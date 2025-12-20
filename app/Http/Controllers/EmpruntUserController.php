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

        // Récupérer les demandes en attente de validation
        $empruntsEnAttente = Emprunt::with('livre')
            ->where('user_id', $user->id)
            ->where('statut', 'en_attente')
            ->orderByDesc('date_emprunt')
            ->get();

        // Récupérer les emprunts actifs (validés et en cours)
        $empruntsActifs = Emprunt::with('livre')
            ->where('user_id', $user->id)
            ->where('statut', 'en_cours')
            ->whereNotNull('valide_le')
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

        return view('emprunts.mes-emprunts', compact('empruntsEnAttente', 'empruntsActifs', 'empruntsHistorique', 'empruntsRetard'));
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

        // Vérifier que l'utilisateur n'a pas déjà emprunté ce livre (en cours ou en attente)
        $existingEmprunt = Emprunt::where('user_id', Auth::id())
            ->where('livre_id', $livre->id)
            ->whereIn('statut', ['en_cours', 'en_retard', 'en_attente'])
            ->first();

        if ($existingEmprunt) {
            if ($existingEmprunt->statut === 'en_attente') {
                return redirect()->back()->with('info', 'Vous avez déjà une demande d\'emprunt en attente pour ce livre.');
            }
            return redirect()->back()->with('error', 'Vous avez déjà emprunté ce livre.');
        }

        // Créer la demande d'emprunt (statut: en_attente) - l'admin devra valider
        Emprunt::create([
            'user_id' => Auth::id(),
            'livre_id' => $livre->id,
            'date_emprunt' => now()->toDateString(),
            'date_retour' => now()->addDays(14)->toDateString(),
            'statut' => 'en_attente',  // Statut en attente de validation
        ]);

        // Ne pas décrémenter le stock immédiatement - sera fait lors de la validation

        return redirect()->route('emprunts.mes-emprunts')
            ->with('success', "Votre demande d'emprunt pour \"{$livre->titre}\" a été soumise avec succès ! Elle sera traitée par un administrateur.");
    }

    /**
     * Afficher les détails d'un livre empruntable
     */
    public function show($id)
    {
        $livre = Catalogue::where('type_categorie', 'emprunt')->findOrFail($id);

        // Vérifier si l'utilisateur a déjà emprunté ce livre
        $dejaEmprunte = false;
        $enAttente = false;
        if (Auth::check()) {
            $dejaEmprunte = Emprunt::where('user_id', Auth::id())
                ->where('livre_id', $livre->id)
                ->whereIn('statut', ['en_cours', 'en_retard'])
                ->exists();

            $enAttente = Emprunt::where('user_id', Auth::id())
                ->where('livre_id', $livre->id)
                ->where('statut', 'en_attente')
                ->exists();
        }

        return view('emprunts.show', compact('livre', 'dejaEmprunte', 'enAttente'));
    }
}
