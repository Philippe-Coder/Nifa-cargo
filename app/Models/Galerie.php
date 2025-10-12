<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Galerie extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'image',
        'categorie',
        'active',
        'mise_en_avant',
        'user_id',
        'ordre',
        'alt_text'
    ];

    protected $casts = [
        'active' => 'boolean',
        'mise_en_avant' => 'boolean',
    ];

    // Catégories disponibles
    public const CATEGORIES = [
        'transport' => 'Transport & Logistique',
        'import' => 'Import',
        'export' => 'Export',
        'entreprise' => 'Notre Entreprise',
        'equipe' => 'Notre Équipe',
        'vehicules' => 'Nos Véhicules',
        'entrepots' => 'Nos Entrepôts',
        'clients' => 'Nos Clients'
    ];

    /**
     * Relation avec l'utilisateur (admin) qui a ajouté la photo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope pour les photos actives
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope pour les photos mises en avant
     */
    public function scopeMiseEnAvant($query)
    {
        return $query->where('mise_en_avant', true);
    }

    /**
     * Scope pour une catégorie spécifique
     */
    public function scopeCategorie($query, $categorie)
    {
        return $query->where('categorie', $categorie);
    }

    /**
     * Scope pour l'ordre d'affichage
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('mise_en_avant', 'desc')
                    ->orderBy('ordre', 'desc')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Accesseur pour la catégorie formatée
     */
    public function getCategorieFormateAttribute()
    {
        return self::CATEGORIES[$this->categorie] ?? $this->categorie;
    }

    /**
     * Accesseur pour la classe CSS de la catégorie
     */
    public function getCategorieClassAttribute()
    {
        return match($this->categorie) {
            'transport' => 'bg-blue-100 text-blue-800',
            'import' => 'bg-green-100 text-green-800',
            'export' => 'bg-red-100 text-red-800',
            'entreprise' => 'bg-purple-100 text-purple-800',
            'equipe' => 'bg-yellow-100 text-yellow-800',
            'vehicules' => 'bg-indigo-100 text-indigo-800',
            'entrepots' => 'bg-gray-100 text-gray-800',
            'clients' => 'bg-pink-100 text-pink-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Accesseur pour l'URL complète de l'image
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }

    /**
     * Accesseur pour le texte alternatif par défaut
     */
    public function getAltAttribute()
    {
        return $this->alt_text ?: $this->titre;
    }
}
