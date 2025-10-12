@extends('layouts.dashboard')

@section('title', 'Gestion des Demandes - NIFA Admin')
@section('page-title', 'Gestion des Demandes')

@section('content')
<!-- Hero Section -->
<div class="gradient-bg-dashboard rounded-2xl p-8 mb-8 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black bg-opacity-10"></div>
    <div class="relative z-10">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    📦 Gestion des Demandes
                </h1>
                <p class="text-blue-100 text-lg">
                    Gérez et suivez toutes les demandes de transport
                </p>
            </div>
            <div class="hidden md:block">
                <div class="text-6xl opacity-20">
                    📋
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtres et Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Total</p>
                <p class="text-2xl font-bold text-gray-900">{{ $demandes->total() }}</p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-boxes text-blue-600"></i>
            </div>
        </div>
    </div>
    
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">En Attente</p>
                <p class="text-2xl font-bold text-gray-900">{{ $demandes->filter(fn($d) => $d->statut === 'en attente')->count() }}</p>
            </div>
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600"></i>
            </div>
        </div>
    </div>
    
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">En Cours</p>
                <p class="text-2xl font-bold text-gray-900">{{ $demandes->filter(fn($d) => in_array($d->statut, ['en cours', 'en transit']))->count() }}</p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-truck text-blue-600"></i>
            </div>
        </div>
    </div>
    
    <div class="dashboard-card p-6 fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Livrées</p>
                <p class="text-2xl font-bold text-gray-900">{{ $demandes->filter(fn($d) => $d->statut === 'livrée')->count() }}</p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600"></i>
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
            <button class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                <i class="fas fa-download mr-2"></i> Exporter
            </button>
        </div>
    </div>
</div>

<!-- Liste des Demandes -->
<div class="dashboard-card p-6 fade-in">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-left py-3 px-4 font-medium text-gray-600">Client</th>
                    <th class="text-left py-3 px-4 font-medium text-gray-600">Référence</th>
                    <th class="text-left py-3 px-4 font-medium text-gray-600">Type</th>
                    <th class="text-left py-3 px-4 font-medium text-gray-600">Trajet</th>
                    <th class="text-left py-3 px-4 font-medium text-gray-600">Statut</th>
                    <th class="text-left py-3 px-4 font-medium text-gray-600">Date</th>
                    <th class="text-left py-3 px-4 font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($demandes as $demande)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-xs font-bold">
                                        {{ substr($demande->user->name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $demande->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $demande->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="font-mono text-sm font-medium text-blue-600">
                                {{ $demande->reference ?? 'REF-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-medium">
                                {{ ucfirst($demande->type) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="text-sm">
                                <p class="font-medium text-gray-900">{{ $demande->ville_depart }}</p>
                                <p class="text-gray-500">→ {{ $demande->ville_destination }}</p>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="status-badge status-{{ str_replace(' ', '-', strtolower($demande->statut)) }}">
                                {{ ucfirst($demande->statut) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-gray-600 text-sm">
                            {{ $demande->created_at->format('d/m/Y') }}
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.demandes.show', $demande->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-eye mr-1"></i> Voir
                                </a>
                                
                                <div class="relative">
                                    <button class="text-gray-400 hover:text-gray-600" onclick="toggleDropdown({{ $demande->id }})">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div id="dropdown-{{ $demande->id }}" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden z-10">
                                        <div class="py-2">
                                            <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-edit mr-2"></i> Modifier
                                            </button>
                                            <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-truck mr-2"></i> Changer statut
                                            </button>
                                            <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-download mr-2"></i> Télécharger
                                            </button>
                                            <div class="border-t border-gray-100 mt-2 pt-2">
                                                <form action="{{ route('admin.demandes.destroy', $demande->id) }}" method="POST" class="inline w-full">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ?')"
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
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center">
                            <div class="text-6xl mb-4">📦</div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune demande trouvée</h3>
                            <p class="text-gray-600">Les demandes de transport apparaîtront ici</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($demandes->hasPages())
        <div class="mt-6 border-t border-gray-200 pt-6">
            {{ $demandes->links() }}
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
