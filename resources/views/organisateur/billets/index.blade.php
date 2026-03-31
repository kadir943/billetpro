@extends('layouts.organisateur')
@section('title','Billets Vendus')
@section('page-title','Billets Vendus')
@section('page-subtitle','Tous les billets vendus pour vos événements')
@section('content')
<div class="card">
    <div class="card-header bg-dark text-white"><i class="fas fa-ticket-alt mr-2"></i>Billets vendus ({{ $billets->total() }})</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr><th>N° Billet</th><th>Client</th><th>Événement</th><th>Qté</th><th>Montant</th><th>Paiement</th><th>Statut</th><th>Date</th></tr>
                </thead>
                <tbody>
                    @forelse($billets as $b)
                    <tr>
                        <td><code class="small">{{ $b->numero_billet }}</code></td>
                        <td>
                            <div class="font-weight-bold small">{{ $b->client ? $b->client->nom : '-' }}</div>
                            <small class="text-muted">{{ $b->client ? $b->client->email : '' }}</small>
                        </td>
                        <td>{{ $b->evenement ? str_limit($b->evenement->titre, 25) : '-' }}</td>
                        <td class="text-center font-weight-bold">{{ $b->quantite }}</td>
                        <td class="font-weight-bold">{{ number_format($b->prix_unitaire * $b->quantite, 0, '.', ' ') }} DJF</td>
                        <td>
                            @if($b->paiement)
                                <span class="badge badge-{{ $b->paiement->statut_paiement == 'reussi' ? 'success' : 'warning' }}">
                                    {{ ucfirst($b->paiement->statut_paiement) }}
                                </span>
                                <div class="small text-muted">{{ ucfirst($b->paiement->methode_paiement) }}</div>
                            @else
                                <span class="badge badge-secondary">N/A</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $b->statut == 'valide' ? 'success' : ($b->statut == 'utilise' ? 'secondary' : 'danger') }}">
                                {{ ucfirst($b->statut) }}
                            </span>
                        </td>
                        <td class="small text-muted">{{ $b->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-5 text-muted">Aucun billet vendu pour le moment.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">{{ $billets->links() }}</div>
</div>
@endsection
