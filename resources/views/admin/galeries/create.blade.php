@extends('layouts.dashboard')

@section('title', 'Ajouter une Photo')

@section('hero')
<div class="hero-bg-transport relative overflow-hidden">
    <div class="hero-overlay"></div>
    <div class="floating-particles"></div>
    <div class="relative z-10 text-center text-white py-20">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in">
                📷 Nouvelle Photo
            </h1>
            <p class="text-xl md:text-2xl opacity-90 animate-slide-up">
                Ajoutez une photo à votre galerie d'entreprise
            </p>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-blue-600 px-8 py-6">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-plus-circle mr-3"></i>
                Ajouter une Photo
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

            <form action="{{ route('admin.galeries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Image (obligatoire) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-image mr-2 text-blue-600"></i>
                        Photo *
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                        <input type="file" 
                               name="image" 
                               id="image"
                               accept="image/*"
                               class="hidden"
                               required
                               onchange="previewImage(this)">
                        <label for="image" class="cursor-pointer">
                            <div id="image-preview" class="hidden mb-4">
                                <img id="preview-img" class="max-w-full max-h-64 mx-auto rounded-lg shadow-md">
                            </div>
                            <div id="upload-placeholder">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                                <p class="text-lg font-medium text-gray-700 mb-2">Cliquez pour sélectionner une photo</p>
                                <p class="text-sm text-gray-500">JPEG, PNG, JPG, GIF, WEBP (max 5MB)</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Titre -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-heading mr-2 text-blue-600"></i>
                            Titre de la photo *
                        </label>
                        <input type="text" 
                               name="titre" 
                               value="{{ old('titre') }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="Ex: Transport de marchandises vers l'Europe"
                               required>
                    </div>

                    <!-- Catégorie -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-tag mr-2 text-blue-600"></i>
                            Catégorie *
                        </label>
                        <select name="categorie" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                required>
                            <option value="">Sélectionnez une catégorie</option>
                            @foreach(\App\Models\Galerie::CATEGORIES as $key => $label)
                                <option value="{{ $key }}" {{ old('categorie') == $key ? 'selected' : '' }}>
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
                               value="{{ old('ordre', 0) }}" 
                               min="0" 
                               max="999"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="0">
                        <p class="text-xs text-gray-500 mt-1">Plus le nombre est élevé, plus la photo sera affichée en premier</p>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-align-left mr-2 text-blue-600"></i>
                        Description
                    </label>
                    <textarea name="description" 
                              rows="4" 
                              class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                              placeholder="Décrivez cette photo...">{{ old('description') }}</textarea>
                </div>

                <!-- Texte alternatif -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-universal-access mr-2 text-blue-600"></i>
                        Texte alternatif (accessibilité)
                    </label>
                    <input type="text" 
                           name="alt_text" 
                           value="{{ old('alt_text') }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           placeholder="Description courte pour l'accessibilité">
                    <p class="text-xs text-gray-500 mt-1">Si vide, le titre sera utilisé comme texte alternatif</p>
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
                                   {{ old('active', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="active" class="ml-2 block text-sm text-gray-700">
                                <i class="fas fa-eye text-green-500 mr-1"></i>
                                Photo active (visible dans la galerie publique)
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="mise_en_avant" 
                                   id="mise_en_avant" 
                                   value="1" 
                                   {{ old('mise_en_avant') ? 'checked' : '' }}
                                   class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                            <label for="mise_en_avant" class="ml-2 block text-sm text-gray-700">
                                <i class="fas fa-star text-yellow-500 mr-1"></i>
                                Mettre en avant (affichage prioritaire sur la page d'accueil)
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.galeries.index') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-green-600 to-blue-600 text-white rounded-lg hover:from-green-700 hover:to-blue-700 transition-all transform hover:scale-105 shadow-lg">
                        <i class="fas fa-save mr-2"></i>
                        Ajouter la photo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
