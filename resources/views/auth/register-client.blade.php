@extends('layouts.main')

@section('title', 'Créer un compte client - NIFA')
@section('description', 'Rejoignez des milliers de clients qui font confiance à NIFA pour leurs besoins de transport en Afrique.')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg w-full space-y-8">
        <div class="bg-white rounded-2xl shadow-xl p-8">
    <div class="mb-6 text-center">
        <div class="flex items-center justify-center mb-4">
            <span class="text-4xl mr-2">🚢</span>
            <h1 class="text-2xl font-bold text-gray-900">NIFA</h1>
        </div>
        <h2 class="text-lg text-gray-600">Créer un compte client</h2>
        <p class="text-sm text-gray-500 mt-2">Rejoignez des milliers de clients qui nous font confiance</p>
    </div>

    <form method="POST" action="{{ route('register.client.store') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nom complet *" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Ex: Jean Dupont" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" value="Adresse email *" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Ex: jean@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Telephone -->
        <div class="mt-4">
            <x-input-label for="telephone" value="Téléphone" />
            <x-text-input id="telephone" class="block mt-1 w-full" type="tel" name="telephone" :value="old('telephone')" autocomplete="tel" placeholder="Ex: +228 90 12 34 56" />
            <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
            <p class="text-xs text-gray-500 mt-1">Optionnel - Pour vous contacter rapidement</p>
        </div>

        <!-- Adresse -->
        <div class="mt-4">
            <x-input-label for="adresse" value="Adresse" />
            <textarea id="adresse" name="adresse" rows="2" 
                      class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                      placeholder="Ex: 123 Rue de la Paix, Lomé, Togo">{{ old('adresse') }}</textarea>
            <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
            <p class="text-xs text-gray-500 mt-1">Optionnel - Pour faciliter les livraisons</p>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Mot de passe *" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p class="text-xs text-gray-500 mt-1">Minimum 8 caractères</p>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirmer le mot de passe *" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Conditions -->
        <div class="mt-4">
            <label class="flex items-start">
                <input type="checkbox" required class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 mt-1">
                <span class="ml-2 text-sm text-gray-600">
                    J'accepte les <a href="#" class="text-blue-600 hover:underline">conditions générales d'utilisation</a> 
                    et la <a href="#" class="text-blue-600 hover:underline">politique de confidentialité</a> de NIFA.
                </span>
            </label>
        </div>

        <!-- Newsletter -->
        <div class="mt-4">
            <label class="flex items-start">
                <input type="checkbox" name="newsletter" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 mt-1">
                <span class="ml-2 text-sm text-gray-600">
                    Je souhaite recevoir les actualités et offres spéciales de NIFA par email.
                </span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                ← Déjà inscrit ? Se connecter
            </a>

            <x-primary-button class="ml-4">
                👤 Créer mon compte
            </x-primary-button>
        </div>
    </form>

    <!-- Avantages -->
    <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-md">
        <h3 class="text-sm font-medium text-blue-800 mb-2">✨ Avantages du compte client</h3>
        <div class="text-xs text-blue-700 space-y-1">
            <div>• Suivi en temps réel de vos envois</div>
            <div>• Historique complet de vos demandes</div>
            <div>• Devis personnalisés et tarifs préférentiels</div>
            <div>• Support client prioritaire</div>
            <div>• Notifications SMS et email automatiques</div>
        </div>
    </div>
        </div>
    </div>
</div>
@endsection
