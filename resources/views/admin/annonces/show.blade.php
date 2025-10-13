@extends('layouts.dashboard')

@section('title', 'Aperçu de l\'Annonce')

@section('hero')
<div class="hero-bg-home relative overflow-hidden">
    <div class="hero-overlay"></div>
    <div class="floating-particles"></div>
    <div class="relative z-10 text-center text-white py-20">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in">
                👁️ Aperçu de l'Annonce
            </h1>
            <p class="text-xl md:text-2xl opacity-90 animate-slide-up">
                Prévisualisation de l'affichage public
            </p>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Actions rapides -->
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.annonces.index') }}" 
           class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour à la liste
        </a>
        
        <div class="flex space-x-2">
            <a href="{{ route('admin.annonces.edit', $annonce) }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-edit mr-2"></i>
                Modifier
            </a>
            
            <form action="{{ route('admin.annonces.toggle-active', $annonce) }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        class="px-4 py-2 rounded-lg transition-colors {{ $annonce->active ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-green-600 hover:bg-green-700 text-white' }}">
                    <i class="fas fa-{{ $annonce->active ? 'eye-slash' : 'eye' }} mr-2"></i>
                    {{ $annonce->active ? 'Désactiver' : 'Activer' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Aperçu de l'annonce (comme elle apparaîtra sur le site public) -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-8 py-6">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-bullhorn mr-3"></i>
                    Aperçu Public
                </h2>
                
                <!-- Badges de statut -->
                <div class="flex items-center space-x-2">
                    @if($annonce->epingle)
                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                            <i class="fas fa-thumbtack mr-1"></i>
                            Épinglé
                        </span>
                    @endif
                    
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $annonce->active ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                        <i class="fas fa-{{ $annonce->active ? 'eye' : 'eye-slash' }} mr-1"></i>
                        {{ $annonce->active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-8">
            <!-- Simulation de l'affichage public -->
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 bg-gray-50">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <!-- En-tête de l'annonce -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-start mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $annonce->type_class }}">
                                {{ $annonce->type_formate }}
                            </span>
                            
                            @if($annonce->epingle)
                                <div class="text-yellow-500">
                                    <i class="fas fa-thumbtack"></i>
                                </div>
                            @endif
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">
                            {{ $annonce->titre }}
                        </h3>
                        
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-calendar mr-1"></i>
                            Publié le {{ $annonce->created_at->format('d/m/Y') }}
                            
                            @if($annonce->date_debut || $annonce->date_fin)
                                <span class="ml-4">
                                    <i class="fas fa-clock mr-1"></i>
                                    @if($annonce->date_debut && $annonce->date_fin)
                                        Valide du {{ $annonce->date_debut->format('d/m/Y') }} au {{ $annonce->date_fin->format('d/m/Y') }}
                                    @elseif($annonce->date_debut)
                                        À partir du {{ $annonce->date_debut->format('d/m/Y') }}
                                    @else
                                        Jusqu'au {{ $annonce->date_fin->format('d/m/Y') }}
                                    @endif
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Image -->
                    @if($annonce->image)
                        <div class="px-6 py-4">
                            <img src="{{ asset('storage/' . $annonce->image) }}" 
                                 alt="{{ $annonce->titre }}"
                                 class="w-full max-h-64 object-cover rounded-lg">
                        </div>
                    @endif
                    
                    <!-- Contenu -->
                    <div class="px-6 pb-6">
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($annonce->contenu)) !!}
                        </div>
                    </div>
                </div>
            </div>
            
            <p class="text-center text-sm text-gray-500 mt-4">
                <i class="fas fa-info-circle mr-1"></i>
                Ceci est un aperçu de l'affichage sur le site public
            </p>
        </div>
    </div>

    <!-- Informations techniques -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-gray-600 to-gray-800 px-8 py-6">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-cog mr-3"></i>
                Informations Techniques
            </h2>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">ID</label>
                        <p class="text-gray-900">{{ $annonce->id }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Type</label>
                        <p class="text-gray-900">{{ $annonce->type_formate }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Ordre d'affichage</label>
                        <p class="text-gray-900">{{ $annonce->ordre }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Statut</label>
                        <div class="flex items-center space-x-4">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $annonce->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $annonce->active ? 'Active' : 'Inactive' }}
                            </span>
                            
                            @if($annonce->epingle)
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Épinglé
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Créé par</label>
                        <p class="text-gray-900">{{ $annonce->user->name }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Date de création</label>
                        <p class="text-gray-900">{{ $annonce->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Dernière modification</label>
                        <p class="text-gray-900">{{ $annonce->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Validité</label>
                        <p class="text-gray-900">
                            @if($annonce->estValide())
                                <span class="text-green-600">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Valide
                                </span>
                            @else
                                <span class="text-red-600">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Hors période
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
            @if($annonce->image)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <label class="text-sm font-semibold text-gray-700 block mb-2">Image</label>
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $annonce->image) }}" 
                             alt="{{ $annonce->titre }}"
                             class="w-20 h-20 object-cover rounded-lg border">
                        <div class="text-sm text-gray-600">
                            <p>Fichier : {{ basename($annonce->image) }}</p>
                            <p>Chemin : storage/{{ $annonce->image }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
