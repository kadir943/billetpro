@extends('layouts.client')
@section('title','Mes Billets')
@section('page-title','Mes Billets')
@section('page-subtitle','Historique de vos billets achetés')
@section('content')
<div class="card">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <span><i class="fas fa-ticket-alt mr-2"></i>Mes billets ({{ $billets->total() }})</span>
        <a href="{{ route('client.evenements') }}" class="btn btn-sm btn-light rounded-pill">
            <i class="fas fa-plus mr-1"></i>Acheter un billet
        </a>
    </div>
    <div class="card-body p-0">
        @forelse($billets as $b)
        <div class="p-3 border-bottom">
            <div class="row align-items-center">
                <div class="col-md-1 text-center">
                    <div style="width:45px;height:45px;background:linear-gradient(135deg,#F97316,#FBBF24);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.2rem">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="font-weight-bold">{{ $b->evenement ? str_limit($b->evenement->titre, 30) : '-' }}</div>
                    <small class="text-muted">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ $b->evenement && $b->evenement->date_evenement ? \Carbon\Carbon::parse($b->evenement->date_evenement)->format('d/m/Y') : '-' }}
                    </small>
                </div>
                <div class="col-md-3">
                    <code class="small" style="color:#6C3DF4">{{ $b->numero_billet }}</code>
                    <div class="text-muted" style="font-size:0.75rem">{{ $b->quantite }} billet(s) · {{ number_format($b->prix_unitaire * $b->quantite, 0) }} DJF</div>
                </div>
                <div class="col-md-2">
                    <span class="badge badge-{{ $b->statut == 'valide' ? 'success' : ($b->statut == 'utilise' ? 'secondary' : 'danger') }} px-3 py-2">
                        @if($b->statut == 'valide') <i class="fas fa-check mr-1"></i>
                        @elseif($b->statut == 'utilise') <i class="fas fa-check-double mr-1"></i>
                        @else <i class="fas fa-times mr-1"></i>
                        @endif
                        {{ ucfirst($b->statut) }}
                    </span>
                </div>
                <div class="col-md-2 text-right">
                    <a href="{{ route('client.billet.show', $b->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                        <i class="fas fa-eye mr-1"></i>Voir billet
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="fas fa-ticket-alt fa-3x text-muted mb-3 d-block"></i>
            <h5 class="text-muted">Vous n'avez pas encore de billet</h5>
            <p class="text-muted">Explorez les événements disponibles et achetez votre premier billet !</p>
            <a href="{{ route('client.evenements') }}" class="btn btn-primary rounded-pill">
                <i class="fas fa-search mr-2"></i>Découvrir les événements
            </a>
        </div>
        @endforelse
    </div>
    @if($billets->total() > 0)
    <div class="card-footer">{{ $billets->links() }}</div>
    @endif
</div>
@endsection
