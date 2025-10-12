@extends('layouts.main')

@section('title', 'À Propos - NIFA Transport & Logistique')
@section('description', 'Découvrez NIFA, leader du transport et de la logistique en Afrique depuis plus de 10 ans. Notre histoire, nos valeurs et notre engagement.')

@section('content')
<!-- Hero Section -->
<section class="hero-bg-about relative overflow-hidden py-20">
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
            À propos de NIFA
        </h1>
        <p class="hero-subtitle text-xl max-w-3xl mx-auto">
            Votre partenaire de confiance pour le transport et la logistique en Afrique depuis plus de 10 ans
        </p>
    </div>
</section>

<!-- Notre histoire -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">
                    Notre Histoire
                </h2>
                <div class="space-y-4 text-gray-600">
                    <p>
                        Fondée en 2014 à Lomé, NIFA (Network International Freight Africa) est née de la vision de faciliter les échanges commerciaux entre l'Afrique et le reste du monde. Nos fondateurs, forts de leur expérience dans le transport international, ont identifié le besoin crucial d'un service de transport fiable et professionnel en Afrique de l'Ouest.
                    </p>
                    <p>
                        Depuis notre création, nous avons accompagné des milliers d'entreprises et de particuliers dans leurs projets d'importation et d'exportation. Notre croissance constante témoigne de la confiance que nous accordent nos clients et de notre engagement à fournir des services de qualité.
                    </p>
                    <p>
                        Aujourd'hui, NIFA est reconnue comme l'un des leaders du transport et de la logistique en Afrique de l'Ouest, avec des bureaux au Togo et au Bénin, et un réseau de partenaires dans plus de 15 pays.
                    </p>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-8">
                <div class="text-center">
                    <div class="text-6xl mb-6">🏢</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">NIFA en chiffres</h3>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-white rounded-lg p-4">
                            <div class="text-2xl font-bold text-blue-600">2014</div>
                            <div class="text-sm text-gray-600">Année de création</div>
                        </div>
                        <div class="bg-white rounded-lg p-4">
                            <div class="text-2xl font-bold text-green-600">15+</div>
                            <div class="text-sm text-gray-600">Pays desservis</div>
                        </div>
                        <div class="bg-white rounded-lg p-4">
                            <div class="text-2xl font-bold text-purple-600">5000+</div>
                            <div class="text-sm text-gray-600">Clients satisfaits</div>
                        </div>
                        <div class="bg-white rounded-lg p-4">
                            <div class="text-2xl font-bold text-yellow-600">50+</div>
                            <div class="text-sm text-gray-600">Employés</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission, Vision, Valeurs -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                Nos Valeurs
            </h2>
            <p class="text-xl text-gray-600">
                Les principes qui guident notre action au quotidien
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Mission -->
            <div class="bg-white rounded-xl p-8 shadow-sm">
                <div class="text-4xl mb-4">🎯</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Notre Mission</h3>
                <p class="text-gray-600">
                    Faciliter les échanges commerciaux en Afrique en offrant des solutions de transport et de logistique fiables, rapides et économiques. Nous nous engageons à connecter l'Afrique au monde entier.
                </p>
            </div>
            
            <!-- Vision -->
            <div class="bg-white rounded-xl p-8 shadow-sm">
                <div class="text-4xl mb-4">🔮</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Notre Vision</h3>
                <p class="text-gray-600">
                    Devenir le leader incontournable du transport et de la logistique en Afrique, reconnu pour son excellence opérationnelle et son innovation technologique.
                </p>
            </div>
            
            <!-- Valeurs -->
            <div class="bg-white rounded-xl p-8 shadow-sm">
                <div class="text-4xl mb-4">⭐</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Nos Valeurs</h3>
                <ul class="text-gray-600 space-y-2">
                    <li>✓ <strong>Fiabilité</strong> - Respect des engagements</li>
                    <li>✓ <strong>Transparence</strong> - Communication claire</li>
                    <li>✓ <strong>Innovation</strong> - Solutions modernes</li>
                    <li>✓ <strong>Excellence</strong> - Qualité de service</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Équipe dirigeante -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                Notre Équipe Dirigeante
            </h2>
            <p class="text-xl text-gray-600">
                Des experts passionnés au service de votre réussite
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- CEO -->
            <div class="text-center">
                <div class="bg-gradient-to-br from-blue-100 to-blue-200 rounded-full w-32 h-32 flex items-center justify-center mx-auto mb-4">
                    <span class="text-4xl">👨‍💼</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Kofi MENSAH</h3>
                <p class="text-blue-600 font-medium mb-2">Directeur Général</p>
                <p class="text-gray-600 text-sm">
                    15 ans d'expérience dans le transport international. Diplômé en logistique internationale.
                </p>
            </div>
            
            <!-- COO -->
            <div class="text-center">
                <div class="bg-gradient-to-br from-green-100 to-green-200 rounded-full w-32 h-32 flex items-center justify-center mx-auto mb-4">
                    <span class="text-4xl">👩‍💼</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Ama KOFFI</h3>
                <p class="text-green-600 font-medium mb-2">Directrice des Opérations</p>
                <p class="text-gray-600 text-sm">
                    Expert en optimisation logistique et gestion des flux. MBA en Supply Chain Management.
                </p>
            </div>
            
            <!-- CTO -->
            <div class="text-center">
                <div class="bg-gradient-to-br from-purple-100 to-purple-200 rounded-full w-32 h-32 flex items-center justify-center mx-auto mb-4">
                    <span class="text-4xl">👨‍💻</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Jean AKAKPO</h3>
                <p class="text-purple-600 font-medium mb-2">Directeur Technique</p>
                <p class="text-gray-600 text-sm">
                    Spécialiste des systèmes de suivi et technologies logistiques. Ingénieur en informatique.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Nos engagements -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                Nos Engagements
            </h2>
            <p class="text-xl text-gray-600">
                Ce que nous promettons à nos clients
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="flex items-start">
                <div class="bg-blue-100 rounded-lg p-3 mr-4">
                    <span class="text-2xl">🔒</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Sécurité garantie</h3>
                    <p class="text-gray-600">
                        Assurance tous risques sur toutes nos expéditions. Emballage professionnel et manipulation soigneuse de vos marchandises.
                    </p>
                </div>
            </div>
            
            <div class="flex items-start">
                <div class="bg-green-100 rounded-lg p-3 mr-4">
                    <span class="text-2xl">⏰</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Respect des délais</h3>
                    <p class="text-gray-600">
                        Engagement ferme sur les délais annoncés. Suivi en temps réel et notifications automatiques à chaque étape.
                    </p>
                </div>
            </div>
            
            <div class="flex items-start">
                <div class="bg-purple-100 rounded-lg p-3 mr-4">
                    <span class="text-2xl">💰</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Tarifs transparents</h3>
                    <p class="text-gray-600">
                        Pas de frais cachés. Devis détaillé et prix fixes. Options de paiement flexibles adaptées à vos besoins.
                    </p>
                </div>
            </div>
            
            <div class="flex items-start">
                <div class="bg-yellow-100 rounded-lg p-3 mr-4">
                    <span class="text-2xl">🎧</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Support client 7j/7</h3>
                    <p class="text-gray-600">
                        Équipe dédiée disponible tous les jours. Réponse garantie sous 2h pour toutes vos questions.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Certifications et partenaires -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                Certifications & Partenaires
            </h2>
            <p class="text-xl text-gray-600">
                Reconnaissances et collaborations qui garantissent notre qualité
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Certifications -->
            <div>
                <h3 class="text-xl font-semibold text-gray-900 mb-6">🏆 Nos Certifications</h3>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="bg-blue-100 rounded-lg p-2 mr-4">
                            <span class="text-lg">📜</span>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">ISO 9001:2015</div>
                            <div class="text-sm text-gray-600">Management de la qualité</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="bg-green-100 rounded-lg p-2 mr-4">
                            <span class="text-lg">🌱</span>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">ISO 14001</div>
                            <div class="text-sm text-gray-600">Management environnemental</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="bg-purple-100 rounded-lg p-2 mr-4">
                            <span class="text-lg">🛡️</span>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">IATA Cargo Agent</div>
                            <div class="text-sm text-gray-600">Transport aérien international</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Partenaires -->
            <div>
                <h3 class="text-xl font-semibold text-gray-900 mb-6">🤝 Nos Partenaires</h3>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="bg-red-100 rounded-lg p-2 mr-4">
                            <span class="text-lg">🚢</span>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">MSC & CMA CGM</div>
                            <div class="text-sm text-gray-600">Compagnies maritimes mondiales</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="bg-blue-100 rounded-lg p-2 mr-4">
                            <span class="text-lg">✈️</span>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Air France Cargo</div>
                            <div class="text-sm text-gray-600">Transport aérien premium</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="bg-yellow-100 rounded-lg p-2 mr-4">
                            <span class="text-lg">🏦</span>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Chambre de Commerce</div>
                            <div class="text-sm text-gray-600">Togo & Bénin</div>
                        </div>
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
            Rejoignez nos clients satisfaits
        </h2>
        <p class="text-xl text-blue-100 mb-8">
            Faites confiance à NIFA pour tous vos besoins de transport et logistique
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('demande.create') }}" 
               class="bg-yellow-400 text-gray-900 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-yellow-300 transition-colors inline-flex items-center justify-center">
                📦 Commencer maintenant
            </a>
            <a href="{{ route('contact') }}" 
               class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-gray-900 transition-colors inline-flex items-center justify-center">
                📞 Nous contacter
            </a>
        </div>
    </div>
</section>
@endsection
