<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SecurityService
{
    // Seuils de sécurité
    const MAX_ATTEMPTS_WARNING = 5;      // Avertissement
    const MAX_ATTEMPTS_TEMP_BLOCK = 10;  // Blocage temporaire (1h)
    const MAX_ATTEMPTS_PERMANENT = 20;   // Blocage permanent

    // Durées
    const TEMP_BLOCK_DURATION = 3600;    // 1 heure en secondes
    const ATTEMPT_WINDOW = 86400;        // 24 heures en secondes

    /**
     * Enregistrer une tentative de capture d'écran
     */
    public static function recordAttempt(int $userId, string $type, array $details = []): array
    {
        $cacheKey = "security_attempts_{$userId}";
        $blockKey = "security_blocked_{$userId}";

        // Vérifier si déjà bloqué temporairement
        if (Cache::has($blockKey)) {
            $blockExpires = Cache::get($blockKey);
            return [
                'blocked' => true,
                'permanent' => false,
                'message' => 'Accès temporairement bloqué',
                'expires_in' => $blockExpires - time(),
            ];
        }

        // Incrémenter le compteur
        $attempts = Cache::get($cacheKey, 0) + 1;
        Cache::put($cacheKey, $attempts, self::ATTEMPT_WINDOW);

        // Logger l'événement
        Log::channel('security')->warning("Security attempt: {$type}", [
            'user_id' => $userId,
            'attempt_count' => $attempts,
            'type' => $type,
            'details' => $details,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $response = [
            'blocked' => false,
            'permanent' => false,
            'attempts' => $attempts,
            'warning' => false,
        ];

        // Vérifier les seuils
        if ($attempts >= self::MAX_ATTEMPTS_PERMANENT) {
            // Blocage PERMANENT en base de données
            self::blockUserPermanently($userId, 'Trop de tentatives de capture d\'écran');
            $response['blocked'] = true;
            $response['permanent'] = true;
            $response['message'] = 'Compte bloqué définitivement pour violation des conditions d\'utilisation';
        } elseif ($attempts >= self::MAX_ATTEMPTS_TEMP_BLOCK) {
            // Blocage temporaire
            Cache::put($blockKey, time() + self::TEMP_BLOCK_DURATION, self::TEMP_BLOCK_DURATION);
            $response['blocked'] = true;
            $response['message'] = 'Accès bloqué pendant 1 heure';
            $response['expires_in'] = self::TEMP_BLOCK_DURATION;

            Log::channel('security')->critical("User temporarily blocked", [
                'user_id' => $userId,
                'duration' => '1 hour',
                'total_attempts' => $attempts,
            ]);
        } elseif ($attempts >= self::MAX_ATTEMPTS_WARNING) {
            $response['warning'] = true;
            $response['message'] = 'Attention: Activité suspecte détectée';
        }

        return $response;
    }

    /**
     * Bloquer un utilisateur de façon permanente
     */
    public static function blockUserPermanently(int $userId, string $reason): void
    {
        $user = User::find($userId);
        if ($user && !$user->blocked) {
            $user->blocked = true;
            $user->save();

            // Enregistrer dans une table de logs si elle existe
            DB::table('security_blocks')->insert([
                'user_id' => $userId,
                'reason' => $reason,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'blocked_at' => now(),
            ]);

            Log::channel('security')->critical("USER PERMANENTLY BLOCKED", [
                'user_id' => $userId,
                'user_email' => $user->email,
                'reason' => $reason,
                'ip' => request()->ip(),
            ]);
        }
    }

    /**
     * Vérifier si un utilisateur est bloqué
     */
    public static function isUserBlocked(int $userId): array
    {
        // Vérifier blocage permanent en BD
        $user = User::find($userId);
        if ($user && $user->blocked) {
            return [
                'blocked' => true,
                'permanent' => true,
                'message' => 'Votre compte a été bloqué pour violation des conditions d\'utilisation.',
            ];
        }

        // Vérifier blocage temporaire en cache
        $blockKey = "security_blocked_{$userId}";
        if (Cache::has($blockKey)) {
            $blockExpires = Cache::get($blockKey);
            $remaining = $blockExpires - time();
            return [
                'blocked' => true,
                'permanent' => false,
                'message' => 'Accès temporairement bloqué',
                'expires_in' => $remaining,
                'expires_at' => date('H:i:s', $blockExpires),
            ];
        }

        return ['blocked' => false];
    }

    /**
     * Obtenir les statistiques de sécurité d'un utilisateur
     */
    public static function getUserStats(int $userId): array
    {
        $cacheKey = "security_attempts_{$userId}";

        // Statistiques depuis la base de données
        $attempts1h = DB::table('security_attempts')
            ->where('user_id', $userId)
            ->where('created_at', '>=', now()->subHour())
            ->count();

        $attempts24h = DB::table('security_attempts')
            ->where('user_id', $userId)
            ->where('created_at', '>=', now()->subDay())
            ->count();

        $totalAttempts = DB::table('security_attempts')
            ->where('user_id', $userId)
            ->count();

        return [
            'attempts' => Cache::get($cacheKey, 0),
            'attempts_1h' => $attempts1h,
            'attempts_24h' => $attempts24h,
            'total_attempts' => $totalAttempts,
            'max_before_temp_block' => self::MAX_ATTEMPTS_TEMP_BLOCK,
            'max_before_permanent' => self::MAX_ATTEMPTS_PERMANENT,
        ];
    }

    /**
     * Réinitialiser les tentatives d'un utilisateur (admin only)
     */
    public static function resetUserAttempts(int $userId): void
    {
        Cache::forget("security_attempts_{$userId}");
        Cache::forget("security_blocked_{$userId}");

        Log::channel('security')->info("User security attempts reset", [
            'user_id' => $userId,
            'reset_by' => auth()->id(),
        ]);
    }

    /**
     * Générer un identifiant unique pour le watermark forensique
     */
    public static function generateForensicId(int $userId, int $documentId): string
    {
        $data = [
            'u' => $userId,
            'd' => $documentId,
            't' => time(),
            'ip' => request()->ip(),
            's' => session()->getId(),
        ];

        return base64_encode(json_encode($data)) . '.' . hash('sha256', json_encode($data) . env('APP_KEY'));
    }

    /**
     * Décoder un identifiant forensique (pour tracer une fuite)
     */
    public static function decodeForensicId(string $forensicId): ?array
    {
        $parts = explode('.', $forensicId);
        if (count($parts) !== 2) {
            return null;
        }

        $data = json_decode(base64_decode($parts[0]), true);
        $expectedHash = hash('sha256', json_encode($data) . env('APP_KEY'));

        if ($parts[1] !== $expectedHash) {
            return null; // Identifiant falsifié
        }

        return [
            'user_id' => $data['u'],
            'document_id' => $data['d'],
            'timestamp' => date('Y-m-d H:i:s', $data['t']),
            'ip_address' => $data['ip'],
            'session_id' => $data['s'],
        ];
    }
}
