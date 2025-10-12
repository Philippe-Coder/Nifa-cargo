<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Galerie;
use Illuminate\Http\Request;

class GaleriePublicController extends Controller
{
    /**
     * Affiche la page de la galerie publique
     */
    public function index(Request $request)
    {
        $query = Galerie::with('images')
            ->where('active', true)
            ->orderByDesc('created_at');

        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        $galeries = $query->withCount('images')->paginate(12);
        $categories = Galerie::CATEGORIES;

        return view('public.galerie', compact('galeries', 'categories'));
    }

    /**
     * Affiche un album spécifique
     */
    public function show(Galerie $galerie)
    {
        if (!$galerie->active) {
            abort(404);
        }

        $galerie->load('images');
        
        return view('public.galerie-show', compact('galerie'));
    }
}
