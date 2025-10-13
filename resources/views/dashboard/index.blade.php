@extends('layouts.dashboard')

@section('title', 'Tableau de bord - NIFA')
@section('page-title', 'Mon Espace Client')

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
                    <span class="text-sm font-medium">Bienvenue dans votre espace</span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-bold mb-3">
                    Bonjour, {{ Auth::user()->name }} !
                </h1>
                <p class="text-blue-100 text-lg max-w-2xl">
                    Gérez vos demandes de transport et suivez vos expéditions en temps réel
                </p>
            </div>
            <div class="hidden lg:block">
                <div class="text-6xl opacity-20">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cartes de statistiques -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Demandes -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Total des demandes</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_demandes'] ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-clipboard-list text-blue-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600 font-medium flex items-center">
                <i class="fas fa-arrow-up mr-1 text-xs"></i> +12%
            </span>
            <span class="text-gray-500 ml-2">ce mois</span>
        </div>
    </div>
    
    <!-- En Cours -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">En cours</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['en_cours'] ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-shipping-fast text-yellow-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-blue-600 font-medium flex items-center">
                <i class="fas fa-sync-alt mr-1 text-xs"></i> Actif
            </span>
            <span class="text-gray-500 ml-2">suivi temps réel</span>
        </div>
    </div>
    
    <!-- Livrées -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Livrées</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['livrees'] ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600 font-medium flex items-center">
                <i class="fas fa-thumbs-up mr-1 text-xs"></i> 98%
            </span>
            <span class="text-gray-500 ml-2">satisfaction</span>
        </div>
    </div>
    
    <!-- Dépenses totales -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Dépenses totales</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['montant_total'] ?? 0, 0, ',', ' ') }} FCFA</p>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-file-invoice-dollar text-purple-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-purple-600 font-medium flex items-center">
                <i class="fas fa-chart-line mr-1 text-xs"></i> +8%
            </span>
            <span class="text-gray-500 ml-2">vs mois dernier</span>
        </div>
    </div>
</div>

<!-- Actions Rapides -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Actions Principales -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Actions Rapides</h2>
                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-bolt text-blue-600 text-sm"></i>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('demande.create') }}" 
                   class="group flex items-center p-4 bg-white border border-gray-200 rounded-xl hover:border-blue-500 hover:shadow-md transition-all duration-300">
                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-blue-100 transition-colors">
                        <i class="fas fa-plus text-blue-600 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">Nouvelle Demande</h3>
                        <p class="text-sm text-gray-600">Créer une demande de transport</p>
                    </div>
                </a>
                
                <a href="{{ route('mes-demandes.index') }}" 
                   class="group flex items-center p-4 bg-white border border-gray-200 rounded-xl hover:border-green-500 hover:shadow-md transition-all duration-300">
                    <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-green-100 transition-colors">
                        <i class="fas fa-list text-green-600 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-green-600 transition-colors">Mes Demandes</h3>
                        <p class="text-sm text-gray-600">Voir toutes mes demandes</p>
                    </div>
                </a>
                
                <a href="{{ route('suivi.public') }}" 
                   class="group flex items-center p-4 bg-white border border-gray-200 rounded-xl hover:border-purple-500 hover:shadow-md transition-all duration-300">
                    <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-purple-100 transition-colors">
                        <i class="fas fa-search-location text-purple-600 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">Suivi Colis</h3>
                        <p class="text-sm text-gray-600">Suivre un envoi</p>
                    </div>
                </a>
                
                <a href="{{ route('contact') }}" 
                   class="group flex items-center p-4 bg-white border border-gray-200 rounded-xl hover:border-red-500 hover:shadow-md transition-all duration-300">
                    <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-red-100 transition-colors">
                        <i class="fas fa-headset text-red-600 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-red-600 transition-colors">Support Client</h3>
                        <p class="text-sm text-gray-600">Contacter notre équipe</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Profil Utilisateur -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Mon Profil</h2>
            <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center">
                <i class="fas fa-user text-gray-600 text-sm"></i>
            </div>
        </div>
        <div class="space-y-6">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                    <span class="text-white text-lg font-bold">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </span>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 text-lg">{{ Auth::user()->name }}</h3>
                    <p class="text-gray-600 text-sm">{{ Auth::user()->email }}</p>
                    <span class="inline-block mt-2 px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-medium border border-blue-200">
                        Client NIFA
                    </span>
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-4">
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Membre depuis</span>
                        <span class="font-medium text-gray-900">{{ Auth::user()->created_at->format('M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Statut du compte</span>
                        <span class="flex items-center text-green-600 font-medium">
                            <i class="fas fa-check-circle mr-1 text-xs"></i> Actif
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Dernière connexion</span>
                        <span class="font-medium text-gray-900">{{ now()->format('d/m H:i') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="flex space-x-3">
                <a href="{{ route('profile.edit') }}" 
                   class="flex-1 bg-gray-50 hover:bg-gray-100 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors text-center text-sm border border-gray-200">
                    <i class="fas fa-edit mr-2"></i> Modifier
                </a>
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="flex-1 bg-red-50 hover:bg-red-100 text-red-700 font-medium py-2 px-4 rounded-lg transition-colors text-center text-sm border border-red-200">
                    <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Dernières Demandes -->
<div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 mb-8">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <h2 class="text-xl font-semibold text-gray-900 mr-3">Dernières Demandes</h2>
            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                <i class="fas fa-history text-blue-600 text-sm"></i>
            </div>
        </div>
        <a href="{{ route('mes-demandes.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center group">
            Voir tout
            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>
    
    @if(isset($recent_demandes) && $recent_demandes->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-4 px-4 font-semibold text-gray-700 text-sm uppercase tracking-wider">Référence</th>
                        <th class="text-left py-4 px-4 font-semibold text-gray-700 text-sm uppercase tracking-wider">Statut</th>
                        <th class="text-left py-4 px-4 font-semibold text-gray-700 text-sm uppercase tracking-wider">Origine</th>
                        <th class="text-left py-4 px-4 font-semibold text-gray-700 text-sm uppercase tracking-wider">Destination</th>
                        <th class="text-left py-4 px-4 font-semibold text-gray-700 text-sm uppercase tracking-wider">Date</th>
                        <th class="text-left py-4 px-4 font-semibold text-gray-700 text-sm uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recent_demandes as $demande)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-4">
                                <span class="font-mono text-sm font-semibold text-blue-700 bg-blue-50 px-2 py-1 rounded">
                                    {{ $demande->reference }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                @php
                                    $statusClasses = [
                                        'en attente' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'en cours' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'en transit' => 'bg-purple-100 text-purple-800 border-purple-200',
                                        'livrée' => 'bg-green-100 text-green-800 border-green-200',
                                        'annulée' => 'bg-red-100 text-red-800 border-red-200',
                                    ];
                                    $statusClass = $statusClasses[$demande->statut] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $statusClass }}">
                                    {{ ucfirst($demande->statut) }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-gray-400 mr-2 text-sm"></i>
                                    <span class="text-gray-900 font-medium">{{ $demande->ville_depart }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <i class="fas fa-flag text-gray-400 mr-2 text-sm"></i>
                                    <span class="text-gray-900 font-medium">{{ $demande->ville_destination }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-gray-600 text-sm">
                                {{ $demande->created_at->format('d/m/Y') }}
                            </td>
                            <td class="py-4 px-4">
                                <a href="{{ route('mes-demandes.show', $demande) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center group">
                                    <i class="fas fa-eye mr-2"></i>
                                    Détails
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-box-open text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune demande pour le moment</h3>
            <p class="text-gray-600 mb-6 max-w-md mx-auto">Commencez par créer votre première demande de transport pour suivre vos expéditions</p>
            <a href="{{ route('demande.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl">
                <i class="fas fa-plus mr-2"></i> Créer une demande
            </a>
        </div>
    @endif
</div>

<!-- Notifications récentes -->
<div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <h2 class="text-xl font-semibold text-gray-900 mr-3">Notifications récentes</h2>
            <div class="w-8 h-8 bg-yellow-50 rounded-lg flex items-center justify-center">
                <i class="fas fa-bell text-yellow-600 text-sm"></i>
            </div>
        </div>
        @if($unreadCount > 0)
        <form action="{{ route('notifications.markAllRead') }}" method="POST">
            @csrf
            <button type="submit" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
                <i class="fas fa-check-double mr-2"></i> Tout marquer comme lu
            </button>
        </form>
        @endif
    </div>
    
    <div class="space-y-4">
        @forelse($notifications as $notification)
        <div class="flex items-start p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-blue-300 transition-colors {{ $notification->unread() ? 'bg-blue-50 border-blue-200' : '' }}">
            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600 mr-4 flex-shrink-0">
                <i class="fas fa-bell text-sm"></i>
            </div>
            <div class="flex-1">
                <div class="flex items-start justify-between">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 mb-1">
                            {{ $notification->data['title'] ?? 'Notification' }}
                        </h4>
                        <p class="text-sm text-gray-600 mb-2">
                            {{ $notification->data['message'] ?? '' }}
                        </p>
                        <div class="text-xs text-gray-500">
                            <i class="far fa-clock mr-1"></i>{{ $notification->created_at->diffForHumans() }}
                        </div>
                    </div>
                    @if($notification->unread())
                    <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-green-600 hover:text-green-800 text-sm flex items-center ml-4">
                            <i class="fas fa-check-circle mr-1"></i> Lu
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-8">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-bell-slash text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune notification</h3>
            <p class="text-gray-600">Vous serez notifié des mises à jour importantes concernant vos demandes</p>
        </div>
        @endforelse
    </div>
    
    @if($unreadCount > 5)
    <div class="mt-6 pt-4 border-t border-gray-200 text-center">
        <a href="{{ route('notifications.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center justify-center group">
            <i class="fas fa-list mr-2"></i>
            Voir toutes les notifications ({{ $unreadCount }} non lues)
            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>
    @endif
</div>
@endsection