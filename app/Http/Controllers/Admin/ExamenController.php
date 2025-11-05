<?php
namespace App\Http\Controllers\Admin;

use App\Models\Examen;
use App\Models\Formation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamenController extends Controller
{
    public function index()
    {
        $examens = Examen::with('formation')->get();
        return view('admin.examens.index', compact('examens'));
    }

    public function create()
    {
        $formations = Formation::all();
        return view('admin.examens.create', compact('formations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'formation_id' => 'required|exists:formations,id',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
        ]);
        Examen::create($validated);
        return redirect()->route('admin.examens.index')->with('success', 'Examen créé avec succès.');
    }

    public function show(Examen $examen)
    {
        return view('admin.examens.show', compact('examen'));
    }

    public function edit(Examen $examen)
    {
        $formations = Formation::all();
        return view('admin.examens.edit', compact('examen', 'formations'));
    }

    public function update(Request $request, Examen $examen)
    {
        $validated = $request->validate([
            'formation_id' => 'required|exists:formations,id',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
        ]);
        $examen->update($validated);
        return redirect()->route('admin.examens.index')->with('success', 'Examen modifié avec succès.');
    }

    public function destroy(Examen $examen)
    {
        $examen->delete();
        return redirect()->route('admin.examens.index')->with('success', 'Examen supprimé avec succès.');
    }
}
