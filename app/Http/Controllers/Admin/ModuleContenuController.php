<?php
namespace App\Http\Controllers\Admin;

use App\Models\Module;
use App\Models\ModuleContenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModuleContenuController extends Controller
{
    public function create(Module $module)
    {
        return view('admin.contenus.create', compact('module'));
    }

    public function store(Request $request, Module $module)
    {
        $validated = $request->validate([
            'type' => 'required|in:video,pdf,audio,image,texte',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'fichier' => 'nullable|file|max:51200',
            'contenu' => 'nullable|string',
            'duree' => 'nullable|string',
            'ordre' => 'required|integer',
        ]);

        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $type = $validated['type'];
            $filename = uniqid('contenu_').'.'.$file->getClientOriginalExtension();

            $directory = match($type) {
                'video' => 'videos/modules',
                'pdf' => 'pdf/modules',
                'audio' => 'audio/modules',
                'image' => 'img/modules',
                default => 'files/modules'
            };

            $file->move(public_path($directory), $filename);
            $validated['fichier'] = $directory.'/'.$filename;
        }

        $validated['module_id'] = $module->id;
        ModuleContenu::create($validated);

        return redirect()->route('admin.modules.show', $module)->with('success', 'Contenu créé avec succès.');
    }

    public function edit(ModuleContenu $contenu)
    {
        return view('admin.contenus.edit', compact('contenu'));
    }

    public function update(Request $request, ModuleContenu $contenu)
    {
        $validated = $request->validate([
            'type' => 'required|in:video,pdf,audio,image,texte',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'fichier' => 'nullable|file|max:51200',
            'contenu' => 'nullable|string',
            'duree' => 'nullable|string',
            'ordre' => 'required|integer',
        ]);

        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $type = $validated['type'];
            $filename = uniqid('contenu_').'.'.$file->getClientOriginalExtension();

            $directory = match($type) {
                'video' => 'videos/modules',
                'pdf' => 'pdf/modules',
                'audio' => 'audio/modules',
                'image' => 'img/modules',
                default => 'files/modules'
            };

            $file->move(public_path($directory), $filename);
            $validated['fichier'] = $directory.'/'.$filename;
        }

        $contenu->update($validated);

        return redirect()->route('admin.modules.show', $contenu->module)->with('success', 'Contenu modifié avec succès.');
    }

    public function destroy(ModuleContenu $contenu)
    {
        $module = $contenu->module;
        $contenu->delete();

        return redirect()->route('admin.modules.show', $module)->with('success', 'Contenu supprimé avec succès.');
    }
}
