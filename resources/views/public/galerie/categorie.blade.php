@extends('layouts.main')

@section('title', $categories[$categorieActuelle] . ' - ' . __('Galerie'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 py-16">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="inline-flex items-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-white mb-6">
                    @switch($categorieActuelle)
                        @case('transport')
                            <i class="fas fa-truck mr-2"></i>
                            @break
                        @case('import')
                            <i class="fas fa-plane-arrival mr-2"></i>
                            @break
                        @case('export')
                            <i class="fas fa-plane-departure mr-2"></i>
                            @break
                        @case('entreprise')
                            <i class="fas fa-building mr-2"></i>
                            @break
                        @case('equipe')
                            <i class="fas fa-users mr-2"></i>
                            @break
                        @case('vehicules')
                            <i class="fas fa-shipping-fast mr-2"></i>
                            @break
                        @case('entrepots')
                            <i class="fas fa-warehouse mr-2"></i>
                            @break
                        @case('clients')
                            <i class="fas fa-handshake mr-2"></i>
                            @break
                        @default
                            <i class="fas fa-image mr-2"></i>
                    @endswitch
                    {{ __('Catégorie') }}
                </div>
                
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-6">
                    {{ $categories[$categorieActuelle] }}
                </h1>
                
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                    @switch($categorieActuelle)
                        @case('transport')
                            {{ __('Découvrez nos activités de transport et logistique à travers ces images') }}
                            @break
                        @case('import')
                            {{ __('Nos services d\'importation et réception de marchandises') }}
                            @break
                        @case('export')
                            {{ __('Nos services d\'exportation vers l\'international') }}
                            @break
                        @case('entreprise')
                            {{ __('Découvrez notre entreprise, nos locaux et nos installations') }}
                            @break
                        @case('equipe')
                            {{ __('Rencontrez notre équipe professionnelle et dévouée') }}
                            @break
                        @case('vehicules')
                            {{ __('Notre flotte de véhicules pour tous vos besoins de transport') }}
                            @break
                        @case('entrepots')
                            {{ __('Nos entrepôts modernes et sécurisés pour vos marchandises') }}
                            @break
                        @case('clients')
                            {{ __('Nos partenaires et clients satisfaits') }}
                            @break
                        @default
                            {{ __('Explorez cette collection d\'images') }}
                    @endswitch
                </p>

                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('galerie.index') }}" 
                       class="inline-flex items-center bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-3 rounded-lg font-medium transition-all duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        {{ __('Retour à la galerie') }}
                    </a>
                    
                    <span class="inline-flex items-center bg-white text-gray-900 px-6 py-3 rounded-lg font-medium">
                        <i class="fas fa-images mr-2"></i>
                        {{ $galeries->total() }} {{ __('image(s)') }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Decorative elements -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
        </div>
    </section>

    <!-- Navigation par catégorie -->
    <section class="py-8 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-center gap-3">
                @foreach($categories as $key => $label)
                <a href="{{ route('galerie.categorie', $key) }}" 
                   class="inline-flex items-center px-4 py-2 rounded-full font-medium transition-all duration-200 {{ $key === $categorieActuelle ? 'bg-blue-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
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
    </section>

    <!-- Galerie -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($galeries->count() > 0)
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
                        
                        @if($galerie->mise_en_avant)
                        <!-- Badge mise en avant -->
                        <div class="absolute top-3 left-3">
                            <span class="px-2 py-1 bg-yellow-400 text-yellow-900 text-xs font-bold rounded-full">
                                <i class="fas fa-star mr-1"></i>{{ __('Vedette') }}
                            </span>
                        </div>
                        @endif
                        
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
                        @switch($categorieActuelle)
                            @case('transport')
                                <i class="fas fa-truck text-3xl text-gray-400"></i>
                                @break
                            @case('import')
                                <i class="fas fa-plane-arrival text-3xl text-gray-400"></i>
                                @break
                            @case('export')
                                <i class="fas fa-plane-departure text-3xl text-gray-400"></i>
                                @break
                            @case('entreprise')
                                <i class="fas fa-building text-3xl text-gray-400"></i>
                                @break
                            @case('equipe')
                                <i class="fas fa-users text-3xl text-gray-400"></i>
                                @break
                            @case('vehicules')
                                <i class="fas fa-shipping-fast text-3xl text-gray-400"></i>
                                @break
                            @case('entrepots')
                                <i class="fas fa-warehouse text-3xl text-gray-400"></i>
                                @break
                            @case('clients')
                                <i class="fas fa-handshake text-3xl text-gray-400"></i>
                                @break
                            @default
                                <i class="fas fa-images text-3xl text-gray-400"></i>
                        @endswitch
                    </div>
                    
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">
                        {{ __('Aucune image dans cette catégorie') }}
                    </h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        {{ __('Cette section sera bientôt remplie avec de nouvelles images. Consultez les autres catégories en attendant !') }}
                    </p>
                    
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('galerie.index') }}" 
                           class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-images mr-2"></i>
                            {{ __('Voir toutes les images') }}
                        </a>
                        
                        <!-- Suggestion d'autres catégories -->
                        @php
                            $autresCategories = array_diff_key($categories, [$categorieActuelle => '']);
                            $categoriesSuggerees = array_slice($autresCategories, 0, 2, true);
                        @endphp
                        
                        @foreach($categoriesSuggerees as $key => $label)
                        <a href="{{ route('galerie.categorie', $key) }}" 
                           class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-lg font-medium transition-colors duration-200">
                            {{ $label }}
                        </a>
                        @endforeach
                    </div>
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
    
    .aspect-w-4 { position: relative; padding-bottom: 75%; }
    .aspect-w-4 > * { position: absolute; height: 100%; width: 100%; top: 0; right: 0; bottom: 0; left: 0; }
</style>
@endpush
@endsection