<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $module
     * @param  string  $action
     */
    public function handle(Request $request, Closure $next, string $module, string $action = 'view'): Response
    {
        $admin = auth('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        if (!$admin->isActive()) {
            auth('admin')->logout();
            return redirect()->route('admin.login')->with('error', 'Votre compte a été désactivé. Contactez un administrateur.');
        }

        if (!$admin->hasPermission($module, $action)) {
            abort(403, 'Vous n\'avez pas la permission d\'effectuer cette action.');
        }

        return $next($request);
    }
}
