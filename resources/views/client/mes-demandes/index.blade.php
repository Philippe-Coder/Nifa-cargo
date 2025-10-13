@extends('layouts.dashboard')

@section('title', 'Mes Demandes - NIF Cargo')
@section('page-title', 'Mes Demandes de Transport')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 rounded-2xl p-8 mb-8 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black bg-opacity-10"></div>
    <!-- Pattern Background -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.1\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"1\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    <div class="relative z-10">
        <div class="flex items-center justify-between">
            <div>
                <div class="inline-flex items-center bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-4 border border-white/30">
                    <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                    <span class="text-sm font-medium">Gestion des demandes</span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-bold mb-3">
                    Mes Demandes de Transport
                </h1>
                <p class="text-blue-100 text-lg max-w-2xl">
                    Suivez l'état de toutes vos demandes en temps réel et gérez vos expéditions
                </p>
            </div>
            <div class="hidden lg:block">
                <a href="{{ route('demande.create') }}" 
                   class="bg-white text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center">
                    <i class="fas fa-plus mr-3"></i> Nouvelle Demande
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filtres et Recherche -->
<div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 mb-8">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <!-- Filtres par statut -->
        <div class="flex flex-wrap gap-2">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors shadow-sm">
                <i class="fas fa-list mr-2"></i> Toutes ({{ $demandes->total() }})
            </button>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors flex items-center">
                <i class="fas fa-clock mr-2 text-yellow-500"></i> En attente
            </button>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors flex items-center">
                <i class="fas fa-shipping-fast mr-2 text-blue-500"></i> En cours
            </button>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors flex items-center">
                <i class="fas fa-check-circle mr-2 text-green-500"></i> Livrées
            </button>
        </div>
        
        <!-- Recherche et Filtres avancés -->
        <div class="flex gap-3">
            <div class="relative flex-1 lg:w-64">
                <input type="text" placeholder="Rechercher une demande..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors flex items-center">
                <i class="fas fa-filter mr-2"></i> Filtres
            </button>
        </div>
    </div>
</div>

@if($demandes->count() > 0)
    <!-- Liste des Demandes -->
    <div class="space-y-6">
        @foreach($demandes as $demande)
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 group">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <!-- Informations principales -->
                    <div class="flex-1">
                        <!-- En-tête avec référence et statut -->
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-4 gap-3">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2 flex items-center">
                                    <i class="fas fa-hashtag text-blue-500 mr-2"></i>
                                    {{ $demande->reference ?? 'REF-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT) }}
                                </h3>
                                <div class="flex items-center text-gray-600 mb-3">
                                    <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                                    <span class="font-medium">{{ $demande->ville_depart }}</span>
                                    <i class="fas fa-arrow-right mx-2 text-gray-400 text-sm"></i>
                                    <span class="font-medium">{{ $demande->ville_destination }}</span>
                                </div>
                            </div>
                            @php
                                $statusColors = [
                                    'en attente' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'en cours' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'en transit' => 'bg-purple-100 text-purple-800 border-purple-200',
                                    'livrée' => 'bg-green-100 text-green-800 border-green-200',
                                    'annulée' => 'bg-red-100 text-red-800 border-red-200',
                                ];
                                $statusClass = $statusColors[$demande->statut] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                            @endphp
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium border {{ $statusClass }} self-start">
                                <i class="fas fa-circle mr-2 text-xs"></i>
                                {{ ucfirst($demande->statut) }}
                            </span>
                        </div>
                        
                        <!-- Métadonnées -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm mb-4">
                            <div class="flex items-center text-gray-600 bg-gray-50 px-3 py-2 rounded-lg">
                                <i class="fas fa-box text-purple-500 mr-3"></i>
                                <div>
                                    <div class="font-medium text-gray-900">{{ ucfirst($demande->type) }}</div>
                                    <div class="text-xs text-gray-500">Type de transport</div>
                                </div>
                            </div>
                            <div class="flex items-center text-gray-600 bg-gray-50 px-3 py-2 rounded-lg">
                                <i class="fas fa-calendar text-green-500 mr-3"></i>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $demande->created_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-500">Date de création</div>
                                </div>
                            </div>
                            <div class="flex items-center text-gray-600 bg-gray-50 px-3 py-2 rounded-lg">
                                <i class="fas fa-clock text-orange-500 mr-3"></i>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $demande->created_at->diffForHumans() }}</div>
                                    <div class="text-xs text-gray-500">Dernière mise à jour</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Description -->
                        @if($demande->description)
                            <div class="border-t pt-4">
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    <i class="fas fa-file-alt text-blue-500 mr-2"></i>
                                    {{ Str::limit($demande->description, 150) }}
                                </p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row lg:flex-col gap-2 lg:w-48">
                        <a href="{{ route('mes-demandes.show', $demande) }}" 
                           class="inline-flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition-all duration-300 transform hover:scale-105 shadow-sm group-hover:shadow-md">
                            <i class="fas fa-eye mr-3"></i> Voir détails
                        </a>
                        
                        @if($demande->statut !== 'livrée' && $demande->statut !== 'annulée')
                            <button class="inline-flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200 transition-colors">
                                <i class="fas fa-edit mr-3"></i> Modifier
                            </button>
                        @endif
                        
                        <button class="inline-flex items-center justify-center px-4 py-3 bg-green-50 text-green-700 rounded-xl text-sm font-medium hover:bg-green-100 transition-colors border border-green-200">
                            <i class="fas fa-file-pdf mr-3"></i> Télécharger
                        </button>
                    </div>
                </div>
                
                <!-- Barre de progression -->
                @if($demande->etapes && $demande->etapes->count() > 0)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-3">
                            <span class="font-medium">Progression de l'expédition</span>
                            <span class="font-semibold">{{ $demande->etapes->where('statut', 'terminée')->count() }}/{{ $demande->etapes->count() }} étapes</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            @php
                                $progress = $demande->etapes->count() > 0 
                                    ? ($demande->etapes->where('statut', 'terminée')->count() / $demande->etapes->count()) * 100 
                                    : 0;
                            @endphp
                            <div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full transition-all duration-1000 ease-out" 
                                 style="width: {{ $progress }}%"></div>
                        </div>
                        
                        <!-- Étapes récentes -->
                        <div class="mt-3 flex items-center text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                            Dernière étape: 
                            @if($demande->etapes->where('statut', 'terminée')->last())
                                {{ $demande->etapes->where('statut', 'terminée')->last()->nom }} - 
                                {{ $demande->etapes->where('statut', 'terminée')->last()->updated_at->diffForHumans() }}
                            @else
                                En attente de prise en charge
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    
    <!-- Pagination Personnalisée -->
    @if($demandes->hasPages())
    <div class="mt-8 bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <div class="flex items-center justify-between">
            <!-- Informations de pagination -->
            <div class="text-sm text-gray-700">
                Affichage de 
                <span class="font-medium">{{ $demandes->firstItem() }}</span>
                à 
                <span class="font-medium">{{ $demandes->lastItem() }}</span>
                sur 
                <span class="font-medium">{{ $demandes->total() }}</span>
                demandes
            </div>

            <!-- Liens de pagination -->
            <div class="flex items-center space-x-2">
                <!-- Premier et Précédent -->
                @if($demandes->onFirstPage())
                    <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-lg text-sm cursor-not-allowed">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $demandes->previousPageUrl() }}" class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition-colors">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                @endif

                <!-- Numéros de page -->
                @foreach($demandes->getUrlRange(1, $demandes->lastPage()) as $page => $url)
                    @if($page == $demandes->currentPage())
                        <span class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                <!-- Suivant et Dernier -->
                @if($demandes->hasMorePages())
                    <a href="{{ $demandes->nextPageUrl() }}" class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition-colors">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-lg text-sm cursor-not-allowed">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                @endif
            </div>
        </div>
    </div>
    @endif

@else
    <!-- État vide -->
    <div class="bg-white rounded-2xl p-12 text-center shadow-lg border border-gray-100">
        <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-inbox text-blue-500 text-3xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-3">
            Aucune demande pour le moment
        </h3>
        <p class="text-gray-600 mb-8 max-w-md mx-auto text-lg">
            Vous n'avez pas encore créé de demande de transport. Lancez-vous dès maintenant pour expédier vos marchandises en toute sécurité.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('demande.create') }}" 
               class="inline-flex items-center px-8 py-4 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                <i class="fas fa-plus mr-3"></i> Créer ma première demande
            </a>
            <a href="{{ route('services') }}" 
               class="inline-flex items-center px-8 py-4 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                <i class="fas fa-info-circle mr-3"></i> Découvrir nos services
            </a>
        </div>
    </div>
@endif

<!-- Bouton mobile flottant -->
<div class="lg:hidden fixed bottom-6 right-6 z-50">
    <a href="{{ route('demande.create') }}" 
       class="w-14 h-14 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 transition-all duration-300 transform hover:scale-110">
        <i class="fas fa-plus text-xl"></i>
    </a>
</div>
@endsection

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Animation pour les barres de progression */
@keyframes progressBar {
    0% { width: 0%; }
    100% { width: var(--progress-width); }
}

.progress-bar-animated {
    animation: progressBar 1.5s ease-out;
}

/* Styles pour la pagination responsive */
@media (max-width: 640px) {
    .pagination-info {
        text-align: center;
        margin-bottom: 1rem;
    }
    
    .pagination-links {
        justify-content: center;
    }
}
</style>
@endpush