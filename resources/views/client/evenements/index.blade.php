@extends('layouts.client')
@section('title','Événements')
@section('page-title','Tous les Événements')
@section('page-subtitle','Trouvez et réservez votre prochain événement')
@section('content')
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('client.evenements') }}" class="row align-items-end">
            <div class="col-md-4 mb-2 mb-md-0">
                <label class="small font-weight-bold mb-1">Rechercher</label>
                <input type="text" name="search" class="form-control" placeholder="Titre, lieu..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3 mb-2 mb-md-0">
                <label class="small font-weight-bold mb-1">Catégorie</label>
                <select name="categorie" class="form-control">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('categorie') == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-2 mb-md-0">
                <label class="small font-weight-bold mb-1">Prix max (DJF)</label>
                <input type="number" name="prix_max" class="form-control" placeholder="Ex: 5000" value="{{ request('prix_max') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-block rounded-pill"><i class="fas fa-search mr-1"></i>Filtrer</button>
            </div>
        </form>
    </div>
</div>
@if($evenements->isEmpty())
<div class="text-center py-5">
    <i class="fas fa-calendar-times fa-3x text-muted mb-3 d-block"></i>
    <h5 class="text-muted">Aucun événement trouvé</h5>
    <a href="{{ route('client.evenements') }}" class="btn btn-primary rounded-pill">Voir tous les événements</a>
</div>
@else
<div class="row">
    @foreach($evenements as $e)
    <div class="col-md-4 mb-4">
        <div class="event-card card h-100">
            @if($e->image)
                <img src="{{ asset('uploads/events/' . $e->image) }}" class="event-img">
            @else
                <div class="event-img-placeholder"><i class="fas fa-calendar-alt"></i></div>
            @endif
            <div class="card-body">
                <h6 class="font-weight-bold mb-1">{{ str_limit($e->titre, 30) }}</h6>
                @if($e->categorie)
                    <span class="badge badge-secondary mb-2">{{ $e->categorie->nom }}</span>
                @endif
                <p class="text-muted small mb-1"><i class="fas fa-map-marker-alt mr-1 text-danger"></i>{{ str_limit($e->lieu ? $e->lieu : '-', 30) }}</p>
                <p class="text-muted small mb-1"><i class="fas fa-calendar mr-1 text-primary"></i>{{ $e->date_evenement ? \Carbon\Carbon::parse($e->date_evenement)->format('d/m/Y à H:i') : '-' }}</p>
                <p class="text-muted small mb-2"><i class="fas fa-users mr-1 text-success"></i>{{ $e->places_disponibles }} places disponibles</p>
                <div class="d-flex justify-content-between align-items-center mt-auto">
                    <span class="price-tag">{{ $e->prix == 0 ? 'Gratuit' : number_format($e->prix, 0).' DJF' }}</span>
                    <a href="{{ route('client.evenement.show', $e->id) }}" class="btn btn-primary btn-sm rounded-pill">Détails</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="d-flex justify-content-center">{{ $evenements->appends(request()->query())->links() }}</div>
@endif
@endsection
