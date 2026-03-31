@extends('layouts.admin')
@section('title','Catégories')
@section('page-title','Gestion des Catégories')
@section('content')

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="pro-card">
            <div class="pro-card-header">
                <div class="pro-card-title">Ajouter une catégorie</div>
            </div>
            <div style="padding:1.2rem">
                @if($errors->any())
                    <div class="alert alert-danger py-2">
                        @foreach($errors->all() as $err)
                            <div>{{ $err }}</div>
                        @endforeach
                    </div>
                @endif
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label>Nom de la catégorie</label>
                        <input type="text" name="nom" class="form-control" placeholder="Ex: Concert" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Description..."></textarea>
                    </div>
                    <button type="submit" class="btn-primary-pro" style="width:100%;justify-content:center;padding:10px">
                        <i class="fas fa-plus mr-2"></i>Ajouter
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8 mb-4">
        <div class="pro-card">
            <div class="pro-card-header">
                <div class="pro-card-title">Liste des catégories ({{ $categories->count() }})</div>
            </div>
            <div class="table-responsive">
                <table class="pro-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Événements</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                        <tr>
                            <td>{{ $cat->id }}</td>
                            <td><span style="font-weight:500;color:#0f1824">{{ $cat->nom }}</span></td>
                            <td style="color:#a0aec0">{{ $cat->description ? str_limit($cat->description, 40) : '-' }}</td>
                            <td><span style="background:#e3f2fd;color:#0288d1;border-radius:6px;padding:3px 10px;font-size:11px;font-weight:500">{{ $cat->evenements_count }}</span></td>
                            <td>
                                <form method="POST" action="{{ route('admin.categories.delete', $cat->id) }}" style="display:inline" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="action-btn action-delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align:center;padding:2rem;color:#a0aec0">
                                <i class="fas fa-tags fa-2x mb-2 d-block" style="color:#e0e7ef"></i>
                                Aucune catégorie trouvée
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
