@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Détails de la demande</h1>

    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Informations principales</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="mb-2"><span class="font-semibold">Type de transport :</span> {{ ucfirst($demande->type) }}</p>
                <p class="mb-2"><span class="font-semibold">Marchandise :</span> {{ $demande->marchandise ?? 'Non spécifiée' }}</p>
                <p class="mb-2"><span class="font-semibold">Poids :</span> {{ $demande->poids ? $demande->poids . ' kg' : 'Non spécifié' }}</p>
                <p class="mb-2"><span class="font-semibold">Origine :</span> {{ $demande->origine ?? 'Non spécifiée' }}</p>
                <p class="mb-2"><span class="font-semibold">Destination :</span> {{ $demande->destination ?? 'Non spécifiée' }}</p>
                <p class="mb-2"><span class="font-semibold">Description :</span> {{ $demande->description ?? 'Aucune description' }}</p>
            </div>
            <div>
                <p class="mb-2"><span class="font-semibold">Client :</span> {{ $demande->user->name }}</p>
                <p class="mb-2"><span class="font-semibold">Email :</span> {{ $demande->user->email }}</p>
                <p class="mb-2"><span class="font-semibold">Date de création :</span> {{ $demande->created_at->format('d/m/Y H:i') }}</p>
                <p class="mb-2"><span class="font-semibold">Statut :</span> 
                    <span class="px-2 py-1 rounded text-sm font-medium
                        @switch($demande->statut)
                            @case('en attente') bg-yellow-100 text-yellow-800 @break
                            @case('validée') bg-blue-100 text-blue-800 @break
                            @case('en transit') bg-orange-100 text-orange-800 @break
                            @case('livrée') bg-green-100 text-green-800 @break
                            @default bg-gray-100 text-gray-800
                        @endswitch">
                        {{ ucfirst($demande->statut) }}
                    </span>
                </p>
            </div>
        </div>
    </div>

    {{-- Section Workflow Logistique --}}
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Workflow Logistique</h2>
        
        @if($demande->etapes->count() > 0)
            <div class="space-y-4">
                @foreach($demande->etapes as $etape)
                    <div class="border rounded-lg p-4 
                        @if($etape->statut == 'terminee') bg-green-50 border-green-200
                        @elseif($etape->statut == 'en_cours') bg-blue-50 border-blue-200
                        @else bg-gray-50 border-gray-200 @endif">
                        
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $etape->nom }}</h3>
                                <p class="text-sm text-gray-600">{{ $etape->description }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($etape->statut == 'terminee') bg-green-100 text-green-800
                                @elseif($etape->statut == 'en_cours') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $etape->statut)) }}
                            </span>
                        </div>

                        @if($etape->agent)
                            <p class="text-sm text-gray-600 mb-2">
                                <strong>Agent:</strong> {{ $etape->agent->name }}
                            </p>
                        @endif

                        @if($etape->date_debut)
                            <p class="text-sm text-gray-600 mb-2">
                                <strong>Début:</strong> {{ $etape->date_debut->format('d/m/Y H:i') }}
                            </p>
                        @endif

                        @if($etape->date_fin)
                            <p class="text-sm text-gray-600 mb-2">
                                <strong>Fin:</strong> {{ $etape->date_fin->format('d/m/Y H:i') }}
                            </p>
                        @endif

                        @if($etape->commentaire)
                            <p class="text-sm text-gray-600 mb-3">
                                <strong>Commentaire:</strong> {{ $etape->commentaire }}
                            </p>
                        @endif

                        {{-- Documents de l'étape --}}
                        @if($etape->documents && $etape->documents->count() > 0)
                            <div class="mt-3 pt-3 border-t border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-700 mb-2">📎 Documents de cette étape</h4>
                                <div class="space-y-2">
                                    @foreach($etape->documents as $doc)
                                        <div class="flex items-center justify-between bg-gray-50 p-2 rounded">
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs text-gray-600">📄 {{ $doc->nom }}</span>
                                                <span class="text-xs text-gray-400">({{ number_format($doc->taille / 1024, 2) }} KB)</span>
                                            </div>
                                            <div class="flex gap-2">
                                                <a href="{{ route('etape-documents.download', $doc->id) }}" 
                                                   class="text-blue-600 hover:underline text-xs">Télécharger</a>
                                                <form action="{{ route('etape-documents.destroy', $doc->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline text-xs" 
                                                            onclick="return confirm('Supprimer ce document ?')">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Formulaire d'upload de document pour cette étape --}}
                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <details class="mb-3">
                                <summary class="cursor-pointer text-sm font-medium text-gray-700 hover:text-blue-600">
                                    📤 Ajouter un document à cette étape
                                </summary>
                                <form action="{{ route('etape-documents.store', $etape->id) }}" method="POST" enctype="multipart/form-data" class="mt-3 space-y-3">
                                    @csrf
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Fichier *</label>
                                        <input type="file" name="document" required
                                               class="border rounded px-2 py-1 text-sm w-full"
                                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xls,.xlsx">
                                        <p class="text-xs text-gray-500 mt-1">PDF, Word, Excel, Images (max 10MB)</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Description</label>
                                        <input type="text" name="description" 
                                               class="border rounded px-2 py-1 text-sm w-full" 
                                               placeholder="Description du document">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Visibilité *</label>
                                        <select name="visibilite" required class="border rounded px-2 py-1 text-sm">
                                            <option value="tous">Visible par tous (admin + client)</option>
                                            <option value="admin">Admin uniquement</option>
                                            <option value="client">Client uniquement</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                        ✓ Uploader le document
                                    </button>
                                </form>
                            </details>
                        </div>

                        {{-- Actions pour l'étape --}}
                        @if($etape->statut !== 'terminee')
                            <div class="mt-3 pt-3 border-t border-gray-200">
                                <form action="{{ route('admin.etapes.updateStatut', $etape->id) }}" method="POST" class="flex gap-3 items-end">
                                    @csrf
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Statut</label>
                                        <select name="statut" class="border rounded px-2 py-1 text-sm">
                                            <option value="en_attente" {{ $etape->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                            <option value="en_cours" {{ $etape->statut == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                            <option value="terminee" {{ $etape->statut == 'terminee' ? 'selected' : '' }}>Terminée</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Commentaire</label>
                                        <input type="text" name="commentaire" value="{{ $etape->commentaire }}" 
                                               class="border rounded px-2 py-1 text-sm w-48" placeholder="Commentaire optionnel">
                                    </div>
                                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                        Mettre à jour
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Barre de progression --}}
            <div class="mt-6">
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Progression</span>
                    <span>{{ $demande->pourcentage_progression }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $demande->pourcentage_progression }}%"></div>
                </div>
            </div>
        @else
            <p class="text-gray-600">Aucune étape définie pour cette demande.</p>
        @endif
    </div>

    {{-- Section Documents --}}
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Documents Associés</h2>
        
        @php
            $documentsGeneraux = $demande->documents;
            $documentsEtapes = $demande->documentsEtapes();
            $tousDocuments = $documentsGeneraux->merge($documentsEtapes);
        @endphp
        
        @if($tousDocuments->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                {{-- Documents généraux de la demande --}}
                @foreach($documentsGeneraux as $document)
                    <div class="border rounded-lg p-3 bg-gray-50">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <h4 class="font-medium text-gray-800 text-sm">{{ $document->nom }}</h4>
                                <p class="text-xs text-gray-600">{{ ucfirst(str_replace('_', ' ', $document->type)) }}</p>
                                <span class="inline-block mt-1 px-2 py-0.5 bg-blue-100 text-blue-800 text-xs rounded">Document général</span>
                            </div>
                            <span class="text-xs text-gray-500">{{ $document->taille_formattee }}</span>
                        </div>
                        <p class="text-xs text-gray-500 mb-3">
                            Uploadé par {{ $document->uploadedBy->name }} le {{ $document->created_at->format('d/m/Y') }}
                        </p>
                        <div class="flex gap-2">
                            <a href="{{ route('documents.download', $document->id) }}" 
                               class="text-blue-600 hover:underline text-sm">Télécharger</a>
                        </div>
                    </div>
                @endforeach
                
                {{-- Documents des étapes --}}
                @foreach($documentsEtapes as $document)
                    <div class="border rounded-lg p-3 bg-green-50">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <h4 class="font-medium text-gray-800 text-sm">{{ $document->nom }}</h4>
                                <p class="text-xs text-gray-600">{{ $document->type }}</p>
                                <span class="inline-block mt-1 px-2 py-0.5 bg-green-100 text-green-800 text-xs rounded">
                                    {{ $document->etapeLogistique->nom }}
                                </span>
                            </div>
                            <span class="text-xs text-gray-500">{{ number_format($document->taille / 1024, 2) }} KB</span>
                        </div>
                        <p class="text-xs text-gray-500 mb-3">
                            Uploadé par {{ $document->user->name }} le {{ $document->created_at->format('d/m/Y') }}
                        </p>
                        <div class="flex gap-2">
                            <a href="{{ route('etape-documents.download', $document->id) }}" 
                               class="text-blue-600 hover:underline text-sm">Télécharger</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Aucun document uploadé pour cette demande.</p>
        @endif
    </div>

    {{-- Section Action Admin --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Mettre à jour le statut</h2>

        <form action="{{ route('admin.demandes.updateStatut', $demande->id) }}" method="POST" class="flex items-center gap-4">
            @csrf
            <select name="statut" class="border rounded p-2">
                @foreach(['en attente', 'validée', 'en transit', 'livrée'] as $statut)
                    <option value="{{ $statut }}" {{ $demande->statut == $statut ? 'selected' : '' }}>
                        {{ ucfirst($statut) }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Mettre à jour
            </button>
        </form>
    </div>

    {{-- Bouton retour --}}
    <div class="mt-6">
        <a href="{{ route('admin.demandes.index') }}" class="text-blue-600 hover:underline">← Retour à la liste</a>
    </div>
</div>
@endsection
