@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- En-tête -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    📦 {{ $demande->marchandise ?? 'Transport' }} - {{ ucfirst($demande->type) }}
                </h1>
                <p class="mt-2 text-gray-600">{{ $demande->origine }} → {{ $demande->destination }}</p>
            </div>
            <span class="inline-flex px-4 py-2 rounded-full text-lg font-medium
                @if($demande->statut == 'livrée') bg-green-100 text-green-800
                @elseif($demande->statut == 'en transit') bg-blue-100 text-blue-800
                @elseif($demande->statut == 'validée') bg-yellow-100 text-yellow-800
                @else bg-gray-100 text-gray-800 @endif">
                {{ ucfirst($demande->statut) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Colonne principale -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Suivi en temps réel -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">🚚 Suivi en temps réel</h2>
                
                <!-- Barre de progression globale -->
                <div class="mb-8">
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>Progression globale</span>
                        <span class="font-semibold">{{ $demande->pourcentage_progression }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full transition-all duration-500" 
                             style="width: {{ $demande->pourcentage_progression }}%"></div>
                    </div>
                </div>

                <!-- Timeline des étapes -->
                <div class="space-y-6">
                    @foreach($demande->etapes as $index => $etape)
                        <div class="flex items-start">
                            <!-- Icône de statut -->
                            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center
                                @if($etape->statut == 'terminee') bg-green-500 text-white
                                @elseif($etape->statut == 'en_cours') bg-blue-500 text-white animate-pulse
                                @else bg-gray-300 text-gray-600 @endif">
                                @if($etape->statut == 'terminee')
                                    ✓
                                @elseif($etape->statut == 'en_cours')
                                    ⏳
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </div>

                            <!-- Ligne de connexion -->
                            @if(!$loop->last)
                                <div class="absolute left-4 mt-8 w-0.5 h-6
                                    @if($etape->statut == 'terminee') bg-green-500
                                    @else bg-gray-300 @endif"></div>
                            @endif

                            <!-- Contenu de l'étape -->
                            <div class="ml-4 flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $etape->nom }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">{{ $etape->description }}</p>
                                        
                                        @if($etape->agent)
                                            <p class="text-xs text-gray-500 mt-2">
                                                👤 Agent: {{ $etape->agent->name }}
                                            </p>
                                        @endif

                                        @if($etape->commentaire)
                                            <p class="text-sm text-blue-700 mt-2 bg-blue-50 p-2 rounded">
                                                💬 {{ $etape->commentaire }}
                                            </p>
                                        @endif
                                    </div>
                                    
                                    <div class="text-right text-xs text-gray-500">
                                        @if($etape->date_debut)
                                            <p>Début: {{ $etape->date_debut->format('d/m H:i') }}</p>
                                        @endif
                                        @if($etape->date_fin)
                                            <p>Fin: {{ $etape->date_fin->format('d/m H:i') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Gestion des documents -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">📄 Documents</h2>
                
                <!-- Formulaire d'upload -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="font-medium text-gray-900 mb-3">Ajouter un document</h3>
                    <form action="{{ route('documents.store', $demande->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Type de document</label>
                                <select name="type" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @foreach(\App\Models\Document::getTypesAutorises() as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fichier</label>
                                <input type="file" name="document" required accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                            📤 Uploader le document
                        </button>
                    </form>
                </div>

                <!-- Liste des documents -->
                @if($demande->documents->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($demande->documents as $document)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $document->nom }}</h4>
                                        <p class="text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $document->type)) }}</p>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $document->taille_formattee }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mb-3">
                                    Uploadé le {{ $document->created_at->format('d/m/Y à H:i') }}
                                </p>
                                <div class="flex gap-2">
                                    <a href="{{ route('documents.download', $document->id) }}" 
                                       class="text-blue-600 hover:underline text-sm">📥 Télécharger</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-center py-4">Aucun document uploadé pour cette demande.</p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Informations de la demande -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">ℹ️ Informations</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Type:</span>
                        <span class="text-gray-900">{{ ucfirst($demande->type) }}</span>
                    </div>
                    @if($demande->poids)
                        <div>
                            <span class="font-medium text-gray-700">Poids:</span>
                            <span class="text-gray-900">{{ $demande->poids }} kg</span>
                        </div>
                    @endif
                    <div>
                        <span class="font-medium text-gray-700">Créée le:</span>
                        <span class="text-gray-900">{{ $demande->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                    @if($demande->description)
                        <div>
                            <span class="font-medium text-gray-700">Description:</span>
                            <p class="text-gray-900 mt-1">{{ $demande->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Notifications récentes -->
            @if($demande->notifications->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">🔔 Notifications récentes</h3>
                    <div class="space-y-3">
                        @foreach($demande->notifications->take(5) as $notification)
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="font-medium text-sm text-gray-900">{{ $notification->titre }}</p>
                                <p class="text-xs text-gray-600 mt-1">{{ $notification->created_at->format('d/m à H:i') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Actions rapides -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">⚡ Actions rapides</h3>
                <div class="space-y-3">
                    <a href="{{ route('client.suivi.index') }}" 
                       class="block w-full text-center bg-gray-100 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-200 transition-colors">
                        📋 Toutes mes demandes
                    </a>
                    <a href="{{ route('demande.create') }}" 
                       class="block w-full text-center bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
                        ➕ Nouvelle demande
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
