<?php
namespace App\Http\Controllers\Admin;

use App\Models\Module;
use App\Models\Formation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::with('formation')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.modules.index', compact('modules'));
    }

    public function create()
    {
        $formations = Formation::all();
        return view('admin.modules.create', compact('formations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'formation_id' => 'nullable|exists:formations,id',
            'titre' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'duree' => 'nullable|string',
            'ordre' => 'nullable|integer',
            'active' => 'boolean',
        ]);

        $validated['active'] = $request->has('active') ? 1 : 0;

        Module::create($validated);
        return redirect()->route('admin.modules.index')->with('success', 'Module créé avec succès.');
    }

    public function show(Module $module)
    {
        return view('admin.modules.show', compact('module'));
    }

    public function edit(Module $module)
    {
        $formations = Formation::all();
        return view('admin.modules.edit', compact('module', 'formations'));
    }

    public function update(Request $request, Module $module)
    {
        $validated = $request->validate([
            'formation_id' => 'nullable|exists:formations,id',
            'titre' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'duree' => 'nullable|string',
            'ordre' => 'nullable|integer',
            'active' => 'boolean',
        ]);

        $validated['active'] = $request->has('active') ? 1 : 0;

        $module->update($validated);
        return redirect()->route('admin.modules.index')->with('success', 'Module modifié avec succès.');
    }

    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('admin.modules.index')->with('success', 'Module supprimé avec succès.');
    }
}
