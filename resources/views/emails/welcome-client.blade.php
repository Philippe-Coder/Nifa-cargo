<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bienvenue chez NIF CARGO</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { background-color: white; max-width: 600px; margin: 0 auto; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 20px; border-radius: 8px; text-align: center; margin-bottom: 20px; }
        .content { padding: 20px 0; line-height: 1.6; color: #333; }
        .credentials-box { background-color: #f0fdf4; padding: 20px; border-left: 4px solid #10b981; margin: 20px 0; border-radius: 8px; }
        .button { display: inline-block; background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; margin: 15px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; color: #666; }
        .logo { font-size: 24px; font-weight: bold; }
        .warning { background-color: #fef3c7; padding: 15px; border-left: 4px solid #f59e0b; margin: 15px 0; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">NIF CARGO </div>
            <h2 style="margin: 10px 0 0 0;">Bienvenue dans votre espace client !</h2>
        </div>
        
        <div class="content">
            <p>Bonjour <strong>{{ $client_name }}</strong>,</p>
            
            <p>🎉 <strong>Félicitations !</strong> Votre compte client a été créé avec succès par notre équipe NIF CARGO.</p>
            
            <p>Vous pouvez maintenant suivre toutes vos expéditions en temps réel et gérer vos demandes de transport directement depuis votre espace personnel.</p>
            
            <div class="credentials-box">
                <h3 style="margin-top: 0; color: #065f46;">🔐 Vos identifiants de connexion :</h3>
                <p><strong>📧 Email :</strong> {{ $email }}</p>
                <p><strong>🔑 Mot de passe temporaire :</strong> <code style="background: #e5e7eb; padding: 4px 8px; border-radius: 4px; font-family: monospace; font-size: 16px;">{{ $password }}</code></p>
            </div>
            
            <div class="warning">
                <p><strong>⚠️ Important :</strong> Pour votre sécurité, nous vous recommandons vivement de changer ce mot de passe temporaire lors de votre première connexion.</p>
            </div>
            
            <p style="text-align: center;">
                <a href="{{ $login_url }}" class="button">
                    🌐 Se connecter à mon espace
                </a>
            </p>
            
            <h3>🚀 Que pouvez-vous faire dans votre espace client ?</h3>
            <ul>
                <li>📦 Suivre vos expéditions en temps réel</li>
                <li>📋 Consulter l'historique de vos demandes</li>
                <li>📄 Télécharger vos documents et factures</li>
                <li>💬 Recevoir des notifications sur l'avancement</li>
                <li>📞 Contacter notre équipe support</li>
            </ul>
            
            <p>Notre équipe est à votre disposition pour vous accompagner dans toutes vos expéditions. N'hésitez pas à nous contacter si vous avez des questions.</p>
        </div>
        
        <div class="footer">
            <p>📞 <strong>Support client :</strong> +228 99 25 25 31/ +229 96 36 46 07/ +226 05 79 13 10</p>
            <p>📧 <strong>Email :</strong> contact@nifgroupecargo.com</p>
            <p>🏢 <strong>Adresse :</strong> Totsi, Lomé - Togo</p>
            <p style="font-size: 12px; color: #999; margin-top: 20px;">© {{ date('Y') }} NIF CARGO - Transport et Logistique</p>
        </div>
    </div>
</body>
</html>