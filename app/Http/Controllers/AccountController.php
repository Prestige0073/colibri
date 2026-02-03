<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprunt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function profil() {
        $user = Auth::user();
        if ($user) {
            $emprunts = Emprunt::where('user_id', $user->id)->with('livre')->orderByDesc('created_at')->get();
            // Récupérer commandes en cours de livraison
            // Vérifier si la table commandes existe
            if (\Schema::hasTable('commandes') && class_exists(\App\Models\Commande::class)) {
                $commandesEnLivraison = \App\Models\Commande::where('user_id', $user->id)
                    ->whereIn('statut', ['en_preparation', 'expedie', 'en_cours', 'pending', 'en_livraison'])
                    ->with('items')
                    ->orderByDesc('created_at')
                    ->get();
            } else {
                $commandesEnLivraison = collect();
            }
            // Récupérer les livres achetés (bibliothèque)
            $livresAchetes = $user->purchasedBooks()->take(6)->get();
        } else {
            $emprunts = collect();
            $commandesEnLivraison = collect();
            $livresAchetes = collect();
        }
        return view('account.profil', compact('emprunts', 'commandesEnLivraison', 'livresAchetes'));
    }

    /**
     * Update user's avatar
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120', // max 5MB
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('account.profil')->with('error', 'Utilisateur non authentifié.');
        }

        $file = $request->file('avatar');
        $ext = $file->getClientOriginalExtension();
        $basename = Str::random(40) . '.' . $ext;
        $publicDir = public_path('avatars');

        if (!file_exists($publicDir)) {
            mkdir($publicDir, 0755, true);
        }

        // remove old avatar if present in public/avatars
        if ($user->avatar) {
            // possible stored path like 'avatars/xxx.jpg' or full URL
            $old = $user->avatar;
            // normalize
            if (Str::startsWith($old, url('/'))) {
                // strip domain
                $old = str_replace(url('/'), '', $old);
                $old = ltrim($old, '/');
            }
            if (Str::startsWith($old, 'storage/')) {
                $old = substr($old, strlen('storage/'));
            }
            $oldPath = public_path($old);
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        // move uploaded file into public/avatars
        $targetPath = $publicDir . DIRECTORY_SEPARATOR . $basename;
        $file->move($publicDir, $basename);

        // Save user avatar path as public path accessible via asset('/avatars/...')
        $user->avatar = 'avatars/' . $basename;
        $user->save();

        return redirect()->route('account.profil')->with('success', 'Avatar mis à jour avec succès.');
    }

    /**
     * Update user's profile information
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('account.profil')->with('error', 'Utilisateur non authentifié.');
        }

        // Validation des champs de base
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ];

        // Si l'utilisateur veut changer son mot de passe
        if ($request->filled('current_password')) {
            $rules['current_password'] = 'required';
            $rules['new_password'] = 'required|min:8|confirmed';
        }

        $request->validate($rules);

        // Vérifier le mot de passe actuel si fourni
        if ($request->filled('current_password')) {
            if (!\Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.'])->withInput();
            }

            // Mettre à jour le mot de passe
            $user->password = \Hash::make($request->new_password);
        }

        // Mettre à jour les autres informations
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        $message = $request->filled('current_password')
            ? 'Profil et mot de passe mis à jour avec succès.'
            : 'Profil mis à jour avec succès.';

        return redirect()->route('account.profil')->with('success', $message);
    }

    public function historique() {
        return view('account.historique');
    }

    public function certifications() {
        return view('account.certifications');
    }

    /**
     * Affiche la bibliothèque personnelle avec tous les livres achetés
     */
    public function bibliotheque()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à votre bibliothèque.');
        }

        $livresAchetes = $user->purchasedBooks()->get();

        return view('account.bibliotheque', compact('livresAchetes'));
    }

    /**
     * Affiche les formations de l'utilisateur (inscrit)
     */
    public function formations()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à vos formations.');
        }

        // Récupérer toutes les inscriptions de l'utilisateur avec les formations et leurs modules
        $inscriptions = \App\Models\FormationInscription::where('user_id', $user->id)
            ->with(['formation.modules.contenus', 'formation.quizzes'])
            ->orderByDesc('created_at')
            ->get();

        // Calculer la progression pour chaque inscription
        foreach ($inscriptions as $inscription) {
            $formation = $inscription->formation;
            if ($formation) {
                $totalContenus = 0;
                $completedContenus = 0;

                foreach ($formation->modules as $module) {
                    $totalContenus += $module->contenus->count();

                    // Compter les contenus complétés
                    $completedContenus += \App\Models\UserModuleProgression::where('user_id', $user->id)
                        ->where('module_id', $module->id)
                        ->where('completed', true)
                        ->count();
                }

                $inscription->calculated_progression = $totalContenus > 0
                    ? round(($completedContenus / $totalContenus) * 100)
                    : 0;
                $inscription->total_contenus = $totalContenus;
                $inscription->completed_contenus = $completedContenus;
            }
        }

        return view('account.formations', compact('inscriptions'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
