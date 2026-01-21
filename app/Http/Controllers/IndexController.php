<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogue;
use App\Models\Emprunt;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer les catalogues les plus récents pour la page d'accueil (limite à 9)
        $Catalogues = Catalogue::where('type_categorie', 'catalogue')
            ->latest()
            ->take(9)
            ->get();

        // Récupérer les livres de la bibliothèque/emprunt les plus récents (limite à 9)
        $Bibliotheques = Catalogue::where('type_categorie', 'emprunt')
            ->latest()
            ->take(9)
            ->get();

        // Récupérer les derniers emprunts (les plus récents en premier)
        $recentEmprunts = Emprunt::with('livre', 'user')->orderByDesc('created_at')->take(6)->get();

        // Passer les Catalogues et Bibliotheques à la vue
        return view('index', compact('Catalogues', 'Bibliotheques', 'recentEmprunts'));
    }

    /**
     * Show the form for creating a new resource.
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
