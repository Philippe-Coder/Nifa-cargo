<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Référence paiement
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Date
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Montant
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Statut
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Facture
                </th>
                <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Actions</span>
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($paiements as $paiement)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">
                        {{ $paiement->reference_paiement }}
                        @if(optional($paiement->facture)->demandeTransport)
                        <p class="text-xs text-gray-500">
                            Suivi: {{ $paiement->facture->demandeTransport->numero_tracking ?? '—' }}
                        </p>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">
                        {{ $paiement->date_paiement ? $paiement->date_paiement->format('d/m/Y H:i') : '-' }}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">
                        {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
                    </div>
                    @if($paiement->frais > 0)
                    <div class="text-xs text-gray-500">
                        Frais: {{ number_format($paiement->frais, 0, ',', ' ') }} FCFA
                    </div>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $statusClasses = [
                            'payé' => 'bg-green-100 text-green-800',
                            'en_attente' => 'bg-yellow-100 text-yellow-800',
                            'échoué' => 'bg-red-100 text-red-800',
                            'annulé' => 'bg-gray-100 text-gray-800',
                            'remboursé' => 'bg-blue-100 text-blue-800',
                        ][$paiement->statut] ?? 'bg-gray-100 text-gray-800';
                        
                        $statusLabels = [
                            'payé' => 'Payé',
                            'en_attente' => 'En attente',
                            'échoué' => 'Échoué',
                            'annulé' => 'Annulé',
                            'remboursé' => 'Remboursé',
                        ];
                    @endphp
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses }}">
                        {{ $statusLabels[$paiement->statut] ?? ucfirst($paiement->statut) }}
                    </span>
                    
                    @if($paiement->statut === 'en_attente' && $paiement->lien_paiement)
                    <div class="mt-1">
                        <a href="{{ $paiement->lien_paiement }}" target="_blank" 
                           class="text-xs text-indigo-600 hover:text-indigo-900">
                            Payer maintenant
                        </a>
                    </div>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($paiement->facture)
                    <a href="{{ route('factures.show', $paiement->facture) }}" 
                       class="text-indigo-600 hover:text-indigo-900 text-sm">
                        {{ $paiement->facture->numero }}
                    </a>
                    @else
                    <span class="text-gray-500 text-sm">-</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex space-x-2">
                        <a href="{{ route('paiement.show', $paiement) }}" 
                           class="text-indigo-600 hover:text-indigo-900"
                           data-bs-toggle="tooltip" title="Voir les détails">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($paiement->statut === 'en_attente' && $paiement->lien_paiement)
                        <a href="{{ $paiement->lien_paiement }}" target="_blank" 
                           class="text-green-600 hover:text-green-900"
                           data-bs-toggle="tooltip" title="Payer maintenant">
                            <i class="fas fa-credit-card"></i>
                        </a>
                        @endif
                        @if($paiement->statut === 'payé' && $paiement->facture)
                        <a href="{{ route('factures.download', $paiement->facture) }}" 
                           class="text-blue-600 hover:text-blue-900"
                           data-bs-toggle="tooltip" title="Télécharger la facture">
                            <i class="fas fa-file-invoice"></i>
                        </a>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                    Aucun paiement trouvé.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
