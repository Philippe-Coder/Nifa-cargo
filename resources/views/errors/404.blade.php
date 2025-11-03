@extends('layouts.app')

@section('title', 'Erreur 404 - Page non trouvée')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 text-center">
            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100 mb-6">
                <i class="fas fa-exclamation-triangle text-3xl text-red-600"></i>
            </div>

            <!-- Titre -->
            <h2 class="text-3xl font-extrabold text-gray-900 mb-4">
                Page non trouvée
            </h2>

            <!-- Message -->
            <p class="text-sm text-gray-600 mb-6">
                Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
            </p>

            <!-- Actions -->
            <div class="space-y-3">
                <a href="{{ route('home') }}" 
                   class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-home mr-2"></i>
                    Retour à l'accueil
                </a>
                
                <button onclick="history.back()" 
                        class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Page précédente
                </button>
            </div>

            @if(isset($errorId))
                <div class="mt-6 p-3 bg-gray-100 rounded-lg">
                    <p class="text-xs text-gray-500">
                        Code d'erreur: {{ $errorId }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection