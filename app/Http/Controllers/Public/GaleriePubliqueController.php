<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Galerie;
use Illuminate\Http\Request;

class GaleriePubliqueController extends Controller
{
    /**
     * Afficher toutes les galeries publiques
     */
    public function index(Request $request)
    {
        $query = Galerie::active();

        // Filtrer par catégorie si spécifiée
        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        // Recherche par titre si spécifiée
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('titre', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $galeries = $query->ordered()->paginate(12);
        $categories = Galerie::CATEGORIES;
        
        // Récupérer les galeries mises en avant pour le hero
        $galeriesMiseEnAvant = Galerie::active()->miseEnAvant()->ordered()->limit(6)->get();

        return view('public.galerie.index', compact('galeries', 'categories', 'galeriesMiseEnAvant'));
    }

    /**
     * Afficher une galerie spécifique
     */
    public function show(Galerie $galerie)
    {
        // Vérifier que la galerie est active
        if (!$galerie->active) {
            abort(404);
        }

        // Récupérer d'autres images de la même catégorie
        $galeriesLiees = Galerie::active()
            ->where('categorie', $galerie->categorie)
            ->where('id', '!=', $galerie->id)
            ->ordered()
            ->limit(8)
            ->get();

        return view('public.galerie.show', compact('galerie', 'galeriesLiees'));
    }

    /**
     * Afficher les galeries par catégorie
     */
    public function categorie($categorie)
    {
        // Vérifier que la catégorie existe
        if (!array_key_exists($categorie, Galerie::CATEGORIES)) {
            abort(404);
        }

        $galeries = Galerie::active()
            ->categorie($categorie)
            ->ordered()
            ->paginate(12);

        $categories = Galerie::CATEGORIES;
        $categorieActuelle = $categorie;

        return view('public.galerie.categorie', compact('galeries', 'categories', 'categorieActuelle'));
    }
}