<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'message',
        'notifiable_type',
        'notifiable_id',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Relation polymorphe avec le modèle notifiable
     */
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }
    
    /**
     * Marquer la notification comme lue
     */
    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }
    
    /**
     * Obtenir l'icône en fonction du type de notification
     */
    public function getIconAttribute(): string
    {
        $icons = [
            'demande_acceptee' => 'check-circle',
            'demande_refusee' => 'times-circle',
            'demande_annulee' => 'ban',
            'nouvelle_demande' => 'plus-circle',
            'statut_modifie' => 'sync-alt',
            'paiement_effectue' => 'credit-card',
            'livraison_effectuee' => 'truck',
        ];
        
        return $icons[$this->type] ?? 'bell';
    }
    
    /**
     * Scope pour les notifications non lues
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
    
    /**
     * Scope pour les notifications lues
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }
}
