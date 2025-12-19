<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogue;
use App\Models\Emprunt;
use Illuminate\Support\Facades\Auth;

class EmpruntUserController extends Controller
{
    /**
     * Afficher tous les livres disponibles à l'emprunt
     */
    public function index()
    {
        // Récupérer uniquement les livres empruntables avec stock disponible
        // Tri du plus récent au plus ancien
        $livres = Catalogue::where('type_categorie', 'emprunt')
            ->where('quantite', '>', 0)
            ->orderByDesc('created_at')
            ->orderBy('titre')
            ->paginate(12);

        return view('emprunts.index', compact('livres'));
    }

    /**
     * Afficher les emprunts de l'utilisateur connecté
     */
    public function mesEmprunts()
    {
        $user = Auth::user();

        // Récupérer les emprunts actifs (en cours)
        $empruntsActifs = Emprunt::with('livre')
            ->where('user_id', $user->id)
            ->where('statut', 'en_cours')
            ->orderByDesc('date_emprunt')
            ->get();

        // Récupérer l'historique (retournés)
        $empruntsHistorique = Emprunt::with('livre')
            ->where('user_id', $user->id)
            ->where('statut', 'retourne')
            ->orderByDesc('date_retour')
            ->paginate(10);

        // Récupérer les emprunts en retard
        $empruntsRetard = Emprunt::with('livre')
            ->where('user_id', $user->id)
            ->where('statut', 'en_retard')
            ->orderByDesc('date_emprunt')
            ->get();

        return view('emprunts.mes-emprunts', compact('empruntsActifs', 'empruntsHistorique', 'empruntsRetard'));
    }

    /**
     * Créer une demande d'emprunt (l'admin devra valider)
     */
    public function demander(Request $request)
    {
        $validated = $request->validate([
            'livre_id' => 'required|exists:catalogues,id',
        ]);

        $livre = Catalogue::findOrFail($validated['livre_id']);

        // Vérifier que c'est bien un livre empruntable
        if ($livre->type_categorie !== 'emprunt') {
            return redirect()->back()->with('error', 'Ce livre n\'est pas disponible à l\'emprunt.');
        }

        // Vérifier la disponibilité
        if ($livre->quantite <= 0) {
            return redirect()->back()->with('error', 'Ce livre n\'est plus disponible en ce moment.');
        }

        // Vérifier que l'utilisateur n'a pas déjà emprunté ce livre (en cours)
        $existingEmprunt = Emprunt::where('user_id', Auth::id())
            ->where('livre_id', $livre->id)
            ->whereIn('statut', ['en_cours', 'en_retard'])
            ->first();

        if ($existingEmprunt) {
            return redirect()->back()->with('error', 'Vous avez déjà emprunté ce livre.');
        }

        // Créer l'emprunt avec durée de 14 jours
        Emprunt::create([
            'user_id' => Auth::id(),
            'livre_id' => $livre->id,
            'date_emprunt' => now()->toDateString(),
            'date_retour' => now()->addDays(14)->toDateString(),
            'statut' => 'en_cours',
        ]);

        // Décrémenter le stock
        $livre->decrement('quantite');

        return redirect()->route('emprunts.mes-emprunts')
            ->with('success', "Votre demande d'emprunt pour \"{$livre->titre}\" a été enregistrée avec succès ! Durée : 14 jours.");
    }

    /**
     * Afficher les détails d'un livre empruntable
     */
    public function show($id)
    {
        $livre = Catalogue::where('type_categorie', 'emprunt')->findOrFail($id);

        // Vérifier si l'utilisateur a déjà emprunté ce livre
        $dejaEmprunte = false;
        if (Auth::check()) {
            $dejaEmprunte = Emprunt::where('user_id', Auth::id())
                ->where('livre_id', $livre->id)
                ->whereIn('statut', ['en_cours', 'en_retard'])
                ->exists();
        }

        return view('emprunts.show', compact('livre', 'dejaEmprunte'));
    }
}
