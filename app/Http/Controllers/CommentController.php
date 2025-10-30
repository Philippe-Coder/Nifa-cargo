<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Récupérer les commentaires d'un article
     */
    public function index($annonceId)
    {
        $comments = Comment::where('annonce_id', $annonceId)
            ->where('approuve', true)
            ->whereNull('parent_id')
            ->with(['user', 'replies' => function($query) {
                $query->where('approuve', true)->with('user');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'comments' => $comments
        ]);
    }

    /**
     * Stocker un nouveau commentaire
     */
    public function store(Request $request, $annonceId)
    {
        // Validation différente selon si l'utilisateur est connecté ou non
        if (Auth::check()) {
            $validator = Validator::make($request->all(), [
                'contenu' => 'required|string|max:1000',
                'parent_id' => 'nullable|exists:comments,id'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'nom' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'contenu' => 'required|string|max:1000',
                'parent_id' => 'nullable|exists:comments,id'
            ]);
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Vérifier que l'annonce existe
        $annonce = Annonce::findOrFail($annonceId);

        // Créer le commentaire
        $commentData = [
            'annonce_id' => $annonceId,
            'contenu' => $request->contenu,
            'parent_id' => $request->parent_id,
            'approuve' => true // Approbation automatique des commentaires
        ];

        if (Auth::check()) {
            $commentData['user_id'] = Auth::id();
        } else {
            $commentData['nom'] = $request->nom;
            $commentData['email'] = $request->email;
        }

        Comment::create($commentData);

        return back()->with('success', 'Votre commentaire a été publié avec succès !');
    }

    /**
     * Approuver un commentaire (admin seulement)
     */
    public function approve($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('accueil')->with('error', 'Accès non autorisé.');
        }
        
        $comment = Comment::findOrFail($id);
        $comment->update(['approuve' => true]);

        return back()->with('success', 'Commentaire approuvé avec succès.');
    }

    /**
     * Supprimer un commentaire (admin seulement)
     */
    public function destroy($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('accueil')->with('error', 'Accès non autorisé.');
        }
        
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return back()->with('success', 'Commentaire supprimé avec succès.');
    }
}
