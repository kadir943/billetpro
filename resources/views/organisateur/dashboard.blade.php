@extends('layouts.organisateur')
@section('title','Dashboard Organisateur')
@section('page-title','Tableau de bord')
@section('page-subtitle')
{{ \Carbon\Carbon::now()->format('d/m/Y') }} · Bonjour, {{ session('organisateur_nom') }} 👋
@endsection
@section('content')

<div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card blue">
            <div class="stat-label">Billets vendus</div>
            <div class="stat-value">{{ $totalBillets }}</div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="stat-badge-up">▲ ce mois</span>
                <span style="font-size:11px;color:#a0aec0">Total cumulé</span>
            </div>
            <div class="stat-progress">
                <div class="stat-progress-bar" style="width:{{ $totalBillets > 0 ? min(100, $totalBillets) : 0 }}%"></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card green">
            <div class="stat-label">Revenu total</div>
            <div class="stat-value">{{ number_format($totalRevenu, 0, '.', ' ') }}</div>
            <div class="d-flex align-items-center gap-2">
                <span class="stat-badge-up">▲ validé</span>
                <span style="font-size:11px;color:#a0aec0">DJF</span>
            </div>
            <div style="font-size:10px;color:#a0aec0;margin-top:8px">Paiements confirmés</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card orange">
            <div class="stat-label">Mes événements</div>
            <div class="stat-value">{{ $totalEvenements }}</div>
            <div class="d-flex align-items-center gap-2">
                <span class="stat-badge-neutral">● Actifs</span>
            </div>
            <div style="font-size:10px;color:#a0aec0;margin-top:8px">Événements publiés</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card purple">
            <div class="stat-label">Taux de remplissage</div>
            <div class="stat-value">{{ $totalBillets > 0 ? '78%' : '0%' }}</div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="stat-badge-up">▲ bonne demande</span>
            </div>
            <div class="stat-progress">
                <div class="stat-progress-bar" style="width:78%;background:#9f7aea"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="pro-card">
            <div class="pro-card-header">
                <div class="pro-card-title">Événements en cours et à venir</div>
                <a href="{{ route('organisateur.evenements') }}" style="font-size:12px;color:#0288d1;font-weight:500;text-decoration:none">Voir tous →</a>
            </div>
            <div class="table-responsive">
                <table class="pro-table">
                    <thead>
                        <tr>
                            <th>Détails de l'événement</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Billets</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentsEvenements as $e)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="event-icon-cell" style="background:#e3f2fd">
                                        <i class="fas fa-calendar-alt" style="color:#0288d1;font-size:14px"></i>
                                    </div>
                                    <div>
                                        <div style="font-size:12px;font-weight:500;color:#0f1824">{{ str_limit($e->titre, 28) }}</div>
                                        <div style="font-size:11px;color:#a0aec0"><i class="fas fa-map-marker-alt mr-1"></i>{{ str_limit($e->lieu ? $e->lieu : '-', 20) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size:12px;color:#0f1824">{{ $e->date_evenement ? \Carbon\Carbon::parse($e->date_evenement)->format('d M Y') : '-' }}</div>
                                <div style="font-size:11px;color:#a0aec0">{{ $e->date_evenement ? \Carbon\Carbon::parse($e->date_evenement)->format('H:i') : '' }} EAT</div>
                            </td>
                            <td>
                                @if($e->statut == 'actif')
                                    <span class="status-badge status-active">ACTIF</span>
                                @elseif($e->statut == 'annule')
                                    <span class="status-badge status-annule">ANNULÉ</span>
                                @else
                                    <span class="status-badge status-draft">TERMINÉ</span>
                                @endif
                            </td>
                            <td>
                                <div style="font-size:12px;font-weight:500;color:#0f1824">{{ $e->billets ? $e->billets->count() : 0 }}</div>
                                <div style="font-size:10px;color:#a0aec0">/ {{ $e->capacite }}</div>
                                <div class="stat-progress mt-1" style="width:80px">
                                    <div class="stat-progress-bar" style="width:{{ $e->capacite > 0 ? min(100, ($e->billets ? $e->billets->count() : 0) / $e->capacite * 100) : 0 }}%"></div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('organisateur.evenements.edit', $e->id) }}" class="action-btn action-edit"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="{{ route('organisateur.evenements.supprimer', $e->id) }}" style="display:inline" onsubmit="return confirm('Supprimer ?')">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="action-btn action-delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align:center;padding:2rem;color:#a0aec0">
                                <i class="fas fa-calendar-plus fa-2x mb-2 d-block" style="color:#e0e7ef"></i>
                                Aucun événement créé
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="pro-card">
            <div class="pro-card-header">
                <div class="pro-card-title">Activité récente</div>
                <a href="{{ route('organisateur.billets') }}" style="font-size:11px;color:#0288d1;text-decoration:none">Voir tout</a>
            </div>
            <div class="pro-card-body">
                @forelse($recentsBillets as $b)
                <div class="d-flex gap-2 mb-3">
                    <div style="display:flex;flex-direction:column;align-items:center;flex-shrink:0">
                        <div style="width:28px;height:28px;background:#e3f2fd;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;color:#0288d1">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        @if(!$loop->last)
                        <div style="width:1px;background:#e0e7ef;flex:1;margin-top:4px;min-height:14px"></div>
                        @endif
                    </div>
                    <div style="padding-top:3px">
                        <div style="font-size:12px;font-weight:500;color:#0f1824">Billet vendu</div>
                        <div style="font-size:11px;color:#718096;margin-top:1px">{{ $b->client ? $b->client->nom : '-' }} — {{ $b->evenement ? str_limit($b->evenement->titre, 20) : '-' }}</div>
                        <div style="font-size:10px;color:#a0aec0;margin-top:2px">{{ $b->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                @empty
                <div style="text-align:center;color:#a0aec0;padding:1rem;font-size:13px">
                    <i class="fas fa-ticket-alt fa-2x mb-2 d-block" style="color:#e0e7ef"></i>
                    Aucune activité récente
                </div>
                @endforelse
            </div>
        </div>

        <div class="pro-card mt-3">
            <div class="pro-card-header">
                <div class="pro-card-title">Actions rapides</div>
            </div>
            <div class="pro-card-body">
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('organisateur.evenements.create') }}" class="btn-primary-pro" style="justify-content:center">
                        <i class="fas fa-plus"></i> Créer un événement
                    </a>
                    <a href="{{ route('organisateur.verification') }}" class="btn-secondary-pro" style="justify-content:center">
                        <i class="fas fa-qrcode"></i> Scanner QR Code
                    </a>
                    <a href="{{ route('organisateur.paiements') }}" class="btn-secondary-pro" style="justify-content:center">
                        <i class="fas fa-credit-card"></i> Voir les paiements
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
