@extends('layouts.employe')
@section('title','Détail Paiement')
@section('page-title','Détail du Paiement')
@section('page-subtitle','Vérifiez les informations avant d\'approuver')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="pro-card mb-4">
            <div class="pro-card-header">
                <div class="pro-card-title">Informations du paiement</div>
                <span class="status-badge {{ $paiement->statut_paiement == 'en_attente' ? 'status-pending' : ($paiement->statut_paiement == 'reussi' ? 'status-active' : 'status-cancelled') }}">
                    {{ ucfirst(str_replace('_', ' ', $paiement->statut_paiement)) }}
                </span>
            </div>
            <div style="padding:1.5rem">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div style="font-size:11px;color:#a0aec0;margin-bottom:4px">Client</div>
                        <div style="font-size:13px;font-weight:500;color:#0f1824">{{ $paiement->billet && $paiement->billet->client ? $paiement->billet->client->nom : '-' }}</div>
                        <div style="font-size:12px;color:#0288d1">{{ $paiement->billet && $paiement->billet->client ? $paiement->billet->client->email : '' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div style="font-size:11px;color:#a0aec0;margin-bottom:4px">Événement</div>
                        <div style="font-size:13px;font-weight:500;color:#0f1824">{{ $paiement->billet && $paiement->billet->evenement ? $paiement->billet->evenement->titre : '-' }}</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div style="font-size:11px;color:#a0aec0;margin-bottom:4px">Méthode</div>
                        <span class="status-badge" style="background:#e3f2fd;color:#0288d1">{{ ucfirst($paiement->methode_paiement) }}</span>
                    </div>
                    <div class="col-md-4">
                        <div style="font-size:11px;color:#a0aec0;margin-bottom:4px">Montant</div>
                        <div style="font-size:1.2rem;font-weight:700;color:#0288d1">{{ number_format($paiement->montant, 0) }} DJF</div>
                    </div>
                    <div class="col-md-4">
                        <div style="font-size:11px;color:#a0aec0;margin-bottom:4px">Date</div>
                        <div style="font-size:12px;color:#0f1824">{{ $paiement->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div style="font-size:11px;color:#a0aec0;margin-bottom:4px">Code de transaction</div>
                        <code style="font-size:14px;color:#0288d1;font-weight:700">{{ $paiement->code_transaction ? $paiement->code_transaction : 'Non fourni' }}</code>
                    </div>
                    <div class="col-md-6">
                        <div style="font-size:11px;color:#a0aec0;margin-bottom:4px">Numéro de billet</div>
                        <code style="font-size:12px;color:#0288d1">{{ $paiement->billet ? $paiement->billet->numero_billet : '-' }}</code>
                    </div>
                </div>

                @if($paiement->recu_paiement)
                <div class="mb-3">
                    <div style="font-size:11px;color:#a0aec0;margin-bottom:8px">Reçu de paiement</div>
                    <img src="{{ asset('uploads/recus/' . $paiement->recu_paiement) }}" style="max-width:100%;border-radius:8px;border:1px solid #e0e7ef">
                </div>
                @else
                <div style="background:#fff3e0;border-radius:8px;padding:12px;margin-bottom:1rem">
                    <i class="fas fa-exclamation-triangle mr-2" style="color:#ed8936"></i>
                    <span style="font-size:12px;color:#e65100">Aucun reçu fourni par le client</span>
                </div>
                @endif

                @if($paiement->statut_paiement == 'en_attente')
                <div class="d-flex gap-3 mt-4">
                    <form method="POST" action="{{ route('employe.paiement.approuver', $paiement->id) }}" style="flex:1" onsubmit="return confirm('Approuver ce paiement ?')">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn-primary-pro" style="width:100%;justify-content:center;padding:10px;background:#28a745;border-color:#28a745">
                            <i class="fas fa-check mr-2"></i>Approuver le paiement
                        </button>
                    </form>
                    <form method="POST" action="{{ route('employe.paiement.refuser', $paiement->id) }}" style="flex:1" onsubmit="return confirm('Refuser ce paiement ?')">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" style="width:100%;justify-content:center;padding:10px;background:#e53e3e;color:#fff;border:none;border-radius:8px;font-weight:500;display:flex;align-items:center;gap:6px">
                            <i class="fas fa-times mr-2"></i>Refuser le paiement
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        <a href="{{ route('employe.dashboard') }}" class="btn-secondary-pro">
            <i class="fas fa-arrow-left mr-2"></i>Retour au dashboard
        </a>
    </div>
</div>
@endsection