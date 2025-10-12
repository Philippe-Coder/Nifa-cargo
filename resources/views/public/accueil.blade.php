@extends('layouts.main')

@section('title', 'NIFA - Transport et Logistique en Afrique')

@section('content')
<!-- Hero Section -->
<section class="hero-bg-home relative overflow-hidden py-20">
    <!-- Overlay animé -->
    <div class="hero-overlay"></div>
    
    <!-- Particules flottantes -->
    <div class="hero-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Contenu principal -->
            <div class="hero-text relative z-10">
                <div class="inline-flex items-center bg-white bg-opacity-20 backdrop-blur-sm rounded-full px-4 py-2 mb-6">
                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                    <span class="text-sm font-medium">Leader du transport en Afrique</span>
                </div>
                
                <h1 class="hero-title text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                    Votre partenaire <span class="text-red-400">logistique</span> en Afrique
                </h1>
                <p class="hero-subtitle text-xl lg:text-2xl mb-8">
                    Solutions complètes de transport maritime, aérien et terrestre avec suivi en temps réel
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('demande.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg inline-flex items-center justify-center">
                        <i class="fas fa-box mr-3"></i> Faire une demande
                    </a>
                    <a href="{{ route('suivi.public') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-lg font-semibold text-lg inline-flex items-center justify-center">
                        <i class="fas fa-search mr-3"></i> Suivre un colis
                    </a>
                </div>
                
                <!-- Trust indicators -->
                <div class="flex flex-wrap gap-6 mt-10">
                    <div class="flex items-center">
                        <i class="fas fa-shield-alt text-blue-200 mr-2"></i>
                        <span class="text-blue-100">Sécurité garantie</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock text-blue-200 mr-2"></i>
                        <span class="text-blue-100">Livraison rapide</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-headset text-blue-200 mr-2"></i>
                        <span class="text-blue-100">Support 24/7</span>
                    </div>
                </div>
            </div>

            <!-- Illustration/Stats -->
            <div class="relative">
                <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-8">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-white bg-opacity-20 rounded-xl p-6 text-center">
                            <div class="text-3xl font-bold mb-2 text-white">{{ number_format($stats['demandes_traitees']) }}+</div>
                            <div class="text-sm text-blue-100">Demandes traitées</div>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-xl p-6 text-center">
                            <div class="text-3xl font-bold mb-2 text-white">{{ $stats['clients_satisfaits'] }}%</div>
                            <div class="text-sm text-blue-100">Clients satisfaits</div>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-xl p-6 text-center">
                            <div class="text-3xl font-bold mb-2 text-white">{{ $stats['pays_desservis'] }}+</div>
                            <div class="text-sm text-blue-100">Pays desservis</div>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-xl p-6 text-center">
                            <div class="text-3xl font-bold mb-2 text-white">{{ $stats['annees_experience'] }}+</div>
                            <div class="text-sm text-blue-100">Années d'expérience</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vague décorative -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" class="w-full h-12 lg:h-20">
            <path fill="#ffffff" d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,64C960,75,1056,85,1152,80C1248,75,1344,53,1392,42.7L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
        </svg>
    </div>
</section>


    <!-- Annonces -->
    @if($annonces && $annonces->count() > 0)
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    📢 <span class="text-blue-700">Actualités</span> & Annonces
                </h2>
                <p class="text-xl text-gray-600">
                    Restez informés de nos dernières nouvelles et promotions
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($annonces as $annonce)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <!-- Badge épinglé -->
                        @if($annonce->epingle)
                            <div class="absolute top-4 right-4 z-10">
                                <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    <i class="fas fa-star mr-1"></i>
                                    À la une
                                </span>
                            </div>
                        @endif
                        
                        <!-- Image -->
                        @if($annonce->image)
                            <div class="h-48 bg-cover bg-center relative" style="background-image: url('{{ asset('storage/' . $annonce->image) }}')">
                                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                            </div>
                        @else
                            <div class="h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                <i class="fas fa-bullhorn text-white text-4xl"></i>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <!-- Type et date -->
                            <div class="flex justify-between items-center mb-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $annonce->type_class }}">
                                    @switch($annonce->type)
                                        @case('promotion')
                                            <i class="fas fa-percent mr-1"></i>
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
                                <span class="text-xs text-gray-500">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ $annonce->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                            
                            <!-- Titre -->
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">
                                {{ $annonce->titre }}
                            </h3>
                            
                            <!-- Contenu -->
                            <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                                {{ Str::limit(strip_tags($annonce->contenu), 120) }}
                            </p>
                            
                            <!-- Action -->
                            <div class="flex justify-between items-center">
                                <button onclick="showAnnonceModal({{ $annonce->id }})" 
                                        class="text-blue-600 hover:text-blue-800 font-medium text-sm transition-colors">
                                    <i class="fas fa-arrow-right mr-1"></i>
                                    Lire la suite
                                </button>
                                
                                @if($annonce->type == 'promotion')
                                    <a href="{{ route('demande.create') }}" 
                                       class="bg-green-500 text-white px-4 py-2 rounded-lg text-xs font-medium hover:bg-green-600 transition-colors">
                                        <i class="fas fa-gift mr-1"></i>
                                        Profiter
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

    <!-- Services principaux -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 fade-in">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Nos <span class="text-blue-700">Services</span> de Transport
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Des solutions complètes adaptées à tous vos besoins de transport et logistique en Afrique et au-delà
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Transport Maritime -->
                <div class="service-card bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 shadow-sm border border-blue-100">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-700 to-blue-500 rounded-xl flex items-center justify-center text-white text-2xl mb-6">
                        <i class="fas fa-ship"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Transport Maritime</h3>
                    <p class="text-gray-600 mb-4">
                        Conteneurs et groupage vers l'Afrique et l'Europe avec dédouanement complet
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2 mb-6">
                        <li class="flex items-center">
                            <i class="fas fa-check text-blue-600 mr-2"></i> Conteneurs 20 et 40 pieds
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-blue-600 mr-2"></i> Groupage LCL
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-blue-600 mr-2"></i> Dédouanement inclus
                        </li>
                    </ul>
                    <a href="{{ route('services') }}" class="text-blue-600 font-medium hover:text-blue-800 inline-flex items-center transition-colors">
                        En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Transport Aérien -->
                <div class="service-card bg-gradient-to-br from-red-50 to-red-100 rounded-2xl p-8 shadow-sm border border-red-100">
                    <div class="w-16 h-16 bg-gradient-to-r from-red-700 to-red-500 rounded-xl flex items-center justify-center text-white text-2xl mb-6">
                        <i class="fas fa-plane"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Transport Aérien</h3>
                    <p class="text-gray-600 mb-4">
                        Livraison express pour vos marchandises urgentes et fragiles
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2 mb-6">
                        <li class="flex items-center">
                            <i class="fas fa-check text-red-600 mr-2"></i> Livraison 24-48h
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-red-600 mr-2"></i> Marchandises fragiles
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-red-600 mr-2"></i> Réseau mondial
                        </li>
                    </ul>
                    <a href="{{ route('services') }}" class="text-red-600 font-medium hover:text-red-800 inline-flex items-center transition-colors">
                        En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Transport Terrestre -->
                <div class="service-card bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl p-8 shadow-sm border border-indigo-100">
                    <div class="w-16 h-16 bg-gradient-to-r from-indigo-700 to-indigo-500 rounded-xl flex items-center justify-center text-white text-2xl mb-6">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Transport Terrestre</h3>
                    <p class="text-gray-600 mb-4">
                        Flotte moderne pour le transport routier en Afrique de l'Ouest
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2 mb-6">
                        <li class="flex items-center">
                            <i class="fas fa-check text-indigo-600 mr-2"></i> Camions réfrigérés
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-indigo-600 mr-2"></i> Transport véhicules
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-indigo-600 mr-2"></i> Livraison domicile
                        </li>
                    </ul>
                    <a href="{{ route('services') }}" class="text-indigo-600 font-medium hover:text-indigo-800 inline-flex items-center transition-colors">
                        En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Processus de transport -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 fade-in">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Comment ça <span class="text-blue-700">marche</span> ?
                </h2>
                <p class="text-xl text-gray-600">
                    Un processus simple et transparent en 4 étapes
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Étape 1 -->
                <div class="process-step text-center">
                    <div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white w-20 h-20 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Demande</h3>
                    <p class="text-gray-600 text-sm">
                        Remplissez notre formulaire en ligne avec les détails de votre envoi
                    </p>
                </div>

                <!-- Étape 2 -->
                <div class="process-step text-center">
                    <div class="bg-gradient-to-r from-red-700 to-red-500 text-white w-20 h-20 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Devis</h3>
                    <p class="text-gray-600 text-sm">
                        Recevez votre devis personnalisé sous 24h avec options de paiement
                    </p>
                </div>

                <!-- Étape 3 -->
                <div class="process-step text-center">
                    <div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white w-20 h-20 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Transport</h3>
                    <p class="text-gray-600 text-sm">
                        Nous organisons l'enlèvement et le transport de vos marchandises
                    </p>
                </div>

                <!-- Étape 4 -->
                <div class="text-center">
                    <div class="bg-gradient-to-r from-red-700 to-red-500 text-white w-20 h-20 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Livraison</h3>
                    <p class="text-gray-600 text-sm">
                        Suivez votre colis en temps réel jusqu'à la livraison finale
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Galerie Photos -->
    @if($photosGalerie && $photosGalerie->count() > 0)
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    📸 Notre <span class="text-blue-700">Galerie</span>
                </h2>
                <p class="text-xl text-gray-600">
                    Découvrez nos activités, nos équipes et nos réalisations en images
                </p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($photosGalerie as $photo)
                    <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                        <img src="{{ $photo->image_url }}" 
                             alt="{{ $photo->alt }}"
                             class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-110">
                        
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                <div class="mb-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-white/20 backdrop-blur-sm">
                                        {{ $photo->categorie_formate }}
                                    </span>
                                </div>
                                <h3 class="font-semibold text-sm mb-1">{{ $photo->titre }}</h3>
                                @if($photo->description)
                                    <p class="text-xs text-gray-200 line-clamp-2">{{ Str::limit($photo->description, 80) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="#" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all transform hover:scale-105 shadow-lg">
                    <i class="fas fa-images mr-2"></i>
                    Voir toute la galerie
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Avantages -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Contenu -->
                <div class="fade-in">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">
                        Pourquoi choisir <span class="text-blue-700">NIFA</span> ?
                    </h2>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-blue-100 rounded-xl p-4 mr-4">
                                <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Sécurité garantie</h3>
                                <p class="text-gray-600">Assurance tous risques et emballage professionnel pour protéger vos marchandises</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-red-100 rounded-xl p-4 mr-4">
                                <i class="fas fa-map-marker-alt text-red-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Suivi en temps réel</h3>
                                <p class="text-gray-600">Notifications SMS et email à chaque étape du transport</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-blue-100 rounded-xl p-4 mr-4">
                                <i class="fas fa-clock text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Service rapide</h3>
                                <p class="text-gray-600">Délais respectés et service client réactif 7j/7</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-red-100 rounded-xl p-4 mr-4">
                                <i class="fas fa-euro-sign text-red-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Prix compétitifs</h3>
                                <p class="text-gray-600">Tarifs transparents sans frais cachés et options de paiement flexibles</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image/Illustration -->
                <div class="bg-gradient-to-br from-blue-50 to-red-50 rounded-2xl p-8 text-center shadow-sm border border-blue-100">
                    <div class="text-8xl mb-6 text-blue-600">
                        <i class="fas fa-globe-africa"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Réseau International</h3>
                    <p class="text-gray-600 mb-6">
                        Présent dans plus de 15 pays avec des partenaires de confiance
                    </p>
                    <div class="grid grid-cols-3 gap-4 text-sm">
                        <div class="bg-white rounded-xl p-3 shadow-sm">
                            <div class="font-semibold text-blue-700">🇹🇬 Togo</div>
                            <div class="text-gray-600 text-xs">Siège social</div>
                        </div>
                        <div class="bg-white rounded-xl p-3 shadow-sm">
                            <div class="font-semibold text-blue-700">🇧🇯 Bénin</div>
                            <div class="text-gray-600 text-xs">Agence</div>
                        </div>
                        <div class="bg-white rounded-xl p-3 shadow-sm">
                            <div class="font-semibold text-blue-700">🇫🇷 France</div>
                            <div class="text-gray-600 text-xs">Partenaire</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 gradient-bg hero-pattern">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6">
                Prêt à expédier vos marchandises ?
            </h2>
            <p class="text-xl text-blue-100 mb-8">
                Obtenez un devis gratuit en moins de 2 minutes
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('demande.create') }}" class="btn-primary px-8 py-4 rounded-lg font-semibold text-lg inline-flex items-center justify-center">
                    <i class="fas fa-box mr-3"></i> Demander un devis gratuit
                </a>
                <a href="{{ route('contact') }}" class="btn-secondary px-8 py-4 rounded-lg font-semibold text-lg inline-flex items-center justify-center">
                    <i class="fas fa-phone mr-3"></i> Nous contacter
                </a>
            </div>
        </div>
    </section>
@endsection