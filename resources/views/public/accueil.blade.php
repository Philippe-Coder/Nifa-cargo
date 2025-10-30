@extends('layouts.main')

@section('title', 'NIF Cargo - Transport et Logistique en Afrique')

@section('content')
<!-- Hero Section avec Slider Synchronisé -->
<section class="relative h-screen min-h-[700px] overflow-hidden">
    <!-- Slider Container -->
    <div class="absolute inset-0 slider-container">
        <!-- Slide 1 - Transport Maritime -->
        <div class="absolute inset-0 slide active" data-slide="1">
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')"></div>
            <div class="absolute inset-0 bg-slate-900/60"></div>
        </div>
        
        <!-- Slide 2 - Transport Aérien -->
        <div class="absolute inset-0 slide" data-slide="2">
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')"></div>
            <div class="absolute inset-0 bg-slate-900/60"></div>
        </div>
        
        <!-- Slide 3 - Solutions Logistiques -->
        <div class="absolute inset-0 slide" data-slide="3">
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')"></div>
            <div class="absolute inset-0 bg-slate-900/60"></div>
        </div>
        
        <!-- Slide 4 - Réseau International -->
        <div class="absolute inset-0 slide" data-slide="4">
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')"></div>
            <div class="absolute inset-0 bg-slate-900/60"></div>
        </div>
    </div>

    <!-- Navigation du slider -->
    <button class="slider-nav slider-prev absolute left-4 top-1/2 transform -translate-y-1/2 z-20 bg-white/20 hover:bg-white/30 text-white w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 backdrop-blur-sm">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="slider-nav slider-next absolute right-4 top-1/2 transform -translate-y-1/2 z-20 bg-white/20 hover:bg-white/30 text-white w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 backdrop-blur-sm">
        <i class="fas fa-chevron-right"></i>
    </button>

    <!-- Contenu principal synchronisé -->
    <div class="relative z-10 h-full flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Texte principal synchronisé avec le slider -->
                <div class="text-white">
                    <!-- Badge dynamique -->
                    <div class="slide-content active" data-slide="1">
                        <div class="inline-flex items-center bg-blue-600 text-white rounded-full px-4 py-2 mb-6">
                            <span class="w-2 h-2 bg-white rounded-full mr-2"></span>
                            <span class="text-sm font-medium">{{ __('Transport Maritime') }}</span>
                        </div>
                    </div>
                    <div class="slide-content" data-slide="2">
                        <div class="inline-flex items-center bg-red-600 text-white rounded-full px-4 py-2 mb-6">
                            <span class="w-2 h-2 bg-white rounded-full mr-2"></span>
                            <span class="text-sm font-medium">{{ __('Transport Aérien Express') }}</span>
                        </div>
                    </div>
                    <div class="slide-content" data-slide="3">
                        <div class="inline-flex items-center bg-green-600 text-white rounded-full px-4 py-2 mb-6">
                            <span class="w-2 h-2 bg-white rounded-full mr-2"></span>
                            <span class="text-sm font-medium">{{ __('Solutions Logistiques') }}</span>
                        </div>
                    </div>
                    <div class="slide-content" data-slide="4">
                        <div class="inline-flex items-center bg-purple-600 text-white rounded-full px-4 py-2 mb-6">
                            <span class="w-2 h-2 bg-white rounded-full mr-2"></span>
                            <span class="text-sm font-medium">{{ __('Réseau International') }}</span>
                        </div>
                    </div>
                    
                    <!-- Titre dynamique -->
                    <div class="slide-content active" data-slide="1">
                        <h1 class="text-4xl lg:text-5xl xl:text-6xl font-bold mb-6 leading-tight">
                            {{ __('Transport Maritime') }} <span class="text-blue-400">{{ __('vers l\'Afrique') }}</span>
                        </h1>
                        <p class="text-xl text-slate-200 mb-8 leading-relaxed">
                            {{ __('Conteneurs et groupage avec dédouanement inclus. Solutions fiables pour vos échanges commerciaux.') }}
                        </p>
                    </div>
                    <div class="slide-content" data-slide="2">
                        <h1 class="text-4xl lg:text-5xl xl:text-6xl font-bold mb-6 leading-tight">
                            {{ __('Transport Aérien Express') }} <span class="text-red-400"></span>
                        </h1>
                        <p class="text-xl text-slate-200 mb-8 leading-relaxed">
                            {{ __('Livraison urgente 24-48h pour marchandises sensibles. Rapidité et sécurité garanties.') }}
                        </p>
                    </div>
                    <div class="slide-content" data-slide="3">
                        <h1 class="text-4xl lg:text-5xl xl:text-6xl font-bold mb-6 leading-tight">
                            {{ __('Solutions Logistiques') }} <span class="text-green-400">{{ __('Complètes') }}</span>
                        </h1>
                        <p class="text-xl text-slate-200 mb-8 leading-relaxed">
                            {{ __('De l\'emballage à la livraison finale. Une gestion intégrée de votre supply chain.') }}
                        </p>
                    </div>
                    <div class="slide-content" data-slide="4">
                        <h1 class="text-4xl lg:text-5xl xl:text-6xl font-bold mb-6 leading-tight">
                            {{ __('Réseau International') }} <span class="text-purple-400">{{ __('en Afrique') }}</span>
                        </h1>
                        <p class="text-xl text-slate-200 mb-8 leading-relaxed">
                            {{ __('Présents dans 15+ pays avec des partenaires locaux de confiance. Votre pont vers l\'Afrique.') }}
                        </p>
                    </div>
                    
                    <!-- Boutons CTA -->
                    <div class="flex flex-col sm:flex-row gap-4 mb-8">
                        <a href="{{ route('demande.create') }}{{ app()->getLocale() != 'fr' ? '?locale=' . app()->getLocale() : '' }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg inline-flex items-center justify-center transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-box mr-3"></i> {{ __('Faire une demande') }}
                        </a>
                        <a href="{{ route('suivi.public') }}{{ app()->getLocale() != 'fr' ? '?locale=' . app()->getLocale() : '' }}" 
                           class="bg-white/10 hover:bg-white/20 text-white px-8 py-4 rounded-lg font-semibold text-lg inline-flex items-center justify-center transition-all duration-300 border border-white/20">
                            <i class="fas fa-search mr-3"></i> {{ __('Suivre un colis') }}
                        </a>
                    </div>
                    
                    <!-- Indicateurs de confiance -->
                    <div class="flex flex-wrap gap-6 text-slate-200">
                        <div class="flex items-center">
                            <i class="fas fa-shield-alt text-blue-400 mr-2"></i>
                            <span>{{ __('Sécurité garantie') }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock text-blue-400 mr-2"></i>
                            <span>{{ __('Livraison rapide') }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-headset text-blue-400 mr-2"></i>
                            <span>{{ __('Support 24/7') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Carte statistiques -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-white/10 rounded-xl p-6 text-center backdrop-blur-sm border border-white/10">
                            <div class="text-3xl font-bold mb-2 text-white">{{ number_format($stats['demandes_traitees']) }}+</div>
                            <div class="text-sm text-slate-300">{{ __('Demandes traitées') }}</div>
                        </div>
                        <div class="bg-white/10 rounded-xl p-6 text-center backdrop-blur-sm border border-white/10">
                            <div class="text-3xl font-bold mb-2 text-white">{{ $stats['clients_satisfaits'] }}%</div>
                            <div class="text-sm text-slate-300">{{ __('Clients satisfaits') }}</div>
                        </div>
                        <div class="bg-white/10 rounded-xl p-6 text-center backdrop-blur-sm border border-white/10">
                            <div class="text-3xl font-bold mb-2 text-white">{{ $stats['pays_desservis'] }}+</div>
                            <div class="text-sm text-slate-300">{{ __('Pays desservis') }}</div>
                        </div>
                        <div class="bg-white/10 rounded-xl p-6 text-center backdrop-blur-sm border border-white/10">
                            <div class="text-3xl font-bold mb-2 text-white">{{ $stats['annees_experience'] }}+</div>
                            <div class="text-sm text-slate-300">{{ __('Années d\'expérience') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Indicateurs de slide -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20">
        <div class="flex space-x-2">
            @for($i = 1; $i <= 4; $i++)
                <button class="slide-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all duration-300 {{ $i === 1 ? 'bg-white w-8' : '' }}"
                        data-slide="{{ $i }}"></button>
            @endfor
        </div>
    </div>

    <!-- Wave Divider -->
    <div class="absolute bottom-0 left-0 right-0 z-10">
        <svg viewBox="0 0 1440 120" class="w-full h-16 lg:h-24">
            <path fill="#ffffff" fill-opacity="1" d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,74.7C1120,75,1280,53,1360,42.7L1440,32L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</section>

<!-- Annonces Section -->
@if($annonces && $annonces->count() > 0)
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center bg-blue-600 text-white rounded-full px-4 py-2 mb-4">
                <i class="fas fa-bullhorn mr-2"></i>
                <span class="font-semibold">{{ __('Actualités & Annonces') }}</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">
                {{ __('Restez') }} <span class="text-blue-600">{{ __('informé') }}</span>
            </h2>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto">
                {{ __('Découvrez nos dernières nouvelles, promotions et actualités importantes') }}
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($annonces as $annonce)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden group">
                    @if($annonce->epingle)
                        <div class="absolute top-4 right-4 z-10">
                            <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                <i class="fas fa-star mr-1"></i>
                                À la une
                            </span>
                        </div>
                    @endif
                    
                    @if($annonce->image)
                        <div class="h-48 bg-cover bg-center relative overflow-hidden">
                            <img src="{{ asset('storage/' . $annonce->image) }}" alt="{{ $annonce->titre }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                            <div class="absolute inset-0 bg-black/20"></div>
                        </div>
                    @else
                        <div class="h-48 bg-blue-600 flex items-center justify-center">
                            <i class="fas fa-newspaper text-white text-4xl"></i>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $annonce->type_class }}">
                                @switch($annonce->type)
                                    @case('promotion')
                                        <i class="fas fa-tag mr-1"></i>
                                        @break
                                    @case('urgent')
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        @break
                                    @case('actualite')
                                        <i class="fas fa-newspaper mr-1"></i>
                                        @break
                                    @default
                                        <i class="fas fa-info-circle mr-1"></i>
                                @endswitch
                                {{ $annonce->type_formate }}
                            </span>
                            <span class="text-xs text-slate-500">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ $annonce->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-slate-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors">
                            {{ $annonce->titre }}
                        </h3>
                        
                        <p class="text-slate-600 text-sm line-clamp-3 mb-4 leading-relaxed">
                            {{ Str::limit(strip_tags($annonce->contenu), 120) }}
                        </p>
                        
                        <div class="flex justify-between items-center">
                            <button onclick="showAnnonceModal({{ $annonce->id }})" 
                                    class="text-blue-600 hover:text-blue-800 font-medium text-sm transition-colors inline-flex items-center group">
                                <span>{{ __('Lire la suite') }}</span>
                                <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                            </button>
                            
                            @if($annonce->type == 'promotion')
                                <a href="{{ route('demande.create') }}{{ app()->getLocale() != 'fr' ? '?locale=' . app()->getLocale() : '' }}" 
                                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-xs font-medium transition-all transform hover:scale-105">
                                    <i class="fas fa-gift mr-1"></i>
                                    {{ __('Profiter') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Services Section avec Images -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center bg-blue-600 text-white rounded-full px-4 py-2 mb-4">
                <i class="fas fa-shipping-fast mr-2"></i>
                <span class="font-semibold">{{ __('Nos Services') }}</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">
                {{ __('Solutions') }} <span class="text-blue-600">{{ __('complètes') }}</span>
            </h2>
            <p class="text-xl text-slate-600 max-w-3xl mx-auto">
                {{ __('Des services de transport adaptés à tous vos besoins logistiques en Afrique et au-delà') }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Transport Maritime -->
            <div class="group bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                <div class="h-48 bg-cover bg-center relative overflow-hidden" style="background-image: url('{{ asset('images/Transport Maritime.jpg') }}')">
                    <div class="absolute inset-0 bg-blue-900/40"></div>
                    <div class="absolute bottom-4 left-4">
                        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center text-blue-600 text-xl shadow-lg">
                            <i class="fas fa-ship"></i>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-slate-900 mb-4">{{ __('Transport Maritime') }}</h3>
                    <p class="text-slate-600 mb-6 leading-relaxed">
                        {{ __('Conteneurs et groupage vers l\'Afrique et l\'Europe avec dédouanement complet') }}
                    </p>
                    <ul class="text-sm text-slate-600 space-y-3 mb-6">
                        <li class="flex items-center">
                            <i class="fas fa-check text-blue-600 mr-3"></i>
                            {{ __('Conteneurs 20 et 40 pieds') }}
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-blue-600 mr-3"></i>
                            {{ __('Groupage LCL') }}
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-blue-600 mr-3"></i>
                            {{ __('Dédouanement inclus') }}
                        </li>
                    </ul>
                    <a href="{{ route('services') }}{{ app()->getLocale() != 'fr' ? '?locale=' . app()->getLocale() : '' }}" class="text-blue-600 font-medium hover:text-blue-800 inline-flex items-center transition-colors group">
                        <span>{{ __('En savoir plus') }}</span>
                        <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <!-- Transport Aérien -->
            <div class="group bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                <div class="h-48 bg-cover bg-center relative overflow-hidden" style="background-image: url('{{ asset('images/Transport Aérien.jpg') }}')">
                    <div class="absolute inset-0 bg-red-900/40"></div>
                    <div class="absolute bottom-4 left-4">
                        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center text-red-600 text-xl shadow-lg">
                            <i class="fas fa-plane"></i>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-slate-900 mb-4">{{ __('Transport Aérien') }}</h3>
                    <p class="text-slate-600 mb-6 leading-relaxed">
                        {{ __('Livraison express pour vos marchandises urgentes et fragiles') }}
                    </p>
                    <ul class="text-sm text-slate-600 space-y-3 mb-6">
                        <li class="flex items-center">
                            <i class="fas fa-check text-red-600 mr-3"></i>
                            {{ __('Livraison 24-48h') }}
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-red-600 mr-3"></i>
                            {{ __('Marchandises fragiles') }}
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-red-600 mr-3"></i>
                            {{ __('Réseau mondial') }}
                        </li>
                    </ul>
                    <a href="{{ route('services') }}{{ app()->getLocale() != 'fr' ? '?locale=' . app()->getLocale() : '' }}" class="text-red-600 font-medium hover:text-red-800 inline-flex items-center transition-colors group">
                        <span>{{ __('En savoir plus') }}</span>
                        <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <!-- Transport Terrestre -->
            <div class="group bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                <div class="h-48 bg-cover bg-center relative overflow-hidden" style="background-image: url('{{ asset('images/Transport Terrestre.jpg') }}')">
                    <div class="absolute inset-0 bg-indigo-900/40"></div>
                    <div class="absolute bottom-4 left-4">
                        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center text-indigo-600 text-xl shadow-lg">
                            <i class="fas fa-truck"></i>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-slate-900 mb-4">{{ __('Transport Terrestre') }}</h3>
                    <p class="text-slate-600 mb-6 leading-relaxed">
                        {{ __('Flotte moderne pour le transport routier en Afrique de l\'Ouest') }}
                    </p>
                    <ul class="text-sm text-slate-600 space-y-3 mb-6">
                        <li class="flex items-center">
                            <i class="fas fa-check text-indigo-600 mr-3"></i>
                            {{ __('Camions réfrigérés') }}
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-indigo-600 mr-3"></i>
                            {{ __('Transport véhicules') }}
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-indigo-600 mr-3"></i>
                            {{ __('Livraison domicile') }}
                        </li>
                    </ul>
                    <a href="{{ route('services') }}{{ app()->getLocale() != 'fr' ? '?locale=' . app()->getLocale() : '' }}" class="text-indigo-600 font-medium hover:text-indigo-800 inline-flex items-center transition-colors group">
                        <span>{{ __('En savoir plus') }}</span>
                        <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Process Section Professionnelle -->
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center bg-blue-600 text-white rounded-full px-4 py-2 mb-4">
                <i class="fas fa-cogs mr-2"></i>
                <span class="font-semibold">{{ __('Notre Processus') }}</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">
                {{ __('Votre envoi en') }} <span class="text-blue-600">{{ __('4 étapes simples') }}</span>
            </h2>
            <p class="text-xl text-slate-600">
                {{ __('Un processus transparent et professionnel du début à la fin') }}
            </p>
        </div>

        <!-- Timeline Processus -->
        <div class="relative">
            <!-- Ligne de progression -->
            <div class="hidden md:block absolute left-1/2 top-0 bottom-0 w-1 bg-blue-200 transform -translate-x-1/2"></div>
            
            <div class="space-y-12 md:space-y-0">
                @php
                    $steps = [
                        [
                            'icon' => 'file-alt', 
                            'title' => __('Demande en ligne'), 
                            'desc' => __('Remplissez notre formulaire en ligne avec les détails de votre envoi'),
                            'position' => 'left'
                        ],
                        [
                            'icon' => 'calculator', 
                            'title' => __('Devis personnalisé'), 
                            'desc' => __('Recevez votre devis personnalisé sous 24h avec options de paiement'),
                            'position' => 'right'
                        ],
                        [
                            'icon' => 'shipping-fast', 
                            'title' => __('Transport sécurisé'), 
                            'desc' => __('Nous organisons l\'enlèvement et le transport de vos marchandises'),
                            'position' => 'left'
                        ],
                        [
                            'icon' => 'box-open', 
                            'title' => __('Livraison finale'), 
                            'desc' => __('Suivez votre colis en temps réel jusqu\'à la livraison finale'),
                            'position' => 'right'
                        ]
                    ];
                @endphp

                @foreach($steps as $index => $step)
                    <div class="relative flex flex-col md:flex-row items-center">
                        <!-- Côté gauche -->
                        <div class="md:w-1/2 {{ $step['position'] === 'left' ? 'md:pr-12 md:text-right' : 'md:pl-12 md:order-2' }} mb-8 md:mb-0">
                            <div class="bg-white rounded-xl p-6 shadow-lg border border-slate-200 max-w-md {{ $step['position'] === 'left' ? 'md:ml-auto' : 'md:mr-auto' }}">
                                <h3 class="text-xl font-semibold text-slate-900 mb-3">{{ $step['title'] }}</h3>
                                <p class="text-slate-600 leading-relaxed">
                                    {{ $step['desc'] }}
                                </p>
                            </div>
                        </div>

                        <!-- Point central -->
                        <div class="absolute left-1/2 transform -translate-x-1/2 md:relative md:left-0 md:transform-none z-10">
                            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-xl font-bold shadow-lg border-4 border-white">
                                <i class="fas fa-{{ $step['icon'] }}"></i>
                            </div>
                            <div class="absolute -top-2 -right-2 bg-white rounded-full w-8 h-8 flex items-center justify-center text-blue-600 font-bold text-sm shadow-lg border">
                                {{ $index + 1 }}
                            </div>
                        </div>

                        <!-- Côté droit (espace vide pour l'alternance) -->
                        <div class="md:w-1/2 {{ $step['position'] === 'left' ? 'md:pl-12 md:order-2' : 'md:pr-12 md:text-right' }}"></div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Appel à l'action processus -->
        <div class="text-center mt-16">
            <a href="{{ route('demande.create') }}{{ app()->getLocale() != 'fr' ? '?locale=' . app()->getLocale() : '' }}" class="inline-flex items-center px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-lg transition-all transform hover:scale-105">
                <i class="fas fa-play-circle mr-3"></i>
                {{ __('Démarrer mon envoi') }}
            </a>
        </div>
    </div>
</section>

<!-- Galerie Section -->
@if($photosGalerie && $photosGalerie->count() > 0)
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center bg-blue-600 text-white rounded-full px-4 py-2 mb-4">
                <i class="fas fa-images mr-2"></i>
                <span class="font-semibold">{{ __('Galerie') }}</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">
                {{ __('Notre') }} <span class="text-blue-600">{{ __('univers') }}</span>
            </h2>
            <p class="text-xl text-slate-600">
                {{ __('Découvrez nos activités, nos équipes et nos réalisations en images') }}
            </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($photosGalerie as $photo)
                <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <img src="{{ $photo->image_url }}" 
                         alt="{{ $photo->alt }}"
                         class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                            <div class="mb-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20">
                                    {{ $photo->categorie_formate }}
                                </span>
                            </div>
                            <h3 class="font-semibold text-lg mb-2">{{ $photo->titre }}</h3>
                            @if($photo->description)
                                <p class="text-sm text-slate-200 leading-relaxed">{{ Str::limit($photo->description, 80) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('galerie.index') }}{{ app()->getLocale() != 'fr' ? '?locale=' . app()->getLocale() : '' }}" class="inline-flex items-center px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-all transform hover:scale-105">
                <i class="fas fa-images mr-3"></i>
                {{ __('Explorer la galerie complète') }}
            </a>
        </div>
    </div>
</section>
@endif

<!-- Avantages Section -->
<section class="py-20 bg-slate-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="inline-flex items-center bg-blue-500 text-white rounded-full px-4 py-2 mb-6">
                    <i class="fas fa-trophy mr-2"></i>
                    <span class="font-semibold">{{ __('Pourquoi nous choisir') }}</span>
                </div>
                
                <h2 class="text-3xl lg:text-4xl font-bold mb-8">
                    {{ __('L\'excellence') }} <span class="text-blue-400">{{ __('logistique') }}</span>
                </h2>
                
                <div class="space-y-6">
                    @php
                        $advantages = [
                            ['icon' => 'shield-alt', 'title' => __('Sécurité garantie'), 'desc' => __('Assurance tous risques et emballage professionnel pour protéger vos marchandises')],
                            ['icon' => 'map-marker-alt', 'title' => __('Suivi en temps réel'), 'desc' => __('Notifications SMS et email à chaque étape du transport')],
                            ['icon' => 'clock', 'title' => __('Service rapide'), 'desc' => __('Délais respectés et service client réactif 7j/7')],
                            ['icon' => 'euro-sign', 'title' => __('Prix compétitifs'), 'desc' => __('Tarifs transparents sans frais cachés et options de paiement flexibles')]
                        ];
                    @endphp

                    @foreach($advantages as $advantage)
                        <div class="flex items-start group">
                            <div class="bg-blue-500 rounded-lg p-3 mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-{{ $advantage['icon'] }} text-white text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold mb-2 text-white">{{ $advantage['title'] }}</h3>
                                <p class="text-slate-300 leading-relaxed">{{ $advantage['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- World Map -->
            <div class="bg-slate-700 rounded-xl p-8 border border-slate-600">
                <div class="text-center mb-8">
                    <div class="text-6xl mb-4 text-blue-400">
                        <i class="fas fa-globe-africa"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">{{ __('Réseau International') }}</h3>
                    <p class="text-slate-300">
                        {{ __('Présent dans plus de 15 pays avec des partenaires de confiance') }}
                    </p>
                </div>
                
                <div class="grid grid-cols-3 gap-4">
                    @php
                        $countries = [
                            ['flag' => '🇹🇬', 'name' => 'Togo', 'desc' => __('Siège social')],
                            ['flag' => '🇧🇯', 'name' => 'Bénin', 'desc' => __('Agence')],
                            ['flag' => '🇫🇷', 'name' => 'France', 'desc' => __('Partenaire')],
                            ['flag' => '🇨🇮', 'name' => 'Côte d\'Ivoire', 'desc' => __('Agence')],
                            ['flag' => '🇬🇭', 'name' => 'Ghana', 'desc' => __('Partenaire')],
                            ['flag' => '🇳🇬', 'name' => 'Nigeria', 'desc' => __('Agence')]
                        ];
                    @endphp

                    @foreach($countries as $country)
                        <div class="bg-slate-600 rounded-lg p-4 text-center border border-slate-500 hover:border-blue-500 transition-colors">
                            <div class="text-2xl mb-2">{{ $country['flag'] }}</div>
                            <div class="font-semibold text-blue-300 text-sm">{{ $country['name'] }}</div>
                            <div class="text-slate-400 text-xs mt-1">{{ $country['desc'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-blue-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold mb-6">
            {{ __('Prêt à expédier vos marchandises ?') }}
        </h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto leading-relaxed">
            {{ __('Obtenez un devis gratuit personnalisé en moins de 2 minutes') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('demande.create') }}{{ app()->getLocale() != 'fr' ? '?locale=' . app()->getLocale() : '' }}" 
               class="bg-white text-blue-600 hover:bg-slate-100 px-8 py-4 rounded-lg font-semibold text-lg inline-flex items-center justify-center transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-box mr-3"></i> {{ __('Demander un devis gratuit') }}
            </a>
            <a href="{{ route('contact') }}{{ app()->getLocale() != 'fr' ? '?locale=' . app()->getLocale() : '' }}" 
               class="bg-transparent border-2 border-white text-white hover:bg-white/10 px-8 py-4 rounded-lg font-semibold text-lg inline-flex items-center justify-center transition-all duration-300">
                <i class="fas fa-phone mr-3"></i> {{ __('Nous contacter') }}
            </a>
        </div>
        
        <!-- Trust Badges -->
        <div class="flex flex-wrap justify-center gap-6 mt-12 text-blue-100">
            <div class="flex items-center">
                <i class="fas fa-lock mr-2"></i>
                <span>{{ __('100% Sécurisé') }}</span>
            </div>
            <div class="flex items-center">
                <i class="fas fa-clock mr-2"></i>
                <span>{{ __('Réponse sous 24h') }}</span>
            </div>
            <div class="flex items-center">
                <i class="fas fa-star mr-2"></i>
                <span>{{ __('Service Premium') }}</span>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
/* Styles pour le slider synchronisé */
.slide {
    opacity: 0;
    transition: opacity 0.8s ease-in-out;
    z-index: 1;
}

.slide.active {
    opacity: 1;
    z-index: 2;
}

.slide-content {
    display: none;
}

.slide-content.active {
    display: block;
    animation: fadeInUp 0.8s ease-out;
}

.slider-container {
    position: relative;
}

/* Animation des indicateurs */
.slide-indicator {
    transition: all 0.3s ease-in-out;
}

/* Navigation hover effects */
.slider-nav:hover {
    transform: translateY(-50%) scale(1.1);
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Timeline process */
@media (max-width: 768px) {
    .process-timeline::before {
        left: 30px;
    }
}

/* Smooth transitions */
.transition-all {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Classes pour les types d'annonces */
.bg-promotion {
    background-color: #10b981;
    color: white;
}

.bg-urgent {
    background-color: #ef4444;
    color: white;
}

.bg-actualite {
    background-color: #3b82f6;
    color: white;
}

.bg-default {
    background-color: #6b7280;
    color: white;
}
</style>
@endpush

@push('scripts')
<script>
// Script pour le slider synchronisé
document.addEventListener('DOMContentLoaded', function() {
    let currentSlide = 1;
    const totalSlides = 4;
    let slideInterval;

    const slides = document.querySelectorAll('.slide');
    const slideContents = document.querySelectorAll('.slide-content');
    const indicators = document.querySelectorAll('.slide-indicator');

    function goToSlide(n) {
        // Retirer la classe active de tous les éléments
        slides.forEach(slide => slide.classList.remove('active'));
        slideContents.forEach(content => content.classList.remove('active'));
        indicators.forEach(indicator => {
            indicator.classList.remove('bg-white', 'w-8');
            indicator.classList.add('bg-white/50', 'w-3');
        });
        
        // Mettre à jour l'index du slide
        currentSlide = n;
        
        // Ajouter la classe active aux éléments correspondants
        document.querySelector(`.slide[data-slide="${currentSlide}"]`).classList.add('active');
        document.querySelector(`.slide-content[data-slide="${currentSlide}"]`).classList.add('active');
        document.querySelector(`.slide-indicator[data-slide="${currentSlide}"]`).classList.add('bg-white', 'w-8');
        document.querySelector(`.slide-indicator[data-slide="${currentSlide}"]`).classList.remove('bg-white/50', 'w-3');
    }

    function nextSlide() {
        const next = currentSlide === totalSlides ? 1 : currentSlide + 1;
        goToSlide(next);
    }

    function prevSlide() {
        const prev = currentSlide === 1 ? totalSlides : currentSlide - 1;
        goToSlide(prev);
    }

    function startSlideShow() {
        slideInterval = setInterval(nextSlide, 5000);
    }

    function stopSlideShow() {
        clearInterval(slideInterval);
    }

    // Événements pour la navigation
    document.querySelector('.slider-next').addEventListener('click', () => {
        stopSlideShow();
        nextSlide();
        startSlideShow();
    });

    document.querySelector('.slider-prev').addEventListener('click', () => {
        stopSlideShow();
        prevSlide();
        startSlideShow();
    });

    // Événements pour les indicateurs
    indicators.forEach((indicator) => {
        indicator.addEventListener('click', () => {
            const slideNumber = parseInt(indicator.getAttribute('data-slide'));
            stopSlideShow();
            goToSlide(slideNumber);
            startSlideShow();
        });
    });

    // Pause au survol
    const slider = document.querySelector('.slider-container');
    slider.addEventListener('mouseenter', stopSlideShow);
    slider.addEventListener('mouseleave', startSlideShow);

    // Démarrer le slider
    startSlideShow();
});
</script>
@endpush
@endsection