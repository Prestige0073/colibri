<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'admin.permission' => \App\Http\Middleware\CheckRoutePermission::class,
        ]);

        // Appliquer le middleware de permission à toutes les routes admin
        $middleware->appendToGroup('admin', [
            \App\Http\Middleware\CheckRoutePermission::class,
        ]);

        // Exclure les routes de sécurité de la vérification CSRF
        $middleware->validateCsrfTokens(except: [
            'api/security/*',
        ]);
    })
    ->withSchedule(function (Schedule $schedule): void {
        // Mettre à jour les emprunts expirés toutes les heures
        $schedule->command('emprunts:update-expired')->hourly();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Gérer l'erreur 419 (Token CSRF expiré) - rediriger vers login
        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            // Si c'est une requête admin, rediriger vers login admin
            if ($request->is('admin/*') || $request->is('admin')) {
                return redirect()->route('admin.login')
                    ->with('warning', 'Votre session a expiré. Veuillez vous reconnecter.');
            }

            // Sinon, rediriger vers login utilisateur
            return redirect()->route('login')
                ->with('warning', 'Votre session a expiré. Veuillez vous reconnecter.');
        });
    })->create();
