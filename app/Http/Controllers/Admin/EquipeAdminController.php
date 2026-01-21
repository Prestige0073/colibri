<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipeAdminController extends Controller
{
    public function index()
    {
        $membres = Equipe::orderBy('created_at', 'desc')->get();
        return view('admin.equipe.index', compact('membres'));
    }

    public function create()
    {
        return view('admin.equipe.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'poste' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'email' => 'nullable|email|max:255',
        ]);

        // Nettoyer les champs vides pour les convertir en null
        foreach (['email', 'bio'] as $field) {
            if (isset($validated[$field]) && empty(trim($validated[$field]))) {
                $validated[$field] = null;
            }
        }

        // Gérer l'upload de photo
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('equipe', 'public');
        }

        // Gérer le statut actif
        $validated['actif'] = $request->has('actif');

        Equipe::create($validated);

        return redirect()->route('admin.equipe.index')->with('success', 'Membre ajouté avec succès !');
    }

    public function show($id)
    {
        $membre = Equipe::findOrFail($id);
        return view('admin.equipe.show', compact('membre'));
    }

    public function edit($id)
    {
        $membre = Equipe::findOrFail($id);
        return view('admin.equipe.edit', compact('membre'));
    }

    public function update(Request $request, $id)
    {
        \Log::info('=== DÉBUT UPDATE EQUIPE ===');
        \Log::info('ID membre: ' . $id);
        \Log::info('Données reçues:', $request->all());

        $membre = Equipe::findOrFail($id);
        \Log::info('Membre trouvé:', $membre->toArray());

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'poste' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'email' => 'nullable|email|max:255',
        ]);

        \Log::info('Validation réussie:', $validated);

        // Nettoyer les champs vides pour les convertir en null
        foreach (['email', 'bio'] as $field) {
            if (isset($validated[$field]) && empty(trim($validated[$field]))) {
                $validated[$field] = null;
            }
        }

        // Gérer l'upload de photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe et n'est pas dans img/
            if ($membre->photo && !str_starts_with($membre->photo, 'img/')) {
                if (Storage::disk('public')->exists($membre->photo)) {
                    Storage::disk('public')->delete($membre->photo);
                }
            }
            $validated['photo'] = $request->file('photo')->store('equipe', 'public');
        }

        // Gérer le statut actif
        $validated['actif'] = $request->has('actif');
        \Log::info('Statut actif: ' . ($validated['actif'] ? 'true' : 'false'));

        \Log::info('Données finales avant update:', $validated);

        // Mettre à jour le membre
        $membre->update($validated);

        \Log::info('Membre mis à jour:', $membre->fresh()->toArray());
        \Log::info('=== FIN UPDATE EQUIPE - SUCCÈS ===');

        return redirect()->route('admin.equipe.index')->with('success', 'Membre modifié avec succès !');
    }

    public function destroy($id)
    {
        $membre = Equipe::findOrFail($id);

        // Supprimer la photo si elle existe
        if ($membre->photo && Storage::disk('public')->exists($membre->photo)) {
            Storage::disk('public')->delete($membre->photo);
        }

        $membre->delete();

        return redirect()->route('admin.equipe.index')->with('success', 'Membre supprimé avec succès !');
    }
}
