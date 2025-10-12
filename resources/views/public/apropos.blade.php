@extends('layouts.main')

@section('title', 'À Propos - NIFA Transport & Logistique')
@section('description', 'Découvrez NIFA, leader du transport et de la logistique en Afrique depuis plus de 10 ans. Notre histoire, nos valeurs et notre engagement.')

@section('content')
<!-- Hero Section avec Image -->
<section class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-red-700 overflow-hidden py-20 lg:py-28">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80" 
             alt="Équipe NIFA Transport & Logistique" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/80 to-red-700/60"></div>
    </div>

    <!-- Overlay animé -->
    <div class="hero-overlay"></div>
    
    <!-- Particules flottantes -->
    <div class="hero-particles">
        @for ($i = 0; $i < 12; $i++)
            <div class="particle"></div>
        @endfor
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <div class="inline-flex items-center bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-6 border border-white/30">
            <span class="w-2 h-2 bg-red-400 rounded-full mr-2 animate-pulse"></span>
            <span class="text-sm font-medium text-white">Leader depuis 2014</span>
        </div>

        <h1 class="text-4xl lg:text-5xl xl:text-6xl font-bold text-white mb-6 leading-tight">
            À propos de <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-red-300">NIFA</span>
        </h1>
        <p class="text-xl lg:text-2xl text-blue-100 max-w-3xl mx-auto leading-relaxed">
            Votre partenaire de confiance pour le transport et la logistique en Afrique depuis plus de 10 ans
        </p>
    </div>

    <!-- Vague décorative -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" class="w-full h-16 lg:h-20">
            <path fill="#ffffff" fill-opacity="1" d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,74.7C1120,75,1280,53,1360,42.7L1440,32L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</section>

<!-- Notre histoire avec Image de fond -->
<section class="py-20 bg-gradient-to-br from-slate-50 to-blue-50 relative">
    <!-- Image de fond -->
    <div class="absolute inset-0 opacity-10">
        <img src="https://images.unsplash.com/photo-1565689228866-1f6a7ae89ab1?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
             alt="Histoire NIFA" 
             class="w-full h-full object-cover">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Contenu texte -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 lg:p-12 shadow-xl">
                <div class="inline-flex items-center bg-blue-100 text-blue-800 rounded-full px-4 py-2 mb-6">
                    <i class="fas fa-history mr-2"></i>
                    <span class="font-semibold">Notre Histoire</span>
                </div>

                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-6">
                    Une success story <span class="text-blue-600">africaine</span>
                </h2>
                
                <div class="space-y-4 text-slate-700 leading-relaxed">
                    <p>
                        Fondée en 2014 à Lomé, <strong class="text-blue-600">NIFA</strong> (Network International Freight Africa) est née de la vision de faciliter les échanges commerciaux entre l'Afrique et le reste du monde. Nos fondateurs, forts de leur expérience dans le transport international, ont identifié le besoin crucial d'un service de transport fiable et professionnel en Afrique de l'Ouest.
                    </p>
                    <p>
                        Depuis notre création, nous avons accompagné des milliers d'entreprises et de particuliers dans leurs projets d'importation et d'exportation. Notre croissance constante témoigne de la confiance que nous accordent nos clients et de notre engagement à fournir des services de qualité.
                    </p>
                    <p>
                        Aujourd'hui, NIFA est reconnue comme l'un des leaders du transport et de la logistique en Afrique de l'Ouest, avec des bureaux au Togo et au Bénin, et un réseau de partenaires dans plus de 15 pays.
                    </p>
                </div>
            </div>
            
            <!-- Chiffres clés -->
            <div class="bg-gradient-to-br from-blue-600 to-red-600 rounded-2xl p-8 text-white shadow-2xl">
                <div class="text-center mb-8">
                    <i class="fas fa-chart-line text-4xl mb-4 text-white"></i>
                    <h3 class="text-2xl font-bold mb-2">NIFA en chiffres</h3>
                    <p class="text-blue-100">Une croissance continue depuis 2014</p>
                </div>
                
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                        <div class="text-2xl lg:text-3xl font-bold mb-2">2014</div>
                        <div class="text-sm text-blue-100">Année de création</div>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                        <div class="text-2xl lg:text-3xl font-bold mb-2">15+</div>
                        <div class="text-sm text-blue-100">Pays desservis</div>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                        <div class="text-2xl lg:text-3xl font-bold mb-2">5K+</div>
                        <div class="text-sm text-blue-100">Clients satisfaits</div>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                        <div class="text-2xl lg:text-3xl font-bold mb-2">50+</div>
                        <div class="text-sm text-blue-100">Experts dédiés</div>
                    </div>
                </div>

                <!-- Barre de progression -->
                <div class="mt-8">
                    <div class="flex justify-between text-sm text-blue-100 mb-2">
                        <span>Croissance annuelle</span>
                        <span>+25%</span>
                    </div>
                    <div class="w-full bg-white/20 rounded-full h-2">
                        <div class="bg-yellow-400 h-2 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission, Vision, Valeurs -->
<section class="py-20 bg-gradient-to-br from-slate-900 to-blue-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center bg-white/20 text-blue-200 rounded-full px-4 py-2 mb-4 border border-white/20">
                <i class="fas fa-star mr-2"></i>
                <span class="font-semibold">Nos Fondements</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold mb-4">
                Notre <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-red-300">ADN</span>
            </h2>
            <p class="text-xl text-blue-200 max-w-2xl mx-auto">
                Les principes qui guident notre action au quotidien et font notre différence
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Mission -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:border-blue-400 transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white text-2xl mb-6 mx-auto">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4 text-center">Notre Mission</h3>
                <p class="text-blue-100 text-center leading-relaxed">
                    Faciliter les échanges commerciaux en Afrique en offrant des solutions de transport et de logistique fiables, rapides et économiques. Nous nous engageons à connecter l'Afrique au monde entier.
                </p>
            </div>
            
            <!-- Vision -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:border-red-400 transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-r from-red-500 to-red-600 rounded-xl flex items-center justify-center text-white text-2xl mb-6 mx-auto">
                    <i class="fas fa-eye"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4 text-center">Notre Vision</h3>
                <p class="text-blue-100 text-center leading-relaxed">
                    Devenir le leader incontournable du transport et de la logistique en Afrique, reconnu pour son excellence opérationnelle et son innovation technologique.
                </p>
            </div>
            
            <!-- Valeurs -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:border-yellow-400 transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center text-white text-2xl mb-6 mx-auto">
                    <i class="fas fa-heart"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4 text-center">Nos Valeurs</h3>
                <ul class="text-blue-100 space-y-3">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-400 mr-3 bg-green-400/20 p-1 rounded-full"></i>
                        <span><strong class="text-white">Fiabilité</strong> - Respect des engagements</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-400 mr-3 bg-green-400/20 p-1 rounded-full"></i>
                        <span><strong class="text-white">Transparence</strong> - Communication claire</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-400 mr-3 bg-green-400/20 p-1 rounded-full"></i>
                        <span><strong class="text-white">Innovation</strong> - Solutions modernes</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-400 mr-3 bg-green-400/20 p-1 rounded-full"></i>
                        <span><strong class="text-white">Excellence</strong> - Qualité de service</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Équipe dirigeante -->
<section class="py-20 bg-gradient-to-br from-white to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center bg-blue-100 text-blue-800 rounded-full px-4 py-2 mb-4">
                <i class="fas fa-users mr-2"></i>
                <span class="font-semibold">Notre Équipe</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">
                Rencontrez notre <span class="text-blue-600">équipe</span>
            </h2>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto">
                Des experts passionnés et dévoués à votre réussite
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 max-w-6xl mx-auto">
            <!-- CEO -->
            <div class="bg-white rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-slate-100 group">
                <div class="relative mb-6">
                    <div class="w-32 h-32 mx-auto rounded-2xl overflow-hidden shadow-lg group-hover:shadow-2xl transition-all duration-300">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             alt="Kofi MENSAH - Directeur Général" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-bold">
                        CEO
                    </div>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">Kofi MENSAH</h3>
                <p class="text-blue-600 font-medium mb-3">Directeur Général</p>
                <p class="text-slate-600 text-sm leading-relaxed mb-4">
                    15 ans d'expérience dans le transport international. Diplômé en logistique internationale.
                </p>
                <div class="flex justify-center space-x-3">
                    <a href="#" class="text-slate-400 hover:text-blue-600 transition-colors">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-blue-600 transition-colors">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
            
            <!-- COO -->
            <div class="bg-white rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-slate-100 group">
                <div class="relative mb-6">
                    <div class="w-32 h-32 mx-auto rounded-2xl overflow-hidden shadow-lg group-hover:shadow-2xl transition-all duration-300">
                        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             alt="Ama KOFFI - Directrice des Opérations" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-green-600 text-white px-3 py-1 rounded-full text-xs font-bold">
                        COO
                    </div>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">Ama KOFFI</h3>
                <p class="text-green-600 font-medium mb-3">Directrice des Opérations</p>
                <p class="text-slate-600 text-sm leading-relaxed mb-4">
                    Expert en optimisation logistique et gestion des flux. MBA en Supply Chain Management.
                </p>
                <div class="flex justify-center space-x-3">
                    <a href="#" class="text-slate-400 hover:text-green-600 transition-colors">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-green-600 transition-colors">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
            
            <!-- CTO -->
            <div class="bg-white rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-slate-100 group">
                <div class="relative mb-6">
                    <div class="w-32 h-32 mx-auto rounded-2xl overflow-hidden shadow-lg group-hover:shadow-2xl transition-all duration-300">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             alt="Jean AKAKPO - Directeur Technique" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-purple-600 text-white px-3 py-1 rounded-full text-xs font-bold">
                        CTO
                    </div>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">Jean AKAKPO</h3>
                <p class="text-purple-600 font-medium mb-3">Directeur Technique</p>
                <p class="text-slate-600 text-sm leading-relaxed mb-4">
                    Spécialiste des systèmes de suivi et technologies logistiques. Ingénieur en informatique.
                </p>
                <div class="flex justify-center space-x-3">
                    <a href="#" class="text-slate-400 hover:text-purple-600 transition-colors">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-purple-600 transition-colors">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
            
            <!-- CFO -->
            <div class="bg-white rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-slate-100 group">
                <div class="relative mb-6">
                    <div class="w-32 h-32 mx-auto rounded-2xl overflow-hidden shadow-lg group-hover:shadow-2xl transition-all duration-300">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             alt="Marie ADJO - Directrice Financière" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold">
                        CFO
                    </div>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">Marie ADJO</h3>
                <p class="text-red-600 font-medium mb-3">Directrice Financière</p>
                <p class="text-slate-600 text-sm leading-relaxed mb-4">
                    Expert-comptable avec 12 ans d'expérience. Spécialiste en finance internationale.
                </p>
                <div class="flex justify-center space-x-3">
                    <a href="#" class="text-slate-400 hover:text-red-600 transition-colors">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-red-600 transition-colors">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
            
            <!-- CMO -->
            <div class="bg-white rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-slate-100 group">
                <div class="relative mb-6">
                    <div class="w-32 h-32 mx-auto rounded-2xl overflow-hidden shadow-lg group-hover:shadow-2xl transition-all duration-300">
                        <img src="https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             alt="Sarah LAWSON - Directrice Marketing" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-yellow-600 text-white px-3 py-1 rounded-full text-xs font-bold">
                        CMO
                    </div>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">Sarah LAWSON</h3>
                <p class="text-yellow-600 font-medium mb-3">Directrice Marketing</p>
                <p class="text-slate-600 text-sm leading-relaxed mb-4">
                    Spécialiste en marketing digital et relations clients. Master en communication.
                </p>
                <div class="flex justify-center space-x-3">
                    <a href="#" class="text-slate-400 hover:text-yellow-600 transition-colors">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-yellow-600 transition-colors">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Nos engagements -->
<section class="py-20 bg-gradient-to-br from-slate-50 to-red-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center bg-red-100 text-red-800 rounded-full px-4 py-2 mb-4">
                <i class="fas fa-handshake mr-2"></i>
                <span class="font-semibold">Nos Engagements</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">
                Ce que nous <span class="text-red-600">promettons</span>
            </h2>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto">
                Des engagements concrets pour votre tranquillité d'esprit
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @php
                $engagements = [
                    ['icon' => 'shield-alt', 'color' => 'blue', 'title' => 'Sécurité garantie', 'desc' => 'Assurance tous risques sur toutes nos expéditions. Emballage professionnel et manipulation soigneuse de vos marchandises.'],
                    ['icon' => 'clock', 'color' => 'green', 'title' => 'Respect des délais', 'desc' => 'Engagement ferme sur les délais annoncés. Suivi en temps réel et notifications automatiques à chaque étape.'],
                    ['icon' => 'euro-sign', 'color' => 'purple', 'title' => 'Tarifs transparents', 'desc' => 'Pas de frais cachés. Devis détaillé et prix fixes. Options de paiement flexibles adaptées à vos besoins.'],
                    ['icon' => 'headset', 'color' => 'yellow', 'title' => 'Support client 7j/7', 'desc' => 'Équipe dédiée disponible tous les jours. Réponse garantie sous 2h pour toutes vos questions.']
                ];
            @endphp

            @foreach($engagements as $engagement)
                <div class="flex items-start bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 group">
                    <div class="w-12 h-12 bg-{{ $engagement['color'] }}-100 rounded-xl flex items-center justify-center text-{{ $engagement['color'] }}-600 text-xl mr-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-{{ $engagement['icon'] }}"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-slate-900 mb-2">{{ $engagement['title'] }}</h3>
                        <p class="text-slate-600 leading-relaxed">
                            {{ $engagement['desc'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Certifications et partenaires avec carrousel -->
<section class="py-20 bg-gradient-to-br from-slate-900 to-blue-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center bg-white/20 text-blue-200 rounded-full px-4 py-2 mb-4 border border-white/20">
                <i class="fas fa-award mr-2"></i>
                <span class="font-semibold">Reconnaissances</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold mb-4">
                Certifications & <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-red-300">Partenaires</span>
            </h2>
            <p class="text-xl text-blue-200 max-w-2xl mx-auto">
                Les reconnaissances et collaborations qui garantissent notre excellence
            </p>
        </div>
        
        <!-- Certifications Carrousel -->
        <div class="mb-16">
            <h3 class="text-2xl font-semibold text-center mb-8 flex items-center justify-center">
                <i class="fas fa-trophy mr-3 text-yellow-400"></i>
                Nos Certifications
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $certifications = [
                        ['name' => 'ISO 9001:2015', 'desc' => 'Management de la qualité', 'icon' => 'file-certificate', 'color' => 'blue'],
                        ['name' => 'ISO 14001', 'desc' => 'Management environnemental', 'icon' => 'leaf', 'color' => 'green'],
                        ['name' => 'IATA Cargo Agent', 'desc' => 'Transport aérien international', 'icon' => 'shield-alt', 'color' => 'purple']
                    ];
                @endphp

                @foreach($certifications as $certification)
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 hover:border-{{ $certification['color'] }}-400 transition-all duration-300 text-center group">
                        <div class="w-16 h-16 bg-{{ $certification['color'] }}-500 rounded-xl flex items-center justify-center text-white text-2xl mb-4 mx-auto group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-{{ $certification['icon'] }}"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-white mb-2">{{ $certification['name'] }}</h4>
                        <p class="text-blue-200 text-sm">{{ $certification['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Partenaires Carrousel -->
        <div>
            <h3 class="text-2xl font-semibold text-center mb-8 flex items-center justify-center">
                <i class="fas fa-handshake mr-3 text-green-400"></i>
                Nos Partenaires Stratégiques
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $partenaires = [
                        ['name' => 'MSC & CMA CGM', 'desc' => 'Compagnies maritimes mondiales', 'icon' => 'ship', 'color' => 'red'],
                        ['name' => 'Air France Cargo', 'desc' => 'Transport aérien premium', 'icon' => 'plane', 'color' => 'blue'],
                        ['name' => 'Chambre de Commerce', 'desc' => 'Togo & Bénin', 'icon' => 'landmark', 'color' => 'yellow']
                    ];
                @endphp

                @foreach($partenaires as $partenaire)
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 hover:border-{{ $partenaire['color'] }}-400 transition-all duration-300 text-center group">
                        <div class="w-16 h-16 bg-{{ $partenaire['color'] }}-500 rounded-xl flex items-center justify-center text-white text-2xl mb-4 mx-auto group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-{{ $partenaire['icon'] }}"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-white mb-2">{{ $partenaire['name'] }}</h4>
                        <p class="text-blue-200 text-sm">{{ $partenaire['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-gradient-to-r from-blue-600 via-blue-700 to-red-600 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.1\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"1\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6">
            Rejoignez nos clients satisfaits
        </h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto leading-relaxed">
            Faites confiance à NIFA pour tous vos besoins de transport et logistique en Afrique
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('demande.create') }}" 
               class="bg-yellow-400 text-slate-900 px-8 py-4 rounded-xl font-semibold text-lg hover:bg-yellow-300 transition-all transform hover:scale-105 shadow-lg hover:shadow-xl inline-flex items-center justify-center">
                <i class="fas fa-box mr-3"></i> Commencer maintenant
            </a>
            <a href="{{ route('contact') }}" 
               class="bg-transparent border-2 border-white text-white hover:bg-white/10 px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-300 backdrop-blur-sm inline-flex items-center justify-center">
                <i class="fas fa-phone mr-3"></i> Nous contacter
            </a>
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
</style>
@endpush