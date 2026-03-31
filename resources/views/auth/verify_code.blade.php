@extends('layouts.app')
@section('title','Vérification du code')
@section('styles')
<style>
body{background:linear-gradient(135deg,#1a1a2e,#16213e);min-height:100vh;display:flex;align-items:center}
.card-pro{border-radius:20px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.4)}
.card-left{background:linear-gradient(135deg,#0288d1,#0077b6);padding:3rem;color:#fff;text-align:center;display:flex;flex-direction:column;justify-content:center}
.card-right{background:#fff;padding:3rem}
.form-control{border-radius:10px;border:2px solid #eee;padding:0.8rem 1rem;font-size:1.5rem;text-align:center;letter-spacing:8px;font-weight:700}
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
                        <div style="font-size:4rem;margin-bottom:1rem">📧</div>
                        <h3 class="font-weight-bold">Code envoyé !</h3>
                        <p style="opacity:0.85">Vérifiez votre boîte email et entrez le code à 6 chiffres.</p>
                        <hr style="border-color:rgba(255,255,255,0.3)">
                        <div style="background:rgba(255,255,255,0.15);border-radius:10px;padding:0.8rem;font-size:0.85rem">
                            <i class="fas fa-clock mr-2"></i>Code valable 15 minutes
                        </div>
                    </div>
                    <div class="col-md-7 card-right">
                        <h4 class="font-weight-bold mb-1">Entrez votre code</h4>
                        <p class="text-muted small mb-4">Un code à 6 chiffres a été envoyé à <strong>{{ $email }}</strong></p>
                        @if(session('error'))
                            <div class="alert alert-danger py-2">{{ session('error') }}</div>
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success py-2">{{ session('success') }}</div>
                        @endif
                        <form method="POST" action="{{ route('password.verify.code') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="email" value="{{ $email }}">
                            <div class="form-group">
                                <label class="small font-weight-bold">Code de vérification</label>
                                <input type="text" name="code" class="form-control" placeholder="000000" maxlength="6" required autofocus>
                                <small class="text-muted">Entrez le code à 6 chiffres reçu par email</small>
                            </div>
                            <button type="submit" class="btn-pro mt-2">
                                <i class="fas fa-check mr-2"></i>Vérifier le code
                            </button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="{{ route('password.forgot') }}" class="text-muted small"><i class="fas fa-redo mr-1"></i>Renvoyer un nouveau code</a>
                        </div>
                        <div class="text-center mt-2">
                            <a href="{{ route('login') }}" class="text-muted small"><i class="fas fa-arrow-left mr-1"></i>Retour à la connexion</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection