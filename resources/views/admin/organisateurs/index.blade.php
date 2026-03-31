@extends('layouts.admin')
@section('title','Organisateurs')
@section('page-title','Gestion des Organisateurs')
@section('content')
<div class="pro-card">
    <div class="pro-card-header">
        <div class="pro-card-title"><i class="fas fa-user-tie mr-2" style="color:#0288d1"></i>Organisateurs inscrits ({{ $organisateurs->total() }})</div>
    </div>
    <div class="table-responsive">
        <table class="pro-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Organisateur</th>
                    <th>Organisation</th>
                    <th>Type</th>
                    <th>Contact</th>
                    <th>IFU</th>
                    <th>Pièce d'identité</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($organisateurs as $o)
                <tr>
                    <td>{{ $o->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:32px;height:32px;border-radius:50%;background:#0288d1;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.8rem">{{ strtoupper(substr($o->nom,0,1)) }}</div>
                            <div>
                                <div style="font-size:12px;font-weight:500;color:#0f1824">{{ $o->nom }}</div>
                                <div style="font-size:11px;color:#a0aec0">{{ $o->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:12px">{{ $o->nom_organisation ? $o->nom_organisation : '-' }}</td>
                    <td>
                        @if($o->type_organisation)
                            <span class="status-badge" style="background:#e3f2fd;color:#0288d1">{{ ucfirst($o->type_organisation) }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td style="font-size:11px">
                        <div>{{ $o->telephone ? $o->telephone : '-' }}</div>
                        <div style="color:#0288d1">{{ $o->telephone_pro ? $o->telephone_pro : '-' }}</div>
                    </td>
                    <td style="font-size:11px">{{ $o->numero_ifu ? $o->numero_ifu : '-' }}</td>
                    <td>
                        @if($o->photo_identite)
                            <a href="{{ asset('uploads/identites/' . $o->photo_identite) }}" target="_blank" class="btn-secondary-pro" style="padding:4px 10px;font-size:11px">
                                <i class="fas fa-id-card mr-1"></i>Voir
                            </a>
                        @else
                            <span class="text-muted small">Non fournie</span>
                        @endif
                    </td>
                    <td>
                        @if($o->statut == 'en_attente')
                            <span class="status-badge status-pending">En attente</span>
                        @elseif($o->statut == 'approuve')
                            <span class="status-badge status-active">Approuvé</span>
                        @else
                            <span class="status-badge status-cancelled">Refusé</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            @if($o->statut == 'en_attente')
                            <form method="POST" action="{{ route('admin.organisateurs.approuver', $o->id) }}" style="display:inline">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="action-btn" style="background:#e8f5e9;color:#2e7d32" onclick="return confirm('Approuver cet organisateur ?')">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endif
                            <form method="POST" action="{{ route('admin.organisateurs.delete', $o->id) }}" style="display:inline" onsubmit="return confirm('Supprimer cet organisateur ?')">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="action-btn action-delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:2rem;color:#a0aec0">Aucun organisateur inscrit.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:0.8rem 1.2rem;border-top:0.5px solid #f0f4f8">{{ $organisateurs->links() }}</div>
</div>
@endsection
