<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use App\Models\Emprunt;
use App\Models\Equipe;
use App\Models\Formation;
use App\Models\User;

class IndexController extends Controller
{
    /**
     * Affiche la page d'accueil
     */
    public function index()
    {
        // Récupérer les catalogues les plus récents pour la page d'accueil (limite à 9)
        $catalogues = Catalogue::where('type_categorie', 'catalogue')
            ->latest()
            ->take(9)
            ->get();

        // Récupérer les livres de la bibliothèque/emprunt les plus récents (limite à 9)
        $bibliotheques = Catalogue::where('type_categorie', 'emprunt')
            ->latest()
            ->take(9)
            ->get();

        // Récupérer les derniers emprunts (les plus récents en premier)
        $recentEmprunts = Emprunt::with('livre', 'user')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        // Statistiques pour la page d'accueil (évite les appels directs dans la vue)
        $totalMembres = Equipe::where('actif', true)->count();
        $totalLivres = Catalogue::count();
        $totalFormations = Formation::where('active', true)->count();
        $totalUtilisateurs = User::count();

        // Variables avec convention Laravel (minuscule) pour compatibilité
        $Catalogues = $catalogues;
        $Bibliotheques = $bibliotheques;

        return view('index', compact(
            'Catalogues',
            'Bibliotheques',
            'catalogues',
            'bibliotheques',
            'recentEmprunts',
            'totalMembres',
            'totalLivres',
            'totalFormations',
            'totalUtilisateurs'
        ));
    }
}
