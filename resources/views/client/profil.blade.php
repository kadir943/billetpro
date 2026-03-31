@extends('layouts.client')
@section('title','Mon Profil')
@section('page-title','Mon Profil')
@section('page-subtitle','Gérez vos informations personnelles')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-dark text-white"><i class="fas fa-user-cog mr-2"></i>Modifier mon profil</div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#F97316,#FBBF24);color:#fff;display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:800;margin:0 auto">
                        {{ strtoupper(substr($client->nom, 0, 1)) }}
                    </div>
                    <h5 class="mt-2 font-weight-bold">{{ $client->nom }}</h5>
                    <span class="badge" style="background:#F97316;color:#fff">Client</span>
                    <div class="text-muted small mt-1">Membre depuis {{ $client->created_at->format('d/m/Y') }}</div>
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
                <form method="POST" action="{{ route('client.profil.update') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label class="small font-weight-bold">Nom complet</label>
                        <input type="text" name="nom" class="form-control" value="{{ old('nom', $client->nom) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $client->email) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Téléphone</label>
                        <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $client->telephone) }}" placeholder="+253 77 00 00 00">
                    </div>
                    <hr>
                    <p class="small text-muted"><i class="fas fa-lock mr-1"></i>Laissez vide pour ne pas modifier le mot de passe</p>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Nouveau mot de passe</label>
                            <input type="password" name="mot_de_passe" class="form-control" placeholder="Minimum 6 caractères">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Confirmer</label>
                            <input type="password" name="mot_de_passe_confirmation" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block rounded-pill">
                        <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
