<?php

namespace App\Http\Middleware;

use Closure;
use App\Organisateur;

class OrganisateurMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!session('organisateur_id')) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }

        $organisateur = Organisateur::find(session('organisateur_id'));
        if (!$organisateur || $organisateur->statut == 'en_attente') {
            session()->flush();
            return redirect()->route('login')->with('error', 'Votre compte est en attente d\'approbation par l\'administrateur. Vous recevrez un email dès l\'activation.');
        }

        return $next($request);
    }
}
