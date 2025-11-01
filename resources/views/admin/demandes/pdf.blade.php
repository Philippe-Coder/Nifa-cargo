<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Export Demandes - NIFA CARGO</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 3px solid #1f2937; padding-bottom: 15px; margin-bottom: 30px; }
        .header h1 { color: #1f2937; margin: 0 0 10px 0; font-size: 24px; font-weight: bold; }
        .header .subtitle { color: #6b7280; font-size: 14px; }
        .info-section { background-color: #f9fafb; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #3b82f6; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 8px; }
        .info-label { font-weight: bold; color: #374151; }
        .info-value { color: #1f2937; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #d1d5db; padding: 10px 8px; text-align: left; }
        th { background-color: #1f2937; color: white; font-weight: bold; font-size: 11px; }
        td { font-size: 10px; }
        .statut-badge { padding: 4px 8px; border-radius: 20px; font-size: 9px; font-weight: bold; text-align: center; color: white; }
        .statut-en-cours { background-color: #f59e42; }
        .statut-terminee { background-color: #10b981; }
        .statut-annulee { background-color: #ef4444; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #d1d5db; color: #6b7280; font-size: 10px; }
        .page-number { text-align: center; color: #6b7280; font-size: 10px; position: fixed; bottom: 10px; width: 100%; }
    </style>
</head>
<body>
    <div class="header">
        <h1>NIFA CARGO</h1>
        <div class="subtitle">Exportation des demandes de transport</div>
    </div>

    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Date d'exportation :</span>
            <span class="info-value">{{ now()->format('d/m/Y à H:i') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Nombre total de demandes :</span>
            <span class="info-value">{{ $demandes->count() }} demande(s)</span>
        </div>
    </div>

    <div class="header">
        <h1>NIFA CARGO</h1>
        @if(isset($demande))
            <div class="subtitle">Demande de Transport - Détails</div>
        @else
            <div class="subtitle">Exportation des demandes de transport</div>
        @endif
                    <th>Référence</th>
                    <th>Client</th>
    @if(isset($demande))
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Référence :</span>
                <span class="info-value">{{ $demande->reference ?? 'REF-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Numéro de suivi :</span>
                <span class="info-value">{{ $demande->numero_tracking ?? '—' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Client :</span>
                <span class="info-value">{{ $demande->user->name ?? '' }} ({{ $demande->user->email ?? '' }})</span>
            </div>
            <div class="info-row">
                <span class="info-label">Trajet :</span>
                <span class="info-value">{{ $demande->origine ?? '' }} → {{ $demande->destination ?? '' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Créée le :</span>
                <span class="info-value">{{ $demande->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Marchandise</th>
                    <th>Poids</th>
                    <th>Volume</th>
                    <th>Statut</th>
                    <th>Date souhaitée</th>
                    <th>Valeur</th>
                    <th>Fragile</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $demande->type ?? '' }}</td>
                    <td>{{ $demande->marchandise ?? '' }}</td>
                    <td>{{ $demande->poids ?? '' }}</td>
                    <td>{{ $demande->volume ?? '' }}</td>
                    <td>{{ ucfirst($demande->statut) }}</td>
                    <td>{{ $demande->date_souhaitee ? \Carbon\Carbon::parse($demande->date_souhaitee)->format('d/m/Y') : '' }}</td>
                    <td>{{ $demande->valeur ?? '' }}</td>
                    <td>{{ $demande->fragile ? 'Oui' : 'Non' }}</td>
                </tr>
            </tbody>
        </table>
    @else
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Date d'exportation :</span>
                <span class="info-value">{{ now()->format('d/m/Y à H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Nombre total de demandes :</span>
                <span class="info-value">{{ $demandes->count() }} demande(s)</span>
            </div>
        </div>
                    <th>Créée le</th>
        @if($demandes->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Client</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Tracking</th>
                        <th>Type</th>
                        <th>Marchandise</th>
                        <th>Poids</th>
                        <th>Volume</th>
                        <th>Origine</th>
                        <th>Destination</th>
                        <th>Statut</th>
                        <th>Créée le</th>
                        <th>Date souhaitée</th>
                        <th>Valeur</th>
                        <th>Fragile</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($demandes as $demande)
                    <tr>
                        <td>{{ $demande->reference ?? 'REF-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $demande->user->name ?? '' }}</td>
                        <td>{{ $demande->user->email ?? '' }}</td>
                        <td>{{ $demande->user->telephone ?? '' }}</td>
                        <td>{{ $demande->numero_tracking ?? '' }}</td>
                        <td>{{ $demande->type ?? '' }}</td>
                        <td>{{ $demande->marchandise ?? '' }}</td>
                        <td>{{ $demande->poids ?? '' }}</td>
                        <td>{{ $demande->volume ?? '' }}</td>
                        <td>{{ $demande->origine ?? '' }}</td>
                        <td>{{ $demande->destination ?? '' }}</td>
                        <td>
                            <span class="statut-badge statut-{{ strtolower($demande->statut) }}">
                                {{ ucfirst($demande->statut) }}
                            </span>
                        </td>
                        <td>{{ $demande->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $demande->date_souhaitee ? \Carbon\Carbon::parse($demande->date_souhaitee)->format('d/m/Y') : '' }}</td>
                        <td>{{ $demande->valeur ?? '' }}</td>
                        <td>{{ $demande->fragile ? 'Oui' : 'Non' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="text-align: center; padding: 40px; color: #6b7280; font-style: italic;">
                Aucune demande trouvée avec les critères sélectionnés
            </div>
        @endif
    @endif