@extends('layouts.employe')
@section('title','Dashboard Employé')
@section('page-title','Tableau de bord')
@section('page-subtitle','Vérification des paiements')
@section('content')
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="stat-card" style="border-top:3px solid #ed8936">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div style="width:28px;height:28px;background:#fff3e0;border-radius:6px;display:flex;align-items:center;justify-content:center"><i class="fas fa-clock" style="color:#ed8936;font-size:12px"></i></div>
                <span style="font-size:11px;background:#fff3e0;color:#e65100;padding:2px 7px;border-radius:4px;font-weight:500">À vérifier</span>
            </div>
            <div class="stat-label">Paiements en attente</div>
            <div class="stat-value" style="color:#ed8936">{{ $totalEnAttente }}</div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card" style="border-top:3px solid #48bb78">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div style="width:28px;height:28px;background:#e8f5e9;border-radius:6px;display:flex;align-items:center;justify-content:center"><i class="fas fa-check" style="color:#48bb78;font-size:12px"></i></div>
                <span style="font-size:11px;background:#e8f5e9;color:#2e7d32;padding:2px 7px;border-radius:4px;font-weight:500">Approuvés</span>
            </div>
            <div class="stat-label">Paiements vérifiés</div>
            <div class="stat-value" style="color:#48bb78">{{ $totalVerifies }}</div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card" style="border-top:3px solid #e53e3e">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div style="width:28px;height:28px;background:#fff0f0;border-radius:6px;display:flex;align-items:center;justify-content:center"><i class="fas fa-times" style="color:#e53e3e;font-size:12px"></i></div>
                <span style="font-size:11px;background:#fff0f0;color:#e53e3e;padding:2px 7px;border-radius:4px;font-weight:500">Refusés</span>
            </div>
            <div class="stat-label">Paiements refusés</div>
            <div class="stat-value" style="color:#e53e3e">{{ $totalRefuses }}</div>
        </div>
    </div>
</div>

<div class="pro-card">
    <div class="pro-card-header">
        <div class="pro-card-title">Paiements en attente de vérification</div>
        <a href="{{ route('employe.paiements') }}" style="font-size:12px;color:#0288d1;font-weight:500;text-decoration:none">Voir tout →</a>
    </div>
    <div class="table-responsive">
        <table class="pro-table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Événement</th>
                    <th>Méthode</th>
                    <th>Montant</th>
                    <th>Code transaction</th>
                    <th>Reçu</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($paiementsRecents as $p)
                <tr>
                    <td>
                        <div style="font-size:12px;font-weight:500;color:#0f1824">{{ $p->billet && $p->billet->client ? $p->billet->client->nom : '-' }}</div>
                        <div style="font-size:11px;color:#a0aec0">{{ $p->billet && $p->billet->client ? $p->billet->client->email : '' }}</div>
                    </td>
                    <td style="font-size:12px">{{ $p->billet && $p->billet->evenement ? str_limit($p->billet->evenement->titre, 25) : '-' }}</td>
                    <td>
                        <span class="status-badge" style="background:#e3f2fd;color:#0288d1">{{ ucfirst($p->methode_paiement) }}</span>
                    </td>
                    <td style="font-size:12px;font-weight:600;color:#0f1824">{{ number_format($p->montant, 0) }} DJF</td>
                    <td>
                        <code style="font-size:11px;color:#0288d1">{{ $p->code_transaction ? $p->code_transaction : 'Non fourni' }}</code>
                    </td>
                    <td>
                        @if($p->recu_paiement)
                            <a href="{{ asset('uploads/recus/' . $p->recu_paiement) }}" target="_blank" class="btn-secondary-pro" style="padding:4px 10px;font-size:11px">
                                <i class="fas fa-image mr-1"></i>Voir
                            </a>
                        @else
                            <span style="font-size:11px;color:#a0aec0">Non fourni</span>
                        @endif
                    </td>
                    <td style="font-size:11px;color:#a0aec0">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <form method="POST" action="{{ route('employe.paiement.approuver', $p->id) }}" style="display:inline" onsubmit="return confirm('Approuver ce paiement ?')">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="action-btn" style="background:#e8f5e9;color:#2e7d32"><i class="fas fa-check"></i></button>
                            </form>
                            <form method="POST" action="{{ route('employe.paiement.refuser', $p->id) }}" style="display:inline" onsubmit="return confirm('Refuser ce paiement ?')">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="action-btn action-delete"><i class="fas fa-times"></i></button>
                            </form>
                            <a href="{{ route('employe.paiement.voir', $p->id) }}" class="action-btn action-edit"><i class="fas fa-eye"></i></a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:2rem;color:#a0aec0">
                        <i class="fas fa-check-circle fa-2x mb-2 d-block" style="color:#48bb78"></i>
                        Aucun paiement en attente
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection