@extends('layouts.dashboard')

@section('title', 'Gestion des Clients - NIF Cargo Admin')
@section('page-title', 'Gestion des Clients')

@section('content')
<!-- Hero Section -->
<div class="gradient-bg-dashboard rounded-2xl p-8 mb-8 text-blue relative overflow-hidden">
    <div class="absolute inset-0 bg-black bg-opacity-10"></div>
    <div class="relative z-10">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                     Gestion des Clients
                </h1>
                <p class="text-blue-100 text-lg">
                    Gérez tous les clients enregistrés sur la plateforme
                </p>
            </div>
            <div class="hidden md:block">
                <div class="text-6xl opacity-20">
                    👤
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats des Clients -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Total Clients</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalClients ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-blue-600"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600 font-medium">
                <i class="fas fa-arrow-up mr-1"></i> Active
            </span>
            <span class="text-gray-500 ml-2">sur la plateforme</span>
        </div>
    </div>
    
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Clients Vérifiés</p>
                <p class="text-2xl font-bold text-gray-900">{{ $clientsVerifies ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-check text-green-600"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600 font-medium">
                <i class="fas fa-shield-alt mr-1"></i> Vérifiés
            </span>
            <span class="text-gray-500 ml-2">email confirmé</span>
        </div>
    </div>
    
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Nouveaux (30j)</p>
                <p class="text-2xl font-bold text-gray-900">{{ $clientsRecents ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-plus text-orange-600"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-orange-600 font-medium">
                <i class="fas fa-calendar mr-1"></i> Récents
            </span>
            <span class="text-gray-500 ml-2">derniers 30 jours</span>
        </div>
    </div>
    
                    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Avec Demandes</p>
                <p class="text-2xl font-bold text-gray-900">{{ $clientsAvecDemandes ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-shipping-fast text-purple-600"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-purple-600 font-medium">
                <i class="fas fa-box mr-1"></i> Actifs
            </span>
            <span class="text-gray-500 ml-2">ont des demandes</span>
        </div>
    </div>
</div>

<!-- Statistiques supplémentaires -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Comptes Suspendus</p>
                <p class="text-2xl font-bold text-gray-900">{{ $clientsSuspendus ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-ban text-red-600"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-red-600 font-medium">
                <i class="fas fa-user-slash mr-1"></i> Suspendus
            </span>
            <span class="text-gray-500 ml-2">accès restreint</span>
        </div>
    </div>
    
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Comptes Actifs</p>
                <p class="text-2xl font-bold text-gray-900">{{ ($totalClients ?? 0) - ($clientsSuspendus ?? 0) }}</p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-check text-green-600"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600 font-medium">
                <i class="fas fa-check-circle mr-1"></i> Fonctionnels
            </span>
            <span class="text-gray-500 ml-2">peuvent se connecter</span>
        </div>
    </div>
</div>

<!-- Filtres et Recherche -->
<div class="dashboard-card p-6 mb-8">
    <form method="GET" action="{{ route('admin.clients.index') }}" id="filterForm">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 space-y-4 lg:space-y-0">
            <h3 class="text-xl font-semibold text-gray-900">
                <i class="fas fa-users mr-2 text-blue-600"></i>
                Liste des Clients ({{ $clients->total() }})
            </h3>
            
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3 w-full lg:w-auto">
                <!-- Recherche -->
                <div class="relative">
                    <input type="text" 
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Rechercher par nom, email, téléphone..."
                           class="w-full sm:w-80 pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <i class="fas fa-search absolute left-3 top-4 text-gray-400"></i>
                </div>
                
                <!-- Boutons d'actions -->
                <div class="flex space-x-2">
                    <button type="button" onclick="toggleFilters()" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl">
                        <i class="fas fa-filter"></i>
                        <span>Filtres</span>
                        <i class="fas fa-chevron-down transition-transform" id="filterIcon"></i>
                    </button>
                    
                    <div class="relative" id="exportDropdown">
                        <button id="exportBtn" type="button" onclick="toggleExportMenu()" 
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg transition duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl">
                            <i class="fas fa-download"></i>
                            <span>Exporter</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div id="exportMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-20 border border-gray-200">
                            <a href="#" onclick="exportData('csv')" 
                               class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 flex items-center rounded-t-lg transition-colors">
                                <i class="fas fa-file-csv mr-3 text-green-600"></i>
                                Exporter en CSV
                            </a>
                            <a href="#" onclick="exportData('pdf')" 
                               class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 flex items-center rounded-b-lg transition-colors">
                                <i class="fas fa-file-pdf mr-3 text-red-600"></i>
                                Exporter en PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panneau de filtres (caché par défaut) -->
        <div id="filtersPanel" class="hidden bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-lg mb-6 border border-blue-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Filtre par statut -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user-shield mr-1 text-blue-600"></i>
                        Statut de vérification
                    </label>
                    <select name="statut" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 bg-white">
                        <option value="tous" {{ request('statut') == 'tous' ? 'selected' : '' }}>Tous les clients</option>
                        <option value="actifs" {{ request('statut') == 'actifs' ? 'selected' : '' }}>Comptes actifs</option>
                        <option value="suspendus" {{ request('statut') == 'suspendus' ? 'selected' : '' }}>Comptes suspendus</option>
                        <option value="verifies" {{ request('statut') == 'verifies' ? 'selected' : '' }}>Clients vérifiés</option>
                        <option value="non_verifies" {{ request('statut') == 'non_verifies' ? 'selected' : '' }}>Non vérifiés</option>
                        <option value="recents" {{ request('statut') == 'recents' ? 'selected' : '' }}>Récents (30 jours)</option>
                        <option value="avec_demandes" {{ request('statut') == 'avec_demandes' ? 'selected' : '' }}>Avec demandes</option>
                    </select>
                </div>

                <!-- Date de début -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt mr-1 text-green-600"></i>
                        Date de début
                    </label>
                    <input type="date" name="date_debut" value="{{ request('date_debut') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 bg-white">
                </div>

                <!-- Date de fin -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar-check mr-1 text-red-600"></i>
                        Date de fin
                    </label>
                    <input type="date" name="date_fin" value="{{ request('date_fin') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 bg-white">
                </div>

                <!-- Boutons d'actions -->
                <div class="flex items-end space-x-2">
                    <button type="submit" 
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition duration-200 flex-1 flex items-center justify-center space-x-2 shadow-lg">
                        <i class="fas fa-search"></i>
                        <span>Filtrer</span>
                    </button>
                    <a href="{{ route('admin.clients.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center justify-center shadow-lg">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Légende des actions -->
<div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-4 mb-6 border border-blue-200">
    <h4 class="text-sm font-semibold text-gray-800 mb-3">
        <i class="fas fa-info-circle mr-2 text-blue-600"></i>
        Actions disponibles pour chaque client :
    </h4>
    <div class="flex flex-wrap gap-4 text-sm">
        <div class="flex items-center space-x-2">
            <div class="w-6 h-6 bg-blue-100 text-blue-600 rounded flex items-center justify-center">
                <i class="fas fa-eye text-xs"></i>
            </div>
            <span class="text-gray-700">Voir le profil</span>
        </div>
        <div class="flex items-center space-x-2">
            <div class="w-6 h-6 bg-green-100 text-green-600 rounded flex items-center justify-center">
                <i class="fas fa-edit text-xs"></i>
            </div>
            <span class="text-gray-700">Modifier</span>
        </div>
        <div class="flex items-center space-x-2">
            <div class="w-6 h-6 bg-purple-100 text-purple-600 rounded flex items-center justify-center">
                <i class="fas fa-shipping-fast text-xs"></i>
            </div>
            <span class="text-gray-700">Demandes</span>
        </div>
        <div class="flex items-center space-x-2">
            <div class="w-6 h-6 bg-orange-100 text-orange-600 rounded flex items-center justify-center">
                <i class="fas fa-bell text-xs"></i>
            </div>
            <span class="text-gray-700">Notification</span>
        </div>
        <div class="flex items-center space-x-2">
            <div class="w-6 h-6 bg-amber-100 text-amber-600 rounded flex items-center justify-center">
                <i class="fas fa-ban text-xs"></i>
            </div>
            <span class="text-gray-700">Suspendre</span>
        </div>
        <div class="flex items-center space-x-2">
            <div class="w-6 h-6 bg-cyan-100 text-cyan-600 rounded flex items-center justify-center">
                <i class="fas fa-user-check text-xs"></i>
            </div>
            <span class="text-gray-700">Réactiver</span>
        </div>
        <div class="flex items-center space-x-2">
            <div class="w-6 h-6 bg-red-100 text-red-600 rounded flex items-center justify-center">
                <i class="fas fa-trash text-xs"></i>
            </div>
            <span class="text-gray-700">Supprimer</span>
        </div>
    </div>
</div>

<!-- Liste des Clients -->
<div class="dashboard-card p-6 fade-in">
    @if($clients->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Client</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Contact</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Statut</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Demandes</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-600 hidden sm:table-cell">Inscription</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-600 min-w-[280px]">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white text-sm font-bold">
                                            {{ substr($client->name, 0, 2) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $client->name }}</p>
                                        <p class="text-sm text-gray-500">ID: {{ $client->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-sm">
                                    <p class="font-medium text-gray-900">{{ $client->email }}</p>
                                    @if($client->telephone)
                                        <p class="text-gray-500">{{ $client->telephone }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex flex-col space-y-1">
                                    @if($client->email_verified_at)
                                        <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium w-fit">
                                            <i class="fas fa-check-circle mr-1"></i> Vérifié
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium w-fit">
                                            <i class="fas fa-clock mr-1"></i> En attente
                                        </span>
                                    @endif
                                    
                                    @if($client->suspended_at)
                                        <span class="inline-flex items-center px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium w-fit">
                                            <i class="fas fa-ban mr-1"></i> Suspendu
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium w-fit">
                                            <i class="fas fa-user-check mr-1"></i> Actif
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-sm">
                                    <p class="font-medium text-gray-900">{{ $client->demandes_count ?? 0 }} demandes</p>
                                    @if($client->demandes_count > 0)
                                        <p class="text-gray-500">Dernière: {{ $client->demandes->first()?->created_at?->diffForHumans() ?? 'N/A' }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4 text-gray-600 text-sm hidden sm:table-cell">
                                <div>
                                    <p>{{ $client->created_at->format('d/m/Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $client->created_at->diffForHumans() }}</p>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <!-- Voir le client -->
                                    <a href="{{ route('admin.clients.show', $client->id) }}" 
                                       class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-all duration-200 hover:scale-105"
                                       title="Voir le profil du client">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    
                                    <!-- Modifier le client -->
                                    <a href="{{ route('admin.clients.edit', $client->id) }}" 
                                       class="inline-flex items-center justify-center w-8 h-8 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg transition-all duration-200 hover:scale-105"
                                       title="Modifier le profil du client">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    
                                    <!-- Voir les demandes -->
                                    <a href="{{ route('admin.demandes.index', ['client_id' => $client->id]) }}" 
                                       class="inline-flex items-center justify-center w-8 h-8 bg-purple-100 hover:bg-purple-200 text-purple-600 rounded-lg transition-all duration-200 hover:scale-105"
                                       title="Voir les demandes du client">
                                        <i class="fas fa-shipping-fast text-sm"></i>
                                    </a>
                                    
                                    <!-- Envoyer notification -->
                                    <button onclick="openNotificationModal({{ $client->id }}, '{{ str_replace("'", "\'", $client->name) }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 bg-orange-100 hover:bg-orange-200 text-orange-600 rounded-lg transition-all duration-200 hover:scale-105"
                                            title="Envoyer une notification">
                                        <i class="fas fa-bell text-sm"></i>
                                    </button>
                                    
                                    <!-- Suspendre/Activer -->
                                    @if($client->suspended_at)
                                        <form action="{{ route('admin.clients.activate', $client->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" 
                                                    onclick="return confirm('Êtes-vous sûr de vouloir réactiver ce client ?')"
                                                    class="inline-flex items-center justify-center w-8 h-8 bg-cyan-100 hover:bg-cyan-200 text-cyan-600 rounded-lg transition-all duration-200 hover:scale-105"
                                                    title="Réactiver le compte">
                                                <i class="fas fa-user-check text-sm"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button type="button"
                                                onclick="showSuspendModal({{ $client->id }}, '{{ $client->name }}')"
                                                class="inline-flex items-center justify-center w-8 h-8 bg-amber-100 hover:bg-amber-200 text-amber-600 rounded-lg transition-all duration-200 hover:scale-105"
                                                title="Suspendre le compte">
                                            <i class="fas fa-ban text-sm"></i>
                                        </button>
                                    @endif
                                    
                                    <!-- Supprimer le client -->
                                    <button type="button"
                                            onclick="showDeleteModal({{ $client->id }}, '{{ $client->name }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-all duration-200 hover:scale-105"
                                            title="Supprimer définitivement">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($clients->hasPages())
            <div class="mt-6 border-t border-gray-200 pt-6">
                {{ $clients->links() }}
            </div>
        @endif
    @else
        <!-- État vide -->
        <div class="text-center py-12">
            <div class="text-6xl mb-4">👥</div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun client enregistré</h3>
            <p class="text-gray-600">Les clients apparaîtront ici une fois qu'ils s'inscriront</p>
        </div>
    @endif
</div>
<!-- Modal de notification -->
<div id="notificationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-screen overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Envoyer une notification</h3>
                <button onclick="closeNotificationModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form id="notificationForm" class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-user mr-1 text-blue-600"></i>
                    Client destinataire
                </label>
                <input type="text" id="clientName" readonly 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                <input type="hidden" id="clientId">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tag mr-1 text-green-600"></i>
                    Type de notification
                </label>
                <select id="notificationType" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="info">Information générale</option>
                    <option value="reminder">Rappel</option>
                    <option value="warning">Avertissement</option>
                    <option value="promotion">Promotion</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-heading mr-1 text-purple-600"></i>
                    Titre de la notification
                </label>
                <input type="text" id="notificationTitle" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                       placeholder="Titre de votre notification...">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-comment mr-1 text-orange-600"></i>
                    Message
                </label>
                <textarea id="notificationMessage" rows="4" required 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                          placeholder="Tapez votre message ici..."></textarea>
            </div>
            
            <div class="flex items-center">
                <input type="checkbox" id="sendWhatsApp" class="mr-2">
                <label for="sendWhatsApp" class="text-sm text-gray-700">
                    <i class="fab fa-whatsapp mr-1 text-green-600"></i>
                    Envoyer aussi par WhatsApp
                </label>
            </div>
        </form>
        
        <div class="p-6 border-t border-gray-200 flex justify-end space-x-3">
            <button onclick="closeNotificationModal()" 
                    class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                Annuler
            </button>
            <button onclick="sendNotification()" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors flex items-center space-x-2">
                <i class="fas fa-paper-plane"></i>
                <span>Envoyer</span>
            </button>
        </div>
    </div>
</div>

<!-- Modal de suspension -->
<div id="suspendModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
        <div class="bg-gradient-to-r from-amber-600 to-amber-700 px-6 py-4 rounded-t-2xl">
            <h3 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-ban mr-3"></i>
                Suspendre le compte
            </h3>
        </div>
        
        <form id="suspendForm" method="POST" class="p-6">
            @csrf
            <p class="text-gray-700 mb-4">Client : <strong id="suspendClientName"></strong></p>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Raison de la suspension *</label>
                <select name="suspension_reason" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    <option value="">Sélectionner une raison...</option>
                    <option value="violation_terms">Violation des conditions d'utilisation</option>
                    <option value="suspicious_activity">Activité suspecte</option>
                    <option value="payment_issues">Problèmes de paiement</option>
                    <option value="admin_request">Demande administrative</option>
                    <option value="other">Autre</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Commentaire (optionnel)</label>
                <textarea name="suspension_comment" rows="3" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                          placeholder="Détails supplémentaires..."></textarea>
            </div>
            
            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" onclick="closeSuspendModal()" 
                        class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-6 py-2.5 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors font-medium">
                    <i class="fas fa-ban mr-2"></i>
                    Suspendre
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de suppression -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
        <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 rounded-t-2xl">
            <h3 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-trash mr-3"></i>
                Supprimer définitivement
            </h3>
        </div>
        
        <form id="deleteForm" method="POST" class="p-6">
            @csrf
            @method('DELETE')
            <p class="text-gray-700 mb-4">Client : <strong id="deleteClientName"></strong></p>
            
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <h4 class="font-semibold text-red-800 mb-2">⚠️ ATTENTION - Action irréversible !</h4>
                <ul class="text-sm text-red-700 space-y-1">
                    <li>• Toutes les demandes du client seront supprimées</li>
                    <li>• Tous les documents associés seront supprimés</li>
                    <li>• L'historique des paiements sera supprimé</li>
                    <li>• Cette action ne peut pas être annulée</li>
                </ul>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Pour confirmer, tapez : <strong>SUPPRIMER</strong>
                </label>
                <input type="text" name="confirmation" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                       placeholder="Tapez SUPPRIMER en majuscules">
            </div>
            
            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" onclick="closeDeleteModal()" 
                        class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                    <i class="fas fa-trash mr-2"></i>
                    Supprimer définitivement
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Gestion des filtres
function toggleFilters() {
    const panel = document.getElementById('filtersPanel');
    const icon = document.getElementById('filterIcon');
    
    if (panel.classList.contains('hidden')) {
        panel.classList.remove('hidden');
        panel.classList.add('animate-fade-in');
        icon.style.transform = 'rotate(180deg)';
    } else {
        panel.classList.add('hidden');
        panel.classList.remove('animate-fade-in');
        icon.style.transform = 'rotate(0deg)';
    }
}

// Gestion du menu d'exportation
function toggleExportMenu() {
    const menu = document.getElementById('exportMenu');
    menu.classList.toggle('hidden');
}

// Fermer le menu d'exportation si on clique ailleurs
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('exportDropdown');
    const menu = document.getElementById('exportMenu');
    
    if (!dropdown.contains(event.target)) {
        menu.classList.add('hidden');
    }
});

// Fonction d'exportation
function exportData(format) {
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    
    // Construire l'URL avec les paramètres de recherche
    const params = new URLSearchParams();
    for (let [key, value] of formData.entries()) {
        if (value) {
            params.append(key, value);
        }
    }
    
    let url;
    if (format === 'csv') {
        url = "{{ route('admin.clients.export.csv') }}";
    } else if (format === 'pdf') {
        url = "{{ route('admin.clients.export.pdf') }}";
    }
    
    // Ajouter les paramètres à l'URL
    if (params.toString()) {
        url += '?' + params.toString();
    }
    
    // Ouvrir dans une nouvelle fenêtre pour télécharger
    window.open(url, '_blank');
    
    // Fermer le menu
    document.getElementById('exportMenu').classList.add('hidden');
}

// Auto-submit du formulaire lors de la recherche (avec délai)
let searchTimeout;
document.querySelector('input[name="search"]').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        document.getElementById('filterForm').submit();
    }, 1000);
});

// Animation pour les nouvelles données
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        setTimeout(() => {
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 50);
    });
});

// Animation au survol des boutons d'action
document.addEventListener('DOMContentLoaded', function() {
    // Ajouter des tooltips dynamiques si nécessaire
    const actionButtons = document.querySelectorAll('[title]');
    actionButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
});

// Fonctions pour le modal de notification
function openNotificationModal(clientId, clientName) {
    document.getElementById('clientId').value = clientId;
    document.getElementById('clientName').value = clientName;
    document.getElementById('notificationModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Fermer le dropdown
    document.getElementById(`client-dropdown-${clientId}`).classList.add('hidden');
}

function closeNotificationModal() {
    document.getElementById('notificationModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    
    // Reset du formulaire
    document.getElementById('notificationForm').reset();
}

async function sendNotification() {
    const clientId = document.getElementById('clientId').value;
    const type = document.getElementById('notificationType').value;
    const title = document.getElementById('notificationTitle').value;
    const message = document.getElementById('notificationMessage').value;
    const sendWhatsApp = document.getElementById('sendWhatsApp').checked;
    
    if (!title || !message) {
        alert('Veuillez remplir tous les champs obligatoires.');
        return;
    }
    
    try {
        const response = await fetch('{{ route("admin.clients.send-notification") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                client_id: clientId,
                type: type,
                title: title,
                message: message,
                send_whatsapp: sendWhatsApp
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('Notification envoyée avec succès !');
            closeNotificationModal();
        } else {
            alert('Erreur lors de l\'envoi : ' + (result.message || 'Erreur inconnue'));
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Erreur lors de l\'envoi de la notification');
    }
}

// Fermer le modal en cliquant à l'extérieur
document.getElementById('notificationModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeNotificationModal();
    }
});

// Gestion du modal de suspension
function showSuspendModal(clientId, clientName) {
    const modal = document.getElementById('suspendModal');
    const form = document.getElementById('suspendForm');
    const nameElement = document.getElementById('suspendClientName');
    
    form.action = `/admin/clients/${clientId}/suspend`;
    nameElement.textContent = clientName;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeSuspendModal() {
    const modal = document.getElementById('suspendModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Gestion du modal de suppression
function showDeleteModal(clientId, clientName) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    const nameElement = document.getElementById('deleteClientName');
    
    form.action = `/admin/clients/${clientId}`;
    nameElement.textContent = clientName;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Fermer les modals avec Echap
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeSuspendModal();
        closeDeleteModal();
    }
});

// Fermer en cliquant en dehors
document.getElementById('suspendModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeSuspendModal();
});

document.getElementById('deleteModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}

.gradient-bg-dashboard {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.dashboard-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.dashboard-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.fade-in {
    animation: fade-in 0.6s ease-out;
}
</style>
