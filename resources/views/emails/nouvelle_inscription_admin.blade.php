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
        .info-box{background:#fff3e0;border-left:4px solid #ed8936;border-radius:8px;padding:16px 20px;margin:20px 0}
        .info-box p{margin:0;color:#0f1824;font-size:0.9rem}
        .badge{display:inline-block;background:#ed8936;color:#fff;border-radius:20px;padding:4px 16px;font-size:0.85rem;font-weight:600;margin-bottom:16px}
        .user-card{background:#f8fafc;border:1px solid #e0e7ef;border-radius:10px;padding:20px;margin:20px 0}
        .user-card p{margin:6px 0;font-size:0.9rem;color:#4a5568}
        .user-card strong{color:#0f1824}
        .footer{background:#f8fafc;padding:20px 30px;text-align:center;border-top:1px solid #e0e7ef}
        .footer p{color:#a0aec0;font-size:0.8rem;margin:0}
        .btn{display:inline-block;background:#0288d1;color:#fff;text-decoration:none;border-radius:8px;padding:12px 28px;font-weight:600;font-size:0.95rem;margin-top:8px}
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🎫 BilletPro</h1>
        <p>Notification — Nouvelle inscription</p>
    </div>
    <div class="body">
        <span class="badge">Nouvelle inscription</span>
        <h2>Un nouveau {{ $role }} vient de s'inscrire !</h2>
        <p>Bonjour Administrateur, une nouvelle inscription a été effectuée sur la plateforme BilletPro. Veuillez examiner et valider ce compte.</p>

        <div class="user-card">
            <p><strong>👤 Nom :</strong> {{ $nom }}</p>
            <p><strong>📧 Email :</strong> {{ $email }}</p>
            <p><strong>🎭 Rôle :</strong> {{ ucfirst($role) }}</p>
            <p><strong>📅 Date :</strong> {{ date('d/m/Y à H:i') }}</p>
        </div>

        <div class="info-box">
            <p>⚠️ <strong>Action requise :</strong> Ce compte est en attente de validation. Connectez-vous au dashboard admin pour l'activer ou le refuser.</p>
        </div>

        <a href="http://localhost:8000/admin/dashboard" class="btn">Accéder au dashboard admin</a>
    </div>
    <div class="footer">
        <p>© 2026 BilletPro — Université de Djibouti</p>
        <p style="margin-top:4px">Notification automatique du système BilletPro.</p>
    </div>
</div>
</body>
</html>