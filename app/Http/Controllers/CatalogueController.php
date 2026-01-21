<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogue;
use App\Models\Emprunt;
use Illuminate\Support\Facades\Auth;

class CatalogueController extends Controller
{
    public function decouvrir()
    {
        // Pagination pour les catalogues (12 par page)
        $catalogues = Catalogue::where('type_categorie', 'catalogue')
            ->latest()
            ->paginate(12);

        return view('catalogue.decouvrir', compact('catalogues'));
    }

    public function acheter()
    {
        // Récupérer les livres à vendre, triés du plus récent au plus ancien
        $livres = Catalogue::where('type_categorie', 'vente')
            ->orderByDesc('created_at')
            ->orderBy('titre')
            ->paginate(12);

        // Collection complète de catalogues (utile pour filtres, catégories, etc.)
        $catalogues = Catalogue::where('type_categorie', 'vente')
            ->orderBy('titre')
            ->get();

        $user = Auth::user();
        $emprunts = $user && method_exists($user, 'emprunts') ? $user->emprunts()->with('livre')->orderByDesc('created_at')->get() : collect();
        return view('catalogue.acheter', compact('livres', 'catalogues', 'emprunts'));
    }

    /**
     * Display a listing of the resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'categorie' => 'required|string|max:255',
            'prix' => 'required|integer|min:0',
            'quantite' => 'required|integer|min:0',
            'resumer' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pdf' => 'nullable|mimes:pdf|max:10000',
        ]);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('img'), $imageName);
            $validated['image'] = $imageName;
        } else {
            $validated['image'] = '';
        }

        // Gestion du PDF
        if ($request->hasFile('pdf')) {
            $pdfName = time().'_'.$request->file('pdf')->getClientOriginalName();
            $request->file('pdf')->move(public_path('pdf'), $pdfName);
            $validated['pdf'] = $pdfName;
        } else {
            $validated['pdf'] = '';
        }

    $validated['type'] = 'catalogue';
    Catalogue::create($validated);
        return redirect()->back()->with('success', 'Livre ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $catalogue = Catalogue::findOrFail($id);

        // Récupérer des livres similaires (même catégorie)
        $livresSimilaires = Catalogue::where('categorie', $catalogue->categorie)
            ->where('id', '!=', $id)
            ->where('type_categorie', $catalogue->type_categorie)
            ->limit(4)
            ->get();

        return view('catalogue.show', compact('catalogue', 'livresSimilaires'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $emprunt = Emprunt::findOrFail($id);
        $user = Auth::user();
        if (!$user || $emprunt->user_id !== $user->id) {
            return redirect()->back()->with('error', "Vous n'êtes pas autorisé à supprimer cet emprunt.");
        }
        $emprunt->delete();
        return redirect()->back()->with('success', 'Emprunt retiré avec succès.');
    }
}
