<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Facture extends Model
{
    protected $fillable = [
        'numero_facture',
        'demande_transport_id',
        'user_id',
        'montant_ht',
        'taux_tva',
        'montant_tva',
        'montant_ttc',
        'description',
        'details',
        'statut',
        'date_emission',
        'date_echeance',
        'devise',
        'chemin_pdf'
    ];

    protected $casts = [
        'details' => 'array',
        'date_emission' => 'date',
        'date_echeance' => 'date',
        'montant_ht' => 'decimal:2',
        'montant_tva' => 'decimal:2',
        'montant_ttc' => 'decimal:2',
        'taux_tva' => 'decimal:2'
    ];

    /**
     * Relation avec la demande de transport
     */
    public function demandeTransport(): BelongsTo
    {
        return $this->belongsTo(DemandeTransport::class);
    }

    /**
     * Relation avec l'utilisateur (client)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec les paiements
     */
    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }

    /**
     * Générer un numéro de facture unique
     */
    public static function genererNumeroFacture()
    {
        $annee = date('Y');
        $dernierNumero = self::where('numero_facture', 'like', "F-{$annee}-%")
            ->orderBy('numero_facture', 'desc')
            ->first();
        
        if ($dernierNumero) {
            $numero = (int) substr($dernierNumero->numero_facture, -3);
            $nouveauNumero = $numero + 1;
        } else {
            $nouveauNumero = 1;
        }
        
        return "F-{$annee}-" . str_pad($nouveauNumero, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Calculer les montants automatiquement
     */
    public function calculerMontants()
    {
        $this->montant_tva = ($this->montant_ht * $this->taux_tva) / 100;
        $this->montant_ttc = $this->montant_ht + $this->montant_tva;
        $this->save();
    }

    /**
     * Vérifier si la facture est payée
     */
    public function estPayee()
    {
        return $this->statut === 'payee';
    }

    /**
     * Obtenir le montant total payé
     */
    public function getMontantPayeAttribute()
    {
        return $this->paiements()->where('statut', 'reussi')->sum('montant');
    }

    /**
     * Obtenir le solde restant
     */
    public function getSoldeRestantAttribute()
    {
        return $this->montant_ttc - $this->montant_paye;
    }

    /**
     * Marquer comme payée
     */
    public function marquerPayee()
    {
        $this->update(['statut' => 'payee']);
    }

    /**
     * Scope pour les factures en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'envoyee');
    }

    /**
     * Scope pour les factures payées
     */
    public function scopePayees($query)
    {
        return $query->where('statut', 'payee');
    }
}
