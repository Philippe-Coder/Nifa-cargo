@extends('layouts.dashboard')

@section('title', 'Dashboard Admin - NIFA')
@section('page-title', 'Administration NIFA')

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
                    <span class="text-sm font-medium">Tableau de bord administrateur</span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-bold mb-3">
                    Bonjour, {{ Auth::user()->name }} !
                </h1>
                <p class="text-blue-100 text-lg max-w-2xl">
                    Gérez l'ensemble des activités de NIFA et supervisez les opérations en temps réel
                </p>
            </div>
            <div class="hidden lg:block">
                <div class="text-6xl opacity-20">
                    <i class="fas fa-cogs"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Clients -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Clients Enregistrés</p>
                <p class="text-3xl font-bold text-gray-900">{{ $clientsCount ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600 font-medium flex items-center">
                <i class="fas fa-arrow-up mr-1 text-xs"></i> +5%
            </span>
            <span class="text-gray-500 ml-2">ce mois</span>
        </div>
    </div>
    
    <!-- Total Demandes -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Demandes Totales</p>
                <p class="text-3xl font-bold text-gray-900">{{ $demandesCount ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-shipping-fast text-indigo-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-blue-600 font-medium flex items-center">
                <i class="fas fa-chart-line mr-1 text-xs"></i> +18%
            </span>
            <span class="text-gray-500 ml-2">vs mois dernier</span>
        </div>
    </div>
    
    <!-- En Attente -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">En Attente</p>
                <p class="text-3xl font-bold text-gray-900">{{ $demandesEnAttente ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-yellow-600 font-medium flex items-center">
                <i class="fas fa-exclamation-circle mr-1 text-xs"></i> À traiter
            </span>
            <span class="text-gray-500 ml-2">action requise</span>
        </div>
    </div>
    
    <!-- Livrées -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Livraisons Terminées</p>
                <p class="text-3xl font-bold text-gray-900">{{ $demandesLivrees ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600 font-medium flex items-center">
                <i class="fas fa-thumbs-up mr-1 text-xs"></i> 97%
            </span>
            <span class="text-gray-500 ml-2">taux de satisfaction</span>
        </div>
    </div>
</div>

<!-- Actions Rapides et Activité -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Actions Administrateur -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Actions Administrateur</h2>
                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tools text-blue-600 text-sm"></i>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('admin.demandes.index') }}" 
                   class="group flex items-center p-4 bg-white border border-gray-200 rounded-xl hover:border-blue-500 hover:shadow-md transition-all duration-300">
                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-blue-100 transition-colors">
                        <i class="fas fa-clipboard-list text-blue-600 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">Gérer Demandes</h3>
                        <p class="text-sm text-gray-600">Voir et traiter les demandes</p>
                    </div>
                </a>
                
                <a href="{{ route('admin.clients.index') }}" 
                   class="group flex items-center p-4 bg-white border border-gray-200 rounded-xl hover:border-green-500 hover:shadow-md transition-all duration-300">
                    <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-green-100 transition-colors">
                        <i class="fas fa-user-friends text-green-600 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-green-600 transition-colors">Gestion Clients</h3>
                        <p class="text-sm text-gray-600">Administrer les comptes clients</p>
                    </div>
                </a>
                
                <a href="{{ route('admin.annonces.index') }}" 
                   class="group flex items-center p-4 bg-white border border-gray-200 rounded-xl hover:border-purple-500 hover:shadow-md transition-all duration-300">
                    <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-purple-100 transition-colors">
                        <i class="fas fa-bullhorn text-purple-600 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">Annonces</h3>
                        <p class="text-sm text-gray-600">Gérer les communications</p>
                    </div>
                </a>
                
                <a href="{{ route('admin.galeries.index') }}" 
                   class="group flex items-center p-4 bg-white border border-gray-200 rounded-xl hover:border-red-500 hover:shadow-md transition-all duration-300">
                    <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-red-100 transition-colors">
                        <i class="fas fa-images text-red-600 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-red-600 transition-colors">Galerie</h3>
                        <p class="text-sm text-gray-600">Photos et médias</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Activité Récente -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Activité Récente</h2>
            <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center">
                <i class="fas fa-history text-gray-600 text-sm"></i>
            </div>
        </div>
        <div class="space-y-4">
            <div class="flex items-center p-3 bg-blue-50 rounded-lg border border-blue-100">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-plus text-white text-sm"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Nouvelle demande créée</p>
                    <p class="text-xs text-gray-500">Il y a 5 minutes</p>
                </div>
            </div>
            
            <div class="flex items-center p-3 bg-green-50 rounded-lg border border-green-100">
                <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-check text-white text-sm"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Livraison finalisée</p>
                    <p class="text-xs text-gray-500">Il y a 1 heure</p>
                </div>
            </div>
            
            <div class="flex items-center p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                <div class="w-10 h-10 bg-yellow-600 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-user-plus text-white text-sm"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Nouveau client inscrit</p>
                    <p class="text-xs text-gray-500">Il y a 2 heures</p>
                </div>
            </div>

            <div class="flex items-center p-3 bg-purple-50 rounded-lg border border-purple-100">
                <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-bullhorn text-white text-sm"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Annonce publiée</p>
                    <p class="text-xs text-gray-500">Il y a 3 heures</p>
                </div>
            </div>
        </div>
        
        <!-- Remplacement du lien par un bouton désactivé ou redirection vers les demandes -->
        <a href="{{ route('admin.demandes.index') }}" 
           class="w-full mt-4 bg-gray-50 hover:bg-gray-100 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors text-center text-sm border border-gray-200 flex items-center justify-center">
            <i class="fas fa-list-alt mr-2"></i> Voir toutes les demandes
        </a>
    </div>
</div>

<!-- Dernières Demandes -->
<div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <h2 class="text-xl font-semibold text-gray-900 mr-3">Dernières Demandes Reçues</h2>
            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                <i class="fas fa-inbox text-blue-600 text-sm"></i>
            </div>
        </div>
        <a href="{{ route('admin.demandes.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center group">
            Voir toutes
            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>
    
    @if($dernieresDemandes->isEmpty())
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-inbox text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune demande récente</h3>
            <p class="text-gray-600 max-w-md mx-auto">Les nouvelles demandes de transport apparaîtront ici dès leur création par les clients</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-4 px-4 font-semibold text-gray-700 text-sm uppercase tracking-wider">Client</th>
                        <th class="text-left py-4 px-4 font-semibold text-gray-700 text-sm uppercase tracking-wider">Type</th>
                        <th class="text-left py-4 px-4 font-semibold text-gray-700 text-sm uppercase tracking-wider">Référence</th>
                        <th class="text-left py-4 px-4 font-semibold text-gray-700 text-sm uppercase tracking-wider">Statut</th>
                        <th class="text-left py-4 px-4 font-semibold text-gray-700 text-sm uppercase tracking-wider">Date</th>
                        <th class="text-left py-4 px-4 font-semibold text-gray-700 text-sm uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($dernieresDemandes as $demande)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg flex items-center justify-center mr-3">
                                        <span class="text-white text-sm font-bold">
                                            {{ substr($demande->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-900 block">{{ $demande->user->name }}</span>
                                        <span class="text-gray-500 text-xs">{{ $demande->user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ ucfirst($demande->type) }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="font-mono text-sm font-semibold text-gray-900 bg-gray-50 px-2 py-1 rounded">
                                    {{ $demande->reference ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                @php
                                    $statusColors = [
                                        'en_attente' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'en_cours' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'livree' => 'bg-green-100 text-green-800 border-green-200',
                                        'annulee' => 'bg-red-100 text-red-800 border-red-200'
                                    ];
                                    $statusClass = $statusColors[str_replace(' ', '_', strtolower($demande->statut))] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $statusClass }}">
                                    {{ ucfirst($demande->statut) }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-gray-600 text-sm">
                                {{ $demande->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-4 px-4">
                                <a href="{{ route('admin.demandes.show', $demande) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center group">
                                    <i class="fas fa-eye mr-2"></i>
                                    Consulter
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