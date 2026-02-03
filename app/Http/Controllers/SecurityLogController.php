<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\SecurityService;

class SecurityLogController extends Controller
{
    /**
     * Log les tentatives de capture d'écran et autres violations de sécurité
     * Applique les sanctions automatiques (blocage temporaire/permanent)
     */
    public function logAttempt(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:100',
            'user_id' => 'nullable|integer',
            'user_name' => 'nullable|string|max:255',
            'contenu_id' => 'nullable|integer',
            'document_type' => 'nullable|string|max:50',
            'session_id' => 'nullable|string|max:255',
            'timestamp' => 'nullable|string',
            'user_agent' => 'nullable|string|max:500',
            'screen_size' => 'nullable|string|max:50',
            'details' => 'nullable|array',
        ]);

        $userId = $validated['user_id'] ?? Auth::id() ?? 0;
        $type = $validated['type'];

        // Enregistrer en base de données
        try {
            DB::table('security_attempts')->insert([
                'user_id' => $userId ?: null,
                'type' => $type,
                'document_id' => $validated['contenu_id'] ?? null,
                'document_type' => $validated['document_type'] ?? 'catalogue',
                'ip_address' => $request->ip(),
                'user_agent' => $validated['user_agent'] ?? $request->userAgent(),
                'details' => json_encode($validated['details'] ?? []),
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log security attempt to DB', ['error' => $e->getMessage()]);
        }

        // Appliquer les sanctions si c'est une tentative de capture
        $response = ['status' => 'logged'];

        if ($userId && in_array($type, ['screenshot_attempt', 'devtools_opened', 'print_attempt', 'recording_attempt'])) {
            $securityResult = SecurityService::recordAttempt($userId, $type, $validated['details'] ?? []);

            $response['attempt_count'] = $securityResult['attempts'] ?? 0;
            $response['warning'] = $securityResult['warning'] ?? false;

            if ($securityResult['blocked']) {
                $response['blocked'] = true;
                $response['permanent'] = $securityResult['permanent'] ?? false;
                $response['message'] = $securityResult['message'] ?? 'Accès bloqué';

                if (isset($securityResult['expires_in'])) {
                    $response['expires_in'] = $securityResult['expires_in'];
                }
            }
        }

        // Logger dans le fichier de log dédié
        $logLevel = isset($response['blocked']) && $response['blocked'] ? 'critical' : 'warning';
        Log::channel('security')->{$logLevel}("Security Event: {$type}", [
            'user_id' => $userId,
            'user_name' => $validated['user_name'] ?? 'Unknown',
            'document_id' => $validated['contenu_id'] ?? null,
            'ip_address' => $request->ip(),
            'response' => $response,
        ]);

        return response()->json($response);
    }

    /**
     * Vérifier le statut de sécurité d'un utilisateur
     */
    public function checkStatus(Request $request)
    {
        $userId = $request->input('user_id') ?? Auth::id();

        if (!$userId) {
            return response()->json(['error' => 'User ID required'], 400);
        }

        $status = SecurityService::isUserBlocked($userId);
        $stats = SecurityService::getUserStats($userId);

        return response()->json([
            'blocked' => $status['blocked'],
            'permanent' => $status['permanent'] ?? false,
            'message' => $status['message'] ?? null,
            'attempts' => $stats['attempts'],
            'remaining_before_block' => max(0, $stats['max_before_temp_block'] - $stats['attempts']),
        ]);
    }

    /**
     * Récupérer les statistiques de sécurité (admin uniquement)
     */
    public function getStats(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $period = $request->input('period', '24h');
        $since = match($period) {
            '1h' => now()->subHour(),
            '24h' => now()->subDay(),
            '7d' => now()->subWeek(),
            '30d' => now()->subMonth(),
            default => now()->subDay(),
        };

        $stats = [
            'total_attempts' => DB::table('security_attempts')
                ->where('created_at', '>=', $since)
                ->count(),

            'by_type' => DB::table('security_attempts')
                ->where('created_at', '>=', $since)
                ->select('type', DB::raw('count(*) as count'))
                ->groupBy('type')
                ->orderByDesc('count')
                ->get(),

            'blocked_users' => DB::table('security_blocks')
                ->where('blocked_at', '>=', $since)
                ->count(),

            'top_offenders' => DB::table('security_attempts')
                ->where('created_at', '>=', $since)
                ->whereNotNull('user_id')
                ->select('user_id', DB::raw('count(*) as attempts'))
                ->groupBy('user_id')
                ->orderByDesc('attempts')
                ->limit(10)
                ->get(),
        ];

        return response()->json($stats);
    }

    /**
     * Débloquer un utilisateur (admin uniquement)
     */
    public function unblockUser(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $userId = $request->input('user_id');
        if (!$userId) {
            return response()->json(['error' => 'User ID required'], 400);
        }

        // Débloquer en BD
        $user = \App\Models\User::find($userId);
        if ($user) {
            $user->blocked = false;
            $user->save();

            // Enregistrer le déblocage
            DB::table('security_blocks')
                ->where('user_id', $userId)
                ->whereNull('unblocked_at')
                ->update([
                    'unblocked_at' => now(),
                    'unblocked_by' => Auth::id(),
                ]);
        }

        // Réinitialiser le cache
        SecurityService::resetUserAttempts($userId);

        Log::channel('security')->info("User unblocked by admin", [
            'user_id' => $userId,
            'admin_id' => Auth::id(),
        ]);

        return response()->json(['success' => true, 'message' => 'Utilisateur débloqué']);
    }
}
