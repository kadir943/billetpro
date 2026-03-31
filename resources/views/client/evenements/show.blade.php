@extends('layouts.client')
@section('title', $evenement->titre)
@section('page-title', $evenement->titre)
@section('page-subtitle', 'Détails de l\'événement')
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4" style="overflow:hidden;border-radius:15px">
            @if($evenement->image)
                <img src="{{ asset('uploads/events/' . $evenement->image) }}" style="width:100%;max-height:350px;object-fit:cover">
            @else
                <div style="height:250px;background:linear-gradient(135deg,#6C3DF4,#F97316);display:flex;align-items:center;justify-content:center;color:#fff;font-size:5rem"><i class="fas fa-calendar-alt"></i></div>
            @endif
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="font-weight-bold">{{ $evenement->titre }}</h4>
                @if($evenement->categorie)
                    <span class="badge badge-secondary mb-3">{{ $evenement->categorie->nom }}</span>
                @endif
                <p class="text-muted">{{ $evenement->description ? $evenement->description : 'Aucune description disponible.' }}</p>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2"><i class="fas fa-calendar-alt mr-2 text-primary"></i><strong>Date :</strong> {{ $evenement->date_evenement ? \Carbon\Carbon::parse($evenement->date_evenement)->format('d/m/Y à H:i') : '-' }}</p>
                        <p class="mb-2"><i class="fas fa-map-marker-alt mr-2 text-danger"></i><strong>Lieu :</strong> {{ $evenement->lieu ? $evenement->lieu : '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><i class="fas fa-users mr-2 text-success"></i><strong>Places disponibles :</strong> {{ $evenement->places_disponibles }} / {{ $evenement->capacite }}</p>
                        <p class="mb-2"><i class="fas fa-user-tie mr-2 text-info"></i><strong>Organisateur :</strong> {{ $evenement->organisateur ? $evenement->organisateur->nom : '-' }}</p>
                    </div>
                </div>
                @if($evenement->places_disponibles > 0)
                    <div class="progress mt-2" style="height:8px;border-radius:10px">
                        <div class="progress-bar bg-success" style="width:{{ ($evenement->places_disponibles / $evenement->capacite) * 100 }}%"></div>
                    </div>
                    <small class="text-muted">{{ round(($evenement->places_disponibles / $evenement->capacite) * 100) }}% des places encore disponibles</small>
                @else
                    <div class="alert alert-danger py-2 mt-2"><i class="fas fa-times-circle mr-2"></i>Complet - Plus de places disponibles</div>
                @endif
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <i class="fas fa-star mr-2"></i>Avis ({{ $evenement->avis->count() }})
                @if($noteMoyenne > 0)
                    <span class="ml-2">
                        @for($i=1;$i<=5;$i++)
                            <i class="fas fa-star" style="color:{{ $i <= round($noteMoyenne) ? '#FBBF24' : '#ccc' }};font-size:0.9rem"></i>
                        @endfor
                        <small>({{ number_format($noteMoyenne,1) }}/5)</small>
                    </span>
                @endif
            </div>
            <div class="card-body">
                @if($dejaAchete && !$aDejaAvis)
                <form method="POST" action="{{ route('client.avis.store', $evenement->id) }}" class="mb-4 p-3" style="background:#f8f9ff;border-radius:10px">
                    @csrf
                    <h6 class="font-weight-bold mb-3">Laisser un avis</h6>
                    <div class="form-group">
                        <label class="small font-weight-bold">Note</label>
                        <select name="note" class="form-control" style="max-width:150px">
                            <option value="5">⭐⭐⭐⭐⭐ 5/5</option>
                            <option value="4">⭐⭐⭐⭐ 4/5</option>
                            <option value="3">⭐⭐⭐ 3/5</option>
                            <option value="2">⭐⭐ 2/5</option>
                            <option value="1">⭐ 1/5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Commentaire</label>
                        <textarea name="commentaire" class="form-control" rows="3" placeholder="Partagez votre expérience..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm rounded-pill"><i class="fas fa-paper-plane mr-2"></i>Publier mon avis</button>
                </form>
                @endif
                @forelse($evenement->avis as $avis)
                <div class="d-flex mb-3 pb-3 border-bottom">
                    <div class="mr-3" style="width:40px;height:40px;border-radius:50%;background:#F97316;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0">{{ strtoupper(substr($avis->client ? $avis->client->nom : 'U',0,1)) }}</div>
                    <div>
                        <div class="font-weight-bold small">{{ $avis->client ? $avis->client->nom : 'Utilisateur' }}</div>
                        <div class="mb-1">@for($i=1;$i<=5;$i++)<i class="fas fa-star" style="color:{{ $i<=$avis->note ? '#FBBF24' : '#ddd' }};font-size:0.75rem"></i>@endfor</div>
                        <p class="text-muted small mb-0">{{ $avis->commentaire ? $avis->commentaire : '' }}</p>
                        <small class="text-muted" style="font-size:0.7rem">{{ $avis->created_at->format('d/m/Y') }}</small>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center py-3">Aucun avis pour cet événement.</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card sticky-top" style="top:80px">
            <div class="card-body text-center">
                <div class="mb-3">
                    <div style="font-size:2.5rem;font-weight:900;color:#F97316">
                        {{ $evenement->prix == 0 ? 'GRATUIT' : number_format($evenement->prix, 0).' DJF' }}
                    </div>
                    <small class="text-muted">par billet</small>
                </div>
                @if($dejaAchete)
                    <div class="alert alert-success py-2"><i class="fas fa-check-circle mr-1"></i>Vous avez déjà un billet</div>
                    <a href="{{ route('client.billets') }}" class="btn btn-outline-success btn-block rounded-pill">Voir mes billets</a>
                @elseif($evenement->places_disponibles <= 0)
                    <div class="alert alert-danger py-2">Complet</div>
                @else
                    <a href="{{ route('client.billet.achat', $evenement->id) }}" class="btn btn-primary btn-lg btn-block rounded-pill">
                        <i class="fas fa-ticket-alt mr-2"></i>Acheter un billet
                    </a>
                @endif
                <hr>
                <form method="POST" action="{{ route('client.favori.toggle', $evenement->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-{{ $enFavori ? 'danger' : 'secondary' }} btn-block rounded-pill btn-sm">
                        <i class="fas fa-heart mr-2"></i>{{ $enFavori ? 'Retirer des favoris' : 'Ajouter aux favoris' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
