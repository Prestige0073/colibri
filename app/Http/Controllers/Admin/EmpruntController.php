<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Emprunt;
use App\Models\User;
use App\Models\Catalogue;
use Illuminate\Support\Facades\DB;

class EmpruntController extends Controller
{
    public function index()
    {
        // Liste des livres/empruntables
        $livres = Catalogue::all();
        $cataloguesEmprunt = Catalogue::where('type_categorie', 'emprunt')->get();

        // Charger les utilisateurs ayant des emprunts, triés par date du dernier emprunt
        $usersQuery = User::whereHas('emprunts')
            ->withCount(['emprunts as last_emprunt_at' => function ($q) {
                $q->select(DB::raw('MAX(created_at)'));
            }])
            ->orderByDesc('last_emprunt_at');

        $users = $usersQuery->paginate(20);

        // Pour chaque utilisateur, charger ses emprunts actifs (non 'retourne') et archives ('retourne')
        foreach ($users as $user) {
            $activeQuery = $user->emprunts()->with('livre')->where('statut','<>','retourne');
            $activeQuery->orderByDesc('created_at');
            $active = $activeQuery->take(10)->get();
            $user->setRelation('emprunts_active', $active);

            $archiveQuery = $user->emprunts()->with('livre')->where('statut','retourne')->orderByDesc('created_at');
            $archives = $archiveQuery->take(50)->get();
            $user->setRelation('emprunts_archives', $archives);
        }

        return view('admin.emprunts', compact('users', 'livres', 'cataloguesEmprunt'));
    }

    /**
     * Mettre à jour le statut d'un emprunt (ex: marquer comme 'retourne')
     */
    public function updateStatus(Request $request, Emprunt $emprunt)
    {
        $request->validate([
            'statut' => 'required|string',
            'date_retour' => 'nullable|date',
        ]);

        $statut = $request->input('statut');
        $emprunt->statut = $statut;

        // Normaliser la date_retour : si fournie, stocker au format date (Y-m-d).
        // Si le statut devient 'retourne' et qu'aucune date n'est fournie, utiliser la date du jour.
        $dateRetourInput = $request->input('date_retour');
        if ($dateRetourInput) {
            try {
                $emprunt->date_retour = \Carbon\Carbon::parse($dateRetourInput)->toDateString();
            } catch (\Exception $e) {
                // en cas d'erreur de parsing, laisser la valeur précédente
            }
        } elseif ($statut === 'retourne' || strtolower($statut) === 'retourné' || strtolower($statut) === 'retourne') {
            $emprunt->date_retour = now()->toDateString();
        }

        $emprunt->save();
        return redirect()->back()->with('success', 'Statut de l\'emprunt mis à jour.');
    }

    /**
     * Actions groupées : mettre à jour le statut de tous les emprunts d'un utilisateur
     */
    public function bulkUpdateStatus(Request $request, User $user)
    {
        $request->validate(['statut' => 'required|string']);
        $statut = $request->input('statut');
        Emprunt::where('user_id', $user->id)->update(['statut' => $statut]);
        return redirect()->back()->with('success', 'Statuts des emprunts utilisateur mis à jour.');
    }

    public function addBooks(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'livre_id' => 'required|exists:catalogues,id',
            'date_emprunt' => 'required|date',
            'date_retour' => 'nullable|date',
            'statut' => 'required|string',
        ]);

        $user_id = $request->input('user_id');
        $livre_id = $request->input('livre_id');
        $date_emprunt = $request->input('date_emprunt');
        $date_retour = $request->input('date_retour');
        $statut = $request->input('statut');

        $livre = Catalogue::find($livre_id);
        if ($livre && $livre->quantite > 0) {
            Emprunt::create([
                'user_id' => $user_id,
                'livre_id' => $livre_id,
                'date_emprunt' => $date_emprunt,
                'date_retour' => $date_retour,
                'statut' => $statut,
            ]);
            // Décrémenter la quantité
            $livre->quantite--;
            $livre->type = 'emprunt';
            $livre->save();
            return redirect()->route('admin.emprunts.index')
                ->with('success', "Livre emprunté avec succès.");
        } else {
            return redirect()->route('admin.emprunts.index')
                ->with('error', "Ce livre n'est pas disponible.");
        }
    }

    public function edit($id)
    {
        // ...
    }

    public function update(Request $request, $id)
    {
        // ...
    }

    public function destroy($id)
    {
        $emprunt = \App\Models\Emprunt::findOrFail($id);
        $emprunt->delete();
        return redirect()->route('admin.emprunts.index')->with('success', 'Emprunt supprimé avec succès.');
    }

    public function create()
    {
        // ...
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'categorie' => 'required|string|max:255',
            'prix' => 'required|integer|min:0',
            'quantite' => 'required|integer|min:0',
            'resumer' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'pdf' => 'required|mimes:pdf|max:10000',
        ]);

        // Gestion image
        $imagePath = 'img/livres';
        if (!file_exists(public_path($imagePath))) {
            mkdir(public_path($imagePath), 0775, true);
        }
        $imageName = uniqid('img_') . '.' . $request->image->extension();
        $request->image->move(public_path($imagePath), $imageName);
        $imageUrl = $imagePath . '/' . $imageName;

        // Gestion PDF
        $pdfPath = 'pdf/emprunt';
        if (!file_exists(public_path($pdfPath))) {
            mkdir(public_path($pdfPath), 0775, true);
        }
        $pdfName = uniqid('pdf_') . '.' . $request->pdf->extension();
        $request->pdf->move(public_path($pdfPath), $pdfName);
        $pdfUrl = $pdfPath . '/' . $pdfName;

        $catalogue = Catalogue::create([
            'titre' => $request->titre,
            'auteur' => $request->auteur,
            'categorie' => $request->categorie,
            'prix' => $request->prix,
            'quantite' => $request->quantite,
            'type_categorie' => 'emprunt',
            'resumer' => $request->resumer,
            'image' => $imageUrl,
            'pdf' => $pdfUrl,
        ]);

        return redirect()->route('admin.emprunts.index')->with('success', 'Livre ajouté avec succès !');
    }
}
