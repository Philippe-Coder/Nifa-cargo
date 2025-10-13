<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIFA - Header Moderne</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
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

        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.85);
        }

        .nav-link {
            position: relative;
            overflow: hidden;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #10b981);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .logo-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #10b981 100%);
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #10b981 100%);
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2), 0 2px 4px -1px rgba(59, 130, 246, 0.06);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3), 0 4px 6px -2px rgba(59, 130, 246, 0.1);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .user-avatar {
            background: linear-gradient(135deg, #3b82f6 0%, #10b981 100%);
        }

        .mobile-menu-bg {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .dropdown-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header/Navigation -->
    <header class="glass-effect shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ route('accueil') }}" class="flex items-center group">
                        <!-- Remplacement du logo texte par votre image -->
                        <img src="/images/logo.png" alt="NIFA Logo" class="h-12 w-auto transition-all duration-300 group-hover:scale-105">
                    </a>
                </div>
                
                <!-- Navigation Desktop -->
                <nav class="hidden lg:flex items-center space-x-1">
                    <a href="{{ route('accueil') }}" 
                       class="nav-link px-5 py-2.5 text-gray-700 hover:text-gray-900 font-medium transition-all duration-300 rounded-lg {{ request()->routeIs('accueil') ? 'active text-gray-900' : '' }}">
                        Accueil
                    </a>
                    <a href="{{ route('services') }}" 
                       class="nav-link px-5 py-2.5 text-gray-700 hover:text-gray-900 font-medium transition-all duration-300 rounded-lg {{ request()->routeIs('services') ? 'active text-gray-900' : '' }}">
                        Services
                    </a>
                    <a href="{{ route('apropos') }}" 
                       class="nav-link px-5 py-2.5 text-gray-700 hover:text-gray-900 font-medium transition-all duration-300 rounded-lg {{ request()->routeIs('apropos') ? 'active text-gray-900' : '' }}">
                        À propos
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="nav-link px-5 py-2.5 text-gray-700 hover:text-gray-900 font-medium transition-all duration-300 rounded-lg {{ request()->routeIs('contact') ? 'active text-gray-900' : '' }}">
                        Contact
                    </a>
                </nav>
                
                <!-- CTA Buttons -->
                <div class="flex items-center space-x-3">
                    <!-- Suivi colis - Desktop -->
                    <a href="{{ route('suivi.public') }}" 
                       class="hidden md:flex items-center btn-secondary text-gray-700 font-medium px-4 py-2.5 rounded-lg">
                        <i class="fas fa-search mr-2 text-sm"></i>
                        <span class="text-sm">Suivre un colis</span>
                    </a>
                    
                    @auth
                        <!-- Boutons selon le rôle -->
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" 
                               class="hidden md:flex items-center btn-primary text-white px-5 py-2.5 rounded-lg font-semibold">
                                <i class="fas fa-tachometer-alt mr-2 text-sm"></i>
                                <span class="text-sm">Admin</span>
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" 
                               class="hidden md:flex items-center btn-primary text-white px-5 py-2.5 rounded-lg font-semibold">
                                <i class="fas fa-user mr-2 text-sm"></i>
                                <span class="text-sm">Mon espace</span>
                            </a>
                        @endif
                        
                        <!-- Menu utilisateur -->
                        <div class="relative">
                            <button id="user-menu-button" 
                                    class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 transition-all duration-300 p-2 rounded-lg hover:bg-gray-100">
                                <div class="user-avatar w-9 h-9 rounded-full flex items-center justify-center shadow-sm">
                                    <span class="text-white text-xs font-semibold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                </div>
                                <span class="hidden lg:block text-sm font-medium">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-300"></i>
                            </button>
                            
                            <!-- Dropdown menu -->
                            <div id="user-menu" 
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl dropdown-shadow border border-gray-100 py-2 z-50 hidden animate-fade-in">
                                <!-- En-tête du menu -->
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate mt-1">{{ Auth::user()->email }}</p>
                                    <span class="inline-block mt-2 px-2.5 py-1 bg-gradient-to-r from-blue-50 to-green-50 text-gray-700 border border-gray-200 rounded-full text-xs font-medium">
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
                                       class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-tachometer-alt mr-3 text-gray-500 w-4"></i>
                                        Dashboard
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-user mr-3 text-gray-500 w-4"></i>
                                        Mon profil
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-cog mr-3 text-gray-500 w-4"></i>
                                        Paramètres
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-bell mr-3 text-gray-500 w-4"></i>
                                        Notifications
                                    </a>
                                </div>
                                
                                <!-- Séparateur -->
                                <div class="border-t border-gray-100 my-1"></div>
                                
                                <!-- Déconnexion -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="flex items-center w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-3 w-4"></i>
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Utilisateur non connecté -->
                        <a href="{{ route('login') }}" 
                           class="hidden md:flex items-center btn-secondary text-gray-700 font-medium px-4 py-2.5 rounded-lg">
                            <i class="fas fa-sign-in-alt mr-2 text-sm"></i>
                            <span class="text-sm">Connexion</span>
                        </a>
                        <a href="{{ route('register') }}" 
                           class="hidden md:flex items-center btn-primary text-white px-5 py-2.5 rounded-lg font-semibold">
                            <i class="fas fa-box mr-2 text-sm"></i>
                            <span class="text-sm">Faire une demande</span>
                        </a>
                    @endauth
                    
                    <!-- Menu mobile button -->
                    <button id="mobile-menu-button" class="lg:hidden flex items-center justify-center w-10 h-10 text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Menu mobile -->
            <div id="mobile-menu" class="lg:hidden hidden mobile-menu-bg py-4 animate-slide-down rounded-b-xl border-t border-gray-100">
                <div class="space-y-1">
                    <a href="{{ route('accueil') }}" 
                       class="flex items-center px-4 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300 {{ request()->routeIs('accueil') ? 'text-gray-900 bg-gray-50' : '' }}">
                        <i class="fas fa-home mr-3 w-5 text-center text-gray-500"></i>
                        Accueil
                    </a>
                    <a href="{{ route('services') }}" 
                       class="flex items-center px-4 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300 {{ request()->routeIs('services') ? 'text-gray-900 bg-gray-50' : '' }}">
                        <i class="fas fa-shipping-fast mr-3 w-5 text-center text-gray-500"></i>
                        Services
                    </a>
                    <a href="{{ route('apropos') }}" 
                       class="flex items-center px-4 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300 {{ request()->routeIs('apropos') ? 'text-gray-900 bg-gray-50' : '' }}">
                        <i class="fas fa-info-circle mr-3 w-5 text-center text-gray-500"></i>
                        À propos
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="flex items-center px-4 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300 {{ request()->routeIs('contact') ? 'text-gray-900 bg-gray-50' : '' }}">
                        <i class="fas fa-envelope mr-3 w-5 text-center text-gray-500"></i>
                        Contact
                    </a>
                    <a href="{{ route('suivi.public') }}" 
                       class="flex items-center px-4 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300">
                        <i class="fas fa-search mr-3 w-5 text-center text-gray-500"></i>
                        Suivre un colis
                    </a>
                    
                    @auth
                        <!-- Section utilisateur connecté -->
                        <div class="border-t border-gray-200 pt-3 mt-3 space-y-1">
                            <div class="px-4 py-2">
                                <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ Auth::user()->email }}</p>
                            </div>
                            
                            <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" 
                               class="flex items-center px-4 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300">
                                <i class="fas fa-tachometer-alt mr-3 w-5 text-center text-gray-500"></i>
                                Mon espace
                            </a>
                            <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300">
                                <i class="fas fa-user mr-3 w-5 text-center text-gray-500"></i>
                                Mon profil
                            </a>
                            <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300">
                                <i class="fas fa-cog mr-3 w-5 text-center text-gray-500"></i>
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
                               class="flex items-center px-4 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300">
                                <i class="fas fa-sign-in-alt mr-3 w-5 text-center text-gray-500"></i>
                                Connexion
                            </a>
                            <a href="{{ route('register') }}" 
                               class="flex items-center justify-center btn-primary text-white px-4 py-3 rounded-lg font-semibold transition-all duration-300 mx-4">
                                <i class="fas fa-box mr-2"></i>
                                Faire une demande
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

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
</body>
</html>