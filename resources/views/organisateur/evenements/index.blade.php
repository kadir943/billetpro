@extends('layouts.organisateur')
@section('title','Mes Événements')
@section('page-title','Mes Événements')
@section('page-subtitle','Gérez vos événements publiés')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="{{ route('organisateur.evenements.create') }}" class="btn btn-primary rounded-pill">
        <i class="fas fa-plus mr-2"></i>Créer un événement
    </a>
</div>
<div class="card">
    <div class="card-header bg-dark text-white"><i class="fas fa-calendar-alt mr-2"></i>Mes événements ({{ $evenements->total() }})</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr><th>Titre</th><th>Catégorie</th><th>Date</th><th>Lieu</th><th>Prix</th><th>Places</th><th>Billets</th><th>Statut</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($evenements as $e)
                    <tr>
                        <td><div class="font-weight-bold">{{ str_limit($e->titre, 28) }}</div></td>
                        <td>{{ $e->categorie ? $e->categorie->nom : '-' }}</td>
                        <td class="small">{{ $e->date_evenement ? \Carbon\Carbon::parse($e->date_evenement)->format('d/m/Y H:i') : '-' }}</td>
                        <td class="small">{{ str_limit($e->lieu ? $e->lieu : '-', 20) }}</td>
                        <td>{{ number_format($e->prix, 0) }} DJF</td>
                        <td>
                            <span class="badge badge-{{ $e->places_disponibles > 0 ? 'success' : 'danger' }}">
                                {{ $e->places_disponibles }}/{{ $e->capacite }}
                            </span>
                        </td>
                        <td><span class="badge badge-primary">{{ $e->billets_count }}</span></td>
                        <td>
                            <span class="badge badge-{{ $e->statut == 'actif' ? 'success' : ($e->statut == 'annule' ? 'danger' : 'secondary') }}">
                                {{ ucfirst($e->statut) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('organisateur.evenements.edit', $e->id) }}" class="btn btn-sm btn-outline-primary mr-1"><i class="fas fa-edit"></i></a>
                          <form method="POST" action="{{ route('organisateur.evenements.supprimer', $e->id) }}" style="display:inline" onsubmit="return confirm('Supprimer cet événement ?')">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
</form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <i class="fas fa-calendar-plus fa-3x text-muted mb-3 d-block"></i>
                            <p class="text-muted">Vous n'avez pas encore créé d'événement.</p>
                            <a href="{{ route('organisateur.evenements.create') }}" class="btn btn-primary btn-sm rounded-pill">Créer mon premier événement</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">{{ $evenements->links() }}</div>
</div>
@endsection
