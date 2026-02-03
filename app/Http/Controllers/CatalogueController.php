<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogue;
use App\Models\Emprunt;
use Illuminate\Support\Facades\Auth;

class CatalogueController extends Controller
{
    public function decouvrir(Request $request)
    {
        // Requête de base pour les catalogues
        $query = Catalogue::where('type_categorie', 'catalogue');

        // Recherche textuelle (titre, auteur, catégorie)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', '%' . $search . '%')
                  ->orWhere('auteur', 'like', '%' . $search . '%')
                  ->orWhere('categorie', 'like', '%' . $search . '%')
                  ->orWhere('resumer', 'like', '%' . $search . '%');
            });
        }

        // Filtre par catégorie si spécifié
        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        // Filtre par prix minimum
        if ($request->filled('prix_min')) {
            $query->where('prix', '>=', (int) $request->prix_min);
        }

        // Filtre par prix maximum
        if ($request->filled('prix_max')) {
            $query->where('prix', '<=', (int) $request->prix_max);
        }

        // Filtre par disponibilité
        if ($request->filled('disponible') && $request->disponible === 'true') {
            $query->where('quantite', '>', 0);
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $allowedSorts = ['created_at', 'titre', 'auteur', 'prix'];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder === 'asc' ? 'asc' : 'desc');
        } else {
            $query->latest();
        }

        // Pagination (12 par page) avec conservation des paramètres de requête
        $catalogues = $query->paginate(12)->withQueryString();

        return view('catalogue.decouvrir', compact('catalogues'));
    }

    public function acheter(Request $request)
    {
        // Requête de base pour les livres empruntables
        $query = Catalogue::where('type_categorie', 'emprunt');

        // Recherche textuelle (titre, auteur, catégorie)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', '%' . $search . '%')
                  ->orWhere('auteur', 'like', '%' . $search . '%')
                  ->orWhere('categorie', 'like', '%' . $search . '%')
                  ->orWhere('resumer', 'like', '%' . $search . '%');
            });
        }

        // Filtre par catégorie si spécifié
        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        // Filtre par disponibilité
        if ($request->filled('disponible') && $request->disponible === 'true') {
            $query->where('quantite', '>', 0);
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $allowedSorts = ['created_at', 'titre', 'auteur'];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder === 'asc' ? 'asc' : 'desc');
        } else {
            $query->latest();
        }

        // Pagination (12 par page) avec conservation des paramètres de requête
        $emprunts = $query->paginate(12)->withQueryString();

        return view('catalogue.acheter', compact('emprunts'));
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
