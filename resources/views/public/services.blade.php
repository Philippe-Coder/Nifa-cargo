@extends('layouts.main')

@section('title', 'Nos Services - NIFA Transport & Logistique')
@section('description', 'Découvrez nos services de transport maritime, aérien, terrestre, dédouanement, entreposage et assurance en Afrique.')

@section('content')
<!-- Hero Section -->
<section class="hero-bg-services relative overflow-hidden py-20">
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
        <h1 class="hero-title text-4xl lg:text-5xl font-bold mb-6">
            Nos Services de Transport
        </h1>
        <p class="hero-subtitle text-xl max-w-3xl mx-auto">
            Solutions complètes de transport et logistique adaptées à tous vos besoins en Afrique et dans le monde
        </p>
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
                            <div class="text-5xl mr-4">{{ $service['icon'] }}</div>
                            <h2 class="text-3xl font-bold text-gray-900">{{ $service['titre'] }}</h2>
                        </div>
                        
                        <p class="text-lg text-gray-600 mb-8">
                            {{ $service['description'] }}
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                            @foreach($service['features'] as $feature)
                                <div class="flex items-center">
                                    <span class="text-green-500 mr-3">✓</span>
                                    <span class="text-gray-700">{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('demande.create') }}" 
                               class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors inline-flex items-center justify-center">
                                📦 Demander un devis
                            </a>
                            <a href="{{ route('contact') }}" 
                               class="border border-blue-600 text-blue-600 px-6 py-3 rounded-lg font-medium hover:bg-blue-50 transition-colors inline-flex items-center justify-center">
                                📞 Plus d'infos
                            </a>
                        </div>
                    </div>

                    <!-- Illustration -->
                    <div class="{{ $index % 2 == 1 ? 'lg:col-start-1' : '' }}">
                        <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-8 text-center">
                            <div class="text-8xl mb-6">{{ $service['icon'] }}</div>
                            
                            @if($service['titre'] == 'Transport Maritime')
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div class="bg-white rounded-lg p-4">
                                        <div class="font-semibold text-blue-600">Conteneur 20'</div>
                                        <div class="text-gray-600">33 m³</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-4">
                                        <div class="font-semibold text-blue-600">Conteneur 40'</div>
                                        <div class="text-gray-600">67 m³</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-4">
                                        <div class="font-semibold text-blue-600">Groupage LCL</div>
                                        <div class="text-gray-600">À partir de 1 m³</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-4">
                                        <div class="font-semibold text-blue-600">Délai</div>
                                        <div class="text-gray-600">15-25 jours</div>
                                    </div>
                                </div>
                            @elseif($service['titre'] == 'Transport Aérien')
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div class="bg-white rounded-lg p-4">
                                        <div class="font-semibold text-purple-600">Express</div>
                                        <div class="text-gray-600">24-48h</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-4">
                                        <div class="font-semibold text-purple-600">Standard</div>
                                        <div class="text-gray-600">3-5 jours</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-4">
                                        <div class="font-semibold text-purple-600">Poids max</div>
                                        <div class="text-gray-600">500 kg/colis</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-4">
                                        <div class="font-semibold text-purple-600">Destinations</div>
                                        <div class="text-gray-600">Monde entier</div>
                                    </div>
                                </div>
                            @elseif($service['titre'] == 'Transport Terrestre')
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div class="bg-white rounded-lg p-4">
                                        <div class="font-semibold text-green-600">Camion 19T</div>
                                        <div class="text-gray-600">90 m³</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-4">
                                        <div class="font-semibold text-green-600">Semi-remorque</div>
                                        <div class="text-gray-600">100 m³</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-4">
                                        <div class="font-semibold text-green-600">Réfrigéré</div>
                                        <div class="text-gray-600">-18°C à +25°C</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-4">
                                        <div class="font-semibold text-green-600">Zone</div>
                                        <div class="text-gray-600">Afrique Ouest</div>
                                    </div>
                                </div>
                            @else
                                <div class="bg-white rounded-lg p-6">
                                    <h3 class="font-semibold text-gray-900 mb-4">Service professionnel</h3>
                                    <p class="text-gray-600 text-sm">
                                        Notre équipe d'experts vous accompagne à chaque étape pour garantir la réussite de vos opérations.
                                    </p>
                                </div>
                            @endif
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
            <div class="bg-white rounded-xl p-6 text-center shadow-sm">
                <div class="text-4xl mb-4">📏</div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Dimensions</h3>
                <p class="text-gray-600 text-sm">
                    Volume et poids de vos marchandises
                </p>
            </div>

            <!-- Facteur 2 -->
            <div class="bg-white rounded-xl p-6 text-center shadow-sm">
                <div class="text-4xl mb-4">🌍</div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Destination</h3>
                <p class="text-gray-600 text-sm">
                    Distance et accessibilité du lieu de livraison
                </p>
            </div>

            <!-- Facteur 3 -->
            <div class="bg-white rounded-xl p-6 text-center shadow-sm">
                <div class="text-4xl mb-4">⚡</div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Urgence</h3>
                <p class="text-gray-600 text-sm">
                    Délai de livraison souhaité
                </p>
            </div>

            <!-- Facteur 4 -->
            <div class="bg-white rounded-xl p-6 text-center shadow-sm">
                <div class="text-4xl mb-4">📦</div>
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
               class="bg-blue-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-blue-700 transition-colors inline-flex items-center">
                💰 Calculer mon devis
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
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">🌍 Afrique de l'Ouest</h3>
                <div class="space-y-2 text-sm text-gray-700">
                    <div>🇹🇬 Togo - Siège social</div>
                    <div>🇧🇯 Bénin - Agence</div>
                    <div>🇬🇭 Ghana - Partenaire</div>
                    <div>🇳🇬 Nigeria - Partenaire</div>
                    <div>🇨🇮 Côte d'Ivoire - Partenaire</div>
                    <div>🇸🇳 Sénégal - Partenaire</div>
                    <div>🇲🇱 Mali - Partenaire</div>
                    <div>🇧🇫 Burkina Faso - Partenaire</div>
                </div>
            </div>

            <!-- Afrique Centrale -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">🌍 Afrique Centrale</h3>
                <div class="space-y-2 text-sm text-gray-700">
                    <div>🇨🇲 Cameroun - Partenaire</div>
                    <div>🇬🇦 Gabon - Partenaire</div>
                    <div>🇨🇬 Congo - Partenaire</div>
                    <div>🇨🇩 RD Congo - Partenaire</div>
                    <div>🇹🇩 Tchad - Partenaire</div>
                    <div>🇨🇫 Centrafrique - Partenaire</div>
                </div>
            </div>

            <!-- International -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">🌍 International</h3>
                <div class="space-y-2 text-sm text-gray-700">
                    <div>🇫🇷 France - Bureau</div>
                    <div>🇧🇪 Belgique - Partenaire</div>
                    <div>🇩🇪 Allemagne - Partenaire</div>
                    <div>🇨🇳 Chine - Partenaire</div>
                    <div>🇺🇸 États-Unis - Partenaire</div>
                    <div>🇦🇪 Émirats - Partenaire</div>
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
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    Quels sont les délais de transport ?
                </h3>
                <p class="text-gray-600">
                    Les délais varient selon le mode de transport : 24-48h pour l'aérien express, 3-7 jours pour le terrestre en Afrique de l'Ouest, et 15-25 jours pour le maritime.
                </p>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    Comment suivre mon colis ?
                </h3>
                <p class="text-gray-600">
                    Vous recevez un numéro de suivi par SMS et email. Utilisez notre outil de suivi en ligne ou connectez-vous à votre espace client pour voir la progression en temps réel.
                </p>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    Quels documents sont nécessaires ?
                </h3>
                <p class="text-gray-600">
                    Selon la destination : facture commerciale, liste de colisage, certificat d'origine. Notre équipe vous accompagne dans la préparation de tous les documents requis.
                </p>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
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
               class="bg-yellow-400 text-gray-900 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-yellow-300 transition-colors inline-flex items-center justify-center">
                📞 Contactez nos experts
            </a>
            <a href="{{ route('demande.create') }}" 
               class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-gray-900 transition-colors inline-flex items-center justify-center">
                📦 Faire une demande
            </a>
        </div>
    </div>
</section>
@endsection
