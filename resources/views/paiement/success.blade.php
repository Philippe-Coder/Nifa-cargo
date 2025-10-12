@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center">
        <!-- Icône de succès -->
        <div class="mx-auto w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mb-6">
            <span class="text-4xl">✅</span>
        </div>
        
        <!-- Titre -->
        <h1 class="text-3xl font-bold text-gray-900 mb-4">
            Paiement réussi !
        </h1>
        
        <!-- Message -->
        <p class="text-lg text-gray-600 mb-8">
            {{ $message }}
        </p>
        
        <!-- Informations -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8">
            <div class="flex items-center justify-center mb-4">
                <span class="text-2xl mr-2">🎉</span>
                <h2 class="text-lg font-semibold text-green-800">Transaction confirmée</h2>
            </div>
            <p class="text-green-700 text-sm">
                Votre paiement a été traité avec succès. Vous recevrez une confirmation par email et SMS.
            </p>
        </div>
        
        <!-- Actions -->
        <div class="space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
            <a href="{{ route('client.suivi.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors">
                📋 Voir mes demandes
            </a>
            
            <a href="{{ route('paiement.historique') }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-medium rounded-md hover:bg-gray-700 transition-colors">
                💳 Historique des paiements
            </a>
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
