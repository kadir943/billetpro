<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Administrateur;
use App\Organisateur;
use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin()
{
    return view('auth.login');
}

public function login(Request $request)
{
    $email    = $request->email;
    $password = $request->mot_de_passe;

    // Vérifier Admin
    $admin = \App\Administrateur::where('email', $email)->first();
    if ($admin && Hash::check($password, $admin->mot_de_passe)) {
        session(['admin_id' => $admin->id, 'admin_nom' => $admin->nom]);
        return redirect()->route('admin.dashboard');
    }

    // Vérifier Organisateur
    $org = \App\Organisateur::where('email', $email)->first();
    if ($org && Hash::check($password, $org->mot_de_passe)) {
        session(['organisateur_id' => $org->id, 'organisateur_nom' => $org->nom]);
        return redirect()->route('organisateur.dashboard');
    }

    // Vérifier Client
    $client = \App\Client::where('email', $email)->first();
    if ($client && Hash::check($password, $client->mot_de_passe)) {
        session(['client_id' => $client->id, 'client_nom' => $client->nom]);
        return redirect()->route('client.dashboard');
    }

    return back()->with('error', 'Email ou mot de passe incorrect.');
}
    public function showAdminLogin()
    {
        if (session('admin_id')) return redirect()->route('admin.dashboard');
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'        => 'required|email',
            'mot_de_passe' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $admin = Administrateur::where('email', $request->email)->first();
        if ($admin && Hash::check($request->mot_de_passe, $admin->mot_de_passe)) {
            session(['admin_id' => $admin->id, 'admin_nom' => $admin->nom]);
            return redirect()->route('admin.dashboard');
        }
        return back()->with('error', 'Email ou mot de passe incorrect.');
    }

    public function adminLogout()
    {
        session()->forget(['admin_id', 'admin_nom']);
        return redirect()->route('admin.login');
    }

    public function showOrganisateurLogin()
    {
        if (session('organisateur_id')) return redirect()->route('organisateur.dashboard');
        return view('auth.organisateur-login');
    }

    public function showOrganisateurRegister()
    {
        return view('auth.organisateur-register');
    }

    public function organisateurLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'        => 'required|email',
            'mot_de_passe' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $org = Organisateur::where('email', $request->email)->first();
        if ($org && Hash::check($request->mot_de_passe, $org->mot_de_passe)) {
            session(['organisateur_id' => $org->id, 'organisateur_nom' => $org->nom]);
            return redirect()->route('organisateur.dashboard');
        }
        return back()->with('error', 'Email ou mot de passe incorrect.');
    }

public function organisateurRegister(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nom'              => 'required|string|max:100',
        'nom_organisation' => 'required|string|max:200',
        'type_organisation'=> 'required|in:entreprise,association,particulier',
        'email'            => 'required|email|unique:organisateurs,email',
        'telephone'        => 'nullable|string|max:20',
        'telephone_pro'    => 'required|string|max:20',
        'numero_ifu'       => 'nullable|string|max:50',
        'photo_identite'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        'mot_de_passe'     => 'required|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    $photoIdentitePath = null;
    if ($request->hasFile('photo_identite')) {
        $file = $request->file('photo_identite');
        $name = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/identites'), $name);
        $photoIdentitePath = $name;
    }

    $org = Organisateur::create([
        'nom'               => $request->nom,
        'nom_organisation'  => $request->nom_organisation,
        'type_organisation' => $request->type_organisation,
        'email'             => $request->email,
        'telephone'         => $request->telephone,
        'telephone_pro'     => $request->telephone_pro,
        'numero_ifu'        => $request->numero_ifu,
        'photo_identite'    => $photoIdentitePath,
        'mot_de_passe'      => Hash::make($request->mot_de_passe),
        'statut'            => 'en_attente',
    ]);

    try {
        \Mail::to($org->email)->send(new \App\Mail\InscriptionConfirmation($org->nom, 'organisateur'));
        \Mail::to('kadirmohamed801@gmail.com')->send(new \App\Mail\NouvelleInscriptionAdmin($org->nom, $org->email, 'organisateur'));
    } catch (\Exception $e) {
        \Log::error('Erreur envoi email inscription organisateur: ' . $e->getMessage());
    }

    return redirect()->route('login')->with('success', 'Votre dossier a été soumis avec succès ! Vous recevrez un email de confirmation dans les 24h après vérification.');
}



    public function organisateurLogout()
    {
        session()->forget(['organisateur_id', 'organisateur_nom']);
        return redirect()->route('organisateur.login');
    }

    public function showClientLogin()
    {
        if (session('client_id')) return redirect()->route('client.dashboard');
        return view('auth.client-login');
    }

    public function showClientRegister()
    {
        return view('auth.client-register');
    }

    public function clientLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'        => 'required|email',
            'mot_de_passe' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $client = Client::where('email', $request->email)->first();
        if ($client && Hash::check($request->mot_de_passe, $client->mot_de_passe)) {
            session(['client_id' => $client->id, 'client_nom' => $client->nom]);
            return redirect()->route('client.dashboard');
        }
        return back()->with('error', 'Email ou mot de passe incorrect.');
    }

    public function clientRegister(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nom'          => 'required|string|max:100',
        'email'        => 'required|email|unique:clients,email',
        'telephone'    => 'nullable|string|max:20',
        'mot_de_passe' => 'required|min:6|confirmed',
    ]);
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }
    $client = Client::create([
        'nom'          => $request->nom,
        'email'        => $request->email,
        'telephone'    => $request->telephone,
        'mot_de_passe' => Hash::make($request->mot_de_passe),
    ]);

    try {
        \Mail::to($client->email)->send(new \App\Mail\InscriptionConfirmation($client->nom, 'client'));
        \Mail::to('kadirmohamed801@gmail.com')->send(new \App\Mail\NouvelleInscriptionAdmin($client->nom, $client->email, 'client'));
    } catch (\Exception $e) {
        \Log::error('Erreur envoi email inscription client: ' . $e->getMessage());
    }

    session(['client_id' => $client->id, 'client_nom' => $client->nom]);
    return redirect()->route('client.dashboard')->with('success', 'Compte créé avec succès ! Vous recevrez un email de confirmation dans les 24h.');
}

    public function clientLogout()
    {
        session()->forget(['client_id', 'client_nom']);
        return redirect()->route('client.login');
    }
    public function showEmployeLogin()
{
    return view('auth.employe-login');
}

public function employeLogin(Request $request)
{
    $email    = $request->email;
    $password = $request->mot_de_passe;

    $employe = \App\Employe::where('email', $email)
                ->where('statut', 'actif')->first();

    if ($employe && Hash::check($password, $employe->mot_de_passe)) {
        session(['employe_id' => $employe->id, 'employe_nom' => $employe->nom]);
        return redirect()->route('employe.dashboard');
    }

    return back()->with('error', 'Email ou mot de passe incorrect.');
}

public function employeLogout()
{
    session()->forget(['employe_id', 'employe_nom']);
    return redirect()->route('login')->with('success', 'Déconnexion réussie.');
}

}