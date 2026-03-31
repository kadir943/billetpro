@extends('layouts.client')
@section('title','Demande soumise')
@section('page-title','Demande de billet')
@section('page-subtitle','Votre demande est en cours de traitement')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">

        @if($billet->statut == 'en_attente')
        <!-- EN ATTENTE -->
        <div class="text-center mb-4 p-4 rounded" style="background:linear-gradient(135deg,#ed8936,#dd6b20);color:#fff;border-radius:16px">
            <i class="fas fa-clock" style="font-size:4rem;margin-bottom:1rem;display:block"></i>
            <h3 class="font-weight-bold">Demande soumise !</h3>
            <p class="mb-0">Votre paiement est en cours de vérification par notre équipe.</p>
        </div>

        <div class="pro-card mb-4">
            <div style="padding:1.5rem">
                <div style="font-size:14px;font-weight:600;color:#0f1824;margin-bottom:1rem">
                    <i class="fas fa-info-circle mr-2" style="color:#ed8936"></i>Que se passe-t-il maintenant ?
                </div>
                <div style="display:flex;flex-direction:column;gap:12px">
                    <div style="display:flex;align-items:flex-start;gap:12px">
                        <div style="width:28px;height:28px;background:#ed8936;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;color:#fff;font-weight:700;flex-shrink:0">1</div>
                        <div>
                            <div style="font-size:13px;font-weight:500;color:#0f1824">Vérification du paiement</div>
                            <div style="font-size:12px;color:#718096">Notre équipe vérifie votre reçu et code de transaction.</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:12px">
                        <div style="width:28px;height:28px;background:#ed8936;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;color:#fff;font-weight:700;flex-shrink:0">2</div>
                        <div>
                            <div style="font-size:13px;font-weight:500;color:#0f1824">Activation du billet</div>
                            <div style="font-size:12px;color:#718096">Une fois vérifié, votre billet sera activé automatiquement.</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:12px">
                        <div style="width:28px;height:28px;background:#48bb78;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;color:#fff;font-weight:700;flex-shrink:0">3</div>
                        <div>
                            <div style="font-size:13px;font-weight:500;color:#0f1824">Email de confirmation</div>
                            <div style="font-size:12px;color:#718096">Vous recevrez un email avec votre billet QR Code.</div>
                        </div>
                    </div>
                </div>

                <div style="background:#fff3e0;border-left:4px solid #ed8936;border-radius:8px;padding:12px 16px;margin-top:1.2rem">
                    <p style="margin:0;font-size:12px;color:#e65100">
                        <i class="fas fa-clock mr-1"></i>
                        <strong>Délai de vérification :</strong> Votre paiement sera vérifié dans les <strong>2 heures ouvrées</strong>.
                    </p>
                </div>
            </div>
        </div>

        <div class="pro-card mb-4">
            <div style="padding:1.5rem">
                <div style="font-size:14px;font-weight:600;color:#0f1824;margin-bottom:1rem">Résumé de votre demande</div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <div style="font-size:11px;color:#a0aec0">Événement</div>
                        <div style="font-size:13px;font-weight:500;color:#0f1824">{{ $billet->evenement ? $billet->evenement->titre : '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div style="font-size:11px;color:#a0aec0">N° de réservation</div>
                        <code style="font-size:12px;color:#0288d1">{{ $billet->numero_billet }}</code>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div style="font-size:11px;color:#a0aec0">Méthode de paiement</div>
                        <div style="font-size:13px;color:#0f1824">{{ $billet->paiement ? ucfirst($billet->paiement->methode_paiement) : '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div style="font-size:11px;color:#a0aec0">Montant</div>
                        <div style="font-size:13px;font-weight:600;color:#0288d1">{{ $billet->paiement ? number_format($billet->paiement->montant, 0).' DJF' : '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div style="font-size:11px;color:#a0aec0">Statut</div>
                        <span style="background:#fff3e0;color:#e65100;border-radius:6px;padding:3px 10px;font-size:11px;font-weight:500">
                            <i class="fas fa-clock mr-1"></i>En attente de vérification
                        </span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div style="font-size:11px;color:#a0aec0">Date de soumission</div>
                        <div style="font-size:13px;color:#0f1824">{{ $billet->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>

        @elseif($billet->statut == 'valide')
        <!-- BILLET VALIDE -->
        <div class="text-center mb-4 p-4 rounded" style="background:linear-gradient(135deg,#28a745,#20c997);color:#fff;border-radius:16px">
            <i class="fas fa-check-circle" style="font-size:4rem;margin-bottom:1rem;display:block"></i>
            <h3 class="font-weight-bold">Paiement confirmé !</h3>
            <p class="mb-0">Votre billet électronique est prêt.</p>
        </div>

        <div class="pro-card mb-4" style="border-radius:20px;overflow:hidden;border:none;box-shadow:0 10px 40px rgba(0,0,0,0.15)">
            <div style="background:linear-gradient(135deg,#1a1a2e,#16213e);color:#fff;padding:1.5rem">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div style="font-size:0.75rem;opacity:0.6;text-transform:uppercase;letter-spacing:1px">BilletPro</div>
                        <h4 class="font-weight-bold mb-0">{{ $billet->evenement ? $billet->evenement->titre : '-' }}</h4>
                    </div>
                    <div class="text-right">
                        <div style="font-size:0.75rem;opacity:0.6">N° Billet</div>
                        <div style="font-family:monospace;font-size:0.85rem;color:#F97316">{{ $billet->numero_billet }}</div>
                    </div>
                </div>
            </div>
            <div style="display:flex">
                <div style="flex:1;padding:1.5rem">
                    <div class="mb-3">
                        <div style="font-size:11px;color:#a0aec0">Date</div>
                        <div style="font-weight:600">{{ $billet->evenement && $billet->evenement->date_evenement ? \Carbon\Carbon::parse($billet->evenement->date_evenement)->format('d/m/Y à H:i') : '-' }}</div>
                    </div>
                    <div class="mb-3">
                        <div style="font-size:11px;color:#a0aec0">Lieu</div>
                        <div style="font-weight:600">{{ $billet->evenement && $billet->evenement->lieu ? $billet->evenement->lieu : '-' }}</div>
                    </div>
                    <div class="mb-3">
                        <div style="font-size:11px;color:#a0aec0">Titulaire</div>
                        <div style="font-weight:600">{{ $billet->client ? $billet->client->nom : '-' }}</div>
                    </div>
                    <span class="badge badge-success px-3 py-2">BILLET VALIDE</span>
                </div>
                <div style="flex:0 0 180px;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:1.5rem;background:#f8f9ff;border-left:2px dashed #dee2e6">
                    <div style="font-size:12px;color:#a0aec0;margin-bottom:8px">QR Code d'accès</div>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode($billet->numero_billet) }}&bgcolor=ffffff&color=1a1a2e&margin=10"
                         style="border-radius:10px;border:3px solid #1a1a2e"
                         alt="QR Code" width="160" height="160">
                </div>
            </div>
        </div>
        @endif

        <div class="d-flex justify-content-between">
            <a href="{{ route('client.billets') }}" class="btn-secondary-pro"><i class="fas fa-ticket-alt mr-2"></i>Mes billets</a>
            <a href="{{ route('client.evenements') }}" class="btn-primary-pro"><i class="fas fa-search mr-2"></i>Autres événements</a>
        </div>
    </div>
</div>
@endsection
