<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'NIF Cargo - Transport et Logistique en Afrique')</title>
    <meta name="description" content="@yield('description', 'NIF Cargo, votre partenaire de confiance pour le transport et la logistique en Afrique. Services de transport maritime, aérien et terrestre.')">

    <!-- Favicon et icônes -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/logo.png') }}">
    
    <!-- Métadonnées Open Graph pour les réseaux sociaux -->
    <meta property="og:title" content="@yield('title', 'NIF Cargo - Transport et Logistique en Afrique')">
    <meta property="og:description" content="@yield('description', 'NIF Cargo, votre partenaire de confiance pour le transport et la logistique en Afrique. Services de transport maritime, aérien et terrestre.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="NIF Cargo">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="fr_FR">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'NIF Cargo - Transport et Logistique en Afrique')">
    <meta name="twitter:description" content="@yield('description', 'NIF Cargo, votre partenaire de confiance pour le transport et la logistique en Afrique. Services de transport maritime, aérien et terrestre.')">
    <meta name="twitter:image" content="{{ asset('images/logo.png') }}">
    
    <!-- Métadonnées supplémentaires pour SEO -->
    <meta name="robots" content="index, follow">
    <meta name="author" content="NIF Cargo">
    <meta name="theme-color" content="#1e3a8a">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Web App Manifest -->
    <link rel="manifest" href="/manifest.json">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles additionnels -->
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .hero-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo -->
                    <a href="{{ route('accueil') }}" class="flex items-center">
                        <img src="{{ asset('img/logo.png') }}" alt="NIF CARGO" class="h-10 w-auto">
                        <span class="ml-2 text-sm text-gray-600 hidden sm:block">Transport & Logistique</span>
                    </a>
                </div>

                <!-- Menu principal -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('accueil') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium {{ request()->routeIs('accueil') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
                        🏠 Accueil
                    </a>
                    <a href="{{ route('services') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium {{ request()->routeIs('services') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
                        🚛 Services
                    </a>
                    <a href="{{ route('suivi.public') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium {{ request()->routeIs('suivi.public') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
                        📦 Suivi
                    </a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium {{ request()->routeIs('contact') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
                        📞 Contact
                    </a>
                </div>

                <!-- Boutons d'action -->
                <div class="flex items-center space-x-4">
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="bg-purple-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-purple-700 transition-colors">
                                👨‍💼 Admin
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700 transition-colors">
                                📊 Mon espace
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                            🔑 Connexion
                        </a>
                        <a href="{{ route('register.client') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition-colors">
                            ✨ S'inscrire
                        </a>
                    @endauth

                    <!-- Menu mobile -->
                    <button id="mobile-menu-button" class="md:hidden text-gray-700 hover:text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu mobile -->
        <div id="mobile-menu" class="md:hidden hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('accueil') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">
                    🏠 Accueil
                </a>
                <a href="{{ route('services') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">
                    🚛 Services
                </a>
                <a href="{{ route('suivi.public') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">
                    📦 Suivi
                </a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">
                    📞 Contact
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- À propos -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">🚢 NIF CARGO</h3>
                    <p class="text-gray-300 text-sm mb-4">
                        Votre partenaire de confiance pour le transport et la logistique en Afrique depuis plus de 10 ans.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Facebook</span>
                            📘
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Twitter</span>
                            🐦
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">LinkedIn</span>
                            💼
                        </a>
                    </div>
                </div>

                <!-- Services -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Nos Services</h3>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="{{ route('services') }}" class="hover:text-white">🚢 Transport Maritime</a></li>
                        <li><a href="{{ route('services') }}" class="hover:text-white">✈️ Transport Aérien</a></li>
                        <li><a href="{{ route('services') }}" class="hover:text-white">🚛 Transport Terrestre</a></li>
                        <li><a href="{{ route('services') }}" class="hover:text-white">📋 Dédouanement</a></li>
                        <li><a href="{{ route('services') }}" class="hover:text-white">🏭 Entreposage</a></li>
                    </ul>
                </div>

                <!-- Liens utiles -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liens Utiles</h3>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="{{ route('suivi.public') }}" class="hover:text-white">Suivre un colis</a></li>
                        <li><a href="{{ route('demande.create') }}" class="hover:text-white">Faire une demande</a></li>
                        <li><a href="{{ route('apropos') }}" class="hover:text-white">ℹÀ propos</a></li>
                        <li><a href="#" class="hover:text-white">Conditions générales</a></li>
                        <li><a href="#" class="hover:text-white">Politique de confidentialité</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <div class="space-y-2 text-sm text-gray-300">
                        <p>Totsi à 100m non loin de l’\église catholique Lomé</p>
                        <p>+228 99 25 25 31</p>
                        <p>+228 99 25 25 31</p>
                        <p>contact@nifgroupecargo.com</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} OGOUBI Komivi Philippe. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Menu mobile toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Smooth scroll pour les ancres
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
