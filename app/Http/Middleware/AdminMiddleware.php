<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login')->with('error', 'Accès réservé aux administrateurs.');
        }
        return $next($request);
    }
}
