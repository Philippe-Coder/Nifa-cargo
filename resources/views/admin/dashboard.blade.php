@extends('layouts.dashboard')

@section('title', 'Dashboard Admin - NIFA')
@section('page-title', 'Administration NIFA')

@section('content')
<!-- Hero Section -->
<div class="gradient-bg-dashboard rounded-2xl p-8 mb-8 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black bg-opacity-10"></div>
    <div class="relative z-10">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    👨‍💼 Bonjour, {{ Auth::user()->name }} !
                </h1>
                <p class="text-blue-100 text-lg">
                    Tableau de bord administrateur NIFA
                </p>
            </div>
            <div class="hidden md:block">
                <div class="text-6xl opacity-20">
                    📊
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Clients -->
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Clients Enregistrés</p>
                <p class="text-3xl font-bold text-gray-900">{{ $clientsCount ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600 font-medium">
                <i class="fas fa-arrow-up mr-1"></i> +5%
            </span>
            <span class="text-gray-500 ml-2">ce mois</span>
        </div>
    </div>
    
    <!-- Total Demandes -->
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Demandes Totales</p>
                <p class="text-3xl font-bold text-gray-900">{{ $demandesCount ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-boxes text-indigo-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-blue-600 font-medium">
                <i class="fas fa-chart-line mr-1"></i> +18%
            </span>
            <span class="text-gray-500 ml-2">vs mois dernier</span>
        </div>
    </div>
    
    <!-- En Attente -->
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">En Attente</p>
                <p class="text-3xl font-bold text-gray-900">{{ $demandesEnAttente ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-yellow-600 font-medium">
                <i class="fas fa-exclamation-triangle mr-1"></i> Urgent
            </span>
            <span class="text-gray-500 ml-2">à traiter</span>
        </div>
    </div>
    
    <!-- Livrées -->
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Livraisons Terminées</p>
                <p class="text-3xl font-bold text-gray-900">{{ $demandesLivrees ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600 font-medium">
                <i class="fas fa-thumbs-up mr-1"></i> 97%
            </span>
            <span class="text-gray-500 ml-2">satisfaction</span>
        </div>
    </div>
</div>

<!-- Actions Rapides Admin -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Actions -->
    <div class="lg:col-span-2">
        <div class="dashboard-card p-6 fade-in">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">
                ⚡ Actions Administrateur
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('admin.demandes.index') }}" 
                   class="flex items-center p-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 transform hover:scale-105">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-boxes text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Gérer Demandes</h3>
                        <p class="text-sm text-blue-100">Voir toutes les demandes</p>
                    </div>
                </a>
                
                <a href="{{ route('admin.clients.index') }}" 
                   class="flex items-center p-4 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-300 transform hover:scale-105">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Clients</h3>
                        <p class="text-sm text-green-100">Gérer les clients</p>
                    </div>
                </a>
                
                <a href="{{ route('admin.annonces.index') }}" 
                   class="flex items-center p-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all duration-300 transform hover:scale-105">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-bullhorn text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Annonces</h3>
                        <p class="text-sm text-purple-100">Gérer les annonces</p>
                    </div>
                </a>
                
                <a href="{{ route('admin.galeries.index') }}" 
                   class="flex items-center p-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 transform hover:scale-105">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-images text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Galerie</h3>
                        <p class="text-sm text-red-100">Photos entreprise</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Activité Récente -->
    <div class="dashboard-card p-6 fade-in">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">
            📊 Activité Récente
        </h2>
        <div class="space-y-4">
            <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-plus text-white text-sm"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Nouvelle demande</p>
                    <p class="text-xs text-gray-500">Il y a 5 minutes</p>
                </div>
            </div>
            
            <div class="flex items-center p-3 bg-green-50 rounded-lg">
                <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-check text-white text-sm"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Livraison terminée</p>
                    <p class="text-xs text-gray-500">Il y a 1 heure</p>
                </div>
            </div>
            
            <div class="flex items-center p-3 bg-yellow-50 rounded-lg">
                <div class="w-10 h-10 bg-yellow-600 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-user text-white text-sm"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Nouveau client</p>
                    <p class="text-xs text-gray-500">Il y a 2 heures</p>
                </div>
            </div>
        </div>
        
        <button class="w-full mt-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors">
            <i class="fas fa-history mr-2"></i> Voir tout l'historique
        </button>
    </div>
</div>

<!-- Dernières Demandes -->
<div class="dashboard-card p-6 fade-in">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-900">
            🕒 Dernières Demandes Reçues
        </h2>
        <a href="{{ route('admin.demandes.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
            Voir toutes <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    
    @if($dernieresDemandes->isEmpty())
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📦</div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune demande récente</h3>
            <p class="text-gray-600">Les nouvelles demandes apparaîtront ici</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Client</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Type</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Référence</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Statut</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Date</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dernieresDemandes as $demande)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white text-xs font-bold">
                                            {{ substr($demande->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $demande->user->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-gray-900">{{ ucfirst($demande->type) }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-mono text-sm font-medium text-blue-600">
                                    {{ $demande->reference ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="status-badge status-{{ str_replace(' ', '-', strtolower($demande->statut)) }}">
                                    {{ ucfirst($demande->statut) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-600 text-sm">
                                {{ $demande->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.demandes.show', $demande) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-eye mr-1"></i> Voir
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
