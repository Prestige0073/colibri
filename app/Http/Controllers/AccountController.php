<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprunt;
use Illuminate\Support\Facades\Auth;

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
