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
        .body{padding:40px 30px;text-align:center}
        .body h2{color:#0f1824;font-size:1.3rem;margin-bottom:16px}
        .body p{color:#4a5568;line-height:1.7;font-size:0.95rem;margin-bottom:12px}
        .code-box{background:#e3f2fd;border:2px dashed #0288d1;border-radius:12px;padding:30px;margin:24px 0;display:inline-block;width:100%}
        .code{font-size:3rem;font-weight:900;color:#0288d1;letter-spacing:12px}
        .warning{background:#fff3e0;border-left:4px solid #ed8936;border-radius:8px;padding:14px 18px;margin:20px 0;text-align:left}
        .warning p{margin:0;color:#0f1824;font-size:0.88rem}
        .footer{background:#f8fafc;padding:20px 30px;text-align:center;border-top:1px solid #e0e7ef}
        .footer p{color:#a0aec0;font-size:0.8rem;margin:0}
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🎫 BilletPro</h1>
        <p>Réinitialisation de mot de passe</p>
    </div>
    <div class="body">
        <h2>Bonjour {{ $nom }} !</h2>
        <p>Vous avez demandé à réinitialiser votre mot de passe. Voici votre code de vérification :</p>

        <div class="code-box">
            <div class="code">{{ $code }}</div>
            <p style="margin:8px 0 0;color:#0288d1;font-size:0.85rem;font-weight:500">Code valable pendant 15 minutes</p>
        </div>

        <div class="warning">
            <p>⚠️ <strong>Important :</strong> Ne partagez ce code avec personne. BilletPro ne vous demandera jamais votre code par téléphone ou email.</p>
        </div>

        <p style="color:#a0aec0;font-size:0.85rem">Si vous n'avez pas demandé cette réinitialisation, ignorez cet email. Votre mot de passe restera inchangé.</p>
    </div>
    <div class="footer">
        <p>© 2026 BilletPro — Université de Djibouti</p>
        <p style="margin-top:4px">Cet email a été envoyé automatiquement, merci de ne pas y répondre directement.</p>
    </div>
</div>
</body>
</html>