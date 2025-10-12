<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $fillable = [
        'demande_transport_id',
        'nom',
        'type',
        'chemin',
        'extension',
        'taille',
        'uploaded_by'
    ];

    /**
     * Relation avec la demande de transport
     */
    public function demandeTransport(): BelongsTo
    {
        return $this->belongsTo(DemandeTransport::class);
    }

    /**
     * Relation avec l'utilisateur qui a uploadé
     */
    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Obtenir l'URL du document
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->chemin);
    }

    /**
     * Obtenir la taille formatée
     */
    public function getTailleFormatteeAttribute()
    {
        $bytes = $this->taille;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Types de documents autorisés
     */
    public static function getTypesAutorises()
    {
        return [
            'facture_proforma' => 'Facture Proforma',
            'bordereau' => 'Bordereau',
            'connaissement' => 'Connaissement',
            'certificat_origine' => 'Certificat d\'origine',
            'liste_colisage' => 'Liste de colisage',
            'autre' => 'Autre document'
        ];
    }
}
