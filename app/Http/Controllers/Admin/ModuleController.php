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
        $modules = Module::with('formation')->get();
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
            'formation_id' => 'required|exists:formations,id',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ordre' => 'required|integer',
        ]);
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
            'formation_id' => 'required|exists:formations,id',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ordre' => 'required|integer',
        ]);
        $module->update($validated);
        return redirect()->route('admin.modules.index')->with('success', 'Module modifié avec succès.');
    }

    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('admin.modules.index')->with('success', 'Module supprimé avec succès.');
    }
}
