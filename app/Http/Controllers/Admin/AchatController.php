<?php
namespace App\Http\Controllers\Admin;

use App\Models\Achat;
use App\Models\User;
use App\Models\Formation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AchatController extends Controller
{
    public function index()
    {
        $achats = Achat::with(['user', 'formation'])->get();
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
            'date_achat' => 'required|date',
            'montant' => 'required|numeric',
            'statut' => 'required|string',
        ]);
        Achat::create($validated);
        return redirect()->route('admin.achats.index')->with('success', 'Achat créé avec succès.');
    }

    public function show(Achat $achat)
    {
        return view('admin.achats.show', compact('achat'));
    }

    public function edit(Achat $achat)
    {
        $users = User::all();
        $formations = Formation::all();
        return view('admin.achats.edit', compact('achat', 'users', 'formations'));
    }

    public function update(Request $request, Achat $achat)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'formation_id' => 'required|exists:formations,id',
            'date_achat' => 'required|date',
            'montant' => 'required|numeric',
            'statut' => 'required|string',
        ]);
        $achat->update($validated);
        return redirect()->route('admin.achats.index')->with('success', 'Achat modifié avec succès.');
    }

    public function destroy(Achat $achat)
    {
        $achat->delete();
        return redirect()->route('admin.achats.index')->with('success', 'Achat supprimé avec succès.');
    }
}
