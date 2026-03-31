<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Client;
use App\Evenement;
use App\Billet;
use App\Paiement;
use App\Avis;
use App\Favori;
use App\Categorie;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function dashboard()
    {
        $clientId = session('client_id');
        $totalBillets       = Billet::where('client_id', $clientId)->count();
        $prochainEvenements = Evenement::where('date_evenement', '>=', date('Y-m-d H:i:s'))
                                ->where('statut', 'actif')->count();
        $totalDepenses      = Paiement::whereHas('billet', function($q) use ($clientId) {
                                $q->where('client_id', $clientId);
                            })->where('statut_paiement', 'reussi')->sum('montant');
        $mesBillets         = Billet::where('client_id', $clientId)
                                ->with(['evenement'])->latest()->take(3)->get();
        $evenementsRecents  = Evenement::where('statut', 'actif')
                                ->where('date_evenement', '>=', date('Y-m-d H:i:s'))
                                ->with('categorie')->latest()->take(6)->get();

        return view('client.dashboard', compact(
            'totalBillets', 'prochainEvenements', 'totalDepenses',
            'mesBillets', 'evenementsRecents'
        ));
    }

    public function evenements(Request $request)
    {
        $categories = Categorie::all();
        $query = Evenement::where('statut', 'actif')
                    ->where('date_evenement', '>=', date('Y-m-d H:i:s'))
                    ->with(['categorie', 'organisateur']);

        if ($request->categorie != '') {
    $query->where('categorie_id', $request->categorie);
}

if ($request->search != '') {
    $search = $request->search;
    $query->where(function($q) use ($search) {
        $q->where('titre', 'like', '%' . $search . '%')
          ->orWhere('lieu', 'like', '%' . $search . '%')
          ->orWhere('description', 'like', '%' . $search . '%');
    });
}

if ($request->prix_max != '') {
    $query->where('prix', '<=', $request->prix_max);
}


        $evenements = $query->latest()->paginate(9);
        return view('client.evenements.index', compact('evenements', 'categories'));
    }

    public function showEvenement($id)
    {
        $evenement  = Evenement::with(['organisateur', 'categorie', 'avis.client'])->findOrFail($id);
        $clientId   = session('client_id');
        $dejaAchete = Billet::where('client_id', $clientId)->where('evenement_id', $id)
                        ->where('statut', '!=', 'annule')->exists();
        $enFavori   = Favori::where('client_id', $clientId)->where('evenement_id', $id)->exists();
        $noteMoyenne = $evenement->noteMoyenne();
        $aDejaAvis  = Avis::where('client_id', $clientId)->where('evenement_id', $id)->exists();

        return view('client.evenements.show', compact(
            'evenement', 'dejaAchete', 'enFavori', 'noteMoyenne', 'aDejaAvis'
        ));
    }

    public function showAchat($evenementId)
    {
        $evenement = Evenement::where('statut', 'actif')->findOrFail($evenementId);
        if ($evenement->places_disponibles <= 0) {
            return redirect()->route('client.evenement.show', $evenementId)
                ->with('error', 'Désolé, il n\'y a plus de places disponibles.');
        }
        return view('client.billets.achat', compact('evenement'));
    }

   public function acheterBillet(Request $request, $evenementId)
{
    $validator = Validator::make($request->all(), [
        'quantite'         => 'required|integer|min:1|max:10',
        'methode_paiement' => 'required|in:waafi,dmoney,cacpay,sabapay,eximpay,dahabplus,carte,especes',
        'code_transaction' => 'nullable|string|max:100',
        'recu_paiement'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    $evenement = Evenement::where('statut', 'actif')->findOrFail($evenementId);
    $clientId  = session('client_id');
    $quantite  = $request->quantite;

    if ($evenement->places_disponibles < $quantite) {
        return back()->with('error', 'Seulement ' . $evenement->places_disponibles . ' places disponibles.');
    }

    $numeroBillet = strtoupper('BIL-' . date('Ymd') . '-' . Str::random(8));

    // Billet en attente jusqu'à confirmation du paiement
    $billet = Billet::create([
        'client_id'     => $clientId,
        'evenement_id'  => $evenementId,
        'numero_billet' => $numeroBillet,
        'code_qr'       => $numeroBillet,
        'statut'        => 'en_attente',
        'quantite'      => $quantite,
        'prix_unitaire' => $evenement->prix,
    ]);

    // Upload reçu de paiement
    $recuPath = null;
    if ($request->hasFile('recu_paiement')) {
        $file     = $request->file('recu_paiement');
        $name     = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/recus'), $name);
        $recuPath = $name;
    }

    // Créer le paiement en attente
    Paiement::create([
        'billet_id'        => $billet->id,
        'montant'          => $evenement->prix * $quantite,
        'methode_paiement' => $request->methode_paiement,
        'statut_paiement'  => 'en_attente',
        'date_paiement'    => date('Y-m-d H:i:s'),
        'reference'        => 'REF-' . strtoupper(Str::random(10)),
        'code_transaction' => $request->code_transaction,
        'recu_paiement'    => $recuPath,
    ]);

    // Réserver les places
    $evenement->decrement('places_disponibles', $quantite);

    // Notification au client
    Notification::create([
        'client_id'  => $clientId,
        'message'    => 'Votre demande de billet pour "' . $evenement->titre . '" est en attente de vérification du paiement.',
        'date_envoi' => date('Y-m-d H:i:s'),
        'statut'     => 'non_lu',
    ]);

    // Email à l'employé vérificateur
    try {
        \Mail::to('verificateur@billetpro.com')->send(
            new \App\Mail\NouvelleInscriptionAdmin(
                session('client_nom'),
                'Nouveau paiement à vérifier - ' . $evenement->titre,
                'paiement'
            )
        );
    } catch (\Exception $e) {
        \Log::error('Erreur email verificateur: ' . $e->getMessage());
    }

    return redirect()->route('client.billet.confirmation', $billet->id)
        ->with('success', 'Votre demande a été soumise ! Votre billet sera activé après vérification du paiement.');
}

    public function confirmationBillet($billetId)
    {
        $clientId = session('client_id');
        $billet   = Billet::where('client_id', $clientId)
                        ->with(['evenement', 'paiement', 'client'])->findOrFail($billetId);
        return view('client.billets.confirmation', compact('billet'));
    }

    public function mesBillets()
    {
        $clientId = session('client_id');
        $billets  = Billet::where('client_id', $clientId)
                        ->with(['evenement', 'paiement'])->latest()->paginate(10);
        return view('client.billets.index', compact('billets'));
    }

    public function voirBillet($id)
    {
        $clientId = session('client_id');
        $billet   = Billet::where('client_id', $clientId)
                        ->with(['evenement.organisateur', 'paiement', 'client'])->findOrFail($id);
        return view('client.billets.show', compact('billet'));
    }

    public function soumettreAvis(Request $request, $evenementId)
    {
        $clientId = session('client_id');
        $achete = Billet::where('client_id', $clientId)->where('evenement_id', $evenementId)->exists();
        if (!$achete) {
            return back()->with('error', 'Vous devez avoir acheté un billet pour laisser un avis.');
        }
        $existant = Avis::where('client_id', $clientId)->where('evenement_id', $evenementId)->first();
        if ($existant) {
            $existant->update(['note' => $request->note, 'commentaire' => $request->commentaire]);
        } else {
            Avis::create([
                'client_id'    => $clientId,
                'evenement_id' => $evenementId,
                'note'         => $request->note,
                'commentaire'  => $request->commentaire,
            ]);
        }
        return back()->with('success', 'Votre avis a été enregistré. Merci !');
    }

    public function toggleFavori($evenementId)
    {
        $clientId = session('client_id');
        $favori   = Favori::where('client_id', $clientId)->where('evenement_id', $evenementId)->first();
        if ($favori) {
            $favori->delete();
            $msg = 'Événement retiré des favoris.';
        } else {
            Favori::create(['client_id' => $clientId, 'evenement_id' => $evenementId]);
            $msg = 'Événement ajouté aux favoris !';
        }
        return back()->with('success', $msg);
    }

    public function mesFavoris()
    {
        $clientId = session('client_id');
        $favoris  = Favori::where('client_id', $clientId)->with('evenement.categorie')->get();
        return view('client.favoris', compact('favoris'));
    }

    public function profil()
    {
        $client = Client::findOrFail(session('client_id'));
        return view('client.profil', compact('client'));
    }

    public function updateProfil(Request $request)
    {
        $client = Client::findOrFail(session('client_id'));
        $data   = $request->only('nom', 'email', 'telephone');
      if ($request->mot_de_passe != '') {
    $data['mot_de_passe'] = Hash::make($request->mot_de_passe);
}

        $client->update($data);
        session(['client_nom' => $client->nom]);
        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    public function notifications()
    {
        $clientId      = session('client_id');
        $notifications = Notification::where('client_id', $clientId)->latest()->paginate(15);
        Notification::where('client_id', $clientId)->where('statut', 'non_lu')->update(['statut' => 'lu']);
        return view('client.notifications', compact('notifications'));
    }
}