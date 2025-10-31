<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de Transport - {{ $demande->numero_tracking ?? 'TRK-' . $demande->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: #fff;
        }

        .header {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header .subtitle {
            font-size: 14px;
            opacity: 0.9;
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section h2 {
            background: #f8fafc;
            border-left: 4px solid #3b82f6;
            padding: 8px 12px;
            font-size: 16px;
            margin-bottom: 15px;
            color: #1e40af;
        }

        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .info-row {
            display: table-row;
        }

        .info-label, .info-value {
            display: table-cell;
            padding: 8px 12px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
            background: #f9fafb;
            width: 35%;
            color: #374151;
        }

        .info-value {
            color: #1f2937;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-progress {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-transit {
            background: #fed7aa;
            color: #c2410c;
        }

        .status-delivered {
            background: #d1fae5;
            color: #065f46;
        }

        .etapes-timeline {
            margin-left: 20px;
        }

        .etape-item {
            position: relative;
            padding-left: 30px;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-left: 2px solid #e5e7eb;
        }

        .etape-item:last-child {
            border-left: none;
        }

        .etape-circle {
            position: absolute;
            left: -8px;
            top: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #e5e7eb;
        }

        .etape-item.completed .etape-circle {
            background: #10b981;
        }

        .etape-item.in-progress .etape-circle {
            background: #3b82f6;
        }

        .etape-title {
            font-weight: bold;
            color: #1f2937;
        }

        .etape-description {
            color: #6b7280;
            font-size: 11px;
            margin-top: 2px;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }

        .tracking-code {
            background: #1f2937;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 11px;
        }

        .two-column {
            display: table;
            width: 100%;
        }

        .column {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 15px;
        }

        .column:last-child {
            padding-right: 0;
            padding-left: 15px;
        }

        .highlight {
            background: #fef3c7;
            padding: 2px 4px;
            border-radius: 3px;
        }

        @page {
            margin: 20mm;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- En-tête -->
    <div class="header">
        <h1>📦 NIF CARGO</h1>
        <div class="subtitle">Demande de Transport & Logistique</div>
        <div style="margin-top: 10px;">
            <span class="tracking-code">{{ $demande->numero_tracking ?? 'TRK-' . $demande->id }}</span>
        </div>
    </div>

    <!-- Informations générales -->
    <div class="section">
        <h2>📋 Informations Générales</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Numéro de suivi</div>
                <div class="info-value">{{ $demande->numero_tracking ?? 'TRK-' . $demande->id }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Date de création</div>
                <div class="info-value">{{ $demande->created_at->format('d/m/Y à H:i') }}</div>
            </div>
            @if($demande->date_souhaitee)
            <div class="info-row">
                <div class="info-label">Date souhaitée</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($demande->date_souhaitee)->format('d/m/Y') }}</div>
            </div>
            @endif
            <div class="info-row">
                <div class="info-label">Statut</div>
                <div class="info-value">
                    <span class="status-badge 
                        @if($demande->statut === 'en attente') status-pending
                        @elseif($demande->statut === 'en cours') status-progress
                        @elseif($demande->statut === 'en transit') status-transit
                        @elseif($demande->statut === 'livrée') status-delivered
                        @endif">
                        {{ ucfirst($demande->statut) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Informations Client -->
    <div class="section">
        <h2>👤 Informations Client</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nom complet</div>
                <div class="info-value">{{ $demande->user->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $demande->user->email }}</div>
            </div>
            @if($demande->user->telephone)
            <div class="info-row">
                <div class="info-label">Téléphone</div>
                <div class="info-value">{{ $demande->user->telephone }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Détails du Transport -->
    <div class="section">
        <h2>🚛 Détails du Transport</h2>
        <div class="two-column">
            <div class="column">
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Type</div>
                        <div class="info-value">{{ ucfirst($demande->type) }}</div>
                    </div>
                    @if($demande->type_transport)
                    <div class="info-row">
                        <div class="info-label">Mode</div>
                        <div class="info-value">{{ $demande->type_transport }}</div>
                    </div>
                    @endif
                    <div class="info-row">
                        <div class="info-label">Origine</div>
                        <div class="info-value">{{ $demande->origine ?? 'Non spécifiée' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Destination</div>
                        <div class="info-value">{{ $demande->destination ?? 'Non spécifiée' }}</div>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="info-grid">
                    @if($demande->ville_depart)
                    <div class="info-row">
                        <div class="info-label">Ville départ</div>
                        <div class="info-value">{{ $demande->ville_depart }}</div>
                    </div>
                    @endif
                    @if($demande->ville_destination)
                    <div class="info-row">
                        <div class="info-label">Ville arrivée</div>
                        <div class="info-value">{{ $demande->ville_destination }}</div>
                    </div>
                    @endif
                    @if($demande->frais_expedition)
                    <div class="info-row">
                        <div class="info-label">Frais</div>
                        <div class="info-value">{{ number_format($demande->frais_expedition, 0, ',', ' ') }} FCFA</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Informations Colis -->
    <div class="section">
        <h2>📦 Informations du Colis</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nature du colis</div>
                <div class="info-value">{{ $demande->nature_colis ?? $demande->marchandise ?? 'Non spécifiée' }}</div>
            </div>
            @if($demande->poids)
            <div class="info-row">
                <div class="info-label">Poids</div>
                <div class="info-value"><strong>{{ $demande->poids }} kg</strong></div>
            </div>
            @endif
            @if($demande->volume)
            <div class="info-row">
                <div class="info-label">Volume</div>
                <div class="info-value"><strong>{{ $demande->volume }} m³</strong></div>
            </div>
            @endif
            @if($demande->valeur)
            <div class="info-row">
                <div class="info-label">Valeur déclarée</div>
                <div class="info-value">{{ number_format($demande->valeur, 0, ',', ' ') }} FCFA</div>
            </div>
            @endif
            @if($demande->fragile)
            <div class="info-row">
                <div class="info-label">Fragile</div>
                <div class="info-value"><span class="highlight">⚠️ OUI - Manipulation délicate requise</span></div>
            </div>
            @endif
            @if($demande->description)
            <div class="info-row">
                <div class="info-label">Description</div>
                <div class="info-value">{{ $demande->description }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Étapes Logistiques -->
    @if($demande->etapes && $demande->etapes->count() > 0)
    <div class="section">
        <h2>🚀 Suivi Logistique</h2>
        <div class="etapes-timeline">
            @foreach($demande->etapes as $etape)
                <div class="etape-item {{ $etape->statut === 'terminee' ? 'completed' : ($etape->statut === 'en_cours' ? 'in-progress' : '') }}">
                    <div class="etape-circle"></div>
                    <div class="etape-title">
                        {{ $etape->nom }}
                        @if($etape->statut === 'terminee') ✅
                        @elseif($etape->statut === 'en_cours') 🔄
                        @else ⏳
                        @endif
                    </div>
                    <div class="etape-description">{{ $etape->description }}</div>
                    @if($etape->agent)
                        <div class="etape-description">👨‍💼 Agent: {{ $etape->agent->name }}</div>
                    @endif
                    @if($etape->date_debut)
                        <div class="etape-description">📅 Début: {{ \Carbon\Carbon::parse($etape->date_debut)->format('d/m/Y H:i') }}</div>
                    @endif
                    @if($etape->date_fin)
                        <div class="etape-description">✅ Fin: {{ \Carbon\Carbon::parse($etape->date_fin)->format('d/m/Y H:i') }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <div>
            <strong>NIF CARGO</strong> - Transport & Logistique en Afrique<br>
            📧 contact@nifcargo.com | 📞 +228 XX XX XX XX | 🌐 www.nifgroupecargo.com
        </div>
        <div style="margin-top: 5px;">
            Document généré le {{ now()->format('d/m/Y à H:i') }}
        </div>
    </div>
</body>
</html>