@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">💳 Paiement de la facture</h1>
        <p class="mt-2 text-gray-600">Facture {{ $facture->numero_facture }} - {{ $facture->demandeTransport->marchandise ?? 'Transport' }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Détails de la facture -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">📄 Détails de la facture</h2>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Numéro:</span>
                        <span class="font-medium">{{ $facture->numero_facture }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Date d'émission:</span>
                        <span>{{ $facture->date_emission->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Date d'échéance:</span>
                        <span>{{ $facture->date_echeance->format('d/m/Y') }}</span>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Montant HT:</span>
                        <span>{{ number_format($facture->montant_ht, 0, ',', ' ') }} {{ $facture->devise }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">TVA ({{ $facture->taux_tva }}%):</span>
                        <span>{{ number_format($facture->montant_tva, 0, ',', ' ') }} {{ $facture->devise }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg border-t pt-2">
                        <span>Total TTC:</span>
                        <span class="text-blue-600">{{ number_format($facture->montant_ttc, 0, ',', ' ') }} {{ $facture->devise }}</span>
                    </div>
                    
                    @if($facture->montant_paye > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Déjà payé:</span>
                            <span>{{ number_format($facture->montant_paye, 0, ',', ' ') }} {{ $facture->devise }}</span>
                        </div>
                        <div class="flex justify-between font-semibold text-red-600">
                            <span>Reste à payer:</span>
                            <span>{{ number_format($facture->solde_restant, 0, ',', ' ') }} {{ $facture->devise }}</span>
                        </div>
                    @endif
                </div>

                @if($facture->description)
                    <div class="mt-4 pt-4 border-t">
                        <h3 class="font-medium text-gray-900 mb-2">Description</h3>
                        <p class="text-sm text-gray-600">{{ $facture->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Méthodes de paiement -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">💰 Choisissez votre méthode de paiement</h2>
                
                <form id="paiementForm" class="space-y-6">
                    @csrf
                    
                    <!-- Paiements locaux (Mobile Money) -->
                    <div>
                        <h3 class="font-medium text-gray-900 mb-4">📱 Paiement Mobile (Afrique)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($methodesDisponibles['local'] as $key => $methode)
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="methode_paiement" value="{{ $key }}" 
                                           class="sr-only peer" required>
                                    <div class="border-2 border-gray-200 rounded-lg p-4 peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-gray-300 transition-colors">
                                        <div class="flex items-center">
                                            <span class="text-2xl mr-3">{{ $methode['icon'] }}</span>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $methode['nom'] }}</div>
                                                <div class="text-sm text-gray-600">{{ $methode['description'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Paiements internationaux -->
                    <div>
                        <h3 class="font-medium text-gray-900 mb-4">🌍 Paiement International</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($methodesDisponibles['international'] as $key => $methode)
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="methode_paiement" value="{{ $key }}" 
                                           class="sr-only peer">
                                    <div class="border-2 border-gray-200 rounded-lg p-4 peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-gray-300 transition-colors">
                                        <div class="flex items-center">
                                            <span class="text-2xl mr-3">{{ $methode['icon'] }}</span>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $methode['nom'] }}</div>
                                                <div class="text-sm text-gray-600">{{ $methode['description'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Autres méthodes -->
                    <div>
                        <h3 class="font-medium text-gray-900 mb-4">🏦 Autres méthodes</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($methodesDisponibles['autres'] as $key => $methode)
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="methode_paiement" value="{{ $key }}" 
                                           class="sr-only peer">
                                    <div class="border-2 border-gray-200 rounded-lg p-4 peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-gray-300 transition-colors">
                                        <div class="flex items-center">
                                            <span class="text-2xl mr-3">{{ $methode['icon'] }}</span>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $methode['nom'] }}</div>
                                                <div class="text-sm text-gray-600">{{ $methode['description'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Champ téléphone pour mobile money -->
                    <div id="phoneField" class="hidden">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            📞 Numéro de téléphone
                        </label>
                        <input type="tel" id="phone" name="phone" 
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Ex: +228 90 12 34 56">
                        <p class="text-xs text-gray-500 mt-1">
                            Numéro associé à votre compte mobile money
                        </p>
                    </div>

                    <!-- Bouton de paiement -->
                    <div class="pt-4">
                        <button type="submit" id="btnPaiement"
                                class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            💳 Payer {{ number_format($facture->montant_ttc, 0, ',', ' ') }} {{ $facture->devise }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('paiementForm');
    const phoneField = document.getElementById('phoneField');
    const btnPaiement = document.getElementById('btnPaiement');
    
    // Afficher/masquer le champ téléphone selon la méthode
    document.querySelectorAll('input[name="methode_paiement"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const methodesAvecTelephone = ['flooz', 'tmoney', 'moov_money', 'orange_money', 'mobile_money'];
            
            if (methodesAvecTelephone.includes(this.value)) {
                phoneField.classList.remove('hidden');
                document.getElementById('phone').required = true;
            } else {
                phoneField.classList.add('hidden');
                document.getElementById('phone').required = false;
            }
        });
    });
    
    // Gestion du formulaire
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const methode = formData.get('methode_paiement');
        
        if (!methode) {
            alert('Veuillez sélectionner une méthode de paiement');
            return;
        }
        
        btnPaiement.disabled = true;
        btnPaiement.innerHTML = '⏳ Traitement en cours...';
        
        fetch('{{ route("paiement.initier", $facture->id) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.redirect_url) {
                    // Redirection vers la passerelle de paiement
                    window.location.href = data.redirect_url;
                } else {
                    // Message de confirmation pour les paiements manuels
                    alert(data.message || 'Paiement initié avec succès');
                    window.location.href = '{{ route("client.suivi.show", $facture->demande_transport_id) }}';
                }
            } else {
                alert('Erreur: ' + (data.error || 'Une erreur est survenue'));
                btnPaiement.disabled = false;
                btnPaiement.innerHTML = '💳 Payer {{ number_format($facture->montant_ttc, 0, ",", " ") }} {{ $facture->devise }}';
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors du paiement');
            btnPaiement.disabled = false;
            btnPaiement.innerHTML = '💳 Payer {{ number_format($facture->montant_ttc, 0, ",", " ") }} {{ $facture->devise }}';
        });
    });
});
</script>
@endsection
