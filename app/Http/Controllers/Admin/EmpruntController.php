<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Emprunt;
use App\Models\User;
use App\Models\Catalogue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmpruntController extends Controller
{
    /**
     * Affiche la page admin des emprunts
     */
    public function index()
    {
        // Récupérer les demandes en attente de validation
        $demandesEnAttente = Emprunt::with(['user', 'livre'])
            ->where('statut', 'en_attente')
            ->orderByDesc('created_at')
            ->get();

        // Récupérer tous les emprunts (hors attente)
        $emprunts = Emprunt::with(['user', 'livre'])
            ->where('statut', '!=', 'en_attente')
            ->orderByDesc('created_at')
            ->paginate(15);

        // Récupérer tous les utilisateurs pour le formulaire
        $users = User::orderBy('name')->get();

        // Récupérer tous les livres empruntables
        $livresEmpruntables = Catalogue::where('type_categorie', 'emprunt')
            ->orderBy('titre')
            ->get();

        // Récupérer tous les livres pour le formulaire d'ajout de livre empruntable
        $allCatalogues = Catalogue::all();

        return view('admin.emprunts', compact('demandesEnAttente', 'emprunts', 'users', 'livresEmpruntables', 'allCatalogues'));
    }

    /**
     * Afficher le formulaire de création (optionnel, car on utilise un modal)
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $livresEmpruntables = Catalogue::where('type_categorie', 'emprunt')->get();
        return view('admin.emprunts.create', compact('users', 'livresEmpruntables'));
    }

    /**
     * Stocker un nouveau livre empruntable dans le catalogue
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'categorie' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'quantite' => 'required|integer|min:0',
            'resumer' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'pdf' => 'nullable|mimes:pdf|max:10000',
        ]);

        // Gestion de l'image
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $imagePath = 'img/livres';
            if (!file_exists(public_path($imagePath))) {
                mkdir(public_path($imagePath), 0775, true);
            }
            $imageName = uniqid('img_') . '.' . $request->image->extension();
            $request->image->move(public_path($imagePath), $imageName);
            $imageUrl = $imagePath . '/' . $imageName;
        }

        // Gestion du PDF
        $pdfUrl = null;
        if ($request->hasFile('pdf')) {
            $pdfPath = 'pdf/emprunt';
            if (!file_exists(public_path($pdfPath))) {
                mkdir(public_path($pdfPath), 0775, true);
            }
            $pdfName = uniqid('pdf_') . '.' . $request->pdf->extension();
            $request->pdf->move(public_path($pdfPath), $pdfName);
            $pdfUrl = $pdfPath . '/' . $pdfName;
        }

        Catalogue::create([
            'titre' => $validated['titre'],
            'auteur' => $validated['auteur'],
            'categorie' => $validated['categorie'],
            'prix' => $validated['prix'],
            'quantite' => $validated['quantite'],
            'type_categorie' => 'emprunt',
            'type' => 'emprunt',
            'resumer' => $validated['resumer'] ?? '',
            'image' => $imageUrl,
            'pdf' => $pdfUrl,
        ]);

        return redirect()->route('admin.emprunts.index')
            ->with('success', 'Livre empruntable ajouté avec succès !');
    }

    /**
     * Afficher un emprunt spécifique
     */
    public function show(Emprunt $emprunt)
    {
        $emprunt->load(['user', 'livre']);
        return view('admin.emprunts.show', compact('emprunt'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Emprunt $emprunt)
    {
        $users = User::orderBy('name')->get();
        $livresEmpruntables = Catalogue::where('type_categorie', 'emprunt')->get();
        return view('admin.emprunts.edit', compact('emprunt', 'users', 'livresEmpruntables'));
    }

    /**
     * Mettre à jour un emprunt
     */
    public function update(Request $request, Emprunt $emprunt)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'livre_id' => 'required|exists:catalogues,id',
            'date_emprunt' => 'required|date',
            'date_retour' => 'nullable|date|after_or_equal:date_emprunt',
            'statut' => 'required|in:en_cours,retourne,en_retard',
        ]);

        $emprunt->update($validated);

        return redirect()->route('admin.emprunts.index')
            ->with('success', 'Emprunt mis à jour avec succès !');
    }

    /**
     * Mettre à jour un livre empruntable (Catalogue)
     */
    public function updateLivre(Request $request, $id)
    {
        $livre = Catalogue::findOrFail($id);

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'categorie' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'quantite' => 'required|integer|min:0',
            'resumer' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'pdf' => 'nullable|mimes:pdf|max:10000',
        ]);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($livre->image && file_exists(public_path($livre->image))) {
                unlink(public_path($livre->image));
            }

            $imagePath = 'img/livres';
            if (!file_exists(public_path($imagePath))) {
                mkdir(public_path($imagePath), 0775, true);
            }
            $imageName = uniqid('img_') . '.' . $request->image->extension();
            $request->image->move(public_path($imagePath), $imageName);
            $validated['image'] = $imagePath . '/' . $imageName;
        }

        // Gestion du PDF
        if ($request->hasFile('pdf')) {
            // Supprimer l'ancien PDF si il existe
            if ($livre->pdf && file_exists(public_path($livre->pdf))) {
                unlink(public_path($livre->pdf));
            }

            $pdfPath = 'pdf/emprunt';
            if (!file_exists(public_path($pdfPath))) {
                mkdir(public_path($pdfPath), 0775, true);
            }
            $pdfName = uniqid('pdf_') . '.' . $request->pdf->extension();
            $request->pdf->move(public_path($pdfPath), $pdfName);
            $validated['pdf'] = $pdfPath . '/' . $pdfName;
        }

        $livre->update($validated);

        return redirect()->route('admin.emprunts.index')
            ->with('success', 'Livre empruntable mis à jour avec succès !');
    }

    /**
     * Supprimer un emprunt (relation user-livre)
     */
    public function destroy(Emprunt $emprunt)
    {
        // Incrémenter le stock du livre si l'emprunt n'était pas déjà retourné
        if ($emprunt->statut !== 'retourne' && $emprunt->livre) {
            $emprunt->livre->increment('quantite');
        }

        $emprunt->delete();

        return redirect()->route('admin.emprunts.index')
            ->with('success', 'Emprunt supprimé avec succès !');
    }

    /**
     * Supprimer un livre empruntable du catalogue
     */
    public function destroyLivre($id)
    {
        $livre = Catalogue::findOrFail($id);

        // Vérifier qu'il n'y a pas d'emprunts en cours pour ce livre
        $empruntsEnCours = Emprunt::where('livre_id', $livre->id)
            ->whereIn('statut', ['en_cours', 'en_retard'])
            ->count();

        if ($empruntsEnCours > 0) {
            return redirect()->route('admin.emprunts.index')
                ->with('error', "Impossible de supprimer ce livre car il y a {$empruntsEnCours} emprunt(s) en cours.");
        }

        // Supprimer les fichiers associés
        if ($livre->image && file_exists(public_path($livre->image))) {
            unlink(public_path($livre->image));
        }
        if ($livre->pdf && file_exists(public_path($livre->pdf))) {
            unlink(public_path($livre->pdf));
        }

        $livre->delete();

        return redirect()->route('admin.emprunts.index')
            ->with('success', 'Livre empruntable supprimé avec succès !');
    }

    /**
     * Ajouter un nouvel emprunt (créer une relation emprunt entre un user et un livre)
     */
    public function addBooks(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'livre_id' => 'required|exists:catalogues,id',
            'date_emprunt' => 'required|date',
            'date_retour' => 'nullable|date|after_or_equal:date_emprunt',
            'statut' => 'required|in:en_cours,retourne,en_retard',
        ]);

        $livre = Catalogue::findOrFail($validated['livre_id']);

        // Vérifier la disponibilité
        if ($livre->quantite <= 0) {
            return redirect()->route('admin.emprunts.index')
                ->with('error', "Le livre '{$livre->titre}' n'est plus disponible à l'emprunt.");
        }

        // Créer l'emprunt
        Emprunt::create([
            'user_id' => $validated['user_id'],
            'livre_id' => $validated['livre_id'],
            'date_emprunt' => $validated['date_emprunt'],
            'date_retour' => $validated['date_retour'],
            'statut' => $validated['statut'],
        ]);

        // Décrémenter la quantité du livre
        $livre->decrement('quantite');

        return redirect()->route('admin.emprunts.index')
            ->with('success', "Emprunt créé avec succès pour '{$livre->titre}'.");
    }

    /**
     * Mettre à jour le statut d'un emprunt unique
     */
    public function updateStatus(Request $request, Emprunt $emprunt)
    {
        $validated = $request->validate([
            'statut' => 'required|in:en_cours,retourne,en_retard',
            'date_retour' => 'nullable|date',
        ]);

        $oldStatut = $emprunt->statut;
        $newStatut = $validated['statut'];

        $emprunt->statut = $newStatut;

        // Si le livre est retourné, mettre la date de retour et incrémenter le stock
        if ($newStatut === 'retourne') {
            $emprunt->date_retour = $validated['date_retour'] ?? now()->toDateString();

            // Incrémenter le stock du livre si le statut passe de en_cours à retourné
            if ($oldStatut !== 'retourne' && $emprunt->livre) {
                $emprunt->livre->increment('quantite');
            }
        }

        $emprunt->save();

        return redirect()->back()->with('success', 'Statut de l\'emprunt mis à jour avec succès.');
    }

    /**
     * Mettre à jour en masse les statuts des emprunts d'un utilisateur
     */
    public function bulkUpdateStatus(Request $request, User $user)
    {
        $validated = $request->validate([
            'statut' => 'required|in:en_cours,retourne,en_retard',
        ]);

        $statut = $validated['statut'];

        // Récupérer tous les emprunts de l'utilisateur qui ne sont pas déjà au statut demandé
        $emprunts = $user->emprunts()->where('statut', '!=', $statut)->get();

        foreach ($emprunts as $emprunt) {
            $oldStatut = $emprunt->statut;
            $emprunt->statut = $statut;

            if ($statut === 'retourne' && !$emprunt->date_retour) {
                $emprunt->date_retour = now()->toDateString();

                // Incrémenter le stock si passage de en_cours à retourné
                if ($oldStatut !== 'retourne' && $emprunt->livre) {
                    $emprunt->livre->increment('quantite');
                }
            }

            $emprunt->save();
        }

        return redirect()->back()->with('success', "Statuts des emprunts de {$user->name} mis à jour avec succès.");
    }

    /**
     * Valider une demande d'emprunt
     */
    public function validerDemande(Emprunt $emprunt)
    {
        if ($emprunt->statut !== 'en_attente') {
            return redirect()->back()->with('error', 'Cette demande a déjà été traitée.');
        }

        // Vérifier la disponibilité du livre
        if ($emprunt->livre->quantite <= 0) {
            return redirect()->back()->with('error', 'Le livre n\'est plus disponible en stock.');
        }

        // Valider la demande avec accès de 6 heures
        $emprunt->update([
            'statut' => 'en_cours',
            'valide_par' => auth()->id(),
            'valide_le' => now(),
            'access_expires_at' => now()->addHours(6),
        ]);

        // Décrémenter le stock
        $emprunt->livre->decrement('quantite');

        return redirect()->back()->with('success', "La demande d'emprunt de {$emprunt->user->name} pour \"{$emprunt->livre->titre}\" a été validée.");
    }

    /**
     * Rejeter une demande d'emprunt
     */
    public function rejeterDemande(Emprunt $emprunt)
    {
        if ($emprunt->statut !== 'en_attente') {
            return redirect()->back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $userName = $emprunt->user->name;
        $livreTitre = $emprunt->livre->titre;

        // Supprimer la demande
        $emprunt->delete();

        return redirect()->back()->with('info', "La demande d'emprunt de {$userName} pour \"{$livreTitre}\" a été rejetée.");
    }

    /**
     * Prolonger l'accès PDF de 6 heures
     */
    public function renewAccess(Emprunt $emprunt)
    {
        // Prolonger l'accès de 6 heures
        $emprunt->update([
            'access_expires_at' => now()->addHours(6),
        ]);

        return redirect()->back()->with('success', "L'accès PDF pour \"{$emprunt->livre->titre}\" a été prolongé de 6 heures pour {$emprunt->user->name}.");
    }
}
