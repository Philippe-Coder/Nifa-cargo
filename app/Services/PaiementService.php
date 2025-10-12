<?php

namespace App\Services;

use App\Models\Facture;
use App\Models\Paiement;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaiementService
{
    /**
     * Initier un paiement
     */
    public function initierPaiement(Facture $facture, string $methodePaiement, array $donneesClient = [])
    {
        // Créer l'enregistrement de paiement
        $paiement = Paiement::create([
            'reference_paiement' => Paiement::genererReference(),
            'facture_id' => $facture->id,
            'user_id' => $facture->user_id,
            'montant' => $facture->montant_ttc,
            'devise' => $facture->devise,
            'methode_paiement' => $methodePaiement,
            'statut' => 'en_attente',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        // Rediriger vers la passerelle appropriée
        switch ($methodePaiement) {
            case 'flooz':
                return $this->initierPaiementFlooz($paiement, $donneesClient);
            case 'tmoney':
                return $this->initierPaiementTMoney($paiement, $donneesClient);
            case 'moov_money':
                return $this->initierPaiementMoovMoney($paiement, $donneesClient);
            case 'orange_money':
                return $this->initierPaiementOrangeMoney($paiement, $donneesClient);
            case 'stripe':
                return $this->initierPaiementStripe($paiement, $donneesClient);
            case 'paypal':
                return $this->initierPaiementPayPal($paiement, $donneesClient);
            default:
                return $this->initierPaiementGenerique($paiement, $donneesClient);
        }
    }

    /**
     * Paiement Flooz (Togo)
     */
    private function initierPaiementFlooz(Paiement $paiement, array $donneesClient)
    {
        try {
            // Configuration Flooz (exemple)
            $response = Http::post('https://api.flooz.app/v1/payments', [
                'amount' => $paiement->montant,
                'currency' => 'XOF',
                'reference' => $paiement->reference_paiement,
                'description' => "Paiement facture {$paiement->facture->numero_facture}",
                'customer' => [
                    'name' => $paiement->user->name,
                    'email' => $paiement->user->email,
                    'phone' => $donneesClient['phone'] ?? null
                ],
                'callback_url' => route('paiement.callback.flooz'),
                'return_url' => route('paiement.success')
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $paiement->update([
                    'gateway_reference' => $data['payment_id'] ?? null,
                    'statut' => 'en_cours'
                ]);

                return [
                    'success' => true,
                    'redirect_url' => $data['payment_url'] ?? null,
                    'paiement_id' => $paiement->id
                ];
            }

            throw new \Exception('Erreur lors de l\'initialisation du paiement Flooz');

        } catch (\Exception $e) {
            Log::error('Erreur paiement Flooz: ' . $e->getMessage());
            $paiement->marquerEchec($e->getMessage());
            
            return [
                'success' => false,
                'error' => 'Erreur lors du paiement Flooz'
            ];
        }
    }

    /**
     * Paiement T-Money (Togo)
     */
    private function initierPaiementTMoney(Paiement $paiement, array $donneesClient)
    {
        try {
            // Configuration T-Money (exemple)
            $response = Http::post('https://api.tmoney.tg/v1/payments', [
                'amount' => $paiement->montant,
                'currency' => 'XOF',
                'reference' => $paiement->reference_paiement,
                'description' => "Paiement facture {$paiement->facture->numero_facture}",
                'customer_phone' => $donneesClient['phone'] ?? null,
                'callback_url' => route('paiement.callback.tmoney')
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $paiement->update([
                    'gateway_reference' => $data['transaction_id'] ?? null,
                    'statut' => 'en_cours'
                ]);

                return [
                    'success' => true,
                    'message' => 'Veuillez composer *155# pour confirmer le paiement',
                    'paiement_id' => $paiement->id
                ];
            }

            throw new \Exception('Erreur lors de l\'initialisation du paiement T-Money');

        } catch (\Exception $e) {
            Log::error('Erreur paiement T-Money: ' . $e->getMessage());
            $paiement->marquerEchec($e->getMessage());
            
            return [
                'success' => false,
                'error' => 'Erreur lors du paiement T-Money'
            ];
        }
    }

    /**
     * Paiement Stripe (International)
     */
    private function initierPaiementStripe(Paiement $paiement, array $donneesClient)
    {
        try {
            // Configuration Stripe
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => strtolower($paiement->devise),
                        'product_data' => [
                            'name' => "Facture {$paiement->facture->numero_facture}",
                            'description' => $paiement->facture->description
                        ],
                        'unit_amount' => $paiement->montant * 100, // Stripe utilise les centimes
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('paiement.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('paiement.cancel'),
                'metadata' => [
                    'paiement_id' => $paiement->id,
                    'facture_id' => $paiement->facture_id
                ]
            ]);

            $paiement->update([
                'gateway_reference' => $session->id,
                'statut' => 'en_cours'
            ]);

            return [
                'success' => true,
                'redirect_url' => $session->url,
                'paiement_id' => $paiement->id
            ];

        } catch (\Exception $e) {
            Log::error('Erreur paiement Stripe: ' . $e->getMessage());
            $paiement->marquerEchec($e->getMessage());
            
            return [
                'success' => false,
                'error' => 'Erreur lors du paiement par carte'
            ];
        }
    }

    /**
     * Paiement générique (pour les autres méthodes)
     */
    private function initierPaiementGenerique(Paiement $paiement, array $donneesClient)
    {
        // Pour les méthodes comme virement, espèces, etc.
        $paiement->update(['statut' => 'en_attente']);

        return [
            'success' => true,
            'message' => 'Paiement en attente de confirmation manuelle',
            'paiement_id' => $paiement->id
        ];
    }

    /**
     * Traiter le callback de paiement
     */
    public function traiterCallback(string $methodePaiement, array $data)
    {
        try {
            switch ($methodePaiement) {
                case 'flooz':
                    return $this->traiterCallbackFlooz($data);
                case 'tmoney':
                    return $this->traiterCallbackTMoney($data);
                case 'stripe':
                    return $this->traiterCallbackStripe($data);
                default:
                    Log::warning("Callback non géré pour la méthode: {$methodePaiement}");
                    return false;
            }
        } catch (\Exception $e) {
            Log::error("Erreur lors du traitement du callback {$methodePaiement}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Traiter callback Flooz
     */
    private function traiterCallbackFlooz(array $data)
    {
        $paiement = Paiement::where('gateway_reference', $data['payment_id'] ?? null)->first();
        
        if (!$paiement) {
            return false;
        }

        if ($data['status'] === 'success') {
            $paiement->marquerReussi($data['transaction_id'] ?? null, $data);
        } else {
            $paiement->marquerEchec($data['message'] ?? 'Paiement échoué');
        }

        return true;
    }

    /**
     * Traiter callback Stripe
     */
    private function traiterCallbackStripe(array $data)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        
        $session = \Stripe\Checkout\Session::retrieve($data['session_id']);
        $paiement = Paiement::where('gateway_reference', $session->id)->first();
        
        if (!$paiement) {
            return false;
        }

        if ($session->payment_status === 'paid') {
            $paiement->marquerReussi($session->payment_intent, $session->toArray());
        } else {
            $paiement->marquerEchec('Paiement non confirmé');
        }

        return true;
    }

    /**
     * Obtenir les méthodes de paiement disponibles
     */
    public static function getMethodesDisponibles()
    {
        return [
            'local' => [
                'flooz' => ['nom' => 'Flooz', 'icon' => '💳', 'description' => 'Paiement mobile Flooz'],
                'tmoney' => ['nom' => 'T-Money', 'icon' => '📱', 'description' => 'Paiement mobile T-Money'],
                'moov_money' => ['nom' => 'Moov Money', 'icon' => '💰', 'description' => 'Paiement mobile Moov'],
                'orange_money' => ['nom' => 'Orange Money', 'icon' => '🍊', 'description' => 'Paiement mobile Orange'],
            ],
            'international' => [
                'stripe' => ['nom' => 'Carte bancaire', 'icon' => '💳', 'description' => 'Visa, MasterCard'],
                'paypal' => ['nom' => 'PayPal', 'icon' => '🅿️', 'description' => 'Paiement PayPal'],
            ],
            'autres' => [
                'virement' => ['nom' => 'Virement bancaire', 'icon' => '🏦', 'description' => 'Virement bancaire'],
                'especes' => ['nom' => 'Espèces', 'icon' => '💵', 'description' => 'Paiement en espèces'],
            ]
        ];
    }
}
