<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Catalogue;
use Illuminate\Support\Facades\Storage;

class CatalogueAdminController extends Controller
{
    public function index()
    {
        $catalogues = Catalogue::where('type_categorie', 'catalogue')->latest()->paginate(15);
        $cataloguesEmprunt = Catalogue::where('type_categorie', 'emprunt')->latest()->paginate(15);

        return view('admin.catalogue', compact('catalogues', 'cataloguesEmprunt'));
    }
    public function create() {}
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'nullable|string|max:255',
            'auteur' => 'nullable|string|max:255',
            'categorie' => 'nullable|string|max:255',
            'prix' => 'nullable|integer|min:0',
            'quantite' => 'nullable|integer|min:0',
            'resumer' => 'nullable|string',
            'image' => 'nullable|image',
            'pdf' => 'nullable|mimes:pdf',
            'audio' => 'nullable|mimes:mp3,wav,ogg,m4a',
            'type_contenu' => 'nullable|in:pdf,audio',
        ]);

        // Gestion image (tous formats acceptés)
        if ($request->hasFile('image')) {
            $imagePath = 'img/livres';
            if (!file_exists(public_path($imagePath))) {
                mkdir(public_path($imagePath), 0775, true);
            }
            $imageName = uniqid('img_') . '.' . $request->image->extension();
            $request->image->move(public_path($imagePath), $imageName);
            $validated['image'] = $imagePath . '/' . $imageName;
        }

        // Gestion PDF
        if ($request->hasFile('pdf')) {
            $pdfPath = 'pdf/catalogue';
            if (!file_exists(public_path($pdfPath))) {
                mkdir(public_path($pdfPath), 0775, true);
            }
            $pdfName = uniqid('pdf_') . '.' . $request->pdf->extension();
            $request->pdf->move(public_path($pdfPath), $pdfName);
            $validated['pdf'] = $pdfPath . '/' . $pdfName;
        }

        // Gestion Audio
        if ($request->hasFile('audio')) {
            $audioPath = 'audio/catalogue';
            if (!file_exists(public_path($audioPath))) {
                mkdir(public_path($audioPath), 0775, true);
            }
            $audioName = uniqid('audio_') . '.' . $request->audio->extension();
            $request->audio->move(public_path($audioPath), $audioName);
            $validated['audio'] = $audioPath . '/' . $audioName;
        }

        $validated['type_categorie'] = 'catalogue';

        Catalogue::create($validated);

        return redirect()->route('admin.catalogue.index')->with('success', 'Livre ajouté avec succès !');
    }
    public function show($id) {}
    public function edit($id) {}
    public function update(Request $request, $id)
    {
        $catalogue = Catalogue::findOrFail($id);

        $validated = $request->validate([
            'titre' => 'nullable|string|max:255',
            'auteur' => 'nullable|string|max:255',
            'categorie' => 'nullable|string|max:255',
            'prix' => 'nullable|integer|min:0',
            'quantite' => 'nullable|integer|min:0',
            'resumer' => 'nullable|string',
            'image' => 'nullable|image',
            'pdf' => 'nullable|mimes:pdf',
            'audio' => 'nullable|mimes:mp3,wav,ogg,m4a',
            'type_contenu' => 'nullable|in:pdf,audio',
        ]);

        // Gestion image (tous formats acceptés)
        if ($request->hasFile('image')) {
            $imagePath = 'img/livres';
            if (!file_exists(public_path($imagePath))) {
                mkdir(public_path($imagePath), 0775, true);
            }
            // Supprime l'ancienne image
            if ($catalogue->image && file_exists(public_path($catalogue->image))) {
                @unlink(public_path($catalogue->image));
            }
            $imageName = uniqid('img_') . '.' . $request->image->extension();
            $request->image->move(public_path($imagePath), $imageName);
            $validated['image'] = $imagePath . '/' . $imageName;
        }

        // Gestion PDF
        if ($request->hasFile('pdf')) {
            $pdfPath = 'pdf/catalogue';
            if (!file_exists(public_path($pdfPath))) {
                mkdir(public_path($pdfPath), 0775, true);
            }
            // Supprime l'ancien PDF
            if ($catalogue->pdf && file_exists(public_path($catalogue->pdf))) {
                @unlink(public_path($catalogue->pdf));
            }
            $pdfName = uniqid('pdf_') . '.' . $request->pdf->extension();
            $request->pdf->move(public_path($pdfPath), $pdfName);
            $validated['pdf'] = $pdfPath . '/' . $pdfName;
        }

        // Gestion Audio
        if ($request->hasFile('audio')) {
            $audioPath = 'audio/catalogue';
            if (!file_exists(public_path($audioPath))) {
                mkdir(public_path($audioPath), 0775, true);
            }
            // Supprime l'ancien audio
            if ($catalogue->audio && file_exists(public_path($catalogue->audio))) {
                @unlink(public_path($catalogue->audio));
            }
            $audioName = uniqid('audio_') . '.' . $request->audio->extension();
            $request->audio->move(public_path($audioPath), $audioName);
            $validated['audio'] = $audioPath . '/' . $audioName;
        }

        $validated['type_categorie'] = 'catalogue';

        $catalogue->update($validated);

        return redirect()->route('admin.catalogue.index')->with('success', 'Livre modifié avec succès !');
    }
    public function destroy($id)
    {
        $catalogue = Catalogue::findOrFail($id);
        // Supprimer les fichiers associés
        if ($catalogue->image && file_exists(public_path($catalogue->image))) {
            @unlink(public_path($catalogue->image));
        }
        if ($catalogue->pdf && file_exists(public_path($catalogue->pdf))) {
            @unlink(public_path($catalogue->pdf));
        }
        if ($catalogue->audio && file_exists(public_path($catalogue->audio))) {
            @unlink(public_path($catalogue->audio));
        }
        $catalogue->delete();
        return redirect()->route('admin.catalogue.index')->with('success', 'Livre supprimé avec succès !');
    }
}
