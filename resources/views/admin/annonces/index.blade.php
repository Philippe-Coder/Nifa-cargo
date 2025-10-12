@extends('layouts.dashboard')

@section('title', 'Gestion des Annonces')

@section('hero')
<div class="hero-bg-contact relative overflow-hidden">
    <div class="hero-overlay"></div>
    <div class="floating-particles"></div>
    <div class="relative z-10 text-center text-white py-20">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in">
                📢 Gestion des Annonces
            </h1>
            <p class="text-xl md:text-2xl opacity-90 animate-slide-up">
                Créez et gérez les annonces qui s'afficheront sur le site public
            </p>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Messages de feedback -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex">
                <i class="fas fa-check-circle text-green-400 mt-1 mr-3"></i>
                <div>
                    <h3 class="text-sm font-medium text-green-800">Succès</h3>
                    <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- En-tête avec bouton d'ajout -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-red-600 px-8 py-6">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-bullhorn mr-3"></i>
                    Liste des Annonces
                </h2>
                <a href="{{ route('admin.annonces.create') }}" 
                   class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Nouvelle Annonce
                </a>
            </div>
        </div>

        <div class="p-8">
            @if($annonces->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($annonces as $annonce)
                        <div class="bg-gray-50 rounded-xl p-6 relative">
                            <!-- Badge épinglé -->
                            @if($annonce->epingle)
                                <div class="absolute -top-2 -right-2">
                                    <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                        <i class="fas fa-thumbtack mr-1"></i>
                                        Épinglé
                                    </span>
                                </div>
                            @endif

                            <!-- Type et statut -->
                            <div class="flex justify-between items-start mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $annonce->type_class }}">
                                    {{ $annonce->type_formate }}
                                </span>
                                <div class="flex items-center space-x-2">
                                    <!-- Toggle Active -->
                                    <form action="{{ route('admin.annonces.toggle-active', $annonce) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="w-8 h-8 rounded-full flex items-center justify-center transition-colors {{ $annonce->active ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600' }}"
                                                title="{{ $annonce->active ? 'Désactiver' : 'Activer' }}">
                                            <i class="fas fa-{{ $annonce->active ? 'eye' : 'eye-slash' }} text-xs"></i>
                                        </button>
                                    </form>
                                    
                                    <!-- Toggle Épinglé -->
                                    <form action="{{ route('admin.annonces.toggle-epingle', $annonce) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="w-8 h-8 rounded-full flex items-center justify-center transition-colors {{ $annonce->epingle ? 'bg-yellow-500 text-white' : 'bg-gray-300 text-gray-600' }}"
                                                title="{{ $annonce->epingle ? 'Désépingler' : 'Épingler' }}">
                                            <i class="fas fa-thumbtack text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Image -->
                            @if($annonce->image)
                                <div class="mb-4">
                                    <img src="{{ asset('storage/' . $annonce->image) }}" 
                                         alt="{{ $annonce->titre }}"
                                         class="w-full h-32 object-cover rounded-lg">
                                </div>
                            @endif

                            <!-- Titre -->
                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">
                                {{ $annonce->titre }}
                            </h3>

                            <!-- Contenu (extrait) -->
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($annonce->contenu), 120) }}
                            </p>

                            <!-- Métadonnées -->
                            <div class="text-xs text-gray-500 mb-4 space-y-1">
                                <div class="flex items-center">
                                    <i class="fas fa-user mr-2"></i>
                                    {{ $annonce->user->name }}
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar mr-2"></i>
                                    {{ $annonce->created_at->format('d/m/Y à H:i') }}
                                </div>
                                @if($annonce->date_debut || $annonce->date_fin)
                                    <div class="flex items-center">
                                        <i class="fas fa-clock mr-2"></i>
                                        @if($annonce->date_debut && $annonce->date_fin)
                                            Du {{ $annonce->date_debut->format('d/m/Y') }} au {{ $annonce->date_fin->format('d/m/Y') }}
                                        @elseif($annonce->date_debut)
                                            À partir du {{ $annonce->date_debut->format('d/m/Y') }}
                                        @else
                                            Jusqu'au {{ $annonce->date_fin->format('d/m/Y') }}
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex justify-between items-center">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.annonces.show', $annonce) }}" 
                                       class="text-blue-600 hover:text-blue-800 transition-colors"
                                       title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.annonces.edit', $annonce) }}" 
                                       class="text-green-600 hover:text-green-800 transition-colors"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.annonces.destroy', $annonce) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-800 transition-colors"
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                
                                @if($annonce->ordre > 0)
                                    <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs font-medium">
                                        Ordre: {{ $annonce->ordre }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $annonces->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-bullhorn text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune annonce</h3>
                    <p class="text-gray-600 mb-6">Commencez par créer votre première annonce pour le site public.</p>
                    <a href="{{ route('admin.annonces.create') }}" 
                       class="bg-gradient-to-r from-blue-600 to-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-red-700 transition-all">
                        <i class="fas fa-plus mr-2"></i>
                        Créer une annonce
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
