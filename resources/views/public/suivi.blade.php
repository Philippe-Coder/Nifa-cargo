@extends('layouts.main')

@section('title', 'Suivi de Colis - NIF CARGO')

@section('content')
<!-- Hero Section -->
<section class="hero-bg-tracking relative overflow-hidden py-20">
    <div class="hero-overlay"></div>
    <div class="relative z-10 text-center text-white py-12">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in">
                📦 Suivez votre colis
            </h1>
            <p class="text-xl md:text-2xl opacity-90 animate-slide-up">
                Entrez votre numéro de référence pour connaître la position exacte de votre envoi en temps réel
            </p>
        </div>
    </div>
</div>
@endsection

@section('content')

<!-- Messages de feedback -->
@if(session('error'))
    <div class="max-w-4xl mx-auto px-4 mb-8">
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <i class="fas fa-exclamation-circle text-red-400 mt-1 mr-3"></i>
                <div>
                    <h3 class="text-sm font-medium text-red-800">Erreur</h3>
                    <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Formulaire de recherche -->
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-red-600 px-8 py-6">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-search mr-3"></i>
                Rechercher votre envoi
            </h2>
        </div>

        <div class="p-8">
            <div class="text-center mb-8">
                <div class="text-6xl mb-4">🔍</div>
                <p class="text-gray-600 text-lg">
                    Saisissez votre numéro de référence pour suivre votre colis en temps réel
                </p>
            </div>
            
            <form action="{{ route('suivi.rechercher') }}" method="POST" class="max-w-2xl mx-auto">
                @csrf
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" 
                               name="reference" 
                               placeholder="Ex: NIFCARGO-2025-001" 
                               required
                               value="{{ old('reference') }}"
                               class="w-full px-6 py-4 text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('reference') border-red-500 @enderror">
                        @error('reference')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" 
                            class="bg-gradient-to-r from-blue-600 to-red-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:from-blue-700 hover:to-red-700 transition-all transform hover:scale-105 shadow-lg whitespace-nowrap">
                        <i class="fas fa-search mr-2"></i>
                        Rechercher
                    </button>
                </div>
            </form>
            
            <div class="text-center mt-6">
                <p class="text-sm text-gray-500">
                    Vous ne trouvez pas votre numéro de référence ? 
                    <a href="{{ route('contact') }}" class="text-blue-600 hover:underline font-medium">Contactez-nous</a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Comment obtenir le numéro -->
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-blue-600 px-8 py-6">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-question-circle mr-3"></i>
                Comment obtenir votre numéro de suivi ?
            </h2>
        </div>
        
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- SMS -->
                <div class="bg-blue-50 rounded-xl p-6 text-center">
                    <div class="text-4xl mb-4">📱</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">SMS automatique</h3>
                    <p class="text-gray-600 text-sm">
                        Vous recevez automatiquement un SMS avec votre numéro de suivi dès la prise en charge
                    </p>
                </div>
                
                <!-- Email -->
                <div class="bg-green-50 rounded-xl p-6 text-center">
                    <div class="text-4xl mb-4">📧</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Email de confirmation</h3>
                    <p class="text-gray-600 text-sm">
                        Un email détaillé avec toutes les informations de suivi vous est envoyé après validation
                    </p>
                </div>
                
                <!-- Reçu -->
                <div class="bg-yellow-50 rounded-xl p-6 text-center">
                    <div class="text-4xl mb-4">🧾</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Reçu de dépôt</h3>
                    <p class="text-gray-600 text-sm">
                        Le numéro figure sur votre reçu de dépôt remis lors de la prise en charge
                    </p>
                </div>
                
                <!-- Espace client -->
                <div class="bg-purple-50 rounded-xl p-6 text-center">
                    <div class="text-4xl mb-4">👤</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Espace client</h3>
                    <p class="text-gray-600 text-sm">
                        Connectez-vous à votre espace client pour retrouver tous vos envois
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Actions rapides -->
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-8 py-6">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-life-ring mr-3"></i>
                Besoin d'aide ?
            </h2>
        </div>
        
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center bg-blue-50 rounded-xl p-6">
                    <div class="text-4xl mb-4">📞</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Appelez-nous</h3>
                    <p class="text-gray-600 mb-4 text-sm">Service client disponible 7j/7</p>
                    <a href="tel:+22897311158" class="text-blue-600 font-medium hover:underline">
                        +228 97 31 11 58
                    </a>
                </div>
                
                <div class="text-center bg-green-50 rounded-xl p-6">
                    <div class="text-4xl mb-4">💬</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">WhatsApp</h3>
                    <p class="text-gray-600 mb-4 text-sm">Chat direct avec nos agents</p>
                    <a href="https://wa.me/22897311158" target="_blank" class="text-green-600 font-medium hover:underline">
                        Ouvrir WhatsApp
                    </a>
                </div>
                
                <div class="text-center bg-purple-50 rounded-xl p-6">
                    <div class="text-4xl mb-4">👤</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Espace client</h3>
                    <p class="text-gray-600 mb-4 text-sm">Suivi détaillé de tous vos envois</p>
                    <a href="{{ route('login') }}" class="text-purple-600 font-medium hover:underline">
                        Se connecter
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
