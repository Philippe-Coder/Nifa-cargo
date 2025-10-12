@extends('layouts.dashboard')

@section('title', $galerie->titre . ' - Galerie')

@push('styles')
<style>
    .lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }
    
    .lightbox.active {
        display: flex;
    }
    
    .lightbox-content {
        max-width: 90%;
        max-height: 90%;
        position: relative;
    }
    
    .lightbox-img {
        max-width: 100%;
        max-height: 80vh;
        object-fit: contain;
    }
    
    .lightbox-close, .lightbox-prev, .lightbox-next {
        position: absolute;
        color: white;
        font-size: 2rem;
        cursor: pointer;
        background: rgba(0, 0, 0, 0.5);
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    
    .lightbox-close {
        top: 20px;
        right: 20px;
    }
    
    .lightbox-prev {
        left: 20px;
    }
    
    .lightbox-next {
        right: 20px;
    }
    
    .lightbox-caption {
        color: white;
        text-align: center;
        margin-top: 15px;
        max-width: 80%;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8">
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('galerie.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    Galerie
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $galerie->titre }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $galerie->titre }}</h1>
                    <p class="text-gray-600">{{ $galerie->description }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        {{ $galerie->categorie }}
                    </span>
                    <span class="text-sm text-gray-500 ml-2">
                        {{ $galerie->images_count }} {{ Str::plural('image', $galerie->images_count) }}
                    </span>
                </div>
            </div>

            @if($galerie->images->isNotEmpty())
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    @foreach($galerie->images as $index => $image)
                        <div class="relative group cursor-pointer" onclick="openLightbox({{ $index }})">
                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                 alt="{{ $image->titre ?? 'Image ' . ($index + 1) }}"
                                 class="w-full h-40 object-cover rounded-lg transition-transform duration-300 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black bg-opacity-20 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Aucune image dans cet album</h3>
                    <p class="text-gray-500">Cet album ne contient aucune image pour le moment.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Lightbox -->
<div id="lightbox" class="lightbox">
    <div class="lightbox-content">
        <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
        <img id="lightbox-img" class="lightbox-img" src="" alt="">
        <div id="lightbox-caption" class="lightbox-caption"></div>
        <button class="lightbox-prev" onclick="changeImage(-1)">❮</button>
        <button class="lightbox-next" onclick="changeImage(1)">❯</button>
    </div>
</div>

@push('scripts')
<script>
    let currentImageIndex = 0;
    const images = @json($galerie->images->map(function($image) {
        return [
            'src' => asset('storage/' . $image->image_path),
            'alt' => $image->titre ?? '',
            'description' => $image->description ?? ''
        ];
    }));

    function openLightbox(index) {
        currentImageIndex = index;
        updateLightbox();
        document.getElementById('lightbox').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    function changeImage(step) {
        currentImageIndex += step;
        if (currentImageIndex >= images.length) currentImageIndex = 0;
        if (currentImageIndex < 0) currentImageIndex = images.length - 1;
        updateLightbox();
    }

    function updateLightbox() {
        const lightboxImg = document.getElementById('lightbox-img');
        const lightboxCaption = document.getElementById('lightbox-caption');
        
        lightboxImg.src = images[currentImageIndex].src;
        lightboxImg.alt = images[currentImageIndex].alt;
        
        let captionText = [];
        if (images[currentImageIndex].alt) captionText.push(images[currentImageIndex].alt);
        if (images[currentImageIndex].description) captionText.push(images[currentImageIndex].description);
        
        lightboxCaption.textContent = captionText.join(' - ');
    }

    // Fermer la lightbox avec la touche Échap
    document.addEventListener('keydown', function(event) {
        const lightbox = document.getElementById('lightbox');
        if (event.key === 'Escape' && lightbox.classList.contains('active')) {
            closeLightbox();
        } else if (event.key === 'ArrowLeft') {
            changeImage(-1);
        } else if (event.key === 'ArrowRight') {
            changeImage(1);
        }
    });
</script>
@endpush
@endsection
