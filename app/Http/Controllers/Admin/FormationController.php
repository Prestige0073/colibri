<?php
namespace App\Http\Controllers\Admin;

use App\Models\Formation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::withCount(['modules', 'inscriptions'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.formations.index', compact('formations'));
    }

    public function create()
    {
        return view('admin.formations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'objectifs' => 'nullable|string',
            'prix' => 'nullable|numeric|min:0',
            'est_gratuit' => 'nullable|in:0,1',
            'duree' => 'nullable|string',
            'niveau' => 'nullable|string',
            'categorie' => 'nullable|string',
            'prerequis' => 'nullable|string',
            'note_minimale_certification' => 'nullable|integer|min:0|max:100',
            'image' => 'nullable|image',
            'active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid('formation_').'.'.$file->getClientOriginalExtension();
            $file->move(public_path('img/formations'), $filename);
            $validated['image'] = 'img/formations/'.$filename;
        }

        // Gérer le champ active (checkbox)
        $validated['active'] = $request->has('active') ? 1 : 0;

        // Gérer formation gratuite
        $validated['est_gratuit'] = $request->input('est_gratuit') == '1';
        if ($validated['est_gratuit']) {
            $validated['prix'] = 0;
        }

        Formation::create($validated);
        return redirect()->route('admin.formations.index')->with('success', 'Formation créée avec succès.');
    }

    public function show(Formation $formation)
    {
        $formation->load(['modules.contenus', 'inscriptions.user']);
        return view('admin.formations.show', compact('formation'));
    }

    public function edit(Formation $formation)
    {
        return view('admin.formations.edit', compact('formation'));
    }

    public function update(Request $request, Formation $formation)
    {
        $validated = $request->validate([
            'titre' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'objectifs' => 'nullable|string',
            'prix' => 'nullable|numeric|min:0',
            'est_gratuit' => 'nullable|in:0,1',
            'duree' => 'nullable|string',
            'niveau' => 'nullable|string',
            'categorie' => 'nullable|string',
            'prerequis' => 'nullable|string',
            'note_minimale_certification' => 'nullable|integer|min:0|max:100',
            'image' => 'nullable|image',
            'active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid('formation_').'.'.$file->getClientOriginalExtension();
            $file->move(public_path('img/formations'), $filename);
            $validated['image'] = 'img/formations/'.$filename;
        }

        // Gérer le champ active (checkbox)
        $validated['active'] = $request->has('active') ? 1 : 0;

        // Gérer formation gratuite
        $validated['est_gratuit'] = $request->input('est_gratuit') == '1';
        if ($validated['est_gratuit']) {
            $validated['prix'] = 0;
        }

        $formation->update($validated);
        return redirect()->route('admin.formations.index')->with('success', 'Formation modifiée avec succès.');
    }

    public function destroy(Formation $formation)
    {
        $formation->delete();
    return redirect()->route('admin.formations.index')->with('success', 'Formation supprimée avec succès.');
    }
}
