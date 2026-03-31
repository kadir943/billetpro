<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    // Afficher formulaire email
    public function showForgotForm()
    {
        return view('auth.forgot_password');
    }

    // Envoyer le code
    public function sendCode(Request $request)
    {
        $email = $request->email;

        // Chercher dans les 3 tables
        $user = \App\Client::where('email', $email)->first();
        $role = 'client';

        if (!$user) {
            $user = \App\Organisateur::where('email', $email)->first();
            $role = 'organisateur';
        }

        if (!$user) {
            $user = \App\Administrateur::where('email', $email)->first();
            $role = 'admin';
        }

        if (!$user) {
            return back()->with('error', 'Aucun compte trouvé avec cet email.');
        }

        // Générer code à 6 chiffres
        $code = strval(rand(100000, 999999));

        // Supprimer anciens codes
        DB::table('reset_codes')->where('email', $email)->delete();

        // Sauvegarder le code
        DB::table('reset_codes')->insert([
            'email'      => $email,
            'code'       => $code,
            'role'       => $role,
            'expires_at' => Carbon::now()->addMinutes(15),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Envoyer l'email
        try {
            \Mail::to($email)->send(new \App\Mail\ResetPasswordCode($user->nom, $code));
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'envoi de l\'email. Réessayez.');
        }

        return redirect()->route('password.verify.form', ['email' => $email])
                         ->with('success', 'Code envoyé ! Vérifiez votre email.');
    }

    // Afficher formulaire de vérification du code
    public function showVerifyForm(Request $request)
    {
        return view('auth.verify_code', ['email' => $request->email]);
    }

    // Vérifier le code
    public function verifyCode(Request $request)
    {
        $email = $request->email;
        $code  = $request->code;

        $reset = DB::table('reset_codes')
                    ->where('email', $email)
                    ->where('code', $code)
                    ->first();

        if (!$reset) {
            return back()->with('error', 'Code incorrect. Vérifiez votre email.');
        }

        if (Carbon::now()->gt(Carbon::parse($reset->expires_at))) {
            return back()->with('error', 'Code expiré. Demandez un nouveau code.');
        }

        return redirect()->route('password.reset.form', ['email' => $email, 'code' => $code]);
    }

    // Afficher formulaire nouveau mot de passe
    public function showResetForm(Request $request)
    {
        return view('auth.reset_password', [
            'email' => $request->email,
            'code'  => $request->code,
        ]);
    }

    // Réinitialiser le mot de passe
    public function resetPassword(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email'        => 'required|email',
            'code'         => 'required',
            'mot_de_passe' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $reset = DB::table('reset_codes')
                    ->where('email', $request->email)
                    ->where('code', $request->code)
                    ->first();

        if (!$reset) {
            return back()->with('error', 'Code invalide.');
        }

        if (Carbon::now()->gt(Carbon::parse($reset->expires_at))) {
            return back()->with('error', 'Code expiré.');
        }

        $newPassword = Hash::make($request->mot_de_passe);

        // Mettre à jour selon le rôle
        if ($reset->role == 'client') {
            \App\Client::where('email', $request->email)->update(['mot_de_passe' => $newPassword]);
        } elseif ($reset->role == 'organisateur') {
            \App\Organisateur::where('email', $request->email)->update(['mot_de_passe' => $newPassword]);
        } else {
            \App\Administrateur::where('email', $request->email)->update(['mot_de_passe' => $newPassword]);
        }

        // Supprimer le code utilisé
        DB::table('reset_codes')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Mot de passe réinitialisé avec succès ! Connectez-vous.');
    }
}