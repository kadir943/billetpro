@extends('layouts.app')
@section('title','Connexion Employé')
@section('styles')
<style>
body{background:linear-gradient(135deg,#1a1a2e,#16213e);min-height:100vh;display:flex;align-items:center}
.login-card{border-radius:20px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.4)}
.login-left{background:linear-gradient(135deg,#0288d1,#0077b6);padding:3rem;color:#fff;text-align:center;display:flex;flex-direction:column;justify-content:center}
.login-right{background:#fff;padding:3rem}
.form-control{border-radius:10px;border:2px solid #eee;padding:0.8rem 1rem}
.form-control:focus{border-color:#0288d1;box-shadow:none}
.btn-login{background:#0288d1;color:#fff;border:none;border-radius:10px;padding:0.9rem;font-weight:700;font-size:1rem;width:100%}
.btn-login:hover{background:#0077b6;color:#fff}
</style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            <div class="login-card">
                <div class="row no-gutters">
                    <div class="col-md-5 login-left">
                        <i class="fas fa-user-check" style="font-size:4rem;margin-bottom:1rem"></i>
                        <h3 class="font-weight-bold">Espace Employé</h3>
                        <p style="opacity:0.85">Vérifiez et approuvez les paiements des clients.</p>
                    </div>
                    <div class="col-md-7 login-right">
                        <h4 class="font-weight-bold mb-1">Connexion Employé</h4>
                        <p class="text-muted small mb-4">Accédez à votre espace de vérification.</p>
                        @if(session('error'))
                            <div class="alert alert-danger py-2">{{ session('error') }}</div>
                        @endif
                        <form method="POST" action="{{ route('employe.login.post') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="small font-weight-bold">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold">Mot de passe</label>
                                <input type="password" name="mot_de_passe" class="form-control" required>
                            </div>
                            <button type="submit" class="btn-login"><i class="fas fa-sign-in-alt mr-2"></i>Se connecter</button>
                            <div class="text-right mt-2">
    <a href="{{ route('password.forgot') }}" style="font-size:0.82rem;color:#0288d1;text-decoration:none">
        <i class="fas fa-lock mr-1"></i>Mot de passe oublié ?
    </a>
</div>

                        </form>
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-muted small"><i class="fas fa-arrow-left mr-1"></i>Retour</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection