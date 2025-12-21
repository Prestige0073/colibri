<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CartItem;
use App\Models\Emprunt;
use App\Models\Catalogue;
use App\Services\EmpruntService;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Afficher le tableau de bord admin avec toutes les statistiques
     */
    public function index()
    {
        // Mettre à jour automatiquement les emprunts expirés
        EmpruntService::markLateEmprunts();
        EmpruntService::updateExpiredEmprunts();

        // Statistiques utilisateurs
        $totalUsers = User::count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $activeUsers = User::where('created_at', '>=', now()->subDays(30))->count();

        // Statistiques ventes
        $totalSales = CartItem::count();
        $totalRevenue = CartItem::join('catalogues', 'cart_items.catalogue_id', '=', 'catalogues.id')
            ->sum(DB::raw('cart_items.quantite * catalogues.prix'));
        $salesThisMonth = CartItem::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $revenueThisMonth = CartItem::join('catalogues', 'cart_items.catalogue_id', '=', 'catalogues.id')
            ->whereMonth('cart_items.created_at', now()->month)
            ->whereYear('cart_items.created_at', now()->year)
            ->sum(DB::raw('cart_items.quantite * catalogues.prix'));

        // Statistiques emprunts
        $totalEmprunts = Emprunt::count();
        $empruntsEnCours = Emprunt::where('statut', 'en_cours')->count();
        $empruntsEnAttente = Emprunt::where('statut', 'en_attente')->count();
        $empruntsEnRetard = Emprunt::where('statut', 'en_retard')->count();
        $empruntsRetournes = Emprunt::where('statut', 'retourne')->count();
        $empruntsThisMonth = Emprunt::whereMonth('date_emprunt', now()->month)
            ->whereYear('date_emprunt', now()->year)
            ->count();

        // Emprunts avec accès expiré (alerte)
        $empruntsAccesExpire = Emprunt::with(['user', 'livre'])
            ->whereIn('statut', ['en_cours', 'en_retard'])
            ->whereNotNull('access_expires_at')
            ->where('access_expires_at', '<', now())
            ->orderBy('access_expires_at', 'asc')
            ->get();

        // Statistiques catalogue
        $totalBooks = Catalogue::count();
        $booksForSale = Catalogue::where('type_categorie', 'vente')->count();
        $booksForLoan = Catalogue::where('type_categorie', 'emprunt')->count();
        $outOfStock = Catalogue::where('quantite', 0)->count();

        // Activités récentes
        $recentUsers = User::orderByDesc('created_at')->take(10)->get();
        $recentSales = CartItem::with(['user', 'catalogue'])
            ->orderByDesc('created_at')
            ->take(10)
            ->get();
        $recentEmprunts = Emprunt::with(['user', 'livre'])
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        // Top vendeurs
        $topSellingBooks = CartItem::select('catalogue_id', DB::raw('SUM(quantite) as total_sold'))
            ->groupBy('catalogue_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->with('catalogue')
            ->get();

        // Top livres empruntés
        $topBorrowedBooks = Emprunt::select('livre_id', DB::raw('COUNT(*) as total_borrowed'))
            ->groupBy('livre_id')
            ->orderByDesc('total_borrowed')
            ->take(5)
            ->with('livre')
            ->get();

        // Graphiques - Ventes par mois (6 derniers mois)
        $salesByMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = CartItem::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            $salesByMonth[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }

        // Graphiques - Emprunts par mois (6 derniers mois)
        $empruntsByMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = Emprunt::whereMonth('date_emprunt', $date->month)
                ->whereYear('date_emprunt', $date->year)
                ->count();
            $empruntsByMonth[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }

        return view('admin.dashboard', compact(
            'totalUsers', 'newUsersThisMonth', 'activeUsers',
            'totalSales', 'totalRevenue', 'salesThisMonth', 'revenueThisMonth',
            'totalEmprunts', 'empruntsEnCours', 'empruntsEnAttente', 'empruntsEnRetard',
            'empruntsRetournes', 'empruntsThisMonth', 'empruntsAccesExpire',
            'totalBooks', 'booksForSale', 'booksForLoan', 'outOfStock',
            'recentUsers', 'recentSales', 'recentEmprunts',
            'topSellingBooks', 'topBorrowedBooks',
            'salesByMonth', 'empruntsByMonth'
        ));
    }

    /**
     * Récupérer tous les utilisateurs pour la modale
     */
    public function getUsers()
    {
        $users = User::orderByDesc('created_at')->get();
        return response()->json($users);
    }

    /**
     * Récupérer toutes les ventes pour la modale
     */
    public function getSales()
    {
        $sales = CartItem::with(['user', 'catalogue'])
            ->orderByDesc('created_at')
            ->get();
        return response()->json($sales);
    }

    /**
     * Récupérer tous les emprunts pour la modale
     */
    public function getEmprunts()
    {
        $emprunts = Emprunt::with(['user', 'livre', 'validateur'])
            ->orderByDesc('created_at')
            ->get();
        return response()->json($emprunts);
    }
}
