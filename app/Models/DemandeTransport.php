<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemandeTransport extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'type_transport',
        'marchandise',
        'poids',
        'volume',
        'nature_colis',
        'frais_expedition',
        'origine',
        'destination',
        'ville_depart',
        'ville_destination',
        'description',
        'statut',
        'document_path',
        'numero_tracking',
        'date_souhaitee',
        'dimensions',
        'valeur',
        'fragile',
        'montant',
        'created_by_admin'
    ];

    // Suppression de la logique 'reference' : le suivi est basé sur 'numero_tracking' exclusivement

    protected $casts = [
        'poids' => 'decimal:2',
        'volume' => 'decimal:2',
        'valeur' => 'decimal:2',
        'montant' => 'decimal:2',
        'frais_expedition' => 'decimal:2',
        'fragile' => 'boolean',
        'created_by_admin' => 'boolean',
        'date_souhaitee' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur qui a fait la demande
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scopes pour filtrer par statut
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en attente');
    }

    public function scopeLivrees($query)
    {
        return $query->where('statut', 'livrée');
    }

    public function scopeEnTransit($query)
    {
        return $query->where('statut', 'en transit');
    }

    /**
     * Relation avec les étapes logistiques
     */
    public function etapes()
    {
        return $this->hasMany(EtapeLogistique::class)->orderBy('ordre');
    }

    /**
     * Relation avec les documents
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Relation avec les notifications (relation polymorphe)
     */
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    /**
     * Relation avec la facture
     */
    public function facture()
    {
        return $this->hasOne(Facture::class);
    }

    /**
     * Créer les étapes par défaut pour une demande
     */
    public function creerEtapesParDefaut()
    {
        $etapesDefaut = [
            ['nom' => 'Enregistrement', 'description' => 'Réception et validation de la demande', 'ordre' => 1],
            ['nom' => 'Transit', 'description' => 'Transport en cours', 'ordre' => 2],
            ['nom' => 'Dédouanement', 'description' => 'Procédures douanières', 'ordre' => 3],
            ['nom' => 'Livraison', 'description' => 'Livraison finale', 'ordre' => 4],
        ];

        foreach ($etapesDefaut as $etape) {
            $this->etapes()->create($etape);
        }
    }

    /**
     * Obtenir l'étape actuelle
     */
    public function getEtapeActuelleAttribute()
    {
        return $this->etapes()->where('statut', 'en_cours')->first() 
            ?? $this->etapes()->where('statut', 'en_attente')->first();
    }

    /**
     * Obtenir le pourcentage de progression
     */
    public function getPourcentageProgressionAttribute()
    {
        $totalEtapes = $this->etapes()->count();
        $etapesTerminees = $this->etapes()->where('statut', 'terminee')->count();
        
        return $totalEtapes > 0 ? round(($etapesTerminees / $totalEtapes) * 100) : 0;
    }

    /**
     * URL de la notification pour ce modèle
     */
    public function notificationUrl(): string
    {
        return route('mes-demandes.show', $this->id);
    }

    /**
     * Obtenir tous les documents des étapes
     */
    public function documentsEtapes()
    {
        return EtapeDocument::whereIn('etape_logistique_id', $this->etapes()->pluck('id'))
            ->with(['etapeLogistique', 'user'])
            ->latest()
            ->get();
    }
}
