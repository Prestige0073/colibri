<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;
use App\Models\Module as ModuleModel;

class FormationController extends Controller
{
    public function modules() {
        // Récupère les formations paginées avec le nombre de modules associés
        $formations = Formation::withCount('modules')->orderBy('created_at', 'desc')->paginate(9);
        return view('formation.modules', compact('formations'));
    }

    /**
     * Affiche la page de détail d'une formation avec tous ses modules
     */
    public function show(Formation $formation)
    {
        $formation->load('modules');
        return view('formation.show', compact('formation'));
    }

    /**
     * Permet à un utilisateur connecté d'acheter une formation (création d'un Achat)
     */
    public function acheter(Request $request, Formation $formation)
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour acheter une formation.');
        }

        $user = \Illuminate\Support\Facades\Auth::user();

        $achat = \App\Models\Achat::create([
            'user_id' => $user->id,
            'formation_id' => $formation->id,
            'date_achat' => now(),
            'montant' => $formation->prix ?? 0,
            'statut' => 'pending',
        ]);

        // Ici on pourrait rediriger vers une page de paiement
        return redirect()->route('formation.show', $formation)->with('success', 'Formation ajoutée aux achats. Continuez vers le paiement.');
    }

    /**
     * Affiche un module (vidéo + ressources) appartenant à une formation
     */
    public function moduleShow(Formation $formation, ModuleModel $module)
    {
        // Vérifie que le module appartient bien à la formation
        if ($module->formation_id !== $formation->id) {
            abort(404);
        }
        return view('formation.module', ['module' => $module, 'formation' => $formation]);
    }

    public function quiz() {
        return view('formation.quiz');
    }

    public function certification() {
        return view('formation.certification');
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
     * (Méthode show publique gérée plus haut)
     */

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
