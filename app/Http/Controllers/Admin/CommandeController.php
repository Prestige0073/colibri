<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    public function __construct()
    {
        // middleware applied at route group level
    }

    public function index(Request $request)
    {
        // Regrouper les commandes par utilisateur pour l'interface admin
        $sort = $request->input('sort', 'date'); // 'date' or 'amount'

        // Ordonner les utilisateurs par la date de leur dernière commande (les plus récents en premier)
        $usersQuery = User::whereHas('commandes')
            ->withCount(['commandes as last_commande_at' => function ($q) {
                $q->select(DB::raw('MAX(created_at)'));
            }])
            ->orderByDesc('last_commande_at');

        $users = $usersQuery->paginate(20);

        // Pour chaque utilisateur, charger les dernières commandes (limit 10) selon le tri demandé
        foreach ($users as $user) {
            // Active commandes (non livrées)
            $activeQuery = $user->commandes()->with('items')->where('statut','<>','livre');
            if ($request->filled('statut')) {
                $activeQuery->where('statut', $request->input('statut'));
            }
            if ($sort === 'amount') {
                $activeQuery->orderByDesc('total');
            } else {
                $activeQuery->orderByDesc('created_at');
            }
            $active = $activeQuery->take(10)->get();
            $user->setRelation('commandes_active', $active);

            // Archives (livrées) - up to 50 latest
            $archiveQuery = $user->commandes()->with('items')->where('statut','livre')->orderByDesc('created_at');
            $archives = $archiveQuery->take(50)->get();
            $user->setRelation('commandes_archives', $archives);
        }

        // Ensure pagination links keep current filters
        $users->appends($request->only(['statut','sort']));
        return view('admin.commandes', compact('users','sort'));
    }

    // Bulk update status for all commandes of a given user
    public function bulkUpdateStatus(Request $request, User $user)
    {
        $request->validate(['statut' => 'required|string']);

        $statut = $request->input('statut');
        // Update all commandes for this user
        \App\Models\Commande::where('user_id', $user->id)->update(['statut' => $statut]);

        return redirect()->back()->with('success', 'Statut des commandes de l\'utilisateur mis à jour.');
    }

    public function show(Commande $commande)
    {
        $commande->load('items');
        return view('admin.commandes_show', compact('commande'));
    }

    // simple status update endpoint (POST)
    public function updateStatus(Request $request, Commande $commande)
    {
        $request->validate(['statut' => 'required|string']);
        $commande->statut = $request->input('statut');
        $commande->save();
        return redirect()->back()->with('success', 'Statut mis à jour.');
    }
}
