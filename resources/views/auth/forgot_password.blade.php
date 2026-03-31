@extends('layouts.app')
@section('title','Mot de passe oublié')
@section('styles')
<style>
body{background:linear-gradient(135deg,#1a1a2e,#16213e);min-height:100vh;display:flex;align-items:center}
.card-pro{border-radius:20px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.4)}
.card-left{background:linear-gradient(135deg,#0288d1,#0077b6);padding:3rem;color:#fff;text-align:center;display:flex;flex-direction:column;justify-content:center}
.card-right{background:#fff;padding:3rem}
.form-control{border-radius:10px;border:2px solid #eee;padding:0.8rem 1rem}
.form-control:focus{border-color:#0288d1;box-shadow:none}
.btn-pro{background:#0288d1;color:#fff;border:none;border-radius:10px;padding:0.9rem;font-weight:700;font-size:1rem;width:100%}
.btn-pro:hover{background:#0077b6;color:#fff}
</style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            <div class="card-pro">
                <div class="row no-gutters">
                    <div class="col-md-5 card-left">
                        <div style="font-size:4rem;margin-bottom:1rem">🔐</div>
                        <h3 class="font-weight-bold">Mot de passe oublié ?</h3>
                        <p style="opacity:0.85">Entrez votre email et nous vous enverrons un code de vérification.</p>
                        <hr style="border-color:rgba(255,255,255,0.3)">
                        <p class="small" style="opacity:0.8">Vous vous souvenez ?</p>
                        <a href="{{ route('login') }}" class="btn btn-light btn-sm rounded-pill font-weight-bold">Se connecter</a>
                    </div>
                    <div class="col-md-7 card-right">
                        <h4 class="font-weight-bold mb-1">Réinitialiser le mot de passe</h4>
                        <p class="text-muted small mb-4">Entrez votre email pour recevoir un code de vérification.</p>
                        @if(session('error'))
                            <div class="alert alert-danger py-2">{{ session('error') }}</div>
                        @endif
                        <form method="POST" action="{{ route('password.send.code') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="small font-weight-bold">Adresse email</label>
                                <input type="email" name="email" class="form-control" placeholder="votre@email.com" required autofocus>
                            </div>
                            <button type="submit" class="btn-pro mt-2">
                                <i class="fas fa-paper-plane mr-2"></i>Envoyer le code
                            </button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-muted small"><i class="fas fa-arrow-left mr-1"></i>Retour à la connexion</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection