<?php
namespace App\Http\Controllers\Admin;

use App\Models\FormationInscription;
use App\Models\User;
use App\Models\Formation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AchatController extends Controller
{
    public function index()
    {
        $achats = FormationInscription::with(['user', 'formation'])->get();
        return view('admin.achats.index', compact('achats'));
    }

    public function create()
    {
        $users = User::all();
        $formations = Formation::all();
        return view('admin.achats.create', compact('users', 'formations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'formation_id' => 'required|exists:formations,id',
            'date_inscription' => 'required|date',
            'montant_paye' => 'required|numeric',
            'statut' => 'required|string',
        ]);

        $validated['progression'] = 0;
        $validated['paiement_valide'] = false;

        FormationInscription::create($validated);
        return redirect()->route('admin.achats.index')->with('success', 'Inscription créée avec succès.');
    }

    public function show(FormationInscription $achat)
    {
        return view('admin.achats.show', compact('achat'));
    }

    public function edit(FormationInscription $achat)
    {
        $users = User::all();
        $formations = Formation::all();
        return view('admin.achats.edit', compact('achat', 'users', 'formations'));
    }

    public function update(Request $request, FormationInscription $achat)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'formation_id' => 'required|exists:formations,id',
            'date_inscription' => 'required|date',
            'montant_paye' => 'required|numeric',
            'statut' => 'required|string',
        ]);
        $achat->update($validated);
        return redirect()->route('admin.achats.index')->with('success', 'Inscription modifiée avec succès.');
    }

    public function destroy(FormationInscription $achat)
    {
        $achat->delete();
        return redirect()->route('admin.achats.index')->with('success', 'Inscription supprimée avec succès.');
    }
}
