@extends('layouts.app')
@section('title','Inscription Client')
@section('styles')
<style>
body{background:linear-gradient(135deg,#1a1a2e,#16213e);min-height:100vh;display:flex;align-items:center;padding:2rem 0}
.register-card{border-radius:20px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.4)}
.register-left{background:linear-gradient(135deg,#0288d1,#0077b6);padding:3rem;color:#fff;text-align:center;display:flex;flex-direction:column;justify-content:center}
.register-right{background:#fff;padding:2.5rem}
.form-control{border-radius:10px;border:2px solid #eee;padding:0.7rem 1rem}
.form-control:focus{border-color:#0288d1;box-shadow:none}
.btn-register{background:linear-gradient(135deg,#0288d1,#0077b6);color:#fff;border:none;border-radius:10px;padding:0.9rem;font-weight:700;width:100%}
.btn-register:hover{opacity:0.9;color:#fff}
</style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-9">
            <div class="register-card">
                <div class="row no-gutters">
                    <div class="col-md-4 register-left">
                        <i class="fas fa-ticket-alt" style="font-size:4rem;margin-bottom:1rem"></i>
                        <h3 class="font-weight-bold">Rejoignez BilletPro</h3>
                        <p style="opacity:0.85">Créez votre compte et commencez à réserver vos événements préférés.</p>
                        <hr style="border-color:rgba(255,255,255,0.3)">
                        <p class="small" style="opacity:0.9">Déjà un compte ?</p>
                        <a href="{{ route('client.login') }}" class="btn btn-light btn-sm rounded-pill font-weight-bold">Se connecter</a>
                    </div>
                    <div class="col-md-8 register-right">
                        <h4 class="font-weight-bold mb-1">Créer un compte Client</h4>
                        <p class="text-muted small mb-4">Inscription gratuite et rapide.</p>
                        @if($errors->any())
                            <div class="alert alert-danger py-2">
                                <ul class="mb-0 pl-3">
                                    @foreach($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('client.register.post') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold">Nom complet <span class="text-danger">*</span></label>
                                    <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold">Téléphone</label>
                                    <input type="text" name="telephone" class="form-control" value="{{ old('telephone') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold">Mot de passe <span class="text-danger">*</span></label>
                                    <input type="password" name="mot_de_passe" class="form-control" placeholder="Minimum 6 caractères" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold">Confirmer <span class="text-danger">*</span></label>
                                    <input type="password" name="mot_de_passe_confirmation" class="form-control" required>
                                </div>
                            </div>
                            <button type="submit" class="btn-register"><i class="fas fa-user-plus mr-2"></i>Créer mon compte</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="{{ route('home') }}" class="text-muted small"><i class="fas fa-arrow-left mr-1"></i>Retour à l'accueil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection