@extends('layouts.main')

@section('title', 'Créer un compte client - NIF Cargo')
@section('description', 'Rejoignez des milliers de clients qui font confiance à NIF Cargo pour leurs besoins de transport en Afrique.')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-emerald-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg w-full space-y-8">
        <!-- Carte principale -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 border border-slate-100 backdrop-blur-sm">
            <!-- En-tête avec logo et badge -->
            <div class="text-center mb-8">
                <!-- Logo animé -->
                <div class="relative inline-flex items-center justify-center mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg group hover:shadow-xl transition-all duration-300">
                        <i class="fas fa-shipping-fast text-white text-2xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center shadow-lg animate-pulse">
                        <i class="fas fa-plus text-white text-xs"></i>
                    </div>
                </div>
                
                <h1 class="text-3xl font-bold text-gray-900 mb-2">NIF Cargo</h1>
                <p class="text-gray-600 mb-4">Création de compte client</p>
                
                <!-- Badge de confiance -->
                <div class="inline-flex items-center bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-full px-4 py-2">
                    <i class="fas fa-users text-green-500 mr-2"></i>
                    <span class="text-sm font-medium text-green-700">Rejoignez +10,000 clients satisfaits</span>
                </div>
            </div>

            <form method="POST" action="{{ route('register.client.store') }}" class="space-y-6">
                @csrf

                <!-- Informations personnelles -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 flex items-center">
                        <i class="fas fa-user-circle text-blue-500 mr-2"></i>
                        Informations personnelles
                    </h3>
                    
                    <!-- Nom complet -->
                    <div>
                        <x-input-label for="name" value="Nom complet *" class="text-gray-700 font-medium" />
                        <div class="relative">
                            <x-text-input 
                                id="name" 
                                class="block mt-1 w-full pl-4 pr-10 py-3 rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500" 
                                type="text" 
                                name="name" 
                                :value="old('name')" 
                                required 
                                autofocus 
                                autocomplete="name" 
                                placeholder="Ex: Jean Dupont"
                            />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" value="Adresse email *" class="text-gray-700 font-medium" />
                        <div class="relative">
                            <x-text-input 
                                id="email" 
                                class="block mt-1 w-full pl-4 pr-10 py-3 rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autocomplete="username" 
                                placeholder="jean@example.com"
                            />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <x-input-label for="telephone" value="Téléphone *" class="text-gray-700 font-medium" />
                        <div class="relative">
                            <x-text-input 
                                id="telephone" 
                                class="block mt-1 w-full pl-4 pr-10 py-3 rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500" 
                                type="tel" 
                                name="telephone" 
                                :value="old('telephone')" 
                                required 
                                autocomplete="tel" 
                                placeholder="+228 90 12 34 56"
                            />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="fas fa-phone text-gray-400"></i>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                        <p class="text-xs text-gray-500 mt-1 flex items-center">
                            <i class="fas fa-comment-dots mr-1"></i>
                            Pour vous contacter rapidement concernant vos envois
                        </p>
                    </div>

                    <!-- Adresse -->
                    <div>
                        <x-input-label for="adresse" value="Adresse" class="text-gray-700 font-medium" />
                        <div class="relative">
                            <textarea 
                                id="adresse" 
                                name="adresse" 
                                rows="2" 
                                class="block mt-1 w-full pl-4 pr-10 py-3 rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500 shadow-sm resize-none"
                                placeholder="Ex: 123 Rue de la Paix, Lomé, Togo"
                            >{{ old('adresse') }}</textarea>
                            <div class="absolute top-3 right-3">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
                        <p class="text-xs text-gray-500 mt-1 flex items-center">
                            <i class="fas fa-truck mr-1"></i>
                            Optionnel - Pour faciliter les livraisons à domicile
                        </p>
                    </div>
                </div>

                <!-- Sécurité du compte -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 flex items-center">
                        <i class="fas fa-lock text-blue-500 mr-2"></i>
                        Sécurité du compte
                    </h3>
                    
                    <!-- Mot de passe -->
                    <div>
                        <x-input-label for="password" value="Mot de passe *" class="text-gray-700 font-medium" />
                        <div class="relative">
                            <x-text-input 
                                id="password" 
                                class="block mt-1 w-full pl-4 pr-12 py-3 rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500" 
                                type="password"
                                name="password"
                                required 
                                autocomplete="new-password"
                                placeholder="Créez un mot de passe sécurisé"
                            />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="fas fa-eye-slash text-gray-400 cursor-pointer hover:text-gray-600 transition-colors" onclick="togglePassword('password', this)"></i>
                            </div>
                        </div>
                        <!-- Générateur de mot de passe -->
                        <div class="mt-2 flex items-center gap-2">
                            <button type="button" onclick="generateAndFillPassword()" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200">
                                <i class="fas fa-magic mr-2"></i>
                                Générer automatiquement
                            </button>
                            <button type="button" onclick="copyPassword()" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg bg-gray-50 text-gray-700 hover:bg-gray-100 border border-gray-200">
                                <i class="fas fa-copy mr-2"></i>
                                Copier
                            </button>
                            <span id="copy-feedback" class="text-xs text-green-600 hidden"><i class="fas fa-check mr-1"></i>Copié</span>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        
                        <!-- Indicateur de force du mot de passe -->
                        <div class="mt-2">
                            <div class="flex items-center text-xs text-gray-500 mb-1">
                                <i class="fas fa-shield-alt mr-2"></i>
                                <span>Sécurité du mot de passe :</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div id="password-strength" class="h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                            <div class="grid grid-cols-2 gap-1 mt-2 text-xs">
                                <div class="flex items-center password-requirement" data-requirement="length">
                                    <i class="fas fa-times text-red-400 mr-1 text-xs"></i>
                                    <span class="text-gray-600">8 caractères</span>
                                </div>
                                <div class="flex items-center password-requirement" data-requirement="uppercase">
                                    <i class="fas fa-times text-red-400 mr-1 text-xs"></i>
                                    <span class="text-gray-600">Majuscule</span>
                                </div>
                                <div class="flex items-center password-requirement" data-requirement="lowercase">
                                    <i class="fas fa-times text-red-400 mr-1 text-xs"></i>
                                    <span class="text-gray-600">Minuscule</span>
                                </div>
                                <div class="flex items-center password-requirement" data-requirement="number">
                                    <i class="fas fa-times text-red-400 mr-1 text-xs"></i>
                                    <span class="text-gray-600">Chiffre</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmation mot de passe -->
                    <div>
                        <x-input-label for="password_confirmation" value="Confirmation du mot de passe *" class="text-gray-700 font-medium" />
                        <div class="relative">
                            <x-text-input 
                                id="password_confirmation" 
                                class="block mt-1 w-full pl-4 pr-12 py-3 rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500" 
                                type="password"
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password"
                                placeholder="Confirmez votre mot de passe"
                            />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="fas fa-eye-slash text-gray-400 cursor-pointer hover:text-gray-600 transition-colors" onclick="togglePassword('password_confirmation', this)"></i>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <!-- Préférences et conditions -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 flex items-center">
                        <i class="fas fa-cog text-blue-500 mr-2"></i>
                        Préférences
                    </h3>
                    
                    <!-- Conditions générales -->
                    <div class="flex items-start space-x-3 bg-blue-50 rounded-xl p-4 border border-blue-200">
                        <input 
                            type="checkbox" 
                            required 
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 mt-1 flex-shrink-0"
                            id="conditions"
                        >
                        <label for="conditions" class="text-sm text-gray-700 leading-relaxed">
                            <span class="font-medium">J'accepte les</span> 
                            <a href="#" class="text-blue-600 hover:underline font-medium">conditions générales d'utilisation</a> 
                            et la 
                            <a href="#" class="text-blue-600 hover:underline font-medium">politique de confidentialité</a> 
                            de NIF Cargo.
                        </label>
                    </div>

                    <!-- Newsletter -->
                    <div class="flex items-start space-x-3 bg-emerald-50 rounded-xl p-4 border border-emerald-200">
                        <input 
                            type="checkbox" 
                            name="newsletter" 
                            value="1" 
                            class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500 mt-1 flex-shrink-0"
                            id="newsletter"
                        >
                        <label for="newsletter" class="text-sm text-gray-700 leading-relaxed">
                            <span class="font-medium">Je souhaite recevoir les actualités et offres spéciales</span> 
                            de NIF Cargo par email. Restez informé des promotions exclusives et conseils logistiques.
                        </label>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a 
                        href="{{ route('login') }}" 
                        class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 font-medium transition-colors group"
                    >
                        <i class="fas fa-sign-in-alt mr-2 group-hover:-translate-x-1 transition-transform"></i>
                        Déjà inscrit ? Se connecter
                    </a>

                    <x-primary-button class="ml-4 bg-gradient-to-r from-blue-600 to-emerald-500 hover:from-blue-700 hover:to-emerald-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-user-plus mr-2"></i>
                        Créer mon compte
                    </x-primary-button>
                </div>
            </form>

            <!-- Garanties -->
            <div class="mt-4 grid grid-cols-3 gap-4 text-center">
                <div class="bg-white rounded-lg p-3 border border-gray-200 shadow-sm">
                    <i class="fas fa-shield-alt text-green-500 text-lg mb-1"></i>
                    <p class="text-xs text-gray-600 font-medium">Sécurisé</p>
                </div>
                <div class="bg-white rounded-lg p-3 border border-gray-200 shadow-sm">
                    <i class="fas fa-clock text-blue-500 text-lg mb-1"></i>
                    <p class="text-xs text-gray-600 font-medium">Rapide</p>
                </div>
                <div class="bg-white rounded-lg p-3 border border-gray-200 shadow-sm">
                    <i class="fas fa-hand-holding-heart text-red-500 text-lg mb-1"></i>
                    <p class="text-xs text-gray-600 font-medium">Fiable</p>
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

// Validation en temps réel du mot de passe
document.getElementById('password')?.addEventListener('input', function(e) {
    const password = e.target.value;
    const requirements = {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /[0-9]/.test(password)
    };
    
    // Calcul du score de force
    let score = 0;
    const totalRequirements = Object.keys(requirements).length;
    
    Object.values(requirements).forEach(met => {
        if (met) score++;
    });
    
    const percentage = (score / totalRequirements) * 100;
    const strengthBar = document.getElementById('password-strength');
    
    // Mettre à jour la barre de force
    if (strengthBar) {
        strengthBar.style.width = percentage + '%';
        if (percentage < 50) {
            strengthBar.className = 'h-2 rounded-full bg-red-500 transition-all duration-300';
        } else if (percentage < 100) {
            strengthBar.className = 'h-2 rounded-full bg-yellow-500 transition-all duration-300';
        } else {
            strengthBar.className = 'h-2 rounded-full bg-green-500 transition-all duration-300';
        }
    }
    
    // Mettre à jour les icônes des exigences
    Object.keys(requirements).forEach(req => {
        const element = document.querySelector(`.password-requirement[data-requirement="${req}"] i`);
        if (element) {
            if (requirements[req]) {
                element.className = 'fas fa-check text-green-500 mr-1 text-xs';
            } else {
                element.className = 'fas fa-times text-red-400 mr-1 text-xs';
            }
        }
    });
});

// Animation d'entrée pour les éléments
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.bg-white, .bg-blue-50, .bg-emerald-50');
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

// Générateur de mot de passe sécurisé respectant les exigences
function generateSecurePassword(length = 12) {
    const upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const lower = 'abcdefghijklmnopqrstuvwxyz';
    const numbers = '0123456789';
    const specials = '!@#$%^&*()-_=+[]{};:,.?';
    const all = upper + lower + numbers + specials;

    // Garantir au moins un de chaque catégorie
    let pwd = '';
    pwd += upper[Math.floor(Math.random() * upper.length)];
    pwd += lower[Math.floor(Math.random() * lower.length)];
    pwd += numbers[Math.floor(Math.random() * numbers.length)];
    pwd += specials[Math.floor(Math.random() * specials.length)];

    // Compléter le reste
    for (let i = pwd.length; i < length; i++) {
        pwd += all[Math.floor(Math.random() * all.length)];
    }

    // Mélanger
    pwd = pwd.split('').sort(() => 0.5 - Math.random()).join('');
    return pwd;
}

function generateAndFillPassword() {
    const pwd = generateSecurePassword(12);
    const p1 = document.getElementById('password');
    const p2 = document.getElementById('password_confirmation');
    if (p1) {
        p1.value = pwd;
        p1.dispatchEvent(new Event('input', { bubbles: true }));
    }
    if (p2) {
        p2.value = pwd;
    }
}

async function copyPassword() {
    const p1 = document.getElementById('password');
    const feedback = document.getElementById('copy-feedback');
    if (p1 && navigator.clipboard) {
        try {
            await navigator.clipboard.writeText(p1.value || '');
            if (feedback) {
                feedback.classList.remove('hidden');
                setTimeout(() => feedback.classList.add('hidden'), 1500);
            }
        } catch (e) {
            console.warn('Clipboard copy failed', e);
        }
    }
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
input:focus, textarea:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    border-color: #3b82f6;
}

/* Animation pour les cartes */
.bg-white, .bg-blue-50, .bg-emerald-50 {
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

/* Responsive amélioré */
@media (max-width: 640px) {
    .max-w-lg {
        margin: 1rem;
    }
    
    .p-8 {
        padding: 1.5rem;
    }
    
    .grid-cols-2 {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection