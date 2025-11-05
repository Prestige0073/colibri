<?php
namespace App\Http\Controllers\Admin;

use App\Models\Suivi;
use App\Models\User;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuiviController extends Controller
{
    public function index()
    {
        $suivis = Suivi::with(['user', 'module'])->get();
        return view('admin.suivis.index', compact('suivis'));
    }

    public function create()
    {
        $users = User::all();
        $modules = Module::all();
        return view('admin.suivis.create', compact('users', 'modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'module_id' => 'required|exists:modules,id',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date',
            'statut' => 'required|string',
            'score' => 'nullable|integer',
        ]);
        Suivi::create($validated);
        return redirect()->route('admin.suivis.index')->with('success', 'Suivi créé avec succès.');
    }

    public function show(Suivi $suivi)
    {
        return view('admin.suivis.show', compact('suivi'));
    }

    public function edit(Suivi $suivi)
    {
        $users = User::all();
        $modules = Module::all();
        return view('admin.suivis.edit', compact('suivi', 'users', 'modules'));
    }

    public function update(Request $request, Suivi $suivi)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'module_id' => 'required|exists:modules,id',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date',
            'statut' => 'required|string',
            'score' => 'nullable|integer',
        ]);
        $suivi->update($validated);
        return redirect()->route('admin.suivis.index')->with('success', 'Suivi modifié avec succès.');
    }

    public function destroy(Suivi $suivi)
    {
        $suivi->delete();
        return redirect()->route('admin.suivis.index')->with('success', 'Suivi supprimé avec succès.');
    }
}
