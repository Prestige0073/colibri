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
        $emprunts = $user ? $user->emprunts()->with('livre')->get() : collect();
        return view('catalogue.acheter', compact('livres', 'emprunts'));
    }
}
