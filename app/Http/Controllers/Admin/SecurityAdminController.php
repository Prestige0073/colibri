<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Services\SecurityService;

class SecurityAdminController extends Controller
{
    /**
     * Afficher le tableau de bord de sécurité
     */
    public function index()
    {
        // Statistiques générales
        $stats = [
            'total_attempts_24h' => DB::table('security_attempts')
                ->where('created_at', '>=', now()->subDay())
                ->count(),

            'total_attempts_7d' => DB::table('security_attempts')
                ->where('created_at', '>=', now()->subWeek())
                ->count(),

            'blocked_users' => User::where('blocked', true)->count(),

            'temp_blocked_today' => DB::table('security_blocks')
                ->where('blocked_at', '>=', now()->subDay())
                ->count(),
        ];

        // Types d'événements les plus fréquents (24h)
        $eventTypes = DB::table('security_attempts')
            ->where('created_at', '>=', now()->subDay())
            ->select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // Utilisateurs les plus suspects (24h)
        $topOffenders = DB::table('security_attempts')
            ->where('created_at', '>=', now()->subDay())
            ->whereNotNull('user_id')
            ->select('user_id', DB::raw('count(*) as attempts'))
            ->groupBy('user_id')
            ->orderByDesc('attempts')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $user = User::find($item->user_id);
                return [
                    'user_id' => $item->user_id,
                    'user_name' => $user ? $user->name : 'Inconnu',
                    'user_email' => $user ? $user->email : '-',
                    'attempts' => $item->attempts,
                    'blocked' => $user ? $user->blocked : false,
                ];
            });

        // Dernières tentatives
        $recentAttempts = DB::table('security_attempts')
            ->orderByDesc('created_at')
            ->limit(20)
            ->get()
            ->map(function ($item) {
                $user = $item->user_id ? User::find($item->user_id) : null;
                return [
                    'id' => $item->id,
                    'type' => $item->type,
                    'user_id' => $item->user_id,
                    'user_name' => $user ? $user->name : 'Anonyme',
                    'document_id' => $item->document_id,
                    'ip_address' => $item->ip_address,
                    'created_at' => $item->created_at,
                ];
            });

        // Utilisateurs bloqués
        $blockedUsers = User::where('blocked', true)
            ->select('id', 'name', 'email', 'updated_at')
            ->get()
            ->map(function ($user) {
                $blockInfo = DB::table('security_blocks')
                    ->where('user_id', $user->id)
                    ->orderByDesc('blocked_at')
                    ->first();

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'blocked_at' => $blockInfo ? $blockInfo->blocked_at : $user->updated_at,
                    'reason' => $blockInfo ? $blockInfo->reason : 'Non spécifié',
                ];
            });

        return view('admin.security.index', compact(
            'stats',
            'eventTypes',
            'topOffenders',
            'recentAttempts',
            'blockedUsers'
        ));
    }

    /**
     * Débloquer un utilisateur
     */
    public function unblockUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        // Débloquer en BD
        $user->blocked = false;
        $user->save();

        // Enregistrer le déblocage
        DB::table('security_blocks')
            ->where('user_id', $userId)
            ->whereNull('unblocked_at')
            ->update([
                'unblocked_at' => now(),
                'unblocked_by' => auth()->id(),
            ]);

        // Réinitialiser le cache
        SecurityService::resetUserAttempts($userId);

        Log::channel('security')->info("User unblocked by admin", [
            'user_id' => $userId,
            'user_email' => $user->email,
            'admin_id' => auth()->id(),
            'admin_name' => auth()->user()->name,
        ]);

        return redirect()->route('admin.security.index')
            ->with('success', "L'utilisateur {$user->name} a été débloqué.");
    }

    /**
     * Bloquer manuellement un utilisateur
     */
    public function blockUser(Request $request, $userId)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($userId);

        // Bloquer en BD
        $user->blocked = true;
        $user->save();

        // Enregistrer le blocage
        DB::table('security_blocks')->insert([
            'user_id' => $userId,
            'reason' => $request->reason,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'blocked_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::channel('security')->critical("User manually blocked by admin", [
            'user_id' => $userId,
            'user_email' => $user->email,
            'reason' => $request->reason,
            'admin_id' => auth()->id(),
            'admin_name' => auth()->user()->name,
        ]);

        return redirect()->route('admin.security.index')
            ->with('success', "L'utilisateur {$user->name} a été bloqué.");
    }

    /**
     * Réinitialiser les tentatives d'un utilisateur sans le débloquer
     */
    public function resetAttempts(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        SecurityService::resetUserAttempts($userId);

        Log::channel('security')->info("User attempts reset by admin", [
            'user_id' => $userId,
            'user_email' => $user->email,
            'admin_id' => auth()->id(),
        ]);

        return redirect()->route('admin.security.index')
            ->with('success', "Les tentatives de {$user->name} ont été réinitialisées.");
    }

    /**
     * Voir les détails de sécurité d'un utilisateur
     */
    public function userDetails($userId)
    {
        $user = User::findOrFail($userId);

        // Statistiques de sécurité
        $securityStats = SecurityService::getUserStats($userId);
        $securityStatus = SecurityService::isUserBlocked($userId);

        // Historique des tentatives
        $attempts = DB::table('security_attempts')
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->limit(100)
            ->get();

        // Historique des blocages
        $blocks = DB::table('security_blocks')
            ->where('user_id', $userId)
            ->orderByDesc('blocked_at')
            ->get()
            ->map(function ($block) {
                $unblockedBy = $block->unblocked_by ? User::find($block->unblocked_by) : null;
                return [
                    'reason' => $block->reason,
                    'ip_address' => $block->ip_address,
                    'blocked_at' => $block->blocked_at,
                    'unblocked_at' => $block->unblocked_at,
                    'unblocked_by' => $unblockedBy ? $unblockedBy->name : null,
                ];
            });

        return view('admin.security.user-details', compact(
            'user',
            'securityStats',
            'securityStatus',
            'attempts',
            'blocks'
        ));
    }
}
