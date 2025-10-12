@extends('layouts.dashboard')

@section('title', 'Dashboard Client - NIFA')
@section('page-title', 'Mon Espace Client')

@section('content')
<!-- Hero Section -->
<div class="gradient-bg-dashboard rounded-2xl p-8 mb-8 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black bg-opacity-10"></div>
    <div class="relative z-10">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    👋 Bonjour, {{ Auth::user()->name }} !
                </h1>
                <p class="text-blue-100 text-lg">
                    Bienvenue dans votre espace client NIFA
                </p>
            </div>
            <div class="hidden md:block">
                <div class="text-6xl opacity-20">
                    📦
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Demandes -->
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Total Demandes</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_demandes'] ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-boxes text-blue-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600 font-medium">
                <i class="fas fa-arrow-up mr-1"></i> +12%
            </span>
            <span class="text-gray-500 ml-2">ce mois</span>
        </div>
    </div>
    
    <!-- En Cours -->
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">En Cours</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['en_cours'] ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-blue-600 font-medium">
                <i class="fas fa-sync mr-1"></i> Actif
            </span>
            <span class="text-gray-500 ml-2">suivi temps réel</span>
        </div>
    </div>
    
    <!-- Livrées -->
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Livrées</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['livrees'] ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600 font-medium">
                <i class="fas fa-thumbs-up mr-1"></i> 98%
            </span>
            <span class="text-gray-500 ml-2">satisfaction</span>
        </div>
    </div>
    
    <!-- Montant Total -->
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Montant Total</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['montant_total'] ?? 0) }} F</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-wallet text-purple-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-purple-600 font-medium">
                <i class="fas fa-chart-line mr-1"></i> +8%
            </span>
            <span class="text-gray-500 ml-2">vs mois dernier</span>
        </div>
    </div>
</div>

<!-- Actions Rapides -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Actions -->
    <div class="lg:col-span-2">
        <div class="dashboard-card p-6 fade-in">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">
                ⚡ Actions Rapides
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('demande.create') }}" 
                   class="flex items-center p-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 transform hover:scale-105">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-plus text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Nouvelle Demande</h3>
                        <p class="text-sm text-blue-100">Créer une demande de transport</p>
                    </div>
                </a>
                
                <a href="{{ route('mes-demandes') }}" 
                   class="flex items-center p-4 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-300 transform hover:scale-105">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-list text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Mes Demandes</h3>
                        <p class="text-sm text-green-100">Voir toutes mes demandes</p>
                    </div>
                </a>
                
                <a href="{{ route('suivi.public') }}" 
                   class="flex items-center p-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all duration-300 transform hover:scale-105">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-search text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Suivi Colis</h3>
                        <p class="text-sm text-purple-100">Suivre un envoi</p>
                    </div>
                </a>
                
                <a href="{{ route('contact') }}" 
                   class="flex items-center p-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 transform hover:scale-105">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-headset text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Support</h3>
                        <p class="text-sm text-red-100">Contacter l'équipe</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Profil -->
    <div class="dashboard-card p-6 fade-in">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">
            👤 Mon Profil
        </h2>
        <div class="space-y-4">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center mr-4">
                    <span class="text-white text-xl font-bold">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </span>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">{{ Auth::user()->name }}</h3>
                    <p class="text-gray-600">{{ Auth::user()->email }}</p>
                    <span class="inline-block mt-1 px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                        Client NIFA
                    </span>
                </div>
            </div>
            
            <div class="border-t pt-4">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Membre depuis</span>
                        <span class="font-medium">{{ Auth::user()->created_at->format('M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Statut</span>
                        <span class="text-green-600 font-medium">
                            <i class="fas fa-check-circle mr-1"></i> Actif
                        </span>
                    </div>
                </div>
            </div>
            
            <button class="w-full mt-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors">
                <i class="fas fa-edit mr-2"></i> Modifier le profil
            </button>
        </div>
    </div>
</div>

<!-- Dernières Demandes -->
<div class="dashboard-card p-6 fade-in">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-900">
            📦 Dernières Demandes
        </h2>
        <a href="{{ route('mes-demandes') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
            Voir tout <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    
    @if(isset($recent_demandes) && $recent_demandes->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Référence</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Destination</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Statut</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Date</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recent_demandes as $demande)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <span class="font-mono text-sm font-medium text-blue-600">
                                    {{ $demande->reference }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-gray-900">{{ $demande->ville_destination }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="status-badge status-{{ str_replace(' ', '-', strtolower($demande->statut)) }}">
                                    {{ $demande->statut }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-600 text-sm">
                                {{ $demande->created_at->format('d/m/Y') }}
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('mes-demandes.show', $demande) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-eye mr-1"></i> Voir
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📦</div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune demande pour le moment</h3>
            <p class="text-gray-600 mb-6">Commencez par créer votre première demande de transport</p>
            <a href="{{ route('demande.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i> Créer une demande
            </a>
        </div>
    @endif
</div>
@endsection
