<?php

namespace App\Middleware;

use Support\Vault\Foundation\Auth;

class GuestMiddleware
{
    public function handle(array $params, \Closure $next)
    {
        if (auth()->check()) {
            redirect('/'); 
            exit;
        }

        return $next($params);
    }
}