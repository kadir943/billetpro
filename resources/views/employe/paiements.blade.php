@extends('layouts.employe')
@section('title','Tous les Paiements')
@section('page-title','Gestion des Paiements')
@section('content')
<div class="pro-card">
    <div class="pro-card-header">
        <div class="pro-card-title">Tous les paiements</div>
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
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($paiements as $p)
                <tr>
                    <td>
                        <div style="font-size:12px;font-weight:500;color:#0f1824">{{ $p->billet && $p->billet->client ? $p->billet->client->nom : '-' }}</div>
                        <div style="font-size:11px;color:#a0aec0">{{ $p->billet && $p->billet->client ? $p->billet->client->email : '' }}</div>
                    </td>
                    <td style="font-size:12px">{{ $p->billet && $p->billet->evenement ? str_limit($p->billet->evenement->titre, 25) : '-' }}</td>
                    <td><span class="status-badge" style="background:#e3f2fd;color:#0288d1">{{ ucfirst($p->methode_paiement) }}</span></td>
                    <td style="font-size:12px;font-weight:600">{{ number_format($p->montant, 0) }} DJF</td>
                    <td><code style="font-size:11px;color:#0288d1">{{ $p->code_transaction ? $p->code_transaction : '-' }}</code></td>
                    <td>
                        @if($p->recu_paiement)
                            <a href="{{ asset('uploads/recus/' . $p->recu_paiement) }}" target="_blank" class="btn-secondary-pro" style="padding:4px 10px;font-size:11px"><i class="fas fa-image mr-1"></i>Voir</a>
                        @else
                            <span style="font-size:11px;color:#a0aec0">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge {{ $p->statut_paiement == 'reussi' ? 'status-active' : ($p->statut_paiement == 'en_attente' ? 'status-pending' : 'status-cancelled') }}">
                            {{ ucfirst(str_replace('_', ' ', $p->statut_paiement)) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            @if($p->statut_paiement == 'en_attente')
                            <form method="POST" action="{{ route('employe.paiement.approuver', $p->id) }}" style="display:inline" onsubmit="return confirm('Approuver ?')">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="action-btn" style="background:#e8f5e9;color:#2e7d32"><i class="fas fa-check"></i></button>
                            </form>
                            <form method="POST" action="{{ route('employe.paiement.refuser', $p->id) }}" style="display:inline" onsubmit="return confirm('Refuser ?')">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="action-btn action-delete"><i class="fas fa-times"></i></button>
                            </form>
                            @endif
                            <a href="{{ route('employe.paiement.voir', $p->id) }}" class="action-btn action-edit"><i class="fas fa-eye"></i></a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center;padding:2rem;color:#a0aec0">Aucun paiement trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:0.8rem 1.2rem;border-top:0.5px solid #f0f4f8">{{ $paiements->links() }}</div>
</div>
@endsection
