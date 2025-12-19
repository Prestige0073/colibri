<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin.login')->with('error', 'Veuillez vous connecter en tant qu\'administrateur.');
        }

        // Vérifier si l'utilisateur est admin
        if (Auth::guard('web')->user()->role !== 'admin') {
            return redirect()->route('admin.login')->with('error', 'Accès refusé. Vous devez être administrateur.');
        }

        return $next($request);
    }
}
