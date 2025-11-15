@extends('layouts.main')

@section('title', 'Suivi de Colis - NIF CARGO')

@section('content')
<!-- Hero Section Moderne -->
<section class="relative overflow-hidden bg-gradient-to-br from-blue-900 via-blue-800 to-purple-900 py-24 lg:py-32">
    <!-- Éléments décoratifs -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    <div class="absolute top-10 left-10 w-72 h-72 bg-blue-600/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl"></div>
    
    <div class="relative z-10 text-center text-white max-w-6xl mx-auto px-4">
        <!-- Badge animé -->
        <div class="inline-flex items-center bg-white/10 backdrop-blur-md text-white rounded-full px-6 py-3 mb-8 border border-white/20 shadow-lg animate-pulse">
            <span class="w-2 h-2 bg-green-400 rounded-full mr-3 animate-pulse"></span>
            <span class="text-lg font-semibold">Suivi en temps réel</span>
        </div>
        
        <h1 class="text-5xl lg:text-7xl font-bold mb-6 leading-tight animate-fade-in">
            Suivez votre 
            <span class="bg-gradient-to-r from-blue-400 to-green-400 bg-clip-text text-transparent">colis</span>
        </h1>
        <p class="text-xl lg:text-2xl opacity-90 max-w-3xl mx-auto leading-relaxed animate-slide-up">
            Entrez votre numéro de suivi pour connaître la position exacte de votre envoi en temps réel
        </p>
        
        <!-- Indicateurs de performance -->
        <div class="flex flex-wrap justify-center gap-8 mt-12">
            <div class="text-center">
                <div class="text-3xl font-bold text-white mb-2">24h/24</div>
                <div class="text-blue-200 text-sm">Disponibilité</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-white mb-2">Temps réel</div>
                <div class="text-blue-200 text-sm">Mises à jour</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-white mb-2">100%</div>
                <div class="text-blue-200 text-sm">Précision</div>
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
@if(session('error'))
    <div class="max-w-4xl mx-auto px-4 mb-8 mt-8">
        <div class="bg-red-50 border-l-4 border-red-500 rounded-r-xl p-6 shadow-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-red-800 font-semibold">Erreur de recherche</h3>
                    <p class="text-red-700 mt-1">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Formulaire de recherche moderne -->
<div class="max-w-4xl mx-auto px-4 py-12 -mt-8 relative z-20">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-100 backdrop-blur-sm">
        <!-- En-tête avec dégradé -->
        <div class="bg-gradient-to-r from-blue-600 via-red-500 to-purple-600 px-8 py-8 relative overflow-hidden">
            <!-- Éléments décoratifs -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-12 -translate-x-12"></div>
            
            <h2 class="text-3xl font-bold text-white flex items-center relative z-10">
                <i class="fas fa-search-location mr-4 text-2xl"></i>
                Rechercher votre envoi
            </h2>
            <p class="text-blue-100 mt-2 relative z-10">Suivi en temps réel de votre colis</p>
        </div>

        <div class="p-8 lg:p-10">
            <!-- Illustration et texte -->
            <div class="text-center mb-10">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-purple-100 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg group hover:shadow-xl transition-all duration-300">
                    <i class="fas fa-shipping-fast text-4xl text-blue-600 group-hover:scale-110 transition-transform"></i>
                </div>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto leading-relaxed">
                    Saisissez votre numéro de suivi pour suivre votre colis en temps réel avec une précision maximale
                </p>
            </div>
            
            <!-- Formulaire amélioré -->
            <form action="{{ route('suivi.rechercher') }}" method="POST" class="max-w-2xl mx-auto">
                @csrf
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1 relative">
                        <input type="text" 
                               name="tracking" 
                               placeholder="Ex: 1234567" 
                               required
                               value="{{ old('tracking') }}"
                               class="w-full px-6 py-4 text-lg border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all durée-200 bg-white/50 backdrop-blur-sm @error('tracking') border-red-500 @enderror">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                            <i class="fas fa-barcode text-gray-400 text-xl"></i>
                        </div>
                        @error('tracking')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    <button type="submit" 
                            class="bg-gradient-to-r from-blue-600 to-red-600 text-white px-8 py-4 rounded-2xl font-semibold text-lg hover:from-blue-700 hover:to-red-700 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center whitespace-nowrap group">
                        <i class="fas fa-search mr-3 group-hover:scale-110 transition-transform"></i>
                        Rechercher
                    </button>
                </div>
            </form>
            
            <!-- Lien d'aide -->
            <div class="text-center mt-8">
                <p class="text-sm text-gray-500 flex items-center justify-center">
                    <i class="fas fa-question-circle mr-2"></i>
                    Vous ne trouvez pas votre numéro de suivi ? 
                    <a href="{{ route('contact') }}" class="text-blue-600 hover:text-blue-700 font-medium ml-1 transition-colors">
                        Contactez-nous
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Comment obtenir le numéro - Version moderne -->
<div class="max-w-6xl mx-auto px-4 py-16">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-100">
        <!-- En-tête -->
        <div class="bg-gradient-to-r from-green-600 via-blue-500 to-purple-600 px-8 py-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -translate-y-20 translate-x-20"></div>
            <h2 class="text-3xl font-bold text-white flex items-center relative z-10">
                <i class="fas fa-info-circle mr-4 text-2xl"></i>
                Comment obtenir votre numéro de suivi ?
            </h2>
        </div>
        
        <div class="p-8 lg:p-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- SMS -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 text-center group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-blue-200">
                    <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center text-white text-2xl mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="fas fa-sms"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">SMS automatique</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Vous recevez automatiquement un SMS avec votre numéro de suivi dès la prise en charge de votre colis
                    </p>
                </div>
                
                <!-- Email -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-2xl p-8 text-center group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-green-200">
                    <div class="w-16 h-16 bg-green-500 rounded-2xl flex items-center justify-center text-white text-2xl mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Email de confirmation</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Un email détaillé avec toutes les informations de suivi vous est envoyé après validation de votre envoi
                    </p>
                </div>
                
                <!-- Reçu -->
                <div class="bg-gradient-to-br from-yellow-50 to-amber-100 rounded-2xl p-8 text-center group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-yellow-200">
                    <div class="w-16 h-16 bg-yellow-500 rounded-2xl flex items-center justify-center text-white text-2xl mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Reçu de dépôt</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Le numéro figure sur votre reçu de dépôt remis lors de la prise en charge de votre colis
                    </p>
                </div>
                
                <!-- Espace client -->
                <div class="bg-gradient-to-br from-purple-50 to-violet-100 rounded-2xl p-8 text-center group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-purple-200">
                    <div class="w-16 h-16 bg-purple-500 rounded-2xl flex items-center justify-center text-white text-2xl mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Espace client</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Connectez-vous à votre espace client pour retrouver tous vos envois et leurs numéros de suivi
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Actions rapides modernisées -->
<div class="max-w-4xl mx-auto px-4 py-16">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-100">
        <!-- En-tête -->
        <div class="bg-gradient-to-r from-purple-600 via-pink-500 to-red-600 px-8 py-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full -translate-y-20 -translate-x-20"></div>
            <h2 class="text-3xl font-bold text-white flex items-center relative z-10">
                <i class="fas fa-life-ring mr-4 text-2xl"></i>
                Besoin d'aide ?
            </h2>
            <p class="text-purple-100 mt-2 relative z-10">Notre équipe est à votre disposition</p>
        </div>
        
        <div class="p-8 lg:p-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Téléphone -->
                <div class="bg-gradient-to-br from-blue-50 to-cyan-100 rounded-2xl p-8 text-center group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-blue-200">
                    <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center text-white text-2xl mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Appelez-nous</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">Service client disponible 7j/7 pour vous accompagner</p>
                    <a href="tel:+22899252531" class="text-blue-600 font-semibold hover:text-blue-700 transition-colors text-lg inline-flex items-center group/link">
                        +228 99 25 25 31
                        <i class="fas fa-arrow-right ml-2 group-hover/link:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                
                <!-- WhatsApp -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-2xl p-8 text-center group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-green-200">
                    <div class="w-16 h-16 bg-green-500 rounded-2xl flex items-center justify-center text-white text-2xl mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">WhatsApp</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">Chat direct et instantané avec nos agents</p>
                    <a href="https://wa.me/22899252531" target="_blank" class="text-green-600 font-semibold hover:text-green-700 transition-colors text-lg inline-flex items-center group/link">
                        Ouvrir WhatsApp
                        <i class="fas fa-external-link-alt ml-2 group-hover/link:scale-110 transition-transform"></i>
                    </a>
                </div>
                
                <!-- Espace client -->
                <div class="bg-gradient-to-br from-purple-50 to-violet-100 rounded-2xl p-8 text-center group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-purple-200">
                    <div class="w-16 h-16 bg-purple-500 rounded-2xl flex items-center justify-center text-white text-2xl mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Espace client</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">Accédez au suivi détaillé de tous vos envois</p>
                    <a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:text-purple-700 transition-colors text-lg inline-flex items-center group/link">
                        Se connecter
                        <i class="fas fa-arrow-right ml-2 group-hover/link:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Rapide -->
<div class="max-w-4xl mx-auto px-4 py-16">
    <div class="bg-gradient-to-br from-slate-50 to-blue-50 rounded-3xl p-8 border border-slate-200 shadow-xl">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Questions fréquentes</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                    <i class="fas fa-clock text-blue-500 mr-3"></i>
                    Délai de mise à jour ?
                </h3>
                <p class="text-gray-600">Les informations sont mises à jour toutes les 15 minutes pour une précision maximale.</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                    <i class="fas fa-map-marker-alt text-green-500 mr-3"></i>
                    Précision géographique ?
                </h3>
                <p class="text-gray-600">Localisation précise à moins de 100 mètres grâce à notre système GPS avancé.</p>
            </div>
        </div>
    </div>
</div>

<style>
.animate-fade-in {
    animation: fadeIn 0.8s ease-out;
}

.animate-slide-up {
    animation: slideUp 0.8s ease-out 0.2s both;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.backdrop-blur-sm {
    backdrop-filter: blur(8px);
}

/* Amélioration responsive */
@media (max-width: 768px) {
    .text-7xl {
        font-size: 3rem;
    }
    
    .text-5xl {
        font-size: 2.5rem;
    }
    
    .p-8 {
        padding: 1.5rem;
    }
    
    .p-10 {
        padding: 2rem;
    }
}

/* Effets de hover améliorés */
.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}

.transition-all {
    transition: all 0.3s ease;
}
</style>

<script>
// Animation d'entrée pour les éléments
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.bg-white, .bg-gradient-to-br');
    elements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        setTimeout(() => {
            el.style.transition = 'all 0.6s ease';
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

// Focus automatique sur le champ de recherche
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="tracking"]');
    if (searchInput) {
        setTimeout(() => {
            searchInput.focus();
        }, 500);
    }
});
</script>
@endsection