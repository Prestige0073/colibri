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
        $catalogues = Catalogue::where('type_categorie', 'catalogue')->latest()->get();
        $cataloguesEmprunt = Catalogue::where('type_categorie', 'emprunt')->latest()->get();

        return view('admin.catalogue', compact('catalogues', 'cataloguesEmprunt'));
    }
    public function create() {}
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'categorie' => 'required|string|max:255',
            'prix' => 'required|integer|min:0',
            'quantite' => 'required|integer|min:0',
            'resumer' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'pdf' => 'required|mimes:pdf|max:10000',
        ]);

        // Gestion image
        $imagePath = 'img/livres';
        if (!file_exists(public_path($imagePath))) {
            mkdir(public_path($imagePath), 0775, true);
        }
        $imageName = uniqid('img_') . '.' . $request->image->extension();
        $request->image->move(public_path($imagePath), $imageName);
        $imageUrl = $imagePath . '/' . $imageName;

        // Gestion PDF
        $pdfPath = 'pdf/catalogue';
        if (!file_exists(public_path($pdfPath))) {
            mkdir(public_path($pdfPath), 0775, true);
        }
        $pdfName = uniqid('pdf_') . '.' . $request->pdf->extension();
        $request->pdf->move(public_path($pdfPath), $pdfName);
        $pdfUrl = $pdfPath . '/' . $pdfName;

        $catalogue = Catalogue::create([
            'titre' => $request->titre,
            'auteur' => $request->auteur,
            'categorie' => $request->categorie,
            'prix' => $request->prix,
            'quantite' => $request->quantite,
            'type_categorie' => 'catalogue',
            'resumer' => $request->resumer,
            'image' => $imageUrl,
            'pdf' => $pdfUrl,
        ]);

        return redirect()->route('admin.catalogue.index')->with('success', 'Livre ajouté avec succès !');
    }
    public function show($id) {}
    public function edit($id) {}
    public function update(Request $request, $id)
    {
        $catalogue = Catalogue::findOrFail($id);
        $request->validate([
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'categorie' => 'required|string|max:255',
            'prix' => 'required|integer|min:0',
            'quantite' => 'required|integer|min:0',
            'resumer' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'pdf' => 'nullable|mimes:pdf|max:10000',
        ]);

        // Gestion image
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
            $catalogue->image = $imagePath . '/' . $imageName;
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
            $catalogue->pdf = $pdfPath . '/' . $pdfName;
        }

        $catalogue->titre = $request->titre;
        $catalogue->auteur = $request->auteur;
        $catalogue->categorie = $request->categorie;
        $catalogue->prix = $request->prix;
        $catalogue->quantite = $request->quantite;
        $catalogue->type_categorie = 'catalogue';
        $catalogue->resumer = $request->resumer;
        $catalogue->save();

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
        $catalogue->delete();
        return redirect()->route('admin.catalogue.index')->with('success', 'Livre supprimé avec succès !');
    }
}
