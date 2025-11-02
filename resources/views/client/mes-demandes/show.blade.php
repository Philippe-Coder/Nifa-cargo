@extends('layouts.dashboard')

@section('title', 'Détails Demande - NIF Cargo')
@section('page-title', 'Détails de la Demande')

@section('content')
<!-- Breadcrumb -->
<nav class="mb-6">
    <ol class="flex items-center space-x-2 text-sm text-gray-600">
        <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a></li>
        <li><i class="fas fa-chevron-right mx-2 text-gray-400 text-xs"></i></li>
        <li><a href="{{ route('mes-demandes.index') }}" class="hover:text-blue-600 transition-colors">Mes Demandes</a></li>
        <li><i class="fas fa-chevron-right mx-2 text-gray-400 text-xs"></i></li>
    <li class="text-gray-900 font-medium">{{ $demande->numero_tracking ?? '—' }}</li>
    </ol>
</nav>

<!-- Header avec actions -->
<div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 mb-8">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <div class="flex items-center mb-3">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-file-invoice text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-1">
                        {{ $demande->numero_tracking ?? '—' }}
                    </h1>
                    <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                        <span class="flex items-center">
                            <i class="fas fa-calendar mr-2 text-blue-500"></i>
                            Créée le {{ $demande->created_at->format('d/m/Y à H:i') }}
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-clock mr-2 text-green-500"></i>
                            {{ $demande->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex flex-wrap gap-3">
            @php
                $statusColors = [
                    'en attente' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                    'en cours' => 'bg-blue-100 text-blue-800 border-blue-200',
                    'en transit' => 'bg-purple-100 text-purple-800 border-purple-200',
                    'livrée' => 'bg-green-100 text-green-800 border-green-200',
                    'annulée' => 'bg-red-100 text-red-800 border-red-200',
                ];
                $statusClass = $statusColors[$demande->statut] ?? 'bg-gray-100 text-gray-800 border-gray-200';
            @endphp
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium border {{ $statusClass }}">
                <i class="fas fa-circle mr-2 text-xs"></i>
                {{ ucfirst($demande->statut) }}
            </span>
            <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition-all duration-300 transform hover:scale-105 shadow-sm">
                <i class="fas fa-file-pdf mr-3"></i> Télécharger PDF
            </button>
            <button class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200 transition-colors">
                <i class="fas fa-share-alt mr-3"></i> Partager
            </button>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Colonne principale -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Informations de la demande -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-info-circle text-blue-600 text-lg"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-900">Informations de la Demande</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Détails du Transport -->
                <div class="space-y-6">
                    <h3 class="font-semibold text-gray-900 text-lg border-b border-gray-200 pb-2">Détails du Transport</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-truck text-blue-500 mr-3"></i>
                                <span class="text-gray-600">Type de transport</span>
                            </div>
                            <span class="font-medium text-gray-900">{{ ucfirst($demande->type) }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-red-500 mr-3"></i>
                                <span class="text-gray-600">Ville de départ</span>
                            </div>
                            <span class="font-medium text-gray-900">{{ $demande->ville_depart }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-flag text-green-500 mr-3"></i>
                                <span class="text-gray-600">Ville de destination</span>
                            </div>
                            <span class="font-medium text-gray-900">{{ $demande->ville_destination }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-day text-purple-500 mr-3"></i>
                                <span class="text-gray-600">Date souhaitée</span>
                            </div>
                            <span class="font-medium text-gray-900">{{ $demande->date_souhaitee ? \Carbon\Carbon::parse($demande->date_souhaitee)->format('d/m/Y') : 'Non spécifiée' }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Informations Colis -->
                <div class="space-y-6">
                    <h3 class="font-semibold text-gray-900 text-lg border-b border-gray-200 pb-2">Informations Colis</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-weight text-orange-500 mr-3"></i>
                                <span class="text-gray-600">Poids estimé</span>
                            </div>
                            <span class="font-medium text-gray-900">{{ $demande->poids ?? 'Non spécifié' }} kg</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-ruler-combined text-indigo-500 mr-3"></i>
                                <span class="text-gray-600">Dimensions</span>
                            </div>
                            <span class="font-medium text-gray-900">{{ $demande->dimensions ?? 'Non spécifiées' }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-tag text-green-500 mr-3"></i>
                                <span class="text-gray-600">Valeur déclarée</span>
                            </div>
                            <span class="font-medium text-gray-900">{{ $demande->valeur ? number_format($demande->valeur) . ' FCFA' : 'Non spécifiée' }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mr-3"></i>
                                <span class="text-gray-600">Marchandise fragile</span>
                            </div>
                            <span class="font-medium text-gray-900">{{ $demande->fragile ? 'Oui' : 'Non' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($demande->description)
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-file-alt text-blue-500 mr-3"></i>
                        Description additionnelle
                    </h3>
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                        <p class="text-gray-700 leading-relaxed">{{ $demande->description }}</p>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Suivi des étapes -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-route text-green-600 text-lg"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-900">Suivi du Transport</h2>
            </div>
            
            @if($demande->etapes && $demande->etapes->count() > 0)
                <div class="relative">
                    @foreach($demande->etapes->sortBy('ordre') as $index => $etape)
                        <div class="flex items-start mb-8 last:mb-0 group">
                            <!-- Timeline -->
                            <div class="flex flex-col items-center mr-6">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center border-2 shadow-sm
                                    @if($etape->statut === 'terminée') bg-green-500 border-green-600 text-white
                                    @elseif($etape->statut === 'en_cours') bg-blue-500 border-blue-600 text-white
                                    @else bg-white border-gray-300 text-gray-400 @endif
                                    group-hover:scale-110 transition-transform duration-300">
                                    @if($etape->statut === 'terminée')
                                        <i class="fas fa-check text-sm"></i>
                                    @elseif($etape->statut === 'en_cours')
                                        <i class="fas fa-sync-alt text-sm"></i>
                                    @else
                                        <i class="fas fa-clock text-sm"></i>
                                    @endif
                                </div>
                                @if(!$loop->last)
                                    <div class="w-1 h-16 
                                        @if($etape->statut === 'terminée') bg-green-500
                                        @else bg-gray-300 @endif mt-2 rounded-full"></div>
                                @endif
                            </div>
                            
                            <!-- Contenu -->
                            <div class="flex-1 min-w-0">
                                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 group-hover:border-blue-300 transition-colors">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3 gap-2">
                                        <h3 class="font-semibold text-gray-900 text-lg">{{ $etape->nom }}</h3>
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-calendar mr-2 text-blue-500"></i>
                                            {{ $etape->date_prevue ? \Carbon\Carbon::parse($etape->date_prevue)->format('d/m/Y') : 'Date à définir' }}
                                        </div>
                                    </div>
                                    
                                    @if($etape->description)
                                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">{{ $etape->description }}</p>
                                    @endif
                                    
                                    {{-- Documents de l'étape --}}
                                    @if($etape->documents && $etape->documents->count() > 0)
                                        <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-100">
                                            <h4 class="text-xs font-semibold text-gray-700 mb-2 flex items-center">
                                                <i class="fas fa-paperclip mr-2 text-blue-600"></i>
                                                Documents disponibles ({{ $etape->documents->count() }})
                                            </h4>
                                            <div class="space-y-2">
                                                @foreach($etape->documents as $doc)
                                                    @if($doc->estVisiblePour(auth()->user()))
                                                        <div class="flex items-center justify-between bg-white p-2 rounded">
                                                            <div class="flex items-center gap-2 flex-1 min-w-0">
                                                                <i class="fas fa-file-alt text-gray-400 text-xs"></i>
                                                                <span class="text-xs text-gray-700 truncate">{{ $doc->nom }}</span>
                                                                <span class="text-xs text-gray-400">({{ number_format($doc->taille / 1024, 1) }} KB)</span>
                                                            </div>
                                                            <a href="{{ route('etape-documents.download', $doc->id) }}" 
                                                               class="text-blue-600 hover:text-blue-800 text-xs font-medium ml-2 whitespace-nowrap">
                                                                <i class="fas fa-download mr-1"></i>Télécharger
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-sm">
                                        @php
                                            $etapeStatusColors = [
                                                'terminée' => 'bg-green-100 text-green-800 border-green-200',
                                                'en_cours' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'en_attente' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            ];
                                            $etapeStatusClass = $etapeStatusColors[$etape->statut] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $etapeStatusClass }}">
                                            <i class="fas fa-circle mr-2 text-xs"></i>
                                            {{ ucfirst(str_replace('_', ' ', $etape->statut)) }}
                                        </span>
                                        
                                        @if($etape->agent)
                                            <span class="text-gray-600 flex items-center">
                                                <i class="fas fa-user-circle mr-2 text-purple-500"></i>
                                                {{ $etape->agent->name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shipping-fast text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Suivi en préparation</h3>
                    <p class="text-gray-600 max-w-md mx-auto mb-6">
                        Les étapes de suivi détaillées seront disponibles une fois votre demande prise en charge par notre équipe logistique.
                    </p>
                    <div class="flex items-center justify-center text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                        Votre demande est en cours de traitement
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Documents -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-file-alt text-purple-600 text-lg"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Documents associés</h2>
                </div>
                <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition-all duration-300 transform hover:scale-105 shadow-sm">
                    <i class="fas fa-cloud-upload-alt mr-3"></i> Ajouter un document
                </button>
            </div>
            
            @php
                $documentsGeneraux = $demande->documents;
                $documentsEtapes = $demande->documentsEtapes()->filter(function($doc) {
                    return $doc->estVisiblePour(auth()->user());
                });
                $tousDocuments = $documentsGeneraux->merge($documentsEtapes);
            @endphp
            
            @if($tousDocuments->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Documents généraux --}}
                    @foreach($documentsGeneraux as $document)
                        <div class="border border-gray-200 rounded-xl p-4 hover:bg-gray-50 transition-all duration-300 group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center flex-1 min-w-0">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-blue-200 transition-colors">
                                        <i class="fas fa-file-pdf text-blue-600 text-lg"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-gray-900 truncate">{{ $document->nom }}</h4>
                                        <p class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                            {{ $document->created_at->format('d/m/Y') }}
                                        </p>
                                        <span class="inline-block mt-1 px-2 py-0.5 bg-blue-100 text-blue-800 text-xs rounded">Document général</span>
                                    </div>
                                </div>
                                <a href="{{ route('documents.download', $document) }}" 
                                   class="text-blue-600 hover:text-blue-800 transition-colors transform hover:scale-110 ml-2">
                                    <i class="fas fa-download text-lg"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                    
                    {{-- Documents des étapes --}}
                    @foreach($documentsEtapes as $document)
                        <div class="border border-green-200 rounded-xl p-4 hover:bg-green-50 transition-all duration-300 group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center flex-1 min-w-0">
                                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-green-200 transition-colors">
                                        <i class="fas fa-file-alt text-green-600 text-lg"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-gray-900 truncate">{{ $document->nom }}</h4>
                                        <p class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                            {{ $document->created_at->format('d/m/Y') }}
                                        </p>
                                        <span class="inline-block mt-1 px-2 py-0.5 bg-green-100 text-green-800 text-xs rounded">{{ $document->etapeLogistique->nom }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('etape-documents.download', $document->id) }}" 
                                   class="text-green-600 hover:text-green-800 transition-colors transform hover:scale-110 ml-2">
                                    <i class="fas fa-download text-lg"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-file-import text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Aucun document</h3>
                    <p class="text-gray-600 max-w-md mx-auto">
                        Les documents liés à votre demande (factures, bons de livraison, etc.) apparaîtront ici au fur et à mesure de l'avancement.
                    </p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Résumé -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-chart-pie text-orange-600 text-lg"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Résumé de la demande</h3>
            </div>
            
            <div class="space-y-6">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-600">Statut actuel :</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $statusClass }}">
                        {{ ucfirst($demande->statut) }}
                    </span>
                </div>
                
                @if($demande->etapes && $demande->etapes->count() > 0)
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Progression :</span>
                            <span class="font-semibold text-gray-900">
                                {{ $demande->etapes->where('statut', 'terminee')->count() }}/{{ $demande->etapes->count() }}
                            </span>
                        </div>
                        
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full transition-all duration-1000 ease-out" 
                                 style="width: {{ $demande->pourcentage_progression }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 text-center mt-1">{{ $demande->pourcentage_progression }}% complété</p>
                    </div>
                @endif
                
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-600">Documents :</span>
                    @php
                        $totalDocs = $demande->documents->count() + $demande->documentsEtapes()->filter(function($doc) {
                            return $doc->estVisiblePour(auth()->user());
                        })->count();
                    @endphp
                    <span class="font-semibold text-gray-900">{{ $totalDocs }}</span>
                </div>
            </div>
        </div>
        
        <!-- Actions rapides -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-bolt text-yellow-600 text-lg"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Actions Rapides</h3>
            </div>
            
            <div class="space-y-3">
                <button class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition-all duration-300 transform hover:scale-105 shadow-sm">
                    <i class="fas fa-phone-alt mr-3"></i> Contacter le support
                </button>
                
                <button class="w-full flex items-center justify-center px-4 py-3 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700 transition-all duration-300 transform hover:scale-105 shadow-sm">
                    <i class="fab fa-whatsapp mr-3 text-lg"></i> WhatsApp
                </button>
                
                <button class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200 transition-colors">
                    <i class="fas fa-print mr-3"></i> Imprimer les détails
                </button>
            </div>
        </div>
        
        <!-- Informations de contact -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-headset text-red-600 text-lg"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Besoin d'aide ?</h3>
            </div>
            
            <div class="space-y-4 text-sm">
                <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                    <i class="fas fa-phone mr-3 text-blue-600"></i>
                    <div>
                        <div class="font-medium text-gray-900">+228 99 25 25 31/ +229 96 36 46 07/ +226 05 79 13 10</div>
                        <div class="text-gray-600 text-xs">Support téléphonique</div>
                    </div>
                </div>
                
                <div class="flex items-center p-3 bg-green-50 rounded-lg">
                    <i class="fas fa-envelope mr-3 text-green-600"></i>
                    <div>
                        <div class="font-medium text-gray-900">contact@nifgroupecargo.com</div>
                        <div class="text-gray-600 text-xs">Email de support</div>
                    </div>
                </div>
                
                <div class="flex items-center p-3 bg-orange-50 rounded-lg">
                    <i class="fas fa-clock mr-3 text-orange-600"></i>
                    <div>
                        <div class="font-medium text-gray-900">Lun - Ven: 8h-18h</div>
                        <div class="text-gray-600 text-xs">Samedi: 8h-12h</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection