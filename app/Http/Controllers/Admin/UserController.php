<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Emprunt;
use App\Models\CartItem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Afficher la liste de tous les utilisateurs
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filtrer par rôle
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filtrer par statut (bloqué/actif)
        if ($request->filled('status')) {
            if ($request->status === 'blocked') {
                $query->where('blocked', true);
            } elseif ($request->status === 'active') {
                $query->where('blocked', false);
            }
        }

        // Recherche par nom ou email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->withCount(['emprunts', 'cartItems'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Afficher le formulaire de création d'un utilisateur
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Enregistrer un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:user,admin'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Afficher les détails d'un utilisateur
     */
    public function show(User $user)
    {
        $user->load([
            'emprunts' => function($query) {
                $query->with('livre')->latest()->limit(10);
            },
            'cartItems' => function($query) {
                $query->with('catalogue')->latest()->limit(10);
            }
        ]);

        // Statistiques utilisateur
        $stats = [
            'total_emprunts' => $user->emprunts()->count(),
            'emprunts_en_cours' => $user->emprunts()->where('statut', 'en_cours')->count(),
            'emprunts_en_retard' => $user->emprunts()->where('statut', 'en_retard')->count(),
            'total_achats' => $user->cartItems()->count(),
        ];

        return view('admin.users.show', compact('user', 'stats'));
    }

    /**
     * Afficher le formulaire d'édition d'un utilisateur
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'in:user,admin'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Mettre à jour le mot de passe uniquement s'il est fourni
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprimer un utilisateur
     */
    public function destroy(User $user)
    {
        // Vérifier qu'on ne supprime pas son propre compte
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
                        ->with('success', "L'utilisateur {$userName} a été supprimé avec succès.");
    }

    /**
     * Bloquer/Débloquer un utilisateur
     */
    public function toggleBlock(User $user)
    {
        // Vérifier qu'on ne bloque pas son propre compte
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas bloquer votre propre compte.');
        }

        $user->blocked = !$user->blocked;
        $user->save();

        $message = $user->blocked
            ? "L'utilisateur {$user->name} a été bloqué."
            : "L'utilisateur {$user->name} a été débloqué.";

        return redirect()->back()->with('success', $message);
    }

    /**
     * Changer le rôle d'un utilisateur
     */
    public function changeRole(Request $request, User $user)
    {
        // Vérifier qu'on ne change pas son propre rôle
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas changer votre propre rôle.');
        }

        $validated = $request->validate([
            'role' => ['required', 'in:user,admin'],
        ]);

        $user->update($validated);

        return redirect()->back()
                        ->with('success', "Le rôle de {$user->name} a été changé en {$validated['role']}.");
    }
}
