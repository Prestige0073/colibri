<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprunt;
use Illuminate\Support\Facades\Auth;

class BibliothequeController extends Controller
{
    public function emprunter(Request $request)
    {
        $request->validate([
            'livre_id' => 'required|exists:catalogues,id',
        ]);

        $user_id = Auth::id();
        if (!$user_id) {
            return redirect()->back()->with('error', 'Vous devez être connecté pour emprunter un livre.');
        }

        Emprunt::create([
            'user_id' => $user_id,
            'livre_id' => $request->livre_id,
            'date_emprunt' => now(),
            'statut' => 'en_cours',
        ]);

        return redirect()->back()->with('success', 'Livre emprunté avec succès !');
    }

    public function destroy($id)
    {
        $emprunt = Emprunt::findOrFail($id);

        // Vérifier que l'utilisateur connecté est le propriétaire de l'emprunt
        if ($emprunt->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à supprimer cet emprunt.');
        }

        $emprunt->delete();

        return redirect()->back()->with('success', 'Emprunt supprimé avec succès.');
    }

    public function acheter()
    {
        $livres = \App\Models\Catalogue::all();
        $user = Auth::user();
        $emprunts = $user ? $user->emprunts()->with('livre')->orderByDesc('created_at')->get() : collect();
        return view('catalogue.acheter', compact('livres', 'emprunts'));
    }

    /**
     * Affiche le visualiseur PDF sécurisé pour un livre acheté
     */
    public function lire($catalogueId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Vous devez vous connecter pour accéder à ce livre.');
        }

        // Vérifier que le livre existe
        $livre = \App\Models\Catalogue::findOrFail($catalogueId);

        // Vérifier que l'utilisateur a bien acheté ce livre
        if (!$user->hasPurchasedBook($catalogueId)) {
            return redirect()->route('account.bibliotheque')
                ->with('error', 'Vous n\'avez pas accès à ce livre. Veuillez l\'acheter pour y accéder.');
        }

        // Vérifier que le livre a un PDF
        if (!$livre->pdf) {
            return redirect()->route('account.bibliotheque')
                ->with('error', 'Ce livre n\'a pas de version PDF disponible.');
        }

        // Afficher le visualiseur PDF sécurisé
        return view('bibliotheque.lire', [
            'livre' => $livre,
            'user' => $user,
        ]);
    }
}
