@extends('layouts.client')
@section('title','Mes Favoris')
@section('page-title','Mes Favoris')
@section('page-subtitle','Événements que vous suivez')
@section('content')
@if($favoris->isEmpty())
<div class="text-center py-5">
    <i class="fas fa-heart fa-3x text-muted mb-3 d-block"></i>
    <h5 class="text-muted">Aucun favori pour le moment</h5>
    <p class="text-muted">Ajoutez des événements à vos favoris pour les retrouver facilement.</p>
    <a href="{{ route('client.evenements') }}" class="btn btn-primary rounded-pill">
        <i class="fas fa-search mr-2"></i>Découvrir les événements
    </a>
</div>
@else
<div class="row">
    @foreach($favoris as $f)
    @if($f->evenement)
    <div class="col-md-4 mb-4">
        <div class="event-card card h-100">
            @if($f->evenement->image)
                <img src="{{ asset('uploads/events/'.$f->evenement->image) }}" class="event-img">
            @else
                <div class="event-img-placeholder"><i class="fas fa-calendar-alt"></i></div>
            @endif
            <div class="card-body">
                <h6 class="font-weight-bold">{{ str_limit($f->evenement->titre, 30) }}</h6>
                @if($f->evenement->categorie)
                    <span class="badge badge-secondary mb-2">{{ $f->evenement->categorie->nom }}</span>
                @endif
                <p class="text-muted small mb-1">
                    <i class="fas fa-calendar mr-1"></i>
                    {{ $f->evenement->date_evenement ? \Carbon\Carbon::parse($f->evenement->date_evenement)->format('d/m/Y') : '-' }}
                </p>
                <p class="text-muted small mb-2">
                    <i class="fas fa-map-marker-alt mr-1"></i>
                    {{ str_limit($f->evenement->lieu ? $f->evenement->lieu : '-', 25) }}
                </p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="price-tag">{{ $f->evenement->prix == 0 ? 'Gratuit' : number_format($f->evenement->prix, 0).' DJF' }}</span>
                    <div>
                        <a href="{{ route('client.evenement.show', $f->evenement->id) }}" class="btn btn-primary btn-sm rounded-pill mr-1">Voir</a>
                        <form method="POST" action="{{ route('client.favori.toggle', $f->evenement->id) }}" style="display:inline">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                                <i class="fas fa-heart-broken"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>
@endif
@endsection
