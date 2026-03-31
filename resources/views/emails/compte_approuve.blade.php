<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body{font-family:'Segoe UI',sans-serif;background:#f4f6f9;margin:0;padding:20px}
        .container{max-width:600px;margin:0 auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.08)}
        .header{background:linear-gradient(135deg,#28a745,#20c997);padding:40px 30px;text-align:center}
        .header h1{color:#fff;margin:0;font-size:1.8rem;font-weight:800}
        .header p{color:rgba(255,255,255,0.8);margin:8px 0 0;font-size:0.95rem}
        .body{padding:40px 30px;text-align:center}
        .body h2{color:#0f1824;font-size:1.3rem;margin-bottom:16px}
        .body p{color:#4a5568;line-height:1.7;font-size:0.95rem;margin-bottom:12px}
        .success-box{background:#e8f5e9;border:2px solid #28a745;border-radius:12px;padding:24px;margin:24px 0}
        .success-box p{margin:0;color:#2e7d32;font-size:1rem;font-weight:600}
        .btn{display:inline-block;background:#0288d1;color:#fff;text-decoration:none;border-radius:8px;padding:14px 32px;font-weight:700;font-size:1rem;margin-top:16px}
        .footer{background:#f8fafc;padding:20px 30px;text-align:center;border-top:1px solid #e0e7ef}
        .footer p{color:#a0aec0;font-size:0.8rem;margin:0}
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🎉 BilletPro</h1>
        <p>Votre compte est maintenant actif !</p>
    </div>
    <div class="body">
        <h2>Félicitations {{ $nom }} !</h2>
        <p>Votre compte <strong>{{ ucfirst($role) }}</strong> sur BilletPro a été approuvé par notre équipe.</p>
        <div class="success-box">
            <p>✅ Votre compte est maintenant actif et vous pouvez vous connecter !</p>
        </div>
        <p>Vous pouvez maintenant accéder à toutes les fonctionnalités de la plateforme.</p>
        <a href="http://localhost:8000/login" class="btn">
            Se connecter maintenant →
        </a>
    </div>
    <div class="footer">
        <p>© 2026 BilletPro — Université de Djibouti</p>
    </div>
</div>
</body>
</html>