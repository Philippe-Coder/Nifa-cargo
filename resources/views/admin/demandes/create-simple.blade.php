@extends('layouts.dashboard')

@section('title', 'Créer une Demande Client - NIF Cargo Admin')
@section('page-title', 'Créer une Demande pour un Client')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- En-tête -->
    <div class="bg-gradient-to-r from-green-600 to-green-800 rounded-xl p-6 mb-8 text-white">
        <h1 class="text-3xl font-bold mb-2">Créer une Demande pour un Client</h1>
        <p class="text-green-100">Enregistrez une nouvelle demande de transport et créez automatiquement le compte client</p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded">
            <h3 class="text-red-800 font-semibold">Erreurs de validation :</h3>
            <ul class="list-disc list-inside text-red-700 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.demandes.store-admin') }}" method="POST" class="space-y-8">
        @csrf
        
        <!-- Section Client -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800">
                <i class="fas fa-user mr-2 text-blue-600"></i>
                Informations du Client
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Nom -->
                <div>
                    <label for="client_name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet *</label>
                    <input type="text" name="client_name" id="client_name" value="{{ old('client_name') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Ex: Jean Dupont">
                </div>

                <!-- Email -->
                <div>
                    <label for="client_email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="client_email" id="client_email" value="{{ old('client_email') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                           placeholder="jean.dupont@email.com">
                </div>

                <!-- Téléphone -->
                <div>
                    <label for="client_telephone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                    <input type="tel" name="client_telephone" id="client_telephone" value="{{ old('client_telephone') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                           placeholder="+228 97 31 11 58">
                </div>
            </div>
        </div>

        <!-- Section Transport -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800">
                <i class="fas fa-truck mr-2 text-purple-600"></i>
                Détails du Transport
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type de transport *</label>
                    <select name="type" id="type" required
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label for="numero_tracking" class="block text-sm font-medium text-gray-700 mb-2">Numéro de suivi (max 7 chiffres)</label>
                <input type="text" name="numero_tracking" id="numero_tracking" maxlength="7" pattern="\d{1,7}" required value="{{ old('numero_tracking') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Saisir le numéro de suivi" autocomplete="off">
                <span class="text-xs text-gray-500">Ce champ doit contenir uniquement des chiffres (max 7).</span>
            </div>
        </div>

                <!-- Statut -->
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">Statut *</label>
                    <select name="statut" id="statut" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
                        <option value="en attente" {{ old('statut') == 'en attente' ? 'selected' : '' }}>En attente</option>
                        <option value="en cours" {{ old('statut') == 'en cours' ? 'selected' : '' }}>En cours</option>
                        <option value="en transit" {{ old('statut') == 'en transit' ? 'selected' : '' }}>En transit</option>
                        <option value="livrée" {{ old('statut') == 'livrée' ? 'selected' : '' }}>Livrée</option>
                    </select>
                </div>

                <!-- Origine -->
                <div>
                    <label for="origine" class="block text-sm font-medium text-gray-700 mb-2">Origine *</label>
                    <input type="text" name="origine" id="origine" value="{{ old('origine') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                           placeholder="Lomé, Togo">
                </div>

                <!-- Destination -->
                <div>
                    <label for="destination" class="block text-sm font-medium text-gray-700 mb-2">Destination *</label>
                    <input type="text" name="destination" id="destination" value="{{ old('destination') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                           placeholder="Cotonou, Bénin">
                </div>

                <!-- Ville départ -->
                <div>
                    <label for="ville_depart" class="block text-sm font-medium text-gray-700 mb-2">Ville de départ *</label>
                    <input type="text" name="ville_depart" id="ville_depart" value="{{ old('ville_depart') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                           placeholder="Lomé">
                </div>

                <!-- Ville destination -->
                <div>
                    <label for="ville_destination" class="block text-sm font-medium text-gray-700 mb-2">Ville de destination *</label>
                    <input type="text" name="ville_destination" id="ville_destination" value="{{ old('ville_destination') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                           placeholder="Cotonou">
                </div>
            </div>
        </div>

        <!-- Section Colis -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800">
                <i class="fas fa-box mr-2 text-orange-600"></i>
                Informations du Colis
            </h2>
            
            <!-- Nature du colis -->
            <div class="mb-6">
                <label for="nature_colis" class="block text-sm font-medium text-gray-700 mb-2">Nature du colis *</label>
                <textarea name="nature_colis" id="nature_colis" rows="3" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                          placeholder="Décrivez le contenu du colis...">{{ old('nature_colis') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Poids -->
                <div>
                    <label for="poids" class="block text-sm font-medium text-gray-700 mb-2">Poids (kg) *</label>
                    <input type="number" name="poids" id="poids" step="0.01" min="0" value="{{ old('poids') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                           placeholder="25.5">
                </div>

                <!-- Volume -->
                <div>
                    <label for="volume" class="block text-sm font-medium text-gray-700 mb-2">Volume (m³)</label>
                    <input type="number" name="volume" id="volume" step="0.01" min="0" value="{{ old('volume') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                           placeholder="1.5">
                </div>

                <!-- Valeur -->
                <div>
                    <label for="valeur" class="block text-sm font-medium text-gray-700 mb-2">Valeur (FCFA)</label>
                    <input type="number" name="valeur" id="valeur" step="0.01" min="0" value="{{ old('valeur') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                           placeholder="50000">
                </div>

                <!-- Frais -->
                <div>
                    <label for="frais_expedition" class="block text-sm font-medium text-gray-700 mb-2">Frais (FCFA)</label>
                    <input type="number" name="frais_expedition" id="frais_expedition" step="0.01" min="0" value="{{ old('frais_expedition') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                           placeholder="15000">
                </div>
            </div>

            <!-- Mode de transport -->
            <div class="mt-6">
                <label for="type_transport" class="block text-sm font-medium text-gray-700 mb-2">Mode de transport *</label>
                <input type="text" name="type_transport" id="type_transport" value="{{ old('type_transport') }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                       placeholder="Conteneur 20 pieds, Express, Standard">
            </div>

            <!-- Fragile -->
            <div class="mt-6">
                <label class="flex items-center">
                    <input type="checkbox" name="fragile" value="1" {{ old('fragile') ? 'checked' : '' }}
                           class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                    <span class="ml-2 text-sm text-gray-700">Colis fragile</span>
                </label>
            </div>

            <!-- Date souhaitée -->
            <div class="mt-6">
                <label for="date_souhaitee" class="block text-sm font-medium text-gray-700 mb-2">Date souhaitée de livraison</label>
                <input type="date" name="date_souhaitee" id="date_souhaitee" value="{{ old('date_souhaitee') }}"
                       min="{{ date('Y-m-d') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
            </div>

            <!-- Description -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description supplémentaire</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                          placeholder="Informations additionnelles...">{{ old('description') }}</textarea>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.demandes.index') }}" 
                   class="px-6 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Créer la Demande et le Compte Client
                </button>
            </div>
        </div>
    </form>
</div>
@endsection