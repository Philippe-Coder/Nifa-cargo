<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'annonce_id',
        'user_id',
        'nom',
        'email',
        'contenu',
        'approuve',
        'parent_id'
    ];

    protected $casts = [
        'approuve' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec l'annonce/article
     */
    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class);
    }

    /**
     * Relation avec l'utilisateur (si connecté)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation pour les réponses (commentaires enfants)
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->where('approuve', true)->orderBy('created_at');
    }

    /**
     * Relation pour le commentaire parent
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Scope pour les commentaires approuvés
     */
    public function scopeApprouve($query)
    {
        return $query->where('approuve', true);
    }

    /**
     * Scope pour les commentaires principaux (pas de réponses)
     */
    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Obtenir le nom de l'auteur du commentaire
     */
    public function getAuthorNameAttribute()
    {
        if ($this->user) {
            return $this->user->name;
        }
        return $this->nom;
    }

    /**
     * Obtenir l'email de l'auteur du commentaire
     */
    public function getAuthorEmailAttribute()
    {
        if ($this->user) {
            return $this->user->email;
        }
        return $this->email;
    }
}
