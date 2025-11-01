<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Clients</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #1f2937;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #1f2937;
            margin: 0 0 10px 0;
            font-size: 24px;
            font-weight: bold;
        }
        .header .subtitle {
            color: #6b7280;
            font-size: 14px;
        }
        .info-section {
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #3b82f6;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .info-row:last-child {
            margin-bottom: 0;
        }
        .info-label {
            font-weight: bold;
            color: #374151;
        }
        .info-value {
            color: #1f2937;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 10px 8px;
            text-align: left;
        }
        th {
            background-color: #1f2937;
            color: white;
            font-weight: bold;
            font-size: 11px;
        }
        td {
            font-size: 10px;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: bold;
            text-align: center;
            color: white;
        }
        .status-verifie {
            background-color: #10b981;
        }
        .status-non-verifie {
            background-color: #ef4444;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #d1d5db;
            color: #6b7280;
            font-size: 10px;
        }
        .page-number {
            text-align: center;
            color: #6b7280;
            font-size: 10px;
            position: fixed;
            bottom: 10px;
            width: 100%;
        }
        .total-badge {
            display: inline-block;
            background-color: #3b82f6;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>NIFA CARGO</h1>
        <div class="subtitle">Liste des Clients</div>
    </div>

    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Date d'exportation :</span>
            <span class="info-value">{{ now()->format('d/m/Y à H:i') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Nombre total de clients :</span>
            <span class="info-value">{{ $clients->count() }} client(s)</span>
        </div>
        <div class="info-row">
            <span class="info-label">Clients vérifiés :</span>
            <span class="info-value">{{ $clients->whereNotNull('email_verified_at')->count() }} client(s)</span>
        </div>
        <div class="info-row">
            <span class="info-label">Clients non vérifiés :</span>
            <span class="info-value">{{ $clients->whereNull('email_verified_at')->count() }} client(s)</span>
        </div>
    </div>

    @if($clients->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 20%;">Nom</th>
                    <th style="width: 25%;">Email</th>
                    <th style="width: 15%;">Téléphone</th>
                    <th style="width: 12%;">Statut</th>
                    <th style="width: 8%;">Demandes</th>
                    <th style="width: 10%;">Inscription</th>
                    <th style="width: 10%;">Dernière activité</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr>
                    <td style="font-weight: bold;">{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->telephone ?? 'Non renseigné' }}</td>
                    <td>
                        <span class="status-badge {{ $client->email_verified_at ? 'status-verifie' : 'status-non-verifie' }}">
                            {{ $client->email_verified_at ? 'Vérifié' : 'Non vérifié' }}
                        </span>
                    </td>
                    <td style="text-align: center; font-weight: bold;">
                        {{ $client->demandes_count }}
                    </td>
                    <td>{{ $client->created_at->format('d/m/Y') }}</td>
                    <td>{{ $client->updated_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align: center; padding: 40px; color: #6b7280; font-style: italic;">
            Aucun client trouvé avec les critères sélectionnés
        </div>
    @endif

    <div class="footer">
        <div><strong>NIFA CARGO</strong> - Système de Gestion des Clients</div>
        <div>Exporté le {{ now()->format('d/m/Y à H:i:s') }}</div>
    </div>

    <div class="page-number">
        Page <span class="pagenum"></span>
    </div>
</body>
</html>