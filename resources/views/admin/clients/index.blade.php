@extends('layouts.dashboard')

@section('title', 'Gestion des Clients - NIFA Admin')
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
                <p class="text-2xl font-bold text-gray-900">{{ $clients->total() }}</p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-blue-600"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600 font-medium">
                <i class="fas fa-arrow-up mr-1"></i> +5%
            </span>
            <span class="text-gray-500 ml-2">ce mois</span>
        </div>
    </div>
    
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Actifs</p>
                <p class="text-2xl font-bold text-gray-900">{{ $clients->filter(fn($client) => $client->email_verified_at !== null)->count() }}</p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600 font-medium">
                <i class="fas fa-thumbs-up mr-1"></i> 98%
            </span>
            <span class="text-gray-500 ml-2">vérifiés</span>
        </div>
    </div>
    
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Nouveaux</p>
                <p class="text-2xl font-bold text-gray-900">{{ $clients->filter(fn($client) => $client->created_at >= now()->subDays(30))->count() }}</p>
            </div>
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-plus text-purple-600"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-purple-600 font-medium">
                <i class="fas fa-calendar mr-1"></i> 30j
            </span>
            <span class="text-gray-500 ml-2">derniers</span>
        </div>
    </div>
    
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Avec Demandes</p>
                <p class="text-2xl font-bold text-gray-900">{{ $clients->filter(fn($client) => $client->demandes_count > 0)->count() }}</p>
            </div>
            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-box text-orange-600"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-orange-600 font-medium">
                <i class="fas fa-chart-line mr-1"></i> Actifs
            </span>
            <span class="text-gray-500 ml-2">utilisateurs</span>
        </div>
    </div>
</div>

<!-- Filtres et Actions -->
<div class="dashboard-card p-6 mb-8 fade-in">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex flex-wrap gap-2">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                Tous ({{ $clients->total() }})
            </button>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                Vérifiés
            </button>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                Non vérifiés
            </button>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                Récents
            </button>
        </div>
        
        <div class="flex gap-2">
            <div class="relative">
                <input type="text" placeholder="Rechercher un client..." 
                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                <i class="fas fa-filter mr-2"></i> Filtrer
            </button>
            <button class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                <i class="fas fa-download mr-2"></i> Exporter
            </button>
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

@push('scripts')
<script>
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
@endpush
