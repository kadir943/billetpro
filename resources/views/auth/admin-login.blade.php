@extends('layouts.app')
@section('title','Connexion Administrateur')
@section('styles')
<style>
body{background:linear-gradient(135deg,#1a1a2e,#16213e);min-height:100vh;display:flex;align-items:center}
.login-card{border-radius:20px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.4)}
.login-left{background:linear-gradient(135deg,#0288d1,#0077b6);padding:3rem;color:#fff;display:flex;flex-direction:column;justify-content:center;text-align:center}
.login-right{background:#fff;padding:3rem}
.form-control{border-radius:10px;border:2px solid #eee;padding:0.8rem 1rem}
.form-control:focus{border-color:#0288d1;box-shadow:none}
.btn-login{background:linear-gradient(135deg,#0288d1,#0077b6);color:#fff;border:none;border-radius:10px;padding:0.9rem;font-weight:700;font-size:1rem;width:100%}
.btn-login:hover{opacity:0.9;color:#fff}
</style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="login-card">
                <div class="row no-gutters">
                    <div class="col-md-5 login-left">
                        <i class="fas fa-user-shield" style="font-size:4rem;margin-bottom:1rem"></i>
                        <h3 class="font-weight-bold">Administration</h3>
                        <p style="opacity:0.85">Accès réservé aux administrateurs de BilletPro.</p>
                    </div>
                    <div class="col-md-7 login-right">
                        <h4 class="font-weight-bold mb-1">Connexion Admin</h4>
                        <p class="text-muted small mb-4">Entrez vos identifiants administrateur.</p>
                        @if(session('error'))
                            <div class="alert alert-danger py-2">{{ session('error') }}</div>
                        @endif
                        @if($errors->has('email'))
                            <div class="alert alert-danger py-2">{{ $errors->first('email') }}</div>
                        @endif
                        <form method="POST" action="{{ route('admin.login.post') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="small font-weight-bold">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email','admin@billetterie.com') }}" required>
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold">Mot de passe</label>
                                <input type="password" name="mot_de_passe" class="form-control" placeholder="••••••••" required>
                            </div>
                            <button type="submit" class="btn-login mt-2"><i class="fas fa-sign-in-alt mr-2"></i>Se connecter</button>
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