<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galerie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalerieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Galerie::with('user');

        // Filtrer par catégorie si spécifiée
        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        $galeries = $query->ordered()->paginate(20);
        $categories = Galerie::CATEGORIES;

        return view('admin.galeries.index', compact('galeries', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.galeries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            'categorie' => 'required|in:' . implode(',', array_keys(Galerie::CATEGORIES)),
            'active' => 'boolean',
            'mise_en_avant' => 'boolean',
            'ordre' => 'nullable|integer|min:0|max:999',
            'alt_text' => 'nullable|string|max:255'
        ]);

        // Upload de l'image
        $validated['image'] = $request->file('image')->store('galerie', 'public');

        // Ajouter l'ID de l'admin connecté
        $validated['user_id'] = auth()->id();
        
        // Valeurs par défaut
        $validated['active'] = $request->has('active');
        $validated['mise_en_avant'] = $request->has('mise_en_avant');
        $validated['ordre'] = $validated['ordre'] ?? 0;

        Galerie::create($validated);

        return redirect()->route('admin.galeries.index')
            ->with('success', 'Photo ajoutée à la galerie avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Galerie $galerie)
    {
        $galerie->load('user');
        return view('admin.galeries.show', compact('galerie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Galerie $galerie)
    {
        return view('admin.galeries.edit', compact('galerie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galerie $galerie)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'categorie' => 'required|in:' . implode(',', array_keys(Galerie::CATEGORIES)),
            'active' => 'boolean',
            'mise_en_avant' => 'boolean',
            'ordre' => 'nullable|integer|min:0|max:999',
            'alt_text' => 'nullable|string|max:255'
        ]);

        // Gestion de l'upload d'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($galerie->image) {
                Storage::disk('public')->delete($galerie->image);
            }
            $validated['image'] = $request->file('image')->store('galerie', 'public');
        }

        // Valeurs par défaut
        $validated['active'] = $request->has('active');
        $validated['mise_en_avant'] = $request->has('mise_en_avant');
        $validated['ordre'] = $validated['ordre'] ?? 0;

        $galerie->update($validated);

        return redirect()->route('admin.galeries.index')
            ->with('success', 'Photo mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galerie $galerie)
    {
        // Supprimer l'image du stockage
        if ($galerie->image) {
            Storage::disk('public')->delete($galerie->image);
        }

        $galerie->delete();

        return redirect()->route('admin.galeries.index')
            ->with('success', 'Photo supprimée de la galerie avec succès !');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(Galerie $galerie)
    {
        $galerie->update(['active' => !$galerie->active]);
        
        $status = $galerie->active ? 'activée' : 'désactivée';
        return back()->with('success', "Photo {$status} avec succès !");
    }

    /**
     * Toggle mise en avant status
     */
    public function toggleMiseEnAvant(Galerie $galerie)
    {
        $galerie->update(['mise_en_avant' => !$galerie->mise_en_avant]);
        
        $status = $galerie->mise_en_avant ? 'mise en avant' : 'retirée de la mise en avant';
        return back()->with('success', "Photo {$status} avec succès !");
    }
}
