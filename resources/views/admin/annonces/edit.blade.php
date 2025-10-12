@extends('layouts.dashboard')

@section('title', 'Modifier l\'Annonce')

@section('hero')
<div class="hero-bg-about relative overflow-hidden">
    <div class="hero-overlay"></div>
    <div class="floating-particles"></div>
    <div class="relative z-10 text-center text-white py-20">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in">
                ✏️ Modifier l'Annonce
            </h1>
            <p class="text-xl md:text-2xl opacity-90 animate-slide-up">
                {{ $annonce->titre }}
            </p>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-orange-600 to-red-600 px-8 py-6">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-edit mr-3"></i>
                Modifier l'Annonce
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

            <form action="{{ route('admin.annonces.update', $annonce) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Titre -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-heading mr-2 text-blue-600"></i>
                            Titre de l'annonce *
                        </label>
                        <input type="text" 
                               name="titre" 
                               value="{{ old('titre', $annonce->titre) }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="Ex: Nouvelle promotion sur les envois vers l'Europe"
                               required>
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-tag mr-2 text-blue-600"></i>
                            Type d'annonce *
                        </label>
                        <select name="type" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                required>
                            <option value="">Sélectionnez un type</option>
                            @foreach(\App\Models\Annonce::TYPES as $key => $label)
                                <option value="{{ $key }}" {{ old('type', $annonce->type) == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ordre -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-sort-numeric-up mr-2 text-blue-600"></i>
                            Ordre d'affichage
                        </label>
                        <input type="number" 
                               name="ordre" 
                               value="{{ old('ordre', $annonce->ordre) }}" 
                               min="0" 
                               max="999"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="0">
                        <p class="text-xs text-gray-500 mt-1">Plus le nombre est élevé, plus l'annonce sera affichée en haut</p>
                    </div>

                    <!-- Date de début -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-calendar-plus mr-2 text-green-600"></i>
                            Date de début
                        </label>
                        <input type="date" 
                               name="date_debut" 
                               value="{{ old('date_debut', $annonce->date_debut?->format('Y-m-d')) }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Laisser vide pour une publication immédiate</p>
                    </div>

                    <!-- Date de fin -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-calendar-minus mr-2 text-red-600"></i>
                            Date de fin
                        </label>
                        <input type="date" 
                               name="date_fin" 
                               value="{{ old('date_fin', $annonce->date_fin?->format('Y-m-d')) }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Laisser vide pour une publication permanente</p>
                    </div>
                </div>

                <!-- Contenu -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-align-left mr-2 text-blue-600"></i>
                        Contenu de l'annonce *
                    </label>
                    <textarea name="contenu" 
                              rows="8" 
                              class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                              placeholder="Rédigez le contenu de votre annonce..."
                              required>{{ old('contenu', $annonce->contenu) }}</textarea>
                </div>

                <!-- Image -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-image mr-2 text-blue-600"></i>
                        Image
                    </label>
                    
                    @if($annonce->image)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Image actuelle :</p>
                            <img src="{{ asset('storage/' . $annonce->image) }}" 
                                 alt="{{ $annonce->titre }}"
                                 class="w-32 h-32 object-cover rounded-lg border">
                        </div>
                    @endif
                    
                    <input type="file" 
                           name="image" 
                           accept="image/*"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">
                        Formats acceptés : JPEG, PNG, JPG, GIF (max 2MB)
                        @if($annonce->image)
                            <br>Laisser vide pour conserver l'image actuelle
                        @endif
                    </p>
                </div>

                <!-- Options -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Options d'affichage</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="active" 
                                   id="active" 
                                   value="1" 
                                   {{ old('active', $annonce->active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="active" class="ml-2 block text-sm text-gray-700">
                                <i class="fas fa-eye text-green-500 mr-1"></i>
                                Annonce active (visible sur le site public)
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="epingle" 
                                   id="epingle" 
                                   value="1" 
                                   {{ old('epingle', $annonce->epingle) ? 'checked' : '' }}
                                   class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                            <label for="epingle" class="ml-2 block text-sm text-gray-700">
                                <i class="fas fa-thumbtack text-yellow-500 mr-1"></i>
                                Épingler cette annonce (affichage prioritaire)
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Métadonnées -->
                <div class="bg-blue-50 rounded-lg p-4">
                    <h4 class="text-sm font-semibold text-blue-900 mb-2">Informations</h4>
                    <div class="text-xs text-blue-700 space-y-1">
                        <div>Créée par : {{ $annonce->user->name }}</div>
                        <div>Créée le : {{ $annonce->created_at->format('d/m/Y à H:i') }}</div>
                        @if($annonce->updated_at != $annonce->created_at)
                            <div>Dernière modification : {{ $annonce->updated_at->format('d/m/Y à H:i') }}</div>
                        @endif
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.annonces.index') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Annuler
                    </a>
                    <a href="{{ route('admin.annonces.show', $annonce) }}" 
                       class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-eye mr-2"></i>
                        Aperçu
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-lg hover:from-orange-700 hover:to-red-700 transition-all transform hover:scale-105 shadow-lg">
                        <i class="fas fa-save mr-2"></i>
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
