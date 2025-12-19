<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Afficher le formulaire de connexion admin
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Traiter la connexion admin
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Ajouter la condition que l'utilisateur doit être admin
        $credentials['role'] = 'admin';

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Identifiants invalides ou accès non autorisé.',
        ])->withInput($request->only('email'));
    }

    /**
     * Déconnexion admin
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', 'Déconnexion réussie.');
    }

    /**
     * Afficher le formulaire d'enregistrement admin (avec token secret)
     */
    public function showRegisterForm(Request $request, $token)
    {
        // Vérifier que le token correspond au token secret dans .env
        $secretToken = config('app.admin_register_token');

        if (!$secretToken || $token !== $secretToken) {
            abort(404); // Page non trouvée si le token est invalide
        }

        return view('admin.auth.register', ['token' => $token]);
    }

    /**
     * Traiter l'enregistrement d'un nouvel admin
     */
    public function register(Request $request, $token)
    {
        // Vérifier le token secret
        $secretToken = config('app.admin_register_token');

        if (!$secretToken || $token !== $secretToken) {
            abort(403, 'Accès interdit.');
        }

        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Créer l'utilisateur admin
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);

        // Connecter automatiquement le nouvel admin
        Auth::login($user);

        return redirect()->route('admin.dashboard')->with('success', 'Compte administrateur créé avec succès !');
    }
}
