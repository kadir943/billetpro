@extends('layouts.admin')
@section('title','Clients')
@section('page-title','Gestion des Clients')
@section('page-subtitle','Liste de tous les clients inscrits')
@section('content')
<div class="card">
    <div class="card-header bg-dark text-white">
        <i class="fas fa-users mr-2"></i>Clients inscrits ({{ $clients->total() }})
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>#</th><th>Nom</th><th>Email</th><th>Téléphone</th><th>Billets</th><th>Inscrit le</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse($clients as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div style="width:32px;height:32px;border-radius:50%;background:#6C3DF4;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.8rem;margin-right:8px">{{ strtoupper(substr($c->nom,0,1)) }}</div>
                                {{ $c->nom }}
                            </div>
                        </td>
                        <td>{{ $c->email }}</td>
                        <td>{{ $c->telephone ? $c->telephone : '-' }}</td>
                        <td><span class="badge badge-primary">{{ $c->billets_count }}</span></td>
                        <td class="small text-muted">{{ $c->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($c->statut == 'en_attente')
<form method="POST" action="{{ route('admin.clients.approuver', $c->id) }}" style="display:inline">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button type="submit" class="btn btn-sm btn-success mr-1"><i class="fas fa-check"></i></button>
</form>
@endif
                           <form method="POST" action="{{ route('admin.clients.delete', $c->id) }}" onsubmit="return confirm('Supprimer ce client ?')">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="DELETE">
    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
</form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Aucun client inscrit.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">{{ $clients->links() }}</div>
</div>
@endsection
