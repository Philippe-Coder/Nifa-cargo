<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_transport',
        'marchandise',
        'poids',
        'origine',
        'destination',
        'description',
        'statut',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
