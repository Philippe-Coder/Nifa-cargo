<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Annonce extends Model
{
    protected $fillable = [
        'titre',
        'contenu',
        'type',
        'image',
        'active',
        'epingle',
        'date_debut',
        'date_fin',
        'date_publication',
        'date_expiration',
        'user_id',
        'ordre'
    ];

    protected $casts = [
        'active' => 'boolean',
        'epingle' => 'boolean',
        'date_debut' => 'date',
        'date_fin' => 'date',
        'date_publication' => 'datetime',
        'date_expiration' => 'datetime',
    ];

    // Types d'annonces disponibles
    public const TYPES = [
        'info' => 'Information',
        'promotion' => 'Promotion',
        'urgent' => 'Urgent',
        'actualite' => 'Actualité'
    ];

    /**
     * Relation avec l'utilisateur (admin) qui a créé l'annonce
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec les commentaires
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->where('approuve', true)->whereNull('parent_id')->orderBy('created_at', 'desc');
    }

    /**
     * Relation avec tous les commentaires (pour l'admin)
     */
    public function allComments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    /**
     * Scope pour les annonces actives
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope pour les annonces épinglées
     */
    public function scopeEpingle($query)
    {
        return $query->where('epingle', true);
    }

    /**
     * Scope pour les annonces dans la période de validité
     */
    public function scopeValide($query)
    {
        $today = now()->toDateString();
        return $query->where(function ($q) use ($today) {
            $q->whereNull('date_debut')
              ->orWhere('date_debut', '<=', $today);
        })->where(function ($q) use ($today) {
            $q->whereNull('date_fin')
              ->orWhere('date_fin', '>=', $today);
        });
    }

    /**
     * Scope pour l'ordre d'affichage
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('epingle', 'desc')
                    ->orderBy('ordre', 'desc')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Accesseur pour le type formaté
     */
    public function getTypeFormateAttribute()
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    /**
     * Accesseur pour la classe CSS du type
     */
    public function getTypeClassAttribute()
    {
        return match($this->type) {
            'info' => 'bg-blue-100 text-blue-800',
            'promotion' => 'bg-green-100 text-green-800',
            'urgent' => 'bg-red-100 text-red-800',
            'actualite' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Vérifier si l'annonce est valide (dans la période)
     */
    public function estValide(): bool
    {
        $today = now()->toDateString();
        
        $debutOk = is_null($this->date_debut) || $this->date_debut <= $today;
        $finOk = is_null($this->date_fin) || $this->date_fin >= $today;
        
        return $debutOk && $finOk;
    }
}
