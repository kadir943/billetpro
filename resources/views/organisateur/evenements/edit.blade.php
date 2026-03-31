@extends('layouts.organisateur')
@section('title','Modifier l\'Événement')
@section('page-title','Modifier l\'Événement')
@section('page-subtitle','Modifiez les informations de votre événement')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-dark text-white"><i class="fas fa-edit mr-2"></i>Modifier l'événement</div>
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
                <form method="POST" action="{{ route('organisateur.evenements.update', $evenement->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="small font-weight-bold">Titre <span class="text-danger">*</span></label>
                        <input type="text" name="titre" class="form-control" value="{{ old('titre', $evenement->titre) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Description</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $evenement->description) }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Date et heure <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="date_evenement" class="form-control"
                                value="{{ old('date_evenement', $evenement->date_evenement ? \Carbon\Carbon::parse($evenement->date_evenement)->format('Y-m-d\TH:i') : '') }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Lieu <span class="text-danger">*</span></label>
                            <input type="text" name="lieu" class="form-control" value="{{ old('lieu', $evenement->lieu) }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label class="small font-weight-bold">Prix (DJF) <span class="text-danger">*</span></label>
                            <input type="number" name="prix" class="form-control" value="{{ old('prix', $evenement->prix) }}" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="small font-weight-bold">Capacité <span class="text-danger">*</span></label>
                            <input type="number" name="capacite" class="form-control" value="{{ old('capacite', $evenement->capacite) }}" min="1" required>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="small font-weight-bold">Catégorie</label>
                            <select name="categorie_id" class="form-control">
                                <option value="">-- Choisir --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('categorie_id', $evenement->categorie_id) == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="small font-weight-bold">Statut</label>
                            <select name="statut" class="form-control">
                                <option value="actif" {{ $evenement->statut == 'actif' ? 'selected' : '' }}>Actif</option>
                                <option value="annule" {{ $evenement->statut == 'annule' ? 'selected' : '' }}>Annulé</option>
                                <option value="termine" {{ $evenement->statut == 'termine' ? 'selected' : '' }}>Terminé</option>
                            </select>
                        </div>
                    </div>
                    @if($evenement->image)
                    <div class="form-group">
                        <label class="small font-weight-bold">Image actuelle</label>
                        <div><img src="{{ asset('uploads/events/' . $evenement->image) }}" class="img-thumbnail" style="max-height:150px"></div>
                    </div>
                    @endif
                    <div class="form-group">
                        <label class="small font-weight-bold">Nouvelle image (optionnel)</label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="imageFile" accept="image/*">
                            <label class="custom-file-label" for="imageFile">Choisir une image...</label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('organisateur.evenements') }}" class="btn btn-outline-secondary rounded-pill"><i class="fas fa-arrow-left mr-2"></i>Retour</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="fas fa-save mr-2"></i>Enregistrer</button>
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
        document.querySelector('.custom-file-label').textContent = e.target.files[0].name;
    }
});
</script>
@endsection
