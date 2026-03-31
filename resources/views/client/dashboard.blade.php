@extends('layouts.client')
@section('title','Mon Espace')
@section('page-title','Bienvenue 👋')
@section('page-subtitle','Votre prochain événement commence bientôt. Voici un aperçu de votre activité.')
@section('content')

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="stat-card">
            <div class="stat-label">Billets actifs</div>
            <div class="d-flex align-items-baseline gap-2 mb-1">
                <div class="stat-value">{{ $totalBillets }}</div>
                <span class="stat-badge-up ml-2">validés</span>
            </div>
            <div style="font-size:11px;color:#a0aec0">Billets valides en cours</div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card">
            <div class="stat-label">Événements disponibles</div>
            <div class="d-flex align-items-baseline gap-2 mb-1">
                <div class="stat-value">{{ $prochainEvenements }}</div>
                <span style="font-size:12px;color:#a0aec0" class="ml-2">à venir</span>
            </div>
            <div style="font-size:11px;color:#a0aec0">Concerts, sports, théâtre...</div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card-dark">
            <div style="position:absolute;right:-10px;top:-10px;font-size:4rem;opacity:0.08"><i class="fas fa-dollar-sign"></i></div>
            <div class="stat-label-dark">Dépenses totales</div>
            <div class="stat-value-dark">{{ number_format($totalDepenses, 0, '.', ' ') }} DJF</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.45);margin-top:6px">Total des achats confirmés</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-7 mb-4">
        <div class="pro-card">
            <div class="pro-card-header">
                <div class="pro-card-title">Mes billets récents</div>
                <a href="{{ route('client.billets') }}" style="font-size:12px;color:#0288d1;font-weight:500;text-decoration:none">Voir tout</a>
            </div>
            @forelse($mesBillets as $b)
            <div style="padding:10px 1.2rem;display:flex;align-items:center;gap:12px;border-bottom:0.5px solid #f0f4f8">
                <div style="width:42px;height:42px;background:#e3f2fd;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">
                    <i class="fas fa-ticket-alt" style="color:#0288d1;font-size:16px"></i>
                </div>
                <div style="flex:1">
                    <div style="font-size:13px;font-weight:500;color:#0f1824">{{ $b->evenement ? str_limit($b->evenement->titre, 30) : '-' }}</div>
                    <div style="font-size:11px;color:#a0aec0">
                        {{ $b->evenement && $b->evenement->date_evenement ? \Carbon\Carbon::parse($b->evenement->date_evenement)->format('d M Y') : '-' }}
                        @if($b->evenement && $b->evenement->lieu)
                        · {{ str_limit($b->evenement->lieu, 20) }}
                        @endif
                    </div>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <span class="status-badge {{ $b->statut == 'valide' ? 'status-valid' : ($b->statut == 'utilise' ? 'status-used' : 'status-cancelled') }}">
                        {{ ucfirst($b->statut) }}
                    </span>
                    <a href="{{ route('client.billet.show', $b->id) }}" class="btn-primary-pro" style="padding:5px 10px;font-size:11px">Détails</a>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:2.5rem;color:#a0aec0">
                <i class="fas fa-ticket-alt fa-2x mb-2 d-block" style="color:#e0e7ef"></i>
                <div style="font-size:13px">Vous n'avez pas encore de billet</div>
                <a href="{{ route('client.evenements') }}" class="btn-primary-pro mt-3" style="display:inline-flex">
                    <i class="fas fa-search"></i> Découvrir les événements
                </a>
            </div>
            @endforelse
        </div>
    </div>

    <div class="col-md-5 mb-4">
       @php $featured = $evenementsRecents->first(); @endphp
@if($featured)
<div style="background:#0f3460;border-radius:12px;overflow:hidden">
    <div style="padding:1rem 1.2rem;border-bottom:0.5px solid rgba(255,255,255,0.1)">
        <span style="background:rgba(251,191,36,0.2);color:#FBBF24;border-radius:6px;padding:3px 10px;font-size:11px;font-weight:600">À NE PAS MANQUER</span>
    </div>
    @if($featured->image)
<img src="{{ asset('uploads/events/' . $featured->image) }}" style="width:100%;height:140px;object-fit:cover">
@else
<div style="height:140px;background:linear-gradient(135deg,#0288d1,#0f3460);display:flex;align-items:center;justify-content:center;font-size:3rem">🎫</div>
@endif
            <div style="padding:1.2rem">
                <div style="font-size:1.1rem;font-weight:700;color:#fff;line-height:1.3;margin-bottom:8px">{{ str_limit($featured->titre, 40) }}</div>
                <div style="font-size:12px;color:rgba(255,255,255,0.55);margin-bottom:8px;line-height:1.5">{{ str_limit($featured->description ? $featured->description : 'Un événement à ne pas manquer à Djibouti.', 80) }}</div>
                <div style="font-size:11px;color:rgba(255,255,255,0.45);margin-bottom:1rem">
                    <i class="fas fa-map-marker-alt mr-1"></i>{{ $featured->lieu ? str_limit($featured->lieu, 25) : '-' }}
                    · {{ $featured->date_evenement ? \Carbon\Carbon::parse($featured->date_evenement)->format('d M Y') : '-' }}
                </div>
                <div style="font-size:1rem;font-weight:700;color:#FBBF24;margin-bottom:1rem">
                    {{ $featured->prix == 0 ? 'Gratuit' : number_format($featured->prix, 0).' DJF' }}
                </div>
                <a href="{{ route('client.evenement.show', $featured->id) }}" style="background:#fff;border-radius:8px;padding:10px;text-align:center;font-size:13px;font-weight:600;color:#0288d1;cursor:pointer;text-decoration:none;display:block">
                    Découvrir l'événement →
                </a>
            </div>
        </div>
        @endif

        <div class="pro-card mt-3">
            <div class="pro-card-header">
                <div class="pro-card-title">Événements à venir</div>
                <a href="{{ route('client.evenements') }}" style="font-size:11px;color:#0288d1;text-decoration:none">Voir tout</a>
            </div>
           @foreach($evenementsRecents->slice(1, 3) as $e)
            <a href="{{ route('client.evenement.show', $e->id) }}" style="padding:10px 1.2rem;display:flex;align-items:center;gap:10px;border-bottom:0.5px solid #f0f4f8;text-decoration:none">
                <div style="width:36px;height:36px;background:#e3f2fd;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0">
                    <i class="fas fa-calendar-alt" style="color:#0288d1;font-size:13px"></i>
                </div>
                <div style="flex:1">
                    <div style="font-size:12px;font-weight:500;color:#0f1824">{{ str_limit($e->titre, 25) }}</div>
                    <div style="font-size:11px;color:#a0aec0">{{ $e->date_evenement ? \Carbon\Carbon::parse($e->date_evenement)->format('d M Y') : '-' }}</div>
                </div>
                <span style="background:#e3f2fd;color:#0288d1;border-radius:6px;padding:3px 8px;font-size:11px;font-weight:600;white-space:nowrap">
                    {{ $e->prix == 0 ? 'Gratuit' : number_format($e->prix, 0).' DJF' }}
                </span>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
