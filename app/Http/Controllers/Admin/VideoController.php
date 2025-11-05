<?php
namespace App\Http\Controllers\Admin;

use App\Models\Video;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::with('module')->get();
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        $modules = Module::all();
        return view('admin.videos.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|string',
            'ordre' => 'required|integer',
        ]);
        Video::create($validated);
        return redirect()->route('admin.videos.index')->with('success', 'Vidéo créée avec succès.');
    }

    public function show(Video $video)
    {
        return view('admin.videos.show', compact('video'));
    }

    public function edit(Video $video)
    {
        $modules = Module::all();
        return view('admin.videos.edit', compact('video', 'modules'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|string',
            'ordre' => 'required|integer',
        ]);
        $video->update($validated);
        return redirect()->route('admin.videos.index')->with('success', 'Vidéo modifiée avec succès.');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Vidéo supprimée avec succès.');
    }
}
