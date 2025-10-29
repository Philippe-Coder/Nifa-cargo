@extends('layouts.main')

@section('title', __('Contact - NIF CARGO'))
@section('description', __('Contactez NIF CARGO pour vos besoins de transport. Bureaux au Togo et Bénin. Devis gratuit et conseil personnalisé.'))

@section('content')
<!-- Hero Section Élégante Moderne -->
<section class="relative py-28 lg:py-32 overflow-hidden bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900">
    <!-- Background avec pattern moderne -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    <!-- Éléments décoratifs -->
    <div class="absolute top-10 left-10 w-72 h-72 bg-blue-600/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl"></div>
    
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <!-- Badge élégant -->
        <div class="inline-flex items-center bg-white/10 backdrop-blur-md text-white rounded-full px-6 py-3 mb-8 border border-white/20 shadow-lg">
            <span class="w-2 h-2 bg-emerald-400 rounded-full mr-3 animate-pulse"></span>
            <span class="text-lg font-semibold">{{ __('Contactez notre équipe') }}</span>
        </div>
        
        <!-- Titre principal -->
        <h1 class="text-5xl lg:text-7xl font-bold text-white mb-6 leading-tight">
            {{ __('Parlons de votre') }} 
            <span class="bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent">{{ __('projet') }}</span>
        </h1>
        
        <!-- Sous-titre -->
        <p class="text-xl lg:text-2xl text-blue-100 max-w-3xl mx-auto leading-relaxed mb-8">
            {{ __('Notre équipe d\'experts logistiques est à votre écoute pour concrétiser vos ambitions de transport') }}
        </p>
        
        <!-- Indicateurs de performance -->
        <div class="flex flex-wrap justify-center gap-8 mt-12">
            <div class="text-center">
                <div class="text-3xl font-bold text-white mb-2">2h</div>
                <div class="text-blue-200 text-sm">{{ __('Délai de réponse') }}</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-white mb-2">24/7</div>
                <div class="text-blue-200 text-sm">{{ __('Support urgence') }}</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-white mb-2">100%</div>
                <div class="text-blue-200 text-sm">{{ __('Satisfaction client') }}</div>
            </div>
        </div>
    </div>
    
    <!-- Vague de séparation -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="w-full h-16 text-white fill-current">
            <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z"></path>
        </svg>
    </div>
</section>

<!-- Messages de feedback modernisés -->
@if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl p-6 shadow-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="bg-red-50 border-l-4 border-red-500 rounded-r-xl p-6 shadow-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Formulaire et Informations - Version Moderne -->
<section class="py-20 bg-gradient-to-b from-white to-slate-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-20">
            <!-- Formulaire Élégant Moderne -->
            <div class="relative">
                <!-- Éléments décoratifs -->
                <div class="absolute -top-6 -left-6 w-32 h-32 bg-blue-100 rounded-full opacity-40 blur-xl"></div>
                <div class="absolute -bottom-8 -right-8 w-40 h-40 bg-indigo-100 rounded-full opacity-30 blur-xl"></div>
                
                <div class="relative bg-white rounded-3xl p-8 lg:p-10 shadow-2xl border border-slate-100/80 backdrop-blur-sm">
                    <!-- En-tête formulaire -->
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                            <i class="fas fa-paper-plane text-white text-xl"></i>
                        </div>
                        <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-3">
                            {{ __('Envoyez-nous un message') }}
                        </h2>
                        <p class="text-slate-600 text-lg">
                            {{ __('Remplissez ce formulaire et nous vous recontacterons sous 2 heures') }}
                        </p>
                    </div>
                    
                    <form action="{{ route('contact.envoyer') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Grille des champs -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Nom -->
                            <div class="space-y-2">
                                <label for="nom" class="block text-sm font-semibold text-slate-700">
                                    {{ __('Nom complet') }} *
                                </label>
                                <div class="relative">
                                    <input type="text" id="nom" name="nom" required
                                           value="{{ old('nom') }}"
                                           class="w-full border border-slate-200 rounded-xl px-4 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm @error('nom') border-red-500 @enderror"
                                           placeholder="{{ __('Votre nom complet') }}">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <i class="fas fa-user text-slate-400"></i>
                                    </div>
                                </div>
                                @error('nom')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                            
                            <!-- Email -->
                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-semibold text-slate-700">
                                    {{ __('Email') }} *
                                </label>
                                <div class="relative">
                                    <input type="email" id="email" name="email" required
                                           value="{{ old('email') }}"
                                           class="w-full border border-slate-200 rounded-xl px-4 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm @error('email') border-red-500 @enderror"
                                           placeholder="votre@email.com">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <i class="fas fa-envelope text-slate-400"></i>
                                    </div>
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Téléphone -->
                        <div class="space-y-2">
                            <label for="telephone" class="block text-sm font-semibold text-slate-700">
                                {{ __('Téléphone') }}
                            </label>
                            <div class="relative">
                                <input type="tel" id="telephone" name="telephone"
                                       value="{{ old('telephone') }}"
                                       placeholder="+228 99 25 25 31"
                                       class="w-full border border-slate-200 rounded-xl px-4 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm @error('telephone') border-red-500 @enderror">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i class="fas fa-phone text-slate-400"></i>
                                </div>
                            </div>
                            @error('telephone')
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Sujet -->
                        <div class="space-y-2">
                            <label for="sujet" class="block text-sm font-semibold text-slate-700">
                                {{ __('Sujet') }} *
                            </label>
                            <div class="relative">
                                <select id="sujet" name="sujet" required
                                        class="w-full border border-slate-200 rounded-xl px-4 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm appearance-none @error('sujet') border-red-500 @enderror">
                                    <option value="">{{ __('Sélectionnez un sujet') }}</option>
                                    <option value="Demande de devis" {{ old('sujet') == 'Demande de devis' ? 'selected' : '' }}>{{ __('Demande de devis') }}</option>
                                    <option value="Transport maritime" {{ old('sujet') == 'Transport maritime' ? 'selected' : '' }}>{{ __('Transport maritime') }}</option>
                                    <option value="Transport aérien" {{ old('sujet') == 'Transport aérien' ? 'selected' : '' }}>{{ __('Transport aérien') }}</option>
                                    <option value="Transport terrestre" {{ old('sujet') == 'Transport terrestre' ? 'selected' : '' }}>{{ __('Transport terrestre') }}</option>
                                    <option value="Dédouanement" {{ old('sujet') == 'Dédouanement' ? 'selected' : '' }}>{{ __('Dédouanement') }}</option>
                                    <option value="Suivi de colis" {{ old('sujet') == 'Suivi de colis' ? 'selected' : '' }}>{{ __('Suivi de colis') }}</option>
                                    <option value="Réclamation" {{ old('sujet') == 'Réclamation' ? 'selected' : '' }}>{{ __('Réclamation') }}</option>
                                    <option value="Partenariat" {{ old('sujet') == 'Partenariat' ? 'selected' : '' }}>{{ __('Partenariat') }}</option>
                                    <option value="Autre" {{ old('sujet') == 'Autre' ? 'selected' : '' }}>{{ __('Autre') }}</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-chevron-down text-slate-400"></i>
                                </div>
                            </div>
                            @error('sujet')
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Message -->
                        <div class="space-y-2">
                            <label for="message" class="block text-sm font-semibold text-slate-700">
                                {{ __('Message') }} *
                            </label>
                            <textarea id="message" name="message" rows="6" required
                                      placeholder="{{ __('Décrivez votre projet ou votre demande en détail...') }}"
                                      class="w-full border border-slate-200 rounded-xl px-4 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm resize-none @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Newsletter -->
                        <div class="flex items-start space-x-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <input type="checkbox" id="newsletter" name="newsletter" value="1"
                                   class="h-5 w-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500 mt-1">
                            <label for="newsletter" class="text-sm text-slate-600 leading-relaxed">
                                {{ __('Je souhaite recevoir les actualités NIF CARGO et des conseils logistiques par email') }}
                            </label>
                        </div>
                        
                        <!-- Bouton d'envoi -->
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 px-6 rounded-xl font-semibold text-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-xl flex items-center justify-center group">
                            <span>{{ __('Envoyer mon message') }}</span>
                            <i class="fas fa-paper-plane ml-3 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Informations de Contact Modernisées -->
            <div class="space-y-8">
                <!-- En-tête informations -->
                <div class="text-center lg:text-left">
                    <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">
                        {{ __('Nos coordonnées') }}
                    </h2>
                    <p class="text-lg text-slate-600">
                        {{ __('Plusieurs moyens pour échanger avec notre équipe') }}
                    </p>
                </div>
                
                <!-- Siège Togo - Carte moderne -->
                <div class="bg-gradient-to-br from-white to-blue-50 rounded-3xl p-8 border border-blue-100 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900 mb-3">
                                {{ __('Siège Social') }}
                            </h3>
                            <div class="flex items-center text-blue-600 bg-blue-50 px-4 py-2 rounded-full">
                                <span class="text-lg mr-2">🇹🇬</span>
                                <span class="font-semibold">Lomé, Togo</span>
                            </div>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-building text-white text-xl"></i>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Adresse -->
                        <div class="flex items-start group">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4 shadow-sm group-hover:bg-blue-200 transition-colors">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-slate-700 font-semibold">{{ __('Adresse') }}</p>
                                <p class="text-slate-600">123 Avenue de la Logistique<br>Quartier Administratif, Lomé</p>
                            </div>
                        </div>
                        
                        <!-- Téléphones -->
                        <div class="flex items-start group">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4 shadow-sm group-hover:bg-green-200 transition-colors">
                                <i class="fas fa-phone text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-slate-700 font-semibold">{{ __('Téléphones') }}</p>
                                <div class="text-slate-600 space-y-1">
                                    <a href="tel:+22899252531" class="block hover:text-blue-600 transition-colors">+228 99 25 25 31</a>
                                    <a href="tel:+22890123456" class="block hover:text-blue-600 transition-colors">+228 90 12 34 56</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="flex items-start group">
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4 shadow-sm group-hover:bg-purple-200 transition-colors">
                                <i class="fas fa-envelope text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-slate-700 font-semibold">{{ __('Email') }}</p>
                                <a href="mailto:contact@nifgroupecargo.com" class="text-slate-600 hover:text-blue-600 transition-colors">
                                    contact@nifgroupecargo.com
                                </a>
                            </div>
                        </div>
                        
                        <!-- Horaires -->
                        <div class="flex items-start group">
                            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mr-4 shadow-sm group-hover:bg-orange-200 transition-colors">
                                <i class="fas fa-clock text-orange-600"></i>
                            </div>
                            <div>
                                <p class="text-slate-700 font-semibold">{{ __('Horaires') }}</p>
                                <p class="text-slate-600">Lun - Ven : 8h00 - 18h00<br>Samedi : 8h00 - 12h00</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Urgence - Carte moderne -->
                <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-3xl p-6 border border-orange-200 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mr-4 shadow-sm">
                            <i class="fas fa-life-ring text-orange-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">{{ __('Assistance Urgence') }}</h3>
                            <p class="text-slate-600 text-sm">{{ __('Support 24h/7j pour les situations critiques') }}</p>
                        </div>
                    </div>
                    <a href="tel:+22899252531" 
                       class="block text-center bg-gradient-to-r from-orange-600 to-orange-500 text-white py-4 px-6 rounded-xl font-semibold hover:from-orange-700 hover:to-orange-600 transition-all duration-200 transform hover:scale-[1.02] shadow-lg">
                       <i class="fas fa-phone mr-2"></i>+228 99 25 25 31
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Canaux de Communication Modernisés -->
<section class="py-20 bg-slate-50/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-5xl font-bold text-slate-900 mb-6">
                {{ __('Canaux de communication') }}
            </h2>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed">
                {{ __('Choisissez le mode d\'échange qui vous convient le mieux') }}
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-10">
            <!-- WhatsApp -->
            <div class="bg-white rounded-3xl p-8 text-center shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-slate-100 group">
                <div class="w-20 h-20 bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl flex items-center justify-center text-green-600 text-3xl mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-md">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-4">{{ __('Messagerie Instantanée') }}</h3>
                <p class="text-slate-600 mb-6 leading-relaxed">
                    {{ __('Échangez en temps réel avec nos conseillers pour des réponses rapides') }}
                </p>
                <a href="https://wa.me/22899252531" target="_blank"
                   class="inline-flex items-center bg-green-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-green-700 transition-all duration-300 shadow-lg hover:shadow-xl group">
                    <i class="fab fa-whatsapp mr-3"></i>
                    {{ __('Démarrer la conversation') }}
                </a>
            </div>
            
            <!-- Réseaux Sociaux -->
            <div class="bg-white rounded-3xl p-8 text-center shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-slate-100 group">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl flex items-center justify-center text-blue-600 text-3xl mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-md">
                    <i class="fas fa-share-alt"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-4">{{ __('Réseaux Sociaux') }}</h3>
                <p class="text-slate-600 mb-6 leading-relaxed">
                    {{ __('Suivez notre actualité et échangez avec notre communauté') }}
                </p>
                <div class="space-y-3">
                    <a href="https://www.tiktok.com/@nifgroupcargo" target="_blank"
                       class="flex items-center justify-center bg-slate-800 text-white px-6 py-3 rounded-lg font-medium hover:bg-slate-900 transition-colors group">
                        <i class="fab fa-tiktok mr-3"></i>TikTok
                    </a>
                    <a href="https://www.facebook.com/Espoir.amewuho55" target="_blank"
                       class="flex items-center justify-center bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors group">
                        <i class="fab fa-facebook-f mr-3"></i>Facebook
                    </a>
                </div>
            </div>
            
            <!-- Visite -->
            <div class="bg-white rounded-3xl p-8 text-center shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-slate-100 group">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl flex items-center justify-center text-purple-600 text-3xl mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-md">
                    <i class="fas fa-building"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-4">{{ __('Rencontre Physique') }}</h3>
                <p class="text-slate-600 mb-6 leading-relaxed">
                    {{ __('Planifiez une visite dans nos bureaux pour un conseil personnalisé') }}
                </p>
                <a href="#localisation"
                   class="inline-flex items-center bg-purple-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl group">
                    <i class="fas fa-calendar-alt mr-3"></i>
                    {{ __('Prendre rendez-vous') }}
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Section Localisation Modernisée -->
<section id="localisation" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-5xl font-bold text-slate-900 mb-6">
                {{ __('Nous localiser') }}
            </h2>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto">
                {{ __('Accédez facilement à nos implantations') }}
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
            <!-- Carte Simplifiée Moderne -->
            <div class="bg-gradient-to-br from-slate-50 to-blue-50 rounded-3xl p-8 border border-slate-200 shadow-lg">
                <h3 class="text-2xl font-bold text-slate-900 mb-8">{{ __('Accès et directions') }}</h3>
                
                <div class="space-y-8">
                    <!-- Togo -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h4 class="text-xl font-semibold text-blue-600 mb-4 flex items-center">
                            <span class="w-3 h-3 bg-blue-600 rounded-full mr-3"></span>
                            Siège Social - Lomé
                        </h4>
                        <div class="space-y-3 text-slate-600">
                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt text-slate-400 mt-1 mr-3"></i>
                                <span>123 Avenue de la Logistique, Quartier Administratif</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-parking text-slate-400 mr-3"></i>
                                <span>Parking visiteurs disponible</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-bus text-slate-400 mr-3"></i>
                                <span>Arrêt de bus à 200m</span>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="https://maps.app.goo.gl/WQNuHkZNAp7N3p7U7" target="_blank"
                               class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl">
                                <i class="fas fa-map-marked-alt mr-3"></i>
                                {{ __('Voir sur Google Maps') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Horaires et Infos Modernisés -->
            <div class="space-y-8">
                <!-- Horaires -->
                <div class="bg-gradient-to-br from-white to-emerald-50 rounded-3xl p-8 border border-emerald-100 shadow-lg">
                    <h3 class="text-2xl font-bold text-slate-900 mb-8">{{ __('Horaires d\'ouverture') }}</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-4 border-b border-slate-200">
                            <span class="text-slate-700 font-semibold flex items-center">
                                <i class="fas fa-calendar-day text-blue-500 mr-3"></i>
                                Lundi - Vendredi
                            </span>
                            <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold shadow-sm">8h00 - 18h00</span>
                        </div>
                        <div class="flex justify-between items-center py-4 border-b border-slate-200">
                            <span class="text-slate-700 font-semibold flex items-center">
                                <i class="fas fa-calendar-alt text-blue-400 mr-3"></i>
                                Samedi
                            </span>
                            <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-semibold shadow-sm">8h00 - 12h00</span>
                        </div>
                        <div class="flex justify-between items-center py-4">
                            <span class="text-slate-700 font-semibold flex items-center">
                                <i class="fas fa-calendar-times text-red-400 mr-3"></i>
                                Dimanche
                            </span>
                            <span class="bg-red-100 text-red-800 px-4 py-2 rounded-full text-sm font-semibold shadow-sm">Fermé</span>
                        </div>
                    </div>
                    
                    <div class="mt-8 p-4 bg-amber-50 rounded-xl border border-amber-200">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-amber-500 text-xl mr-4"></i>
                            <div>
                                <p class="text-amber-800 font-semibold">{{ __('Service d\'urgence disponible 24h/24') }}</p>
                                <a href="tel:+22899252531" class="text-amber-700 hover:underline font-medium">+228 99 25 25 31</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Rendez-vous -->
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 border border-purple-100 shadow-lg">
                    <h3 class="text-2xl font-bold text-slate-900 mb-6">{{ __('Visite sur rendez-vous') }}</h3>
                    <p class="text-slate-600 mb-8 leading-relaxed">
                        {{ __('Pour un conseil personnalisé et une attention optimale, nous recommandons de planifier votre visite.') }}
                    </p>
                    <a href="tel:+22822610000"
                       class="inline-flex items-center bg-gradient-to-r from-purple-600 to-purple-500 text-white px-8 py-4 rounded-xl font-semibold hover:from-purple-700 hover:to-purple-600 transition-all duration-300 shadow-lg hover:shadow-xl w-full justify-center group">
                        <i class="fas fa-phone-alt mr-3 group-hover:scale-110 transition-transform"></i>
                        {{ __('Planifier un rendez-vous') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Élégante Modernisée -->
<section class="py-20 bg-gradient-to-br from-slate-900 to-blue-900 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-5xl font-bold mb-6">
                {{ __('Questions courantes') }}
            </h2>
            <p class="text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed">
                {{ __('Réponses rapides à vos interrogations') }}
            </p>
        </div>
        
        <div class="space-y-6">
            <!-- Question 1 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 hover:bg-white/15 transition-all duration-300 group">
                <h3 class="text-xl font-semibold mb-4 text-blue-300 group-hover:text-blue-200 transition-colors flex items-center">
                    <i class="fas fa-question-circle mr-3"></i>
                    {{ __('Quel est le délai de réponse moyen ?') }}
                </h3>
                <p class="text-slate-300 leading-relaxed">
                    {{ __('Nous nous engageons à répondre à tous les messages dans un délai maximum de 2 heures ouvrables. Pour les demandes urgentes, notre ligne dédiée assure une réponse immédiate.') }}
                </p>
            </div>
            
            <!-- Question 2 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 hover:bg-white/15 transition-all duration-300 group">
                <h3 class="text-xl font-semibold mb-4 text-emerald-300 group-hover:text-emerald-200 transition-colors flex items-center">
                    <i class="fas fa-file-invoice-dollar mr-3"></i>
                    {{ __('Comment obtenir un devis personnalisé ?') }}
                </h3>
                <p class="text-slate-300 leading-relaxed">
                    {{ __('Utilisez notre formulaire en ligne avec les détails de votre envoi, ou contactez-nous directement. Vous recevrez un devis détaillé et transparent sous 24 heures.') }}
                </p>
            </div>
            
            <!-- Question 3 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 hover:bg-white/15 transition-all duration-300 group">
                <h3 class="text-xl font-semibold mb-4 text-purple-300 group-hover:text-purple-200 transition-colors flex items-center">
                    <i class="fas fa-building mr-3"></i>
                    {{ __('Puis-je visiter vos installations ?') }}
                </h3>
                <p class="text-slate-300 leading-relaxed">
                    {{ __("Absolument. Nos bureaux sont accessibles aux horaires d'ouverture. Pour une visite guidée de nos installations logistiques, nous recommandons de prendre rendez-vous.") }}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Final Modernisé -->
<section class="py-20 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 relative overflow-hidden">
    <!-- Éléments décoratifs -->
    <div class="absolute top-0 left-0 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl"></div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-3xl lg:text-5xl font-bold text-white mb-6">
            {{ __('Prêt à concrétiser votre projet ?') }}
        </h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto leading-relaxed">
            {{ __('Notre équipe d\'experts vous accompagne de la planification à la livraison finale') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('demande.create') }}" 
               class="bg-white text-blue-600 px-8 py-4 rounded-xl font-semibold text-lg hover:bg-blue-50 transition-all duration-300 transform hover:scale-105 shadow-2xl hover:shadow-3xl inline-flex items-center justify-center group">
                <i class="fas fa-rocket mr-3 group-hover:rotate-12 transition-transform"></i>
                {{ __('Démarrer mon projet') }}
            </a>
            <a href="tel:+22822610000" 
               class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-white/10 transition-all duration-300 transform hover:scale-105 inline-flex items-center justify-center group">
                <i class="fas fa-phone-alt mr-3 group-hover:scale-110 transition-transform"></i>
                {{ __('Nous appeler') }}
            </a>
        </div>
    </div>
</section>

<!-- Styles additionnels -->
<style>
/* Animation pour les éléments de formulaire */
.form-group {
    transition: all 0.3s ease;
}

/* Amélioration de l'apparence des sélecteurs */
select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
}

/* Animation pour les cartes au survol */
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* Amélioration de la lisibilité */
@media (max-width: 768px) {
    .text-7xl {
        font-size: 3rem;
    }
    
    .text-5xl {
        font-size: 2.5rem;
    }
}

/* Effet de brillance pour les boutons */
.glow:hover {
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
}
</style>
@endsection