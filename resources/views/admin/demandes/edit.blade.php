@extends('layouts.dashboard')

@section('title', 'Modifier la Demande #' . $demande->id . ' - NIF Cargo Admin')
@section('page-title', 'Modifier la Demande')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-orange-600 via-orange-700 to-orange-800 rounded-2xl p-8 mb-8 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black bg-opacity-10"></div>
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.1\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"1\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    <div class="relative z-10">
        <div class="flex items-center justify-between">
            <div>
                <div class="inline-flex items-center bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-4 border border-white/30">
                    <span class="w-2 h-2 bg-orange-400 rounded-full mr-2 animate-pulse"></span>
                    <span class="text-sm font-medium">Modification de demande</span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-bold mb-3">
                    Modifier la Demande #{{ $demande->id }}
                </h1>
                <p class="text-orange-100 text-lg">
                    Client: {{ $demande->user->name }} | Numéro de suivi: {{ $demande->numero_tracking ?: '—' }}
                </p>
            </div>
            <div class="hidden lg:block">
                <div class="text-6xl opacity-20">
                    <i class="fas fa-edit"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Navigation -->
<div class="mb-6">
    <nav class="flex items-center space-x-2 text-sm text-gray-600">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">
            <i class="fas fa-home mr-1"></i> Dashboard
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('admin.demandes.index') }}" class="hover:text-blue-600 transition-colors">
            Demandes
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('admin.demandes.show', $demande->id) }}" class="hover:text-blue-600 transition-colors">
            Demande #{{ $demande->id }}
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-900 font-medium">Modifier</span>
    </nav>
</div>

<!-- Formulaire de Modification -->
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="bg-gradient-to-r from-orange-50 to-orange-100 px-8 py-6 border-b border-orange-200">
        <h2 class="text-2xl font-bold text-orange-900 flex items-center">
            <i class="fas fa-edit mr-3 text-orange-700"></i>
            Modification des Informations
        </h2>
        <p class="text-orange-700 mt-2">Modifiez les informations de la demande. Le client sera automatiquement notifié des changements significatifs.</p>
    </div>

    <form action="{{ route('admin.demandes.update', $demande->id) }}" method="POST" class="p-8">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Colonne Gauche -->
            <div class="space-y-6">
                <!-- Informations de Transport -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-shipping-fast mr-2 text-blue-600"></i>
                        Transport
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type de Transport *</label>
                            <select name="type_transport" required 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('type_transport') border-red-500 @enderror">
                                <option value="">Sélectionner...</option>
                                <option value="maritime" {{ $demande->type_transport === 'maritime' ? 'selected' : '' }}>Maritime</option>
                                <option value="aerien" {{ $demande->type_transport === 'aerien' ? 'selected' : '' }}>Aérien</option>
                                <option value="terrestre" {{ $demande->type_transport === 'terrestre' ? 'selected' : '' }}>Terrestre</option>
                            </select>
                            @error('type_transport')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Statut *</label>
                            <select name="statut" required 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('statut') border-red-500 @enderror">
                                <option value="en_attente" {{ $demande->statut === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="validee" {{ $demande->statut === 'validee' ? 'selected' : '' }}>Validée</option>
                                <option value="en_cours" {{ $demande->statut === 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="en_transit" {{ $demande->statut === 'en_transit' ? 'selected' : '' }}>En transit</option>
                                <option value="livree" {{ $demande->statut === 'livree' ? 'selected' : '' }}>Livrée</option>
                                <option value="annulee" {{ $demande->statut === 'annulee' ? 'selected' : '' }}>Annulée</option>
                            </select>
                            @error('statut')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Marchandise -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-box mr-2 text-green-600"></i>
                        Marchandise
                    </h3>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description de la marchandise *</label>
                        <input type="text" name="marchandise" value="{{ old('marchandise', $demande->marchandise) }}" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('marchandise') border-red-500 @enderror"
                               placeholder="Ex: Matériel informatique, Vêtements...">
                        @error('marchandise')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Poids (kg)</label>
                            <input type="number" name="poids" value="{{ old('poids', $demande->poids) }}" step="0.01" min="0" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('poids') border-red-500 @enderror"
                                   placeholder="0.00">
                            @error('poids')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Volume (m³)</label>
                            <input type="number" name="volume" value="{{ old('volume', $demande->volume) }}" step="0.001" min="0" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('volume') border-red-500 @enderror"
                                   placeholder="0.000">
                            @error('volume')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Valeur (FCFA)</label>
                            <input type="number" name="valeur" value="{{ old('valeur', $demande->valeur) }}" min="0" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('valeur') border-red-500 @enderror"
                                   placeholder="0">
                            @error('valeur')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne Droite -->
            <div class="space-y-6">
                <!-- Trajet -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-route mr-2 text-purple-600"></i>
                        Trajet
                    </h3>
                    
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Origine *</label>
                            <input type="text" name="origine" value="{{ old('origine', $demande->origine) }}" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('origine') border-red-500 @enderror"
                                   placeholder="Pays ou ville d'origine">
                            @error('origine')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ville de départ</label>
                            <input type="text" name="ville_depart" value="{{ old('ville_depart', $demande->ville_depart) }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('ville_depart') border-red-500 @enderror"
                                   placeholder="Ville précise de départ">
                            @error('ville_depart')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Destination *</label>
                            <input type="text" name="destination" value="{{ old('destination', $demande->destination) }}" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('destination') border-red-500 @enderror"
                                   placeholder="Pays ou ville de destination">
                            @error('destination')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ville de destination</label>
                            <input type="text" name="ville_destination" value="{{ old('ville_destination', $demande->ville_destination) }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('ville_destination') border-red-500 @enderror"
                                   placeholder="Ville précise de destination">
                            @error('ville_destination')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Informations Complémentaires -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-indigo-600"></i>
                        Informations Complémentaires
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date souhaitée</label>
                            <input type="date" name="date_souhaitee" value="{{ old('date_souhaitee', $demande->date_souhaitee?->format('Y-m-d')) }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('date_souhaitee') border-red-500 @enderror">
                            @error('date_souhaitee')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dimensions</label>
                            <input type="text" name="dimensions" value="{{ old('dimensions', $demande->dimensions) }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('dimensions') border-red-500 @enderror"
                                   placeholder="Ex: 100x50x30 cm">
                            @error('dimensions')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="fragile" value="1" {{ old('fragile', $demande->fragile) ? 'checked' : '' }}
                                       class="w-5 h-5 text-orange-600 border-gray-300 rounded focus:ring-orange-500 focus:ring-2 mr-3">
                                <span class="text-sm font-medium text-gray-700">Marchandise fragile</span>
                            </label>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description / Notes</label>
                            <textarea name="description" rows="4" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('description') border-red-500 @enderror"
                                      placeholder="Informations complémentaires...">{{ old('description', $demande->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-8 mt-8 border-t border-gray-200">
            <div class="text-sm text-gray-600">
                <i class="fas fa-info-circle mr-1"></i>
                Les champs marqués d'un * sont obligatoires
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.demandes.show', $demande->id) }}" 
                   class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                    <i class="fas fa-times mr-2"></i> Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i> Enregistrer les modifications
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Information Client -->
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mt-8">
    <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-8 py-6 border-b border-blue-200">
        <h2 class="text-2xl font-bold text-blue-900 flex items-center">
            <i class="fas fa-user mr-3 text-blue-700"></i>
            Informations Client
        </h2>
    </div>
    
    <div class="p-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center mb-2">
                    <i class="fas fa-user text-blue-600 mr-2"></i>
                    <span class="font-semibold text-gray-700">Nom</span>
                </div>
                <p class="text-lg font-bold text-gray-900">{{ $demande->user->name }}</p>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center mb-2">
                    <i class="fas fa-envelope text-blue-600 mr-2"></i>
                    <span class="font-semibold text-gray-700">Email</span>
                </div>
                <p class="text-lg font-bold text-gray-900">{{ $demande->user->email }}</p>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center mb-2">
                    <i class="fas fa-phone text-blue-600 mr-2"></i>
                    <span class="font-semibold text-gray-700">Téléphone</span>
                </div>
                <p class="text-lg font-bold text-gray-900">{{ $demande->user->telephone ?: '—' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validation du formulaire côté client
    const form = document.querySelector('form');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function(e) {
        // Désactiver le bouton pour éviter les doubles soumissions
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Enregistrement...';
        
        // Réactiver le bouton après 3 secondes en cas d'erreur
        setTimeout(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i> Enregistrer les modifications';
        }, 3000);
    });
});
</script>
@endpush