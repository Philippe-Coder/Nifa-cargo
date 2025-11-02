@extends('layouts.dashboard')

@section('title', 'Historique des paiements')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- En-tête -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Historique des paiements</h1>
            <p class="text-gray-600">Consultez l'historique de tous vos paiements</p>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <form action="{{ route('paiement.historique') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="reference" class="block text-sm font-medium text-gray-700">Référence</label>
                <input type="text" name="reference" id="reference" value="{{ request('reference') }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                <select id="statut" name="statut" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                    <option value="">Tous les statuts</option>
                    <option value="payé" {{ request('statut') == 'payé' ? 'selected' : '' }}>Payé</option>
                    <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="échoué" {{ request('statut') == 'échoué' ? 'selected' : '' }}>Échoué</option>
                    <option value="annulé" {{ request('statut') == 'annulé' ? 'selected' : '' }}>Annulé</option>
                </select>
            </div>
            <div>
                <label for="date_debut" class="block text-sm font-medium text-gray-700">Du</label>
                <input type="date" name="date_debut" id="date_debut" value="{{ request('date_debut') }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div class="flex items-end space-x-2">
                <div class="flex-1">
                    <label for="date_fin" class="block text-sm font-medium text-gray-700">Au</label>
                    <input type="date" name="date_fin" id="date_fin" value="{{ request('date_fin') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-filter mr-2"></i> Filtrer
                </button>
                <a href="{{ route('paiement.historique') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-redo mr-2"></i> Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <!-- Cartes de synthèse -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Paiements réussis</p>
                    <h3 class="text-2xl font-bold">{{ number_format($stats['total_payes'], 0, ',', ' ') }} FCFA</h3>
                    <p class="text-xs text-gray-500">{{ $stats['count_payes'] }} transactions</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">En attente</p>
                    <h3 class="text-2xl font-bold">{{ number_format($stats['total_en_attente'], 0, ',', ' ') }} FCFA</h3>
                    <p class="text-xs text-gray-500">{{ $stats['count_en_attente'] }} transactions</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                    <i class="fas fa-times-circle text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Échoués/Annulés</p>
                    <h3 class="text-2xl font-bold">{{ number_format($stats['total_echoues'], 0, ',', ' ') }} FCFA</h3>
                    <p class="text-xs text-gray-500">{{ $stats['count_echoues'] }} transactions</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des paiements -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Dernières transactions
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Liste de toutes vos transactions de paiement
            </p>
        </div>
        
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
                                   class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($paiement->statut === 'en_attente' && $paiement->lien_paiement)
                                <a href="{{ $paiement->lien_paiement }}" target="_blank" 
                                   class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-credit-card"></i>
                                </a>
                                @endif
                                @if($paiement->statut === 'payé' && $paiement->facture)
                                <a href="{{ route('factures.download', $paiement->facture) }}" 
                                   class="text-blue-600 hover:text-blue-900">
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
        
        @if($paiements->hasPages())
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                @if($paiements->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white opacity-50 cursor-not-allowed">
                    Précédent
                </span>
                @else
                <a href="{{ $paiements->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Précédent
                </a>
                @endif
                
                @if($paiements->hasMorePages())
                <a href="{{ $paiements->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Suivant
                </a>
                @else
                <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white opacity-50 cursor-not-allowed">
                    Suivant
                </span>
                @endif
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Affichage de
                        <span class="font-medium">{{ $paiements->firstItem() }}</span>
                        à
                        <span class="font-medium">{{ $paiements->lastItem() }}</span>
                        sur
                        <span class="font-medium">{{ $paiements->total() }}</span>
                        résultats
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        @if($paiements->onFirstPage())
                        <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-300 cursor-not-allowed">
                            <span class="sr-only">Précédent</span>
                            <i class="fas fa-chevron-left"></i>
                        </span>
                        @else
                        <a href="{{ $paiements->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Précédent</span>
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        @endif

                        @foreach($paiements->getUrlRange(1, $paiements->lastPage()) as $page => $url)
                            @if($page == $paiements->currentPage())
                            <span aria-current="page" class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                {{ $page }}
                            </span>
                            @else
                            <a href="{{ $url }}" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                {{ $page }}
                            </a>
                            @endif
                        @endforeach

                        @if($paiements->hasMorePages())
                        <a href="{{ $paiements->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Suivant</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        @else
                        <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-300 cursor-not-allowed">
                            <span class="sr-only">Suivant</span>
                            <i class="fas fa-chevron-right"></i>
                        </span>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Section d'aide -->
    <div class="mt-8 bg-indigo-50 rounded-lg p-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-question-circle text-indigo-400 text-2xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-indigo-800">Besoin d'aide avec un paiement ?</h3>
                <div class="mt-2 text-sm text-indigo-700">
                    <p>Si vous rencontrez des difficultés avec un paiement ou si vous avez des questions, n'hésitez pas à contacter notre service client.</p>
                </div>
                <div class="mt-4">
                    <a href="{{ route('contact') }}" class="inline-flex items-center text-sm font-medium text-indigo-700 hover:text-indigo-600">
                        Contacter le support <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Script pour gérer les interactions utilisateur
    document.addEventListener('DOMContentLoaded', function() {
        // Initialisation des tooltips si nécessaire
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Gestion de la confirmation avant annulation de paiement
        document.querySelectorAll('.btn-cancel-paiement').forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Êtes-vous sûr de vouloir annuler ce paiement ?')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endpush
@endsection
