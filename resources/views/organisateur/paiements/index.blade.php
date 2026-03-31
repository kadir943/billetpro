@extends('layouts.organisateur')
@section('title','Paiements')
@section('page-title','Mes Paiements')
@section('page-subtitle','Revenus générés par vos événements')
@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card" style="background:linear-gradient(135deg,#28a745,#20c997)">
            <div class="bg-icon"><i class="fas fa-dollar-sign"></i></div>
            <div class="value">{{ number_format($totalRevenu, 0, '.', ' ') }} DJF</div>
            <div class="small">Revenu total validé</div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header bg-dark text-white"><i class="fas fa-credit-card mr-2"></i>Historique des paiements ({{ $paiements->total() }})</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr><th>Référence</th><th>Client</th><th>Événement</th><th>Montant</th><th>Méthode</th><th>Statut</th><th>Date</th></tr>
                </thead>
                <tbody>
                    @forelse($paiements as $p)
                    <tr>
                        <td><code class="small">{{ $p->reference ? $p->reference : '-' }}</code></td>
                        <td>{{ $p->billet && $p->billet->client ? $p->billet->client->nom : '-' }}</td>
                        <td>{{ $p->billet && $p->billet->evenement ? str_limit($p->billet->evenement->titre, 25) : '-' }}</td>
                        <td class="font-weight-bold text-success">{{ number_format($p->montant, 0, '.', ' ') }} DJF</td>
                        <td><span class="badge badge-secondary">{{ ucfirst($p->methode_paiement) }}</span></td>
                        <td>
                            <span class="badge badge-{{ $p->statut_paiement == 'reussi' ? 'success' : ($p->statut_paiement == 'en_attente' ? 'warning' : 'danger') }}">
                                {{ str_replace('_', ' ', ucfirst($p->statut_paiement)) }}
                            </span>
                        </td>
                        <td class="small text-muted">{{ $p->date_paiement ? \Carbon\Carbon::parse($p->date_paiement)->format('d/m/Y H:i') : '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Aucun paiement trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">{{ $paiements->links() }}</div>
</div>
@endsection
