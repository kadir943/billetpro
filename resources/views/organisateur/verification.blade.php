@extends('layouts.organisateur')
@section('title','Vérification QR Code')
@section('page-title','Vérification des Billets')
@section('page-subtitle','Scanner ou saisir le numéro de billet pour vérifier l\'accès')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-dark text-white"><i class="fas fa-qrcode mr-2"></i>Vérifier un billet</div>
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-qrcode" style="font-size:5rem;color:#6C3DF4;opacity:0.7"></i>
                </div>
                <h5 class="font-weight-bold mb-4">Saisir le numéro du billet</h5>
                <form method="POST" action="{{ route('organisateur.verification.post') }}">
                    @csrf
                    <div class="input-group mb-4" style="max-width:400px;margin:0 auto">
                        <input type="text" name="code_qr" class="form-control form-control-lg text-center"
                            placeholder="Ex: BIL-20240101-XXXXXXXX"
                            style="border-radius:10px 0 0 10px;border:2px solid #6C3DF4;font-family:monospace"
                            required autofocus>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary" style="border-radius:0 10px 10px 0;padding:0 1.5rem">
                                <i class="fas fa-search mr-2"></i>Vérifier
                            </button>
                        </div>
                    </div>
                </form>
                <p class="text-muted small mt-3">
                    <i class="fas fa-info-circle mr-1"></i>
                    Saisissez le numéro de billet tel qu'il apparaît sur le billet électronique du participant.
                </p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h6 class="font-weight-bold">Valide</h6>
                    <small class="text-muted">Billet authentique, accès autorisé</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                    <h6 class="font-weight-bold">Invalide</h6>
                    <small class="text-muted">Billet introuvable ou annulé</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <i class="fas fa-ban fa-2x text-warning mb-2"></i>
                    <h6 class="font-weight-bold">Déjà utilisé</h6>
                    <small class="text-muted">Ce billet a déjà servi à entrer</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
