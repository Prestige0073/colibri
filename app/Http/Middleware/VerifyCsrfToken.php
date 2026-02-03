<?php
namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * URIs à exclure de la vérification CSRF.
     * Le endpoint de logging sécurité est exclu car appelé depuis JS sans token.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/security/log-attempt',
    ];
}
