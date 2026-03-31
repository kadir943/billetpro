<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Administrateur;
use App\Organisateur;
use App\Client;
use App\Evenement;
use App\Billet;
use App\Paiement;
use App\Categorie;
use App\Statistique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $totalClients      = Client::count();
        $totalOrganisateurs = Organisateur::count();
        $totalEvenements   = Evenement::count();
        $totalBillets      = Billet::count();
        $totalRevenu       = Paiement::where('statut_paiement', 'reussi')->sum('montant');
        $recentsBillets        = Billet::with(['client', 'evenement'])->latest()->take(5)->get();
$recentsEvenements     = Evenement::with('organisateur')->latest()->take(5)->get();
$clientsEnAttente      = \App\Client::where('statut', 'en_attente')->count();
$organisateursEnAttente = \App\Organisateur::where('statut', 'en_attente')->count();
$totalEnAttente        = $clientsEnAttente + $organisateursEnAttente;
      $billetsParMois = \App\Billet::selectRaw('MONTH(created_at) as mois, COUNT(*) as total')
                    ->whereYear('created_at', date('Y'))
                    ->groupBy('mois')->orderBy('mois')->get();

return view('admin.dashboard', compact(
    'totalClients', 'totalOrganisateurs', 'totalEvenements',
    'totalBillets', 'totalRevenu', 'recentsBillets', 'recentsEvenements',
    'billetsParMois', 'clientsEnAttente', 'organisateursEnAttente', 'totalEnAttente'
));

    }

    // ===== GESTION CLIENTS =====
    public function clients()
    {
        $clients = Client::withCount('billets')->latest()->paginate(15);
        return view('admin.clients.index', compact('clients'));
    }

    public function deleteClient($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return back()->with('success', 'Client supprimé avec succès.');
    }

    // ===== GESTION ORGANISATEURS =====
    public function organisateurs()
    {
        $organisateurs = Organisateur::withCount('evenements')->latest()->paginate(15);
        return view('admin.organisateurs.index', compact('organisateurs'));
    }

    public function deleteOrganisateur($id)
    {
        $org = Organisateur::findOrFail($id);
        $org->delete();
        return back()->with('success', 'Organisateur supprimé avec succès.');
    }

    // ===== GESTION EVENEMENTS =====
    public function evenements()
    {
        $evenements = Evenement::with(['organisateur', 'categorie'])->latest()->paginate(15);
        return view('admin.evenements.index', compact('evenements'));
    }

    public function deleteEvenement($id)
    {
        $evt = Evenement::findOrFail($id);
        if ($evt->image && file_exists(public_path('uploads/events/' . $evt->image))) {
            unlink(public_path('uploads/events/' . $evt->image));
        }
        $evt->delete();
        return back()->with('success', 'Événement supprimé avec succès.');
    }

    // ===== GESTION CATEGORIES =====
    public function categories()
    {
        $categories = Categorie::withCount('evenements')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategorie(Request $request)
    {
        $request->validate(['nom' => 'required|string|max:100', 'description' => 'nullable|string']);
        Categorie::create($request->only('nom', 'description'));
        return back()->with('success', 'Catégorie ajoutée avec succès.');
    }

    public function deleteCategorie($id)
    {
        Categorie::findOrFail($id)->delete();
        return back()->with('success', 'Catégorie supprimée.');
    }

    // ===== GESTION BILLETS =====
    public function billets()
    {
        $billets = Billet::with(['client', 'evenement', 'paiement'])->latest()->paginate(15);
        return view('admin.billets.index', compact('billets'));
    }

    // ===== PAIEMENTS =====
    public function paiements()
    {
        $paiements = Paiement::with(['billet.client', 'billet.evenement'])->latest()->paginate(15);
        $totalRevenu = Paiement::where('statut_paiement', 'reussi')->sum('montant');
        return view('admin.paiements.index', compact('paiements', 'totalRevenu'));
    }

    // ===== STATISTIQUES =====
    public function statistiques()
    {
        $totalRevenu        = Paiement::where('statut_paiement', 'reussi')->sum('montant');
        $totalBillets       = Billet::count();
        $totalEvenements    = Evenement::count();
        $totalClients       = Client::count();
        $topEvenements      = Evenement::withCount('billets')->orderBy('billets_count', 'desc')->take(5)->get();
        $billetsParMois     = Billet::selectRaw('MONTH(created_at) as mois, COUNT(*) as total')
                                ->whereYear('created_at', date('Y'))
                                ->groupBy('mois')->orderBy('mois')->get();

        return view('admin.statistiques', compact(
            'totalRevenu', 'totalBillets', 'totalEvenements',
            'totalClients', 'topEvenements', 'billetsParMois'
        ));
    }

    // ===== PROFIL ADMIN =====
    public function profil()
    {
        $admin = Administrateur::findOrFail(session('admin_id'));
        return view('admin.profil', compact('admin'));
    }

    public function updateProfil(Request $request)
    {
        $admin = Administrateur::findOrFail(session('admin_id'));
        $request->validate([
            'nom'   => 'required|string|max:100',
            'email' => 'required|email|unique:administrateurs,email,' . $admin->id,
        ]);
        $data = $request->only('nom', 'email');
        if ($request->filled('mot_de_passe')) {
            $request->validate(['mot_de_passe' => 'min:6|confirmed']);
            $data['mot_de_passe'] = Hash::make($request->mot_de_passe);
        }
        $admin->update($data);
        session(['admin_nom' => $admin->nom]);
        return back()->with('success', 'Profil mis à jour avec succès.');
    }
    public function approuverClient($id)
{
    $client = \App\Client::findOrFail($id);
    $client->update(['statut' => 'approuve']);
    try {
        \Mail::to($client->email)->send(new \App\Mail\CompteApprouve($client->nom, 'client'));
    } catch (\Exception $e) {
        \Log::error('Erreur email approbation: ' . $e->getMessage());
    }
    return back()->with('success', 'Client ' . $client->nom . ' approuvé avec succès !');
}

public function approuverOrganisateur($id)
{
    $organisateur = \App\Organisateur::findOrFail($id);
    $organisateur->update(['statut' => 'approuve']);
    try {
        \Mail::to($organisateur->email)->send(new \App\Mail\CompteApprouve($organisateur->nom, 'organisateur'));
    } catch (\Exception $e) {
        \Log::error('Erreur email approbation: ' . $e->getMessage());
    }
    return back()->with('success', 'Organisateur ' . $organisateur->nom . ' approuvé avec succès !');
}
}
