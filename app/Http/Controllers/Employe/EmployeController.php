<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Paiement;
use App\Employe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EmployeController extends Controller
{
    public function dashboard()
    {
        $totalEnAttente  = Paiement::where('statut_paiement', 'en_attente')->count();
        $totalVerifies   = Paiement::where('statut_paiement', 'reussi')->count();
        $totalRefuses    = Paiement::where('statut_paiement', 'echoue')->count();
        $paiementsRecents = Paiement::where('statut_paiement', 'en_attente')
                            ->with(['billet.client', 'billet.evenement'])
                            ->latest()->take(10)->get();

        return view('employe.dashboard', compact(
            'totalEnAttente', 'totalVerifies', 'totalRefuses', 'paiementsRecents'
        ));
    }

    public function paiements()
    {
        $paiements = Paiement::with(['billet.client', 'billet.evenement'])
                        ->latest()->paginate(15);
        return view('employe.paiements', compact('paiements'));
    }

    public function voirPaiement($id)
    {
        $paiement = Paiement::with(['billet.client', 'billet.evenement'])->findOrFail($id);
        return view('employe.paiement_detail', compact('paiement'));
    }

    public function approuverPaiement($id)
    {
        $paiement = Paiement::with(['billet.client', 'billet.evenement'])->findOrFail($id);
        $employeId = session('employe_id');

        $paiement->update([
            'statut_paiement'  => 'reussi',
            'employe_id'       => $employeId,
            'date_verification'=> Carbon::now(),
        ]);

        // Activer le billet
        if ($paiement->billet) {
            $paiement->billet->update(['statut' => 'valide']);

            // Envoyer email au client
            try {
                \Mail::to($paiement->billet->client->email)->send(
                    new \App\Mail\PaiementConfirme(
                        $paiement->billet->client->nom,
                        $paiement->billet->evenement->titre,
                        $paiement->billet->numero_billet,
                        $paiement->montant
                    )
                );
            } catch (\Exception $e) {
                \Log::error('Erreur email paiement: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Paiement approuvé ! Billet généré et envoyé au client.');
    }

    public function refuserPaiement(Request $request, $id)
    {
        $paiement = Paiement::with(['billet.client'])->findOrFail($id);
        $employeId = session('employe_id');

        $paiement->update([
            'statut_paiement'  => 'echoue',
            'employe_id'       => $employeId,
            'date_verification'=> Carbon::now(),
        ]);

        // Annuler le billet
        if ($paiement->billet) {
            $paiement->billet->update(['statut' => 'annule']);
            // Remettre les places disponibles
            $paiement->billet->evenement->increment('places_disponibles', $paiement->billet->quantite);
        }

        return back()->with('error', 'Paiement refusé.');
    }

    public function profil()
    {
        $employe = Employe::findOrFail(session('employe_id'));
        return view('employe.profil', compact('employe'));
    }

    public function updateProfil(Request $request)
    {
        $employe = Employe::findOrFail(session('employe_id'));
        $data = $request->only('nom', 'email', 'telephone');
        if ($request->mot_de_passe != '') {
            $data['mot_de_passe'] = Hash::make($request->mot_de_passe);
        }
        $employe->update($data);
        session(['employe_nom' => $employe->nom]);
        return back()->with('success', 'Profil mis à jour avec succès.');
    }
}
