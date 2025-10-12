@extends('layouts.dashboard')

@section('title', 'Galerie Photos')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Notre Galerie Photos</h1>
        <p class="text-gray-600">Découvrez nos réalisations et nos activités en images</p>
    </div>

    <!-- Filtres par catégorie -->
    <div class="mb-8 flex flex-wrap justify-center gap-2">
        <a href="{{ route('galerie.index') }}" 
           class="px-4 py-2 rounded-full {{ !request('categorie') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Toutes les catégories
        </a>
        @foreach($categories as $key => $categorie)
            <a href="{{ route('galerie.index', ['categorie' => $key]) }}" 
               class="px-4 py-2 rounded-full {{ request('categorie') == $key ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                {{ $categorie }}
            </a>
        @endforeach
    </div>

    <!-- Grille des albums -->
    @if($galeries->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($galeries as $album)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    @if($album->images->isNotEmpty())
                        <a href="{{ route('galerie.show', $album) }}" class="block relative h-48 overflow-hidden">
                            <img src="{{ asset('storage/' . $album->images->first()->image_path) }}" 
                                 alt="{{ $album->titre }}"
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300">
                                <span class="text-white font-medium">Voir l'album ({{ $album->images_count }})</span>
                            </div>
                        </a>
                    @else
                        <div class="h-48 bg-gray-100 flex items-center justify-center">
                            <span class="text-gray-400">Aucune image</span>
                        </div>
                    @endif
                    <div class="p-4">
                        <h3 class="font-semibold text-lg text-gray-900 mb-1">{{ $album->titre }}</h3>
                        @if($album->description)
                            <p class="text-gray-600 text-sm line-clamp-2">{{ $album->description }}</p>
                        @endif
                        <div class="mt-2 flex justify-between items-center">
                            <span class="text-xs text-gray-500">
                                {{ $album->created_at->diffForHumans() }}
                            </span>
                            <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded-full">
                                {{ $categories[$album->categorie] ?? $album->categorie }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $galeries->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Aucun album trouvé</h3>
            <p class="text-gray-500">Aucun album n'est disponible pour le moment.</p>
        </div>
    @endif
</div>
@endsection
