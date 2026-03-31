<?php

// Page d'accueil
Route::get('/', function () {
    $evenements = \App\Evenement::where('statut', 'actif')
                    ->where('date_evenement', '>=', date('Y-m-d H:i:s'))
                    ->with(['categorie', 'organisateur'])
                    ->latest()
                    ->take(5)
                    ->get();
    return view('welcome', compact('evenements'));
})->name('home');

Route::get('login',           'Auth\AuthController@showLogin')->name('login');
Route::post('login',          'Auth\AuthController@login')->name('login.post');
Route::get('password/forgot', 'Auth\ResetPasswordController@showForgotForm')->name('password.forgot');
Route::post('password/send-code', 'Auth\ResetPasswordController@sendCode')->name('password.send.code');
Route::get('password/verify', 'Auth\ResetPasswordController@showVerifyForm')->name('password.verify.form');
Route::post('password/verify','Auth\ResetPasswordController@verifyCode')->name('password.verify.code');
Route::get('password/reset',  'Auth\ResetPasswordController@showResetForm')->name('password.reset.form');
Route::post('password/reset', 'Auth\ResetPasswordController@resetPassword')->name('password.reset.post');

// =====================================================================
// AUTH ADMIN
// =====================================================================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login',  'Auth\AuthController@showAdminLogin')->name('login');
    Route::post('login', 'Auth\AuthController@adminLogin')->name('login.post');
    Route::get('logout', 'Auth\AuthController@adminLogout')->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('dashboard',          'Admin\AdminController@dashboard')->name('dashboard');
        Route::get('clients',            'Admin\AdminController@clients')->name('clients');
        Route::delete('clients/{id}',    'Admin\AdminController@deleteClient')->name('clients.delete');
        Route::post('clients/{id}/approuver', 'Admin\AdminController@approuverClient')->name('clients.approuver');
        Route::get('organisateurs',           'Admin\AdminController@organisateurs')->name('organisateurs');
        Route::delete('organisateurs/{id}',   'Admin\AdminController@deleteOrganisateur')->name('organisateurs.delete');
        Route::post('organisateurs/{id}/approuver', 'Admin\AdminController@approuverOrganisateur')->name('organisateurs.approuver');
        Route::get('evenements',         'Admin\AdminController@evenements')->name('evenements');
        Route::delete('evenements/{id}', 'Admin\AdminController@deleteEvenement')->name('evenements.delete');
        Route::get('categories',         'Admin\AdminController@categories')->name('categories');
        Route::post('categories',        'Admin\AdminController@storeCategorie')->name('categories.store');
        Route::delete('categories/{id}', 'Admin\AdminController@deleteCategorie')->name('categories.delete');
        Route::get('billets',            'Admin\AdminController@billets')->name('billets');
        Route::get('paiements',          'Admin\AdminController@paiements')->name('paiements');
        Route::get('statistiques',       'Admin\AdminController@statistiques')->name('statistiques');
        Route::get('profil',             'Admin\AdminController@profil')->name('profil');
        Route::post('profil',            'Admin\AdminController@updateProfil')->name('profil.update');
    });
});
// =====================================================================
// AUTH EMPLOYE
// =====================================================================
Route::prefix('employe')->name('employe.')->group(function () {
    Route::get('login',  'Auth\AuthController@showEmployeLogin')->name('login');
    Route::post('login', 'Auth\AuthController@employeLogin')->name('login.post');
    Route::get('logout', 'Auth\AuthController@employeLogout')->name('logout');

    Route::middleware('employe')->group(function () {
        Route::get('dashboard',           'Employe\EmployeController@dashboard')->name('dashboard');
        Route::get('paiements',           'Employe\EmployeController@paiements')->name('paiements');
        Route::get('paiements/{id}',      'Employe\EmployeController@voirPaiement')->name('paiement.voir');
        Route::post('paiements/{id}/approuver', 'Employe\EmployeController@approuverPaiement')->name('paiement.approuver');
        Route::post('paiements/{id}/refuser',   'Employe\EmployeController@refuserPaiement')->name('paiement.refuser');
        Route::get('profil',              'Employe\EmployeController@profil')->name('profil');
        Route::post('profil',             'Employe\EmployeController@updateProfil')->name('profil.update');
    });
});

// =====================================================================
// AUTH ORGANISATEUR
// =====================================================================
Route::prefix('organisateur')->name('organisateur.')->group(function () {
    Route::get('login',     'Auth\AuthController@showOrganisateurLogin')->name('login');
    Route::post('login',    'Auth\AuthController@organisateurLogin')->name('login.post');
    Route::get('register',  'Auth\AuthController@showOrganisateurRegister')->name('register');
    Route::post('register', 'Auth\AuthController@organisateurRegister')->name('register.post');
    Route::get('logout',    'Auth\AuthController@organisateurLogout')->name('logout');

    Route::middleware('organisateur')->group(function () {
        Route::get('dashboard',          'Organisateur\OrganisateurController@dashboard')->name('dashboard');
        Route::get('evenements',         'Organisateur\OrganisateurController@evenements')->name('evenements');
        Route::get('evenements/creer',   'Organisateur\OrganisateurController@createEvenement')->name('evenements.create');
        Route::post('evenements',        'Organisateur\OrganisateurController@storeEvenement')->name('evenements.store');
        Route::get('evenements/{id}/edit','Organisateur\OrganisateurController@editEvenement')->name('evenements.edit');
        Route::post('evenements/{id}',   'Organisateur\OrganisateurController@updateEvenement')->name('evenements.update');
        Route::delete('evenements/{id}', 'Organisateur\OrganisateurController@deleteEvenement')->name('evenements.delete');
        Route::post('evenements/{id}/supprimer','Organisateur\OrganisateurController@deleteEvenement')->name('evenements.supprimer');
        Route::get('billets',            'Organisateur\OrganisateurController@billets')->name('billets');
        Route::get('verification',       'Organisateur\OrganisateurController@showVerification')->name('verification');
        Route::post('verification',      'Organisateur\OrganisateurController@verifierBillet')->name('verification.post');
        Route::get('paiements',          'Organisateur\OrganisateurController@paiements')->name('paiements');
        Route::get('profil',             'Organisateur\OrganisateurController@profil')->name('profil');
        Route::post('profil',            'Organisateur\OrganisateurController@updateProfil')->name('profil.update');
    });
});

// =====================================================================
// AUTH CLIENT
// =====================================================================
Route::prefix('client')->name('client.')->group(function () {
    Route::get('login',     'Auth\AuthController@showClientLogin')->name('login');
    Route::post('login',    'Auth\AuthController@clientLogin')->name('login.post');
    Route::get('register',  'Auth\AuthController@showClientRegister')->name('register');
    Route::post('register', 'Auth\AuthController@clientRegister')->name('register.post');
    Route::get('logout',    'Auth\AuthController@clientLogout')->name('logout');

    Route::middleware('client')->group(function () {
        Route::get('dashboard',                'Client\ClientController@dashboard')->name('dashboard');
        Route::get('evenements',               'Client\ClientController@evenements')->name('evenements');
        Route::get('evenements/{id}',          'Client\ClientController@showEvenement')->name('evenement.show');
        Route::get('evenements/{id}/acheter',  'Client\ClientController@showAchat')->name('billet.achat');
        Route::post('evenements/{id}/acheter', 'Client\ClientController@acheterBillet')->name('billet.acheter');
        Route::get('billets',                  'Client\ClientController@mesBillets')->name('billets');
        Route::get('billets/{id}',             'Client\ClientController@voirBillet')->name('billet.show');
        Route::get('billets/{id}/confirmation','Client\ClientController@confirmationBillet')->name('billet.confirmation');
        Route::post('evenements/{id}/avis',    'Client\ClientController@soumettreAvis')->name('avis.store');
        Route::post('favoris/{id}',            'Client\ClientController@toggleFavori')->name('favori.toggle');
        Route::get('favoris',                  'Client\ClientController@mesFavoris')->name('favoris');
        Route::get('notifications',            'Client\ClientController@notifications')->name('notifications');
        Route::get('profil',                   'Client\ClientController@profil')->name('profil');
        Route::post('profil',                  'Client\ClientController@updateProfil')->name('profil.update');
    });
});
