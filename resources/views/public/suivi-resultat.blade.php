@extends('layouts.main')

@section('title', 'Résultat du suivi - ' . $demande->reference)

@section('hero')
<div class="hero-bg-contact relative overflow-hidden">
    <div class="hero-overlay"></div>
    <div class="floating-particles"></div>
    <div class="relative z-10 text-center text-white py-20">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in">
                Suivi de Demande
            </h1>
            <p class="text-xl md:text-2xl opacity-90 animate-slide-up">
                Référence : {{ $demande->reference }}
            </p>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Informations de la demande -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-red-600 px-8 py-6">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-info-circle mr-3"></i>
                Informations de la Demande
            </h2>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-hashtag text-blue-600 mr-2"></i>
                        <span class="font-semibold text-gray-700">Référence</span>
                    </div>
                    <p class="text-lg font-bold text-gray-900">{{ $demande->reference }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-box text-blue-600 mr-2"></i>
                        <span class="font-semibold text-gray-700">Marchandise</span>
                    </div>
                    <p class="text-lg font-bold text-gray-900">{{ $demande->marchandise }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exchange-alt text-blue-600 mr-2"></i>
                        <span class="font-semibold text-gray-700">Type</span>
                    </div>
                    <p class="text-lg font-bold text-gray-900 capitalize">{{ $demande->type_transport }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>
                        <span class="font-semibold text-gray-700">Origine</span>
                    </div>
                    <p class="text-lg font-bold text-gray-900">{{ $demande->origine }}</p>
                    @if($demande->ville_depart)
                        <p class="text-sm text-gray-600">{{ $demande->ville_depart }}</p>
                    @endif
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-map-marker-alt text-red-600 mr-2"></i>
                        <span class="font-semibold text-gray-700">Destination</span>
                    </div>
                    <p class="text-lg font-bold text-gray-900">{{ $demande->destination }}</p>
                    @if($demande->ville_destination)
                        <p class="text-sm text-gray-600">{{ $demande->ville_destination }}</p>
                    @endif
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-info-circle text-purple-600 mr-2"></i>
                        <span class="font-semibold text-gray-700">Statut</span>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($demande->statut == 'en attente') bg-yellow-100 text-yellow-800
                        @elseif($demande->statut == 'validée') bg-blue-100 text-blue-800
                        @elseif($demande->statut == 'en cours') bg-orange-100 text-orange-800
                        @elseif($demande->statut == 'en transit') bg-purple-100 text-purple-800
                        @elseif($demande->statut == 'livrée') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        <i class="fas fa-circle mr-1 text-xs"></i>
                        {{ ucfirst($demande->statut) }}
                    </span>
                </div>
            </div>

            @if($demande->description)
                <div class="mt-6 bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-comment text-blue-600 mr-2"></i>
                        <span class="font-semibold text-gray-700">Description</span>
                    </div>
                    <p class="text-gray-900">{{ $demande->description }}</p>
                </div>
            @endif

            @if($demande->poids || $demande->dimensions || $demande->valeur)
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    @if($demande->poids)
                        <div class="bg-blue-50 rounded-lg p-4 text-center">
                            <i class="fas fa-weight text-blue-600 text-2xl mb-2"></i>
                            <p class="text-sm text-gray-600">Poids</p>
                            <p class="text-lg font-bold text-blue-900">{{ $demande->poids }} kg</p>
                        </div>
                    @endif

                    @if($demande->dimensions)
                        <div class="bg-green-50 rounded-lg p-4 text-center">
                            <i class="fas fa-ruler-combined text-green-600 text-2xl mb-2"></i>
                            <p class="text-sm text-gray-600">Dimensions</p>
                            <p class="text-lg font-bold text-green-900">{{ $demande->dimensions }}</p>
                        </div>
                    @endif

                    @if($demande->valeur)
                        <div class="bg-yellow-50 rounded-lg p-4 text-center">
                            <i class="fas fa-dollar-sign text-yellow-600 text-2xl mb-2"></i>
                            <p class="text-sm text-gray-600">Valeur déclarée</p>
                            <p class="text-lg font-bold text-yellow-900">{{ number_format($demande->valeur, 0, ',', ' ') }} FCFA</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Timeline des étapes -->
    @if($demande->etapes && $demande->etapes->count() > 0)
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-blue-600 px-8 py-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-route mr-3"></i>
                    Suivi Logistique
                </h2>
            </div>

            <div class="p-8">
                <div class="relative">
                    @foreach($demande->etapes->sortBy('ordre') as $index => $etape)
                        <div class="flex items-start mb-8 {{ $loop->last ? 'mb-0' : '' }}">
                            <!-- Timeline line -->
                            @if(!$loop->last)
                                <div class="absolute left-6 top-12 w-0.5 h-16 bg-gray-200"></div>
                            @endif
                            
                            <!-- Timeline dot -->
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-blue-500 to-green-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg z-10">
                                {{ $index + 1 }}
                            </div>
                            
                            <!-- Content -->
                            <div class="ml-6 flex-1">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $etape->nom }}</h3>
                                    @if($etape->description)
                                        <p class="text-gray-700 mb-2">{{ $etape->description }}</p>
                                    @endif
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-calendar mr-2"></i>
                                        <span>{{ $etape->created_at->format('d/m/Y à H:i') }}</span>
                                        @if($etape->agent)
                                            <span class="ml-4">
                                                <i class="fas fa-user mr-1"></i>
                                                {{ $etape->agent->name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-8 text-center">
                <i class="fas fa-info-circle text-blue-500 text-4xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune étape logistique</h3>
                <p class="text-gray-600">Le suivi logistique sera mis à jour dès que votre demande sera prise en charge.</p>
            </div>
        </div>
    @endif

    <!-- Actions -->
    <div class="mt-8 flex justify-center space-x-4">
        <a href="{{ route('suivi.public') }}" 
           class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Nouvelle recherche
        </a>
        
        @auth
            <a href="{{ route('dashboard') }}" 
               class="px-6 py-3 bg-gradient-to-r from-blue-600 to-red-600 text-white rounded-lg hover:from-blue-700 hover:to-red-700 transition-all">
                <i class="fas fa-tachometer-alt mr-2"></i>
                Mon Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" 
               class="px-6 py-3 bg-gradient-to-r from-blue-600 to-red-600 text-white rounded-lg hover:from-blue-700 hover:to-red-700 transition-all">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Se connecter
            </a>
        @endauth
    </div>
</div>
@endsection
