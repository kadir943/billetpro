<?php

namespace App\Http\Middleware;

use Closure;

class EmployeMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!session('employe_id')) {
            return redirect()->route('login')->with('error', 'Accès réservé aux employés.');
        }
        return $next($request);
    }
}