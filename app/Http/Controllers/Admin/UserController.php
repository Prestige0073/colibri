<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Assurez-vous d'importer le modèle User

class UserController extends Controller
{
    public function index()
    {
        // Récupérer tous les utilisateurs (supposons que vous avez un modèle User)
        $users = User::all();

        // Retourner la vue avec les utilisateurs
        return view('admin.users', compact('users'));
    }
    public function create() {}
    public function store(Request $request) {}
    public function show($id) {}
    public function edit($id) {}
    public function update(Request $request, $id) {}
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function toggleBlock($id)
    {
        $user = User::findOrFail($id);
        $user->blocked = !$user->blocked;
        $user->save();
        $message = $user->blocked ? 'Utilisateur bloqué.' : 'Utilisateur débloqué.';
        return redirect()->route('admin.users.index')->with('success', $message);
    }
}
