@extends('layouts.dashboard')

@section('title', 'Modifier Client - NIF Cargo Admin')
@section('page-title', 'Modifier Client')

@section('content')
<!-- Hero Section -->
<div class="gradient-bg-dashboard rounded-2xl p-8 mb-8 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black bg-opacity-10"></div>
    <div class="relative z-10">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    <i class="fas fa-user-edit mr-3"></i>
                    Modifier le Client
                </h1>
                <p class="text-blue-100 text-lg">
                    Mettre à jour les informations de {{ $client->name }}
                </p>
            </div>
            <div class="hidden md:block">
               
            </div>
        </div>
    </div>
</div>

<!-- Informations actuelles -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Statut du compte -->
    <div class="dashboard-card p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Statut du Compte</h3>
            @if($client->suspended_at)
                <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                    <i class="fas fa-ban mr-2"></i> Suspendu
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                    <i class="fas fa-user-check mr-2"></i> Actif
                </span>
            @endif
        </div>
        <div class="space-y-2 text-sm text-gray-600">
            <p><strong>Inscription :</strong> {{ $client->created_at->format('d/m/Y à H:i') }}</p>
            <p><strong>Dernière connexion :</strong> {{ $client->last_login_at ? $client->last_login_at->diffForHumans() : 'Jamais' }}</p>
            @if($client->suspended_at)
                <div class="mt-3 pt-3 border-t border-red-200">
                    <p class="text-red-700"><strong>Suspendu le :</strong> {{ $client->suspended_at->format('d/m/Y à H:i') }}</p>
                    @if($client->suspension_reason)
                        <p class="text-red-700 mt-1"><strong>Raison :</strong> 
                            @switch($client->suspension_reason)
                                @case('violation_terms') Violation des conditions @break
                                @case('suspicious_activity') Activité suspecte @break
                                @case('payment_issues') Problèmes de paiement @break
                                @case('admin_request') Demande administrative @break
                                @case('other') Autre @break
                                @default {{ $client->suspension_reason }}
                            @endswitch
                        </p>
                    @endif
                    @if($client->suspension_comment)
                        <p class="text-red-700 mt-1 text-xs italic">{{ $client->suspension_comment }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Statistiques -->
    <div class="dashboard-card p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistiques</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Demandes totales :</span>
                <span class="font-medium text-blue-600">{{ $client->demandes_count ?? 0 }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Demandes en cours :</span>
                <span class="font-medium text-orange-600">{{ $client->demandes_en_cours ?? 0 }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Demandes terminées :</span>
                <span class="font-medium text-green-600">{{ $client->demandes_terminees ?? 0 }}</span>
            </div>
        </div>
    </div>

    <!-- Vérification -->
    <div class="dashboard-card p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Vérification</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Email vérifié :</span>
                @if($client->email_verified_at)
                    <span class="inline-flex items-center text-green-600 font-medium">
                        <i class="fas fa-check-circle mr-1"></i> Oui
                    </span>
                @else
                    <span class="inline-flex items-center text-red-600 font-medium">
                        <i class="fas fa-times-circle mr-1"></i> Non
                    </span>
                @endif
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Téléphone vérifié :</span>
                @if($client->telephone_verified_at ?? false)
                    <span class="inline-flex items-center text-green-600 font-medium">
                        <i class="fas fa-check-circle mr-1"></i> Oui
                    </span>
                @else
                    <span class="inline-flex items-center text-red-600 font-medium">
                        <i class="fas fa-times-circle mr-1"></i> Non
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Alerte de suspension -->
@if($client->suspended_at)
<div class="bg-red-50 border-l-4 border-red-500 p-6 mb-6 rounded-lg">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
        </div>
        <div class="ml-4 flex-1">
            <h3 class="text-lg font-semibold text-red-800 mb-2">
                ⚠️ Compte suspendu depuis le {{ $client->suspended_at->format('d/m/Y à H:i') }}
            </h3>
            @if($client->suspension_reason)
                <p class="text-red-700 mb-2">
                    <strong>Raison :</strong> 
                    @switch($client->suspension_reason)
                        @case('violation_terms') Violation des conditions d'utilisation @break
                        @case('suspicious_activity') Activité suspecte @break
                        @case('payment_issues') Problèmes de paiement @break
                        @case('admin_request') Demande administrative @break
                        @case('other') Autre @break
                        @default {{ $client->suspension_reason }}
                    @endswitch
                </p>
            @endif
            @if($client->suspension_comment)
                <p class="text-red-700 text-sm">
                    <strong>Commentaire :</strong> {{ $client->suspension_comment }}
                </p>
            @endif
            <div class="mt-4">
                <button type="button" onclick="showReactivateModal()" 
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition duration-200 inline-flex items-center space-x-2">
                    <i class="fas fa-user-check"></i>
                    <span>Réactiver le compte maintenant</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Formulaire de modification -->
<div class="dashboard-card p-8">
    <form action="{{ route('admin.clients.update', $client->id) }}" method="POST" id="clientForm" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Informations personnelles -->
            <div class="space-y-6">
                <h3 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-3">
                    <i class="fas fa-user mr-2 text-blue-600"></i>
                    Informations Personnelles
                </h3>

                <!-- Nom complet -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-1 text-blue-600"></i>
                        Nom complet *
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $client->name) }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                           placeholder="Nom complet du client">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-1 text-green-600"></i>
                        Adresse email *
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $client->email) }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                           placeholder="exemple@email.com">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Téléphone -->
                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-phone mr-1 text-purple-600"></i>
                        Numéro de téléphone
                    </label>
                    <input type="tel" id="telephone" name="telephone" value="{{ old('telephone', $client->telephone) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('telephone') border-red-500 @enderror"
                           placeholder="+33 X XX XX XX XX">
                    @error('telephone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Adresse -->
                <div>
                    <label for="adresse" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt mr-1 text-red-600"></i>
                        Adresse complète
                    </label>
                    <textarea id="adresse" name="adresse" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('adresse') border-red-500 @enderror"
                              placeholder="Adresse complète du client">{{ old('adresse', $client->adresse) }}</textarea>
                    @error('adresse')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Paramètres du compte -->
            <div class="space-y-6">
                <h3 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-3">
                    <i class="fas fa-cog mr-2 text-purple-600"></i>
                    Paramètres du Compte
                </h3>

                <!-- Statut de vérification email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        <i class="fas fa-shield-alt mr-1 text-green-600"></i>
                        Vérification de l'email
                    </label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="email_verified" value="1" 
                                   {{ $client->email_verified_at ? 'checked' : '' }}
                                   class="text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">Email vérifié</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="email_verified" value="0" 
                                   {{ !$client->email_verified_at ? 'checked' : '' }}
                                   class="text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">Email non vérifié</span>
                        </label>
                    </div>
                </div>

                <!-- Nouveau mot de passe (optionnel) -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-1 text-orange-600"></i>
                        Nouveau mot de passe
                    </label>
                    <input type="password" id="password" name="password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                           placeholder="Laisser vide pour conserver le mot de passe actuel">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">
                        Minimum 8 caractères. Laisser vide si vous ne souhaitez pas changer le mot de passe.
                    </p>
                </div>

                <!-- Confirmation mot de passe -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-1 text-orange-600"></i>
                        Confirmer le mot de passe
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                           placeholder="Confirmer le nouveau mot de passe">
                </div>

                <!-- Notifications -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        <i class="fas fa-bell mr-1 text-blue-600"></i>
                        Préférences de notification
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" name="notify_email" value="1" 
                                   {{ old('notify_email', $client->notify_email ?? true) ? 'checked' : '' }}
                                   class="text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Notifications par email</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="notify_whatsapp" value="1" 
                                   {{ old('notify_whatsapp', $client->notify_whatsapp ?? true) ? 'checked' : '' }}
                                   class="text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Notifications WhatsApp</span>
                        </label>
                    </div>
                </div>

                <!-- Notes administrateur -->
                <div>
                    <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-sticky-note mr-1 text-yellow-600"></i>
                        Notes administrateur
                    </label>
                    <textarea id="admin_notes" name="admin_notes" rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('admin_notes') border-red-500 @enderror"
                              placeholder="Notes internes concernant ce client (non visible par le client)">{{ old('admin_notes', $client->admin_notes) }}</textarea>
                    @error('admin_notes')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="border-t border-gray-200 pt-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                <!-- Actions de statut -->
                <div class="flex flex-wrap gap-3">
                    @if($client->suspended_at)
                        <button type="button" onclick="showReactivateModal()" 
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition duration-200 flex items-center space-x-2">
                            <i class="fas fa-user-check"></i>
                            <span>Réactiver le compte</span>
                        </button>
                    @else
                        <button type="button" onclick="showSuspendModal()" 
                                class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg transition duration-200 flex items-center space-x-2">
                            <i class="fas fa-ban"></i>
                            <span>Suspendre le compte</span>
                        </button>
                    @endif
                    
                    <button type="button" onclick="showDeleteModal()" 
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition duration-200 flex items-center space-x-2">
                        <i class="fas fa-trash"></i>
                        <span>Supprimer définitivement</span>
                    </button>
                </div>

                <!-- Actions du formulaire -->
                <div class="flex space-x-3">
                    <a href="{{ route('admin.clients.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center space-x-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Retour</span>
                    </a>
                    
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

<!-- Modals -->
<!-- Modal de suspension -->
<div id="suspendModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
        <div class="bg-gradient-to-r from-amber-600 to-amber-700 px-6 py-4 rounded-t-2xl">
            <h3 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-ban mr-3"></i>
                Suspendre le compte
            </h3>
        </div>
        
        <form action="{{ route('admin.clients.suspend', $client->id) }}" method="POST" class="p-6">
            @csrf
            <p class="text-gray-700 mb-4">Client : <strong>{{ $client->name }}</strong></p>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Raison de la suspension *</label>
                <select name="suspension_reason" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    <option value="">Sélectionner une raison...</option>
                    <option value="violation_terms">Violation des conditions d'utilisation</option>
                    <option value="suspicious_activity">Activité suspecte</option>
                    <option value="payment_issues">Problèmes de paiement</option>
                    <option value="admin_request">Demande administrative</option>
                    <option value="other">Autre</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Commentaire (optionnel)</label>
                <textarea name="suspension_comment" rows="3" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                          placeholder="Détails supplémentaires..."></textarea>
            </div>
            
            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" onclick="closeSuspendModal()" 
                        class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-6 py-2.5 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors font-medium">
                    <i class="fas fa-ban mr-2"></i>
                    Suspendre
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de réactivation -->
<div id="reactivateModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4 rounded-t-2xl">
            <h3 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-user-check mr-3"></i>
                Réactiver le compte
            </h3>
        </div>
        
        <form action="{{ route('admin.clients.activate', $client->id) }}" method="POST" class="p-6">
            @csrf
            <p class="text-gray-700 mb-4">Client : <strong>{{ $client->name }}</strong></p>
            
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <p class="text-green-800 text-sm">
                    <i class="fas fa-info-circle mr-2"></i>
                    Le client pourra à nouveau se connecter et utiliser la plateforme. Les restrictions de suspension seront levées immédiatement.
                </p>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeReactivateModal()" 
                        class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                    <i class="fas fa-user-check mr-2"></i>
                    Réactiver
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de suppression -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
        <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 rounded-t-2xl">
            <h3 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-trash mr-3"></i>
                Supprimer définitivement
            </h3>
        </div>
        
        <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" class="p-6">
            @csrf
            @method('DELETE')
            <p class="text-gray-700 mb-4">Client : <strong>{{ $client->name }}</strong></p>
            
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <h4 class="font-semibold text-red-800 mb-2">⚠️ ATTENTION - Action irréversible !</h4>
                <ul class="text-sm text-red-700 space-y-1">
                    <li>• Toutes les demandes du client seront supprimées</li>
                    <li>• Tous les documents associés seront supprimés</li>
                    <li>• L'historique des paiements sera supprimé</li>
                    <li>• Cette action ne peut pas être annulée</li>
                </ul>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Pour confirmer, tapez : <strong>SUPPRIMER</strong>
                </label>
                <input type="text" name="confirmation" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                       placeholder="Tapez SUPPRIMER en majuscules">
            </div>
            
            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" onclick="closeDeleteModal()" 
                        class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                    <i class="fas fa-trash mr-2"></i>
                    Supprimer définitivement
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Gestion des modals
function showSuspendModal() {
    document.getElementById('suspendModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeSuspendModal() {
    document.getElementById('suspendModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function showReactivateModal() {
    document.getElementById('reactivateModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeReactivateModal() {
    document.getElementById('reactivateModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function showDeleteModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Aperçu des modifications
function previewChanges() {
    const formData = new FormData(document.getElementById('clientForm'));
    const changes = [];
    
    // Comparaison des valeurs
    const originalData = {
        name: '{{ $client->name }}',
        email: '{{ $client->email }}',
        telephone: '{{ $client->telephone ?? '' }}',
        adresse: '{{ $client->adresse ?? '' }}'
    };
    
    for (let [key, value] of formData.entries()) {
        if (originalData[key] !== undefined && originalData[key] !== value) {
            changes.push(`${key}: "${originalData[key]}" → "${value}"`);
        }
    }
    
    if (changes.length > 0) {
        alert('Modifications détectées :\n\n' + changes.join('\n'));
    } else {
        alert('Aucune modification détectée.');
    }
}

// Validation du formulaire
document.getElementById('clientForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const passwordConfirmation = document.getElementById('password_confirmation').value;
    
    if (password && password !== passwordConfirmation) {
        e.preventDefault();
        alert('Les mots de passe ne correspondent pas.');
        return false;
    }
    
    if (password && password.length < 8) {
        e.preventDefault();
        alert('Le mot de passe doit contenir au moins 8 caractères.');
        return false;
    }
});

// Fermer les modals avec Echap
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeSuspendModal();
        closeReactivateModal();
        closeDeleteModal();
    }
});

// Fermer en cliquant en dehors
document.getElementById('suspendModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeSuspendModal();
});

document.getElementById('reactivateModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeReactivateModal();
});

document.getElementById('deleteModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>

<style>
.gradient-bg-dashboard {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.dashboard-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.dashboard-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

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
</style>
@endsection