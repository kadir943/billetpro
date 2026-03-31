<?php

namespace App\Http\Controllers\Organisateur;

use App\Http\Controllers\Controller;
use App\Organisateur;
use App\Evenement;
use App\Billet;
use App\Categorie;
use App\Paiement;
use App\VerificationBillet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OrganisateurController extends Controller
{
    public function dashboard()
    {
        $orgId = session('organisateur_id');
        $totalEvenements = Evenement::where('organisateur_id', $orgId)->count();
        $totalBillets    = Billet::whereHas('evenement', function($q) use ($orgId) {
                                $q->where('organisateur_id', $orgId);
                            })->count();
        $totalRevenu     = Paiement::whereHas('billet', function($q) use ($orgId) {
                                $q->whereHas('evenement', function($q2) use ($orgId) {
                                    $q2->where('organisateur_id', $orgId);
                                });
                            })->where('statut_paiement', 'reussi')->sum('montant');

        $recentsEvenements = Evenement::where('organisateur_id', $orgId)->latest()->take(5)->get();
        $recentsBillets    = Billet::whereHas('evenement', function($q) use ($orgId) {
                                $q->where('organisateur_id', $orgId);
                            })->with(['client', 'evenement'])->latest()->take(5)->get();

        return view('organisateur.dashboard', compact(
            'totalEvenements', 'totalBillets', 'totalRevenu',
            'recentsEvenements', 'recentsBillets'
        ));
    }

    public function evenements()
    {
        $orgId      = session('organisateur_id');
        $evenements = Evenement::where('organisateur_id', $orgId)
                        ->with('categorie')->withCount('billets')->latest()->paginate(10);
        return view('organisateur.evenements.index', compact('evenements'));
    }

    public function createEvenement()
    {
        $categories = Categorie::all();
        return view('organisateur.evenements.create', compact('categories'));
    }

    public function storeEvenement(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titre'          => 'required|string|max:200',
            'description'    => 'nullable|string',
            'date_evenement' => 'required|date',
            'lieu'           => 'required|string|max:200',
            'prix'           => 'required|numeric|min:0',
            'capacite'       => 'required|integer|min:1',
            'categorie_id'   => 'nullable|exists:categories,id',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

    $data = $request->only('titre', 'description', 'lieu', 'prix', 'capacite', 'categorie_id');
$data['date_evenement'] = date('Y-m-d H:i:s', strtotime($request->date_evenement));
        $data['organisateur_id']    = session('organisateur_id');
        $data['places_disponibles'] = $request->capacite;
        $data['statut']             = 'actif';

        if ($request->hasFile('image')) {
            $img  = $request->file('image');
            $name = time() . '_' . $img->getClientOriginalName();
            $img->move(public_path('uploads/events'), $name);
            $data['image'] = $name;
        }

        Evenement::create($data);
        return redirect()->route('organisateur.evenements')->with('success', 'Événement créé avec succès !');
    }

    public function editEvenement($id)
    {
        $orgId      = session('organisateur_id');
        $evenement  = Evenement::where('organisateur_id', $orgId)->findOrFail($id);
        $categories = Categorie::all();
        return view('organisateur.evenements.edit', compact('evenement', 'categories'));
    }

    public function updateEvenement(Request $request, $id)
    {
        $orgId     = session('organisateur_id');
        $evenement = Evenement::where('organisateur_id', $orgId)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'titre'          => 'required|string|max:200',
            'description'    => 'nullable|string',
            'date_evenement' => 'required|date',
            'lieu'           => 'required|string|max:200',
            'prix'           => 'required|numeric|min:0',
            'capacite'       => 'required|integer|min:1',
            'categorie_id'   => 'nullable|exists:categories,id',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only('titre', 'description', 'lieu', 'prix', 'capacite', 'categorie_id', 'statut');
$data['date_evenement'] = date('Y-m-d H:i:s', strtotime($request->date_evenement));
        if ($request->hasFile('image')) {
            if ($evenement->image && file_exists(public_path('uploads/events/' . $evenement->image))) {
                unlink(public_path('uploads/events/' . $evenement->image));
            }
            $img  = $request->file('image');
            $name = time() . '_' . $img->getClientOriginalName();
            $img->move(public_path('uploads/events'), $name);
            $data['image'] = $name;
        }

        $evenement->update($data);
        return redirect()->route('organisateur.evenements')->with('success', 'Événement mis à jour avec succès !');
    }

    public function deleteEvenement($id)
    {
        $orgId     = session('organisateur_id');
        $evenement = Evenement::where('organisateur_id', $orgId)->findOrFail($id);
        if ($evenement->image && file_exists(public_path('uploads/events/' . $evenement->image))) {
            unlink(public_path('uploads/events/' . $evenement->image));
        }
        $evenement->delete();
        return back()->with('success', 'Événement supprimé avec succès.');
    }

    public function billets()
    {
        $orgId   = session('organisateur_id');
        $billets = Billet::whereHas('evenement', function($q) use ($orgId) {
                        $q->where('organisateur_id', $orgId);
                    })->with(['client', 'evenement', 'paiement'])->latest()->paginate(15);
        return view('organisateur.billets.index', compact('billets'));
    }

    public function showVerification()
    {
        return view('organisateur.verification');
    }

    public function verifierBillet(Request $request)
    {
        $orgId  = session('organisateur_id');
        $billet = Billet::where('numero_billet', $request->code_qr)
                    ->with(['client', 'evenement'])->first();

        if (!$billet) {
            return back()->with('error', 'Billet introuvable.');
        }
        if ($billet->evenement->organisateur_id != $orgId) {
            return back()->with('error', 'Ce billet ne correspond pas à vos événements.');
        }
        if ($billet->statut === 'utilise') {
            return back()->with('warning', 'Ce billet a déjà été utilisé.');
        }
        if ($billet->statut === 'annule') {
            return back()->with('error', 'Ce billet est annulé.');
        }

        $billet->update(['statut' => 'utilise']);
        VerificationBillet::create([
            'billet_id'         => $billet->id,
            'verifie_par'       => $orgId,
            'date_verification' => date('Y-m-d H:i:s'),
            'statut'            => 'valide',
        ]);

        return back()->with('success', 'Billet valide ! Accès autorisé pour ' . $billet->client->nom);
    }

    public function paiements()
    {
        $orgId     = session('organisateur_id');
        $paiements = Paiement::whereHas('billet', function($q) use ($orgId) {
                        $q->whereHas('evenement', function($q2) use ($orgId) {
                            $q2->where('organisateur_id', $orgId);
                        });
                    })->with(['billet.client', 'billet.evenement'])->latest()->paginate(15);

        $totalRevenu = Paiement::whereHas('billet', function($q) use ($orgId) {
                        $q->whereHas('evenement', function($q2) use ($orgId) {
                            $q2->where('organisateur_id', $orgId);
                        });
                    })->where('statut_paiement', 'reussi')->sum('montant');

        return view('organisateur.paiements.index', compact('paiements', 'totalRevenu'));
    }

    public function profil()
    {
        $organisateur = Organisateur::findOrFail(session('organisateur_id'));
        return view('organisateur.profil', compact('organisateur'));
    }

    public function updateProfil(Request $request)
    {
        $organisateur = Organisateur::findOrFail(session('organisateur_id'));
        $data = $request->only('nom', 'email', 'telephone');
if ($request->mot_de_passe != '') {
    $data['mot_de_passe'] = Hash::make($request->mot_de_passe);
}
if ($request->hasFile('photo')) {
    $img  = $request->file('photo');
    $name = time() . '_' . $img->getClientOriginalName();
    $img->move(public_path('uploads/profils'), $name);
    $data['photo'] = $name;
}

        $organisateur->update($data);
        session(['organisateur_nom' => $organisateur->nom]);
session(['organisateur_photo' => $organisateur->photo]);
return back()->with('success', 'Profil mis à jour avec succès.');
    }
}