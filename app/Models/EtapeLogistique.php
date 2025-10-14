<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EtapeLogistique extends Model
{
    protected $fillable = [
        'demande_transport_id',
        'nom',
        'description',
        'statut',
        'date_debut',
        'date_fin',
        'agent_id',
        'commentaire',
        'ordre'
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];

    /**
     * Relation avec la demande de transport
     */
    public function demandeTransport(): BelongsTo
    {
        return $this->belongsTo(DemandeTransport::class);
    }

    /**
     * Relation avec l'agent assigné
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * Scope pour les étapes terminées
     */
    public function scopeTerminees($query)
    {
        return $query->where('statut', 'terminee');
    }

    /**
     * Scope pour les étapes en cours
     */
    public function scopeEnCours($query)
    {
        return $query->where('statut', 'en_cours');
    }

    /**
     * Relation avec les documents de l'étape
     */
    public function documents()
    {
        return $this->hasMany(EtapeDocument::class);
    }
}
