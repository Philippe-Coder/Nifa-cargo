<!-- Header/Navigation -->
<header class="bg-white shadow-sm sticky top-0 z-50 backdrop-blur-sm bg-white/95">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-3">
            <!-- Logo -->
            <div class="flex items-center flex-shrink-0">
                <a href="{{ route('accueil') }}" class="flex items-center group">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-600 rounded-lg flex items-center justify-center mr-3 transition-transform group-hover:scale-105">
                        <span class="text-white font-bold text-lg">N</span>
                    </div>
                    <span class="text-xl font-bold text-gray-900">NIFA</span>
                </a>
            </div>
            
            <!-- Navigation Desktop -->
            <nav class="hidden lg:flex items-center space-x-1">
                <a href="{{ route('accueil') }}" 
                   class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 rounded-lg hover:bg-blue-50 {{ request()->routeIs('accueil') ? 'text-blue-600 bg-blue-50' : '' }}">
                    Accueil
                </a>
                <a href="{{ route('services') }}" 
                   class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 rounded-lg hover:bg-blue-50 {{ request()->routeIs('services') ? 'text-blue-600 bg-blue-50' : '' }}">
                    Services
                </a>
                <a href="{{ route('apropos') }}" 
                   class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 rounded-lg hover:bg-blue-50 {{ request()->routeIs('apropos') ? 'text-blue-600 bg-blue-50' : '' }}">
                    À propos
                </a>
                <a href="{{ route('contact') }}" 
                   class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 rounded-lg hover:bg-blue-50 {{ request()->routeIs('contact') ? 'text-blue-600 bg-blue-50' : '' }}">
                    Contact
                </a>
            </nav>
            
            <!-- CTA Buttons -->
            <div class="flex items-center space-x-3">
                <!-- Suivi colis - Desktop -->
                <a href="{{ route('suivi.public') }}" 
                   class="hidden md:flex items-center text-gray-600 hover:text-blue-600 font-medium transition-colors duration-300 px-3 py-2 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-search mr-2 text-sm"></i>
                    <span class="text-sm">Suivre un colis</span>
                </a>
                
                @auth
                    <!-- Boutons selon le rôle -->
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" 
                           class="hidden md:flex items-center bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <i class="fas fa-tachometer-alt mr-2 text-sm"></i>
                            <span class="text-sm">Admin</span>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" 
                           class="hidden md:flex items-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <i class="fas fa-user mr-2 text-sm"></i>
                            <span class="text-sm">Mon espace</span>
                        </a>
                    @endif
                    
                    <!-- Menu utilisateur -->
                    <div class="relative">
                        <button id="user-menu-button" 
                                class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 transition-all duration-300 p-2 rounded-lg hover:bg-gray-50">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-sm">
                                <span class="text-white text-xs font-semibold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            </div>
                            <span class="hidden lg:block text-sm font-medium">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-300"></i>
                        </button>
                        
                        <!-- Dropdown menu -->
                        <div id="user-menu" 
                             class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50 hidden animate-fade-in">
                            <!-- En-tête du menu -->
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                <span class="inline-block mt-1 px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">
                                    @if(Auth::user()->isAdmin())
                                        Administrateur
                                    @else
                                        Client
                                    @endif
                                </span>
                            </div>
                            
                            <!-- Liens du menu -->
                            <div class="py-1">
                                <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                    <i class="fas fa-tachometer-alt mr-3 text-gray-400 w-4"></i>
                                    Dashboard
                                </a>
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                    <i class="fas fa-user mr-3 text-gray-400 w-4"></i>
                                    Mon profil
                                </a>
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                    <i class="fas fa-cog mr-3 text-gray-400 w-4"></i>
                                    Paramètres
                                </a>
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                    <i class="fas fa-bell mr-3 text-gray-400 w-4"></i>
                                    Notifications
                                </a>
                            </div>
                            
                            <!-- Séparateur -->
                            <div class="border-t border-gray-100 my-1"></div>
                            
                            <!-- Déconnexion -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-sign-out-alt mr-3 w-4"></i>
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Utilisateur non connecté -->
                    <a href="{{ route('login') }}" 
                       class="hidden md:flex items-center text-gray-600 hover:text-blue-600 font-medium transition-colors duration-300 px-4 py-2 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-sign-in-alt mr-2 text-sm"></i>
                        <span class="text-sm">Connexion</span>
                    </a>
                    <a href="{{ route('register') }}" 
                       class="hidden md:flex items-center bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white px-5 py-2.5 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <i class="fas fa-box mr-2 text-sm"></i>
                        <span class="text-sm">Faire une demande</span>
                    </a>
                @endauth
                
                <!-- Menu mobile button -->
                <button id="mobile-menu-button" class="lg:hidden flex items-center justify-center w-10 h-10 text-gray-700 hover:text-blue-600 hover:bg-gray-100 rounded-lg transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Menu mobile -->
        <div id="mobile-menu" class="lg:hidden hidden border-t border-gray-200 py-4 bg-white animate-slide-down">
            <div class="space-y-1">
                <a href="{{ route('accueil') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 font-medium rounded-lg transition-all duration-300 {{ request()->routeIs('accueil') ? 'text-blue-600 bg-blue-50' : '' }}">
                    <i class="fas fa-home mr-3 w-5 text-center"></i>
                    Accueil
                </a>
                <a href="{{ route('services') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 font-medium rounded-lg transition-all duration-300 {{ request()->routeIs('services') ? 'text-blue-600 bg-blue-50' : '' }}">
                    <i class="fas fa-shipping-fast mr-3 w-5 text-center"></i>
                    Services
                </a>
                <a href="{{ route('apropos') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 font-medium rounded-lg transition-all duration-300 {{ request()->routeIs('apropos') ? 'text-blue-600 bg-blue-50' : '' }}">
                    <i class="fas fa-info-circle mr-3 w-5 text-center"></i>
                    À propos
                </a>
                <a href="{{ route('contact') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 font-medium rounded-lg transition-all duration-300 {{ request()->routeIs('contact') ? 'text-blue-600 bg-blue-50' : '' }}">
                    <i class="fas fa-envelope mr-3 w-5 text-center"></i>
                    Contact
                </a>
                <a href="{{ route('suivi.public') }}" 
                   class="flex items-center px-4 py-3 text-gray-600 hover:text-blue-600 hover:bg-blue-50 font-medium rounded-lg transition-all duration-300">
                    <i class="fas fa-search mr-3 w-5 text-center"></i>
                    Suivre un colis
                </a>
                
                @auth
                    <!-- Section utilisateur connecté -->
                    <div class="border-t border-gray-200 pt-3 mt-3 space-y-1">
                        <div class="px-4 py-2">
                            <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                        
                        <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" 
                           class="flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 font-medium rounded-lg transition-all duration-300">
                            <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i>
                            Mon espace
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 font-medium rounded-lg transition-all duration-300">
                            <i class="fas fa-user mr-3 w-5 text-center"></i>
                            Mon profil
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 font-medium rounded-lg transition-all duration-300">
                            <i class="fas fa-cog mr-3 w-5 text-center"></i>
                            Paramètres
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="flex items-center w-full px-4 py-3 text-red-600 hover:text-red-700 hover:bg-red-50 font-medium rounded-lg transition-all duration-300">
                                <i class="fas fa-sign-out-alt mr-3 w-5 text-center"></i>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Section utilisateur non connecté -->
                    <div class="border-t border-gray-200 pt-3 mt-3 space-y-2">
                        <a href="{{ route('login') }}" 
                           class="flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 font-medium rounded-lg transition-all duration-300">
                            <i class="fas fa-sign-in-alt mr-3 w-5 text-center"></i>
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" 
                           class="flex items-center justify-center bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md mx-4">
                            <i class="fas fa-box mr-2"></i>
                            Faire une demande
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</header>

<!-- Styles d'animation -->
<style>
.animate-fade-in {
    animation: fadeIn 0.2s ease-out;
}

.animate-slide-down {
    animation: slideDown 0.3s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Améliorations responsive */
@media (max-width: 768px) {
    header .max-w-7xl {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    header .py-3 {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
}

@media (max-width: 640px) {
    .text-xl {
        font-size: 1.25rem;
    }
    
    .w-10 {
        width: 2.5rem;
    }
    
    .h-10 {
        height: 2.5rem;
    }
}

/* Amélioration de l'accessibilité */
@media (prefers-reduced-motion: reduce) {
    .animate-fade-in,
    .animate-slide-down,
    .transition-all,
    .transition-colors,
    .transition-transform {
        animation: none;
        transition: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');
    
    // Menu mobile toggle
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            const isHidden = mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden');
            
            // Animation de l'icône hamburger
            const svg = mobileMenuButton.querySelector('svg');
            if (isHidden) {
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
            } else {
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
            }
        });
        
        // Fermer le menu mobile en cliquant à l'extérieur
        document.addEventListener('click', function(event) {
            if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
                const svg = mobileMenuButton.querySelector('svg');
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
            }
        });
    }
    
    // Menu utilisateur toggle
    if (userMenuButton && userMenu) {
        userMenuButton.addEventListener('click', function(event) {
            event.stopPropagation();
            userMenu.classList.toggle('hidden');
            
            // Animation de la flèche
            const chevron = userMenuButton.querySelector('.fa-chevron-down');
            if (chevron) {
                chevron.classList.toggle('rotate-180');
            }
        });
        
        // Fermer le menu utilisateur en cliquant à l'extérieur
        document.addEventListener('click', function(event) {
            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
                const chevron = userMenuButton.querySelector('.fa-chevron-down');
                if (chevron) {
                    chevron.classList.remove('rotate-180');
                }
            }
        });
    }
    
    // Fermer les menus lors du redimensionnement de la fenêtre
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            if (mobileMenu) mobileMenu.classList.add('hidden');
            if (userMenu) userMenu.classList.add('hidden');
            
            // Réinitialiser l'icône hamburger
            if (mobileMenuButton) {
                const svg = mobileMenuButton.querySelector('svg');
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
            }
            
            // Réinitialiser la flèche
            if (userMenuButton) {
                const chevron = userMenuButton.querySelector('.fa-chevron-down');
                if (chevron) {
                    chevron.classList.remove('rotate-180');
                }
            }
        }
    });
});
</script>