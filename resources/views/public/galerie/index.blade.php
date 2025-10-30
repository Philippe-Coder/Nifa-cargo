@extends('layouts.main')

@section('title', __('Galerie - Photos et Images'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 py-16 sm:py-24">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6">
                    {{ __('Notre Galerie') }}
                </h1>
                <p class="text-xl sm:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto">
                    {{ __('Découvrez nos activités en images : transport, logistique, équipe et infrastructures') }}
                </p>
                
                <!-- Search Bar -->
                <div class="max-w-md mx-auto">
                    <form method="GET" action="{{ route('galerie.index') }}" class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="{{ __('Rechercher dans la galerie...') }}"
                               class="w-full px-6 py-4 pl-12 bg-white/90 backdrop-blur-sm border-0 rounded-2xl shadow-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-4 focus:ring-white/30 transition-all duration-300">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <button type="submit" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                            <div class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg transition-colors duration-200">
                                <i class="fas fa-arrow-right text-sm"></i>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Decorative elements -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
        </div>
    </section>

    <!-- Images mise en avant -->
    @if($galeriesMiseEnAvant->count() > 0)
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                    {{ __('Images à la Une') }}
                </h2>
                <p class="text-lg text-gray-600">
                    {{ __('Nos meilleures photos sélectionnées pour vous') }}
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($galeriesMiseEnAvant as $galerie)
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="aspect-w-16 aspect-h-12 bg-gray-200">
                        <img src="{{ $galerie->image_url }}" 
                             alt="{{ $galerie->alt }}"
                             class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-6 group-hover:translate-y-0 transition-transform duration-300">
                        <span class="inline-block px-3 py-1 bg-blue-600 text-xs font-semibold rounded-full mb-2">
                            {{ $galerie->categorie_formate }}
                        </span>
                        <h3 class="text-lg font-bold mb-2">{{ $galerie->titre }}</h3>
                        @if($galerie->description)
                        <p class="text-sm opacity-90 line-clamp-2">{{ Str::limit($galerie->description, 100) }}</p>
                        @endif
                        <a href="{{ route('galerie.show', $galerie) }}" 
                           class="inline-flex items-center mt-3 text-white hover:text-blue-200 transition-colors duration-200">
                            {{ __('Voir plus') }} <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Filtres et Galerie principale -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filtres par catégorie -->
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">
                    {{ __('Parcourir par catégorie') }}
                </h3>
                
                <div class="flex flex-wrap justify-center gap-3">
                    <a href="{{ route('galerie.index') }}" 
                       class="inline-flex items-center px-6 py-3 rounded-full font-medium transition-all duration-200 {{ !request('categorie') ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200' }}">
                        <i class="fas fa-th-large mr-2 text-sm"></i>
                        {{ __('Toutes') }}
                    </a>
                    
                    @foreach($categories as $key => $label)
                    <a href="{{ route('galerie.index', ['categorie' => $key]) }}" 
                       class="inline-flex items-center px-6 py-3 rounded-full font-medium transition-all duration-200 {{ request('categorie') === $key ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200' }}">
                        @switch($key)
                            @case('transport')
                                <i class="fas fa-truck mr-2 text-sm"></i>
                                @break
                            @case('import')
                                <i class="fas fa-plane-arrival mr-2 text-sm"></i>
                                @break
                            @case('export')
                                <i class="fas fa-plane-departure mr-2 text-sm"></i>
                                @break
                            @case('entreprise')
                                <i class="fas fa-building mr-2 text-sm"></i>
                                @break
                            @case('equipe')
                                <i class="fas fa-users mr-2 text-sm"></i>
                                @break
                            @case('vehicules')
                                <i class="fas fa-shipping-fast mr-2 text-sm"></i>
                                @break
                            @case('entrepots')
                                <i class="fas fa-warehouse mr-2 text-sm"></i>
                                @break
                            @case('clients')
                                <i class="fas fa-handshake mr-2 text-sm"></i>
                                @break
                            @default
                                <i class="fas fa-image mr-2 text-sm"></i>
                        @endswitch
                        {{ $label }}
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Résultats -->
            @if($galeries->count() > 0)
                <div class="mb-8 text-center">
                    <p class="text-gray-600">
                        @if(request('search'))
                            {{ __('Résultats pour') }} "<strong>{{ request('search') }}</strong>" - 
                        @endif
                        @if(request('categorie'))
                            {{ __('Catégorie') }}: <strong>{{ $categories[request('categorie')] ?? request('categorie') }}</strong> - 
                        @endif
                        <strong>{{ $galeries->total() }}</strong> {{ __('image(s) trouvée(s)') }}
                    </p>
                </div>

                <!-- Grille d'images -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($galeries as $galerie)
                    <div class="group relative overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 bg-white">
                        <div class="aspect-w-4 aspect-h-3">
                            <img src="{{ $galerie->image_url }}" 
                                 alt="{{ $galerie->alt }}"
                                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                                 loading="lazy">
                        </div>
                        
                        <!-- Overlay avec informations -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <!-- Badge catégorie -->
                        <div class="absolute top-3 left-3">
                            <span class="px-2 py-1 bg-white/90 backdrop-blur-sm text-xs font-medium rounded-lg {{ $galerie->categorie_class }}">
                                {{ $galerie->categorie_formate }}
                            </span>
                        </div>
                        
                        <!-- Informations -->
                        <div class="absolute bottom-0 left-0 right-0 p-4 text-white transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                            <h4 class="font-semibold mb-1 line-clamp-1">{{ $galerie->titre }}</h4>
                            @if($galerie->description)
                            <p class="text-xs opacity-90 mb-3 line-clamp-2">{{ Str::limit($galerie->description, 80) }}</p>
                            @endif
                            <a href="{{ route('galerie.show', $galerie) }}" 
                               class="inline-flex items-center text-xs bg-white/20 hover:bg-white/30 backdrop-blur-sm px-3 py-1 rounded-full transition-colors duration-200">
                                {{ __('Voir') }} <i class="fas fa-eye ml-1"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $galeries->withQueryString()->links('pagination::tailwind') }}
                </div>
            @else
                <!-- État vide -->
                <div class="text-center py-16">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-images text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">
                        {{ __('Aucune image trouvée') }}
                    </h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        @if(request('search') || request('categorie'))
                            {{ __('Aucune image ne correspond à vos critères de recherche. Essayez de modifier vos filtres.') }}
                        @else
                            {{ __('La galerie sera bientôt remplie avec nos plus belles photos !') }}
                        @endif
                    </p>
                    
                    @if(request('search') || request('categorie'))
                    <a href="{{ route('galerie.index') }}" 
                       class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-refresh mr-2"></i>
                        {{ __('Voir toutes les images') }}
                    </a>
                    @endif
                </div>
            @endif
        </div>
    </section>
</div>

@push('styles')
<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .aspect-w-16 { position: relative; padding-bottom: 75%; }
    .aspect-w-16 > * { position: absolute; height: 100%; width: 100%; top: 0; right: 0; bottom: 0; left: 0; }
    
    .aspect-w-4 { position: relative; padding-bottom: 75%; }
    .aspect-w-4 > * { position: absolute; height: 100%; width: 100%; top: 0; right: 0; bottom: 0; left: 0; }
</style>
@endpush
@endsection