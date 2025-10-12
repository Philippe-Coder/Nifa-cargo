@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">📦 Mes Demandes de Transport</h1>
        <p class="mt-2 text-gray-600">Suivez l'état de vos demandes de transport en temps réel</p>
    </div>

    @if($demandes->count() > 0)
        <div class="grid gap-6">
            @foreach($demandes as $demande)
                <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ $demande->marchandise ?? 'Transport' }} - {{ ucfirst($demande->type) }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $demande->origine }} → {{ $demande->destination }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Créée le {{ $demande->created_at->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium
                                    @if($demande->statut == 'livrée') bg-green-100 text-green-800
                                    @elseif($demande->statut == 'en transit') bg-blue-100 text-blue-800
                                    @elseif($demande->statut == 'validée') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($demande->statut) }}
                                </span>
                            </div>
                        </div>

                        <!-- Barre de progression -->
                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span>Progression</span>
                                <span>{{ $demande->pourcentage_progression }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                                     style="width: {{ $demande->pourcentage_progression }}%"></div>
                            </div>
                        </div>

                        <!-- Étape actuelle -->
                        @if($demande->etape_actuelle)
                            <div class="mb-4 p-3 bg-blue-50 rounded-lg">
                                <p class="text-sm font-medium text-blue-900">
                                    🔄 Étape actuelle: {{ $demande->etape_actuelle->nom }}
                                </p>
                                <p class="text-xs text-blue-700 mt-1">
                                    {{ $demande->etape_actuelle->description }}
                                </p>
                            </div>
                        @endif

                        <!-- Informations supplémentaires -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-600 mb-4">
                            @if($demande->poids)
                                <div>
                                    <span class="font-medium">Poids:</span> {{ $demande->poids }} kg
                                </div>
                            @endif
                            <div>
                                <span class="font-medium">Documents:</span> {{ $demande->documents->count() }}
                            </div>
                            <div>
                                <span class="font-medium">Étapes:</span> {{ $demande->etapes->where('statut', 'terminee')->count() }}/{{ $demande->etapes->count() }}
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3">
                            <a href="{{ route('client.suivi.show', $demande->id) }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                                📋 Voir détails
                            </a>
                            
                            @if($demande->documents->count() > 0)
                                <span class="inline-flex items-center px-3 py-2 bg-green-100 text-green-800 text-sm font-medium rounded-md">
                                    📄 {{ $demande->documents->count() }} document(s)
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $demandes->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <span class="text-4xl">📦</span>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune demande de transport</h3>
            <p class="text-gray-600 mb-6">Vous n'avez pas encore fait de demande de transport.</p>
            <a href="{{ route('demande.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors">
                ➕ Faire une nouvelle demande
            </a>
        </div>
    @endif
</div>
@endsection
