<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SecurePdfController extends Controller
{
    /**
     * Afficher le PDF dans une interface sécurisée
     */
    public function view(Request $request, $id)
    {
        $livre = Catalogue::findOrFail($id);

        // Vérifier que le fichier PDF existe
        if (!$livre->pdf || !file_exists(public_path($livre->pdf))) {
            abort(404, 'PDF non disponible');
        }

        // Vérifier que l'utilisateur est authentifié
        if (!auth()->check()) {
            abort(403, 'Vous devez être connecté pour accéder à ce contenu.');
        }

        // Vérifier que l'utilisateur a un emprunt VALIDÉ pour ce livre
        $empruntValide = \App\Models\Emprunt::where('user_id', auth()->id())
            ->where('livre_id', $livre->id)
            ->whereIn('statut', ['en_cours', 'en_retard'])
            ->whereNotNull('valide_le')  // L'emprunt doit être validé par un admin
            ->first();

        if (!$empruntValide) {
            // Vérifier si l'utilisateur a une demande en attente
            $enAttente = \App\Models\Emprunt::where('user_id', auth()->id())
                ->where('livre_id', $livre->id)
                ->where('statut', 'en_attente')
                ->exists();

            if ($enAttente) {
                abort(403, 'Votre demande d\'emprunt est en attente de validation par un administrateur.');
            }

            abort(403, 'Vous devez emprunter ce livre avant de pouvoir le lire.');
        }

        // Vérifier que l'accès de 14 jours n'a pas expiré
        if ($empruntValide->access_expires_at && now()->greaterThan($empruntValide->access_expires_at)) {
            abort(403, 'Votre période d\'accès de 14 jours a expiré. Veuillez contacter l\'administration pour prolonger votre accès.');
        }

        // Générer un token unique pour cette session de visualisation
        $token = bin2hex(random_bytes(32));
        session(['pdf_token_' . $id => $token]);
        session(['pdf_access_time_' . $id => now()]);

        // Headers de sécurité pour bloquer la capture d'écran
        return response()
            ->view('secure-pdf.viewer', compact('livre', 'token'))
            ->header('X-Frame-Options', 'DENY')
            ->header('X-Content-Type-Options', 'nosniff')
            ->header('X-XSS-Protection', '1; mode=block')
            ->header('Referrer-Policy', 'no-referrer')
            ->header('Permissions-Policy', 'geolocation=(), microphone=(), camera=(), payment=(), usb=(), screen-wake-lock=(), display-capture=(), web-share=()')
            ->header('Content-Security-Policy', "default-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; img-src 'self' data: blob:; media-src 'none'; object-src 'none'; frame-src 'none'; base-uri 'self'; form-action 'self';")
            ->header('Cache-Control', 'private, no-cache, no-store, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Servir le PDF avec vérification du token
     */
    public function serve(Request $request, $id)
    {
        $livre = Catalogue::findOrFail($id);

        // Vérifier le token
        $token = $request->query('token');
        $sessionToken = session('pdf_token_' . $id);

        if (!$token || $token !== $sessionToken) {
            abort(403, 'Accès non autorisé');
        }

        // Vérifier que l'accès n'est pas expiré (30 minutes)
        $accessTime = session('pdf_access_time_' . $id);
        if (!$accessTime || $accessTime->diffInMinutes(now()) > 30) {
            abort(403, 'Session expirée');
        }

        // Vérifier que le fichier existe
        if (!$livre->pdf || !file_exists(public_path($livre->pdf))) {
            abort(404, 'PDF non disponible');
        }

        $pdfPath = public_path($livre->pdf);

        // Headers sécurisés pour empêcher le téléchargement
        return response()->file($pdfPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($pdfPath) . '"',
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }
}
