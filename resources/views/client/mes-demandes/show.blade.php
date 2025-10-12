@extends('layouts.dashboard')

@section('title', 'Détails Demande - NIFA')
@section('page-title', 'Détails de la Demande')

@section('content')
<!-- Breadcrumb -->
<nav class="mb-6 fade-in">
    <ol class="flex items-center space-x-2 text-sm text-gray-600">
        <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
        <li><i class="fas fa-chevron-right mx-2"></i></li>
        <li><a href="{{ route('mes-demandes') }}" class="hover:text-blue-600">Mes Demandes</a></li>
        <li><i class="fas fa-chevron-right mx-2"></i></li>
        <li class="text-gray-900 font-medium">{{ $demande->reference ?? 'REF-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT) }}</li>
    </ol>
</nav>

<!-- Header avec actions -->
<div class="dashboard-card p-6 mb-8 fade-in">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                {{ $demande->reference ?? 'REF-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT) }}
            </h1>
            <div class="flex items-center gap-4 text-sm text-gray-600">
                <span class="flex items-center">
                    <i class="fas fa-calendar mr-2"></i>
                    Créée le {{ $demande->created_at->format('d/m/Y à H:i') }}
                </span>
                <span class="flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    {{ $demande->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
        
        <div class="flex flex-wrap gap-2">
            <span class="status-badge status-{{ str_replace(' ', '-', strtolower($demande->statut)) }}">
                {{ $demande->statut }}
            </span>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                <i class="fas fa-download mr-2"></i> Télécharger PDF
            </button>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                <i class="fas fa-share mr-2"></i> Partager
            </button>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Colonne principale -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Informations de la demande -->
        <div class="dashboard-card p-6 fade-in">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">
                <i class="fas fa-info-circle mr-2 text-blue-500"></i> Informations de la Demande
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-900 mb-3">Détails du Transport</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Type :</span>
                            <span class="font-medium">{{ ucfirst($demande->type) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Départ :</span>
                            <span class="font-medium">{{ $demande->ville_depart }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Destination :</span>
                            <span class="font-medium">{{ $demande->ville_destination }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date souhaitée :</span>
                            <span class="font-medium">{{ $demande->date_souhaitee ? \Carbon\Carbon::parse($demande->date_souhaitee)->format('d/m/Y') : 'Non spécifiée' }}</span>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-900 mb-3">Informations Colis</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Poids :</span>
                            <span class="font-medium">{{ $demande->poids ?? 'Non spécifié' }} kg</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dimensions :</span>
                            <span class="font-medium">{{ $demande->dimensions ?? 'Non spécifiées' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Valeur :</span>
                            <span class="font-medium">{{ $demande->valeur ? number_format($demande->valeur) . ' F CFA' : 'Non spécifiée' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Fragile :</span>
                            <span class="font-medium">{{ $demande->fragile ? 'Oui' : 'Non' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($demande->description)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-3">Description</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $demande->description }}</p>
                </div>
            @endif
        </div>
        
        <!-- Suivi des étapes -->
        <div class="dashboard-card p-6 fade-in">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">
                <i class="fas fa-route mr-2 text-green-500"></i> Suivi du Transport
            </h2>
            
            @if($demande->etapes && $demande->etapes->count() > 0)
                <div class="relative">
                    @foreach($demande->etapes as $index => $etape)
                        <div class="flex items-start mb-8 last:mb-0">
                            <!-- Timeline -->
                            <div class="flex flex-col items-center mr-4">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center
                                    @if($etape->statut === 'terminée') bg-green-500 text-white
                                    @elseif($etape->statut === 'en_cours') bg-blue-500 text-white
                                    @else bg-gray-300 text-gray-600 @endif">
                                    @if($etape->statut === 'terminée')
                                        <i class="fas fa-check"></i>
                                    @elseif($etape->statut === 'en_cours')
                                        <i class="fas fa-clock"></i>
                                    @else
                                        <i class="fas fa-circle"></i>
                                    @endif
                                </div>
                                @if(!$loop->last)
                                    <div class="w-0.5 h-16 
                                        @if($etape->statut === 'terminée') bg-green-500
                                        @else bg-gray-300 @endif mt-2"></div>
                                @endif
                            </div>
                            
                            <!-- Contenu -->
                            <div class="flex-1 min-w-0">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="font-semibold text-gray-900">{{ $etape->nom }}</h3>
                                        <span class="text-sm text-gray-500">
                                            {{ $etape->date_prevue ? \Carbon\Carbon::parse($etape->date_prevue)->format('d/m/Y') : '' }}
                                        </span>
                                    </div>
                                    
                                    @if($etape->description)
                                        <p class="text-gray-600 text-sm mb-3">{{ $etape->description }}</p>
                                    @endif
                                    
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="status-badge status-{{ str_replace(' ', '-', strtolower($etape->statut)) }}">
                                            {{ ucfirst(str_replace('_', ' ', $etape->statut)) }}
                                        </span>
                                        
                                        @if($etape->agent)
                                            <span class="text-gray-600">
                                                <i class="fas fa-user mr-1"></i> {{ $etape->agent->name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-4xl mb-4">🚚</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Suivi en préparation</h3>
                    <p class="text-gray-600">Les étapes de suivi seront disponibles une fois votre demande traitée.</p>
                </div>
            @endif
        </div>
        
        <!-- Documents -->
        <div class="dashboard-card p-6 fade-in">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">
                    <i class="fas fa-file-alt mr-2 text-purple-500"></i> Documents
                </h2>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                    <i class="fas fa-upload mr-2"></i> Ajouter un document
                </button>
            </div>
            
            @if($demande->documents && $demande->documents->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($demande->documents as $document)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-file text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $document->nom }}</h4>
                                        <p class="text-sm text-gray-600">{{ $document->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('documents.download', $document) }}" 
                                   class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-4xl mb-4">📄</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun document</h3>
                    <p class="text-gray-600">Les documents liés à votre demande apparaîtront ici.</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Résumé -->
        <div class="dashboard-card p-6 fade-in">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                <i class="fas fa-chart-pie mr-2 text-orange-500"></i> Résumé
            </h3>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Statut actuel :</span>
                    <span class="status-badge status-{{ str_replace(' ', '-', strtolower($demande->statut)) }}">
                        {{ $demande->statut }}
                    </span>
                </div>
                
                @if($demande->etapes && $demande->etapes->count() > 0)
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Progression :</span>
                        <span class="font-medium">
                            {{ $demande->etapes->where('statut', 'terminée')->count() }}/{{ $demande->etapes->count() }}
                        </span>
                    </div>
                    
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        @php
                            $progress = ($demande->etapes->where('statut', 'terminée')->count() / $demande->etapes->count()) * 100;
                        @endphp
                        <div class="bg-gradient-to-r from-blue-600 to-green-600 h-2 rounded-full" 
                             style="width: {{ $progress }}%"></div>
                    </div>
                @endif
                
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Documents :</span>
                    <span class="font-medium">{{ $demande->documents ? $demande->documents->count() : 0 }}</span>
                </div>
            </div>
        </div>
        
        <!-- Actions rapides -->
        <div class="dashboard-card p-6 fade-in">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                <i class="fas fa-bolt mr-2 text-yellow-500"></i> Actions Rapides
            </h3>
            
            <div class="space-y-3">
                <button class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                    <i class="fas fa-phone mr-2"></i> Contacter le support
                </button>
                
                <button class="w-full flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                    <i class="fas fa-whatsapp mr-2"></i> WhatsApp
                </button>
                
                <button class="w-full flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                    <i class="fas fa-print mr-2"></i> Imprimer
                </button>
            </div>
        </div>
        
        <!-- Informations de contact -->
        <div class="dashboard-card p-6 fade-in">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                <i class="fas fa-headset mr-2 text-red-500"></i> Besoin d'aide ?
            </h3>
            
            <div class="space-y-3 text-sm">
                <div class="flex items-center">
                    <i class="fas fa-phone mr-3 text-blue-500"></i>
                    <span>+228 22 61 00 00</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-envelope mr-3 text-green-500"></i>
                    <span>support@nifa.tg</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-clock mr-3 text-orange-500"></i>
                    <span>Lun-Ven: 8h-18h</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
