<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModuleAdminController extends Controller
{
    public function index() {
        $formations = \App\Models\Formation::all();
        $modules = \App\Models\Module::with('formation')->orderBy('ordre')->get();
        return view('admin.modules', compact('formations', 'modules'));
    }

    public function create() {
        // non utilisé, la création se fait via modal dans la page index
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'formation_id' => 'required|exists:formations,id',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ordre' => 'required|integer',
            'image' => 'nullable|image|max:4096',
            'video' => 'nullable|file|mimetypes:video/mp4,video/ogg,video/webm|max:200000',
            'video_url' => 'nullable|url',
        ]);
        // handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid('module_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('modules'), $filename);
            $validated['image'] = 'modules/' . $filename;
        }
        // handle video upload (file) OR video_url
        if ($request->hasFile('video')) {
            $vfile = $request->file('video');
            $vname = uniqid('module_vid_') . '.' . $vfile->getClientOriginalExtension();
            $vfile->move(public_path('modules/videos'), $vname);
            $validated['video_path'] = 'modules/videos/' . $vname;
        } elseif (!empty($validated['video_url'])) {
            $validated['video_path'] = null;
        }

        \App\Models\Module::create($validated);
        return redirect()->route('admin.modules.index')->with('success', 'Module créé avec succès.');
    }

    public function show($id) { }
    public function edit($id) { }
    public function update(Request $request, $id) { }
    public function destroy($id) {
        $module = \App\Models\Module::findOrFail($id);
        // supprimer fichiers associés si présents
        if ($module->image && file_exists(public_path($module->image))) {
            @unlink(public_path($module->image));
        }
        if ($module->video_path && file_exists(public_path($module->video_path))) {
            @unlink(public_path($module->video_path));
        }
        $module->delete();
        return redirect()->route('admin.modules.index')->with('success', 'Module supprimé avec succès.');
    }
}
