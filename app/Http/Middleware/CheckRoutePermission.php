<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Auth;

class CheckRoutePermission
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.login');
        }

        $routeName = $request->route()->getName();

        // Autoriser les routes sans nom ou les routes publiques
        if (!$routeName || $routeName === 'admin.login' || $routeName === 'admin.logout') {
            return $next($request);
        }

        // Vérifier si l'admin peut accéder à cette route
        if (!PermissionService::canAccessRoute($routeName)) {
            // Si c'est une requête AJAX, retourner JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => PermissionService::getAccessDeniedMessage($routeName),
                ], 403);
            }

            // Sinon, rediriger vers le dashboard avec une session flash pour afficher le modal
            return redirect()->route('admin.dashboard')->with([
                'permission_denied' => true,
                'permission_message' => PermissionService::getAccessDeniedMessage($routeName),
                'attempted_route' => $routeName,
            ]);
        }

        return $next($request);
    }
}
