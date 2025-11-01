@extends('layouts.dashboard')

@section('title', 'Gestion des Clients - NIF Cargo Admin')
@section('page-title', 'Gestion des Clients')

@section('content')
<!-- Hero Section -->
<div class="gradient-bg-dashboard rounded-2xl p-8 mb-8 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black bg-opacity-10"></div>
    <div class="relative z-10">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    👥 Gestion des Clients
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
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Inscription</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Actions</th>
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
                                @if($client->email_verified_at)
                                    <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                        <i class="fas fa-check-circle mr-1"></i> Vérifié
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                        <i class="fas fa-clock mr-1"></i> En attente
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-sm">
                                    <p class="font-medium text-gray-900">{{ $client->demandes_count ?? 0 }} demandes</p>
                                    @if($client->demandes_count > 0)
                                        <p class="text-gray-500">Dernière: {{ $client->demandes->first()?->created_at?->diffForHumans() ?? 'N/A' }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4 text-gray-600 text-sm">
                                <div>
                                    <p>{{ $client->created_at->format('d/m/Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $client->created_at->diffForHumans() }}</p>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.clients.show', $client->id) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        <i class="fas fa-eye mr-1"></i> Voir
                                    </a>
                                    
                                    <div class="relative">
                                        <button class="text-gray-400 hover:text-gray-600" onclick="toggleClientDropdown({{ $client->id }})">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div id="client-dropdown-{{ $client->id }}" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden z-10">
                                            <div class="py-2">
                                                <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <i class="fas fa-edit mr-2"></i> Modifier
                                                </button>
                                                <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <i class="fas fa-envelope mr-2"></i> Envoyer email
                                                </button>
                                                <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <i class="fas fa-ban mr-2"></i> Suspendre
                                                </button>
                                                <div class="border-t border-gray-100 mt-2 pt-2">
                                                    <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" class="inline w-full">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')"
                                                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                            <i class="fas fa-trash mr-2"></i> Supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

function toggleClientDropdown(id) {
    const dropdown = document.getElementById(`client-dropdown-${id}`);
    const allDropdowns = document.querySelectorAll('[id^="client-dropdown-"]');
    
    // Fermer tous les autres dropdowns
    allDropdowns.forEach(d => {
        if (d.id !== `client-dropdown-${id}`) {
            d.classList.add('hidden');
        }
    });
    
    // Toggle le dropdown actuel
    dropdown.classList.toggle('hidden');
}

// Fermer les dropdowns en cliquant ailleurs
document.addEventListener('click', function(event) {
    if (!event.target.closest('[onclick^="toggleClientDropdown"]') && !event.target.closest('[id^="client-dropdown-"]')) {
        document.querySelectorAll('[id^="client-dropdown-"]').forEach(d => {
            d.classList.add('hidden');
        });
    }
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
@endsection
