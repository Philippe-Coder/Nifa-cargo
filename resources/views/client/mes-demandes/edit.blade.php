@extends('layouts.app')

@section('title', 'Modifier ma demande - NIF Cargo')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">
                        <i class="fas fa-edit mr-3"></i>
                        Modifier ma demande
                    </h1>
                    <p class="text-blue-100 text-lg">
                        Demande #{{ $demande->numero_suivi }}
                    </p>
                </div>
                <div class="hidden md:block">
                    <div class="text-6xl opacity-20">
                        📝
                    </div>
                </div>
            </div>
        </div>

        <!-- Statut actuel -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Statut actuel de votre demande</h3>
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($demande->statut == 'en_attente') bg-yellow-100 text-yellow-800
                            @elseif($demande->statut == 'confirmee') bg-blue-100 text-blue-800
                            @elseif($demande->statut == 'en_cours') bg-purple-100 text-purple-800
                            @elseif($demande->statut == 'expediee') bg-indigo-100 text-indigo-800
                            @elseif($demande->statut == 'livree') bg-green-100 text-green-800
                            @elseif($demande->statut == 'annulee') bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $demande->statut)) }}
                        </span>
                        <span class="text-sm text-gray-500">
                            Créée le {{ $demande->created_at->format('d/m/Y à H:i') }}
                        </span>
                    </div>
                </div>
                <div class="mt-4 sm:mt-0">
                    @if(in_array($demande->statut, ['en_attente', 'confirmee']))
                        <span class="inline-flex items-center text-green-600 text-sm font-medium">
                            <i class="fas fa-check-circle mr-1"></i>
                            Modification possible
                        </span>
                    @else
                        <span class="inline-flex items-center text-amber-600 text-sm font-medium">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Modification limitée
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Alerte si modification limitée -->
        @if(!in_array($demande->statut, ['en_attente', 'confirmee']))
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-6 mb-8">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-amber-600 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-amber-800 font-medium mb-2">Modification limitée</h4>
                        <p class="text-amber-700 text-sm">
                            Votre demande a déjà été prise en charge. Seules les informations de contact peuvent être modifiées.
                            Pour d'autres modifications importantes, veuillez contacter notre service client.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulaire de modification -->
        <form action="{{ route('mes-demandes.update', $demande->id) }}" method="POST" enctype="multipart/form-data" id="demandeForm" class="bg-white rounded-lg shadow-sm border border-gray-200">
            @csrf
            @method('PUT')

            <div class="p-8 space-y-8">
                <!-- Informations de contact (toujours modifiables) -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-3 mb-6">
                        <i class="fas fa-user mr-2 text-blue-600"></i>
                        Informations de Contact
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom expéditeur -->
                        <div>
                            <label for="nom_expediteur" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-1 text-blue-600"></i>
                                Nom de l'expéditeur *
                            </label>
                            <input type="text" id="nom_expediteur" name="nom_expediteur" 
                                   value="{{ old('nom_expediteur', $demande->nom_expediteur) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nom_expediteur') border-red-500 @enderror"
                                   placeholder="Votre nom complet">
                            @error('nom_expediteur')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Téléphone expéditeur -->
                        <div>
                            <label for="telephone_expediteur" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-phone mr-1 text-green-600"></i>
                                Téléphone de l'expéditeur *
                            </label>
                            <input type="tel" id="telephone_expediteur" name="telephone_expediteur" 
                                   value="{{ old('telephone_expediteur', $demande->telephone_expediteur) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('telephone_expediteur') border-red-500 @enderror"
                                   placeholder="+33 X XX XX XX XX">
                            @error('telephone_expediteur')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nom destinataire -->
                        <div>
                            <label for="nom_destinataire" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user-tag mr-1 text-purple-600"></i>
                                Nom du destinataire *
                            </label>
                            <input type="text" id="nom_destinataire" name="nom_destinataire" 
                                   value="{{ old('nom_destinataire', $demande->nom_destinataire) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nom_destinataire') border-red-500 @enderror"
                                   placeholder="Nom du destinataire">
                            @error('nom_destinataire')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Téléphone destinataire -->
                        <div>
                            <label for="telephone_destinataire" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-phone-alt mr-1 text-orange-600"></i>
                                Téléphone du destinataire *
                            </label>
                            <input type="tel" id="telephone_destinataire" name="telephone_destinataire" 
                                   value="{{ old('telephone_destinataire', $demande->telephone_destinataire) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('telephone_destinataire') border-red-500 @enderror"
                                   placeholder="+33 X XX XX XX XX">
                            @error('telephone_destinataire')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Informations du colis (modification selon statut) -->
                <div class="{{ !in_array($demande->statut, ['en_attente', 'confirmee']) ? 'opacity-50' : '' }}">
                    <h3 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-3 mb-6">
                        <i class="fas fa-box mr-2 text-purple-600"></i>
                        Informations du Colis
                        @if(!in_array($demande->statut, ['en_attente', 'confirmee']))
                            <span class="text-sm font-normal text-amber-600 ml-2">
                                <i class="fas fa-lock mr-1"></i>
                                Modification non autorisée
                            </span>
                        @endif
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Type de colis -->
                        <div>
                            <label for="type_colis" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-cube mr-1 text-blue-600"></i>
                                Type de colis *
                            </label>
                            <select id="type_colis" name="type_colis" required
                                    {{ !in_array($demande->statut, ['en_attente', 'confirmee']) ? 'disabled' : '' }}
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('type_colis') border-red-500 @enderror">
                                <option value="">Sélectionner le type</option>
                                <option value="document" {{ old('type_colis', $demande->type_colis) == 'document' ? 'selected' : '' }}>Document</option>
                                <option value="colis_standard" {{ old('type_colis', $demande->type_colis) == 'colis_standard' ? 'selected' : '' }}>Colis Standard</option>
                                <option value="colis_volumineux" {{ old('type_colis', $demande->type_colis) == 'colis_volumineux' ? 'selected' : '' }}>Colis Volumineux</option>
                                <option value="marchandise" {{ old('type_colis', $demande->type_colis) == 'marchandise' ? 'selected' : '' }}>Marchandise</option>
                            </select>
                            @error('type_colis')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Poids -->
                        <div>
                            <label for="poids" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-weight mr-1 text-green-600"></i>
                                Poids (kg) *
                            </label>
                            <input type="number" id="poids" name="poids" step="0.1" min="0" 
                                   value="{{ old('poids', $demande->poids) }}" required
                                   {{ !in_array($demande->statut, ['en_attente', 'confirmee']) ? 'readonly' : '' }}
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('poids') border-red-500 @enderror"
                                   placeholder="0.0">
                            @error('poids')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nombre de cartons -->
                        <div>
                            <label for="nombre_cartons" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-boxes mr-1 text-orange-600"></i>
                                Nombre de cartons (optionnel)
                            </label>
                            <input type="number" id="nombre_cartons" name="nombre_cartons" min="0" max="9999" 
                                   value="{{ old('nombre_cartons', $demande->nombre_cartons) }}"
                                   {{ !in_array($demande->statut, ['en_attente', 'confirmee']) ? 'readonly' : '' }}
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nombre_cartons') border-red-500 @enderror"
                                   placeholder="À préciser si connu">
                            @error('nombre_cartons')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Valeur -->
                        <div>
                            <label for="valeur_declaree" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-euro-sign mr-1 text-purple-600"></i>
                                Valeur déclarée (€)
                            </label>
                            <input type="number" id="valeur_declaree" name="valeur_declaree" step="0.01" min="0" 
                                   value="{{ old('valeur_declaree', $demande->valeur_declaree) }}"
                                   {{ !in_array($demande->statut, ['en_attente', 'confirmee']) ? 'readonly' : '' }}
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('valeur_declaree') border-red-500 @enderror"
                                   placeholder="0.00">
                            @error('valeur_declaree')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-align-left mr-1 text-orange-600"></i>
                            Description du contenu *
                        </label>
                        <textarea id="description" name="description" rows="4" required
                                  {{ !in_array($demande->statut, ['en_attente', 'confirmee']) ? 'readonly' : '' }}
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                  placeholder="Décrivez le contenu du colis...">{{ old('description', $demande->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Adresses (modification selon statut) -->
                <div class="{{ !in_array($demande->statut, ['en_attente', 'confirmee']) ? 'opacity-50' : '' }}">
                    <h3 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-3 mb-6">
                        <i class="fas fa-map-marker-alt mr-2 text-red-600"></i>
                        Adresses
                        @if(!in_array($demande->statut, ['en_attente', 'confirmee']))
                            <span class="text-sm font-normal text-amber-600 ml-2">
                                <i class="fas fa-lock mr-1"></i>
                                Modification non autorisée
                            </span>
                        @endif
                    </h3>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Adresse d'enlèvement -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">
                                <i class="fas fa-arrow-up mr-2 text-blue-600"></i>
                                Adresse d'enlèvement
                            </h4>
                            <div class="space-y-4">
                                <div>
                                    <label for="adresse_enlevement" class="block text-sm font-medium text-gray-700 mb-2">Adresse complète *</label>
                                    <textarea id="adresse_enlevement" name="adresse_enlevement" rows="3" required
                                              {{ !in_array($demande->statut, ['en_attente', 'confirmee']) ? 'readonly' : '' }}
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('adresse_enlevement') border-red-500 @enderror"
                                              placeholder="Adresse complète d'enlèvement...">{{ old('adresse_enlevement', $demande->adresse_enlevement) }}</textarea>
                                    @error('adresse_enlevement')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="ville_enlevement" class="block text-sm font-medium text-gray-700 mb-2">Ville *</label>
                                        <input type="text" id="ville_enlevement" name="ville_enlevement" 
                                               value="{{ old('ville_enlevement', $demande->ville_enlevement) }}" required
                                               {{ !in_array($demande->statut, ['en_attente', 'confirmee']) ? 'readonly' : '' }}
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label for="code_postal_enlevement" class="block text-sm font-medium text-gray-700 mb-2">Code postal *</label>
                                        <input type="text" id="code_postal_enlevement" name="code_postal_enlevement" 
                                               value="{{ old('code_postal_enlevement', $demande->code_postal_enlevement) }}" required
                                               {{ !in_array($demande->statut, ['en_attente', 'confirmee']) ? 'readonly' : '' }}
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Adresse de livraison -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">
                                <i class="fas fa-arrow-down mr-2 text-green-600"></i>
                                Adresse de livraison
                            </h4>
                            <div class="space-y-4">
                                <div>
                                    <label for="adresse_livraison" class="block text-sm font-medium text-gray-700 mb-2">Adresse complète *</label>
                                    <textarea id="adresse_livraison" name="adresse_livraison" rows="3" required
                                              {{ !in_array($demande->statut, ['en_attente', 'confirmee']) ? 'readonly' : '' }}
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('adresse_livraison') border-red-500 @enderror"
                                              placeholder="Adresse complète de livraison...">{{ old('adresse_livraison', $demande->adresse_livraison) }}</textarea>
                                    @error('adresse_livraison')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="ville_livraison" class="block text-sm font-medium text-gray-700 mb-2">Ville *</label>
                                        <input type="text" id="ville_livraison" name="ville_livraison" 
                                               value="{{ old('ville_livraison', $demande->ville_livraison) }}" required
                                               {{ !in_array($demande->statut, ['en_attente', 'confirmee']) ? 'readonly' : '' }}
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label for="code_postal_livraison" class="block text-sm font-medium text-gray-700 mb-2">Code postal *</label>
                                        <input type="text" id="code_postal_livraison" name="code_postal_livraison" 
                                               value="{{ old('code_postal_livraison', $demande->code_postal_livraison) }}" required
                                               {{ !in_array($demande->statut, ['en_attente', 'confirmee']) ? 'readonly' : '' }}
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instructions spéciales -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-3 mb-6">
                        <i class="fas fa-sticky-note mr-2 text-yellow-600"></i>
                        Instructions Spéciales
                    </h3>
                    
                    <div>
                        <label for="instructions_speciales" class="block text-sm font-medium text-gray-700 mb-2">
                            Instructions particulières (optionnel)
                        </label>
                        <textarea id="instructions_speciales" name="instructions_speciales" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('instructions_speciales') border-red-500 @enderror"
                                  placeholder="Instructions particulières pour l'enlèvement ou la livraison...">{{ old('instructions_speciales', $demande->instructions_speciales) }}</textarea>
                        @error('instructions_speciales')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-gray-50 px-8 py-6 rounded-b-lg border-t border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                    <!-- Actions dangereuses -->
                    <div class="flex flex-wrap gap-3">
                        @if(in_array($demande->statut, ['en_attente', 'confirmee']))
                            <button type="button" onclick="showCancelModal()" 
                                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition duration-200 flex items-center space-x-2">
                                <i class="fas fa-times"></i>
                                <span>Annuler la demande</span>
                            </button>
                        @endif
                        
                        <a href="{{ route('mes-demandes.index') }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200 flex items-center space-x-2">
                            <i class="fas fa-arrow-left"></i>
                            <span>Retour à mes demandes</span>
                        </a>
                    </div>

                    <!-- Actions du formulaire -->
                    <div class="flex space-x-3">
                        <button type="button" onclick="previewChanges()" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center space-x-2">
                            <i class="fas fa-eye"></i>
                            <span>Aperçu</span>
                        </button>
                        
                        <button type="submit" 
                                class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg transition duration-200 flex items-center space-x-2 font-medium">
                            <i class="fas fa-save"></i>
                            <span>Enregistrer les modifications</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal d'annulation -->
<div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="p-6">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-times text-red-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Annuler la demande</h3>
                    <p class="text-sm text-gray-600">Demande #{{ $demande->numero_suivi }}</p>
                </div>
            </div>
            
            <form action="{{ route('mes-demandes.cancel', $demande->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Raison de l'annulation</label>
                    <select name="cancellation_reason" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500" required>
                        <option value="">Sélectionner une raison...</option>
                        <option value="change_mind">J'ai changé d'avis</option>
                        <option value="wrong_info">Informations incorrectes</option>
                        <option value="found_alternative">J'ai trouvé une alternative</option>
                        <option value="urgent_change">Changement urgent de plans</option>
                        <option value="other">Autre raison</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Commentaire (optionnel)</label>
                    <textarea name="cancellation_comment" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                              placeholder="Détails supplémentaires sur l'annulation..."></textarea>
                </div>
                
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-sm text-red-700">
                        <i class="fas fa-info-circle mr-1"></i>
                        L'annulation de votre demande est définitive. Vous devrez créer une nouvelle demande si vous souhaitez utiliser nos services ultérieurement.
                    </p>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeCancelModal()" 
                            class="px-4 py-2 text-gray-600 hover:text-gray-800">Revenir</button>
                    <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg">
                        Confirmer l'annulation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Gestion du modal d'annulation
function showCancelModal() {
    document.getElementById('cancelModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Aperçu des modifications
function previewChanges() {
    const changes = [];
    const form = document.getElementById('demandeForm');
    const formData = new FormData(form);
    
    // Informations de base pour la comparaison
    const originalData = {
        nom_expediteur: '{{ $demande->nom_expediteur }}',
        telephone_expediteur: '{{ $demande->telephone_expediteur }}',
        nom_destinataire: '{{ $demande->nom_destinataire }}',
        telephone_destinataire: '{{ $demande->telephone_destinataire }}',
        description: '{{ addslashes($demande->description) }}'
    };
    
    // Vérifier les changements
    for (let [key, value] of formData.entries()) {
        if (originalData[key] && originalData[key] !== value) {
            changes.push(`${key}: "${originalData[key]}" → "${value}"`);
        }
    }
    
    if (changes.length > 0) {
        alert('Modifications détectées :\n\n' + changes.join('\n\n'));
    } else {
        alert('Aucune modification détectée.');
    }
}

// Validation du formulaire
document.getElementById('demandeForm').addEventListener('submit', function(e) {
    // Vérification des champs obligatoires
    const requiredFields = ['nom_expediteur', 'telephone_expediteur', 'nom_destinataire', 'telephone_destinataire'];
    let missingFields = [];
    
    requiredFields.forEach(field => {
        const input = document.getElementById(field);
        if (!input.value.trim()) {
            missingFields.push(field);
        }
    });
    
    if (missingFields.length > 0) {
        e.preventDefault();
        alert('Veuillez remplir tous les champs obligatoires.');
        return false;
    }
    
    // Confirmation avant soumission
    if (!confirm('Êtes-vous sûr de vouloir enregistrer ces modifications ?')) {
        e.preventDefault();
        return false;
    }
});

// Fermer le modal avec Echap
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeCancelModal();
    }
});

// Fermer le modal en cliquant à l'extérieur
document.getElementById('cancelModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeCancelModal();
    }
});
</script>

<style>
/* Amélioration du style des inputs */
input:focus, textarea:focus, select:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Animation des boutons */
button {
    transition: all 0.2s ease;
}

button:hover {
    transform: translateY(-1px);
}

button:active {
    transform: translateY(0);
}

/* Style pour les champs désactivés */
input[readonly], textarea[readonly], select[disabled] {
    background-color: #f9fafb;
    cursor: not-allowed;
}
</style>
@endsection