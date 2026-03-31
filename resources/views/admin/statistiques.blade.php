@extends('layouts.admin')
@section('title','Statistiques')
@section('page-title','Statistiques Globales')
@section('page-subtitle','Vue analytique de la plateforme')
@section('content')
<div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#6C3DF4,#9B6FF8)">
            <div class="bg-icon"><i class="fas fa-users"></i></div>
            <div class="value">{{ $totalClients }}</div>
            <div class="small">Clients inscrits</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#17a2b8,#20c997)">
            <div class="bg-icon"><i class="fas fa-calendar"></i></div>
            <div class="value">{{ $totalEvenements }}</div>
            <div class="small">Événements créés</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#F97316,#FBBF24)">
            <div class="bg-icon"><i class="fas fa-ticket-alt"></i></div>
            <div class="value">{{ $totalBillets }}</div>
            <div class="small">Billets vendus</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#28a745,#20c997)">
            <div class="bg-icon"><i class="fas fa-dollar-sign"></i></div>
            <div class="value">{{ number_format($totalRevenu, 0, '.', ' ') }}</div>
            <div class="small">Revenu total (DJF)</div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-7 mb-4">
        <div class="card">
            <div class="card-header bg-dark text-white"><i class="fas fa-chart-line mr-2"></i>Billets vendus par mois ({{ date('Y') }})</div>
            <div class="card-body">
                <canvas id="billetsChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-5 mb-4">
        <div class="card">
            <div class="card-header bg-dark text-white"><i class="fas fa-trophy mr-2"></i>Top 5 événements</div>
            <div class="card-body p-0">
                @forelse($topEvenements as $i => $e)
                <div class="d-flex align-items-center p-3 border-bottom">
                    <div class="mr-3" style="width:30px;height:30px;border-radius:50%;background:{{ ['#6C3DF4','#F97316','#17a2b8','#28a745','#ffc107'][$i] }};color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:0.85rem">{{ $i+1 }}</div>
                    <div class="flex-grow-1">
                        <div class="font-weight-bold small">{{ str_limit($e->titre, 28) }}</div>
                        <div class="progress mt-1" style="height:5px">
                            @php $max = $topEvenements->first()->billets_count; @endphp
                            <div class="progress-bar" style="width:{{ $max > 0 ? ($e->billets_count / $max * 100) : 0 }}%;background:{{ ['#6C3DF4','#F97316','#17a2b8','#28a745','#ffc107'][$i] }}"></div>
                        </div>
                    </div>
                    <span class="badge badge-primary ml-2">{{ $e->billets_count }}</span>
                </div>
                @empty
                <div class="text-center py-4 text-muted">Aucune donnée.</div>
                @endforelse
            </div>
        </div>
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
new Chart(document.getElementById('billetsChart'), {
    type: 'bar',
    data: {
        labels: moisLabels,
        datasets: [{
            label: 'Billets vendus',
            data: data,
            backgroundColor: 'rgba(108,61,244,0.7)',
            borderColor: '#6C3DF4',
            borderWidth: 2,
            borderRadius: 6
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
});
</script>
@endsection
