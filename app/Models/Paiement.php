<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    protected $fillable = [
        'reference_paiement',
        'facture_id',
        'user_id',
        'montant',
        'devise',
        'methode_paiement',
        'statut',
        'transaction_id',
        'gateway_reference',
        'gateway_response',
        'date_paiement',
        'note',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'gateway_response' => 'array',
        'date_paiement' => 'datetime',
        'montant' => 'decimal:2'
    ];

    /**
     * Relation avec la facture
     */
    public function facture(): BelongsTo
    {
        return $this->belongsTo(Facture::class);
    }

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Générer une référence de paiement unique
     */
    public static function genererReference()
    {
        $annee = date('Y');
        $dernierNumero = self::where('reference_paiement', 'like', "P-{$annee}-%")
            ->orderBy('reference_paiement', 'desc')
            ->first();
        
        if ($dernierNumero) {
            $numero = (int) substr($dernierNumero->reference_paiement, -4);
            $nouveauNumero = $numero + 1;
        } else {
            $nouveauNumero = 1;
        }
        
        return "P-{$annee}-" . str_pad($nouveauNumero, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Marquer le paiement comme réussi
     */
    public function marquerReussi($transactionId = null, $gatewayResponse = null)
    {
        $this->update([
            'statut' => 'reussi',
            'date_paiement' => now(),
            'transaction_id' => $transactionId,
            'gateway_response' => $gatewayResponse
        ]);

        // Mettre à jour le statut de la facture si totalement payée
        if ($this->facture->solde_restant <= 0) {
            $this->facture->marquerPayee();
        }
    }

    /**
     * Marquer le paiement comme échoué
     */
    public function marquerEchec($erreur = null)
    {
        $this->update([
            'statut' => 'echec',
            'note' => $erreur
        ]);
    }

    /**
     * Scope pour les paiements réussis
     */
    public function scopeReussis($query)
    {
        return $query->where('statut', 'reussi');
    }

    /**
     * Scope pour les paiements en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    /**
     * Obtenir le libellé de la méthode de paiement
     */
    public function getMethodePaiementLibelleAttribute()
    {
        $methodes = [
            'carte_bancaire' => 'Carte bancaire',
            'mobile_money' => 'Mobile Money',
            'flooz' => 'Flooz',
            'tmoney' => 'T-Money',
            'moov_money' => 'Moov Money',
            'orange_money' => 'Orange Money',
            'paypal' => 'PayPal',
            'stripe' => 'Stripe',
            'virement' => 'Virement bancaire',
            'especes' => 'Espèces'
        ];

        return $methodes[$this->methode_paiement] ?? $this->methode_paiement;
    }
}
