@extends('layouts.main')

@section('title', $galerie->titre . ' - Galerie NIFA')

@push('styles')
<style>
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 0.5rem;
        transition: transform 0.3s ease;
    }
    
    .gallery-item:hover {
        transform: translateY(-5px);
    }
    
    .gallery-item img {
        transition: transform 0.5s ease;
    }
    
    .gallery-item:hover img {
        transform: scale(1.05);
    }
    
    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
    
    .gallery-zoom-icon {
        color: white;
        font-size: 2rem;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl md:text-5xl font-bold mb-4">{{ $galerie->titre }}</h1>
            <p class="text-xl text-blue-100">
                {{ $galerie->description ?? 'Découvrez les photos de cet album' }}
            </p>
            <div class="mt-4">
                <a href="{{ route('galerie.public.index') }}" class="inline-flex items-center text-blue-100 hover:text-white">
                    <i class="fas fa-arrow-left mr-2"></i> Retour à la galerie
                </a>
            </div>
        </div>
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
        @if($galerie->images->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($galerie->images as $image)
                    <div class="gallery-item bg-white rounded-xl shadow-md overflow-hidden">
                        <a href="{{ asset('storage/' . $image->image_path) }}" data-lightbox="gallery" data-title="{{ $image->titre ?? '' }}">
                            <div class="aspect-w-16 aspect-h-9">
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     alt="{{ $image->titre ?? 'Image ' . $loop->iteration }}"
                                     class="w-full h-64 object-cover">
                            </div>
                            <div class="gallery-overlay">
                                <span class="gallery-zoom-icon">
                                    <i class="fas fa-search-plus"></i>
                                </span>
                            </div>
                        </a>
                        @if($image->titre || $image->description)
                            <div class="p-4">
                                @if($image->titre)
                                    <h3 class="font-semibold text-gray-900">{{ $image->titre }}</h3>
                                @endif
                                @if($image->description)
                                    <p class="text-sm text-gray-600 mt-1">{{ $image->description }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-xl shadow">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-blue-600 mb-4">
                    <i class="fas fa-images text-2xl"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Aucune image dans cet album</h3>
                <p class="text-gray-600 mb-6">Cet album ne contient aucune image pour le moment.</p>
                <a href="{{ route('galerie.public.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i> Retour à la galerie
                </a>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="bg-blue-700 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-6">Vous avez des questions ?</h2>
        <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
            Notre équipe est à votre disposition pour répondre à toutes vos questions sur nos services.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 md:py-4 md:text-lg md:px-10 transition-colors duration-200">
                <i class="fas fa-envelope mr-2"></i> Nous contacter
            </a>
            <a href="{{ route('demande.create') }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-medium rounded-md text-white bg-blue-900 bg-opacity-80 hover:bg-opacity-100 md:py-4 md:text-lg md:px-10 transition-colors duration-200">
                <i class="fas fa-phone-alt mr-2"></i> Nous appeler
            </a>
        </div>
    </div>
</section>

@push('scripts')
<!-- Lightbox2 pour la galerie d'images -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
    // Configuration de lightbox
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'showImageNumberLabel': true,
        'alwaysShowNavOnTouchDevices': true
    });
</script>
@endpush

@endsection
