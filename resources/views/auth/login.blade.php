@extends('layouts.main')

@section('title', 'Connexion - NIF Cargo')
@section('description', 'Connectez-vous à votre espace NIF Cargo pour gérer vos demandes de transport et suivre vos envois.')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 via-blue-50 to-emerald-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Carte principale -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 border border-slate-100 backdrop-blur-sm">
            <!-- En-tête avec logo animé -->
            <div class="text-center mb-8">
                <!-- Logo animé -->
                <div class="relative inline-flex items-center justify-center mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg group hover:shadow-xl transition-all duration-300">
                        <i class="fas fa-shipping-fast text-white text-2xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center shadow-lg animate-pulse">
                        <i class="fas fa-lock text-white text-xs"></i>
                    </div>
                </div>
                
                <h1 class="text-3xl font-bold text-gray-900 mb-2">NIF Cargo</h1>
                <p class="text-gray-600 mb-4">Connexion à votre espace</p>
            </div>
            
            <!-- Session Status -->
            <x-auth-session-status class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-xl text-blue-700" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Adresse email')" class="text-gray-700 font-medium" />
                    <div class="relative">
                        <x-text-input 
                            id="email" 
                            class="block mt-1 w-full pl-4 pr-10 py-3 rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autofocus 
                            autocomplete="username" 
                            placeholder="votre@email.com"
                        />
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Mot de passe')" class="text-gray-700 font-medium" />
                    <div class="relative">
                        <x-text-input 
                            id="password" 
                            class="block mt-1 w-full pl-4 pr-12 py-3 rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500"
                            type="password"
                            name="password"
                            required 
                            autocomplete="current-password" 
                            placeholder="Votre mot de passe"
                        />
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i class="fas fa-eye-slash text-gray-400 cursor-pointer hover:text-gray-600 transition-colors" onclick="togglePassword('password', this)"></i>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input 
                            id="remember_me" 
                            type="checkbox" 
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" 
                            name="remember"
                        >
                        <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors flex items-center" href="{{ route('password.request') }}">
                            <i class="fas fa-key mr-1"></i>
                            {{ __('Mot de passe oublié ?') }}
                        </a>
                    @endif
                </div>

                <!-- Bouton de connexion -->
                <div class="pt-4">
                    <x-primary-button class="w-full justify-center bg-gradient-to-r from-blue-600 to-emerald-500 hover:from-blue-700 hover:to-emerald-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 py-3 text-base">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        {{ __('Se connecter') }}
                    </x-primary-button>
                </div>
                
                <!-- Séparateur -->
                <div class="relative flex items-center my-6">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="flex-shrink mx-4 text-sm text-gray-500">Nouveau chez NIF Cargo ?</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>
                
                <!-- Options d'inscription -->
                <div class="space-y-4">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-4">
                            Créez votre compte en 2 minutes
                        </p>
                    </div>
                    
                    <!-- Bouton client -->
                    <a href="{{ route('register.client') }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-wide hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg group">
                        <i class="fas fa-user-plus mr-2 group-hover:scale-110 transition-transform"></i>
                        Créer un compte client
                    </a>
                    
                    <!-- Lien admin -->
                    <div class="text-center">
                        <p class="text-xs text-gray-500">
                            <i class="fas fa-user-shield mr-1"></i>
                            Administrateur ? 
                            <a href="{{ route('register.admin') }}" class="text-purple-600 hover:text-purple-700 font-medium transition-colors">
                                Accès spécial ici
                            </a>
                        </p>
                    </div>
                </div>
            </form>
            

            <!-- Garanties de sécurité -->
            <div class="mt-6 grid grid-cols-3 gap-3 text-center">
                <div class="bg-white rounded-lg p-2 border border-gray-200 shadow-sm">
                    <i class="fas fa-lock text-green-500 text-sm mb-1"></i>
                    <p class="text-xs text-gray-600">Sécurisé</p>
                </div>
                <div class="bg-white rounded-lg p-2 border border-gray-200 shadow-sm">
                    <i class="fas fa-bolt text-blue-500 text-sm mb-1"></i>
                    <p class="text-xs text-gray-600">Rapide</p>
                </div>
                <div class="bg-white rounded-lg p-2 border border-gray-200 shadow-sm">
                    <i class="fas fa-heart text-red-500 text-sm mb-1"></i>
                    <p class="text-xs text-gray-600">Fiable</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId, icon) {
    const input = document.getElementById(inputId);
    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
    input.setAttribute('type', type);
    
    // Changer l'icône
    if (type === 'password') {
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Animation d'entrée pour les éléments
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.bg-white, .bg-slate-50, .bg-amber-50');
    elements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        setTimeout(() => {
            el.style.transition = 'all 0.5s ease';
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

// Auto-remplissage des comptes de test en développement
document.addEventListener('DOMContentLoaded', function() {
    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
        // Ajouter des boutons de remplissage rapide
        const form = document.querySelector('form');
        if (form) {
            const quickFillDiv = document.createElement('div');
            quickFillDiv.className = 'mt-4 flex gap-2';
            quickFillDiv.innerHTML = `
                <button type="button" onclick="fillCredentials('admin@nif.com', 'admin123')" class="flex-1 text-xs bg-purple-100 text-purple-700 px-3 py-2 rounded-lg hover:bg-purple-200 transition-colors">
                    Remplir Admin
                </button>
                <button type="button" onclick="fillCredentials('client@nif.com', 'client123')" class="flex-1 text-xs bg-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-200 transition-colors">
                    Remplir Client
                </button>
            `;
            form.querySelector('.pt-4').parentNode.insertBefore(quickFillDiv, form.querySelector('.pt-4'));
        }
    }
});

function fillCredentials(email, password) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = password;
}
</script>

<style>
/* Animations supplémentaires */
.backdrop-blur-sm {
    backdrop-filter: blur(8px);
}

/* Amélioration des transitions */
.transition-all {
    transition: all 0.3s ease;
}

/* Style pour les inputs au focus */
input:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    border-color: #3b82f6;
}

/* Animation pour les cartes */
.bg-white, .bg-slate-50, .bg-amber-50 {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Effet de profondeur pour les boutons */
.shadow-lg {
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.hover\:shadow-xl:hover {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Responsive amélioré */
@media (max-width: 640px) {
    .max-w-md {
        margin: 1rem;
    }
    
    .p-8 {
        padding: 1.5rem;
    }
    
    .grid-cols-2 {
        grid-template-columns: 1fr;
    }
    
    .text-3xl {
        font-size: 1.75rem;
    }
}
</style>
@endsection