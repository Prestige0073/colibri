<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

class BannerAdminController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('ordre')->get();
        return view('admin.banners', compact('banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'image' => 'required|image|max:5120',
        ]);

        $imagePath = 'img/banners';
        if (!file_exists(public_path($imagePath))) {
            mkdir(public_path($imagePath), 0775, true);
        }

        // Redimensionner l'image à 800x800 pour garder le format
        $imageName = uniqid('banner_') . '.jpg';
        $fullPath = public_path($imagePath . '/' . $imageName);

        $image = $request->file('image');
        $img = imagecreatefromstring(file_get_contents($image->getRealPath()));
        $srcW = imagesx($img);
        $srcH = imagesy($img);

        // Crop au centre pour obtenir un carré, puis redimensionner à 800x800
        $size = min($srcW, $srcH);
        $srcX = ($srcW - $size) / 2;
        $srcY = ($srcH - $size) / 2;

        $dst = imagecreatetruecolor(800, 800);
        imagecopyresampled($dst, $img, 0, 0, (int)$srcX, (int)$srcY, 800, 800, $size, $size);
        imagejpeg($dst, $fullPath, 90);
        imagedestroy($img);
        imagedestroy($dst);

        $maxOrdre = Banner::max('ordre') ?? 0;

        Banner::create([
            'titre' => $request->titre,
            'image' => $imagePath . '/' . $imageName,
            'ordre' => $maxOrdre + 1,
            'actif' => true,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Bannière ajoutée avec succès !');
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'titre' => 'required|string|max:255',
            'image' => 'nullable|image|max:5120',
        ]);

        $banner->titre = $request->titre;

        if ($request->has('actif')) {
            $banner->actif = true;
        } else {
            $banner->actif = false;
        }

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($banner->image && file_exists(public_path($banner->image))) {
                @unlink(public_path($banner->image));
            }

            $imagePath = 'img/banners';
            if (!file_exists(public_path($imagePath))) {
                mkdir(public_path($imagePath), 0775, true);
            }

            $imageName = uniqid('banner_') . '.jpg';
            $fullPath = public_path($imagePath . '/' . $imageName);

            $image = $request->file('image');
            $img = imagecreatefromstring(file_get_contents($image->getRealPath()));
            $srcW = imagesx($img);
            $srcH = imagesy($img);

            $size = min($srcW, $srcH);
            $srcX = ($srcW - $size) / 2;
            $srcY = ($srcH - $size) / 2;

            $dst = imagecreatetruecolor(800, 800);
            imagecopyresampled($dst, $img, 0, 0, (int)$srcX, (int)$srcY, 800, 800, $size, $size);
            imagejpeg($dst, $fullPath, 90);
            imagedestroy($img);
            imagedestroy($dst);

            $banner->image = $imagePath . '/' . $imageName;
        }

        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Bannière modifiée avec succès !');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->image && file_exists(public_path($banner->image))) {
            @unlink(public_path($banner->image));
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Bannière supprimée avec succès !');
    }

    /**
     * Réordonner les bannières via AJAX
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:banners,id',
        ]);

        foreach ($request->order as $index => $id) {
            Banner::where('id', $id)->update(['ordre' => $index + 1]);
        }

        return response()->json(['message' => 'Ordre mis à jour.']);
    }
}
