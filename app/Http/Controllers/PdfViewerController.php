<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;
use App\Models\Module;
use App\Models\ModuleContenu;
use App\Models\FormationInscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PdfViewerController extends Controller
{
    /**
     * Affiche le visualiseur PDF sécurisé dans une page dédiée
     * Utilise la vue ultra-sécurisée avec protection anti-capture
     */
    public function show(Formation $formation, Module $module, ModuleContenu $contenu)
    {
        // Vérifier que l'utilisateur est connecté
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Vous devez vous connecter pour accéder à ce contenu.');
        }

        // SÉCURITÉ: Vérifier si l'utilisateur est bloqué (permanent ou temporaire)
        $securityStatus = \App\Services\SecurityService::isUserBlocked($user->id);
        if ($securityStatus['blocked']) {
            Log::channel('security')->warning('Blocked user attempted PDF access', [
                'user_id' => $user->id,
                'contenu_id' => $contenu->id,
                'permanent' => $securityStatus['permanent'] ?? false,
            ]);

            if ($securityStatus['permanent'] ?? false) {
                return redirect()->route('formation.show', $formation)
                    ->with('error', 'Votre compte a été bloqué pour violation des conditions d\'utilisation.');
            } else {
                $expiresIn = $securityStatus['expires_in'] ?? 3600;
                $minutes = ceil($expiresIn / 60);
                return redirect()->route('formation.show', $formation)
                    ->with('error', "Accès temporairement bloqué. Réessayez dans {$minutes} minutes.");
            }
        }

        // Vérifier que le module appartient bien à la formation
        if ($module->formation_id !== $formation->id) {
            abort(404);
        }

        // Vérifier que le contenu appartient bien au module
        if ($contenu->module_id !== $module->id) {
            abort(404);
        }

        // Vérifier que c'est bien un PDF
        if ($contenu->type !== 'pdf') {
            abort(403, 'Ce contenu n\'est pas un document PDF.');
        }

        // Vérifier que l'utilisateur est inscrit et a payé
        $inscription = FormationInscription::where('user_id', $user->id)
            ->where('formation_id', $formation->id)
            ->where('paiement_valide', true)
            ->first();

        if (!$inscription) {
            return redirect()->route('formation.show', $formation)
                ->with('error', 'Vous devez vous inscrire et valider votre paiement pour accéder à ce document.');
        }

        // Charger tous les modules de la formation pour vérifier la progression
        $allModules = $formation->modules()->orderBy('ordre')->get();

        // Vérifier si le module précédent est complété (sauf pour le premier module)
        $moduleIndex = $allModules->search(function($item) use ($module) {
            return $item->id === $module->id;
        });

        if ($moduleIndex > 0) {
            $previousModule = $allModules[$moduleIndex - 1];

            // Vérifier si tous les contenus du module précédent sont complétés
            $previousModuleCompleted = true;
            $previousModuleProgressions = \App\Models\UserModuleProgression::where('user_id', $user->id)
                ->where('module_id', $previousModule->id)
                ->get()
                ->keyBy('module_contenu_id');

            foreach ($previousModule->contenus as $previousContenu) {
                if (!$previousModuleProgressions->has($previousContenu->id) || !$previousModuleProgressions[$previousContenu->id]->completed) {
                    $previousModuleCompleted = false;
                    break;
                }
            }

            if (!$previousModuleCompleted) {
                return redirect()->route('formation.module.show', [$formation, $previousModule])
                    ->with('error', 'Vous devez d\'abord terminer le module précédent avant d\'accéder à celui-ci.');
            }
        }

        // Vérifier si les contenus précédents de ce module sont complétés
        $allContenus = $module->contenus()->orderBy('ordre')->get();
        $contenuIndex = $allContenus->search(function($item) use ($contenu) {
            return $item->id === $contenu->id;
        });

        if ($contenuIndex > 0) {
            $userProgressions = \App\Models\UserModuleProgression::where('user_id', $user->id)
                ->where('module_id', $module->id)
                ->get()
                ->keyBy('module_contenu_id');

            for ($i = 0; $i < $contenuIndex; $i++) {
                $previousContenu = $allContenus[$i];
                if (!$userProgressions->has($previousContenu->id) || !$userProgressions[$previousContenu->id]->completed) {
                    return redirect()->route('formation.module.show', [$formation, $module])
                        ->with('error', 'Vous devez compléter les contenus précédents dans l\'ordre avant d\'accéder à ce document.');
                }
            }
        }

        // Vérifier que le fichier PDF existe physiquement
        if (!$contenu->fichier || !file_exists(public_path($contenu->fichier))) {
            Log::channel('security')->error('Fichier PDF formation manquant', [
                'user_id' => $user->id,
                'contenu_id' => $contenu->id,
                'fichier_path' => $contenu->fichier,
            ]);
            return redirect()->route('formation.module.show', [$formation, $module])
                ->with('error', 'Le fichier PDF n\'est pas disponible. Veuillez contacter le support.');
        }

        // Générer un token unique pour cette session de visualisation
        $token = bin2hex(random_bytes(32));
        session(['formation_pdf_token_' . $contenu->id => $token]);
        session(['formation_pdf_access_time_' . $contenu->id => now()]);

        // Logger l'accès au document
        Log::channel('security')->info('PDF document accessed', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'contenu_id' => $contenu->id,
            'formation_id' => $formation->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        // Tout est OK, afficher le visualiseur PDF ULTRA-SÉCURISÉ avec token
        return response()
            ->view('pdf.viewer-secure', [
                'formation' => $formation,
                'module' => $module,
                'contenu' => $contenu,
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
     * Servir le PDF de formation avec vérification du token
     */
    public function servePdf(Formation $formation, Module $module, ModuleContenu $contenu)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Non autorisé');
        }

        // Vérifications de base
        if ($module->formation_id !== $formation->id || $contenu->module_id !== $module->id) {
            abort(404);
        }

        // Vérifier l'inscription
        $inscription = FormationInscription::where('user_id', $user->id)
            ->where('formation_id', $formation->id)
            ->where('paiement_valide', true)
            ->first();

        if (!$inscription) {
            abort(403, 'Accès non autorisé');
        }

        // Vérifier le token
        $token = request()->query('token');
        $sessionToken = session('formation_pdf_token_' . $contenu->id);

        if (!$token || $token !== $sessionToken) {
            Log::channel('security')->warning('Token PDF formation invalide', [
                'user_id' => $user->id,
                'contenu_id' => $contenu->id,
                'ip' => request()->ip(),
            ]);
            abort(403, 'Token invalide');
        }

        // Vérifier que l'accès n'est pas expiré (60 minutes)
        $accessTime = session('formation_pdf_access_time_' . $contenu->id);
        if (!$accessTime || $accessTime->diffInMinutes(now()) > 60) {
            abort(403, 'Session expirée. Veuillez recharger la page.');
        }

        // Vérifier que le fichier existe
        if (!$contenu->fichier || !file_exists(public_path($contenu->fichier))) {
            abort(404, 'PDF non disponible');
        }

        $pdfPath = public_path($contenu->fichier);

        // Servir le PDF avec headers sécurisés
        return response()->file($pdfPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $contenu->titre . '.pdf"',
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
