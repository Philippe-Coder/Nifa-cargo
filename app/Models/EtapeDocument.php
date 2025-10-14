<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EtapeDocument extends Model
{
    protected $fillable = [
        'etape_logistique_id',
        'user_id',
        'nom',
        'chemin',
        'type',
        'taille',
        'description',
        'visibilite'
    ];

    /**
     * Relation avec l'étape logistique
     */
    public function etapeLogistique(): BelongsTo
    {
        return $this->belongsTo(EtapeLogistique::class);
    }

    /**
     * Relation avec l'utilisateur qui a uploadé
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Vérifier si le document est visible pour un utilisateur
     */
    public function estVisiblePour(User $user): bool
    {
        // Admin voit tout
        if ($user->isAdmin()) {
            return true;
        }

        // Client ne voit que les documents 'client' ou 'tous'
        if ($user->isClient()) {
            return in_array($this->visibilite, ['client', 'tous']);
        }

        return false;
    }

    /**
     * Obtenir l'URL de téléchargement
     */
    public function getUrlAttribute(): string
    {
        return route('etape-documents.download', $this->id);
    }
}
