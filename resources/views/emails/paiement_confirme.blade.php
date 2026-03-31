<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body{font-family:'Segoe UI',sans-serif;background:#f4f6f9;margin:0;padding:20px}
        .container{max-width:600px;margin:0 auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.08)}
        .header{background:linear-gradient(135deg,#0288d1,#0077b6);padding:40px 30px;text-align:center}
        .header h1{color:#fff;margin:0;font-size:1.8rem;font-weight:800}
        .body{padding:40px 30px;text-align:center}
        .success-box{background:#e8f5e9;border:2px solid #28a745;border-radius:12px;padding:24px;margin:24px 0}
        .code{font-size:1.5rem;font-weight:900;color:#0288d1;letter-spacing:4px;font-family:monospace}
        .btn{display:inline-block;background:#0288d1;color:#fff;text-decoration:none;border-radius:8px;padding:14px 32px;font-weight:700;font-size:1rem;margin-top:16px}
        .footer{background:#f8fafc;padding:20px 30px;text-align:center;border-top:1px solid #e0e7ef}
        .footer p{color:#a0aec0;font-size:0.8rem;margin:0}
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🎫 BilletPro</h1>
        <p style="color:rgba(255,255,255,0.8);margin:8px 0 0">Votre billet est confirmé !</p>
    </div>
    <div class="body">
        <h2 style="color:#0f1824">Félicitations {{ $nom }} ! 🎉</h2>
        <p style="color:#4a5568">Votre paiement a été vérifié et votre billet est maintenant actif.</p>
        <div class="success-box">
            <p style="color:#2e7d32;font-weight:600;margin-bottom:8px">✅ Paiement confirmé</p>
            <p style="color:#4a5568;margin-bottom:8px">Événement : <strong>{{ $evenement }}</strong></p>
            <p style="color:#4a5568;margin-bottom:8px">Montant payé : <strong>{{ number_format($montant, 0) }} DJF</strong></p>
            <p style="color:#4a5568;margin-bottom:4px">Numéro de billet :</p>
            <div class="code">{{ $numeroBillet }}</div>
        </div>
        <p style="color:#718096;font-size:0.9rem">Présentez ce QR Code à l'entrée de l'événement.</p>
        <a href="http://localhost:8000/client/billets" class="btn">Voir mon billet →</a>
    </div>
    <div class="footer">
        <p>© 2026 BilletPro — Université de Djibouti</p>
    </div>
</div>
</body>
</html>