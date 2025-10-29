<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nouvelle demande de transport créée</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { background-color: white; max-width: 600px; margin: 0 auto; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; padding: 20px; border-radius: 8px; text-align: center; margin-bottom: 20px; }
        .content { padding: 20px 0; line-height: 1.6; color: #333; }
        .info-box { background-color: #f8fafc; padding: 20px; border-left: 4px solid #3b82f6; margin: 20px 0; border-radius: 8px; }
        .tracking-box { background-color: #fef3c7; padding: 20px; border-left: 4px solid #f59e0b; margin: 20px 0; border-radius: 8px; text-align: center; }
        .button { display: inline-block; background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; margin: 15px 5px; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; color: #666; }
        .logo { font-size: 24px; font-weight: bold; }
        .status-badge { display: inline-block; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-progress { background-color: #dbeafe; color: #1e40af; }
        .status-transit { background-color: #e0e7ff; color: #3730a3; }
        .status-delivered { background-color: #d1fae5; color: #065f46; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🚛 NIF CARGO</div>
            <h2 style="margin: 10px 0 0 0;">Nouvelle demande de transport créée</h2>
        </div>
        
        <div class="content">
            <p>Bonjour <strong>{{ $client_name }}</strong>,</p>
            
            <p>📦 Une nouvelle demande de transport a été créée pour vous par notre équipe. Voici les détails de votre expédition :</p>
            
            <div class="tracking-box">
                <h3 style="margin-top: 0; color: #92400e;">🔍 Numéro de suivi</h3>
                <p style="font-size: 24px; font-weight: bold; color: #92400e; margin: 10px 0;">{{ $tracking_number }}</p>
                <p style="font-size: 14px; margin: 0;">Conservez ce numéro pour suivre votre colis</p>
            </div>
            
            <div class="info-box">
                <h3 style="margin-top: 0; color: #1e40af;">📋 Détails de la demande</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold; width: 40%;">📍 Trajet :</td>
                        <td style="padding: 8px 0;">{{ $demande->ville_depart }} → {{ $demande->ville_destination }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold;">📦 Nature du colis :</td>
                        <td style="padding: 8px 0;">{{ $demande->nature_colis }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold;">⚖️ Poids :</td>
                        <td style="padding: 8px 0;">{{ $demande->poids }} kg</td>
                    </tr>
                    @if($demande->volume)
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold;">📏 Volume :</td>
                        <td style="padding: 8px 0;">{{ $demande->volume }} m³</td>
                    </tr>
                    @endif
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold;">🚛 Type transport :</td>
                        <td style="padding: 8px 0;">{{ ucfirst($demande->type) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold;">📊 Statut :</td>
                        <td style="padding: 8px 0;">
                            @php
                                $statusClass = 'status-pending';
                                if($demande->statut === 'en cours') $statusClass = 'status-progress';
                                elseif($demande->statut === 'en transit') $statusClass = 'status-transit';
                                elseif($demande->statut === 'livrée') $statusClass = 'status-delivered';
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ ucfirst($demande->statut) }}</span>
                        </td>
                    </tr>
                    @if($demande->frais_expedition)
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold;">💰 Frais :</td>
                        <td style="padding: 8px 0;">{{ number_format($demande->frais_expedition, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    @endif
                </table>
            </div>
            
            <h3>🌐 Suivez votre expédition</h3>
            <p>Vous pouvez suivre l'évolution de votre colis en temps réel grâce à nos outils de suivi :</p>
            
            <div style="text-align: center;">
                <a href="{{ $suivi_url }}" class="button">
                    🔍 Suivi public (sans connexion)
                </a>
                <a href="{{ $login_url }}" class="button">
                    👤 Mon espace client
                </a>
            </div>
            
            <h3>📱 Notifications</h3>
            <p>Vous recevrez automatiquement des notifications par email et WhatsApp à chaque étape importante de votre expédition :</p>
            <ul>
                <li>✅ Validation et prise en charge</li>
                <li>🛂 Dédouanement (si international)</li>
                <li>🚛 Départ en transit</li>
                <li>📦 Livraison finale</li>
            </ul>
            
            <p>Notre équipe reste à votre disposition pour toute question concernant votre expédition.</p>
        </div>
        
        <div class="footer">
            <p>📞 <strong>Support client :</strong> +228 97 31 11 58</p>
            <p>📧 <strong>Email :</strong> contact@nif-tg.com</p>
            <p>🏢 <strong>Adresse :</strong> Totsi, Lomé - Togo</p>
            <p style="font-size: 12px; color: #999; margin-top: 20px;">© {{ date('Y') }} NIF CARGO - Transport et Logistique</p>
        </div>
    </div>
</body>
</html>