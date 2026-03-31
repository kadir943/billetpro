<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body{font-family:'Segoe UI',sans-serif;background:#f4f6f9;margin:0;padding:20px}
        .container{max-width:600px;margin:0 auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.08)}
        .header{background:linear-gradient(135deg,#0f3460,#0288d1);padding:40px 30px;text-align:center}
        .header h1{color:#fff;margin:0;font-size:1.8rem;font-weight:800}
        .header p{color:rgba(255,255,255,0.8);margin:8px 0 0;font-size:0.95rem}
        .body{padding:40px 30px}
        .body h2{color:#0f1824;font-size:1.3rem;margin-bottom:16px}
        .body p{color:#4a5568;line-height:1.7;font-size:0.95rem;margin-bottom:12px}
        .info-box{background:#e3f2fd;border-left:4px solid #0288d1;border-radius:8px;padding:16px 20px;margin:20px 0}
        .info-box p{margin:0;color:#0f1824;font-size:0.9rem}
        .badge{display:inline-block;background:#0288d1;color:#fff;border-radius:20px;padding:4px 16px;font-size:0.85rem;font-weight:600;margin-bottom:16px}
        .footer{background:#f8fafc;padding:20px 30px;text-align:center;border-top:1px solid #e0e7ef}
        .footer p{color:#a0aec0;font-size:0.8rem;margin:0}
        .btn{display:inline-block;background:#0288d1;color:#fff;text-decoration:none;border-radius:8px;padding:12px 28px;font-weight:600;font-size:0.95rem;margin-top:16px}
        .steps{background:#f8fafc;border-radius:8px;padding:20px;margin:20px 0}
        .step{display:flex;align-items:flex-start;gap:12px;margin-bottom:12px}
        .step-num{width:28px;height:28px;background:#0288d1;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:700;flex-shrink:0}
        .step p{margin:0;color:#4a5568;font-size:0.88rem;line-height:1.5}
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🎫 BilletPro</h1>
        <p>Plateforme de vente de billets — Djibouti</p>
    </div>
    <div class="body">
        <span class="badge">{{ ucfirst($role) }}</span>
        <h2>Bonjour {{ $nom }}, bienvenue sur BilletPro !</h2>
        <p>Merci de vous être inscrit sur notre plateforme. Votre demande d'inscription a bien été reçue et est en cours de traitement.</p>

        <div class="info-box">
            <p>⏰ <strong>Votre compte sera activé dans les 24 heures.</strong><br>
            Notre équipe examine votre inscription et vous enverra une confirmation dès que votre compte sera validé.</p>
        </div>

        <div class="steps">
            <div class="step">
                <div class="step-num">1</div>
                <p><strong>Inscription reçue</strong> — Votre demande a été enregistrée avec succès.</p>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <p><strong>Vérification en cours</strong> — Notre équipe examine votre dossier (sous 24h).</p>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <p><strong>Compte activé</strong> — Vous recevrez un email de confirmation d'activation.</p>
            </div>
        </div>

        <p>En attendant, si vous avez des questions n'hésitez pas à nous contacter.</p>
        <a href="mailto:kadirmohamed801@gmail.com" class="btn">Contacter le support</a>
    </div>
    <div class="footer">
        <p>© 2026 BilletPro — Université de Djibouti</p>
        <p style="margin-top:4px">Cet email a été envoyé automatiquement, merci de ne pas y répondre directement.</p>
    </div>
</div>
</body>
</html>