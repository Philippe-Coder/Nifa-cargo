@extends('layouts.main')

@section('title', 'Créer un compte administrateur - NIF Cargo')
@section('description', 'Accès réservé aux administrateurs autorisés NIF Cargo.')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 to-blue-50/30 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Carte principale -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 border border-slate-100 backdrop-blur-sm">
            <!-- En-tête -->
            <div class="text-center mb-8">
                <!-- Logo et badge de sécurité -->
                <div class="relative inline-flex items-center justify-center mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 rounded-full flex items-center justify-center shadow-lg">
                        <i class="fas fa-lock text-white text-xs"></i>
                    </div>
                </div>
                
                <h1 class="text-3xl font-bold text-gray-900 mb-2">NIF Cargo Admin</h1>
                <p class="text-gray-600 mb-4">Création de compte administrateur</p>
                
                <!-- Alerte de sécurité -->
                <div class="inline-flex items-center bg-red-50 border border-red-200 rounded-full px-4 py-2 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                    <span class="text-sm font-medium text-red-700">Accès hautement sécurisé</span>
                </div>
            </div>

            <form method="POST" action="{{ route('register.admin.store') }}" class="space-y-6">
                @csrf

                <!-- Section Clé d'administration -->
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl p-6 border border-amber-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-key text-amber-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Clé d'autorisation administrateur</h3>
                            <p class="text-sm text-amber-700">Fournie par l'équipe de direction</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <x-input-label for="admin_key" value="Clé secrète *" class="text-gray-700 font-medium" />
                            <div class="relative">
                                <x-text-input 
                                    id="admin_key" 
                                    class="block mt-1 w-full pl-4 pr-12 py-3 border-amber-300 focus:border-amber-500 focus:ring-amber-500" 
                                    type="password" 
                                    name="admin_key" 
                                    required 
                                    autofocus 
                                    placeholder="Saisissez la clé d'autorisation"
                                />
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i class="fas fa-eye-slash text-amber-500 cursor-pointer" onclick="togglePassword('admin_key', this)"></i>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('admin_key')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-start text-xs text-amber-700 bg-amber-100/50 rounded-lg p-3">
                            <i class="fas fa-info-circle mt-0.5 mr-2"></i>
                            <span>Cette clé vous a été personnellement remise. Contactez le support en cas de problème.</span>
                        </div>
                    </div>
                </div>

                <!-- Informations personnelles -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Informations personnelles</h3>
                    
                    <!-- Nom complet -->
                    <div>
                        <x-input-label for="name" value="Nom complet *" class="text-gray-700 font-medium" />
                        <div class="relative">
                            <x-text-input 
                                id="name" 
                                class="block mt-1 w-full pl-4 pr-10 py-3" 
                                type="text" 
                                name="name" 
                                :value="old('name')" 
                                required 
                                autocomplete="name" 
                                placeholder="Ex: Marie Administrateur"
                            />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email professionnel -->
                    <div>
                        <x-input-label for="email" value="Email professionnel *" class="text-gray-700 font-medium" />
                        <div class="relative">
                            <x-text-input 
                                id="email" 
                                class="block mt-1 w-full pl-4 pr-10 py-3" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autocomplete="username" 
                                placeholder="admin@nifcargo.com"
                            />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        <p class="text-xs text-gray-500 mt-1 flex items-center">
                            <i class="fas fa-building mr-1"></i>
                            Utilisez votre email professionnel NIF Cargo
                        </p>
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <x-input-label for="telephone" value="Téléphone professionnel" class="text-gray-700 font-medium" />
                        <div class="relative">
                            <x-text-input 
                                id="telephone" 
                                class="block mt-1 w-full pl-4 pr-10 py-3" 
                                type="tel" 
                                name="telephone" 
                                :value="old('telephone')" 
                                autocomplete="tel" 
                                placeholder="+228 99 25 25 31"
                            />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="fas fa-phone text-gray-400"></i>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                    </div>
                </div>

                <!-- Sécurité du compte -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Sécurité du compte</h3>
                    
                    <!-- Mot de passe -->
                    <div>
                        <x-input-label for="password" value="Mot de passe *" class="text-gray-700 font-medium" />
                        <div class="relative">
                            <x-text-input 
                                id="password" 
                                class="block mt-1 w-full pl-4 pr-12 py-3" 
                                type="password"
                                name="password"
                                required 
                                autocomplete="new-password"
                                placeholder="Créez un mot de passe sécurisé"
                            />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="fas fa-eye-slash text-gray-400 cursor-pointer" onclick="togglePassword('password', this)"></i>
                            </div>
                        </div>
                        <!-- Générateur de mot de passe -->
                        <div class="mt-2 flex items-center gap-2">
                            <button type="button" onclick="generateAndFillPassword()" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg bg-purple-50 text-purple-700 hover:bg-purple-100 border border-purple-200">
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
                        <div class="mt-2 space-y-2">
                            <div class="flex items-center text-xs text-gray-500">
                                <i class="fas fa-shield-alt mr-2"></i>
                                <span>Le mot de passe doit contenir :</span>
                            </div>
                            <div class="grid grid-cols-2 gap-1 text-xs">
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-1 text-xs"></i>
                                    <span class="text-gray-600">8 caractères minimum</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-1 text-xs"></i>
                                    <span class="text-gray-600">Majuscules & minuscules</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-1 text-xs"></i>
                                    <span class="text-gray-600">Chiffres</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-1 text-xs"></i>
                                    <span class="text-gray-600">Caractères spéciaux</span>
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
                                class="block mt-1 w-full pl-4 pr-12 py-3" 
                                type="password"
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password"
                                placeholder="Confirmez votre mot de passe"
                            />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="fas fa-eye-slash text-gray-400 cursor-pointer" onclick="togglePassword('password_confirmation', this)"></i>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <!-- Conditions et engagements -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Engagements requis</h3>
                    
                    <!-- Conditions d'utilisation -->
                    <div class="flex items-start space-x-3 bg-blue-50 rounded-xl p-4 border border-blue-200">
                        <input 
                            type="checkbox" 
                            required 
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 mt-1 flex-shrink-0"
                            id="conditions"
                        >
                        <label for="conditions" class="text-sm text-gray-700 leading-relaxed">
                            <span class="font-medium">Je certifie être autorisé(e) à créer un compte administrateur NIF Cargo</span> 
                            et j'accepte les 
                            <a href="#" class="text-blue-600 hover:underline font-medium">conditions d'utilisation administrateur</a> 
                            ainsi que la politique de confidentialité.
                        </label>
                    </div>

                    <!-- Engagement de confidentialité -->
                    <div class="flex items-start space-x-3 bg-purple-50 rounded-xl p-4 border border-purple-200">
                        <input 
                            type="checkbox" 
                            required 
                            class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500 mt-1 flex-shrink-0"
                            id="confidentialite"
                        >
                        <label for="confidentialite" class="text-sm text-gray-700 leading-relaxed">
                            <span class="font-medium">Je m'engage solennellement</span> à respecter la confidentialité des données clients, 
                            les procédures de sécurité NIF Cargo et à signaler toute violation de sécurité immédiatement.
                        </label>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a 
                        href="{{ route('login') }}" 
                        class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 font-medium transition-colors group"
                    >
                        <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                        Retour à la connexion
                    </a>

                    <x-primary-button class="ml-4 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-user-shield mr-2"></i>
                        Créer le compte admin
                    </x-primary-button>
                </div>
            </form>

            <!-- Informations de sécurité renforcées -->
            <div class="mt-8 bg-gradient-to-r from-red-50 to-orange-50 rounded-2xl p-6 border border-red-200">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-shield-alt text-red-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-red-800">Sécurité renforcée</h3>
                        <p class="text-sm text-red-700">Mesures de protection activées</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-red-700">
                    <div class="flex items-center">
                        <i class="fas fa-fingerprint mr-2"></i>
                        <span>Authentification à double facteur</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock mr-2"></i>
                        <span>Sessions limitées dans le temps</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-history mr-2"></i>
                        <span>Audit des actions administrateur</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-bell mr-2"></i>
                        <span>Alertes de sécurité en temps réel</span>
                    </div>
                </div>
            </div>

            <!-- Contact support -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600 mb-2">Assistance technique dédiée</p>
                <div class="flex flex-col sm:flex-row justify-center items-center space-y-2 sm:space-y-0 sm:space-x-6 text-xs">
                    <a href="mailto:contact@nifgroupecargo.com" class="text-blue-600 hover:text-blue-700 font-medium transition-colors flex items-center">
                        <i class="fas fa-envelope mr-2"></i>
                        contact@nifgroupecargo.com
                    </a>
                    <a href="tel:+22899252531" class="text-blue-600 hover:text-blue-700 font-medium transition-colors flex items-center">
                        <i class="fas fa-phone mr-2"></i>
                        +228 99 25 25 31
                    </a>
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
        number: /[0-9]/.test(password),
        special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
    };
    
    // Mettre à jour visuellement les exigences (vous pouvez implémenter cette partie)
    console.log('Exigences du mot de passe:', requirements);
});

// Générateur de mot de passe (identique à la page client)
function generateSecurePassword(length = 12) {
    const upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const lower = 'abcdefghijklmnopqrstuvwxyz';
    const numbers = '0123456789';
    const specials = '!@#$%^&*()-_=+[]{};:,.?';
    const all = upper + lower + numbers + specials;

    let pwd = '';
    pwd += upper[Math.floor(Math.random() * upper.length)];
    pwd += lower[Math.floor(Math.random() * lower.length)];
    pwd += numbers[Math.floor(Math.random() * numbers.length)];
    pwd += specials[Math.floor(Math.random() * specials.length)];
    for (let i = pwd.length; i < length; i++) {
        pwd += all[Math.floor(Math.random() * all.length)];
    }
    pwd = pwd.split('').sort(() => 0.5 - Math.random()).join('');
    return pwd;
}

function generateAndFillPassword() {
    const pwd = generateSecurePassword(12);
    const p1 = document.getElementById('password');
    const p2 = document.getElementById('password_confirmation');
    if (p1) p1.value = pwd;
    if (p2) p2.value = pwd;
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
        } catch (e) { /* no-op */ }
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
input:focus, select:focus {
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

/* Responsive amélioré */
@media (max-width: 640px) {
    .max-w-md {
        margin: 1rem;
    }
    
    .p-8 {
        padding: 1.5rem;
    }
}
</style>
@endsection