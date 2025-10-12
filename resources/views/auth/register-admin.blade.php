@extends('layouts.main')

@section('title', 'Créer un compte administrateur - NIFA')
@section('description', 'Accès réservé aux administrateurs autorisés NIFA.')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg w-full space-y-8">
        <div class="bg-white rounded-2xl shadow-xl p-8">
    <div class="mb-6 text-center">
        <div class="flex items-center justify-center mb-4">
            <span class="text-4xl mr-2">👨‍💼</span>
            <h1 class="text-2xl font-bold text-gray-900">NIFA Admin</h1>
        </div>
        <h2 class="text-lg text-gray-600">Créer un compte administrateur</h2>
        <div class="mt-2 p-2 bg-red-50 border border-red-200 rounded">
            <p class="text-sm text-red-700">⚠️ Accès restreint - Clé d'autorisation requise</p>
        </div>
    </div>

    <form method="POST" action="{{ route('register.admin.store') }}">
        @csrf

        <!-- Admin Key -->
        <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
            <x-input-label for="admin_key" value="Clé d'autorisation administrateur *" />
            <x-text-input id="admin_key" class="block mt-1 w-full" type="password" name="admin_key" required autofocus placeholder="Clé secrète fournie par NIFA" />
            <x-input-error :messages="$errors->get('admin_key')" class="mt-2" />
            <p class="text-xs text-yellow-700 mt-1">
                🔐 Cette clé vous a été fournie par l'équipe NIFA. Contactez le support si vous ne l'avez pas.
            </p>
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nom complet *" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="name" placeholder="Ex: Marie Administrateur" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" value="Adresse email professionnelle *" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Ex: admin@nifa.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <p class="text-xs text-gray-500 mt-1">Utilisez votre email professionnel NIFA</p>
        </div>

        <!-- Telephone -->
        <div class="mt-4">
            <x-input-label for="telephone" value="Téléphone professionnel" />
            <x-text-input id="telephone" class="block mt-1 w-full" type="tel" name="telephone" :value="old('telephone')" autocomplete="tel" placeholder="Ex: +228 22 61 00 00" />
            <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Mot de passe *" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p class="text-xs text-gray-500 mt-1">Minimum 8 caractères avec majuscules, minuscules et chiffres</p>
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
                    Je certifie être autorisé(e) à créer un compte administrateur NIFA et j'accepte les 
                    <a href="#" class="text-blue-600 hover:underline">conditions d'utilisation administrateur</a>.
                </span>
            </label>
        </div>

        <!-- Confidentialité -->
        <div class="mt-4">
            <label class="flex items-start">
                <input type="checkbox" required class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 mt-1">
                <span class="ml-2 text-sm text-gray-600">
                    Je m'engage à respecter la confidentialité des données clients et les procédures de sécurité NIFA.
                </span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                ← Retour à la connexion
            </a>

            <x-primary-button class="ml-4 bg-purple-600 hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900">
                👨‍💼 Créer le compte admin
            </x-primary-button>
        </div>
    </form>

    <!-- Informations de sécurité -->
    <div class="mt-8 p-4 bg-red-50 border border-red-200 rounded-md">
        <h3 class="text-sm font-medium text-red-800 mb-2">🔒 Sécurité</h3>
        <div class="text-xs text-red-700 space-y-1">
            <div>• Seuls les administrateurs autorisés peuvent créer des comptes admin</div>
            <div>• Toutes les créations de comptes admin sont loggées et auditées</div>
            <div>• En cas de problème, contactez immédiatement le support technique</div>
            <div>• La clé d'autorisation change régulièrement pour la sécurité</div>
        </div>
    </div>

    <!-- Contact support -->
    <div class="mt-4 text-center">
        <p class="text-xs text-gray-500">
            Besoin d'aide ? Contactez le support : 
            <a href="mailto:support@nifa.com" class="text-blue-600 hover:underline">support@nifa.com</a> | 
            <a href="tel:+22890123456" class="text-blue-600 hover:underline">+228 90 12 34 56</a>
        </p>
    </div>
        </div>
    </div>
</div>
@endsection
