@extends('layouts.app')
@section('title','Inscription Organisateur')
@section('styles')
<style>
body{background:linear-gradient(135deg,#1a1a2e,#16213e);min-height:100vh;display:flex;align-items:center;padding:2rem 0}
.register-card{border-radius:20px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.4)}
.register-left{background:linear-gradient(135deg,#0288d1,#0077b6);padding:3rem;color:#fff;text-align:center;display:flex;flex-direction:column;justify-content:center}
.register-right{background:#fff;padding:2.5rem}
.form-control{border-radius:10px;border:2px solid #eee;padding:0.7rem 1rem}
.form-control:focus{border-color:#0288d1;box-shadow:none}
.btn-register{background:linear-gradient(135deg,#0288d1,#0077b6);color:#fff;border:none;border-radius:10px;padding:0.9rem;font-weight:700;width:100%}
.btn-register:hover{opacity:0.9;color:#fff}
.section-title{font-size:0.75rem;font-weight:700;color:#0288d1;text-transform:uppercase;letter-spacing:1px;margin:1rem 0 0.5rem;padding-bottom:5px;border-bottom:2px solid #e3f2fd}
.required{color:#e53e3e}
</style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-10">
            <div class="register-card">
                <div class="row no-gutters">
                    <div class="col-md-4 register-left">
                        <i class="fas fa-calendar-plus" style="font-size:3.5rem;margin-bottom:1rem"></i>
                        <h3 class="font-weight-bold">Devenir Organisateur</h3>
                        <p style="opacity:0.85;margin-bottom:1.5rem">Créez votre compte professionnel et publiez vos événements sur BilletPro.</p>
                        <hr style="border-color:rgba(255,255,255,0.3)">
                        <div style="background:rgba(255,255,255,0.15);border-radius:10px;padding:1rem;text-align:left;margin-bottom:1rem">
                            <p class="small mb-1"><i class="fas fa-check mr-2"></i>Vérification sous 24h</p>
                            <p class="small mb-1"><i class="fas fa-check mr-2"></i>Pièce d'identité requise</p>
                            <p class="small mb-1"><i class="fas fa-check mr-2"></i>Compte activé par l'admin</p>
                            <p class="small mb-0"><i class="fas fa-check mr-2"></i>Support dédié</p>
                        </div>
                        <p class="small" style="opacity:0.8">Déjà un compte ?</p>
                        <a href="{{ route('organisateur.login') }}" class="btn btn-light btn-sm rounded-pill font-weight-bold">Se connecter</a>
                    </div>
                    <div class="col-md-8 register-right">
                        <h4 class="font-weight-bold mb-1">Créer un compte Organisateur</h4>
                        <p class="text-muted small mb-3">Remplissez tous les champs. Votre dossier sera examiné par notre équipe.</p>
                        @if($errors->any())
                            <div class="alert alert-danger py-2">
                                <ul class="mb-0 pl-3">
                                    @foreach($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('organisateur.register.post') }}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="section-title"><i class="fas fa-user mr-2"></i>Informations personnelles</div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold">Nom complet <span class="required">*</span></label>
                                    <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" placeholder="Votre nom complet" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold">Téléphone personnel</label>
                                    <input type="text" name="telephone" class="form-control" value="{{ old('telephone') }}" placeholder="+253 77 00 00 00">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold">Email <span class="required">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="votre@email.com" required>
                            </div>

                            <div class="section-title"><i class="fas fa-building mr-2"></i>Informations de l'organisation</div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold">Nom de l'organisation <span class="required">*</span></label>
                                    <input type="text" name="nom_organisation" class="form-control" value="{{ old('nom_organisation') }}" placeholder="Ex: Events Djibouti" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold">Type d'organisation <span class="required">*</span></label>
                                    <select name="type_organisation" class="form-control" required>
                                        <option value="">-- Choisir --</option>
                                        <option value="entreprise" {{ old('type_organisation') == 'entreprise' ? 'selected' : '' }}>Entreprise</option>
                                        <option value="association" {{ old('type_organisation') == 'association' ? 'selected' : '' }}>Association</option>
                                        <option value="particulier" {{ old('type_organisation') == 'particulier' ? 'selected' : '' }}>Particulier</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold">Téléphone professionnel <span class="required">*</span></label>
                                    <input type="text" name="telephone_pro" class="form-control" value="{{ old('telephone_pro') }}" placeholder="+253 77 00 00 00" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold">Numéro IFU (Identifiant Fiscal)</label>
                                    <input type="text" name="numero_ifu" class="form-control" value="{{ old('numero_ifu') }}" placeholder="Numéro IFU">
                                </div>
                            </div>

                            <div class="section-title"><i class="fas fa-id-card mr-2"></i>Pièce d'identité</div>
                            <div class="form-group">
                                <label class="small font-weight-bold">Photo CIN ou Passeport <span class="required">*</span></label>
                                <div class="custom-file">
                                    <input type="file" name="photo_identite" class="custom-file-input" id="photoId" accept="image/*,.pdf" required>
                                    <label class="custom-file-label" for="photoId">Choisir un fichier...</label>
                                </div>
                                <small class="text-muted"><i class="fas fa-lock mr-1"></i>Document confidentiel — utilisé uniquement pour la vérification de votre identité</small>
                            </div>

                            <div class="section-title"><i class="fas fa-lock mr-2"></i>Sécurité</div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold">Mot de passe <span class="required">*</span></label>
                                    <input type="password" name="mot_de_passe" class="form-control" placeholder="Minimum 6 caractères" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="small font-weight-bold">Confirmer <span class="required">*</span></label>
                                    <input type="password" name="mot_de_passe_confirmation" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="conditions" required>
                                <label class="form-check-label small" for="conditions">
                                    J'accepte les <a href="#" style="color:#0288d1">conditions d'utilisation</a> et confirme que les informations fournies sont exactes.
                                </label>
                            </div>

                            <button type="submit" class="btn-register">
                                <i class="fas fa-paper-plane mr-2"></i>Soumettre ma demande
                            </button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="{{ route('home') }}" class="text-muted small"><i class="fas fa-arrow-left mr-1"></i>Retour à l'accueil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
document.getElementById('photoId').addEventListener('change', function(e) {
    if (e.target.files[0]) {
        document.querySelector('.custom-file-label').textContent = e.target.files[0].name;
    }
});
</script>
@endsection