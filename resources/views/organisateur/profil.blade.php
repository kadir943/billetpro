@extends('layouts.organisateur')
@section('title','Mon Profil')
@section('page-title','Mon Profil')
@section('page-subtitle','Gérez vos informations personnelles')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="pro-card">
            <div class="pro-card-header">
                <div class="pro-card-title"><i class="fas fa-user-cog mr-2" style="color:#0288d1"></i>Modifier mon profil</div>
            </div>
            <div class="pro-card-body">
                <div class="text-center mb-4">
                    <div style="position:relative;display:inline-block">
                        @if($organisateur->photo)
                            <img id="photoPreview" src="{{ asset('uploads/profils/' . $organisateur->photo) }}"
                                 style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid #0288d1">
                        @else
                            <div id="photoPlaceholder" style="width:90px;height:90px;border-radius:50%;background:#0288d1;color:#fff;display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:600;margin:0 auto;border:3px solid #e3f2fd">
                                {{ strtoupper(substr($organisateur->nom, 0, 1)) }}
                            </div>
                        @endif
                        <label for="photoInput" style="position:absolute;bottom:0;right:0;width:28px;height:28px;background:#0288d1;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;border:2px solid #fff">
                            <i class="fas fa-camera" style="color:#fff;font-size:11px"></i>
                        </label>
                        <input type="file" id="photoInput" accept="image/*" style="display:none">
                    </div>
                    <h5 class="mt-3 font-weight-bold" style="color:#0f1824">{{ $organisateur->nom }}</h5>
                    <span style="background:#e3f2fd;color:#0288d1;border-radius:20px;padding:3px 14px;font-size:12px;font-weight:500">Organisateur</span>
                    <div style="font-size:11px;color:#a0aec0;margin-top:4px">Membre depuis {{ $organisateur->created_at->format('d/m/Y') }}</div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 pl-3">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('organisateur.profil.update') }}" enctype="multipart/form-data" id="profilForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="file" name="photo" id="photoFormInput" style="display:none" accept="image/*">

                    <div class="form-group">
                        <label>Nom complet</label>
                        <input type="text" name="nom" class="form-control" value="{{ old('nom', $organisateur->nom) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $organisateur->email) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Téléphone</label>
                        <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $organisateur->telephone) }}">
                    </div>
                    <hr>
                    <p class="small text-muted">Laissez vide pour ne pas changer le mot de passe</p>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Nouveau mot de passe</label>
                            <input type="password" name="mot_de_passe" class="form-control" placeholder="Minimum 6 caractères">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Confirmer</label>
                            <input type="password" name="mot_de_passe_confirmation" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn-primary-pro" style="width:100%;justify-content:center;padding:10px">
                        <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
document.getElementById('photoInput').addEventListener('change', function() {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var placeholder = document.getElementById('photoPlaceholder');
            var preview = document.getElementById('photoPreview');
            if (placeholder) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.id = 'photoPreview';
                img.style = 'width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid #0288d1';
                placeholder.parentNode.replaceChild(img, placeholder);
            } else if (preview) {
                preview.src = e.target.result;
            }
        }
        reader.readAsDataURL(this.files[0]);
        var formInput = document.getElementById('photoFormInput');
        var dt = new DataTransfer();
        dt.items.add(this.files[0]);
        formInput.files = dt.files;
    }
});
</script>
@endsection
