@extends('layouts.organisateur')
@section('title','Créer un Événement')
@section('page-title','Créer un Événement')
@section('page-subtitle','Remplissez le formulaire pour publier un nouvel événement')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-dark text-white"><i class="fas fa-plus-circle mr-2"></i>Nouvel événement</div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 pl-3">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('organisateur.evenements.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="small font-weight-bold">Titre de l'événement <span class="text-danger">*</span></label>
                        <input type="text" name="titre" class="form-control" value="{{ old('titre') }}" placeholder="Ex: Concert de Jazz à Djibouti" required>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Description</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Décrivez votre événement...">{{ old('description') }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Date et heure <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="date_evenement" class="form-control" value="{{ old('date_evenement') }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Lieu <span class="text-danger">*</span></label>
                            <input type="text" name="lieu" class="form-control" value="{{ old('lieu') }}" placeholder="Ex: Palais du Peuple, Djibouti" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Prix du billet (DJF) <span class="text-danger">*</span></label>
                            <input type="number" name="prix" class="form-control" value="{{ old('prix', 0) }}" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Capacité totale <span class="text-danger">*</span></label>
                            <input type="number" name="capacite" class="form-control" value="{{ old('capacite') }}" min="1" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Catégorie</label>
                            <select name="categorie_id" class="form-control">
                                <option value="">-- Choisir --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('categorie_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Image de l'événement</label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="imageFile" accept="image/*">
                            <label class="custom-file-label" for="imageFile">Choisir une image...</label>
                        </div>
                        <small class="text-muted">Formats acceptés : JPG, PNG, WEBP (max 2MB)</small>
                    </div>
                    <div id="previewDiv" class="mb-3" style="display:none">
                        <img id="imagePreview" src="" class="img-thumbnail" style="max-height:200px">
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('organisateur.evenements') }}" class="btn btn-outline-secondary rounded-pill">
                            <i class="fas fa-arrow-left mr-2"></i>Retour
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-check mr-2"></i>Publier l'événement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
document.getElementById('imageFile').addEventListener('change', function(e) {
    if (e.target.files[0]) {
        document.getElementById('imagePreview').src = URL.createObjectURL(e.target.files[0]);
        document.getElementById('previewDiv').style.display = 'block';
        document.querySelector('.custom-file-label').textContent = e.target.files[0].name;
    }
});
</script>
@endsection