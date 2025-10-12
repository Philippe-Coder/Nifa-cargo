@extends('layouts.main')

@section('title', 'Galerie Photos - NIFA')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl md:text-5xl font-bold mb-4">Notre Galerie Photos</h1>
        <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto">
            Découvrez nos activités, nos équipes et nos réalisations en images
        </p>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" class="w-full h-12 lg:h-20">
            <path fill="#ffffff" d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,64C960,75,1056,85,1152,80C1248,75,1344,53,1392,42.7L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
        </svg>
    </div>
</section>

<!-- Galerie Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Filtres par catégorie -->
        <div class="mb-12 flex flex-wrap justify-center gap-3">
            <a href="{{ route('galerie.index') }}" 
               class="px-5 py-2 rounded-full text-sm font-medium transition-colors duration-200 {{ !request('categorie') ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 shadow' }}">
                Toutes les catégories
            </a>
            @foreach($categories as $key => $categorie)
                <a href="{{ route('galerie.index', ['categorie' => $key]) }}" 
                   class="px-5 py-2 rounded-full text-sm font-medium transition-colors duration-200 {{ request('categorie') == $key ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 shadow' }}">
                    {{ $categorie }}
                </a>
            @endforeach
        </div>

        @if($galeries->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($galeries as $album)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                        <a href="{{ route('galerie.show', $album) }}" class="block relative group">
                            @if($album->images->isNotEmpty())
                                <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                                    <img src="{{ asset('storage/' . $album->images->first()->image_path) }}" 
                                         alt="{{ $album->titre }}"
                                         class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                                </div>
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                    <span class="text-white opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                        <i class="fas fa-images text-3xl"></i>
                                    </span>
                                </div>
                            @else
                                <div class="h-64 bg-gray-100 flex items-center justify-center">
                                    <span class="text-gray-400">
                                        <i class="fas fa-image fa-3x mb-2"></i>
                                        <p>Aucune image</p>
                                    </span>
                                </div>
                            @endif
                        </a>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                <a href="{{ route('galerie.show', $album) }}" class="hover:text-blue-600 transition-colors">
                                    {{ $album->titre }}
                                </a>
                            </h3>
                            @if($album->description)
                                <p class="text-gray-600 mb-4 line-clamp-2">{{ $album->description }}</p>
                            @endif
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $categories[$album->categorie] ?? $album->categorie }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    {{ $album->images_count }} {{ Str::plural('photo', $album->images_count) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $galeries->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-xl shadow">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-blue-600 mb-4">
                    <i class="fas fa-images text-2xl"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Aucun album trouvé</h3>
                <p class="text-gray-600 mb-6">Aucun album n'est disponible dans cette catégorie pour le moment.</p>
                <a href="{{ route('galerie.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i> Voir tous les albums
                </a>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="bg-blue-700 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-6">Besoin de nos services ?</h2>
        <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
            Découvrez comment nous pouvons vous aider à optimiser votre chaîne logistique en Afrique.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 md:py-4 md:text-lg md:px-10 transition-colors duration-200">
                <i class="fas fa-envelope mr-2"></i> Nous contacter
            </a>
            <a href="{{ route('demande.create') }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-medium rounded-md text-white bg-blue-900 bg-opacity-80 hover:bg-opacity-100 md:py-4 md:text-lg md:px-10 transition-colors duration-200">
                <i class="fas fa-box mr-2"></i> Faire une demande
            </a>
        </div>
    </div>
</section>

@push('styles')
<style>
    .aspect-w-16 {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
    }
    
    .aspect-w-16 > * {
        position: absolute;
        height: 100%;
        width: 100%;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
</style>
@endpush

@endsection
