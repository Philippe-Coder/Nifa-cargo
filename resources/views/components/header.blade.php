<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIF Cargo - Header Moderne</title>
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

        /* Responsive breakpoints optimisés */
        @media (max-width: 640px) {
            .nav-link {
                font-size: 0.875rem;
                padding: 0.5rem 0.75rem;
            }
            
            .btn-primary, .btn-secondary {
                font-size: 0.75rem;
                padding: 0.5rem 0.75rem;
            }
        }

        @media (min-width: 640px) and (max-width: 1024px) {
            .nav-link {
                font-size: 0.875rem;
                padding: 0.625rem 1rem;
            }
        }

        /* Breakpoint critique : petits écrans desktop (1024px - 1280px) */
        @media (min-width: 1024px) and (max-width: 1280px) {
            .nav-link {
                font-size: 0.875rem; /* Taille de texte plus lisible */
                padding: 0.5rem 0.75rem;
            }
            
            .btn-primary, .btn-secondary {
                font-size: 0.875rem;
                padding: 0.5rem 0.75rem;
            }
        }

        /* Écrans desktop moyens (1280px - 1536px) */
        @media (min-width: 1280px) and (max-width: 1536px) {
            .nav-link {
                font-size: 0.875rem;
                padding: 0.625rem 1rem;
            }
            
            .btn-primary, .btn-secondary {
                font-size: 0.875rem;
                padding: 0.625rem 1rem;
            }
        }

        /* Grands écrans desktop (1536px+) */
        @media (min-width: 1536px) {
            .nav-link {
                font-size: 1rem;
                padding: 0.75rem 1.5rem;
            }
            
            .btn-primary, .btn-secondary {
                font-size: 0.875rem;
                padding: 0.75rem 1.5rem;
            }
        }

        /* Prevent layout shifts */
        .header-container {
            min-height: 60px;
        }

        @media (min-width: 640px) {
            .header-container {
                min-height: 64px;
            }
        }

        @media (min-width: 1024px) {
            .header-container {
                min-height: 68px;
            }
        }

        @media (min-width: 1536px) {
            .header-container {
                min-height: 80px;
            }
        }

        /* Optimisation responsive pour éviter débordement */
        @media (min-width: 1024px) and (max-width: 1280px) {
            .header-container {
                gap: 0.5rem; /* Espacement entre éléments */
            }
            
            nav {
                flex-shrink: 1;
            }
            
            .user-avatar {
                min-width: 1.75rem;
                min-height: 1.75rem;
            }

            /* Conteneur plus compact */
            .max-w-8xl {
                max-width: 100%;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header/Navigation -->
    <header class="glass-effect shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-8xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8">
            <div class="header-container flex items-center justify-between py-3 sm:py-4 lg:py-5">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0 mr-1 lg:mr-2 2xl:mr-8">
                    <a href="{{ route('accueil') }}" class="flex items-center group">
                        <!-- Remplacement du logo texte par votre image -->
                        <img src="/images/logo.png" alt="NIF Cargo Logo" class="h-8 lg:h-10 2xl:h-12 w-auto transition-all duration-300 group-hover:scale-105">
                    </a>
                </div>
                
                <!-- Navigation Desktop - Version compacte pour écrans desktop moyens (1024px-1280px) -->
                <nav class="hidden lg:flex xl:hidden items-center space-x-1 flex-shrink min-w-0">
                    <a href="{{ route('accueil') }}" 
                       class="nav-link px-2 py-2 text-gray-800 hover:text-gray-900 font-medium transition-all duration-300 rounded whitespace-nowrap text-sm {{ request()->routeIs('accueil') ? 'active text-gray-900' : '' }}">
                        {{ __('Accueil') }}
                    </a>
                    <a href="{{ route('services') }}" 
                       class="nav-link px-2 py-2 text-gray-800 hover:text-gray-900 font-medium transition-all duration-300 rounded whitespace-nowrap text-sm {{ request()->routeIs('services') ? 'active text-gray-900' : '' }}">
                        {{ __('Services') }}
                    </a>
                    <a href="{{ route('apropos') }}" 
                       class="nav-link px-2 py-2 text-gray-800 hover:text-gray-900 font-medium transition-all duration-300 rounded whitespace-nowrap text-sm {{ request()->routeIs('apropos') ? 'active text-gray-900' : '' }}">
                        {{ __('À Propos') }}
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="nav-link px-2 py-2 text-gray-800 hover:text-gray-900 font-medium transition-all duration-300 rounded whitespace-nowrap text-sm {{ request()->routeIs('contact') ? 'active text-gray-900' : '' }}">
                        {{ __('Contact') }}
                    </a>
                    <a href="{{ route('blog.index') }}" 
                        class="nav-link px-2 py-2 text-gray-800 hover:text-gray-900 font-medium transition-all duration-300 rounded whitespace-nowrap text-sm {{ request()->routeIs('blog.*') ? 'active text-gray-900' : '' }}">
                            {{ __('Actualités') }}
                    </a>
                    <a href="{{ route('galerie.index') }}" 
                       class="nav-link px-2 py-2 text-gray-800 hover:text-gray-900 font-medium transition-all duration-300 rounded whitespace-nowrap text-sm {{ request()->routeIs('galerie.*') ? 'active text-gray-900' : '' }}">
                        {{ __('Galerie') }}
                    </a>
                </nav>

                <!-- Version complète pour grands écrans (1280px+) -->
                <nav class="hidden xl:flex items-center space-x-1 2xl:space-x-3 flex-grow justify-start ml-1 2xl:ml-4">
                    <a href="{{ route('accueil') }}" 
                       class="nav-link px-2 2xl:px-6 py-1.5 2xl:py-3 text-gray-800 hover:text-gray-900 font-medium transition-all duration-300 rounded-lg whitespace-nowrap text-sm 2xl:text-base {{ request()->routeIs('accueil') ? 'active text-gray-900' : '' }}">
                        {{ __('Accueil') }}
                    </a>
                    <a href="{{ route('services') }}" 
                       class="nav-link px-2 2xl:px-6 py-1.5 2xl:py-3 text-gray-800 hover:text-gray-900 font-medium transition-all duration-300 rounded-lg whitespace-nowrap text-sm 2xl:text-base {{ request()->routeIs('services') ? 'active text-gray-900' : '' }}">
                        {{ __('Services') }}
                    </a>
                    <a href="{{ route('apropos') }}" 
                       class="nav-link px-2 2xl:px-6 py-1.5 2xl:py-3 text-gray-800 hover:text-gray-900 font-medium transition-all duration-300 rounded-lg whitespace-nowrap text-sm 2xl:text-base {{ request()->routeIs('apropos') ? 'active text-gray-900' : '' }}">
                        {{ __('À Propos') }}
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="nav-link px-2 2xl:px-6 py-1.5 2xl:py-3 text-gray-800 hover:text-gray-900 font-medium transition-all duration-300 rounded-lg whitespace-nowrap text-sm 2xl:text-base {{ request()->routeIs('contact') ? 'active text-gray-900' : '' }}">
                        {{ __('Contact') }}
                    </a>
                    <a href="{{ route('blog.index') }}" 
                        class="nav-link px-2 2xl:px-6 py-1.5 2xl:py-3 text-gray-800 hover:text-gray-900 font-medium transition-all duration-300 rounded-lg whitespace-nowrap text-sm 2xl:text-base {{ request()->routeIs('blog.*') ? 'active text-gray-900' : '' }}">
                            {{ __('Actualités') }}
                    </a>
                    <a href="{{ route('galerie.index') }}" 
                       class="nav-link px-2 2xl:px-6 py-1.5 2xl:py-3 text-gray-800 hover:text-gray-900 font-medium transition-all duration-300 rounded-lg whitespace-nowrap text-sm 2xl:text-base {{ request()->routeIs('galerie.*') ? 'active text-gray-900' : '' }}">
                        {{ __('Galerie') }}
                    </a>
                </nav>
                
                <!-- Boutons à droite - Restauré avec tous les éléments -->
                <div class="flex items-center space-x-1 lg:space-x-2 xl:space-x-3 2xl:space-x-4 ml-auto">
                    <!-- Language Selector - Visible dès 1024px -->
                    <div class="hidden lg:block mr-1 2xl:mr-2">
                        <x-language-selector-url />
                    </div>
                    
                    <!-- Suivi colis - Desktop - Visible dès 1024px -->
                    <a href="{{ route('suivi.public') }}" 
                       class="hidden lg:flex items-center btn-secondary text-gray-700 font-medium px-3 lg:px-4 2xl:px-5 py-2 lg:py-2.5 2xl:py-3 rounded-lg whitespace-nowrap">
                        <i class="fas fa-search mr-1 lg:mr-1.5 2xl:mr-2 text-sm 2xl:text-sm"></i>
                        <span class="text-sm 2xl:text-sm font-medium">{{ __('Suivre un colis') }}</span>
                    </a>
                    
                    @auth
                        <!-- Boutons selon le rôle - Optimisé pour tous écrans -->
                        <div class="flex items-center space-x-2 2xl:space-x-3 ml-2 2xl:ml-4">
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="hidden lg:flex items-center btn-primary text-white px-3 lg:px-4 2xl:px-6 py-2 lg:py-2.5 2xl:py-3 rounded-lg font-semibold whitespace-nowrap">
                                    <i class="fas fa-tachometer-alt mr-1 lg:mr-1.5 2xl:mr-2 text-sm 2xl:text-sm"></i>
                                    <span class="text-sm 2xl:text-sm">{{ __('Admin') }}</span>
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" 
                                   class="hidden lg:flex items-center btn-primary text-white px-3 lg:px-4 2xl:px-6 py-2 lg:py-2.5 2xl:py-3 rounded-lg font-semibold whitespace-nowrap">
                                    <i class="fas fa-user mr-1 lg:mr-1.5 2xl:mr-2 text-sm 2xl:text-sm"></i>
                                    <span class="text-sm 2xl:text-sm">{{ __('Mon espace') }}</span>
                                </a>
                            @endif
                        
                        <!-- Menu utilisateur -->
                        <div class="relative">
                            <button id="user-menu-button" 
                                    class="flex items-center space-x-0.5 2xl:space-x-2 text-gray-700 hover:text-gray-900 transition-all duration-300 p-0.5 2xl:p-2 rounded-lg hover:bg-gray-100">
                                <div class="user-avatar w-6 lg:w-7 2xl:w-9 h-6 lg:h-7 2xl:h-9 rounded-full flex items-center justify-center shadow-sm">
                                    <span class="text-white text-xs font-semibold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                </div>
                                <span class="hidden 2xl:block text-xs 2xl:text-sm font-medium truncate max-w-16 2xl:max-w-20">{{ Auth::user()->name }}</span>
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
                                            {{ __('Administrateur') }}
                                        @else
                                            {{ __('Client') }}
                                        @endif
                                    </span>
                                </div>
                                
                                <!-- Liens du menu -->
                                <div class="py-1">
                                    <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" 
                                       class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-tachometer-alt mr-3 text-gray-500 w-4"></i>
                                        {{ __('Dashboard') }}
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-user mr-3 text-gray-500 w-4"></i>
                                        {{ __('Mon profil') }}
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-cog mr-3 text-gray-500 w-4"></i>
                                        {{ __('Paramètres') }}
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-bell mr-3 text-gray-500 w-4"></i>
                                        {{ __('Notifications') }}
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
                                        {{ __('Déconnexion') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                        </div>
                    @else
                        <!-- Utilisateur non connecté - Restauré avec taille normale -->
                        <div class="flex items-center space-x-2 2xl:space-x-3 ml-2 2xl:ml-4">
                            <a href="{{ route('login') }}" 
                               class="hidden lg:flex items-center btn-secondary text-gray-700 font-medium px-3 lg:px-4 2xl:px-5 py-2 lg:py-2.5 2xl:py-3 rounded-lg whitespace-nowrap">
                                <i class="fas fa-sign-in-alt mr-1 lg:mr-1.5 2xl:mr-2 text-sm 2xl:text-sm"></i>
                                <span class="text-sm 2xl:text-sm font-medium">{{ __('Connexion') }}</span>
                            </a>
                            <a href="{{ route('register.client') }}" 
                               class="hidden lg:flex items-center btn-primary text-white px-3 lg:px-4 2xl:px-6 py-2 lg:py-2.5 2xl:py-3 rounded-lg font-semibold whitespace-nowrap">
                                <i class="fas fa-box mr-1 lg:mr-1.5 2xl:mr-2 text-sm 2xl:text-sm"></i>
                                <span class="text-sm 2xl:text-sm">{{ __('Faire une demande') }}</span>
                            </a>
                        </div>
                    @endauth
                    
                    <!-- Menu mobile button -->
                    <button id="mobile-menu-button" class="lg:hidden flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-300 ml-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Menu mobile -->
            <div id="mobile-menu" class="lg:hidden hidden mobile-menu-bg py-2 sm:py-4 animate-slide-down rounded-b-xl border-t border-gray-100">
                <div class="space-y-0.5 sm:space-y-1">
                    <a href="{{ route('accueil') }}" 
                       class="flex items-center px-3 sm:px-4 py-2 sm:py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300 text-sm sm:text-base {{ request()->routeIs('accueil') ? 'text-gray-900 bg-gray-50' : '' }}">
                        <i class="fas fa-home mr-2 sm:mr-3 w-4 sm:w-5 text-center text-gray-500 text-xs sm:text-sm"></i>
                        {{ __('Accueil') }}
                    </a>
                    <a href="{{ route('services') }}" 
                       class="flex items-center px-3 sm:px-4 py-2 sm:py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300 text-sm sm:text-base {{ request()->routeIs('services') ? 'text-gray-900 bg-gray-50' : '' }}">
                        <i class="fas fa-shipping-fast mr-2 sm:mr-3 w-4 sm:w-5 text-center text-gray-500 text-xs sm:text-sm"></i>
                        {{ __('Services') }}
                    </a>
                    <a href="{{ route('apropos') }}" 
                       class="flex items-center px-3 sm:px-4 py-2 sm:py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300 text-sm sm:text-base {{ request()->routeIs('apropos') ? 'text-gray-900 bg-gray-50' : '' }}">
                        <i class="fas fa-info-circle mr-2 sm:mr-3 w-4 sm:w-5 text-center text-gray-500 text-xs sm:text-sm"></i>
                        {{ __('À Propos') }}
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="flex items-center px-3 sm:px-4 py-2 sm:py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300 text-sm sm:text-base {{ request()->routeIs('contact') ? 'text-gray-900 bg-gray-50' : '' }}">
                        <i class="fas fa-envelope mr-2 sm:mr-3 w-4 sm:w-5 text-center text-gray-500 text-xs sm:text-sm"></i>
                        {{ __('Contact') }}
                    </a>
                    <a href="{{ route('blog.index') }}" 
                       class="flex items-center px-3 sm:px-4 py-2 sm:py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300 text-sm sm:text-base {{ request()->routeIs('blog.*') ? 'text-gray-900 bg-gray-50' : '' }}">
                        <i class="fas fa-newspaper mr-2 sm:mr-3 w-4 sm:w-5 text-center text-gray-500 text-xs sm:text-sm"></i>
                        {{ __('Actualités') }}
                    </a>
                    <a href="{{ route('galerie.index') }}" 
                       class="flex items-center px-3 sm:px-4 py-2 sm:py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300 text-sm sm:text-base {{ request()->routeIs('galerie.*') ? 'text-gray-900 bg-gray-50' : '' }}">
                        <i class="fas fa-images mr-2 sm:mr-3 w-4 sm:w-5 text-center text-gray-500 text-xs sm:text-sm"></i>
                        {{ __('Galerie') }}
                    </a>
                    <a href="{{ route('suivi.public') }}" 
                       class="flex items-center px-3 sm:px-4 py-2 sm:py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300 text-sm sm:text-base">
                        <i class="fas fa-search mr-2 sm:mr-3 w-4 sm:w-5 text-center text-gray-500 text-xs sm:text-sm"></i>
                        {{ __('Suivre un colis') }}
                    </a>

                    <!-- Language Selector Mobile -->
                    <div class="sm:hidden border-t border-gray-200 pt-2 mt-2">
                        <div class="px-3 py-2">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ __('Langue') }}</p>
                            <x-language-selector-url />
                        </div>
                    </div>
                    
                    @auth
                        <!-- Section utilisateur connecté -->
                        <div class="border-t border-gray-200 pt-2 sm:pt-3 mt-2 sm:mt-3 space-y-0.5 sm:space-y-1">
                            <div class="px-3 sm:px-4 py-1 sm:py-2">
                                <p class="text-xs sm:text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 mt-0.5 sm:mt-1 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            
                            <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" 
                               class="flex items-center px-3 sm:px-4 py-2 sm:py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300 text-sm sm:text-base">
                                <i class="fas fa-tachometer-alt mr-2 sm:mr-3 w-4 sm:w-5 text-center text-gray-500 text-xs sm:text-sm"></i>
                                {{ __('Mon espace') }}
                            </a>
                            <a href="#" class="flex items-center px-3 sm:px-4 py-2 sm:py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300 text-sm sm:text-base">
                                <i class="fas fa-user mr-2 sm:mr-3 w-4 sm:w-5 text-center text-gray-500 text-xs sm:text-sm"></i>
                                {{ __('Mon profil') }}
                            </a>
                            <a href="#" class="flex items-center px-3 sm:px-4 py-2 sm:py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300 text-sm sm:text-base">
                                <i class="fas fa-cog mr-2 sm:mr-3 w-4 sm:w-5 text-center text-gray-500 text-xs sm:text-sm"></i>
                                {{ __('Paramètres') }}
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center w-full px-3 sm:px-4 py-2 sm:py-3 text-red-600 hover:text-red-700 hover:bg-red-50 font-medium rounded-lg transition-all duration-300 text-sm sm:text-base">
                                    <i class="fas fa-sign-out-alt mr-2 sm:mr-3 w-4 sm:w-5 text-center text-xs sm:text-sm"></i>
                                    {{ __('Déconnexion') }}
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- Section utilisateur non connecté -->
                        <div class="border-t border-gray-200 pt-2 sm:pt-3 mt-2 sm:mt-3 space-y-1 sm:space-y-2">
                            <a href="{{ route('login') }}" 
                               class="flex items-center px-3 sm:px-4 py-2 sm:py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 font-medium rounded-lg transition-all duration-300 text-sm sm:text-base">
                                <i class="fas fa-sign-in-alt mr-2 sm:mr-3 w-4 sm:w-5 text-center text-gray-500 text-xs sm:text-sm"></i>
                                {{ __('Connexion') }}
                            </a>
                            <a href="{{ route('register.client') }}" 
                               class="flex items-center justify-center btn-primary text-white px-3 sm:px-4 py-2 sm:py-3 rounded-lg font-semibold transition-all duration-300 mx-3 sm:mx-4 text-sm sm:text-base">
                                <i class="fas fa-box mr-1 sm:mr-2 text-xs sm:text-sm"></i>
                                {{ __('Faire une demande') }}
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