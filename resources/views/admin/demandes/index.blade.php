@extends('layouts.dashboard')

@section('title', 'Gestion des Demandes - NIF Cargo Admin')
@section('page-title', 'Gestion des Demandes')

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
                    <span class="text-sm font-medium">Administration des demandes</span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-bold mb-3">
                    Gestion des Demandes
                </h1>
                <p class="text-blue-100 text-lg max-w-2xl">
                    Gérez et suivez toutes les demandes de transport de vos clients
                </p>
            </div>
            <div class="hidden lg:block">
                <div class="text-6xl opacity-20">
                    <i class="fas fa-clipboard-list"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cartes de Statistiques -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Demandes -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Total Demandes</p>
                <p class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $demandes->total() }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-boxes text-blue-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600 font-medium flex items-center">
                <i class="fas fa-arrow-up mr-1 text-xs"></i> +12%
            </span>
            <span class="text-gray-500 ml-2">ce mois</span>
        </div>
    </div>
    
    <!-- En Attente -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">En Attente</p>
                <p class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $demandes->filter(fn($d) => $d->statut === 'en attente')->count() }}</p>
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
    
    <!-- En Cours -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">En Cours</p>
                <p class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $demandes->filter(fn($d) => in_array($d->statut, ['en cours', 'en transit']))->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-shipping-fast text-blue-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-blue-600 font-medium flex items-center">
                <i class="fas fa-sync-alt mr-1 text-xs"></i> Actives
            </span>
            <span class="text-gray-500 ml-2">en progression</span>
        </div>
    </div>
    
    <!-- Livrées -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Livrées</p>
                <p class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $demandes->filter(fn($d) => $d->statut === 'livrée')->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600 font-medium flex items-center">
                <i class="fas fa-thumbs-up mr-1 text-xs"></i> 97%
            </span>
            <span class="text-gray-500 ml-2">satisfaction</span>
        </div>
    </div>
</div>

<!-- Filtres et Actions -->
<div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 mb-8">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <!-- Filtres par statut -->
        <div class="flex flex-wrap gap-2">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors shadow-sm flex items-center">
                <i class="fas fa-list mr-2"></i> Toutes ({{ $demandes->total() }})
            </button>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors flex items-center">
                <i class="fas fa-clock mr-2 text-yellow-500"></i> En attente
            </button>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors flex items-center">
                <i class="fas fa-truck mr-2 text-blue-500"></i> En cours
            </button>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors flex items-center">
                <i class="fas fa-check-circle mr-2 text-green-500"></i> Livrées
            </button>
        </div>
        
        <!-- Recherche et Actions -->
        <div class="flex gap-3">
            <div class="relative flex-1 lg:w-64">
                <input type="text" placeholder="Rechercher une demande..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors flex items-center">
                <i class="fas fa-filter mr-2"></i> Filtres
            </button>
            <button class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-all duration-300 transform hover:scale-105 shadow-sm flex items-center">
                <i class="fas fa-file-export mr-2"></i> Exporter
            </button>
        </div>
    </div>
</div>

<!-- Liste des Demandes -->
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr class="border-b border-gray-200">
                    <th class="text-left py-4 px-6 font-semibold text-gray-700 text-sm uppercase tracking-wider">Client</th>
                    <th class="text-left py-4 px-6 font-semibold text-gray-700 text-sm uppercase tracking-wider">Référence</th>
                    <th class="text-left py-4 px-6 font-semibold text-gray-700 text-sm uppercase tracking-wider">Type</th>
                    <th class="text-left py-4 px-6 font-semibold text-gray-700 text-sm uppercase tracking-wider">Trajet</th>
                    <th class="text-left py-4 px-6 font-semibold text-gray-700 text-sm uppercase tracking-wider">Statut</th>
                    <th class="text-left py-4 px-6 font-semibold text-gray-700 text-sm uppercase tracking-wider">Date</th>
                    <th class="text-left py-4 px-6 font-semibold text-gray-700 text-sm uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($demandes as $demande)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <!-- Client -->
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl flex items-center justify-center mr-4">
                                    <span class="text-white text-sm font-bold">
                                        {{ substr($demande->user->name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $demande->user->name }}</p>
                                    <p class="text-sm text-gray-500 truncate max-w-[150px]">{{ $demande->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Référence -->
                        <td class="py-4 px-6">
                            <span class="font-mono text-sm font-semibold text-blue-700 bg-blue-50 px-3 py-1 rounded-lg">
                                {{ $demande->reference ?? 'REF-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        
                        <!-- Type -->
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200">
                                <i class="fas fa-{{ $demande->type === 'maritime' ? 'ship' : ($demande->type === 'aérien' ? 'plane' : 'truck') }} mr-2"></i>
                                {{ ucfirst($demande->type) }}
                            </span>
                        </td>
                        
                        <!-- Trajet -->
                        <td class="py-4 px-6">
                            <div class="text-sm">
                                <div class="flex items-center text-gray-900 font-medium">
                                    <i class="fas fa-map-marker-alt text-red-500 mr-2 text-xs"></i>
                                    {{ $demande->ville_depart }}
                                </div>
                                <div class="flex items-center text-gray-500 mt-1">
                                    <i class="fas fa-arrow-right text-gray-400 mr-2 text-xs"></i>
                                    {{ $demande->ville_destination }}
                                </div>
                            </div>
                        </td>
                        
                        <!-- Statut -->
                        <td class="py-4 px-6">
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
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $statusClass }}">
                                <i class="fas fa-circle mr-2 text-xs"></i>
                                {{ ucfirst($demande->statut) }}
                            </span>
                        </td>
                        
                        <!-- Date -->
                        <td class="py-4 px-6">
                            <div class="text-sm text-gray-600">
                                <div class="font-medium">{{ $demande->created_at->format('d/m/Y') }}</div>
                                <div class="text-gray-500 text-xs">{{ $demande->created_at->format('H:i') }}</div>
                            </div>
                        </td>
                        
                        <!-- Actions -->
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.demandes.show', $demande->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center group">
                                    <i class="fas fa-eye mr-2"></i>
                                    Détails
                                </a>
                                
                                <!-- Menu déroulant -->
                                <div class="relative">
                                    <button class="text-gray-400 hover:text-gray-600 transition-colors p-2 rounded-lg hover:bg-gray-100" 
                                            onclick="toggleDropdown({{ $demande->id }})">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div id="dropdown-{{ $demande->id }}" 
                                         class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-200 hidden z-50 transition-all duration-200">
                                        <div class="py-2">
                                            <button class="w-full flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                                <i class="fas fa-edit mr-3 text-blue-500"></i>
                                                Modifier la demande
                                            </button>
                                            <button class="w-full flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                                <i class="fas fa-exchange-alt mr-3 text-green-500"></i>
                                                Changer le statut
                                            </button>
                                            <button class="w-full flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                                <i class="fas fa-file-pdf mr-3 text-red-500"></i>
                                                Télécharger PDF
                                            </button>
                                            <div class="border-t border-gray-100 my-2"></div>
                                            <form action="{{ route('admin.demandes.destroy', $demande->id) }}" method="POST" class="w-full">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ? Cette action est irréversible.')"
                                                        class="w-full flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                                    <i class="fas fa-trash mr-3"></i>
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-16 text-center">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune demande trouvée</h3>
                            <p class="text-gray-600 max-w-md mx-auto">
                                Les demandes de transport créées par vos clients apparaîtront ici.
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($demandes->hasPages())
        <div class="border-t border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Affichage de 
                    <span class="font-medium">{{ $demandes->firstItem() }}</span>
                    à 
                    <span class="font-medium">{{ $demandes->lastItem() }}</span>
                    sur 
                    <span class="font-medium">{{ $demandes->total() }}</span>
                    demandes
                </div>
                <div class="flex items-center space-x-2">
                    @if($demandes->onFirstPage())
                        <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-lg text-sm cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $demandes->previousPageUrl() }}" class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition-colors">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

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
</div>
@endsection

@push('scripts')
<script>
function toggleDropdown(id) {
    const dropdown = document.getElementById(`dropdown-${id}`);
    const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
    
    // Fermer tous les autres dropdowns
    allDropdowns.forEach(d => {
        if (d.id !== `dropdown-${id}`) {
            d.classList.add('hidden');
        }
    });
    
    // Toggle le dropdown actuel
    dropdown.classList.toggle('hidden');
}

// Fermer les dropdowns en cliquant ailleurs
document.addEventListener('click', function(event) {
    if (!event.target.closest('[onclick^="toggleDropdown"]') && !event.target.closest('[id^="dropdown-"]')) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(d => {
            d.classList.add('hidden');
        });
    }
});
</script>
@endpush