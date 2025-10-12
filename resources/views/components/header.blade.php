<!-- Header/Navigation -->
<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('accueil') }}" class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-900 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                        <span class="text-white font-bold text-xl">N</span>
                    </div>
                    <span class="text-2xl font-bold text-gray-900">NIFA</span>
                </a>
            </div>
            
            <!-- Navigation Desktop -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('accueil') }}" 
                   class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('accueil') ? 'text-blue-600' : '' }}">
                    Accueil
                </a>
                <a href="{{ route('services') }}" 
                   class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('services') ? 'text-blue-600' : '' }}">
                    Services
                </a>
                <a href="{{ route('apropos') }}" 
                   class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('apropos') ? 'text-blue-600' : '' }}">
                    À propos
                </a>
                <a href="{{ route('contact') }}" 
                   class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('contact') ? 'text-blue-600' : '' }}">
                    Contact
                </a>
            </nav>
            
            <!-- CTA Buttons -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('suivi.public') }}" 
                   class="text-gray-700 hover:text-blue-600 font-medium transition-colors hidden md:block">
                    <i class="fas fa-search mr-1"></i> Suivre un colis
                </a>
                
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" 
                           class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors">
                            <i class="fas fa-tachometer-alt mr-2"></i> Admin
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" 
                           class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors">
                            <i class="fas fa-user mr-2"></i> Mon espace
                        </a>
                    @endif
                    
                    <!-- Menu utilisateur -->
                    <div class="relative">
                        <button id="user-menu-button" 
                                class="flex items-center text-gray-700 hover:text-blue-600 transition-colors">
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-2">
                                <i class="fas fa-user text-gray-600 text-sm"></i>
                            </div>
                            <span class="hidden md:block">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>
                        
                        <!-- Dropdown menu -->
                        <div id="user-menu" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden">
                            <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Profil
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i> Paramètres
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" 
                       class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                        <i class="fas fa-sign-in-alt mr-1"></i> Connexion
                    </a>
                    <a href="{{ route('register') }}" 
                       class="bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white px-6 py-2 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                        Faire une demande
                    </a>
                @endauth
                
                <!-- Menu mobile button -->
                <button id="mobile-menu-button" class="md:hidden text-gray-700 hover:text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Menu mobile -->
        <div id="mobile-menu" class="md:hidden hidden border-t border-gray-200 py-4">
            <div class="space-y-2">
                <a href="{{ route('accueil') }}" 
                   class="block text-gray-700 hover:text-blue-600 font-medium py-2 {{ request()->routeIs('accueil') ? 'text-blue-600' : '' }}">
                    Accueil
                </a>
                <a href="{{ route('services') }}" 
                   class="block text-gray-700 hover:text-blue-600 font-medium py-2 {{ request()->routeIs('services') ? 'text-blue-600' : '' }}">
                    Services
                </a>
                <a href="{{ route('apropos') }}" 
                   class="block text-gray-700 hover:text-blue-600 font-medium py-2 {{ request()->routeIs('apropos') ? 'text-blue-600' : '' }}">
                    À propos
                </a>
                <a href="{{ route('contact') }}" 
                   class="block text-gray-700 hover:text-blue-600 font-medium py-2 {{ request()->routeIs('contact') ? 'text-blue-600' : '' }}">
                    Contact
                </a>
                <a href="{{ route('suivi.public') }}" 
                   class="block text-gray-700 hover:text-blue-600 font-medium py-2">
                    <i class="fas fa-search mr-2"></i> Suivre un colis
                </a>
                
                @auth
                    <div class="border-t border-gray-200 pt-2 mt-2">
                        <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" 
                           class="block text-gray-700 hover:text-blue-600 font-medium py-2">
                            <i class="fas fa-tachometer-alt mr-2"></i> Mon espace
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="block w-full text-left text-red-600 hover:text-red-800 font-medium py-2">
                                <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                            </button>
                        </form>
                    </div>
                @else
                    <div class="border-t border-gray-200 pt-2 mt-2 space-y-2">
                        <a href="{{ route('login') }}" 
                           class="block text-gray-700 hover:text-blue-600 font-medium py-2">
                            <i class="fas fa-sign-in-alt mr-2"></i> Connexion
                        </a>
                        <a href="{{ route('register') }}" 
                           class="block bg-gradient-to-r from-red-600 to-red-500 text-white px-4 py-2 rounded-lg font-semibold text-center">
                            Faire une demande
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</header>

<script>
    // Menu mobile toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');
        
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }
        
        if (userMenuButton && userMenu) {
            userMenuButton.addEventListener('click', function() {
                userMenu.classList.toggle('hidden');
            });
            
            // Fermer le menu si on clique ailleurs
            document.addEventListener('click', function(event) {
                if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                    userMenu.classList.add('hidden');
                }
            });
        }
    });
</script>
