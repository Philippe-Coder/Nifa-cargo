@extends('layouts.main')

@section('title', 'Contact - NIFA Transport & Logistique')
@section('description', 'Contactez NIFA pour vos besoins de transport. Bureaux au Togo et Bénin. Devis gratuit et conseil personnalisé.')

@section('content')
<!-- Hero Section Élégante -->
<section class="relative py-24 overflow-hidden">
    <!-- Image de fond avec overlay -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" 
             alt="Contact NIFA Transport" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-blue-900/60"></div>
    </div>
    
    <!-- Pattern subtil -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"80\" height=\"80\" viewBox=\"0 0 80 80\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.1\"%3E%3Ccircle cx=\"40\" cy=\"40\" r=\"2\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <div class="inline-flex items-center bg-white/20 backdrop-blur-sm text-white rounded-full px-6 py-3 mb-8 border border-white/30">
            <span class="w-2 h-2 bg-white rounded-full mr-3"></span>
            <span class="text-lg font-medium">Contactez notre équipe</span>
        </div>
        
        <h1 class="text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
            Parlons de votre 
            <span class="text-blue-300">projet</span>
        </h1>
        <p class="text-xl text-blue-100 max-w-2xl mx-auto leading-relaxed">
            Notre équipe d'experts logistiques est à votre écoute pour concrétiser vos ambitions de transport
        </p>
    </div>
</section>

<!-- Messages de feedback -->
@if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mx-4 mt-8">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-500 text-lg"></i>
            </div>
            <div class="ml-3">
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mx-4 mt-8">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
            </div>
            <div class="ml-3">
                <p class="text-red-700">{{ session('error') }}</p>
            </div>
        </div>
    </div>
@endif

<!-- Formulaire et Informations -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <!-- Formulaire Élégant -->
            <div class="relative">
                <div class="absolute -top-4 -left-4 w-24 h-24 bg-blue-100 rounded-full opacity-50"></div>
                <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-blue-50 rounded-full opacity-30"></div>
                
                <div class="relative bg-white rounded-2xl p-8 shadow-xl border border-slate-100">
                    <h2 class="text-3xl font-bold text-slate-900 mb-2">
                        Envoyez-nous un message
                    </h2>
                    <p class="text-slate-600 mb-8">
                        Remplissez ce formulaire et nous vous recontacterons sous 2 heures
                    </p>
                    
                    <form action="{{ route('contact.envoyer') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="nom" class="block text-sm font-medium text-slate-700 mb-3">
                                    Nom complet *
                                </label>
                                <input type="text" id="nom" name="nom" required
                                       value="{{ old('nom') }}"
                                       class="w-full border border-slate-200 rounded-xl px-4 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('nom') border-red-500 @enderror"
                                       placeholder="Votre nom complet">
                                @error('nom')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-slate-700 mb-3">
                                    Email *
                                </label>
                                <input type="email" id="email" name="email" required
                                       value="{{ old('email') }}"
                                       class="w-full border border-slate-200 rounded-xl px-4 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 @enderror"
                                       placeholder="votre@email.com">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="telephone" class="block text-sm font-medium text-slate-700 mb-3">
                                Téléphone
                            </label>
                            <input type="tel" id="telephone" name="telephone"
                                   value="{{ old('telephone') }}"
                                   placeholder="+228 99 25 25 31"
                                   class="w-full border border-slate-200 rounded-xl px-4 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('telephone') border-red-500 @enderror">
                            @error('telephone')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="sujet" class="block text-sm font-medium text-slate-700 mb-3">
                                Sujet *
                            </label>
                            <select id="sujet" name="sujet" required
                                    class="w-full border border-slate-200 rounded-xl px-4 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('sujet') border-red-500 @enderror">
                                <option value="">Sélectionnez un sujet</option>
                                <option value="Demande de devis" {{ old('sujet') == 'Demande de devis' ? 'selected' : '' }}>Demande de devis</option>
                                <option value="Transport maritime" {{ old('sujet') == 'Transport maritime' ? 'selected' : '' }}>Transport maritime</option>
                                <option value="Transport aérien" {{ old('sujet') == 'Transport aérien' ? 'selected' : '' }}>Transport aérien</option>
                                <option value="Transport terrestre" {{ old('sujet') == 'Transport terrestre' ? 'selected' : '' }}>Transport terrestre</option>
                                <option value="Dédouanement" {{ old('sujet') == 'Dédouanement' ? 'selected' : '' }}>Dédouanement</option>
                                <option value="Suivi de colis" {{ old('sujet') == 'Suivi de colis' ? 'selected' : '' }}>Suivi de colis</option>
                                <option value="Réclamation" {{ old('sujet') == 'Réclamation' ? 'selected' : '' }}>Réclamation</option>
                                <option value="Partenariat" {{ old('sujet') == 'Partenariat' ? 'selected' : '' }}>Partenariat</option>
                                <option value="Autre" {{ old('sujet') == 'Autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('sujet')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-slate-700 mb-3">
                                Message *
                            </label>
                            <textarea id="message" name="message" rows="6" required
                                      placeholder="Décrivez votre projet ou votre demande en détail..."
                                      class="w-full border border-slate-200 rounded-xl px-4 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" id="newsletter" name="newsletter" value="1"
                                   class="h-5 w-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500 mt-1">
                            <label for="newsletter" class="text-sm text-slate-600 leading-relaxed">
                                Je souhaite recevoir les actualités NIFA et des conseils logistiques par email
                            </label>
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-blue-600 text-white py-4 px-6 rounded-xl font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                            Envoyer mon message
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Informations de Contact Élégantes -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-2">
                        Nos coordonnées
                    </h2>
                    <p class="text-slate-600">
                        Plusieurs moyens pour échanger avec notre équipe
                    </p>
                </div>
                
                <!-- Siège Togo -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 border border-blue-100">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900 mb-2">
                                Siège Social
                            </h3>
                            <div class="flex items-center text-blue-600">
                                <span class="text-lg mr-2">🇹🇬</span>
                                <span class="font-medium">Lomé, Togo</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <span class="text-blue-600 font-bold text-lg">TS</span>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center mr-4 shadow-sm">
                                <span class="text-blue-600 text-sm">📍</span>
                            </div>
                            <div>
                                <p class="text-slate-700 font-medium">Adresse</p>
                                <p class="text-slate-600 text-sm">123 Avenue de la Logistique<br>Quartier Administratif, Lomé</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center mr-4 shadow-sm">
                                <span class="text-blue-600 text-sm">📞</span>
                            </div>
                            <div>
                                <p class="text-slate-700 font-medium">Téléphones</p>
                                <div class="text-slate-600 text-sm">
                                    <a href="tel:+22822610000" class="hover:text-blue-600 transition-colors">+228 22 61 00 00</a><br>
                                    <a href="tel:+22890123456" class="hover:text-blue-600 transition-colors">+228 90 12 34 56</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center mr-4 shadow-sm">
                                <span class="text-blue-600 text-sm">✉️</span>
                            </div>
                            <div>
                                <p class="text-slate-700 font-medium">Email</p>
                                <a href="mailto:contact@nifa.tg" class="text-slate-600 text-sm hover:text-blue-600 transition-colors">
                                    contact@nifa.tg
                                </a>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center mr-4 shadow-sm">
                                <span class="text-blue-600 text-sm">🕒</span>
                            </div>
                            <div>
                                <p class="text-slate-700 font-medium">Horaires</p>
                                <p class="text-slate-600 text-sm">Lun - Ven : 8h00 - 18h00<br>Samedi : 8h00 - 12h00</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Agence Bénin -->
                <div class="bg-gradient-to-br from-red-50 to-orange-50 rounded-2xl p-8 border border-red-100">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900 mb-2">
                                Agence Régionale
                            </h3>
                            <div class="flex items-center text-red-600">
                                <span class="text-lg mr-2">🇧🇯</span>
                                <span class="font-medium">Cotonou, Bénin</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                            <span class="text-red-600 font-bold text-lg">AB</span>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center mr-4 shadow-sm">
                                <span class="text-red-600 text-sm">📍</span>
                            </div>
                            <div>
                                <p class="text-slate-700 font-medium">Adresse</p>
                                <p class="text-slate-600 text-sm">Port de Cotonou<br>Zone Industrielle, Bénin</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center mr-4 shadow-sm">
                                <span class="text-red-600 text-sm">📞</span>
                            </div>
                            <div>
                                <p class="text-slate-700 font-medium">Téléphones</p>
                                <div class="text-slate-600 text-sm">
                                    <a href="tel:+22921123456" class="hover:text-red-600 transition-colors">+229 21 12 34 56</a><br>
                                    <a href="tel:+22996123456" class="hover:text-red-600 transition-colors">+229 96 12 34 56</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center mr-4 shadow-sm">
                                <span class="text-red-600 text-sm">✉️</span>
                            </div>
                            <div>
                                <p class="text-slate-700 font-medium">Email</p>
                                <a href="mailto:benin@nifa.tg" class="text-slate-600 text-sm hover:text-red-600 transition-colors">
                                    benin@nifa.tg
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Urgence -->
                <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-6 border border-orange-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-orange-600 text-lg">🚨</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Assistance Urgence</h3>
                            <p class="text-slate-600 text-sm">Support 24h/7j pour les situations critiques</p>
                        </div>
                    </div>
                    <a href="tel:+22899252531" 
                       class="block text-center bg-orange-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-orange-700 transition-colors">
                       +228 99 25 25 31
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Canaux de Communication -->
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">
                Canaux de communication
            </h2>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto">
                Choisissez le mode d'échange qui vous convient le mieux
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- WhatsApp -->
            <div class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-slate-100">
                <div class="w-20 h-20 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 text-3xl mx-auto mb-6">
                    <span>💬</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-3">Messagerie Instantanée</h3>
                <p class="text-slate-600 mb-6 leading-relaxed">
                    Échangez en temps réel avec nos conseillers pour des réponses rapides
                </p>
                <a href="https://wa.me/22899252531" target="_blank"
                   class="inline-block bg-green-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-green-700 transition-colors shadow-lg hover:shadow-xl">
                    Démarrer la conversation
                </a>
            </div>
            
            <!-- Réseaux Sociaux -->
            <div class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-slate-100">
                <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 text-3xl mx-auto mb-6">
                    <span>🌐</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-3">Réseaux Sociaux</h3>
                <p class="text-slate-600 mb-6 leading-relaxed">
                    Suivez notre actualité et échangez avec notre communauté
                </p>
                <div class="space-y-3">
                    <a href="https://www.tiktok.com/@nifgroupcargo" target="_blank"
                       class="block bg-slate-800 text-white px-6 py-3 rounded-lg font-medium hover:bg-slate-900 transition-colors">
                        TikTok
                    </a>
                    <a href="https://www.facebook.com/Espoir.amewuho55" target="_blank"
                       class="block bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                        Facebook
                    </a>
                </div>
            </div>
            
            <!-- Visite -->
            <div class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-slate-100">
                <div class="w-20 h-20 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 text-3xl mx-auto mb-6">
                    <span>🏢</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-3">Rencontre Physique</h3>
                <p class="text-slate-600 mb-6 leading-relaxed">
                    Planifiez une visite dans nos bureaux pour un conseil personnalisé
                </p>
                <a href="#localisation"
                   class="inline-block bg-purple-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-purple-700 transition-colors shadow-lg hover:shadow-xl">
                    Prendre rendez-vous
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Section Localisation -->
<section id="localisation" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">
                Nous localiser
            </h2>
            <p class="text-xl text-slate-600">
                Accédez facilement à nos implantations
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Carte Simplifiée -->
            <div class="bg-slate-50 rounded-2xl p-8 border border-slate-200">
                <h3 class="text-2xl font-bold text-slate-900 mb-6">Accès et directions</h3>
                
                <div class="space-y-8">
                    <!-- Togo -->
                    <div>
                        <h4 class="text-lg font-semibold text-blue-600 mb-4">Siège Social - Lomé</h4>
                        <div class="space-y-3 text-slate-600">
                            <div class="flex items-start">
                                <span class="text-blue-500 mr-3">📍</span>
                                <span>123 Avenue de la Logistique, Quartier Administratif</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-blue-500 mr-3">🚗</span>
                                <span>Parking visiteurs disponible</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-blue-500 mr-3">🚌</span>
                                <span>Arrêt de bus à 200m</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="https://maps.app.goo.gl/WQNuHkZNAp7N3p7U7" target="_blank"
                               class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                                <span class="mr-2">🗺️</span>
                                Voir sur Google Maps
                            </a>
                        </div>
                    </div>
                    
                    <!-- Bénin -->
                    <div>
                        <h4 class="text-lg font-semibold text-red-600 mb-4">Agence - Cotonou</h4>
                        <div class="space-y-3 text-slate-600">
                            <div class="flex items-start">
                                <span class="text-red-500 mr-3">📍</span>
                                <span>Port de Cotonou, Zone Industrielle</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-red-500 mr-3">🚢</span>
                                <span>Accès direct au port</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-red-500 mr-3">🛣️</span>
                                <span>Proche autoroute Cotonou-Porto Novo</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="https://maps.app.goo.gl/WQNuHkZNAp7N3p7U7" target="_blank"
                               class="inline-flex items-center bg-red-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-red-700 transition-colors">
                                <span class="mr-2">🗺️</span>
                                Voir sur Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Horaires et Infos -->
            <div class="space-y-8">
                <!-- Horaires -->
                <div class="bg-gradient-to-br from-slate-50 to-blue-50 rounded-2xl p-8 border border-slate-200">
                    <h3 class="text-2xl font-bold text-slate-900 mb-6">Horaires d'ouverture</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-slate-200">
                            <span class="text-slate-700 font-medium">Lundi - Vendredi</span>
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">8h00 - 18h00</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-slate-200">
                            <span class="text-slate-700 font-medium">Samedi</span>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">8h00 - 12h00</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-slate-700 font-medium">Dimanche</span>
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">Fermé</span>
                        </div>
                    </div>
                    
                    <div class="mt-6 p-4 bg-amber-50 rounded-xl border border-amber-200">
                        <div class="flex items-center">
                            <span class="text-amber-600 mr-3">⚠️</span>
                            <div>
                                <p class="text-amber-800 font-medium text-sm">Service d'urgence disponible 24h/24</p>
                                <a href="tel:+22899252531" class="text-amber-700 text-sm hover:underline">+228 99 25 25 31</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Rendez-vous -->
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8 border border-purple-100">
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Visite sur rendez-vous</h3>
                    <p class="text-slate-600 mb-6">
                        Pour un conseil personnalisé et une attention optimale, nous recommandons de planifier votre visite.
                    </p>
                    <a href="tel:+22822610000"
                       class="inline-flex items-center bg-purple-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-purple-700 transition-colors shadow-lg hover:shadow-xl">
                        <span class="mr-3">📅</span>
                        Planifier un rendez-vous
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Élégante -->
<section class="py-20 bg-slate-900 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold mb-4">
                Questions courantes
            </h2>
            <p class="text-xl text-slate-300">
                Réponses rapides à vos interrogations
            </p>
        </div>
        
        <div class="space-y-6">
            <div class="bg-slate-800 rounded-2xl p-8 hover:bg-slate-750 transition-colors">
                <h3 class="text-xl font-semibold mb-4 text-blue-300">
                    Quel est le délai de réponse moyen ?
                </h3>
                <p class="text-slate-300 leading-relaxed">
                    Nous nous engageons à répondre à tous les messages dans un délai maximum de 2 heures ouvrables. 
                    Pour les demandes urgentes, notre ligne dédiée assure une réponse immédiate.
                </p>
            </div>
            
            <div class="bg-slate-800 rounded-2xl p-8 hover:bg-slate-750 transition-colors">
                <h3 class="text-xl font-semibold mb-4 text-green-300">
                    Comment obtenir un devis personnalisé ?
                </h3>
                <p class="text-slate-300 leading-relaxed">
                    Utilisez notre formulaire en ligne avec les détails de votre envoi, ou contactez-nous directement. 
                    Vous recevrez un devis détaillé et transparent sous 24 heures.
                </p>
            </div>
            
            <div class="bg-slate-800 rounded-2xl p-8 hover:bg-slate-750 transition-colors">
                <h3 class="text-xl font-semibold mb-4 text-purple-300">
                    Puis-je visiter vos installations ?
                </h3>
                <p class="text-slate-300 leading-relaxed">
                    Absolument. Nos bureaux sont accessibles aux horaires d'ouverture. 
                    Pour une visite guidée de nos installations logistiques, nous recommandons de prendre rendez-vous.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Final -->
<section class="py-20 bg-gradient-to-br from-blue-600 to-blue-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6">
            Prêt à concrétiser votre projet ?
        </h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto leading-relaxed">
            Notre équipe d'experts vous accompagne de la planification à la livraison finale
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('demande.create') }}" 
               class="bg-white text-blue-600 px-8 py-4 rounded-xl font-semibold text-lg hover:bg-blue-50 transition-colors inline-flex items-center justify-center shadow-lg hover:shadow-xl">
                <span class="mr-3">📦</span>
                Démarrer mon projet
            </a>
            <a href="tel:+22822610000" 
               class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-white/10 transition-colors inline-flex items-center justify-center">
                <span class="mr-3">📞</span>
                Nous appeler
            </a>
        </div>
    </div>
</section>
@endsection