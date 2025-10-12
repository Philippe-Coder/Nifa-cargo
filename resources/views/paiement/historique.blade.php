@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">💳 Historique des paiements</h1>
        <p class="mt-2 text-gray-600">Consultez l'historique de tous vos paiements</p>
    </div>

    @if($paiements->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Référence
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Facture
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Montant
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Méthode
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($paiements as $paiement)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $paiement->reference_paiement }}
                                    </div>
                                    @if($paiement->transaction_id)
                                        <div class="text-xs text-gray-500">
                                            ID: {{ $paiement->transaction_id }}
                                        </div>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $paiement->facture->numero_facture }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $paiement->facture->demandeTransport->marchandise ?? 'Transport' }}
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ number_format($paiement->montant, 0, ',', ' ') }} {{ $paiement->devise }}
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $paiement->methode_paiement_libelle }}
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($paiement->statut == 'reussi') bg-green-100 text-green-800
                                        @elseif($paiement->statut == 'en_cours') bg-blue-100 text-blue-800
                                        @elseif($paiement->statut == 'echec') bg-red-100 text-red-800
                                        @elseif($paiement->statut == 'rembourse') bg-purple-100 text-purple-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        @switch($paiement->statut)
                                            @case('reussi')
                                                ✅ Réussi
                                                @break
                                            @case('en_cours')
                                                ⏳ En cours
                                                @break
                                            @case('echec')
                                                ❌ Échoué
                                                @break
                                            @case('rembourse')
                                                🔄 Remboursé
                                                @break
                                            @default
                                                ⏸️ En attente
                                        @endswitch
                                    </span>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>{{ $paiement->created_at->format('d/m/Y') }}</div>
                                    <div class="text-xs">{{ $paiement->created_at->format('H:i') }}</div>
                                    @if($paiement->date_paiement && $paiement->statut == 'reussi')
                                        <div class="text-xs text-green-600">
                                            Confirmé: {{ $paiement->date_paiement->format('d/m H:i') }}
                                        </div>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('client.suivi.show', $paiement->facture->demande_transport_id) }}" 
                                       class="text-blue-600 hover:underline">
                                        Voir la demande
                                    </a>
                                    
                                    @if($paiement->statut == 'echec' && $paiement->facture->solde_restant > 0)
                                        <div class="mt-1">
                                            <a href="{{ route('paiement.show', $paiement->facture_id) }}" 
                                               class="text-green-600 hover:underline text-xs">
                                                🔄 Réessayer
                                            </a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            
                            @if($paiement->note && $paiement->statut == 'echec')
                                <tr class="bg-red-50">
                                    <td colspan="7" class="px-6 py-2">
                                        <div class="text-xs text-red-700">
                                            <strong>Erreur:</strong> {{ $paiement->note }}
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $paiements->links() }}
        </div>

        <!-- Statistiques -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <span class="text-2xl">💰</span>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">Total payé</div>
                        <div class="text-lg font-semibold text-gray-900">
                            {{ number_format($paiements->where('statut', 'reussi')->sum('montant'), 0, ',', ' ') }} XOF
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <span class="text-2xl">✅</span>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">Paiements réussis</div>
                        <div class="text-lg font-semibold text-green-600">
                            {{ $paiements->where('statut', 'reussi')->count() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <span class="text-2xl">⏳</span>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">En cours</div>
                        <div class="text-lg font-semibold text-blue-600">
                            {{ $paiements->whereIn('statut', ['en_attente', 'en_cours'])->count() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <span class="text-2xl">❌</span>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">Échecs</div>
                        <div class="text-lg font-semibold text-red-600">
                            {{ $paiements->where('statut', 'echec')->count() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <span class="text-4xl">💳</span>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun paiement</h3>
            <p class="text-gray-600 mb-6">Vous n'avez effectué aucun paiement pour le moment.</p>
            <a href="{{ route('client.suivi.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors">
                📋 Voir mes demandes
            </a>
        </div>
    @endif
</div>
@endsection
