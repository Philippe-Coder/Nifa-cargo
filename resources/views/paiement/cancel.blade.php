@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center">
        <!-- Icône d'annulation -->
        <div class="mx-auto w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mb-6">
            <span class="text-4xl">⚠️</span>
        </div>
        
        <!-- Titre -->
        <h1 class="text-3xl font-bold text-gray-900 mb-4">
            Paiement annulé
        </h1>
        
        <!-- Message -->
        <p class="text-lg text-gray-600 mb-8">
            {{ $message }}
        </p>
        
        <!-- Informations -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
            <div class="flex items-center justify-center mb-4">
                <span class="text-2xl mr-2">🔄</span>
                <h2 class="text-lg font-semibold text-yellow-800">Aucun montant n'a été débité</h2>
            </div>
            <p class="text-yellow-700 text-sm">
                Votre paiement a été annulé. Vous pouvez réessayer à tout moment.
            </p>
        </div>
        
        <!-- Actions -->
        <div class="space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
            <button onclick="history.back()" 
                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors">
                🔄 Réessayer le paiement
            </button>
            
            <a href="{{ route('client.suivi.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-medium rounded-md hover:bg-gray-700 transition-colors">
                📋 Mes demandes
            </a>
        </div>
        
        <!-- Support -->
        <div class="mt-8 p-4 bg-gray-50 rounded-lg">
            <h3 class="font-medium text-gray-900 mb-2">Besoin d'aide ?</h3>
            <p class="text-sm text-gray-600">
                Si vous rencontrez des difficultés, contactez notre support client.
            </p>
            <div class="mt-2">
                <a href="mailto:contact@nifgroupecargo.com" class="text-blue-600 hover:underline text-sm">
                    📧 contact@nifgroupecargo.com
                </a>
                <span class="mx-2 text-gray-400">|</span>
                <a href="tel:+22899252531" class="text-blue-600 hover:underline text-sm">
                    📞 +228 99 25 25 31
                </a>
            </div>
        </div>
        
        <!-- Lien retour -->
        <div class="mt-8">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">
                ← Retour au tableau de bord
            </a>
        </div>
    </div>
</div>
@endsection
