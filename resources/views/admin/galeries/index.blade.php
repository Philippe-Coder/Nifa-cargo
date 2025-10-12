@extends('layouts.dashboard')

@section('title', 'Gestion de la Galerie')

@section('hero')
<div class="hero-bg-about relative overflow-hidden">
    <div class="hero-overlay"></div>
    <div class="floating-particles"></div>
    <div class="relative z-10 text-center text-white py-20">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in">
                📸 Galerie Photos
            </h1>
            <p class="text-xl md:text-2xl opacity-90 animate-slide-up">
                Gérez les photos de votre entreprise et de vos activités
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

    <!-- En-tête avec filtres et bouton d'ajout -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-8 py-6">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-images mr-3"></i>
                    Galerie Photos ({{ $galeries->total() }} photos)
                </h2>
                <a href="{{ route('admin.galeries.create') }}" 
                   class="bg-white text-purple-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Ajouter une Photo
                </a>
            </div>
        </div>

        <div class="p-8">
            <!-- Filtres -->
            <div class="mb-6">
                <form method="GET" class="flex flex-wrap gap-4 items-center">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                        <select name="categorie" class="border border-gray-300 rounded-lg px-3 py-2 text-sm" onchange="this.form.submit()">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $key => $label)
                                <option value="{{ $key }}" {{ request('categorie') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    @if(request('categorie'))
                        <div class="flex items-end">
                            <a href="{{ route('admin.galeries.index') }}" 
                               class="bg-gray-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-600 transition-colors">
                                <i class="fas fa-times mr-1"></i>
                                Effacer filtres
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            @if($galeries->count() > 0)
                <!-- Grille de photos -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                    @foreach($galeries as $photo)
                        <div class="bg-gray-50 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            <!-- Badge mise en avant -->
                            @if($photo->mise_en_avant)
                                <div class="absolute top-2 right-2 z-10">
                                    <span class="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                        <i class="fas fa-star"></i>
                                    </span>
                                </div>
                            @endif

                            <!-- Image -->
                            <div class="relative">
                                <img src="{{ $photo->image_url }}" 
                                     alt="{{ $photo->alt }}"
                                     class="w-full h-48 object-cover">
                                
                                <!-- Overlay avec actions -->
                                <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center opacity-0 hover:opacity-100">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.galeries.show', $photo) }}" 
                                           class="bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 transition-colors"
                                           title="Voir">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        <a href="{{ route('admin.galeries.edit', $photo) }}" 
                                           class="bg-green-600 text-white p-2 rounded-full hover:bg-green-700 transition-colors"
                                           title="Modifier">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <form action="{{ route('admin.galeries.destroy', $photo) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette photo ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-600 text-white p-2 rounded-full hover:bg-red-700 transition-colors"
                                                    title="Supprimer">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Informations -->
                            <div class="p-4">
                                <!-- Titre -->
                                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 text-sm">
                                    {{ $photo->titre }}
                                </h3>

                                <!-- Catégorie -->
                                <div class="mb-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $photo->categorie_class }}">
                                        {{ $photo->categorie_formate }}
                                    </span>
                                </div>

                                <!-- Actions rapides -->
                                <div class="flex justify-between items-center">
                                    <div class="flex space-x-1">
                                        <!-- Toggle Active -->
                                        <form action="{{ route('admin.galeries.toggle-active', $photo) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-6 h-6 rounded-full flex items-center justify-center transition-colors text-xs {{ $photo->active ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600' }}"
                                                    title="{{ $photo->active ? 'Désactiver' : 'Activer' }}">
                                                <i class="fas fa-{{ $photo->active ? 'eye' : 'eye-slash' }}"></i>
                                            </button>
                                        </form>
                                        
                                        <!-- Toggle Mise en avant -->
                                        <form action="{{ route('admin.galeries.toggle-mise-en-avant', $photo) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-6 h-6 rounded-full flex items-center justify-center transition-colors text-xs {{ $photo->mise_en_avant ? 'bg-yellow-500 text-white' : 'bg-gray-300 text-gray-600' }}"
                                                    title="{{ $photo->mise_en_avant ? 'Retirer de la mise en avant' : 'Mettre en avant' }}">
                                                <i class="fas fa-star"></i>
                                            </button>
                                        </form>
                                    </div>
                                    
                                    @if($photo->ordre > 0)
                                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs font-medium">
                                            {{ $photo->ordre }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Métadonnées -->
                                <div class="text-xs text-gray-500 mt-2 space-y-1">
                                    <div class="flex items-center">
                                        <i class="fas fa-user mr-1"></i>
                                        {{ $photo->user->name }}
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $photo->created_at->format('d/m/Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $galeries->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-images text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        @if(request('categorie'))
                            Aucune photo dans cette catégorie
                        @else
                            Aucune photo dans la galerie
                        @endif
                    </h3>
                    <p class="text-gray-600 mb-6">
                        @if(request('categorie'))
                            Aucune photo trouvée pour la catégorie "{{ $categories[request('categorie')] ?? request('categorie') }}".
                        @else
                            Commencez par ajouter des photos pour présenter votre entreprise et vos activités.
                        @endif
                    </p>
                    <a href="{{ route('admin.galeries.create') }}" 
                       class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 transition-all">
                        <i class="fas fa-plus mr-2"></i>
                        Ajouter une photo
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
</style>
@endsection
