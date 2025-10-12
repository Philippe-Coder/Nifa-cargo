@extends('layouts.main')

@section('title', 'NIFA - Transport et Logistique en Afrique')

@section('content')
<!-- Hero Section Modernisé -->
<section class="relative bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 overflow-hidden py-16 lg:py-24">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.1\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"1\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <!-- Animated Elements -->
    <div class="hero-particles">
        @for ($i = 0; $i < 12; $i++)
            <div class="particle"></div>
        @endfor
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Content -->
            <div class="text-white">
                <div class="inline-flex items-center bg-white/10 backdrop-blur-md rounded-full px-4 py-2 mb-6 border border-white/20">
                    <span class="w-2 h-2 bg-red-400 rounded-full mr-2 animate-pulse"></span>
                    <span class="text-sm font-medium text-white">Leader du transport en Afrique</span>
                </div>
                
                <h1 class="text-4xl lg:text-5xl xl:text-6xl font-bold mb-6 leading-tight">
                    Votre partenaire 
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">logistique</span> 
                    en Afrique
                </h1>
                
                <p class="text-xl lg:text-2xl text-blue-100 mb-8 leading-relaxed">
                    Solutions complètes de transport maritime, aérien et terrestre avec suivi en temps réel
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 mb-8">
                    <a href="{{ route('demande.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl font-semibold text-lg inline-flex items-center justify-center transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-blue-500/25">
                        <i class="fas fa-box mr-3"></i> Faire une demande
                    </a>
                    <a href="{{ route('suivi.public') }}" 
                       class="bg-white/10 hover:bg-white/20 text-white backdrop-blur-sm px-8 py-4 rounded-xl font-semibold text-lg inline-flex items-center justify-center transition-all duration-300 border border-white/20">
                        <i class="fas fa-search mr-3"></i> Suivre un colis
                    </a>
                </div>
                
                <!-- Trust Indicators -->
                <div class="flex flex-wrap gap-6 text-blue-100">
                    <div class="flex items-center">
                        <i class="fas fa-shield-alt text-blue-300 mr-2"></i>
                        <span>Sécurité garantie</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock text-blue-300 mr-2"></i>
                        <span>Livraison rapide</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-headset text-blue-300 mr-2"></i>
                        <span>Support 24/7</span>
                    </div>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="relative">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20 shadow-2xl">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-white/10 rounded-xl p-6 text-center backdrop-blur-sm border border-white/10">
                            <div class="text-3xl font-bold mb-2 text-white">{{ number_format($stats['demandes_traitees']) }}+</div>
                            <div class="text-sm text-blue-200">Demandes traitées</div>
                        </div>
                        <div class="bg-white/10 rounded-xl p-6 text-center backdrop-blur-sm border border-white/10">
                            <div class="text-3xl font-bold mb-2 text-white">{{ $stats['clients_satisfaits'] }}%</div>
                            <div class="text-sm text-blue-200">Clients satisfaits</div>
                        </div>
                        <div class="bg-white/10 rounded-xl p-6 text-center backdrop-blur-sm border border-white/10">
                            <div class="text-3xl font-bold mb-2 text-white">{{ $stats['pays_desservis'] }}+</div>
                            <div class="text-sm text-blue-200">Pays desservis</div>
                        </div>
                        <div class="bg-white/10 rounded-xl p-6 text-center backdrop-blur-sm border border-white/10">
                            <div class="text-3xl font-bold mb-2 text-white">{{ $stats['annees_experience'] }}+</div>
                            <div class="text-sm text-blue-200">Années d'expérience</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Wave Divider -->
    <div class="absolute bottom-0 left-0 right-0">
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
            <div class="inline-flex items-center bg-blue-100 text-blue-800 rounded-full px-4 py-2 mb-4">
                <i class="fas fa-bullhorn mr-2"></i>
                <span class="font-semibold">Actualités & Annonces</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">
                Restez <span class="text-blue-600">informé</span>
            </h2>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto">
                Découvrez nos dernières nouvelles, promotions et actualités importantes
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($annonces as $annonce)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden group">
                    @if($annonce->epingle)
                        <div class="absolute top-4 right-4 z-10">
                            <span class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
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
                        <div class="h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                            <i class="fas fa-newspaper text-white text-4xl"></i>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $annonce->type_class }} backdrop-blur-sm">
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
                                <span>Lire la suite</span>
                                <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                            </button>
                            
                            @if($annonce->type == 'promotion')
                                <a href="{{ route('demande.create') }}" 
                                   class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 py-2 rounded-lg text-xs font-medium hover:from-green-600 hover:to-emerald-700 transition-all transform hover:scale-105 shadow-lg">
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

<!-- Services Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center bg-blue-100 text-blue-800 rounded-full px-4 py-2 mb-4">
                <i class="fas fa-shipping-fast mr-2"></i>
                <span class="font-semibold">Nos Services</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">
                Solutions <span class="text-blue-600">complètes</span>
            </h2>
            <p class="text-xl text-slate-600 max-w-3xl mx-auto">
                Des services de transport adaptés à tous vos besoins logistiques en Afrique et au-delà
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Transport Maritime -->
            <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-slate-100">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-blue-400 rounded-xl flex items-center justify-center text-white text-2xl mb-6 shadow-lg">
                    <i class="fas fa-ship"></i>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 mb-4">Transport Maritime</h3>
                <p class="text-slate-600 mb-6 leading-relaxed">
                    Conteneurs et groupage vers l'Afrique et l'Europe avec dédouanement complet
                </p>
                <ul class="text-sm text-slate-600 space-y-3 mb-6">
                    <li class="flex items-center">
                        <i class="fas fa-check text-blue-600 mr-3 bg-blue-100 p-1 rounded-full"></i>
                        Conteneurs 20 et 40 pieds
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-blue-600 mr-3 bg-blue-100 p-1 rounded-full"></i>
                        Groupage LCL
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-blue-600 mr-3 bg-blue-100 p-1 rounded-full"></i>
                        Dédouanement inclus
                    </li>
                </ul>
                <a href="{{ route('services') }}" class="text-blue-600 font-medium hover:text-blue-800 inline-flex items-center transition-colors group">
                    <span>En savoir plus</span>
                    <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <!-- Transport Aérien -->
            <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-slate-100">
                <div class="w-16 h-16 bg-gradient-to-r from-red-600 to-red-400 rounded-xl flex items-center justify-center text-white text-2xl mb-6 shadow-lg">
                    <i class="fas fa-plane"></i>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 mb-4">Transport Aérien</h3>
                <p class="text-slate-600 mb-6 leading-relaxed">
                    Livraison express pour vos marchandises urgentes et fragiles
                </p>
                <ul class="text-sm text-slate-600 space-y-3 mb-6">
                    <li class="flex items-center">
                        <i class="fas fa-check text-red-600 mr-3 bg-red-100 p-1 rounded-full"></i>
                        Livraison 24-48h
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-red-600 mr-3 bg-red-100 p-1 rounded-full"></i>
                        Marchandises fragiles
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-red-600 mr-3 bg-red-100 p-1 rounded-full"></i>
                        Réseau mondial
                    </li>
                </ul>
                <a href="{{ route('services') }}" class="text-red-600 font-medium hover:text-red-800 inline-flex items-center transition-colors group">
                    <span>En savoir plus</span>
                    <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <!-- Transport Terrestre -->
            <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-slate-100">
                <div class="w-16 h-16 bg-gradient-to-r from-indigo-600 to-indigo-400 rounded-xl flex items-center justify-center text-white text-2xl mb-6 shadow-lg">
                    <i class="fas fa-truck"></i>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 mb-4">Transport Terrestre</h3>
                <p class="text-slate-600 mb-6 leading-relaxed">
                    Flotte moderne pour le transport routier en Afrique de l'Ouest
                </p>
                <ul class="text-sm text-slate-600 space-y-3 mb-6">
                    <li class="flex items-center">
                        <i class="fas fa-check text-indigo-600 mr-3 bg-indigo-100 p-1 rounded-full"></i>
                        Camions réfrigérés
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-indigo-600 mr-3 bg-indigo-100 p-1 rounded-full"></i>
                        Transport véhicules
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-indigo-600 mr-3 bg-indigo-100 p-1 rounded-full"></i>
                        Livraison domicile
                    </li>
                </ul>
                <a href="{{ route('services') }}" class="text-indigo-600 font-medium hover:text-indigo-800 inline-flex items-center transition-colors group">
                    <span>En savoir plus</span>
                    <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="py-20 bg-gradient-to-br from-slate-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center bg-white text-blue-800 rounded-full px-4 py-2 mb-4 shadow-lg">
                <i class="fas fa-cogs mr-2"></i>
                <span class="font-semibold">Notre Processus</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">
                Comment ça <span class="text-blue-600">fonctionne</span> ?
            </h2>
            <p class="text-xl text-slate-600">
                Un processus simple et transparent en 4 étapes
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
            <!-- Connecting Line -->
            <div class="hidden md:block absolute top-20 left-1/4 right-1/4 h-0.5 bg-blue-200 -z-10"></div>
            
            @php
                $steps = [
                    ['icon' => 'file-alt', 'title' => 'Demande', 'desc' => 'Remplissez notre formulaire en ligne avec les détails de votre envoi'],
                    ['icon' => 'calculator', 'title' => 'Devis', 'desc' => 'Recevez votre devis personnalisé sous 24h avec options de paiement'],
                    ['icon' => 'shipping-fast', 'title' => 'Transport', 'desc' => 'Nous organisons l\'enlèvement et le transport de vos marchandises'],
                    ['icon' => 'box-open', 'title' => 'Livraison', 'desc' => 'Suivez votre colis en temps réel jusqu\'à la livraison finale']
                ];
            @endphp

            @foreach($steps as $index => $step)
                <div class="text-center group">
                    <div class="relative mb-6">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white w-20 h-20 rounded-full flex items-center justify-center text-2xl font-bold mx-auto shadow-lg transform group-hover:scale-110 transition-all duration-300">
                            <i class="fas fa-{{ $step['icon'] }}"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 bg-white rounded-full w-8 h-8 flex items-center justify-center text-blue-600 font-bold text-sm shadow-lg">
                            {{ $index + 1 }}
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-3">{{ $step['title'] }}</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        {{ $step['desc'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Galerie Section -->
@if($photosGalerie && $photosGalerie->count() > 0)
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center bg-blue-100 text-blue-800 rounded-full px-4 py-2 mb-4">
                <i class="fas fa-images mr-2"></i>
                <span class="font-semibold">Galerie</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">
                Notre <span class="text-blue-600">univers</span>
            </h2>
            <p class="text-xl text-slate-600">
                Découvrez nos activités, nos équipes et nos réalisations en images
            </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($photosGalerie as $photo)
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <img src="{{ $photo->image_url }}" 
                         alt="{{ $photo->alt }}"
                         class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                            <div class="mb-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 backdrop-blur-sm">
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
            <a href="{{ route('galerie.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all transform hover:scale-105 shadow-lg hover:shadow-xl">
                <i class="fas fa-images mr-3"></i>
                Explorer la galerie complète
            </a>
        </div>
    </div>
</section>
@endif

<!-- Avantages Section -->
<section class="py-20 bg-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="inline-flex items-center bg-blue-500/20 text-blue-300 rounded-full px-4 py-2 mb-6 border border-blue-500/30">
                    <i class="fas fa-trophy mr-2"></i>
                    <span class="font-semibold">Pourquoi nous choisir</span>
                </div>
                
                <h2 class="text-3xl lg:text-4xl font-bold mb-8">
                    L'excellence <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">logistique</span>
                </h2>
                
                <div class="space-y-6">
                    @php
                        $advantages = [
                            ['icon' => 'shield-alt', 'color' => 'blue', 'title' => 'Sécurité garantie', 'desc' => 'Assurance tous risques et emballage professionnel pour protéger vos marchandises'],
                            ['icon' => 'map-marker-alt', 'color' => 'red', 'title' => 'Suivi en temps réel', 'desc' => 'Notifications SMS et email à chaque étape du transport'],
                            ['icon' => 'clock', 'color' => 'blue', 'title' => 'Service rapide', 'desc' => 'Délais respectés et service client réactif 7j/7'],
                            ['icon' => 'euro-sign', 'color' => 'red', 'title' => 'Prix compétitifs', 'desc' => 'Tarifs transparents sans frais cachés et options de paiement flexibles']
                        ];
                    @endphp

                    @foreach($advantages as $advantage)
                        <div class="flex items-start group">
                            <div class="bg-{{ $advantage['color'] }}-500/20 rounded-xl p-4 mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-{{ $advantage['icon'] }} text-{{ $advantage['color'] }}-400 text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold mb-2 text-white">{{ $advantage['title'] }}</h3>
                                <p class="text-slate-300 leading-relaxed">{{ $advantage['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- World Map Illustration -->
            <div class="bg-slate-800 rounded-2xl p-8 border border-slate-700 shadow-2xl">
                <div class="text-center mb-8">
                    <div class="text-6xl mb-4 text-blue-400">
                        <i class="fas fa-globe-africa"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Réseau International</h3>
                    <p class="text-slate-300">
                        Présent dans plus de 15 pays avec des partenaires de confiance
                    </p>
                </div>
                
                <div class="grid grid-cols-3 gap-4">
                    @php
                        $countries = [
                            ['flag' => '🇹🇬', 'name' => 'Togo', 'desc' => 'Siège social'],
                            ['flag' => '🇧🇯', 'name' => 'Bénin', 'desc' => 'Agence'],
                            ['flag' => '🇫🇷', 'name' => 'France', 'desc' => 'Partenaire'],
                            ['flag' => '🇨🇮', 'name' => 'Côte d\'Ivoire', 'desc' => 'Agence'],
                            ['flag' => '🇬🇭', 'name' => 'Ghana', 'desc' => 'Partenaire'],
                            ['flag' => '🇳🇬', 'name' => 'Nigeria', 'desc' => 'Agence']
                        ];
                    @endphp

                    @foreach($countries as $country)
                        <div class="bg-slate-700/50 rounded-xl p-4 text-center backdrop-blur-sm border border-slate-600 hover:border-blue-500/50 transition-colors">
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
<section class="py-20 bg-gradient-to-r from-blue-600 via-blue-700 to-purple-800 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.1\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"1\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6">
            Prêt à expédier vos marchandises ?
        </h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto leading-relaxed">
            Obtenez un devis gratuit personnalisé en moins de 2 minutes
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('demande.create') }}" 
               class="bg-white text-blue-600 hover:bg-slate-100 px-8 py-4 rounded-xl font-semibold text-lg inline-flex items-center justify-center transition-all duration-300 transform hover:scale-105 shadow-lg">
                <i class="fas fa-box mr-3"></i> Demander un devis gratuit
            </a>
            <a href="{{ route('contact') }}" 
               class="bg-transparent border-2 border-white text-white hover:bg-white/10 px-8 py-4 rounded-xl font-semibold text-lg inline-flex items-center justify-center transition-all duration-300 backdrop-blur-sm">
                <i class="fas fa-phone mr-3"></i> Nous contacter
            </a>
        </div>
        
        <!-- Trust Badges -->
        <div class="flex flex-wrap justify-center gap-6 mt-12 text-blue-100">
            <div class="flex items-center">
                <i class="fas fa-lock mr-2"></i>
                <span>100% Sécurisé</span>
            </div>
            <div class="flex items-center">
                <i class="fas fa-clock mr-2"></i>
                <span>Réponse sous 24h</span>
            </div>
            <div class="flex items-center">
                <i class="fas fa-star mr-2"></i>
                <span>Service Premium</span>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.hero-particles .particle {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: float 6s infinite ease-in-out;
}

@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

/* Animation delays for particles */
.hero-particles .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
.hero-particles .particle:nth-child(2) { left: 20%; animation-delay: 1s; }
.hero-particles .particle:nth-child(3) { left: 30%; animation-delay: 2s; }
.hero-particles .particle:nth-child(4) { left: 40%; animation-delay: 3s; }
.hero-particles .particle:nth-child(5) { left: 50%; animation-delay: 4s; }
.hero-particles .particle:nth-child(6) { left: 60%; animation-delay: 5s; }
.hero-particles .particle:nth-child(7) { left: 70%; animation-delay: 1.5s; }
.hero-particles .particle:nth-child(8) { left: 80%; animation-delay: 2.5s; }
.hero-particles .particle:nth-child(9) { left: 90%; animation-delay: 3.5s; }

/* Smooth transitions */
.transition-all {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Backdrop blur support */
@supports (backdrop-filter: blur(10px)) {
    .backdrop-blur-sm {
        backdrop-filter: blur(4px);
    }
    .backdrop-blur-md {
        backdrop-filter: blur(8px);
    }
}
</style>
@endpush