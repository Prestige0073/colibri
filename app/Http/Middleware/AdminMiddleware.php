<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Vérifier si l'administrateur est connecté avec le guard admin
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'Veuillez vous connecter en tant qu\'administrateur.');
        }

        // Vérifier si le compte admin est actif
        $admin = Auth::guard('admin')->user();
        if ($admin->status !== 'active') {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->with('error', 'Votre compte a été désactivé. Contactez le super administrateur.');
        }

        return $next($request);
    }
}
