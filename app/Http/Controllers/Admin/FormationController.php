<?php
namespace App\Http\Controllers\Admin;

use App\Models\Formation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormationController extends Controller
{
    public function index()
    {
        $formations = \App\Models\Formation::all();
        return view('admin.formations', compact('formations'));
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric',
            'duree' => 'required|string',
            'niveau' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid('formation_').'.'.$file->getClientOriginalExtension();
            $file->move(public_path('formations'), $filename);
            $validated['image'] = 'formations/'.$filename;
        }
        Formation::create($validated);
        return redirect()->route('admin.formations.index')->with('success', 'Formation créée avec succès.');
    }

    public function show(Formation $formation)
    {
        
    }

    public function edit(Formation $formation)
    {
        
    }

    public function update(Request $request, Formation $formation)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric',
            'duree' => 'required|string',
            'niveau' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid('formation_').'.'.$file->getClientOriginalExtension();
            $file->move(public_path('formations'), $filename);
            $validated['image'] = 'formations/'.$filename;
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
