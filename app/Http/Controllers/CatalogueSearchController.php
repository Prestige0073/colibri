<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use Illuminate\Http\Request;

class CatalogueSearchController extends Controller
{
    /**
     * Recherche avancée de catalogues via AJAX
     */
    public function search(Request $request)
    {
        $query = Catalogue::query();

        // Filtre par type de catalogue (découvrir ou acheter)
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type_categorie', $request->type);
        }

        // Recherche par mot-clé (titre, auteur, catégorie)
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('titre', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('auteur', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('categorie', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('resumer', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filtre par catégorie
        if ($request->filled('categorie') && $request->categorie !== 'all') {
            $query->where('categorie', $request->categorie);
        }

        // Filtre par plage de prix
        if ($request->filled('prix_min')) {
            $query->where('prix', '>=', $request->prix_min);
        }
        if ($request->filled('prix_max')) {
            $query->where('prix', '<=', $request->prix_max);
        }

        // Filtre par disponibilité
        if ($request->has('disponible') && $request->disponible == '1') {
            $query->where('quantite', '>', 0);
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        switch($sortBy) {
            case 'titre':
                $query->orderBy('titre', $sortOrder);
                break;
            case 'prix':
                $query->orderBy('prix', $sortOrder);
                break;
            case 'auteur':
                $query->orderBy('auteur', $sortOrder);
                break;
            default:
                $query->orderBy('created_at', $sortOrder);
        }

        // Pagination
        $perPage = $request->get('per_page', 12);
        $catalogues = $query->paginate($perPage);

        // Retourner en JSON pour AJAX
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $catalogues->items(),
                'pagination' => [
                    'total' => $catalogues->total(),
                    'per_page' => $catalogues->perPage(),
                    'current_page' => $catalogues->currentPage(),
                    'last_page' => $catalogues->lastPage(),
                    'from' => $catalogues->firstItem(),
                    'to' => $catalogues->lastItem(),
                ]
            ]);
        }

        // Vue normale si pas AJAX
        return view('catalogue.search-results', compact('catalogues'));
    }

    /**
     * Obtenir les catégories disponibles
     */
    public function getCategories(Request $request)
    {
        $type = $request->get('type', 'all');

        $query = Catalogue::select('categorie')
            ->whereNotNull('categorie')
            ->where('categorie', '!=', '');

        if ($type !== 'all') {
            $query->where('type_categorie', $type);
        }

        $categories = $query->distinct()
            ->orderBy('categorie')
            ->pluck('categorie');

        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }

    /**
     * Obtenir les statistiques de prix (min, max, moyenne)
     */
    public function getPriceStats(Request $request)
    {
        $type = $request->get('type', 'all');

        $query = Catalogue::whereNotNull('prix');

        if ($type !== 'all') {
            $query->where('type_categorie', $type);
        }

        $stats = $query->selectRaw('
            MIN(prix) as prix_min,
            MAX(prix) as prix_max,
            AVG(prix) as prix_moyen
        ')->first();

        return response()->json([
            'success' => true,
            'stats' => [
                'min' => (int) ($stats->prix_min ?? 0),
                'max' => (int) ($stats->prix_max ?? 0),
                'average' => (int) ($stats->prix_moyen ?? 0)
            ]
        ]);
    }
}
