<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NIF Cargo - Transport et Logistique en Afrique')</title>
    <meta name="description" content="@yield('description', 'NIF Cargo, leader du transport et de la logistique en Afrique. Services de transport maritime, aérien et terrestre avec suivi en temps réel.')">
    
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
        }
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, var(--primary-blue) 0%, #1e40af 50%, var(--secondary-blue) 100%);
        }
        
        .hero-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        /* Bannières avec images de fond */
        .hero-bg-home {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.9) 0%, rgba(220, 38, 38, 0.8) 100%),
                        url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            position: relative;
        }
        
        .hero-bg-services {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.9) 0%, rgba(30, 58, 138, 0.8) 100%),
                        url('https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            position: relative;
        }
        
        .hero-bg-contact {
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.9) 0%, rgba(59, 130, 246, 0.8) 100%),
                        url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            position: relative;
        }
        
        .hero-bg-about {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.9) 0%, rgba(220, 38, 38, 0.8) 100%),
                        url('https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            position: relative;
        }
        
        .hero-bg-tracking {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.9) 0%, rgba(220, 38, 38, 0.8) 100%),
                        url('https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
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
            overflow: hidden;
            pointer-events: none;
        }
        
        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float-particle 6s infinite linear;
        }
        
        .particle:nth-child(1) { width: 4px; height: 4px; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 6px; height: 6px; left: 20%; animation-delay: 1s; }
        .particle:nth-child(3) { width: 3px; height: 3px; left: 30%; animation-delay: 2s; }
        .particle:nth-child(4) { width: 5px; height: 5px; left: 40%; animation-delay: 3s; }
        .particle:nth-child(5) { width: 4px; height: 4px; left: 50%; animation-delay: 4s; }
        .particle:nth-child(6) { width: 7px; height: 7px; left: 60%; animation-delay: 5s; }
        .particle:nth-child(7) { width: 3px; height: 3px; left: 70%; animation-delay: 0.5s; }
        .particle:nth-child(8) { width: 5px; height: 5px; left: 80%; animation-delay: 1.5s; }
        .particle:nth-child(9) { width: 4px; height: 4px; left: 90%; animation-delay: 2.5s; }
        
        @keyframes float-particle {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }
        
        /* Texte avec ombre et contraste amélioré */
        .hero-text {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 10;
        }
        
        .hero-title {
            background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: none;
            filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.3));
        }
        
        .hero-subtitle {
            color: rgba(255, 255, 255, 0.95);
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4);
        }
        
        .service-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .btn-primary {
            background: linear-gradient(to right, var(--accent-red), #ef4444);
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(to right, #b91c1c, var(--accent-red));
            box-shadow: 0 10px 15px -3px rgba(220, 38, 38, 0.3);
        }
        
        .btn-secondary {
            background: transparent;
            border: 2px solid white;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: white;
            color: var(--primary-blue);
        }
        
        .process-step {
            position: relative;
        }
        
        .process-step:not(:last-child):after {
            content: "";
            position: absolute;
            top: 40px;
            right: -40px;
            width: 40px;
            height: 2px;
            background: #d1d5db;
        }
        
        @media (max-width: 768px) {
            .process-step:not(:last-child):after {
                display: none;
            }
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Animations personnalisées */
        .slide-in-left {
            animation: slideInLeft 0.6s ease-out;
        }
        
        .slide-in-right {
            animation: slideInRight 0.6s ease-out;
        }
        
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Styles pour les notifications */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            max-width: 400px;
            animation: slideInRight 0.3s ease-out;
        }
        
        .notification.hide {
            animation: slideOutRight 0.3s ease-out forwards;
        }
        
        @keyframes slideOutRight {
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <x-header />
    
    <!-- Messages de notification -->
    @if(session('success'))
        <div class="notification bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg" role="alert">
            <div class="flex">
                <span class="text-xl mr-3">✅</span>
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.parentElement.classList.add('hide')" class="ml-auto text-green-700 hover:text-green-900">
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
                <button onclick="this.parentElement.parentElement.classList.add('hide')" class="ml-auto text-red-700 hover:text-red-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div class="notification bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded shadow-lg" role="alert">
            <div class="flex">
                <span class="text-xl mr-3">⚠️</span>
                <span>{{ session('warning') }}</span>
                <button onclick="this.parentElement.parentElement.classList.add('hide')" class="ml-auto text-yellow-700 hover:text-yellow-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="notification bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded shadow-lg" role="alert">
            <div class="flex">
                <span class="text-xl mr-3">ℹ️</span>
                <span>{{ session('info') }}</span>
                <button onclick="this.parentElement.parentElement.classList.add('hide')" class="ml-auto text-blue-700 hover:text-blue-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif
    
    <!-- Contenu principal -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    <x-footer />
    
    <!-- Scripts -->
    <script>
        // Animation au défilement
        document.addEventListener('DOMContentLoaded', function() {
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
            fadeInOnScroll(); // Vérifier au chargement initial
            
            // Auto-hide notifications après 5 secondes
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notification => {
                setTimeout(() => {
                    notification.classList.add('hide');
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }, 5000);
            });
        });
        
        // Smooth scroll pour les liens d'ancrage
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
