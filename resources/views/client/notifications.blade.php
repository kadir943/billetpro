@extends('layouts.client')
@section('title','Notifications')
@section('page-title','Mes Notifications')
@section('page-subtitle','Vos alertes et confirmations')
@section('content')
<div class="card">
    <div class="card-header bg-dark text-white">
        <i class="fas fa-bell mr-2"></i>Notifications ({{ $notifications->total() }})
    </div>
    <div class="card-body p-0">
        @forelse($notifications as $n)
        <div class="d-flex align-items-start p-3 border-bottom {{ $n->statut == 'non_lu' ? '' : 'bg-light' }}">
            <div class="mr-3 mt-1" style="width:40px;height:40px;border-radius:50%;background:{{ $n->statut == 'non_lu' ? 'linear-gradient(135deg,#F97316,#FBBF24)' : '#e9ecef' }};display:flex;align-items:center;justify-content:center;color:{{ $n->statut == 'non_lu' ? '#fff' : '#6c757d' }};flex-shrink:0">
                <i class="fas fa-bell"></i>
            </div>
            <div class="flex-grow-1">
                <p class="mb-1 {{ $n->statut == 'non_lu' ? 'font-weight-bold' : 'text-muted' }}">{{ $n->message }}</p>
                <small class="text-muted"><i class="fas fa-clock mr-1"></i>{{ $n->date_envoi ? \Carbon\Carbon::parse($n->date_envoi)->diffForHumans() : $n->created_at->diffForHumans() }}</small>
            </div>
            @if($n->statut == 'non_lu')
            <span class="badge badge-warning ml-2" style="font-size:0.65rem">Nouveau</span>
            @endif
        </div>
        @empty
        <div class="text-center py-5">
            <i class="fas fa-bell-slash fa-3x text-muted mb-3 d-block"></i>
            <h5 class="text-muted">Aucune notification</h5>
            <p class="text-muted small">Vous serez notifié lors de vos achats de billets.</p>
        </div>
        @endforelse
    </div>
    @if($notifications->total() > 0)
    <div class="card-footer">{{ $notifications->links() }}</div>
    @endif
</div>
@endsection
