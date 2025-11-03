@extends('layouts.dashboard')

@section('title', 'Nouvelle Demande de Transport')

@section('hero')
<div class="hero-bg-transport relative overflow-hidden">
    <div class="hero-overlay"></div>
    <div class="floating-particles"></div>
    <div class="relative z-10 text-center text-white py-20">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in">
                Nouvelle Demande de Transport
            </h1>
            <p class="text-xl md:text-2xl opacity-90 animate-slide-up">
                Créez votre demande de transport en quelques clics
            </p>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-red-600 px-8 py-6">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-shipping-fast mr-3"></i>
                Formulaire de Demande
            </h2>
        </div>

        <div class="p-8">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle text-red-400 mt-1 mr-3"></i>
                        <div>
                            <h3 class="text-sm font-medium text-red-800">Erreurs détectées :</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('demande.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-exchange-alt mr-2 text-blue-600"></i>
                            Type de transport *
                        </label>
                        <select name="type_transport" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="">Sélectionnez le type</option>
                            <option value="import" {{ old('type_transport') == 'import' ? 'selected' : '' }}>Import</option>
                            <option value="export" {{ old('type_transport') == 'export' ? 'selected' : '' }}>Export</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-box mr-2 text-blue-600"></i>
                            Marchandise *
                        </label>
                        <input type="text" name="marchandise" value="{{ old('marchandise') }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="Ex: Électronique, Textile, Alimentaire..." required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-boxes mr-2 text-blue-600"></i>
                            Nombre de cartons
                            <span class="text-xs text-gray-500">(optionnel)</span>
                        </label>
                        <input type="number" name="nombre_cartons" value="{{ old('nombre_cartons') }}" min="0"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="À préciser si connu">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-weight mr-2 text-blue-600"></i>
                            Poids (kg)
                        </label>
                        <input type="number" name="poids" value="{{ old('poids') }}" step="0.01" min="0"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="Ex: 150.5">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-ruler-combined mr-2 text-blue-600"></i>
                            Dimensions
                        </label>
                        <input type="text" name="dimensions" value="{{ old('dimensions') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="Ex: 120x80x60 cm">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>
                            Pays d'origine *
                        </label>
                        <input type="text" name="origine" value="{{ old('origine') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="Ex: France, Chine, Allemagne..." required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-red-600"></i>
                            Pays de destination *
                        </label>
                        <input type="text" name="destination" value="{{ old('destination') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="Ex: Bénin, Togo, Niger..." required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-city mr-2 text-blue-600"></i>
                            Ville de départ
                        </label>
                        <input type="text" name="ville_depart" value="{{ old('ville_depart') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="Ex: Paris, Shanghai, Hamburg...">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-city mr-2 text-red-600"></i>
                            Ville de destination
                        </label>
                        <input type="text" name="ville_destination" value="{{ old('ville_destination') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="Ex: Cotonou, Lomé, Niamey...">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-calendar mr-2 text-blue-600"></i>
                            Date souhaitée
                        </label>
                        <input type="date" name="date_souhaitee" value="{{ old('date_souhaitee') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-dollar-sign mr-2 text-green-600"></i>
                            Valeur déclarée (FCFA)
                        </label>
                        <input type="number" name="valeur" value="{{ old('valeur') }}" step="0.01" min="0"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="Ex: 1500000">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-comment mr-2 text-blue-600"></i>
                        Description détaillée
                    </label>
                    <textarea name="description" rows="4" 
                              class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                              placeholder="Décrivez votre marchandise, conditions spéciales, instructions particulières...">{{ old('description') }}</textarea>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="fragile" id="fragile" value="1" {{ old('fragile') ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="fragile" class="ml-2 block text-sm text-gray-700">
                        <i class="fas fa-exclamation-triangle text-orange-500 mr-1"></i>
                        Marchandise fragile (nécessite des précautions particulières)
                    </label>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('dashboard') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-red-600 text-white rounded-lg hover:from-blue-700 hover:to-red-700 transition-all transform hover:scale-105 shadow-lg">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Envoyer la demande
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
