@extends('layouts.main')

@section('title', 'Nos Services - NIF CARGO')
@section('description', 'Découvrez nos services de transport maritime, aérien, terrestre, dédouanement, entreposage et assurance en Afrique.')

@php
// Définition des images par service avec vos images personnalisées - AVANT le contenu
$serviceImages = [
    'Transport Maritime' => asset('images/transport-maritime.jpg'),
    'Transport Aérien' => asset('images/transport-aerien.jpg'),
    'Transport Terrestre' => asset('images/transport-terrestre.jpg'),
    'Dédouanement' => asset('images/dedouanement.jpg'),
    'Entreposage' => asset('images/entreposage.jpg'),
    'Assurance' => asset('images/assurance.jpg')
];
@endphp

@section('content')
<!-- Hero Section avec Image -->
<section class="hero-bg-services relative overflow-hidden py-20 lg:py-28">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80" 
             alt="Services de transport et logistique NIF CARGO" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/80 to-slate-900/60"></div>
    </div>

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
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <div class="inline-flex items-center bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-6 border border-white/30">
            <span class="w-2 h-2 bg-red-500 rounded-full mr-2 animate-pulse"></span>
            <span class="text-sm font-medium text-white">Solutions complètes</span>
        </div>

        <h1 class="hero-title text-4xl lg:text-5xl xl:text-6xl font-bold text-white mb-6 leading-tight">
            Nos Services de Transport
        </h1>
        <p class="hero-subtitle text-xl lg:text-2xl text-blue-100 max-w-3xl mx-auto leading-relaxed">
            Solutions complètes de transport et logistique adaptées à tous vos besoins en Afrique et dans le monde
        </p>
    </div>

    <!-- Vague décorative -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" class="w-full h-16 lg:h-20">
            <path fill="#ffffff" fill-opacity="1" d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,74.7C1120,75,1280,53,1360,42.7L1440,32L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</section>

<!-- Services détaillés -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid gap-16">
            @foreach($services as $index => $service)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center {{ $index % 2 == 1 ? 'lg:grid-flow-col-dense' : '' }}">
                    <!-- Contenu -->
                    <div class="{{ $index % 2 == 1 ? 'lg:col-start-2' : '' }}">
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-blue-500 rounded-xl flex items-center justify-center text-white text-2xl mr-4 shadow-lg">
                                {!! $service['icon'] !!}
                            </div>
                            <h2 class="text-3xl font-bold text-gray-900">{{ $service['titre'] }}</h2>
                        </div>
                        
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            {{ $service['description'] }}
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                            @foreach($service['features'] as $feature)
                                <div class="flex items-center">
                                    <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-check text-green-600 text-xs"></i>
                                    </span>
                                    <span class="text-gray-700">{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('demande.create') }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center justify-center shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                                <i class="fas fa-box mr-2"></i> Demander un devis
                            </a>
                            <a href="{{ route('contact') }}" 
                               class="border border-blue-600 text-blue-600 px-6 py-3 rounded-lg font-medium hover:bg-blue-50 transition-colors inline-flex items-center justify-center">
                                <i class="fas fa-phone mr-2"></i> Plus d'infos
                            </a>
                        </div>
                    </div>

                    <!-- Image et Illustration -->
                    <div class="{{ $index % 2 == 1 ? 'lg:col-start-1' : '' }} relative">
                        <!-- Image principale du service -->
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                            <img src="{{ $serviceImages[$service['titre']] ?? asset('images/transport-maritime.jpg') }}" 
                                 alt="{{ $service['titre'] }} - NIF CARGO"
                                 class="w-full h-80 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                            
                            <!-- Badge overlay -->
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur-sm text-gray-900 px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $service['titre'] }}
                                </span>
                            </div>
                        </div>

                        <!-- Stats overlay -->
                        <div class="absolute -bottom-6 left-6 right-6">
                            <div class="bg-white rounded-xl p-6 shadow-2xl border border-gray-100">
                                @if($service['titre'] == 'Transport Maritime')
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div class="text-center p-3 bg-blue-50 rounded-lg">
                                            <div class="font-semibold text-blue-700">Conteneur 20'</div>
                                            <div class="text-gray-600 text-xs">33 m³</div>
                                        </div>
                                        <div class="text-center p-3 bg-blue-50 rounded-lg">
                                            <div class="font-semibold text-blue-700">Conteneur 40'</div>
                                            <div class="text-gray-600 text-xs">67 m³</div>
                                        </div>
                                        <div class="text-center p-3 bg-purple-50 rounded-lg">
                                            <div class="font-semibold text-purple-700">Groupage LCL</div>
                                            <div class="text-gray-600 text-xs">À partir de 1 m³</div>
                                        </div>
                                        <div class="text-center p-3 bg-green-50 rounded-lg">
                                            <div class="font-semibold text-green-700">Délai</div>
                                            <div class="text-gray-600 text-xs">15-25 jours</div>
                                        </div>
                                    </div>
                                @elseif($service['titre'] == 'Transport Aérien')
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div class="text-center p-3 bg-red-50 rounded-lg">
                                            <div class="font-semibold text-red-700">Express</div>
                                            <div class="text-gray-600 text-xs">24-48h</div>
                                        </div>
                                        <div class="text-center p-3 bg-red-50 rounded-lg">
                                            <div class="font-semibold text-red-700">Standard</div>
                                            <div class="text-gray-600 text-xs">3-5 jours</div>
                                        </div>
                                        <div class="text-center p-3 bg-orange-50 rounded-lg">
                                            <div class="font-semibold text-orange-700">Poids max</div>
                                            <div class="text-gray-600 text-xs">500 kg/colis</div>
                                        </div>
                                        <div class="text-center p-3 bg-blue-50 rounded-lg">
                                            <div class="font-semibold text-blue-700">Destinations</div>
                                            <div class="text-gray-600 text-xs">Monde entier</div>
                                        </div>
                                    </div>
                                @elseif($service['titre'] == 'Transport Terrestre')
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div class="text-center p-3 bg-green-50 rounded-lg">
                                            <div class="font-semibold text-green-700">Camion 19T</div>
                                            <div class="text-gray-600 text-xs">90 m³</div>
                                        </div>
                                        <div class="text-center p-3 bg-green-50 rounded-lg">
                                            <div class="font-semibold text-green-700">Semi-remorque</div>
                                            <div class="text-gray-600 text-xs">100 m³</div>
                                        </div>
                                        <div class="text-center p-3 bg-cyan-50 rounded-lg">
                                            <div class="font-semibold text-cyan-700">Réfrigéré</div>
                                            <div class="text-gray-600 text-xs">-18°C à +25°C</div>
                                        </div>
                                        <div class="text-center p-3 bg-emerald-50 rounded-lg">
                                            <div class="font-semibold text-emerald-700">Zone</div>
                                            <div class="text-gray-600 text-xs">Afrique Ouest</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center p-4">
                                        <h3 class="font-semibold text-gray-900 mb-2">Service professionnel</h3>
                                        <p class="text-gray-600 text-sm">
                                            Notre équipe d'experts vous accompagne à chaque étape
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                @if(!$loop->last)
                    <hr class="border-gray-200">
                @endif
            @endforeach
        </div>
    </div>
</section>

<!-- Tarification -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                Tarification Transparente
            </h2>
            <p class="text-xl text-gray-600">
                Nos tarifs sont calculés selon plusieurs critères pour vous offrir le meilleur prix
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Facteur 1 -->
            <div class="bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-2xl mx-auto mb-4">
                    <i class="fas fa-ruler-combined"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Dimensions</h3>
                <p class="text-gray-600 text-sm">
                    Volume et poids de vos marchandises
                </p>
            </div>

            <!-- Facteur 2 -->
            <div class="bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-2xl mx-auto mb-4">
                    <i class="fas fa-globe-africa"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Destination</h3>
                <p class="text-gray-600 text-sm">
                    Distance et accessibilité du lieu de livraison
                </p>
            </div>

            <!-- Facteur 3 -->
            <div class="bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 text-2xl mx-auto mb-4">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Urgence</h3>
                <p class="text-gray-600 text-sm">
                    Délai de livraison souhaité
                </p>
            </div>

            <!-- Facteur 4 -->
            <div class="bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 text-2xl mx-auto mb-4">
                    <i class="fas fa-box"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Nature</h3>
                <p class="text-gray-600 text-sm">
                    Type de marchandises et emballage requis
                </p>
            </div>
        </div>

        <div class="text-center mt-12">
            <p class="text-gray-600 mb-6">
                Obtenez un devis personnalisé gratuit en quelques minutes
            </p>
            <a href="{{ route('demande.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors inline-flex items-center shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-calculator mr-3"></i> Calculer mon devis
            </a>
        </div>
    </div>
</section>

<!-- Zones de couverture -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                Zones de Couverture
            </h2>
            <p class="text-xl text-gray-600">
                Nous desservons l'Afrique et connectons le continent au monde entier
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Afrique de l'Ouest -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-8 hover:shadow-xl transition-all duration-300">
                <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-map-marker-alt text-green-600 mr-3"></i>
                    Afrique de l'Ouest
                </h3>
                <div class="space-y-2 text-sm text-gray-700">
                    <div class="flex items-center p-2 hover:bg-white/50 rounded-lg transition-colors">
                        <span class="text-lg mr-3">🇹🇬</span>
                        <span>Togo - Siège social</span>
                    </div>
                    <div class="flex items-center p-2 hover:bg-white/50 rounded-lg transition-colors">
                        <span class="text-lg mr-3">🇧🇯</span>
                        <span>Bénin - Agence</span>
                    </div>
                    <div class="flex items-center p-2 hover:bg-white/50 rounded-lg transition-colors">
                        <span class="text-lg mr-3">🇬🇭</span>
                        <span>Ghana - Partenaire</span>
                    </div>
                    <div class="flex items-center p-2 hover:bg-white/50 rounded-lg transition-colors">
                        <span class="text-lg mr-3">🇳🇬</span>
                        <span>Nigeria - Partenaire</span>
                    </div>
                    <div class="flex items-center p-2 hover:bg-white/50 rounded-lg transition-colors">
                        <span class="text-lg mr-3">🇨🇮</span>
                        <span>Côte d'Ivoire - Partenaire</span>
                    </div>
                    <div class="flex items-center p-2 hover:bg-white/50 rounded-lg transition-colors">
                        <span class="text-lg mr-3">🇸🇳</span>
                        <span>Sénégal - Partenaire</span>
                    </div>
                </div>
            </div>

            <!-- Afrique Centrale -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-8 hover:shadow-xl transition-all duration-300">
                <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-map-marker-alt text-blue-600 mr-3"></i>
                    Afrique Centrale
                </h3>
                <div class="space-y-2 text-sm text-gray-700">
                    <div class="flex items-center p-2 hover:bg-white/50 rounded-lg transition-colors">
                        <span class="text-lg mr-3">🇨🇲</span>
                        <span>Cameroun - Partenaire</span>
                    </div>
                    <div class="flex items-center p-2 hover:bg-white/50 rounded-lg transition-colors">
                        <span class="text-lg mr-3">🇬🇦</span>
                        <span>Gabon - Partenaire</span>
                    </div>
                    <div class="flex items-center p-2 hover:bg-white/50 rounded-lg transition-colors">
                        <span class="text-lg mr-3">🇨🇬</span>
                        <span>Congo - Partenaire</span>
                    </div>
                    <div class="flex items-center p-2 hover:bg-white/50 rounded-lg transition-colors">
                        <span class="text-lg mr-3">🇨🇩</span>
                        <span>RD Congo - Partenaire</span>
                    </div>
                    <div class="flex items-center p-2 hover:bg-white/50 rounded-lg transition-colors">
                        <span class="text-lg mr-3">🇹🇩</span>
                        <span>Tchad - Partenaire</span>
                    </div>
                    <div class="flex items-center p-2 hover:bg-white/50 rounded-lg transition-colors">
                        <span class="text-lg mr-3">🇨🇫</span>
                        <span>Centrafrique - Partenaire</span>
                    </div>
                </div>
            </div>

            <!-- International -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-8 hover:shadow-xl transition-all duration-300">
                <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-globe text-purple-600 mr-3"></i>
                    International
                </h3>
                <div class="space-y-2 text-sm text-gray-700">
                    <div class="flex items-center p-2 hover:bg-white/50 rounded-lg transition-colors">
                        <span class="text-lg mr-3">🇫🇷</span>
                        <span>France - Bureau</span>
                    </div>
                    <div class="flex items-center p-2 hover:bg-white/50 rounded-lg transition-colors">
                        <span class="text-lg mr-3">🇧🇪</span>
                        <span>Belgique - Partenaire</span>
                    </div>
                    <div class="flex items-center p-2 hover:bg-white/50 rounded-lg transition-colors">
                        <span class="text-lg mr-3">🇩🇪</span>
                        <span>Allemagne - Partenaire</span>
                    </div>
                    <div class="flex items-center p-2 hover:bg-white/50 rounded-lg transition-colors">
                        <span class="text-lg mr-3">🇨🇳</span>
                        <span>Chine - Partenaire</span>
                    </div>
                    <div class="flex items-center p-2 hover:bg-white/50 rounded-lg transition-colors">
                        <span class="text-lg mr-3">🇺🇸</span>
                        <span>États-Unis - Partenaire</span>
                    </div>
                    <div class="flex items-center p-2 hover:bg-white/50 rounded-lg transition-colors">
                        <span class="text-lg mr-3">🇦🇪</span>
                        <span>Émirats - Partenaire</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-20 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                Questions Fréquentes
            </h2>
            <p class="text-xl text-gray-600">
                Trouvez rapidement les réponses à vos questions
            </p>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition-all duration-300">
                <h3 class="text-lg font-semibold text-gray-900 mb-2 flex items-center">
                    <i class="fas fa-question-circle text-blue-600 mr-3"></i>
                    Quels sont les délais de transport ?
                </h3>
                <p class="text-gray-600">
                    Les délais varient selon le mode de transport : 24-48h pour l'aérien express, 3-7 jours pour le terrestre en Afrique de l'Ouest, et 15-25 jours pour le maritime.
                </p>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition-all duration-300">
                <h3 class="text-lg font-semibold text-gray-900 mb-2 flex items-center">
                    <i class="fas fa-question-circle text-blue-600 mr-3"></i>
                    Comment suivre mon colis ?
                </h3>
                <p class="text-gray-600">
                    Vous recevez un numéro de suivi par SMS et email. Utilisez notre outil de suivi en ligne ou connectez-vous à votre espace client pour voir la progression en temps réel.
                </p>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition-all duration-300">
                <h3 class="text-lg font-semibold text-gray-900 mb-2 flex items-center">
                    <i class="fas fa-question-circle text-blue-600 mr-3"></i>
                    Quels documents sont nécessaires ?
                </h3>
                <p class="text-gray-600">
                    Selon la destination : facture commerciale, liste de colisage, certificat d'origine. Notre équipe vous accompagne dans la préparation de tous les documents requis.
                </p>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition-all duration-300">
                <h3 class="text-lg font-semibold text-gray-900 mb-2 flex items-center">
                    <i class="fas fa-question-circle text-blue-600 mr-3"></i>
                    Comment sont calculés les tarifs ?
                </h3>
                <p class="text-gray-600">
                    Nos tarifs dépendent du poids, volume, destination, délai et nature des marchandises. Nous appliquons toujours le tarif le plus avantageux entre poids réel et poids volumétrique.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 gradient-bg hero-pattern">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6">
            Besoin d'un service personnalisé ?
        </h2>
        <p class="text-xl text-blue-100 mb-8">
            Notre équipe d'experts est à votre disposition pour étudier vos besoins spécifiques
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}" 
               class="bg-yellow-400 text-gray-900 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-yellow-300 transition-colors inline-flex items-center justify-center shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-phone mr-3"></i> Contactez nos experts
            </a>
            <a href="{{ route('demande.create') }}" 
               class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-gray-900 transition-colors inline-flex items-center justify-center">
                <i class="fas fa-box mr-3"></i> Faire une demande
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
</style>
@endpush