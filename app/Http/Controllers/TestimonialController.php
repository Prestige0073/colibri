<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Afficher la page des témoignages
     */
    public function index()
    {
        $testimonials = Testimonial::approved()
                                   ->latest('approved_at')
                                   ->paginate(12);

        return view('testimonial', compact('testimonials'));
    }

    /**
     * Enregistrer un nouveau témoignage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'role' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string|min:10|max:500',
            'rating' => 'required|integer|min:1|max:5',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
        ], [
            'name.required' => 'Le nom est requis.',
            'message.required' => 'Le message est requis.',
            'message.min' => 'Le message doit contenir au moins 10 caractères.',
            'message.max' => 'Le message ne doit pas dépasser 500 caractères.',
            'rating.required' => 'La note est requise.',
            'rating.min' => 'La note doit être entre 1 et 5.',
            'rating.max' => 'La note doit être entre 1 et 5.',
            'photo.image' => 'Le fichier doit être une image.',
            'photo.max' => 'L\'image ne doit pas dépasser 1 Mo.',
        ]);

        // Upload de la photo si présente
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        // Ajouter l'ID utilisateur si connecté
        if (Auth::check()) {
            $validated['user_id'] = Auth::id();
        }

        // Le statut par défaut est 'pending'
        Testimonial::create($validated);

        return redirect()->back()->with('success', 'Merci pour votre témoignage ! Il sera publié après validation.');
    }
}
