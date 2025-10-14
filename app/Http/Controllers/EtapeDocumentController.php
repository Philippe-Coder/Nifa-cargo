<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EtapeDocument;
use App\Models\EtapeLogistique;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EtapeDocumentController extends Controller
{
    /**
     * Uploader un document pour une étape
     */
    public function store(Request $request, $etapeId)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,xls,xlsx|max:10240', // 10MB max
            'description' => 'nullable|string|max:500',
            'visibilite' => 'required|in:admin,client,tous'
        ]);

        $etape = EtapeLogistique::findOrFail($etapeId);

        // Vérifier les permissions
        if (!Auth::user()->isAdmin()) {
            // Le client ne peut uploader que sur ses propres demandes
            if ($etape->demandeTransport->user_id !== Auth::id()) {
                abort(403, 'Accès non autorisé');
            }
        }

        $file = $request->file('document');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('etape_documents', $fileName, 'public');

        $document = EtapeDocument::create([
            'etape_logistique_id' => $etapeId,
            'user_id' => Auth::id(),
            'nom' => $file->getClientOriginalName(),
            'chemin' => $filePath,
            'type' => $file->getMimeType(),
            'taille' => $file->getSize(),
            'description' => $request->description,
            'visibilite' => $request->visibilite
        ]);

        return back()->with('success', 'Document ajouté avec succès');
    }

    /**
     * Télécharger un document
     */
    public function download($id)
    {
        $document = EtapeDocument::findOrFail($id);

        // Vérifier les permissions
        if (!$document->estVisiblePour(Auth::user())) {
            abort(403, 'Accès non autorisé');
        }

        return Storage::disk('public')->download($document->chemin, $document->nom);
    }

    /**
     * Supprimer un document
     */
    public function destroy($id)
    {
        $document = EtapeDocument::findOrFail($id);

        // Seul l'admin ou l'auteur peut supprimer
        if (!Auth::user()->isAdmin() && $document->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        // Supprimer le fichier physique
        if (Storage::disk('public')->exists($document->chemin)) {
            Storage::disk('public')->delete($document->chemin);
        }

        $document->delete();

        return back()->with('success', 'Document supprimé avec succès');
    }

    /**
     * Lister les documents d'une étape
     */
    public function index($etapeId)
    {
        $etape = EtapeLogistique::with(['documents.user'])->findOrFail($etapeId);

        // Filtrer les documents selon les permissions
        $documents = $etape->documents->filter(function ($doc) {
            return $doc->estVisiblePour(Auth::user());
        });

        return view('etape-documents.index', compact('etape', 'documents'));
    }
}
