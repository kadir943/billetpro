@extends('layouts.admin')
@section('title','Événements')
@section('page-title','Gestion des Événements')
@section('page-subtitle','Tous les événements publiés sur la plateforme')
@section('content')
<div class="card">
    <div class="card-header bg-dark text-white">
        <i class="fas fa-calendar-check mr-2"></i>Événements ({{ $evenements->total() }})
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr><th>#</th><th>Titre</th><th>Organisateur</th><th>Catégorie</th><th>Date</th><th>Prix</th><th>Places</th><th>Statut</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($evenements as $e)
                    <tr>
                        <td>{{ $e->id }}</td>
                        <td>
                            <div class="font-weight-bold">{{ str_limit($e->titre, 30) }}</div>
                            <small class="text-muted"><i class="fas fa-map-marker-alt mr-1"></i>{{ str_limit($e->lieu ? $e->lieu : '-', 25) }}</small>
                        </td>
                        <td>{{ $e->organisateur ? $e->organisateur->nom : '-' }}</td>
                        <td>
                            @if($e->categorie)
                                <span class="badge badge-secondary">{{ $e->categorie->nom }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="small">{{ $e->date_evenement ? \Carbon\Carbon::parse($e->date_evenement)->format('d/m/Y H:i') : '-' }}</td>
                        <td>{{ number_format($e->prix, 0, '.', ' ') }} DJF</td>
                        <td>
                            <span class="badge badge-{{ $e->places_disponibles > 0 ? 'success' : 'danger' }}">
                                {{ $e->places_disponibles }}/{{ $e->capacite }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $e->statut == 'actif' ? 'success' : ($e->statut == 'annule' ? 'danger' : 'secondary') }}">
                                {{ ucfirst($e->statut) }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.evenements.delete', $e->id) }}" onsubmit="return confirm('Supprimer cet événement ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center py-4 text-muted">Aucun événement trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">{{ $evenements->links() }}</div>
</div>
@endsection
