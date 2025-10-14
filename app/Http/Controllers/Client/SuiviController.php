<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DemandeTransport;
use Illuminate\Support\Facades\Auth;

class SuiviController extends Controller
{
    /**
     * Afficher toutes les demandes du client
     */
    public function index()
    {
        $demandes = DemandeTransport::with(['etapes', 'documents'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        return view('client.mes-demandes.index', compact('demandes'));
    }

    /**
     * Afficher les détails d'une demande spécifique
     */
    public function show($id)
    {
        $demande = DemandeTransport::with([
            'etapes.agent',
            'etapes.documents.user',
            'documents.uploadedBy',
            'notifications' => function($query) {
                $query->where('notifiable_type', DemandeTransport::class)
                      ->where('user_id', Auth::id())
                      ->latest();
            }
        ])
        ->where('user_id', Auth::id())
        ->findOrFail($id);
        
        return view('client.mes-demandes.show', compact('demande'));
    }

    /**
     * Uploader un document pour une demande
     */
    public function uploadDocument(Request $request, $id)
    {
        $demande = DemandeTransport::where('user_id', Auth::id())->findOrFail($id);
        
        // Rediriger vers le contrôleur de documents
        return app(\App\Http\Controllers\DocumentController::class)->store($request, $id);
    }
}
