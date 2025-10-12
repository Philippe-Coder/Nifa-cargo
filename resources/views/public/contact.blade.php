@extends('layouts.main')

@section('title', 'Contact - NIFA Transport & Logistique')
@section('description', 'Contactez NIFA pour vos besoins de transport. Bureaux au Togo et Bénin. Devis gratuit et conseil personnalisé.')

@section('content')
<!-- Hero Section -->
<section class="hero-bg-contact relative overflow-hidden py-20">
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
            Contactez-nous
        </h1>
        <p class="hero-subtitle text-xl max-w-3xl mx-auto">
            Notre équipe d'experts est à votre disposition pour répondre à toutes vos questions et vous accompagner dans vos projets de transport
        </p>
    </div>
</section>

<!-- Messages de feedback -->
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mx-4 mt-4" role="alert">
        <div class="flex">
            <span class="text-xl mr-3">✅</span>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mx-4 mt-4" role="alert">
        <div class="flex">
            <span class="text-xl mr-3">❌</span>
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif

<!-- Formulaire de contact et informations -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <!-- Formulaire de contact -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-8">
                    📝 Envoyez-nous un message
                </h2>
                
                <form action="{{ route('contact.envoyer') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom complet *
                            </label>
                            <input type="text" id="nom" name="nom" required
                                   value="{{ old('nom') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nom') border-red-500 @enderror">
                            @error('nom')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email *
                            </label>
                            <input type="email" id="email" name="email" required
                                   value="{{ old('email') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">
                            Téléphone
                        </label>
                        <input type="tel" id="telephone" name="telephone"
                               value="{{ old('telephone') }}"
                               placeholder="+228 90 12 34 56"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('telephone') border-red-500 @enderror">
                        @error('telephone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="sujet" class="block text-sm font-medium text-gray-700 mb-2">
                            Sujet *
                        </label>
                        <select id="sujet" name="sujet" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sujet') border-red-500 @enderror">
                            <option value="">Sélectionnez un sujet</option>
                            <option value="Demande de devis" {{ old('sujet') == 'Demande de devis' ? 'selected' : '' }}>📦 Demande de devis</option>
                            <option value="Transport maritime" {{ old('sujet') == 'Transport maritime' ? 'selected' : '' }}>🚢 Transport maritime</option>
                            <option value="Transport aérien" {{ old('sujet') == 'Transport aérien' ? 'selected' : '' }}>✈️ Transport aérien</option>
                            <option value="Transport terrestre" {{ old('sujet') == 'Transport terrestre' ? 'selected' : '' }}>🚛 Transport terrestre</option>
                            <option value="Dédouanement" {{ old('sujet') == 'Dédouanement' ? 'selected' : '' }}>📋 Dédouanement</option>
                            <option value="Suivi de colis" {{ old('sujet') == 'Suivi de colis' ? 'selected' : '' }}>📦 Suivi de colis</option>
                            <option value="Réclamation" {{ old('sujet') == 'Réclamation' ? 'selected' : '' }}>⚠️ Réclamation</option>
                            <option value="Partenariat" {{ old('sujet') == 'Partenariat' ? 'selected' : '' }}>🤝 Partenariat</option>
                            <option value="Autre" {{ old('sujet') == 'Autre' ? 'selected' : '' }}>💬 Autre</option>
                        </select>
                        @error('sujet')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Message *
                        </label>
                        <textarea id="message" name="message" rows="6" required
                                  placeholder="Décrivez votre demande en détail..."
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="newsletter" name="newsletter" value="1"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="newsletter" class="ml-2 block text-sm text-gray-700">
                            Je souhaite recevoir la newsletter NIFA avec les actualités du transport
                        </label>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-4 px-6 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        📤 Envoyer le message
                    </button>
                </form>
            </div>
            
            <!-- Informations de contact -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-8">
                    📞 Nos coordonnées
                </h2>
                
                <div class="space-y-8">
                    @foreach($contacts as $contact)
                        <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <span class="text-2xl mr-3">🏢</span>
                                <h3 class="text-xl font-semibold text-gray-900">
                                    {{ $contact['pays'] }} - {{ $contact['ville'] }}
                                </h3>
                            </div>
                            
                            <div class="space-y-3 text-gray-700">
                                <div class="flex items-start">
                                    <span class="text-lg mr-3">📍</span>
                                    <span>{{ $contact['adresse'] }}</span>
                                </div>
                                
                                <div class="flex items-center">
                                    <span class="text-lg mr-3">📞</span>
                                    <a href="tel:{{ $contact['telephone'] }}" class="hover:text-blue-600">
                                        {{ $contact['telephone'] }}
                                    </a>
                                </div>
                                
                                <div class="flex items-center">
                                    <span class="text-lg mr-3">📱</span>
                                    <a href="tel:{{ $contact['mobile'] }}" class="hover:text-blue-600">
                                        {{ $contact['mobile'] }}
                                    </a>
                                </div>
                                
                                <div class="flex items-center">
                                    <span class="text-lg mr-3">✉️</span>
                                    <a href="mailto:{{ $contact['email'] }}" class="hover:text-blue-600">
                                        {{ $contact['email'] }}
                                    </a>
                                </div>
                                
                                <div class="flex items-start">
                                    <span class="text-lg mr-3">🕒</span>
                                    <span>{{ $contact['horaires'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Contact d'urgence -->
                <div class="mt-8 bg-red-50 border border-red-200 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-red-900 mb-4">
                        🚨 Contact d'urgence
                    </h3>
                    <p class="text-red-700 text-sm mb-3">
                        Pour les urgences en dehors des heures d'ouverture
                    </p>
                    <div class="flex items-center">
                        <span class="text-lg mr-3">📱</span>
                        <a href="tel:+22890000000" class="text-red-600 font-medium hover:underline">
                            +228 90 00 00 00
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Autres moyens de contact -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                Autres moyens de nous contacter
            </h2>
            <p class="text-xl text-gray-600">
                Choisissez le canal qui vous convient le mieux
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- WhatsApp -->
            <div class="bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-md transition-shadow">
                <div class="text-4xl mb-4">💬</div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">WhatsApp</h3>
                <p class="text-gray-600 text-sm mb-4">
                    Chat direct avec nos conseillers
                </p>
                <a href="https://wa.me/22890123456" target="_blank"
                   class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                    Ouvrir WhatsApp
                </a>
            </div>
            
            <!-- Telegram -->
            <div class="bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-md transition-shadow">
                <div class="text-4xl mb-4">📱</div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Telegram</h3>
                <p class="text-gray-600 text-sm mb-4">
                    Support technique rapide
                </p>
                <a href="https://t.me/nifasupport" target="_blank"
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                    Ouvrir Telegram
                </a>
            </div>
            
            <!-- Facebook -->
            <div class="bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-md transition-shadow">
                <div class="text-4xl mb-4">📘</div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Facebook</h3>
                <p class="text-gray-600 text-sm mb-4">
                    Suivez nos actualités
                </p>
                <a href="https://facebook.com/nifatransport" target="_blank"
                   class="bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-900 transition-colors">
                    Voir la page
                </a>
            </div>
            
            <!-- LinkedIn -->
            <div class="bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-md transition-shadow">
                <div class="text-4xl mb-4">💼</div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">LinkedIn</h3>
                <p class="text-gray-600 text-sm mb-4">
                    Réseau professionnel
                </p>
                <a href="https://linkedin.com/company/nifa" target="_blank"
                   class="bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-800 transition-colors">
                    Nous suivre
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Section Carte Interactive -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                🗺️ Nos Localisations
            </h2>
            <p class="text-xl text-gray-600">
                Trouvez-nous facilement grâce à notre carte interactive
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Carte interactive -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 bg-gradient-to-r from-blue-600 to-red-600 text-white">
                    <h3 class="text-xl font-semibold mb-2">
                        <i class="fas fa-map-marker-alt mr-2"></i> Carte Interactive
                    </h3>
                    <p class="text-blue-100">Cliquez sur les marqueurs pour plus d'informations</p>
                </div>
                
                <!-- Carte Google Maps -->
                <div id="map" class="h-96 w-full"></div>
                
                <!-- Boutons de navigation -->
                <div class="p-4 bg-gray-50 flex flex-wrap gap-2">
                    <button onclick="focusLocation('togo')" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        🇹🇬 Siège Togo
                    </button>
                    <button onclick="focusLocation('benin')" 
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        🇧🇯 Agence Bénin
                    </button>
                    <button onclick="focusLocation('all')" 
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        🌍 Vue d'ensemble
                    </button>
                </div>
            </div>
            
            <!-- Informations de transport -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">
                        🚗 Comment nous rejoindre ?
                    </h3>
                    
                    <!-- Togo -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-blue-600 mb-3 flex items-center">
                            🇹🇬 Siège Social - Lomé, Togo
                        </h4>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt text-blue-500 mr-2 mt-1"></i>
                                <span>123 Avenue de la Logistique, Quartier Administratif, Lomé</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-car text-blue-500 mr-2"></i>
                                <span>Parking gratuit disponible</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-bus text-blue-500 mr-2"></i>
                                <span>Arrêt de bus : "Ministères" (ligne 12, 15)</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-taxi text-blue-500 mr-2"></i>
                                <span>Taxi/Uber : "NIFA Transport, Avenue de la Logistique"</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bénin -->
                    <div>
                        <h4 class="font-semibold text-red-600 mb-3 flex items-center">
                            🇧🇯 Agence - Cotonou, Bénin
                        </h4>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt text-red-500 mr-2 mt-1"></i>
                                <span>Port de Cotonou, Zone Industrielle, Bénin</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-car text-red-500 mr-2"></i>
                                <span>Accès direct depuis l'autoroute</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-ship text-red-500 mr-2"></i>
                                <span>Proximité immédiate du port</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Horaires d'ouverture -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">
                        🕰️ Horaires d'ouverture
                    </h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Lundi - Vendredi</span>
                            <span class="font-medium text-green-600">8h00 - 18h00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Samedi</span>
                            <span class="font-medium text-blue-600">8h00 - 12h00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dimanche</span>
                            <span class="font-medium text-red-600">Fermé</span>
                        </div>
                        <div class="border-t pt-2 mt-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Urgences 24h/7j</span>
                                <a href="tel:+22890000000" class="font-medium text-red-600 hover:underline">
                                    +228 90 00 00 00
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Directions rapides -->
                <div class="bg-gradient-to-r from-blue-600 to-red-600 rounded-2xl p-6 text-white">
                    <h3 class="text-lg font-semibold mb-4">
                        🧭 Itinéraires rapides
                    </h3>
                    <div class="space-y-3">
                        <a href="https://maps.google.com/directions/?api=1&destination=6.1319,1.2228" 
                           target="_blank" 
                           class="block bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg p-3 transition-colors">
                            <div class="flex items-center">
                                <i class="fab fa-google text-xl mr-3"></i>
                                <span>Google Maps - Siège Togo</span>
                            </div>
                        </a>
                        <a href="https://waze.com/ul?ll=6.1319,1.2228" 
                           target="_blank" 
                           class="block bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg p-3 transition-colors">
                            <div class="flex items-center">
                                <i class="fab fa-waze text-xl mr-3"></i>
                                <span>Waze - Navigation GPS</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Contact -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                Questions sur le contact
            </h2>
        </div>
        
        <div class="space-y-6">
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    Dans quel délai recevrai-je une réponse ?
                </h3>
                <p class="text-gray-600">
                    Nous nous engageons à répondre à tous les messages dans un délai de 2 heures ouvrables maximum. Pour les demandes urgentes, contactez-nous directement par téléphone.
                </p>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    Comment obtenir un devis rapidement ?
                </h3>
                <p class="text-gray-600">
                    Utilisez notre formulaire de demande en ligne ou contactez-nous avec les détails de votre envoi (origine, destination, poids, dimensions). Vous recevrez un devis détaillé sous 24h.
                </p>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    Puis-je visiter vos bureaux ?
                </h3>
                <p class="text-gray-600">
                    Bien sûr ! Nos bureaux sont ouverts du lundi au vendredi de 8h à 18h et le samedi de 8h à 12h. Nous recommandons de prendre rendez-vous pour un conseil personnalisé.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 gradient-bg hero-pattern">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6">
            Prêt à expédier ?
        </h2>
        <p class="text-xl text-blue-100 mb-8">
            Commencez dès maintenant votre demande de transport
        </p>
        <a href="{{ route('demande.create') }}" 
           class="bg-yellow-400 text-gray-900 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-yellow-300 transition-colors inline-flex items-center">
            📦 Faire une demande maintenant
        </a>
    </div>
</section>
@endsection

@push('scripts')
<!-- Google Maps API -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>

<script>
let map;
let markers = [];

// Coordonnées des bureaux NIFA
const locations = {
    togo: {
        lat: 6.1319,
        lng: 1.2228,
        title: "NIFA Siège Social - Lomé, Togo",
        info: `
            <div class="p-4 max-w-sm">
                <h3 class="font-bold text-lg text-blue-600 mb-2">🇹🇬 Siège Social NIFA</h3>
                <p class="text-sm text-gray-600 mb-2">123 Avenue de la Logistique<br>Quartier Administratif, Lomé</p>
                <div class="space-y-1 text-xs text-gray-500">
                    <div>📞 +228 22 61 00 00</div>
                    <div>📱 +228 90 12 34 56</div>
                    <div>✉️ contact@nifa.tg</div>
                    <div>🕒 Lun-Ven: 8h-18h, Sam: 8h-12h</div>
                </div>
                <div class="mt-3">
                    <a href="https://maps.google.com/directions/?api=1&destination=6.1319,1.2228" 
                       target="_blank" 
                       class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                        📍 Itinéraire
                    </a>
                </div>
            </div>
        `
    },
    benin: {
        lat: 6.3703,
        lng: 2.3912,
        title: "NIFA Agence - Cotonou, Bénin",
        info: `
            <div class="p-4 max-w-sm">
                <h3 class="font-bold text-lg text-red-600 mb-2">🇧🇯 Agence NIFA</h3>
                <p class="text-sm text-gray-600 mb-2">Port de Cotonou<br>Zone Industrielle, Bénin</p>
                <div class="space-y-1 text-xs text-gray-500">
                    <div>📞 +229 21 12 34 56</div>
                    <div>📱 +229 96 12 34 56</div>
                    <div>✉️ benin@nifa.tg</div>
                    <div>🕒 Lun-Ven: 8h-18h, Sam: 8h-12h</div>
                </div>
                <div class="mt-3">
                    <a href="https://maps.google.com/directions/?api=1&destination=6.3703,2.3912" 
                       target="_blank" 
                       class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700">
                        📍 Itinéraire
                    </a>
                </div>
            </div>
        `
    }
};

function initMap() {
    // Centre de la carte (entre Togo et Bénin)
    const center = { lat: 6.25, lng: 1.8 };
    
    // Initialiser la carte
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 8,
        center: center,
        styles: [
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [{"color": "#e9e9e9"}, {"lightness": 17}]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [{"color": "#f5f5f5"}, {"lightness": 20}]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [{"color": "#ffffff"}, {"lightness": 17}]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [{"color": "#ffffff"}, {"lightness": 29}, {"weight": 0.2}]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry",
                "stylers": [{"color": "#ffffff"}, {"lightness": 18}]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry",
                "stylers": [{"color": "#ffffff"}, {"lightness": 16}]
            },
            {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [{"color": "#f5f5f5"}, {"lightness": 21}]
            }
        ]
    });
    
    // Créer les marqueurs
    Object.keys(locations).forEach(key => {
        const location = locations[key];
        const marker = new google.maps.Marker({
            position: { lat: location.lat, lng: location.lng },
            map: map,
            title: location.title,
            icon: {
                url: key === 'togo' ? 
                    'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                        <svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="18" fill="#2563eb" stroke="#ffffff" stroke-width="2"/>
                            <text x="20" y="26" text-anchor="middle" fill="white" font-size="16" font-weight="bold">N</text>
                        </svg>
                    `) :
                    'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                        <svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="18" fill="#dc2626" stroke="#ffffff" stroke-width="2"/>
                            <text x="20" y="26" text-anchor="middle" fill="white" font-size="16" font-weight="bold">N</text>
                        </svg>
                    `),
                scaledSize: new google.maps.Size(40, 40)
            }
        });
        
        const infoWindow = new google.maps.InfoWindow({
            content: location.info
        });
        
        marker.addListener('click', () => {
            // Fermer toutes les autres info windows
            markers.forEach(m => m.infoWindow.close());
            infoWindow.open(map, marker);
        });
        
        markers.push({ marker, infoWindow });
    });
}

// Fonctions de navigation
function focusLocation(location) {
    if (location === 'all') {
        // Vue d'ensemble
        const bounds = new google.maps.LatLngBounds();
        Object.values(locations).forEach(loc => {
            bounds.extend(new google.maps.LatLng(loc.lat, loc.lng));
        });
        map.fitBounds(bounds);
        map.setZoom(Math.min(map.getZoom(), 8));
    } else if (locations[location]) {
        // Focus sur une location spécifique
        const loc = locations[location];
        map.setCenter({ lat: loc.lat, lng: loc.lng });
        map.setZoom(15);
        
        // Ouvrir l'info window correspondante
        const markerIndex = Object.keys(locations).indexOf(location);
        if (markers[markerIndex]) {
            markers.forEach(m => m.infoWindow.close());
            markers[markerIndex].infoWindow.open(map, markers[markerIndex].marker);
        }
    }
}

// Fallback si Google Maps ne charge pas
window.addEventListener('load', function() {
    setTimeout(function() {
        if (typeof google === 'undefined') {
            document.getElementById('map').innerHTML = `
                <div class="flex items-center justify-center h-full bg-gray-100">
                    <div class="text-center p-8">
                        <div class="text-4xl mb-4">🗺️</div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Carte non disponible</h3>
                        <p class="text-gray-600 text-sm mb-4">
                            La carte interactive n'a pas pu se charger. Utilisez les liens ci-dessous pour nous localiser.
                        </p>
                        <div class="space-y-2">
                            <a href="https://maps.google.com/?q=6.1319,1.2228" target="_blank" 
                               class="block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                📍 Siège Togo sur Google Maps
                            </a>
                            <a href="https://maps.google.com/?q=6.3703,2.3912" target="_blank" 
                               class="block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                📍 Agence Bénin sur Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            `;
        }
    }, 5000);
});
</script>
@endpush
