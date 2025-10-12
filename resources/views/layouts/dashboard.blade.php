<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - NIFA')</title>
    <meta name="description" content="@yield('description', 'Espace client NIFA - Gérez vos demandes de transport et suivez vos envois.')">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    
    <!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-blue: #1e3a8a;
            --secondary-blue: #3b82f6;
            --accent-red: #dc2626;
            --light-blue: #eff6ff;
            --sidebar-width: 280px;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            transform: translateX(0);
            transition: transform 0.3s ease-in-out;
            background: linear-gradient(135deg, var(--primary-blue) 0%, #1e40af 50%, var(--secondary-blue) 100%);
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar.hidden {
            transform: translateX(-100%);
        }
        
        .sidebar-overlay {
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease-in-out;
        }
        
        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        /* Main content adjustment */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease-in-out;
            min-height: 100vh;
        }
        
        .main-content.expanded {
            margin-left: 0;
        }
        
        /* Menu item styles */
        .menu-item {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            margin: 0.25rem 0.75rem;
        }
        
        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(4px);
        }
        
        .menu-item.active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #fbbf24;
        }
        
        /* Burger button */
        .burger-btn {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
            transition: all 0.3s ease;
        }
        
        .burger-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }
        
        /* Dashboard cards */
        .dashboard-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        
        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1);
        }
        
        /* Gradient backgrounds */
        .gradient-bg-dashboard {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.95) 0%, rgba(220, 38, 38, 0.9) 100%);
        }
        
        /* Bannières avec images de fond pour dashboard */
        .hero-bg-contact {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.9) 0%, rgba(220, 38, 38, 0.8) 100%),
                        url('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            position: relative;
        }
        
        .hero-bg-services {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.9) 0%, rgba(220, 38, 38, 0.8) 100%),
                        url('https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            position: relative;
        }
        
        .hero-bg-tracking {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.9) 0%, rgba(220, 38, 38, 0.8) 100%),
                        url('https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            position: relative;
        }
        
        .hero-bg-about {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.9) 0%, rgba(220, 38, 38, 0.8) 100%),
                        url('https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            position: relative;
        }
        
        .hero-bg-home {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.9) 0%, rgba(220, 38, 38, 0.8) 100%),
                        url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            position: relative;
        }
        
        .hero-bg-transport {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.9) 0%, rgba(220, 38, 38, 0.8) 100%),
                        url('https://images.unsplash.com/photo-1494412574643-ff11b0a5c1c3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            position: relative;
        }
        
        /* Overlay animé */
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, 
                rgba(30, 58, 138, 0.3) 0%, 
                rgba(220, 38, 38, 0.2) 25%, 
                rgba(59, 130, 246, 0.3) 50%, 
                rgba(220, 38, 38, 0.2) 75%, 
                rgba(30, 58, 138, 0.3) 100%);
            background-size: 400% 400%;
            animation: gradientShift 8s ease-in-out infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Particules flottantes */
        .hero-particles {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            overflow: hidden;
        }
        
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 20%; animation-delay: 1s; }
        .particle:nth-child(3) { left: 30%; animation-delay: 2s; }
        .particle:nth-child(4) { left: 40%; animation-delay: 3s; }
        .particle:nth-child(5) { left: 50%; animation-delay: 4s; }
        .particle:nth-child(6) { left: 60%; animation-delay: 5s; }
        .particle:nth-child(7) { left: 70%; animation-delay: 0.5s; }
        .particle:nth-child(8) { left: 80%; animation-delay: 1.5s; }
        .particle:nth-child(9) { left: 90%; animation-delay: 2.5s; }
        
        @keyframes float {
            0%, 100% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-10vh) rotate(360deg); opacity: 0; }
        }
        
        /* Texte hero avec effet */
        .hero-title {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #ffffff 0%, rgba(255, 255, 255, 0.8) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-subtitle {
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }
        
        /* Responsive breakpoints */
        @media (max-width: 1024px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                z-index: 50;
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
        
        /* Animations */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .slide-in-left {
            animation: slideInLeft 0.5s ease-out;
        }
        
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Status badges */
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .status-en-attente { background: #fef3c7; color: #92400e; }
        .status-en-cours { background: #dbeafe; color: #1e40af; }
        .status-livree { background: #d1fae5; color: #065f46; }
        .status-annulee { background: #fee2e2; color: #991b1b; }
        
        /* Notification styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            max-width: 400px;
            animation: slideInRight 0.3s ease-out;
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebar-overlay" class="sidebar-overlay fixed inset-0 z-40 lg:hidden"></div>
    
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar fixed top-0 left-0 h-full z-50 lg:z-30">
        <div class="flex flex-col h-full text-white">
            <!-- Logo -->
            <div class="flex items-center justify-between p-6 border-b border-white border-opacity-20">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                        <span class="text-white font-bold text-lg">N</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">NIFA</h1>
                        <p class="text-xs text-blue-200">
                            @if(Auth::user()->isAdmin())
                                Administration
                            @else
                                Espace Client
                            @endif
                        </p>
                    </div>
                </div>
                
                <!-- Close button (Mobile) -->
                <button id="sidebar-close" class="lg:hidden text-white hover:text-gray-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- User Info -->
            <div class="p-6 border-b border-white border-opacity-20">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-user text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="font-semibold">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-blue-200">{{ Auth::user()->email }}</p>
                        <span class="inline-block mt-1 px-2 py-1 bg-white bg-opacity-20 rounded-full text-xs">
                            @if(Auth::user()->isAdmin())
                                👨‍💼 Administrateur
                            @else
                                👤 Client
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Menu -->
            <nav class="flex-1 py-6 overflow-y-auto">
                @if(Auth::user()->isAdmin())
                    <!-- Menu Admin -->
                    <div class="px-3">
                        <p class="text-xs font-semibold text-blue-200 uppercase tracking-wider mb-3 px-3">
                            Administration
                        </p>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="menu-item flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-10 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt mr-3 text-lg"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.demandes.index') }}" 
                           class="menu-item flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-10 rounded-lg {{ request()->routeIs('admin.demandes.*') ? 'active' : '' }}">
                            <i class="fas fa-boxes mr-3 text-lg"></i>
                            <span>Demandes</span>
                            @if(isset($pending_count) && $pending_count > 0)
                                <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                    {{ $pending_count }}
                                </span>
                            @endif
                        </a>
                        <a href="{{ route('admin.clients.index') }}" 
                           class="menu-item flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-10 rounded-lg {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                            <i class="fas fa-users mr-3 text-lg"></i>
                            <span>Clients</span>
                        </a>
                    </div>
                @else
                    <!-- Menu Client -->
                    <div class="px-3">
                        <p class="text-xs font-semibold text-blue-200 uppercase tracking-wider mb-3 px-3">
                            Mon Espace
                        </p>
                        <a href="{{ route('dashboard') }}" 
                           class="menu-item flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-10 rounded-lg {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-home mr-3 text-lg"></i>
                            <span>Accueil</span>
                        </a>
                        <a href="{{ route('demande.create') }}" 
                           class="menu-item flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-10 rounded-lg {{ request()->routeIs('demande.create') ? 'active' : '' }}">
                            <i class="fas fa-plus-circle mr-3 text-lg"></i>
                            <span>Nouvelle Demande</span>
                        </a>
                        <a href="{{ route('mes-demandes.index') }}" 
                           class="menu-item flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-10 rounded-lg {{ request()->routeIs('mes-demandes*') ? 'active' : '' }}">
                            <i class="fas fa-list mr-3 text-lg"></i>
                            <span>Mes Demandes</span>
                        </a>
                    </div>
                @endif
                
                <!-- Menu commun -->
                <div class="px-3 mt-8">
                    <p class="text-xs font-semibold text-blue-200 uppercase tracking-wider mb-3 px-3">
                        Général
                    </p>
                    <a href="{{ route('accueil') }}" 
                       class="menu-item flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                        <i class="fas fa-globe mr-3 text-lg"></i>
                        <span>Site Public</span>
                        <i class="fas fa-external-link-alt ml-auto text-sm"></i>
                    </a>
                    <a href="{{ route('suivi.public') }}" 
                       class="menu-item flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                        <i class="fas fa-search mr-3 text-lg"></i>
                        <span>Suivi Public</span>
                    </a>
                </div>
            </nav>
            
            <!-- Footer -->
            <div class="p-6 border-t border-white border-opacity-20">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center px-4 py-3 text-white hover:bg-red-600 hover:bg-opacity-20 rounded-lg transition-colors">
                        <i class="fas fa-sign-out-alt mr-3 text-lg"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
                
                <div class="mt-4 text-center">
                    <p class="text-xs text-blue-200">
                        © {{ date('Y') }} NIFA
                    </p>
                </div>
            </div>
        </div>
    </aside>
    
    <!-- Main Content -->
    <div id="main-content" class="main-content">
        <!-- Top Header -->
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-20">
            <div class="flex items-center justify-between px-6 py-4">
                <!-- Burger Menu -->
                <button id="burger-btn" class="burger-btn lg:hidden w-10 h-10 rounded-lg text-white flex items-center justify-center">
                    <i class="fas fa-bars"></i>
                </button>
                
                <!-- Page Title -->
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-gray-900">
                        @yield('page-title', 'Dashboard')
                    </h1>
                </div>
                
                <!-- Header Actions -->
                <div class="flex items-center space-x-4">
                    @livewire('notification-bell')
                    
                    <!-- User Menu -->
                    <div class="relative">
                        <button id="user-menu-btn" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-semibold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                        </button>
                        
                        <!-- Dropdown -->
                        <div id="user-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden">
                            <div class="p-3 border-b border-gray-100">
                                <p class="font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="py-2">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i> Profil
                                </a>
                                <a href="{{ route('notifications.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-bell mr-2"></i> Notifications
                                    <span id="unread-count" class="ml-auto inline-flex items-center justify-center h-5 w-5 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                    </span>
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i> Paramètres
                                </a>
                                <div class="border-t border-gray-100 mt-2 pt-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Messages de notification -->
        @if(session('success'))
            <div class="notification bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg" role="alert">
                <div class="flex">
                    <span class="text-xl mr-3">✅</span>
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-green-700 hover:text-green-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="notification bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg" role="alert">
                <div class="flex">
                    <span class="text-xl mr-3">❌</span>
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-red-700 hover:text-red-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif
        
        <!-- Page Content -->
        <main class="p-6">
            @yield('content')
        </main>
    </div>
    
    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const mainContent = document.getElementById('main-content');
            const burgerBtn = document.getElementById('burger-btn');
            const sidebarClose = document.getElementById('sidebar-close');
            const userMenuBtn = document.getElementById('user-menu-btn');
            const userMenu = document.getElementById('user-menu');
            
            // Toggle sidebar on mobile
            function toggleSidebar() {
                if (window.innerWidth <= 1024) {
                    sidebar.classList.toggle('active');
                    sidebarOverlay.classList.toggle('active');
                } else {
                    sidebar.classList.toggle('hidden');
                    mainContent.classList.toggle('expanded');
                }
            }
            
            // Close sidebar
            function closeSidebar() {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            }
            
            // Event listeners
            if (burgerBtn) {
                burgerBtn.addEventListener('click', toggleSidebar);
            }
            
            if (sidebarClose) {
                sidebarClose.addEventListener('click', closeSidebar);
            }
            
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebar);
            }
            
            // User menu toggle
            if (userMenuBtn && userMenu) {
                userMenuBtn.addEventListener('click', function() {
                    userMenu.classList.toggle('hidden');
                });
                
                document.addEventListener('click', function(event) {
                    if (!userMenuBtn.contains(event.target) && !userMenu.contains(event.target)) {
                        userMenu.classList.add('hidden');
                    }
                });
            }
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 1024) {
                    closeSidebar();
                    sidebar.classList.remove('hidden');
                    mainContent.classList.remove('expanded');
                }
            });
            
            // Animation au défilement
            const fadeElements = document.querySelectorAll('.fade-in');
            
            const fadeInOnScroll = function() {
                fadeElements.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    const elementVisible = 150;
                    
                    if (elementTop < window.innerHeight - elementVisible) {
                        element.classList.add('visible');
                    }
                });
            };
            
            window.addEventListener('scroll', fadeInOnScroll);
            fadeInOnScroll();
            
            // Auto-hide notifications
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notification => {
                setTimeout(() => {
                    notification.style.animation = 'slideOutRight 0.3s ease-out forwards';
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }, 5000);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
