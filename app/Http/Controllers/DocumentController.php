<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DemandeTransport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * Uploader un document pour une demande
     */
    public function store(Request $request, $demandeId)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240', // 10MB max
            'type' => 'required|string|in:facture_proforma,bordereau,connaissement,certificat_origine,liste_colisage,autre'
        ]);

        $demande = DemandeTransport::findOrFail($demandeId);
        
        // Vérifier que l'utilisateur peut uploader pour cette demande
        if (Auth::user()->id !== $demande->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Non autorisé');
        }

        $file = $request->file('document');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents/' . $demandeId, $filename, 'public');

        $document = Document::create([
            'demande_transport_id' => $demandeId,
            'nom' => $file->getClientOriginalName(),
            'type' => $request->type,
            'chemin' => $path,
            'extension' => $file->getClientOriginalExtension(),
            'taille' => $file->getSize(),
            'uploaded_by' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Document uploadé avec succès',
            'document' => $document
        ]);
    }

    /**
     * Télécharger un document
     */
    public function download($id)
    {
        $document = Document::findOrFail($id);
        $demande = $document->demandeTransport;
        
        // Vérifier les permissions
        if (Auth::user()->id !== $demande->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Non autorisé');
        }

        if (!Storage::disk('public')->exists($document->chemin)) {
            abort(404, 'Fichier non trouvé');
        }

        return Storage::disk('public')->download($document->chemin, $document->nom);
    }

    /**
     * Supprimer un document
     */
    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $demande = $document->demandeTransport;
        
        // Vérifier les permissions
        if (Auth::user()->id !== $demande->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Non autorisé');
        }

        // Supprimer le fichier physique
        if (Storage::disk('public')->exists($document->chemin)) {
            Storage::disk('public')->delete($document->chemin);
        }

        // Supprimer l'enregistrement
        $document->delete();

        return response()->json([
            'success' => true,
            'message' => 'Document supprimé avec succès'
        ]);
    }

    /**
     * Lister les documents d'une demande
     */
    public function index($demandeId)
    {
        $demande = DemandeTransport::with('documents.uploadedBy')->findOrFail($demandeId);
        
        // Vérifier les permissions
        if (Auth::user()->id !== $demande->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Non autorisé');
        }

        return response()->json([
            'documents' => $demande->documents
        ]);
    }
}
