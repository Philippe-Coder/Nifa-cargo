@extends('layouts.dashboard')

@section('title', 'Créer une Demande Client - NIF Cargo Admin')
@section('page-title', 'Créer une Demande pour un Client')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 rounded-2xl p-8 mb-8 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black bg-opacity-10"></div>
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.1\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"1\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    <div class="relative z-10">
        <div class="flex items-center justify-between">
            <div>
                <div class="inline-flex items-center bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-4 border border-white/30">
                    <span class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></span>
                    <span class="text-sm font-medium">Création de demande</span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-bold mb-3">
                    Créer une Demande pour un Client
                </h1>
                <p class="text-blue-100 text-lg max-w-2xl">
                    Enregistrez une nouvelle demande de transport et créez automatiquement le compte client
                </p>
            </div>
            <div class="hidden lg:block">
                <div class="text-6xl opacity-20">
                    <i class="fas fa-user-plus"></i>
                </div>
            </div>
        </div>
    </div>
</div>

@if($errors->any())
    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-8 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-400"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Erreurs de validation :</h3>
                <div class="mt-2 text-sm text-red-700">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif

<form action="{{ route('admin.demandes.store-admin') }}" method="POST" class="space-y-8" id="demandeForm">
    @csrf
    
    <!-- Section Informations Client -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-user-circle mr-3 text-blue-600"></i>
                Informations du Client
            </h2>
            <p class="text-sm text-gray-600 mt-1">Si le client existe déjà, ses informations seront automatiquement mises à jour</p>
        </div>
        <div class="p-6">
            <!-- Recherche de client existant -->
            <div class="mb-6 relative">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-search mr-2"></i>Rechercher un client existant
                </label>
                <div class="relative">
                    <input type="text" 
                           id="clientSearch" 
                           placeholder="Tapez le nom, email ou téléphone du client..."
                           class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                           autocomplete="off">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <i id="searchSpinner" class="fas fa-spinner fa-spin absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hidden"></i>
                    <i id="searchClear" class="fas fa-times absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer hidden hover:text-gray-600"></i>
                </div>
                <div id="clientResults" class="hidden mt-2 bg-white border border-gray-200 rounded-lg shadow-xl max-h-60 overflow-y-auto z-50 absolute w-full"></div>
                <p class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-info-circle mr-1"></i>
                    Commencez à taper pour rechercher un client existant ou créer un nouveau compte
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Nom du client -->
                <div>
                    <label for="client_name" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-blue-500"></i>Nom complet *
                        <span id="clientStatus" class="ml-2 text-xs"></span>
                    </label>
                    <input type="text" 
                           name="client_name" 
                           id="client_name"
                           value="{{ old('client_name') }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                           placeholder="Ex: Jean Dupont">
                    <input type="hidden" id="client_id" name="client_id" value="">
                </div>

                <!-- Email du client -->
                <div>
                    <label for="client_email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-blue-500"></i>Adresse email *
                    </label>
                    <input type="email" 
                           name="client_email" 
                           id="client_email"
                           value="{{ old('client_email') }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                           placeholder="Ex: jean.dupont@email.com">
                </div>

                <!-- Téléphone du client -->
                <div>
                    <label for="client_telephone" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-phone mr-2 text-blue-500"></i>Numéro de téléphone *
                    </label>
                    <input type="tel" 
                           name="client_telephone" 
                           id="client_telephone"
                           value="{{ old('client_telephone') }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                           placeholder="Ex: +228 97 31 11 58">
                </div>
            </div>
        </div>
    </div>

    <!-- Section Détails de la Demande -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-shipping-fast mr-3 text-purple-600"></i>
                Détails de la Demande de Transport
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Type de transport -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-truck mr-2 text-purple-500"></i>Type de transport *
                    </label>
                    <select name="type" 
                            id="type" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                        <option value="">Sélectionner un type</option>
                        <option value="maritime" {{ old('type') == 'maritime' ? 'selected' : '' }}>Maritime</option>
                        <option value="aérien" {{ old('type') == 'aérien' ? 'selected' : '' }}>Aérien</option>
                        <option value="routier" {{ old('type') == 'routier' ? 'selected' : '' }}>Routier</option>
                    </select>
                </div>

                <!-- Mode de transport -->
                <div>
                    <label for="type_transport" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-cog mr-2 text-purple-500"></i>Mode de transport *
                    </label>
                    <input type="text" 
                           name="type_transport" 
                           id="type_transport"
                           value="{{ old('type_transport') }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                           placeholder="Ex: Conteneur 20 pieds, Express, Standard">
                </div>

                <!-- Statut -->
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-flag mr-2 text-purple-500"></i>Statut *
                    </label>
                    <select name="statut" 
                            id="statut" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                        <option value="en attente" {{ old('statut') == 'en attente' ? 'selected' : '' }}>En attente</option>
                        <option value="en cours" {{ old('statut') == 'en cours' ? 'selected' : '' }}>En cours</option>
                        <option value="en transit" {{ old('statut') == 'en transit' ? 'selected' : '' }}>En transit</option>
                        <option value="livrée" {{ old('statut') == 'livrée' ? 'selected' : '' }}>Livrée</option>
                        <option value="annulée" {{ old('statut') == 'annulée' ? 'selected' : '' }}>Annulée</option>
                    </select>
                </div>

                <!-- Numéro de suivi (tracking) -->
                <div>
                    <label for="numero_tracking" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-hashtag mr-2 text-purple-500"></i>Numéro de suivi (1 à 7 chiffres) *
                    </label>
                    <input type="text"
                           name="numero_tracking"
                           id="numero_tracking"
                           value="{{ old('numero_tracking') }}"
                           required
                           maxlength="7"
                           inputmode="numeric"
                           pattern="^[0-9]{1,7}$"
                           title="Entrez uniquement des chiffres (1 à 7)"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                           placeholder="Ex: 1234567">
                    <p class="text-xs text-gray-500 mt-1">
                        Ce numéro est obligatoire pour les demandes créées par l'administrateur. Il doit contenir uniquement des chiffres (maximum 7).
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Origine -->
                <div>
                    <label for="origine" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>Lieu d'origine *
                    </label>
                    <input type="text" 
                           name="origine" 
                           id="origine"
                           value="{{ old('origine') }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                           placeholder="Ex: Lomé, Togo">
                </div>

                <!-- Destination -->
                <div>
                    <label for="destination" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>Lieu de destination *
                    </label>
                    <input type="text" 
                           name="destination" 
                           id="destination"
                           value="{{ old('destination') }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                           placeholder="Ex: Cotonou, Bénin">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Ville de départ -->
                <div>
                    <label for="ville_depart" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-city mr-2 text-blue-500"></i>Ville de départ *
                    </label>
                    <input type="text" 
                           name="ville_depart" 
                           id="ville_depart"
                           value="{{ old('ville_depart') }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                           placeholder="Ex: Lomé">
                </div>

                <!-- Ville de destination -->
                <div>
                    <label for="ville_destination" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-city mr-2 text-blue-500"></i>Ville de destination *
                    </label>
                    <input type="text" 
                           name="ville_destination" 
                           id="ville_destination"
                           value="{{ old('ville_destination') }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                           placeholder="Ex: Cotonou">
                </div>
            </div>
        </div>
    </div>

    <!-- Section Détails du Colis -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-orange-50 to-red-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-box mr-3 text-orange-600"></i>
                Informations du Colis
            </h2>
        </div>
        <div class="p-6">
            <!-- Nature du colis -->
            <div class="mb-6">
                <label for="nature_colis" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tags mr-2 text-orange-500"></i>Nature du colis *
                </label>
                <textarea name="nature_colis" 
                          id="nature_colis"
                          rows="3"
                          required
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all"
                          placeholder="Décrivez la nature et le contenu du colis...">{{ old('nature_colis') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                <!-- Nombre de cartons -->
                <div>
                    <label for="nombre_cartons" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-boxes mr-2 text-orange-500"></i>Nombre de cartons
                        <span class="text-xs text-gray-500">(optionnel)</span>
                    </label>
                    <input type="number" 
                           name="nombre_cartons" 
                           id="nombre_cartons"
                           min="0"
                           value="{{ old('nombre_cartons') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all"
                           placeholder="À préciser si connu">
                </div>

                <!-- Poids -->
                <div>
                    <label for="poids" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-weight mr-2 text-orange-500"></i>Poids (kg) *
                    </label>
                    <input type="number" 
                           name="poids" 
                           id="poids"
                           step="0.01"
                           min="0"
                           value="{{ old('poids') }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all"
                           placeholder="Ex: 25.5">
                </div>

                <!-- Volume -->
                <div>
                    <label for="volume" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-cube mr-2 text-orange-500"></i>Volume (m³)
                    </label>
                    <input type="number" 
                           name="volume" 
                           id="volume"
                           step="0.01"
                           min="0"
                           value="{{ old('volume') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all"
                           placeholder="Ex: 1.5">
                </div>

                <!-- Valeur -->
                <div>
                    <label for="valeur" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-dollar-sign mr-2 text-orange-500"></i>Valeur (FCFA)
                    </label>
              <input type="number" 
                           name="valeur" 
                           id="valeur"
                           step="0.01"
                           min="0"
                  max="9999999999999.99"
                           value="{{ old('valeur') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all"
                           placeholder="Ex: 50000">
                </div>

                <!-- Frais d'expédition -->
                <div>
                    <label for="frais_expedition" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-money-bill-wave mr-2 text-orange-500"></i>Frais (FCFA)
                    </label>
              <input type="number" 
                           name="frais_expedition" 
                           id="frais_expedition"
                           step="0.01"
                           min="0"
                  max="9999999999999.99"
                           value="{{ old('frais_expedition') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all"
                           placeholder="Ex: 15000">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Date souhaitée -->
                <div>
                    <label for="date_souhaitee" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar mr-2 text-orange-500"></i>Date souhaitée de livraison
                    </label>
                    <input type="date" 
                           name="date_souhaitee" 
                           id="date_souhaitee"
                           value="{{ old('date_souhaitee') }}" 
                           min="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all">
                </div>

                <!-- Fragile -->
                <div class="flex items-center pt-8">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="fragile" 
                               id="fragile"
                               value="1"
                               {{ old('fragile') ? 'checked' : '' }}
                               class="h-5 w-5 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                        <label for="fragile" class="ml-3 text-sm font-medium text-gray-700">
                            <i class="fas fa-exclamation-triangle mr-2 text-yellow-500"></i>
                            Colis fragile
                        </label>
                    </div>
                </div>
            </div>

            <!-- Description additionnelle -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-comment-alt mr-2 text-orange-500"></i>Description supplémentaire
                </label>
                <textarea name="description" 
                          id="description"
                          rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all"
                          placeholder="Informations supplémentaires sur la demande...">{{ old('description') }}</textarea>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col sm:flex-row gap-4 justify-end">
                <a href="{{ route('admin.demandes.index') }}" 
                   class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
                
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg text-sm font-medium hover:from-blue-700 hover:to-blue-800 transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Créer la Demande et le Compte Client
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Éléments DOM
    const clientSearch = document.getElementById('clientSearch');
    const clientResults = document.getElementById('clientResults');
    const clientName = document.getElementById('client_name');
    const clientEmail = document.getElementById('client_email');
    const clientTelephone = document.getElementById('client_telephone');
    const clientId = document.getElementById('client_id');
    const clientStatus = document.getElementById('clientStatus');
    const searchSpinner = document.getElementById('searchSpinner');
    const searchClear = document.getElementById('searchClear');
    
    let searchTimeout;
    let currentSelectedClient = null;

    // État de l'interface
    function setLoading(isLoading) {
        if (isLoading) {
            searchSpinner.classList.remove('hidden');
            searchClear.classList.add('hidden');
        } else {
            searchSpinner.classList.add('hidden');
            if (clientSearch.value.length > 0) {
                searchClear.classList.remove('hidden');
            }
        }
    }

    function setClientStatus(type, message, client = null) {
        clientStatus.innerHTML = '';
        
        if (type === 'existing') {
            clientStatus.innerHTML = `
                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                    <i class="fas fa-check-circle mr-1"></i>Client existant
                </span>
            `;
            currentSelectedClient = client;
        } else if (type === 'new') {
            clientStatus.innerHTML = `
                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                    <i class="fas fa-plus-circle mr-1"></i>Nouveau client
                </span>
            `;
            currentSelectedClient = null;
        } else if (type === 'searching') {
            clientStatus.innerHTML = `
                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">
                    <i class="fas fa-search mr-1"></i>Recherche...
                </span>
            `;
        }
    }

    function clearClientFields() {
        clientName.value = '';
        clientEmail.value = '';
        clientTelephone.value = '';
        clientId.value = '';
        currentSelectedClient = null;
        setClientStatus('new');
    }

    function fillClientFields(client) {
        clientName.value = client.name;
        clientEmail.value = client.email;
        clientTelephone.value = client.telephone || '';
        clientId.value = client.id;
        clientSearch.value = client.name + ' - ' + client.email;
        setClientStatus('existing', null, client);
        
        // Animation de confirmation
        [clientName, clientEmail, clientTelephone].forEach(field => {
            field.classList.add('bg-blue-50', 'border-blue-300');
            setTimeout(() => {
                field.classList.remove('bg-blue-50', 'border-blue-300');
            }, 1500);
        });
    }

    // Recherche de clients avec debounce
    clientSearch.addEventListener('input', function() {
        const query = this.value.trim();
        
        // Afficher/masquer le bouton clear
        if (query.length > 0) {
            searchClear.classList.remove('hidden');
        } else {
            searchClear.classList.add('hidden');
        }
        
        if (query.length < 2) {
            clientResults.classList.add('hidden');
            if (query.length === 0) {
                clearClientFields();
            }
            return;
        }

        setLoading(true);
        setClientStatus('searching');
        clearTimeout(searchTimeout);
        
        searchTimeout = setTimeout(() => {
            fetch('/admin/demandes/search-clients?q=' + encodeURIComponent(query))
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur réseau');
                    }
                    return response.json();
                })
                .then(data => {
                    setLoading(false);
                    clientResults.innerHTML = '';
                    
                    if (data.length === 0) {
                        clientResults.innerHTML = `
                            <div class="p-4 text-center">
                                <i class="fas fa-user-plus text-3xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-600 font-medium">Aucun client trouvé</p>
                                <p class="text-xs text-gray-500 mt-1">Un nouveau compte sera créé avec ces informations</p>
                            </div>
                        `;
                        setClientStatus('new');
                    } else {
                        // En-tête
                        clientResults.innerHTML = `
                            <div class="p-3 bg-gray-50 border-b border-gray-200">
                                <p class="text-xs font-medium text-gray-700">
                                    <i class="fas fa-users mr-1"></i>
                                    ${data.length} client(s) trouvé(s)
                                </p>
                            </div>
                        `;
                        
                        data.forEach((client, index) => {
                            const div = document.createElement('div');
                            div.className = 'p-4 hover:bg-blue-50 cursor-pointer border-b border-gray-100 last:border-b-0 transition-all duration-150';
                            div.setAttribute('role', 'option');
                            
                            // Mise en évidence du terme recherché
                            const highlightText = (text, query) => {
                                if (!text) return 'N/A';
                                const regex = new RegExp(`(${query})`, 'gi');
                                return text.replace(regex, '<mark class="bg-yellow-200 px-1 rounded">$1</mark>');
                            };
                            
                            div.innerHTML = `
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-4 shadow-sm">
                                        <span class="text-white text-sm font-bold">${client.name.charAt(0).toUpperCase()}</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">${highlightText(client.name, query)}</p>
                                        <p class="text-sm text-gray-600">${highlightText(client.email, query)}</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <i class="fas fa-phone mr-1"></i>
                                            ${highlightText(client.telephone, query)}
                                        </p>
                                    </div>
                                    <div class="ml-4">
                                        <i class="fas fa-chevron-right text-gray-400"></i>
                                    </div>
                                </div>
                            `;
                            
                            // Effet hover amélioré
                            div.addEventListener('mouseenter', () => {
                                div.classList.add('shadow-md', 'transform', 'scale-[1.02]');
                            });
                            
                            div.addEventListener('mouseleave', () => {
                                div.classList.remove('shadow-md', 'transform', 'scale-[1.02]');
                            });
                            
                            div.addEventListener('click', () => {
                                fillClientFields(client);
                                clientResults.classList.add('hidden');
                                
                                // Notification toast
                                showToast('Client sélectionné', `${client.name} a été sélectionné`, 'success');
                            });
                            
                            clientResults.appendChild(div);
                        });
                    }
                    
                    clientResults.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Erreur lors de la recherche:', error);
                    setLoading(false);
                    clientResults.innerHTML = `
                        <div class="p-4 text-center text-red-600">
                            <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                            <p class="text-sm">Erreur lors de la recherche</p>
                            <p class="text-xs mt-1">Veuillez réessayer</p>
                        </div>
                    `;
                    clientResults.classList.remove('hidden');
                });
        }, 300);
    });

    // Bouton clear
    searchClear.addEventListener('click', function() {
        clientSearch.value = '';
        clearClientFields();
        clientResults.classList.add('hidden');
        searchClear.classList.add('hidden');
        clientSearch.focus();
    });

    // Fermer les résultats en cliquant ailleurs
    document.addEventListener('click', function(event) {
        if (!clientSearch.contains(event.target) && !clientResults.contains(event.target)) {
            clientResults.classList.add('hidden');
        }
    });

    // Navigation au clavier
    let selectedIndex = -1;
    clientSearch.addEventListener('keydown', function(e) {
        const items = clientResults.querySelectorAll('[role="option"]');
        
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            selectedIndex = Math.min(selectedIndex + 1, items.length - 1);
            updateSelection(items);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            selectedIndex = Math.max(selectedIndex - 1, -1);
            updateSelection(items);
        } else if (e.key === 'Enter' && selectedIndex >= 0) {
            e.preventDefault();
            items[selectedIndex].click();
        } else if (e.key === 'Escape') {
            clientResults.classList.add('hidden');
            selectedIndex = -1;
        }
    });

    function updateSelection(items) {
        items.forEach((item, index) => {
            if (index === selectedIndex) {
                item.classList.add('bg-blue-100');
                item.scrollIntoView({ block: 'nearest' });
            } else {
                item.classList.remove('bg-blue-100');
            }
        });
    }

    // Auto-remplissage des villes depuis origine/destination
    document.getElementById('origine').addEventListener('blur', function() {
        if (this.value && !document.getElementById('ville_depart').value) {
            document.getElementById('ville_depart').value = this.value;
        }
    });

    document.getElementById('destination').addEventListener('blur', function() {
        if (this.value && !document.getElementById('ville_destination').value) {
            document.getElementById('ville_destination').value = this.value;
        }
    });

    // Validation du formulaire améliorée
    document.getElementById('demandeForm').addEventListener('submit', function(e) {
        let isValid = true;
        const requiredFields = this.querySelectorAll('[required]');
        
        requiredFields.forEach(field => {
            field.classList.remove('border-red-500', 'border-blue-500');
            
            if (!field.value.trim()) {
                field.classList.add('border-red-500');
                isValid = false;
            } else {
                field.classList.add('border-blue-500');
            }
        });

        // Validation stricte du numéro de suivi (1 à 7 chiffres)
        const tracking = document.getElementById('numero_tracking');
        if (tracking) {
            tracking.value = tracking.value.replace(/\D/g, '').slice(0, 7);
            if (!/^\d{1,7}$/.test(tracking.value)) {
                tracking.classList.add('border-red-500');
                isValid = false;
            }
        }

        if (!isValid) {
            e.preventDefault();
            showToast('Erreur de validation', 'Veuillez remplir tous les champs obligatoires.', 'error');
            
            // Scroll vers le premier champ invalide
            const firstInvalid = this.querySelector('.border-red-500');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
        }
    });

    // Fonction toast pour les notifications
    function showToast(title, message, type = 'info') {
        const toast = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-blue-500' : (type === 'error' ? 'bg-red-500' : 'bg-blue-500');
        const iconClass = type === 'success' ? 'fa-check-circle' : (type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle');

        toast.className = 'fixed top-4 right-4 ' + bgColor + ' text-white px-6 py-4 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
        toast.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${iconClass} mr-3"></i>
                <div>
                    <p class="font-semibold">${title}</p>
                    <p class="text-sm opacity-90">${message}</p>
                </div>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Animation d'entrée
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Suppression automatique
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }

    // Initialisation
    setClientStatus('new');

    // Sanitation en temps réel du numéro de suivi
    const trackingInput = document.getElementById('numero_tracking');
    if (trackingInput) {
        trackingInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 7);
        });
    }
});
</script>
@endpush