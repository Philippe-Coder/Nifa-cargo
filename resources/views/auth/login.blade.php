@extends('layouts.main')

@section('title', 'Connexion - NIFA')
@section('description', 'Connectez-vous à votre espace NIFA pour gérer vos demandes de transport et suivre vos envois.')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white rounded-2xl shadow-xl p-8">
    <div class="mb-6 text-center">
        <div class="flex items-center justify-center mb-4">
            <span class="text-4xl mr-2">🚢</span>
            <h1 class="text-2xl font-bold text-gray-900">NIFA</h1>
        </div>
        <h2 class="text-lg text-gray-600">Connexion à votre espace</h2>
    </div>
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                🔑 {{ __('Se connecter') }}
            </x-primary-button>
        </div>
        
        <!-- Lien d'inscription -->
        <div class="mt-6 text-center border-t pt-6">
            <p class="text-sm text-gray-600 mb-4">
                Vous n'avez pas encore de compte ?
            </p>
            <div class="space-y-3">
                <a href="{{ route('register') }}" 
                   class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    👤 Créer un compte client
                </a>
                <p class="text-xs text-gray-500">
                    Administrateur ? 
                    <a href="{{ route('register') }}" class="text-purple-600 hover:underline">
                        Accès spécial
                    </a>
                </p>
            </div>
        </div>
    </form>
    
    <!-- Comptes de test -->
    @if(app()->environment('local'))
        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
            <h3 class="text-sm font-medium text-yellow-800 mb-2">🛠️ Comptes de test (dev uniquement)</h3>
            <div class="text-xs text-yellow-700 space-y-1">
                <div><strong>Admin:</strong> admin@nifa.com / admin123</div>
                <div><strong>Client:</strong> client@nifa.com / client123</div>
            </div>
        </div>
    @endif
        </div>
    </div>
</div>
@endsection
