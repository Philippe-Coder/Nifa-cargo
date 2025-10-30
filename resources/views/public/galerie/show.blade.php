@extends('layouts.main')

@section('title', $galerie->titre . ' - ' . __('Galerie'))

@section('meta')
<meta name="description" content="{{ $galerie->description ?: $galerie->titre }}">
<meta property="og:title" content="{{ $galerie->titre }} - NIF Cargo">
<meta property="og:description" content="{{ $galerie->description ?: $galerie->titre }}">
<meta property="og:image" content="{{ $galerie->image_url }}">
<meta property="og:type" content="article">
@endsection

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
    <!-- Navigation breadcrumb -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center space-x-2 text-sm">
                <a href="{{ route('accueil') }}" class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                    <i class="fas fa-home"></i>
                </a>
                <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
                <a href="{{ route('galerie.index') }}" class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                    {{ __('Galerie') }}
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <a href="{{ route('galerie.index', ['categorie' => $galerie->categorie]) }}" class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                    {{ $galerie->categorie_formate }}
                </a>
                <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
                <span class="text-gray-900 font-medium">{{ Str::limit($galerie->titre, 50) }}</span>
            </div>
        </div>
    </nav>

    <!-- Image principale -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Image -->
                <div class="lg:col-span-2">
                    <div class="relative group">
                        <div class="overflow-hidden rounded-2xl shadow-2xl bg-white">
                            <img src="{{ $galerie->image_url }}" 
                                 alt="{{ $galerie->alt }}"
                                 class="w-full h-auto object-cover transition-transform duration-300 group-hover:scale-105">
                        </div>
                        
                        <!-- Bouton zoom -->
                        <button onclick="openLightbox()" 
                                class="absolute top-4 right-4 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full backdrop-blur-sm transition-all duration-200 transform hover:scale-110">
                            <i class="fas fa-expand text-lg"></i>
                        </button>
                        
                        <!-- Badge catégorie -->
                        <div class="absolute top-4 left-4">
                            <span class="px-4 py-2 bg-white/90 backdrop-blur-sm rounded-full text-sm font-medium {{ $galerie->categorie_class }}">
                                @switch($galerie->categorie)
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
                                {{ $galerie->categorie_formate }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Informations -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl p-6 lg:p-8 sticky top-8">
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">
                            {{ $galerie->titre }}
                        </h1>
                        
                        @if($galerie->description)
                        <div class="prose prose-gray max-w-none mb-6">
                            <p class="text-gray-600 leading-relaxed">{{ $galerie->description }}</p>
                        </div>
                        @endif

                        <!-- Métadonnées -->
                        <div class="border-t border-gray-200 pt-6 space-y-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">{{ __('Catégorie') }}</span>
                                <span class="font-medium text-gray-900">{{ $galerie->categorie_formate }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">{{ __('Ajoutée le') }}</span>
                                <span class="font-medium text-gray-900">{{ $galerie->created_at->format('d/m/Y') }}</span>
                            </div>
                            
                            @if($galerie->mise_en_avant)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">{{ __('Statut') }}</span>
                                <span class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                                    <i class="fas fa-star mr-1"></i>
                                    {{ __('Image vedette') }}
                                </span>
                            </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="border-t border-gray-200 pt-6 mt-6 space-y-3">
                            <!-- Partage -->
                            <div class="text-sm text-gray-500 mb-3">{{ __('Partager cette image') }}</div>
                            <div class="flex space-x-3">
                                <button onclick="shareImage('facebook')" 
                                        class="flex items-center justify-center w-12 h-12 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-colors duration-200">
                                    <i class="fab fa-facebook-f"></i>
                                </button>
                                <button onclick="shareImage('twitter')" 
                                        class="flex items-center justify-center w-12 h-12 bg-sky-500 hover:bg-sky-600 text-white rounded-xl transition-colors duration-200">
                                    <i class="fab fa-twitter"></i>
                                </button>
                                <button onclick="shareImage('linkedin')" 
                                        class="flex items-center justify-center w-12 h-12 bg-blue-700 hover:bg-blue-800 text-white rounded-xl transition-colors duration-200">
                                    <i class="fab fa-linkedin-in"></i>
                                </button>
                                <button onclick="shareImage('whatsapp')" 
                                        class="flex items-center justify-center w-12 h-12 bg-green-500 hover:bg-green-600 text-white rounded-xl transition-colors duration-200">
                                    <i class="fab fa-whatsapp"></i>
                                </button>
                                <button onclick="copyLink()" 
                                        class="flex items-center justify-center w-12 h-12 bg-gray-600 hover:bg-gray-700 text-white rounded-xl transition-colors duration-200">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                            
                            <!-- Boutons d'action -->
                            <div class="pt-4 space-y-3">
                                <a href="{{ route('galerie.index', ['categorie' => $galerie->categorie]) }}" 
                                   class="w-full inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 transform hover:scale-105">
                                    <i class="fas fa-images mr-2"></i>
                                    {{ __('Voir plus d\'images de cette catégorie') }}
                                </a>
                                
                                <a href="{{ route('galerie.index') }}" 
                                   class="w-full inline-flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium transition-all duration-200">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    {{ __('Retour à la galerie') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Images liées -->
    @if($galeriesLiees->count() > 0)
    <section class="py-16 bg-white/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">
                {{ __('Autres images de la catégorie') }} "{{ $galerie->categorie_formate }}"
            </h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($galeriesLiees as $galerieLiee)
                <a href="{{ route('galerie.show', $galerieLiee) }}" 
                   class="group block overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 bg-white">
                    <div class="aspect-w-4 aspect-h-3">
                        <img src="{{ $galerieLiee->image_url }}" 
                             alt="{{ $galerieLiee->alt }}"
                             class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300"
                             loading="lazy">
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $galerieLiee->titre }}</h3>
                        @if($galerieLiee->description)
                        <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit($galerieLiee->description, 80) }}</p>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>

<!-- Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 flex items-center justify-center p-4">
    <div class="relative max-w-7xl max-h-full">
        <button onclick="closeLightbox()" 
                class="absolute -top-4 -right-4 bg-white hover:bg-gray-100 text-gray-900 p-3 rounded-full shadow-lg transition-colors duration-200 z-10">
            <i class="fas fa-times text-lg"></i>
        </button>
        <img src="{{ $galerie->image_url }}" 
             alt="{{ $galerie->alt }}"
             class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
        <div class="absolute bottom-4 left-4 right-4 bg-black/50 backdrop-blur-sm text-white p-4 rounded-lg">
            <h3 class="font-semibold mb-1">{{ $galerie->titre }}</h3>
            @if($galerie->description)
            <p class="text-sm opacity-90">{{ $galerie->description }}</p>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
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

@push('scripts')
<script>
    // Lightbox functions
    function openLightbox() {
        document.getElementById('lightbox').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeLightbox() {
        document.getElementById('lightbox').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    // Close lightbox on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
    
    // Close lightbox on background click
    document.getElementById('lightbox').addEventListener('click', function(e) {
        if (e.target === this) {
            closeLightbox();
        }
    });
    
    // Share functions
    function shareImage(platform) {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent('{{ $galerie->titre }} - NIF Cargo');
        const description = encodeURIComponent('{{ $galerie->description ?: $galerie->titre }}');
        
        let shareUrl = '';
        
        switch(platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                break;
            case 'linkedin':
                shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                break;
            case 'whatsapp':
                shareUrl = `https://wa.me/?text=${title}%20${url}`;
                break;
        }
        
        if (shareUrl) {
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    }
    
    function copyLink() {
        navigator.clipboard.writeText(window.location.href).then(function() {
            // Show success message
            const button = event.target.closest('button');
            const originalContent = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check"></i>';
            button.classList.add('bg-green-500', 'hover:bg-green-600');
            button.classList.remove('bg-gray-600', 'hover:bg-gray-700');
            
            setTimeout(() => {
                button.innerHTML = originalContent;
                button.classList.remove('bg-green-500', 'hover:bg-green-600');
                button.classList.add('bg-gray-600', 'hover:bg-gray-700');
            }, 2000);
        });
    }
</script>
@endpush
@endsection