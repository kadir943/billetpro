@extends('layouts.app')
@section('title','Nouveau mot de passe')
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
                        <div style="font-size:4rem;margin-bottom:1rem">🔑</div>
                        <h3 class="font-weight-bold">Nouveau mot de passe</h3>
                        <p style="opacity:0.85">Choisissez un mot de passe fort et sécurisé.</p>
                        <hr style="border-color:rgba(255,255,255,0.3)">
                        <div style="background:rgba(255,255,255,0.15);border-radius:10px;padding:0.8rem;font-size:0.85rem;text-align:left">
                            <p class="mb-1"><i class="fas fa-check mr-2"></i>Minimum 6 caractères</p>
                            <p class="mb-1"><i class="fas fa-check mr-2"></i>Mélangez lettres et chiffres</p>
                            <p class="mb-0"><i class="fas fa-check mr-2"></i>Évitez les mots simples</p>
                        </div>
                    </div>
                    <div class="col-md-7 card-right">
                        <h4 class="font-weight-bold mb-1">Créer un nouveau mot de passe</h4>
                        <p class="text-muted small mb-4">Entrez et confirmez votre nouveau mot de passe.</p>
                        @if(session('error'))
                            <div class="alert alert-danger py-2">{{ session('error') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger py-2">
                                <ul class="mb-0 pl-3">
                                    @foreach($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('password.reset.post') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="email" value="{{ $email }}">
                            <input type="hidden" name="code" value="{{ $code }}">
                            <div class="form-group">
                                <label class="small font-weight-bold">Nouveau mot de passe</label>
                                <input type="password" name="mot_de_passe" class="form-control" placeholder="Minimum 6 caractères" required>
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold">Confirmer le mot de passe</label>
                                <input type="password" name="mot_de_passe_confirmation" class="form-control" placeholder="Répétez le mot de passe" required>
                            </div>
                            <button type="submit" class="btn-pro mt-2">
                                <i class="fas fa-save mr-2"></i>Enregistrer le nouveau mot de passe
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
