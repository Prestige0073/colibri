<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

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

        // Vérifier si l'admin existe
        $admin = Admin::where('email', $credentials['email'])->first();

        if (!$admin) {
            return back()->withErrors([
                'email' => 'Aucun compte administrateur trouvé avec cet email.',
            ])->withInput($request->only('email'));
        }

        // Vérifier si le compte est actif
        if ($admin->status !== 'active') {
            return back()->withErrors([
                'email' => 'Votre compte a été désactivé. Contactez le super administrateur.',
            ])->withInput($request->only('email'));
        }

        // Tentative de connexion avec le guard admin
        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Mettre à jour la date de dernière connexion
            $admin->update(['last_login_at' => now()]);

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Identifiants invalides.',
        ])->withInput($request->only('email'));
    }

    /**
     * Déconnexion admin
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
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
            'email' => 'required|string|email|max:255|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Créer l'administrateur
        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'], // Le mutateur dans le modèle s'occupe du hash
            'is_super_admin' => true, // Premier admin créé via token = super admin
            'status' => 'active',
        ]);

        // Connecter automatiquement le nouvel admin
        Auth::guard('admin')->login($admin);

        return redirect()->route('admin.dashboard')->with('success', 'Compte administrateur créé avec succès !');
    }
}
