<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprunt;
use App\Models\Catalogue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BibliothequeController extends Controller
{
    public function emprunter(Request $request)
    {
        $request->validate([
            'livre_id' => 'required|exists:catalogues,id',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'Vous devez être connecté pour emprunter un livre.');
        }

        // Récupérer le livre
        $livre = Catalogue::findOrFail($request->livre_id);

        // Vérifier la disponibilité du stock
        if ($livre->quantite <= 0) {
            return redirect()->back()->with('error', 'Ce livre n\'est plus disponible à l\'emprunt.');
        }

        // Vérifier si l'utilisateur n'a pas déjà un emprunt actif pour ce livre
        $empruntActif = Emprunt::where('user_id', $user->id)
            ->where('livre_id', $livre->id)
            ->whereIn('statut', [Emprunt::STATUT_EN_ATTENTE, Emprunt::STATUT_EN_COURS])
            ->first();

        if ($empruntActif) {
            return redirect()->back()->with('error', 'Vous avez déjà une demande d\'emprunt en cours pour ce livre.');
        }

        // Créer l'emprunt avec le statut "en attente" (nécessite validation admin)
        $emprunt = Emprunt::create([
            'user_id' => $user->id,
            'livre_id' => $livre->id,
            'date_emprunt' => now(),
            'statut' => Emprunt::STATUT_EN_ATTENTE,
        ]);

        Log::info('Nouvelle demande d\'emprunt', [
            'user_id' => $user->id,
            'livre_id' => $livre->id,
            'emprunt_id' => $emprunt->id
        ]);

        return redirect()->back()->with('success', 'Votre demande d\'emprunt a été enregistrée. Elle sera validée par notre équipe.');
    }

    public function destroy($id)
    {
        $emprunt = Emprunt::findOrFail($id);

        // Vérifier que l'utilisateur connecté est le propriétaire de l'emprunt
        if ($emprunt->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à supprimer cet emprunt.');
        }

        $emprunt->delete();

        return redirect()->back()->with('success', 'Emprunt supprimé avec succès.');
    }

    public function acheter()
    {
        $livres = \App\Models\Catalogue::all();
        $user = Auth::user();
        $emprunts = $user ? $user->emprunts()->with('livre')->orderByDesc('created_at')->get() : collect();
        return view('catalogue.acheter', compact('livres', 'emprunts'));
    }

    /**
     * Affiche le visualiseur PDF sécurisé pour un livre acheté
     */
    public function lire($catalogueId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Vous devez vous connecter pour accéder à ce livre.');
        }

        // SÉCURITÉ: Vérifier si l'utilisateur est bloqué
        $securityStatus = \App\Services\SecurityService::isUserBlocked($user->id);
        if ($securityStatus['blocked']) {
            Log::channel('security')->warning('Blocked user attempted PDF access', [
                'user_id' => $user->id,
                'catalogue_id' => $catalogueId,
                'permanent' => $securityStatus['permanent'] ?? false,
            ]);

            if ($securityStatus['permanent'] ?? false) {
                return redirect()->route('account.bibliotheque')
                    ->with('error', 'Votre compte a été bloqué pour violation des conditions d\'utilisation. Contactez le support.');
            } else {
                $expiresIn = $securityStatus['expires_in'] ?? 3600;
                $minutes = ceil($expiresIn / 60);
                return redirect()->route('account.bibliotheque')
                    ->with('error', "Accès temporairement bloqué. Réessayez dans {$minutes} minutes.");
            }
        }

        // Vérifier que le livre existe
        $livre = Catalogue::findOrFail($catalogueId);

        // Vérifier que l'utilisateur a bien acheté ce livre
        if (!$user->hasPurchasedBook($catalogueId)) {
            return redirect()->route('account.bibliotheque')
                ->with('error', 'Vous n\'avez pas accès à ce livre. Veuillez l\'acheter pour y accéder.');
        }

        // Vérifier que le livre a un PDF
        if (!$livre->pdf) {
            return redirect()->route('account.bibliotheque')
                ->with('error', 'Ce livre n\'a pas de version PDF disponible.');
        }

        // Vérifier que le fichier PDF existe physiquement
        if (!file_exists(public_path($livre->pdf))) {
            Log::channel('security')->error('Fichier PDF manquant', [
                'user_id' => $user->id,
                'livre_id' => $livre->id,
                'pdf_path' => $livre->pdf,
            ]);
            return redirect()->route('account.bibliotheque')
                ->with('error', 'Le fichier PDF n\'est pas disponible. Veuillez contacter le support.');
        }

        // Générer un token unique pour cette session de visualisation
        $token = bin2hex(random_bytes(32));
        session(['bibliotheque_pdf_token_' . $livre->id => $token]);
        session(['bibliotheque_pdf_access_time_' . $livre->id => now()]);

        // Logger l'accès au document pour la sécurité
        Log::channel('security')->info('Accès document PDF bibliothèque', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'livre_id' => $livre->id,
            'livre_titre' => $livre->titre,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toISOString(),
        ]);

        // Afficher le visualiseur PDF ultra-sécurisé avec le token
        return response()
            ->view('bibliotheque.lire-secure', [
                'livre' => $livre,
                'user' => $user,
                'token' => $token,
            ])
            ->header('X-Frame-Options', 'DENY')
            ->header('X-Content-Type-Options', 'nosniff')
            ->header('X-XSS-Protection', '1; mode=block')
            ->header('Referrer-Policy', 'no-referrer')
            ->header('Cache-Control', 'private, no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache');
    }

    /**
     * Servir le PDF de la bibliothèque avec vérification du token
     */
    public function servePdf($catalogueId)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Non autorisé');
        }

        $livre = Catalogue::findOrFail($catalogueId);

        // Vérifier que l'utilisateur a acheté le livre
        if (!$user->hasPurchasedBook($catalogueId)) {
            abort(403, 'Accès non autorisé');
        }

        // Vérifier le token
        $token = request()->query('token');
        $sessionToken = session('bibliotheque_pdf_token_' . $livre->id);

        if (!$token || $token !== $sessionToken) {
            Log::channel('security')->warning('Token PDF invalide', [
                'user_id' => $user->id,
                'livre_id' => $livre->id,
                'ip' => request()->ip(),
            ]);
            abort(403, 'Token invalide');
        }

        // Vérifier que l'accès n'est pas expiré (60 minutes pour la lecture)
        $accessTime = session('bibliotheque_pdf_access_time_' . $livre->id);
        if (!$accessTime || $accessTime->diffInMinutes(now()) > 60) {
            abort(403, 'Session expirée. Veuillez recharger la page.');
        }

        // Vérifier que le fichier existe
        if (!$livre->pdf || !file_exists(public_path($livre->pdf))) {
            abort(404, 'PDF non disponible');
        }

        $pdfPath = public_path($livre->pdf);

        // Servir le PDF avec headers sécurisés
        return response()->file($pdfPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $livre->titre . '.pdf"',
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
