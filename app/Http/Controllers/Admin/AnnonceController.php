<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $annonces = Annonce::with('user')
            ->orderBy('epingle', 'desc')
            ->orderBy('ordre', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.annonces.index', compact('annonces'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.annonces.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'type' => 'required|in:info,promotion,urgent,actualite',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'boolean',
            'epingle' => 'boolean',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'ordre' => 'nullable|integer|min:0|max:999'
        ]);

        // Gestion de l'upload d'image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('annonces', 'public');
        }

        // Ajouter l'ID de l'admin connecté
        $validated['user_id'] = auth()->id();
        
        // Valeurs par défaut
        $validated['active'] = $request->boolean('active');
        $validated['epingle'] = $request->boolean('epingle');
        $validated['ordre'] = $validated['ordre'] ?? 0;

        Annonce::create($validated);

        return redirect()->route('admin.annonces.index')
            ->with('success', 'Annonce créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Annonce $annonce)
    {
        $annonce->load('user');
        return view('admin.annonces.show', compact('annonce'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Annonce $annonce)
    {
        return view('admin.annonces.edit', compact('annonce'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Annonce $annonce)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'type' => 'required|in:info,promotion,urgent,actualite',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'boolean',
            'epingle' => 'boolean',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'ordre' => 'nullable|integer|min:0|max:999'
        ]);

        // Gestion de l'upload d'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($annonce->image) {
                Storage::disk('public')->delete($annonce->image);
            }
            $validated['image'] = $request->file('image')->store('annonces', 'public');
        }

        // Valeurs par défaut
        $validated['active'] = $request->boolean('active');
        $validated['epingle'] = $request->boolean('epingle');
        $validated['ordre'] = $validated['ordre'] ?? 0;

        $annonce->update($validated);

        return redirect()->route('admin.annonces.index')
            ->with('success', 'Annonce mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Annonce $annonce)
    {
        // Supprimer l'image si elle existe
        if ($annonce->image) {
            Storage::disk('public')->delete($annonce->image);
        }

        $annonce->delete();

        return redirect()->route('admin.annonces.index')
            ->with('success', 'Annonce supprimée avec succès !');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(Annonce $annonce)
    {
        $annonce->update(['active' => !$annonce->active]);
        
        $status = $annonce->active ? 'activée' : 'désactivée';
        return back()->with('success', "Annonce {$status} avec succès !");
    }

    /**
     * Toggle epingle status
     */
    public function toggleEpingle(Annonce $annonce)
    {
        $annonce->update(['epingle' => !$annonce->epingle]);
        
        $status = $annonce->epingle ? 'épinglée' : 'désépinglée';
        return back()->with('success', "Annonce {$status} avec succès !");
    }
}
