@extends('layouts.admin')
@section('title','Dashboard Admin')
@section('page-title','Aperçu du système')
@section('content')

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div style="width:28px;height:28px;background:#e3f2fd;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:13px"><i class="fas fa-dollar-sign" style="color:#0288d1;font-size:12px"></i></div>
                <span class="stat-badge-up">+12.4%</span>
            </div>
            <div class="stat-label">Revenu total</div>
            <div class="stat-value">{{ number_format($totalRevenu, 0, '.', ' ') }} DJF</div>
            <div class="stat-progress mt-2">
                <div class="stat-progress-bar" style="width:75%"></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div style="width:28px;height:28px;background:#e3f2fd;border-radius:6px;display:flex;align-items:center;justify-content:center"><i class="fas fa-ticket-alt" style="color:#0288d1;font-size:12px"></i></div>
                <span class="stat-badge-up">+8.1%</span>
            </div>
            <div class="stat-label">Billets vendus</div>
            <div class="stat-value">{{ number_format($totalBillets, 0, '.', ' ') }}</div>
            <div class="stat-progress mt-2">
                <div class="stat-progress-bar" style="width:82%;background:#48bb78"></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="border-top:3px solid {{ $totalEnAttente > 0 ? '#630cf0' : '#e81d24' }}">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div style="width:28px;height:28px;background:#fff3e0;border-radius:6px;display:flex;align-items:center;justify-content:center"><i class="fas fa-user-clock" style="color:#ed8936;font-size:12px"></i></div>
                @if($totalEnAttente > 0)
                    <span style="font-size:11px;background:#fff3e0;color:#e65100;padding:2px 7px;border-radius:4px;font-weight:500">{{ $totalEnAttente }} en attente</span>
                @else
                    <span style="font-size:11px;background:#e8f5e9;color:#2e7d32;padding:2px 7px;border-radius:4px;font-weight:500">Tout approuvé</span>
                @endif
            </div>
            <div class="stat-label">Nouvelles inscriptions</div>
            <div class="stat-value" style="color:{{ $totalEnAttente > 0 ? '#e031a3' : '#48bb78' }}">{{ $totalEnAttente }}</div>
            <div class="mt-1">
                <small style="color:#a0aec0;font-size:10px">{{ $clientsEnAttente }} clients · {{ $organisateursEnAttente }} organisateurs</small>
            </div>
            <div class="mt-2">
                <a href="{{ route('admin.clients') }}" style="font-size:11px;color:#0288d1;font-weight:500;text-decoration:none">Voir et approuver →</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card-dark">
            <div style="position:absolute;right:-10px;top:-10px;font-size:4rem;opacity:0.08"><i class="fas fa-globe"></i></div>
            <div class="stat-label-dark">Statut de la plateforme</div>
            <div class="stat-value-dark mb-2">99.9% de temps<br>de fonctionnement</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.45);margin-bottom:10px">Tous les serveurs opérationnels</div>
            <div class="d-flex gap-3">
                <span style="font-size:10px;color:#48bb78"><i class="fas fa-circle mr-1" style="font-size:8px"></i>Serveur web</span>
                <span style="font-size:10px;color:#48bb78"><i class="fas fa-circle mr-1" style="font-size:8px"></i>Base de données</span>
            </div>
        </div>
    </div>
</div>
    <div class="col-md-4 mb-3">
        <div class="stat-card-dark">
            <div style="position:absolute;right:-10px;top:-10px;font-size:4rem;opacity:0.08"><i class="fas fa-globe"></i></div>
            <div class="stat-label-dark">Statut de la plateforme</div>
            <div class="stat-value-dark mb-2">99.9% de temps<br>de fonctionnement</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.45);margin-bottom:10px">Tous les serveurs opérationnels</div>
            <div class="d-flex gap-3">
                <span style="font-size:10px;color:#48bb78"><i class="fas fa-circle mr-1" style="font-size:8px"></i>Serveur web</span>
                <span style="font-size:10px;color:#48bb78"><i class="fas fa-circle mr-1" style="font-size:8px"></i>Base de données</span>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-7 mb-3">
        <div class="pro-card">
            <div class="pro-card-header">
                <div>
                    <div class="pro-card-title">Revenus mensuels</div>
                    <div style="font-size:11px;color:#a0aec0">Revenus réels vs projetés</div>
                </div>
                <div class="d-flex gap-2">
                    <div style="background:#e3f2fd;color:#0288d1;border-radius:6px;padding:4px 10px;font-size:11px;font-weight:500">Mensuel</div>
                    <div style="background:#f4f6f9;color:#718096;border-radius:6px;padding:4px 10px;font-size:11px;cursor:pointer">Annuel</div>
                </div>
            </div>
            <div style="padding:1.2rem">
                <canvas id="revenusChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-5 mb-3">
        <div class="pro-card h-100">
            <div class="pro-card-header">
                <div class="pro-card-title">Derniers inscrits</div>
                <span style="background:#fff3e0;color:#e65100;border-radius:6px;padding:3px 8px;font-size:10px;font-weight:600">{{ $totalClients + $totalOrganisateurs }} comptes</span>
            </div>
            <div style="padding:1rem">
                @forelse($recentsEvenements->take(2) as $e)
                <div style="border:0.5px solid #e0e7ef;border-radius:8px;padding:10px;margin-bottom:8px">
                    <div style="font-size:9px;color:#0288d1;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px">ÉVÉNEMENT</div>
                    <div style="font-size:12px;font-weight:500;color:#0f1824">{{ str_limit($e->titre, 30) }}</div>
                    <div style="font-size:11px;color:#a0aec0;margin-bottom:8px">{{ $e->organisateur ? $e->organisateur->nom : '-' }}</div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.evenements') }}" class="btn-primary-pro" style="padding:4px 10px;font-size:11px">Voir</a>
                        <form method="POST" action="{{ route('admin.evenements.delete', $e->id) }}" style="display:inline" onsubmit="return confirm('Supprimer ?')">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="action-btn action-delete" style="padding:4px 10px;font-size:11px">Signaler</button>
                        </form>
                    </div>
                </div>
                @empty
                <div style="text-align:center;color:#a0aec0;padding:1rem;font-size:13px">Aucun événement récent</div>
                @endforelse
                <div style="text-align:center;margin-top:8px">
                    <a href="{{ route('admin.evenements') }}" style="font-size:12px;color:#0288d1;font-weight:500;text-decoration:none">Voir toutes les demandes →</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="pro-card">
    <div class="pro-card-header">
        <div>
            <div class="pro-card-title">Gestion des comptes</div>
            <div style="font-size:11px;color:#a0aec0">Gérer les organisateurs et les clients</div>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <div style="display:flex;border:0.5px solid #e0e7ef;border-radius:8px;overflow:hidden">
                <a href="{{ route('admin.organisateurs') }}" style="background:#0288d1;color:#fff;padding:6px 14px;font-size:12px;cursor:pointer;font-weight:500;text-decoration:none">Organisateurs ({{ $totalOrganisateurs }})</a>
                <a href="{{ route('admin.clients') }}" style="background:#fff;color:#718096;padding:6px 14px;font-size:12px;cursor:pointer;text-decoration:none">Clients ({{ $totalClients }})</a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="pro-table">
            <thead>
                <tr>
                    <th>Organisateur</th>
                    <th>Statut</th>
                    <th>Événements actifs</th>
                    <th>Billets vendus</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentsEvenements as $e)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:32px;height:32px;border-radius:8px;background:#e3f2fd;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;color:#0288d1">
                                {{ $e->organisateur ? strtoupper(substr($e->organisateur->nom,0,2)) : 'NA' }}
                            </div>
                            <div>
                                <div style="font-size:12px;font-weight:500;color:#0f1824">{{ $e->organisateur ? $e->organisateur->nom : '-' }}</div>
                                <div style="font-size:11px;color:#a0aec0">{{ $e->organisateur ? $e->organisateur->email : '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge status-active">VÉRIFIÉ</span></td>
                    <td style="font-size:12px;font-weight:500">{{ $e->billets ? $e->billets->count() : 0 }} billets</td>
                    <td style="font-size:12px;font-weight:500">{{ number_format($e->prix, 0) }} DJF</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.evenements') }}" class="action-btn action-edit"><i class="fas fa-eye"></i></a>
                            <form method="POST" action="{{ route('admin.evenements.delete', $e->id) }}" style="display:inline" onsubmit="return confirm('Supprimer ?')">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="action-btn action-delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:2rem;color:#a0aec0">
                        <i class="fas fa-calendar fa-2x mb-2 d-block" style="color:#e0e7ef"></i>
                        Aucun événement trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:0.8rem 1.2rem;border-top:0.5px solid #f0f4f8;display:flex;justify-content:space-between;align-items:center">
        <span style="font-size:12px;color:#a0aec0">Total : {{ $totalEvenements }} événements · {{ $totalBillets }} billets · {{ $totalClients }} clients</span>
        <a href="{{ route('admin.evenements') }}" style="font-size:12px;color:#0288d1;font-weight:500;text-decoration:none">Voir tout →</a>
    </div>
</div>

@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
var moisLabels = ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'];
var data = [0,0,0,0,0,0,0,0,0,0,0,0];
@foreach($billetsParMois as $b)
    data[{{ $b->mois - 1 }}] = {{ $b->total }};
@endforeach
new Chart(document.getElementById('revenusChart'), {
    type: 'bar',
    data: {
        labels: moisLabels,
        datasets: [{
            label: 'Billets vendus',
            data: data,
            backgroundColor: function(context) {
                var index = context.dataIndex;
                var max = Math.max.apply(null, data);
                return data[index] === max ? '#0288d1' : '#bbdefb';
            },
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { grid: { color: '#f0f4f8' }, ticks: { color: '#a0aec0', font: { size: 10 } } },
            x: { grid: { display: false }, ticks: { color: '#a0aec0', font: { size: 10 } } }
        }
    }
});
</script>
@endsection
