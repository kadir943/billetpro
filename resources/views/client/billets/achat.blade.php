@extends('layouts.client')
@section('title','Acheter un billet')
@section('page-title','Acheter un billet')
@section('page-subtitle','Choisissez votre méthode de paiement')
@section('styles')
<style>
.payment-method{border:2px solid #e0e7ef;border-radius:12px;padding:1rem;cursor:pointer;transition:all 0.2s;margin-bottom:10px}
.payment-method:hover{border-color:#0288d1;background:#f5fbff}
.payment-method.selected{border-color:#0288d1;background:#e3f2fd}
.payment-form{display:none;background:#f8fafc;border-radius:10px;padding:1rem;margin-top:10px;border:1px solid #e0e7ef}
.payment-form.active{display:block}
.card-input{border:1.5px solid #e0e7ef;border-radius:8px;padding:10px 14px;font-size:13px;width:100%;outline:none;transition:border-color 0.2s}
.card-input:focus{border-color:#0288d1}
.processing-overlay{display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center}
.processing-overlay.active{display:flex}
.processing-box{background:#fff;border-radius:16px;padding:2.5rem;text-align:center;max-width:350px;width:90%}
.spinner{width:50px;height:50px;border:4px solid #e3f2fd;border-top:4px solid #0288d1;border-radius:50%;animation:spin 1s linear infinite;margin:0 auto 1rem}
@keyframes spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}
.summary-card{background:#0f3460;border-radius:12px;padding:1.2rem;color:#fff}
.method-group-title{font-size:10px;font-weight:700;color:#a0aec0;text-transform:uppercase;letter-spacing:1px;margin:12px 0 6px}
</style>
@endsection
@section('content')

<!-- Processing Overlay -->
<div class="processing-overlay" id="processingOverlay">
    <div class="processing-box">
        <div class="spinner"></div>
        <h5 style="color:#0f1824;font-weight:700;margin-bottom:8px">Soumission en cours...</h5>
        <p style="color:#718096;font-size:13px;margin:0">Veuillez patienter pendant que nous enregistrons votre demande.</p>
    </div>
</div>

<div class="row">
    <!-- FORMULAIRE PAIEMENT -->
    <div class="col-md-7 mb-4">
        <div class="pro-card">
            <div class="pro-card-header">
                <div class="pro-card-title">Choisir le mode de paiement</div>
            </div>
            <div style="padding:1.2rem">

                <!-- Alerte info -->
                <div style="background:#e3f2fd;border-left:4px solid #0288d1;border-radius:8px;padding:12px 16px;margin-bottom:1.2rem;font-size:12px;color:#0277bd">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Comment ça marche :</strong> Effectuez votre paiement via la méthode choisie, puis uploadez votre reçu et entrez le code de transaction. Votre billet sera activé après vérification par notre équipe.
                </div>

                <form method="POST" action="{{ route('client.billet.acheter', $evenement->id) }}" id="paymentForm" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="methode_paiement" id="methode_paiement" value="">

                    <!-- Quantité -->
                    <div class="form-group mb-4">
                        <label style="font-size:13px;font-weight:600;color:#0f1824">Nombre de billets</label>
                        <div class="d-flex align-items-center gap-3 mt-2">
                            <button type="button" onclick="changeQty(-1)" style="width:36px;height:36px;border:1.5px solid #e0e7ef;border-radius:8px;background:#fff;font-size:1.2rem;cursor:pointer">-</button>
                            <input type="number" name="quantite" id="quantite" value="1" min="1" max="{{ $evenement->places_disponibles }}" style="width:60px;text-align:center;border:1.5px solid #e0e7ef;border-radius:8px;padding:6px;font-size:1rem;font-weight:700">
                            <button type="button" onclick="changeQty(1)" style="width:36px;height:36px;border:1.5px solid #e0e7ef;border-radius:8px;background:#fff;font-size:1.2rem;cursor:pointer">+</button>
                            <span style="font-size:12px;color:#a0aec0">Max : {{ $evenement->places_disponibles }} places</span>
                        </div>
                    </div>

                    <!-- Méthodes Mobile Djibouti -->
                    <div class="method-group-title"><i class="fas fa-mobile-alt mr-1"></i>Paiement mobile Djibouti</div>

                    <!-- Waafi -->
                    <div class="payment-method" onclick="selectMethod('waafi', this)">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:42px;height:42px;border-radius:10px;background:#e8f5e9;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0">💚</div>
                            <div class="flex-grow-1">
                                <div style="font-size:13px;font-weight:600;color:#0f1824">Waafi</div>
                                <div style="font-size:11px;color:#a0aec0">Paiement mobile — Djibouti Telecom</div>
                            </div>
                            <div style="width:20px;height:20px;border-radius:50%;border:2px solid #e0e7ef" id="radio-waafi"></div>
                        </div>
                        <div class="payment-form" id="form-waafi">
                            <p style="font-size:12px;color:#0288d1;margin-bottom:8px"><i class="fas fa-info-circle mr-1"></i>Envoyez <strong id="waafi-amount">{{ number_format($evenement->prix, 0) }} DJF</strong> au numéro Waafi de BilletPro, puis uploadez le reçu.</p>
                        </div>
                    </div>

                    <!-- D-Money -->
                    <div class="payment-method" onclick="selectMethod('dmoney', this)">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:42px;height:42px;border-radius:10px;background:#e3f2fd;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0">💙</div>
                            <div class="flex-grow-1">
                                <div style="font-size:13px;font-weight:600;color:#0f1824">D-Money</div>
                                <div style="font-size:11px;color:#a0aec0">Portefeuille électronique</div>
                            </div>
                            <div style="width:20px;height:20px;border-radius:50%;border:2px solid #e0e7ef" id="radio-dmoney"></div>
                        </div>
                        <div class="payment-form" id="form-dmoney">
                            <p style="font-size:12px;color:#0288d1;margin-bottom:8px"><i class="fas fa-info-circle mr-1"></i>Envoyez <strong id="dmoney-amount">{{ number_format($evenement->prix, 0) }} DJF</strong> via D-Money, puis uploadez le reçu.</p>
                        </div>
                    </div>

                    <!-- CacPay -->
                    <div class="payment-method" onclick="selectMethod('cacpay', this)">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:42px;height:42px;border-radius:10px;background:#fff3e0;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0">🏦</div>
                            <div class="flex-grow-1">
                                <div style="font-size:13px;font-weight:600;color:#0f1824">CacPay</div>
                                <div style="font-size:11px;color:#a0aec0">Banque CAC International</div>
                            </div>
                            <div style="width:20px;height:20px;border-radius:50%;border:2px solid #e0e7ef" id="radio-cacpay"></div>
                        </div>
                        <div class="payment-form" id="form-cacpay">
                            <p style="font-size:12px;color:#0288d1;margin-bottom:8px"><i class="fas fa-info-circle mr-1"></i>Effectuez le paiement via CacPay, puis uploadez le reçu.</p>
                        </div>
                    </div>

                    <!-- SabaPay -->
                    <div class="payment-method" onclick="selectMethod('sabapay', this)">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:42px;height:42px;border-radius:10px;background:#fce4ec;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0">💳</div>
                            <div class="flex-grow-1">
                                <div style="font-size:13px;font-weight:600;color:#0f1824">SabaPay</div>
                                <div style="font-size:11px;color:#a0aec0">Saba Islamic Bank</div>
                            </div>
                            <div style="width:20px;height:20px;border-radius:50%;border:2px solid #e0e7ef" id="radio-sabapay"></div>
                        </div>
                        <div class="payment-form" id="form-sabapay">
                            <p style="font-size:12px;color:#0288d1;margin-bottom:8px"><i class="fas fa-info-circle mr-1"></i>Effectuez le paiement via SabaPay, puis uploadez le reçu.</p>
                        </div>
                    </div>

                    <!-- EximPay -->
                    <div class="payment-method" onclick="selectMethod('eximpay', this)">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:42px;height:42px;border-radius:10px;background:#e8eaf6;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0">🏧</div>
                            <div class="flex-grow-1">
                                <div style="font-size:13px;font-weight:600;color:#0f1824">EximPay</div>
                                <div style="font-size:11px;color:#a0aec0">Exim Bank Djibouti</div>
                            </div>
                            <div style="width:20px;height:20px;border-radius:50%;border:2px solid #e0e7ef" id="radio-eximpay"></div>
                        </div>
                        <div class="payment-form" id="form-eximpay">
                            <p style="font-size:12px;color:#0288d1;margin-bottom:8px"><i class="fas fa-info-circle mr-1"></i>Effectuez le paiement via EximPay, puis uploadez le reçu.</p>
                        </div>
                    </div>

                    <!-- DahabPlus -->
                    <div class="payment-method" onclick="selectMethod('dahabplus', this)">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:42px;height:42px;border-radius:10px;background:#fffde7;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0">⭐</div>
                            <div class="flex-grow-1">
                                <div style="font-size:13px;font-weight:600;color:#0f1824">DahabPlus</div>
                                <div style="font-size:11px;color:#a0aec0">Dahabshiil Money Transfer</div>
                            </div>
                            <div style="width:20px;height:20px;border-radius:50%;border:2px solid #e0e7ef" id="radio-dahabplus"></div>
                        </div>
                        <div class="payment-form" id="form-dahabplus">
                            <p style="font-size:12px;color:#0288d1;margin-bottom:8px"><i class="fas fa-info-circle mr-1"></i>Effectuez le paiement via DahabPlus, puis uploadez le reçu.</p>
                        </div>
                    </div>

                    <!-- Carte bancaire -->
                    <div class="method-group-title"><i class="fas fa-credit-card mr-1"></i>Carte bancaire</div>
                    <div class="payment-method" onclick="selectMethod('carte', this)">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:42px;height:42px;border-radius:10px;background:#f0f0ff;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0">💳</div>
                            <div class="flex-grow-1">
                                <div style="font-size:13px;font-weight:600;color:#0f1824">Carte bancaire</div>
                                <div style="font-size:11px;color:#a0aec0">Visa, Mastercard</div>
                            </div>
                            <div style="width:20px;height:20px;border-radius:50%;border:2px solid #e0e7ef" id="radio-carte"></div>
                        </div>
                        <div class="payment-form" id="form-carte">
                            <p style="font-size:12px;color:#0288d1;margin-bottom:8px"><i class="fas fa-info-circle mr-1"></i>Effectuez le virement bancaire et uploadez le reçu.</p>
                        </div>
                    </div>

                    <!-- Espèces -->
                    <div class="method-group-title"><i class="fas fa-money-bill mr-1"></i>Autre</div>
                    <div class="payment-method" onclick="selectMethod('especes', this)">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:42px;height:42px;border-radius:10px;background:#fff3e0;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0">💵</div>
                            <div class="flex-grow-1">
                                <div style="font-size:13px;font-weight:600;color:#0f1824">Espèces</div>
                                <div style="font-size:11px;color:#a0aec0">Paiement en personne</div>
                            </div>
                            <div style="width:20px;height:20px;border-radius:50%;border:2px solid #e0e7ef" id="radio-especes"></div>
                        </div>
                        <div class="payment-form" id="form-especes">
                            <div style="background:#fff3e0;border-radius:8px;padding:10px;font-size:12px;color:#e65100">
                                <i class="fas fa-map-marker-alt mr-1"></i>Rendez-vous au bureau de l'organisateur. Votre place sera réservée 24h.
                            </div>
                        </div>
                    </div>

                    <!-- Upload reçu et code transaction -->
                    <div id="uploadSection" style="display:none;margin-top:1.2rem;padding:1rem;background:#f8fafc;border-radius:12px;border:1px solid #e0e7ef">
                        <div style="font-size:13px;font-weight:600;color:#0f1824;margin-bottom:1rem"><i class="fas fa-upload mr-2" style="color:#0288d1"></i>Preuves de paiement</div>
                        <div class="form-group">
                            <label style="font-size:12px;font-weight:500;color:#4a5568">Code de transaction <span style="color:#e53e3e">*</span></label>
                            <input type="text" name="code_transaction" class="card-input" placeholder="Ex: TXN123456789" required>
                            <small style="color:#a0aec0;font-size:11px">Le code de référence de votre transaction</small>
                        </div>
                        <div class="form-group mb-0">
                            <label style="font-size:12px;font-weight:500;color:#4a5568">Capture d'écran du reçu <span style="color:#e53e3e">*</span></label>
                            <div class="custom-file">
                                <input type="file" name="recu_paiement" class="custom-file-input" id="recuFile" accept="image/*,.pdf">
                                <label class="custom-file-label" for="recuFile" style="font-size:12px">Choisir une image ou PDF...</label>
                            </div>
                            <small style="color:#a0aec0;font-size:11px">Format JPG, PNG ou PDF — Max 5MB</small>
                        </div>
                    </div>

                    <div id="errorMsg" style="display:none;background:#fff0f0;border:1px solid #e53e3e;border-radius:8px;padding:10px;font-size:12px;color:#e53e3e;margin-top:10px">
                        <i class="fas fa-exclamation-circle mr-1"></i>Veuillez choisir une méthode de paiement.
                    </div>

                    <button type="button" onclick="submitPayment()" class="btn-primary-pro mt-3" style="width:100%;justify-content:center;padding:12px;font-size:14px">
                        <i class="fas fa-paper-plane mr-2"></i>Soumettre ma demande — <span id="totalDisplay">{{ number_format($evenement->prix, 0) }} DJF</span>
                    </button>

                    <div style="background:#e8f5e9;border-radius:8px;padding:10px;margin-top:10px;text-align:center">
                        <i class="fas fa-clock mr-1" style="color:#2e7d32"></i>
                        <span style="font-size:12px;color:#2e7d32">Votre billet sera activé après vérification du paiement par notre équipe.</span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- RÉSUMÉ COMMANDE -->
    <div class="col-md-5 mb-4">
        <div class="summary-card mb-3">
            <div style="font-size:10px;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:1px;margin-bottom:8px">Résumé de la commande</div>
            @if($evenement->image)
                <img src="{{ asset('uploads/events/'.$evenement->image) }}" style="width:100%;height:120px;object-fit:cover;border-radius:8px;margin-bottom:12px">
            @endif
            <div style="font-size:1rem;font-weight:700;color:#fff;margin-bottom:6px">{{ str_limit($evenement->titre, 40) }}</div>
            <div style="font-size:12px;color:rgba(255,255,255,0.6);margin-bottom:4px"><i class="fas fa-calendar mr-1"></i>{{ $evenement->date_evenement ? \Carbon\Carbon::parse($evenement->date_evenement)->format('d M Y à H:i') : '-' }}</div>
            <div style="font-size:12px;color:rgba(255,255,255,0.6);margin-bottom:12px"><i class="fas fa-map-marker-alt mr-1"></i>{{ $evenement->lieu ? $evenement->lieu : '-' }}</div>
            <hr style="border-color:rgba(255,255,255,0.15)">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span style="font-size:12px;color:rgba(255,255,255,0.6)">Prix unitaire</span>
                <span style="font-size:12px;color:#fff;font-weight:500">{{ number_format($evenement->prix, 0) }} DJF</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span style="font-size:12px;color:rgba(255,255,255,0.6)">Quantité</span>
                <span style="font-size:12px;color:#fff;font-weight:500" id="qtyDisplay">1</span>
            </div>
            <hr style="border-color:rgba(255,255,255,0.15)">
            <div class="d-flex justify-content-between align-items-center">
                <span style="font-size:14px;color:#fff;font-weight:600">Total à payer</span>
                <span style="font-size:1.2rem;color:#FBBF24;font-weight:800" id="totalAmount">{{ number_format($evenement->prix, 0) }} DJF</span>
            </div>
        </div>

        <div class="pro-card mb-3">
            <div style="padding:1rem">
                <div style="font-size:12px;font-weight:600;color:#0f1824;margin-bottom:8px"><i class="fas fa-list-ol mr-2" style="color:#0288d1"></i>Étapes du processus</div>
                <div style="font-size:11px;color:#718096;line-height:2">
                    <div><span style="background:#0288d1;color:#fff;border-radius:50%;width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center;font-size:9px;margin-right:6px">1</span>Choisissez votre méthode</div>
                    <div><span style="background:#0288d1;color:#fff;border-radius:50%;width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center;font-size:9px;margin-right:6px">2</span>Effectuez le paiement</div>
                    <div><span style="background:#0288d1;color:#fff;border-radius:50%;width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center;font-size:9px;margin-right:6px">3</span>Uploadez le reçu + code</div>
                    <div><span style="background:#0288d1;color:#fff;border-radius:50%;width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center;font-size:9px;margin-right:6px">4</span>Notre équipe vérifie</div>
                    <div><span style="background:#48bb78;color:#fff;border-radius:50%;width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center;font-size:9px;margin-right:6px">✓</span>Billet activé et envoyé !</div>
                </div>
            </div>
        </div>

        <div class="pro-card">
            <div style="padding:1rem">
                <div style="font-size:12px;font-weight:600;color:#0f1824;margin-bottom:8px"><i class="fas fa-shield-alt mr-2" style="color:#0288d1"></i>Garanties BilletPro</div>
                <div style="font-size:11px;color:#718096;line-height:1.8">
                    <div><i class="fas fa-check mr-2" style="color:#48bb78"></i>Vérification sous 2h ouvrées</div>
                    <div><i class="fas fa-check mr-2" style="color:#48bb78"></i>Billet QR Code sécurisé</div>
                    <div><i class="fas fa-check mr-2" style="color:#48bb78"></i>Remboursement si refusé</div>
                    <div><i class="fas fa-check mr-2" style="color:#48bb78"></i>Support client disponible</div>
                </div>
            </div>
        </div>

        <div class="mt-3 text-center">
            <a href="{{ route('client.evenement.show', $evenement->id) }}" style="font-size:12px;color:#a0aec0;text-decoration:none">
                <i class="fas fa-arrow-left mr-1"></i>Retour à l'événement
            </a>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
var prix = {{ $evenement->prix }};
var selectedMethod = null;

function changeQty(delta) {
    var input = document.getElementById('quantite');
    var newVal = parseInt(input.value) + delta;
    var max = parseInt(input.max);
    if (newVal >= 1 && newVal <= max) {
        input.value = newVal;
        updateTotal(newVal);
    }
}

document.getElementById('quantite').addEventListener('input', function() {
    updateTotal(parseInt(this.value) || 1);
});

function updateTotal(qty) {
    var total = prix * qty;
    document.getElementById('qtyDisplay').textContent = qty;
    document.getElementById('totalAmount').textContent = total.toLocaleString() + ' DJF';
    document.getElementById('totalDisplay').textContent = total.toLocaleString() + ' DJF';

    var methods = ['waafi', 'dmoney', 'cacpay', 'sabapay', 'eximpay', 'dahabplus'];
    methods.forEach(function(m) {
        var el = document.getElementById(m + '-amount');
        if (el) el.textContent = total.toLocaleString() + ' DJF';
    });
}

function selectMethod(method, element) {
    document.querySelectorAll('.payment-method').forEach(function(el) {
        el.classList.remove('selected');
    });
    document.querySelectorAll('.payment-form').forEach(function(form) {
        form.classList.remove('active');
    });
    document.querySelectorAll('[id^="radio-"]').forEach(function(radio) {
        radio.style.background = '';
        radio.style.borderColor = '#e0e7ef';
    });

    element.classList.add('selected');
    document.getElementById('form-' + method).classList.add('active');
    document.getElementById('radio-' + method).style.background = '#0288d1';
    document.getElementById('radio-' + method).style.borderColor = '#0288d1';

    selectedMethod = method;
    document.getElementById('methode_paiement').value = method;
    document.getElementById('errorMsg').style.display = 'none';
    document.getElementById('uploadSection').style.display = 'block';
}

document.getElementById('recuFile').addEventListener('change', function(e) {
    if (e.target.files[0]) {
        document.querySelector('.custom-file-label').textContent = e.target.files[0].name;
    }
});

function submitPayment() {
    if (!selectedMethod) {
        document.getElementById('errorMsg').style.display = 'block';
        return;
    }
    document.getElementById('processingOverlay').classList.add('active');
    setTimeout(function() {
        document.getElementById('paymentForm').submit();
    }, 2000);
}
</script>
@endsection
