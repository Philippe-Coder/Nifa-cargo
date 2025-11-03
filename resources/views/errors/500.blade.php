@extends('layouts.app')

@section('title', 'Erreur 500 - Erreur interne')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 text-center">
            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100 mb-6">
                <i class="fas fa-cog text-3xl text-red-600"></i>
            </div>

            <!-- Titre -->
            <h2 class="text-3xl font-extrabold text-gray-900 mb-4">
                Erreur technique
            </h2>

            <!-- Message -->
            <p class="text-sm text-gray-600 mb-6">
                {{ $message ?? 'Une erreur technique inattendue s\'est produite. Nos équipes ont été notifiées et travaillent à résoudre le problème.' }}
            </p>

            <!-- Actions -->
            <div class="space-y-3">
                <a href="{{ route('home') }}" 
                   class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-home mr-2"></i>
                    Retour à l'accueil
                </a>
                
                <button onclick="window.location.reload()" 
                        class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-redo mr-2"></i>
                    Réessayer
                </button>
            </div>

            @if(isset($errorId))
                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-xs text-blue-600 font-medium">
                        Code d'erreur: {{ $errorId }}
                    </p>
                    <p class="text-xs text-blue-500 mt-1">
                        Mentionnez ce code si vous contactez le support technique
                    </p>
                </div>
            @endif

            <!-- Contact support -->
            <div class="mt-6 pt-4 border-t border-gray-200">
                <p class="text-xs text-gray-500 mb-2">Besoin d'aide ?</p>
                <a href="mailto:support@nifacargo.com" 
                   class="text-xs text-blue-600 hover:text-blue-500">
                    <i class="fas fa-envelope mr-1"></i>
                    support@nifacargo.com
                </a>
            </div>
        </div>
    </div>
</div>
@endsection