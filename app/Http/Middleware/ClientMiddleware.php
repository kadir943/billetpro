<?php

namespace App\Http\Middleware;

use Closure;
use App\Client;

class ClientMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!session('client_id')) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }

        $client = Client::find(session('client_id'));
        if (!$client || $client->statut == 'en_attente') {
            session()->flush();
            return redirect()->route('login')->with('error', 'Votre compte est en attente d\'approbation par l\'administrateur. Vous recevrez un email dès l\'activation.');
        }

        return $next($request);
    }
}