@extends('layouts.main')

@section('title', 'Test Traductions - ' . __('Accueil'))

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold mb-8 text-center">Test des traductions</h1>
            
            <!-- Info système -->
            <div class="mb-8 p-4 bg-blue-50 rounded-lg">
                <h2 class="text-lg font-semibold mb-4">Informations système :</h2>
                <ul class="space-y-2">
                    <li><strong>Locale actuelle :</strong> {{ app()->getLocale() }}</li>
                    <li><strong>Paramètre URL :</strong> {{ request()->get('locale', 'non défini') }}</li>
                    <li><strong>Session locale :</strong> {{ session('locale', 'non définie') }}</li>
                    <li><strong>Config locale :</strong> {{ config('app.locale') }}</li>
                </ul>
            </div>

            <!-- Tests de traductions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-4 bg-gray-50 rounded">
                    <h3 class="font-semibold mb-2">Navigation :</h3>
                    <ul class="space-y-1 text-sm">
                        <li>Accueil : {{ __('Accueil') }}</li>
                        <li>Connexion : {{ __('Connexion') }}</li>
                        <li>Mon espace : {{ __('Mon espace') }}</li>
                    </ul>
                </div>

                <div class="p-4 bg-gray-50 rounded">
                    <h3 class="font-semibold mb-2">Services :</h3>
                    <ul class="space-y-1 text-sm">
                        <li>Transport Maritime : {{ __('Transport Maritime') }}</li>
                        <li>Transport Aérien : {{ __('Transport Aérien') }}</li>
                        <li>Nos Services : {{ __('Nos Services') }}</li>
                    </ul>
                </div>

                <div class="p-4 bg-gray-50 rounded">
                    <h3 class="font-semibold mb-2">Actions :</h3>
                    <ul class="space-y-1 text-sm">
                        <li>Faire une demande : {{ __('Faire une demande') }}</li>
                        <li>Suivre un colis : {{ __('Suivre un colis') }}</li>
                        <li>En savoir plus : {{ __('En savoir plus') }}</li>
                    </ul>
                </div>

                <div class="p-4 bg-gray-50 rounded">
                    <h3 class="font-semibold mb-2">Phrases longues :</h3>
                    <ul class="space-y-2 text-xs">
                        <li>{{ __('Des services de transport adaptés à tous vos besoins logistiques en Afrique et au-delà') }}</li>
                        <li>{{ __('Présent dans plus de 15 pays avec des partenaires de confiance') }}</li>
                    </ul>
                </div>
            </div>

            <!-- Boutons de test -->
            <div class="mt-8 text-center">
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="?locale=fr" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">🇫🇷 Français</a>
                    <a href="?locale=en" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">🇬🇧 English</a>
                    <a href="?locale=zh_CN" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">🇨🇳 中文</a>
                </div>
            </div>

            <!-- Retour à l'accueil -->
            <div class="mt-8 text-center">
                <a href="{{ route('accueil') }}{{ app()->getLocale() != 'fr' ? '?locale=' . app()->getLocale() : '' }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    ← {{ __('Retour à l\'accueil') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection