@extends('layouts.client')
@section('title','Mon Billet')
@section('page-title','Mon Billet')
@section('page-subtitle','Votre billet électronique')
@section('styles')
<style>
.ticket-wrapper{max-width:750px;margin:0 auto}
.ticket-container{background:#0a0a0a;border-radius:16px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.5)}
.ticket-header{padding:1rem 1.5rem;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,0.08)}
.ticket-hero-row{display:grid;grid-template-columns:1fr 1fr;gap:0}
.ticket-hero-left{padding:1.5rem;background:#0a0a0a}
.ticket-image-right{position:relative;height:220px;overflow:hidden}
.ticket-label{text-align:center;padding:0.7rem 0;letter-spacing:8px;font-size:11px;color:rgba(255,255,255,0.25);font-weight:600;border-top:1px solid rgba(255,255,255,0.06);border-bottom:1px solid rgba(255,255,255,0.06)}
.ticket-card{background:#111;border-top:1px solid rgba(255,255,255,0.08)}
.ticket-fields-row{display:grid;grid-template-columns:repeat(4,1fr);border-bottom:1px dashed rgba(255,255,255,0.08)}
.ticket-fields-row-2{display:grid;grid-template-columns:2fr 1fr 1fr;border-bottom:1px dashed rgba(255,255,255,0.08)}
.ticket-cell{padding:0.9rem 1rem}
.ticket-cell-border{border-right:1px dashed rgba(255,255,255,0.08)}
.ticket-field-label{font-size:8px;color:rgba(255,255,255,0.35);letter-spacing:1.5px;margin-bottom:5px;text-transform:uppercase}
.ticket-field-value{font-size:13px;font-weight:600;color:#fff}
.ticket-bottom{display:grid;grid-template-columns:1fr auto;border-top:1px dashed rgba(255,255,255,0.08)}
.ticket-info-left{padding:1.2rem 1.5rem}
.ticket-qr-right{padding:1.2rem;display:flex;flex-direction:column;align-items:center;justify-content:center;border-left:1px dashed rgba(255,255,255,0.08);background:#0f0f0f;min-width:160px}
.ticket-actions{padding:1.2rem 1.5rem;border-top:1px solid rgba(255,255,255,0.06);display:flex;gap:10px}
.btn-ticket-primary{background:#0288d1;color:#fff;border:none;border-radius:8px;padding:10px 20px;font-weight:700;font-size:12px;cursor:pointer;letter-spacing:1px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;flex:1;justify-content:center}
.btn-ticket-primary:hover{background:#0077b6;color:#fff;text-decoration:none}
.btn-ticket-secondary{border:1px solid rgba(255,255,255,0.2);background:transparent;color:#fff;border-radius:8px;padding:10px 20px;font-weight:600;font-size:12px;cursor:pointer;letter-spacing:1px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;flex:1;justify-content:center}
.btn-ticket-secondary:hover{background:rgba(255,255,255,0.05);color:#fff;text-decoration:none}
@media print{
    .main-content .top-bar,.sidebar,.ticket-actions,.back-link{display:none!important}
    .ticket-container{box-shadow:none}
    body{background:#0a0a0a!important}
}
</style>
@endsection
@section('content')
<div class="mb-3 back-link">
    <a href="{{ route('client.billets') }}" style="font-size:12px;color:#a0aec0;text-decoration:none">
        <i class="fas fa-arrow-left mr-1"></i>Retour à mes billets
    </a>
</div>

<div class="ticket-wrapper">
<div class="ticket-container">

    <!-- HEADER -->
    <div class="ticket-header">
        <div style="font-size:10px;letter-spacing:3px;color:rgba(255,255,255,0.5);font-weight:600">🎫 BILLETPRO</div>
        <div style="display:flex;align-items:center;gap:10px">
            @if($billet->statut == 'valide')
                <span style="background:#0288d1;color:#fff;border-radius:20px;padding:3px 12px;font-size:9px;font-weight:700;letter-spacing:1px">✓ BILLET VALIDE</span>
            @elseif($billet->statut == 'en_attente')
                <span style="background:#ed8936;color:#fff;border-radius:20px;padding:3px 12px;font-size:9px;font-weight:700;letter-spacing:1px">⏳ EN ATTENTE</span>
            @elseif($billet->statut == 'utilise')
                <span style="background:#718096;color:#fff;border-radius:20px;padding:3px 12px;font-size:9px;font-weight:700;letter-spacing:1px">✓ UTILISÉ</span>
            @else
                <span style="background:#e53e3e;color:#fff;border-radius:20px;padding:3px 12px;font-size:9px;font-weight:700;letter-spacing:1px">✗ ANNULÉ</span>
            @endif
            <div style="width:32px;height:32px;border-radius:50%;background:#0288d1;display:flex;align-items:center;justify-content:center;font-size:11px;color:#fff;font-weight:700">
                {{ strtoupper(substr($billet->client ? $billet->client->nom : 'U', 0, 2)) }}
            </div>
        </div>
    </div>

    <!-- HERO ROW : Titre + Image -->
    <div class="ticket-hero-row">
        <div class="ticket-hero-left">
            <div style="font-size:9px;letter-spacing:3px;color:#0288d1;font-weight:600;margin-bottom:10px">INVITATION OFFICIELLE</div>
            <h2 style="font-size:1.6rem;font-weight:900;line-height:1.2;color:#fff;text-transform:uppercase;margin:0 0 12px">
                {{ $billet->evenement ? $billet->evenement->titre : '-' }}
            </h2>
            @if($billet->evenement && $billet->evenement->categorie)
                <span style="background:rgba(2,136,209,0.2);border:1px solid rgba(2,136,209,0.4);color:#64b5f6;border-radius:20px;padding:3px 12px;font-size:10px;font-weight:600">{{ $billet->evenement->categorie->nom }}</span>
            @endif
        </div>
        <div class="ticket-image-right">
            @if($billet->evenement && $billet->evenement->image)
                <img src="{{ asset('uploads/events/'.$billet->evenement->image) }}" style="width:100%;height:100%;object-fit:cover">
            @else
                <div style="width:100%;height:100%;background:linear-gradient(135deg,#0f3460,#0288d1);display:flex;align-items:center;justify-content:center;font-size:4rem">🎫</div>
            @endif
            <div style="position:absolute;bottom:0;left:0;right:0;height:60px;background:linear-gradient(to top,#111,transparent)"></div>
        </div>
    </div>

    <!-- TICKET LABEL -->
    <div class="ticket-label">T I C K E T</div>

    <!-- TICKET CARD -->
    <div class="ticket-card">

        <!-- Ligne 1: Nom événement complet -->
        <div style="padding:0.9rem 1rem;border-bottom:1px dashed rgba(255,255,255,0.08)">
            <div class="ticket-field-label">Nom de l'événement</div>
            <div style="font-size:1rem;font-weight:700;color:#0288d1">{{ $billet->evenement ? $billet->evenement->titre : '-' }}</div>
        </div>

        <!-- Ligne 2: Date + Heure + Lieu + Organisateur -->
        <div class="ticket-fields-row">
            <div class="ticket-cell ticket-cell-border">
                <div class="ticket-field-label">Date</div>
                <div class="ticket-field-value">{{ $billet->evenement && $billet->evenement->date_evenement ? \Carbon\Carbon::parse($billet->evenement->date_evenement)->format('d M, Y') : '-' }}</div>
            </div>
            <div class="ticket-cell ticket-cell-border">
                <div class="ticket-field-label">Heure</div>
                <div class="ticket-field-value">{{ $billet->evenement && $billet->evenement->date_evenement ? \Carbon\Carbon::parse($billet->evenement->date_evenement)->format('H:i') : '-' }}</div>
            </div>
            <div class="ticket-cell ticket-cell-border">
                <div class="ticket-field-label">Lieu</div>
                <div class="ticket-field-value" style="font-size:11px">{{ $billet->evenement && $billet->evenement->lieu ? str_limit($billet->evenement->lieu, 20) : '-' }}</div>
            </div>
            <div class="ticket-cell">
                <div class="ticket-field-label">Organisateur</div>
                <div class="ticket-field-value" style="font-size:11px">{{ $billet->evenement && $billet->evenement->organisateur ? str_limit($billet->evenement->organisateur->nom, 18) : '-' }}</div>
            </div>
        </div>

        <!-- Ligne 3: Titulaire + N° Billet + Quantité -->
        <div class="ticket-fields-row-2">
            <div class="ticket-cell ticket-cell-border">
                <div class="ticket-field-label">Titulaire</div>
                <div style="font-size:14px;font-weight:700;color:#0288d1">{{ $billet->client ? $billet->client->nom : '-' }}</div>
                <div style="font-size:10px;color:rgba(255,255,255,0.4);margin-top:2px">{{ $billet->client ? $billet->client->email : '' }}</div>
            </div>
            <div class="ticket-cell ticket-cell-border">
                <div class="ticket-field-label">N° de billet</div>
                <div style="font-size:9px;font-weight:700;font-family:monospace;color:rgba(255,255,255,0.7);word-break:break-all">{{ $billet->numero_billet }}</div>
            </div>
            <div class="ticket-cell">
                <div class="ticket-field-label">Montant</div>
                <div style="font-size:14px;font-weight:700;color:#0288d1">{{ number_format($billet->prix_unitaire * $billet->quantite, 0) }} DJF</div>
                <div style="font-size:10px;color:rgba(255,255,255,0.4);margin-top:2px">{{ $billet->quantite }} billet(s)</div>
            </div>
        </div>

        <!-- BOTTOM: Infos + QR Code -->
        <div class="ticket-bottom">
            <div class="ticket-info-left">
                <div style="margin-bottom:1rem">
                    <div style="color:#0288d1;font-size:1.2rem;font-weight:900;margin-bottom:3px">01</div>
                    <div style="font-weight:700;font-size:11px;margin-bottom:4px;text-transform:uppercase;color:#fff">Protocole d'arrivée</div>
                    <div style="font-size:11px;color:rgba(255,255,255,0.45);line-height:1.5">Présentez-vous 30 min avant le début. Accès réservé aux porteurs de billet valide.</div>
                </div>
                <div style="margin-bottom:1rem">
                    <div style="color:#0288d1;font-size:1.2rem;font-weight:900;margin-bottom:3px">02</div>
                    <div style="font-weight:700;font-size:11px;margin-bottom:4px;text-transform:uppercase;color:#fff">Vérification</div>
                    <div style="font-size:11px;color:rgba(255,255,255,0.45);line-height:1.5">Présentez votre QR Code à l'entrée pour validation par l'organisateur.</div>
                </div>
                <div>
                    <div style="color:#0288d1;font-size:1.2rem;font-weight:900;margin-bottom:3px">03</div>
                    <div style="font-weight:700;font-size:11px;margin-bottom:4px;text-transform:uppercase;color:#fff">Support</div>
                    <div style="font-size:11px;color:rgba(255,255,255,0.45);line-height:1.5">Contact : kadirmohamed801@gmail.com</div>
                </div>
            </div>

            <div class="ticket-qr-right">
                @if($billet->statut == 'valide')
                    <div style="font-size:8px;letter-spacing:2px;color:rgba(255,255,255,0.4);font-weight:600;margin-bottom:10px;text-align:center">SCANNER À L'ENTRÉE</div>
                    <div style="background:#fff;padding:10px;border-radius:8px;border:3px solid #0288d1">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=130x130&data={{ urlencode($billet->numero_billet) }}&bgcolor=ffffff&color=0a0a0a&margin=6"
                             alt="QR Code" width="130" height="130" style="display:block">
                    </div>
                    <div style="font-size:8px;color:rgba(255,255,255,0.25);margin-top:8px;font-family:monospace;text-align:center;word-break:break-all;max-width:130px">{{ $billet->numero_billet }}</div>
                @else
                    <div style="text-align:center;padding:1rem">
                        <i class="fas fa-clock" style="font-size:2rem;color:#ed8936;margin-bottom:8px;display:block"></i>
                        <div style="font-size:10px;color:rgba(255,255,255,0.4);line-height:1.4">QR Code disponible après validation</div>
                    </div>
                @endif
            </div>
        </div>

    </div>

    <!-- ACTIONS -->
    <div class="ticket-actions">
        @if($billet->statut == 'valide')
        <a href="javascript:window.print()" class="btn-ticket-primary">
            <i class="fas fa-print"></i>IMPRIMER
        </a>
        @endif
        <a href="{{ route('client.billets') }}" class="btn-ticket-secondary">
            <i class="fas fa-ticket-alt"></i>MES BILLETS
        </a>
        <a href="{{ route('client.evenements') }}" class="btn-ticket-secondary">
            <i class="fas fa-search"></i>ÉVÉNEMENTS
        </a>
    </div>

</div>
</div>
@endsection
