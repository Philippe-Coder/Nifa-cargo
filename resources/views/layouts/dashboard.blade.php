<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - NIF CARGO')</title>
    <meta name="description" content="@yield('description', 'Espace client NIF CARGO - Gérez vos demandes de transport et suivez vos envois.')">
    
    <!-- Favicon et icônes -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/logo.png') }}">
    
    <!-- Métadonnées Open Graph pour les réseaux sociaux -->
    <meta property="og:title" content="@yield('title', 'Dashboard - NIF CARGO')">
    <meta property="og:description" content="@yield('description', 'Espace client NIF CARGO - Gérez vos demandes de transport et suivez vos envois.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="NIF Cargo">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="fr_FR">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Dashboard - NIF CARGO')">
    <meta name="twitter:description" content="@yield('description', 'Espace client NIF CARGO - Gérez vos demandes de transport et suivez vos envois.')">
    <meta name="twitter:image" content="{{ asset('images/logo.png') }}">
    
    <!-- Métadonnées supplémentaires pour SEO -->
    <meta name="robots" content="noindex, nofollow">
    <meta name="author" content="NIF Cargo">
    <meta name="theme-color" content="#1e3a8a">
    
    <!-- Web App Manifest -->
    <link rel="manifest" href="/manifest.json">
    
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
            --sidebar-collapsed-width: 70px;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            font-size: 14px;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            transform: translateX(0);
            transition: all 0.3s ease-in-out;
            background: linear-gradient(135deg, var(--primary-blue) 0%, #1e40af 50%, var(--secondary-blue) 100%);
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 50;
        }
        
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
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
        
        .main-content.collapsed {
            margin-left: var(--sidebar-collapsed-width);
        }
        
        /* Menu item styles */
        .menu-item {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            margin: 0.25rem 0.75rem;
            white-space: nowrap;
            overflow: hidden;
        }
        
        .sidebar.collapsed .menu-item span,
        .sidebar.collapsed .menu-item .menu-text,
        .sidebar.collapsed .nav-section p,
        .sidebar.collapsed .user-info-text,
        .sidebar.collapsed .logo-text {
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
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
        
        /* Navigation responsive - SUPPRESSION DU SCROLL */
        .nav-container {
            display: flex;
            flex-direction: column;
            height: auto;
            overflow: visible;
        }
        
        .nav-section {
            margin-bottom: 1.5rem;
        }
        
        /* Responsive breakpoints */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .sidebar.collapsed {
                width: var(--sidebar-width);
            }
            
            .sidebar.collapsed .menu-item span,
            .sidebar.collapsed .menu-item .menu-text,
            .sidebar.collapsed .nav-section p,
            .sidebar.collapsed .user-info-text,
            .sidebar.collapsed .logo-text {
                opacity: 1;
                visibility: visible;
            }
        }
        
        @media (max-width: 768px) {
            body {
                font-size: 13px;
            }
            
            .sidebar {
                width: 100%;
            }
            
            .menu-item {
                margin: 0.2rem 0.5rem;
                padding: 0.75rem 1rem;
            }
        }
        
        @media (max-width: 480px) {
            body {
                font-size: 12px;
            }
            
            .menu-item {
                margin: 0.15rem 0.25rem;
                padding: 0.6rem 0.8rem;
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
        
        /* Toggle sidebar button */
        .toggle-sidebar {
            position: absolute;
            right: -12px;
            top: 20px;
            background: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            z-index: 10;
        }
        
        .toggle-sidebar i {
            font-size: 12px;
            color: var(--primary-blue);
            transition: transform 0.3s ease;
        }
        
        /* Styles pour le menu réduit */
        .collapsed-menu-icon {
            display: none;
        }
        
        .sidebar.collapsed .collapsed-menu-icon {
            display: flex;
            justify-content: center;
            width: 100%;
        }
        
        .sidebar.collapsed .default-menu-content {
            display: none;
        }
        
        /* Menu burger pour état réduit */
        .menu-burger-reduced {
            display: none;
        }
        
        .sidebar.collapsed .menu-burger-reduced {
            display: flex;
            justify-content: center;
            padding: 1rem;
            cursor: pointer;
        }
        
        .menu-burger-reduced i {
            color: white;
            font-size: 1.5rem;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebar-overlay" class="sidebar-overlay fixed inset-0 z-40 lg:hidden"></div>
    
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar">
        <div class="flex flex-col h-full text-white">
            <!-- Logo -->
            <div class="flex items-center justify-between p-4 border-b border-white border-opacity-20 relative">
                <div class="flex items-center transition-all duration-300 default-menu-content">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3">
                        <img src="{{ asset('images/logo.png') }}" alt="NIF CARGO" class="w-10 h-12 object-contain">
                    </div>
                    <div class="transition-all duration-300 logo-text">
                        <h1 class="text-xl font-bold">NIF CARGO</h1>
                        <p class="text-xs text-blue-200">
                            @if(Auth::user()->isAdmin())
                                Administration
                            @else
                                Espace Client
                            @endif
                        </p>
                    </div>
                </div>
                
                <!-- Logo réduit -->
                <div class="collapsed-menu-icon">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                        <img src="{{ asset('images/logo.png') }}" alt="NIF CARGO" class="w-10 h-12 object-contain">
                    </div>
                </div>
                
                <!-- Toggle sidebar button (Desktop) -->
                <button id="toggle-sidebar" class="toggle-sidebar hidden lg:flex">
                    <i class="fas fa-chevron-left"></i>
                </button>
                
                <!-- Close button (Mobile) -->
                <button id="sidebar-close" class="lg:hidden text-white hover:text-gray-300 default-menu-content">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- User Info -->
            <div class="p-4 border-b border-white border-opacity-20">
                <div class="flex items-center default-menu-content">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-user text-white text-base"></i>
                    </div>
                    <div class="transition-all duration-300 user-info-text">
                        <p class="font-semibold text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-blue-200 truncate">{{ Auth::user()->email }}</p>
                        <span class="inline-block mt-1 px-2 py-1 bg-white bg-opacity-20 rounded-full text-xs">
                            @if(Auth::user()->isAdmin())
                                Admin
                            @else
                                Client
                            @endif
                        </span>
                    </div>
                </div>
                
                <!-- Burger menu pour état réduit -->
                <div class="menu-burger-reduced" id="expand-sidebar">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
            
            <!-- Navigation Menu - SUPPRESSION DU SCROLL -->
            <div class="nav-container">
                <nav class="flex-1 py-4">
                    @if(Auth::user()->isAdmin())
                        <!-- Menu Admin -->
                        <div class="nav-section default-menu-content">
                            <p class="text-xs font-semibold text-blue-200 uppercase tracking-wider mb-2 px-4">
                                Administration
                            </p>
                            <a href="{{ route('admin.dashboard') }}" 
                               class="menu-item flex items-center px-4 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-tachometer-alt mr-3 text-base"></i>
                                <span class="menu-text">Dashboard</span>
                            </a>
                            <a href="{{ route('admin.demandes.index') }}" 
                               class="menu-item flex items-center px-4 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded-lg {{ request()->routeIs('admin.demandes.index') || request()->routeIs('admin.demandes.show') ? 'active' : '' }}">
                                <i class="fas fa-boxes mr-3 text-base"></i>
                                <span class="menu-text">Gestion Demandes</span>
                                @if(isset($pending_count) && $pending_count > 0)
                                    <span class="ml-auto bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full min-w-[20px] text-center">
                                        {{ $pending_count }}
                                    </span>
                                @endif
                            </a>
                            <a href="{{ route('admin.demandes.create-admin') }}" 
                               class="menu-item flex items-center px-4 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded-lg {{ request()->routeIs('admin.demandes.create-admin') ? 'active' : '' }}">
                                <i class="fas fa-plus-circle mr-3 text-base"></i>
                                <span class="menu-text">Créer Demande Client</span>
                            </a>
                            <a href="{{ route('admin.clients.index') }}" 
                               class="menu-item flex items-center px-4 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded-lg {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                                <i class="fas fa-users mr-3 text-base"></i>
                                <span class="menu-text">Clients</span>
                            </a>
                        </div>
                    @else
                        <!-- Menu Client -->
                        <div class="nav-section default-menu-content">
                            <p class="text-xs font-semibold text-blue-200 uppercase tracking-wider mb-2 px-4">
                                Mon Espace
                            </p>
                            <a href="{{ route('dashboard') }}" 
                               class="menu-item flex items-center px-4 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded-lg {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="fas fa-home mr-3 text-base"></i>
                                <span class="menu-text">Accueil</span>
                            </a>
                            <a href="{{ route('demande.create') }}" 
                               class="menu-item flex items-center px-4 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded-lg {{ request()->routeIs('demande.create') ? 'active' : '' }}">
                                <i class="fas fa-plus-circle mr-3 text-base"></i>
                                <span class="menu-text">Nouvelle Demande</span>
                            </a>
                            <a href="{{ route('mes-demandes.index') }}" 
                               class="menu-item flex items-center px-4 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded-lg {{ request()->routeIs('mes-demandes*') ? 'active' : '' }}">
                                <i class="fas fa-list mr-3 text-base"></i>
                                <span class="menu-text">Mes Demandes</span>
                            </a>
                        </div>
                    @endif
                    
                    <!-- Menu commun -->
                    <div class="nav-section default-menu-content">
                        <p class="text-xs font-semibold text-blue-200 uppercase tracking-wider mb-2 px-4">
                            Général
                        </p>
                        <a href="{{ route('accueil') }}" 
                           class="menu-item flex items-center px-4 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                            <i class="fas fa-globe mr-3 text-base"></i>
                            <span class="menu-text">Site Public</span>
                            <i class="fas fa-external-link-alt ml-auto text-xs"></i>
                        </a>
                        <a href="{{ route('suivi.public') }}" 
                           class="menu-item flex items-center px-4 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                            <i class="fas fa-search mr-3 text-base"></i>
                            <span class="menu-text">Suivi Public</span>
                        </a>
                    </div>
                </nav>
            </div>
            
            <!-- Footer -->
            <div class="p-4 border-t border-white border-opacity-20 mt-auto default-menu-content">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center px-4 py-2 text-white hover:bg-red-600 hover:bg-opacity-20 rounded-lg transition-colors">
                        <i class="fas fa-sign-out-alt mr-3 text-base"></i>
                        <span class="menu-text">Déconnexion</span>
                    </button>
                </form>
                
                <div class="mt-3 text-center">
                    <p class="text-xs text-blue-200">
                        © {{ date('Y') }} NIF
                    </p>
                </div>
            </div>
            
            <!-- Footer réduit -->
            <div class="p-4 border-t border-white border-opacity-20 mt-auto collapsed-menu-icon">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center justify-center text-white hover:bg-red-600 hover:bg-opacity-20 rounded-lg transition-colors py-2">
                        <i class="fas fa-sign-out-alt text-base"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>
    
    <!-- Main Content -->
    <div id="main-content" class="main-content">
        <!-- Top Header -->
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-20">
            <div class="flex items-center justify-between px-4 py-3">
                <!-- Burger Menu -->
                <button id="burger-btn" class="burger-btn lg:hidden w-9 h-9 rounded-lg text-white flex items-center justify-center">
                    <i class="fas fa-bars"></i>
                </button>
                
                <!-- Page Title -->
                <div class="flex items-center">
                    <h1 class="text-lg font-semibold text-gray-900">
                        @yield('page-title', 'Dashboard')
                    </h1>
                </div>
                
                <!-- Header Actions -->
                <div class="flex items-center space-x-3">
                    @livewire('notification-bell')
                    
                    <!-- User Menu -->
                    <div class="relative">
                        <button id="user-menu-btn" class="flex items-center space-x-2 p-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="w-7 h-7 bg-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-xs font-semibold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </button>
                        
                        <!-- Dropdown -->
                        <div id="user-menu" class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg border border-gray-200 hidden">
                            <div class="p-2 border-b border-gray-100">
                                <p class="font-semibold text-gray-900 text-sm">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i> Profil
                                </a>
                                <a href="{{ route('notifications.index') }}" class="flex items-center px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-bell mr-2"></i> Notifications
                                    <span id="unread-count" class="ml-auto inline-flex items-center justify-center h-4 w-4 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                    </span>
                                </a>
                                <a href="#" class="block px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i> Paramètres
                                </a>
                                <div class="border-t border-gray-100 mt-1 pt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-3 py-2 text-xs text-red-600 hover:bg-gray-100">
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
                    <span class="text-sm">{{ session('success') }}</span>
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
                    <span class="text-sm">{{ session('error') }}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-red-700 hover:text-red-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif
        
        <!-- Page Content -->
        <main class="p-4">
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
            const toggleSidebarBtn = document.getElementById('toggle-sidebar');
            const expandSidebarBtn = document.getElementById('expand-sidebar');
            const userMenuBtn = document.getElementById('user-menu-btn');
            const userMenu = document.getElementById('user-menu');
            
            // Check if sidebar should be collapsed by default on small screens
            function checkSidebarState() {
                if (window.innerWidth <= 1024) {
                    sidebar.classList.add('hidden');
                    mainContent.classList.remove('collapsed');
                } else {
                    // On desktop, check localStorage for collapsed state
                    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                    if (isCollapsed) {
                        sidebar.classList.add('collapsed');
                        mainContent.classList.add('collapsed');
                        toggleSidebarBtn.querySelector('i').classList.remove('fa-chevron-left');
                        toggleSidebarBtn.querySelector('i').classList.add('fa-chevron-right');
                    } else {
                        sidebar.classList.remove('collapsed');
                        mainContent.classList.remove('collapsed');
                        toggleSidebarBtn.querySelector('i').classList.remove('fa-chevron-right');
                        toggleSidebarBtn.querySelector('i').classList.add('fa-chevron-left');
                    }
                }
            }
            
            // Toggle sidebar on mobile
            function toggleSidebar() {
                if (window.innerWidth <= 1024) {
                    sidebar.classList.toggle('active');
                    sidebarOverlay.classList.toggle('active');
                }
            }
            
            // Toggle sidebar collapsed state on desktop
            function toggleSidebarCollapsed() {
                if (window.innerWidth > 1024) {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('collapsed');
                    
                    // Update toggle button icon
                    const icon = toggleSidebarBtn.querySelector('i');
                    if (sidebar.classList.contains('collapsed')) {
                        icon.classList.remove('fa-chevron-left');
                        icon.classList.add('fa-chevron-right');
                        localStorage.setItem('sidebarCollapsed', 'true');
                    } else {
                        icon.classList.remove('fa-chevron-right');
                        icon.classList.add('fa-chevron-left');
                        localStorage.setItem('sidebarCollapsed', 'false');
                    }
                }
            }
            
            // Expand sidebar from collapsed state
            function expandSidebar() {
                if (window.innerWidth > 1024 && sidebar.classList.contains('collapsed')) {
                    toggleSidebarCollapsed();
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
            
            if (toggleSidebarBtn) {
                toggleSidebarBtn.addEventListener('click', toggleSidebarCollapsed);
            }
            
            if (expandSidebarBtn) {
                expandSidebarBtn.addEventListener('click', expandSidebar);
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
                checkSidebarState();
                
                if (window.innerWidth > 1024) {
                    closeSidebar();
                }
            });
            
            // Initialize sidebar state
            checkSidebarState();
            
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