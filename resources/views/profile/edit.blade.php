@extends('layouts.dashboard')

@section('title', 'Mon Profil - NIF Cargo')
@section('page-title', 'Mon Profil')

@section('content')
<!-- Hero Section -->
<div class="gradient-bg-dashboard rounded-2xl p-8 mb-8 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black bg-opacity-10"></div>
    <div class="relative z-10">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    👤 Mon Profil
                </h1>
                <p class="text-blue-100 text-lg">
                    Gérez vos informations personnelles et paramètres de compte
                </p>
            </div>
            <div class="hidden md:block">
                <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <span class="text-3xl font-bold">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Sidebar Profil -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Carte Profil -->
        <div class="dashboard-card p-6 fade-in">
            <div class="text-center">
                <div class="w-24 h-24 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-2xl font-bold">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-1">{{ Auth::user()->name }}</h3>
                <p class="text-gray-600 mb-2">{{ Auth::user()->email }}</p>
                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                    @if(Auth::user()->isAdmin())
                        👨‍💼 Administrateur
                    @else
                        👤 Client
                    @endif
                </span>
            </div>
            
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Membre depuis</span>
                        <span class="font-medium">{{ Auth::user()->created_at->format('M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Dernière connexion</span>
                        <span class="font-medium">{{ Auth::user()->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Statut</span>
                        <span class="text-green-600 font-medium">
                            <i class="fas fa-check-circle mr-1"></i> Actif
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Menu Navigation -->
        <div class="dashboard-card p-6 fade-in">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Navigation</h3>
            <nav class="space-y-2">
                <a href="#profile-info" class="flex items-center px-3 py-2 text-blue-600 bg-blue-50 rounded-lg font-medium">
                    <i class="fas fa-user mr-3"></i> Informations personnelles
                </a>
                <a href="#security" class="flex items-center px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-lock mr-3"></i> Sécurité
                </a>
                <a href="#preferences" class="flex items-center px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-cog mr-3"></i> Préférences
                </a>
                <a href="#danger-zone" class="flex items-center px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-exclamation-triangle mr-3"></i> Zone de danger
                </a>
            </nav>
        </div>
    </div>
    
    <!-- Contenu Principal -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Informations Personnelles -->
        <div id="profile-info" class="dashboard-card p-6 fade-in">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">
                <i class="fas fa-user mr-2 text-blue-500"></i> Informations Personnelles
            </h2>
            
            @include('profile.partials.update-profile-information-form')
        </div>
        
        <!-- Sécurité -->
        <div id="security" class="dashboard-card p-6 fade-in">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">
                <i class="fas fa-lock mr-2 text-green-500"></i> Sécurité du Compte
            </h2>
            
            @include('profile.partials.update-password-form')
        </div>
        
        <!-- Préférences -->
        <div id="preferences" class="dashboard-card p-6 fade-in">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">
                <i class="fas fa-cog mr-2 text-purple-500"></i> Préférences
            </h2>
            
            <form class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Langue</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="fr">Français</option>
                            <option value="en">English</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fuseau horaire</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="Africa/Lome">Afrique/Lomé (GMT+0)</option>
                            <option value="Africa/Cotonou">Afrique/Cotonou (GMT+1)</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Notifications</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">Notifications par email</p>
                                <p class="text-sm text-gray-600">Recevoir des mises à jour sur vos demandes</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" value="" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">Notifications SMS</p>
                                <p class="text-sm text-gray-600">Recevoir des SMS pour les étapes importantes</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" value="" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">Newsletter</p>
                                <p class="text-sm text-gray-600">Recevoir nos actualités et promotions</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" value="" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                        Enregistrer les préférences
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Zone de Danger -->
        <div id="danger-zone" class="dashboard-card p-6 fade-in border-red-200">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">
                <i class="fas fa-exclamation-triangle mr-2 text-red-500"></i> Zone de Danger
            </h2>
            
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Navigation smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
            
            // Update active nav
            document.querySelectorAll('nav a').forEach(link => {
                link.classList.remove('text-blue-600', 'bg-blue-50');
                link.classList.add('text-gray-700');
            });
            this.classList.remove('text-gray-700');
            this.classList.add('text-blue-600', 'bg-blue-50');
        }
    });
});
</script>
@endpush
