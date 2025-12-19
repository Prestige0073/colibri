<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprunt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function profil() {
        $user = Auth::user();
        if ($user) {
            $emprunts = Emprunt::where('user_id', $user->id)->get();
            // Récupérer commandes en cours de livraison (statut pending ou en_livraison)
            $commandesEnLivraison = \App\Models\Commande::where('user_id', $user->id)
                ->whereIn('statut', ['pending', 'en_livraison'])
                ->with('items')
                ->orderByDesc('created_at')
                ->get();
        } else {
            $emprunts = collect();
            $commandesEnLivraison = collect();
        }
        return view('account.profil', compact('emprunts', 'commandesEnLivraison'));
    }

    /**
     * Update user's avatar
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120', // max 5MB
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('account.profil')->with('error', 'Utilisateur non authentifié.');
        }

        $file = $request->file('avatar');
        $ext = $file->getClientOriginalExtension();
        $basename = Str::random(40) . '.' . $ext;
        $publicDir = public_path('avatars');

        if (!file_exists($publicDir)) {
            mkdir($publicDir, 0755, true);
        }

        // remove old avatar if present in public/avatars
        if ($user->avatar) {
            // possible stored path like 'avatars/xxx.jpg' or full URL
            $old = $user->avatar;
            // normalize
            if (Str::startsWith($old, url('/'))) {
                // strip domain
                $old = str_replace(url('/'), '', $old);
                $old = ltrim($old, '/');
            }
            if (Str::startsWith($old, 'storage/')) {
                $old = substr($old, strlen('storage/'));
            }
            $oldPath = public_path($old);
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        // move uploaded file into public/avatars
        $targetPath = $publicDir . DIRECTORY_SEPARATOR . $basename;
        $file->move($publicDir, $basename);

        // Save user avatar path as public path accessible via asset('/avatars/...')
        $user->avatar = 'avatars/' . $basename;
        $user->save();

        return redirect()->route('account.profil')->with('success', 'Avatar mis à jour avec succès.');
    }

    public function historique() {
        return view('account.historique');
    }

    public function certifications() {
        return view('account.certifications');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
