@extends('layouts.admin')
@section('title','Mon Profil')
@section('page-title','Mon Profil')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="pro-card">
            <div class="pro-card-header">
                <div class="pro-card-title"><i class="fas fa-user-cog mr-2" style="color:#0288d1"></i>Modifier mon profil</div>
            </div>
            <div style="padding:1.5rem">
                <div class="text-center mb-4">
                    <div style="width:80px;height:80px;border-radius:50%;background:#0288d1;color:#fff;display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:600;margin:0 auto">
                        {{ strtoupper(substr($admin->nom, 0, 1)) }}
                    </div>
                    <h5 class="mt-2 font-weight-bold" style="color:#0f1824">{{ $admin->nom }}</h5>
                    <span style="background:#e3f2fd;color:#0288d1;border-radius:20px;padding:3px 14px;font-size:12px;font-weight:500">Super Admin</span>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 pl-3">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('admin.profil.update') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label>Nom complet</label>
                        <input type="text" name="nom" class="form-control" value="{{ old('nom', $admin->nom) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
                    </div>
                    <hr>
                    <p class="small text-muted">Laissez vide pour ne pas changer le mot de passe</p>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Nouveau mot de passe</label>
                            <input type="password" name="mot_de_passe" class="form-control" placeholder="Minimum 6 caractères">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Confirmer</label>
                            <input type="password" name="mot_de_passe_confirmation" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn-primary-pro" style="width:100%;justify-content:center;padding:10px">
                        <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
