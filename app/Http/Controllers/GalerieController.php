<?php

namespace App\Http\Controllers;

use App\Models\Galerie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalerieController extends Controller
{
    public function index(Request $request)
    {
        $query = Galerie::with('images')
            ->where('active', true)
            ->orderByDesc('created_at');

        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        $galeries = $query->paginate(12);
        $categories = Galerie::CATEGORIES;

        // Compter le nombre d'images pour chaque galerie
        $galeries = $query->withCount('images')->paginate(12);
        $categories = Galerie::CATEGORIES;

        return view('public.galerie', compact('galeries', 'categories'));
    }

    public function show(Galerie $galerie)
    {
        $galerie->load('images');
        return view('galerie.album', compact('galerie'));
    }
}
