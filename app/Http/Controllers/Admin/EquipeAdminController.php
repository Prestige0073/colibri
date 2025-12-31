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
        $membres = Equipe::orderBy('ordre')->get();
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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'nullable|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'linkedin' => 'nullable|url|max:255',
            'twitter' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:255',
            'ordre' => 'nullable|integer',
            'actif' => 'nullable|boolean',
        ]);

        // Nettoyer les URLs vides pour les convertir en null
        if (empty($validated['linkedin'])) {
            $validated['linkedin'] = null;
        }
        if (empty($validated['facebook'])) {
            $validated['facebook'] = null;
        }

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('equipe', 'public');
        }

        $validated['actif'] = $request->has('actif');
        $validated['ordre'] = $validated['ordre'] ?? Equipe::max('ordre') + 1;

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
        \Log::info('=== DEBUT UPDATE EQUIPE ===');
        \Log::info('ID membre: ' . $id);
        \Log::info('Données POST: ', $request->all());

        $membre = Equipe::findOrFail($id);
        \Log::info('Membre trouvé: ' . $membre->nom);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'poste' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'nullable|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'linkedin' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'ordre' => 'nullable|integer',
            'actif' => 'nullable|boolean',
        ]);

        // Nettoyer les champs vides pour les convertir en null
        foreach (['linkedin', 'facebook', 'twitter', 'email', 'telephone', 'bio'] as $field) {
            if (isset($validated[$field]) && empty(trim($validated[$field]))) {
                $validated[$field] = null;
            }
        }

        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($membre->photo && Storage::disk('public')->exists($membre->photo)) {
                Storage::disk('public')->delete($membre->photo);
            }
            $validated['photo'] = $request->file('photo')->store('equipe', 'public');
        }

        $validated['actif'] = $request->has('actif');

        \Log::info('Données à enregistrer: ', $validated);

        $result = $membre->update($validated);

        \Log::info('Update result: ' . ($result ? 'TRUE' : 'FALSE'));
        \Log::info('Membre après update: ', $membre->fresh()->toArray());
        \Log::info('=== FIN UPDATE EQUIPE ===');

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
