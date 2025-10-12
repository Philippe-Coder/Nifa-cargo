@extends('layouts.dashboard')

@section('title', 'Mes Demandes - NIFA')
@section('page-title', 'Mes Demandes de Transport')

@section('content')
<!-- Hero Section -->
<div class="gradient-bg-dashboard rounded-2xl p-8 mb-8 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black bg-opacity-10"></div>
    <div class="relative z-10">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    📦 Mes Demandes de Transport
                </h1>
                <p class="text-blue-100 text-lg">
                    Suivez l'état de toutes vos demandes en temps réel
                </p>
            </div>
            <div class="hidden md:block">
                <a href="{{ route('demande.create') }}" 
                   class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i> Nouvelle Demande
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filtres et Actions -->
<div class="dashboard-card p-6 mb-8 fade-in">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex flex-wrap gap-2">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                Toutes ({{ $demandes->total() }})
            </button>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                En attente
            </button>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                En cours
            </button>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                Livrées
            </button>
        </div>
        
        <div class="flex gap-2">
            <div class="relative">
                <input type="text" placeholder="Rechercher..." 
                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                <i class="fas fa-filter mr-2"></i> Filtrer
            </button>
        </div>
    </div>
</div>

@if($demandes->count() > 0)
    <!-- Liste des Demandes -->
    <div class="space-y-6">
        @foreach($demandes as $demande)
            <div class="dashboard-card p-6 fade-in hover:shadow-lg transition-all duration-300">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <!-- Informations principales -->
                    <div class="flex-1">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                    {{ $demande->reference ?? 'REF-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT) }}
                                </h3>
                                <p class="text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                                    {{ $demande->ville_depart }} → {{ $demande->ville_destination }}
                                </p>
                            </div>
                            <span class="status-badge status-{{ str_replace(' ', '-', strtolower($demande->statut)) }}">
                                {{ $demande->statut }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-box mr-2 text-purple-500"></i>
                                <span>{{ ucfirst($demande->type) }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-calendar mr-2 text-green-500"></i>
                                <span>{{ $demande->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-clock mr-2 text-orange-500"></i>
                                <span>{{ $demande->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        
                        @if($demande->description)
                            <p class="text-gray-600 text-sm mt-3 line-clamp-2">
                                {{ Str::limit($demande->description, 120) }}
                            </p>
                        @endif
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-2 lg:ml-6">
                        <a href="{{ route('mes-demandes.show', $demande) }}" 
                           class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                            <i class="fas fa-eye mr-2"></i> Voir détails
                        </a>
                        
                        @if($demande->statut !== 'livrée')
                            <button class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                                <i class="fas fa-edit mr-2"></i> Modifier
                            </button>
                        @endif
                        
                        <button class="inline-flex items-center justify-center px-4 py-2 bg-green-100 text-green-700 rounded-lg text-sm font-medium hover:bg-green-200 transition-colors">
                            <i class="fas fa-download mr-2"></i> PDF
                        </button>
                    </div>
                </div>
                
                <!-- Barre de progression -->
                @if($demande->etapes && $demande->etapes->count() > 0)
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                            <span>Progression</span>
                            <span>{{ $demande->etapes->where('statut', 'terminée')->count() }}/{{ $demande->etapes->count() }} étapes</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            @php
                                $progress = $demande->etapes->count() > 0 
                                    ? ($demande->etapes->where('statut', 'terminée')->count() / $demande->etapes->count()) * 100 
                                    : 0;
                            @endphp
                            <div class="bg-gradient-to-r from-blue-600 to-green-600 h-2 rounded-full transition-all duration-500" 
                                 style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="mt-8">
        {{ $demandes->links() }}
    </div>
@else
    <!-- État vide -->
    <div class="dashboard-card p-12 text-center fade-in">
        <div class="text-6xl mb-4">📦</div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">
            Aucune demande pour le moment
        </h3>
        <p class="text-gray-600 mb-6 max-w-md mx-auto">
            Vous n'avez pas encore créé de demande de transport. Commencez dès maintenant !
        </p>
        <a href="{{ route('demande.create') }}" 
           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-plus mr-2"></i> Créer ma première demande
        </a>
    </div>
@endif
@endsection

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush
