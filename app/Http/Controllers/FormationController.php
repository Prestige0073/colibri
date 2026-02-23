<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;
use App\Models\Module as ModuleModel;
use Illuminate\Support\Facades\Mail;
use App\Mail\Admin\FormationCompleted;

class FormationController extends Controller
{
    public function modules() {
        // Récupère les formations paginées avec le nombre de modules associés et leurs contenus
        $formations = Formation::withCount('modules')
            ->with(['modules.contenus'])
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        return view('formation.modules', compact('formations'));
    }

    /**
     * Affiche la page de détail d'une formation avec tous ses modules
     */
    public function show(Formation $formation)
    {
        $formation->load(['modules.contenus', 'quizzes' => function($query) {
            $query->where('active', true)->with('questions');
        }]);

        // Vérifier si l'utilisateur est connecté et a une inscription valide
        $inscription = null;
        if (\Illuminate\Support\Facades\Auth::check()) {
            $inscription = \App\Models\FormationInscription::where('user_id', \Illuminate\Support\Facades\Auth::id())
                ->where('formation_id', $formation->id)
                ->first();
        }

        return view('formation.show', compact('formation', 'inscription'));
    }

    /**
     * Permet à un utilisateur connecté de s'inscrire à une formation
     */
    public function acheter(Request $request, Formation $formation)
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour vous inscrire à une formation.');
        }

        $user = \Illuminate\Support\Facades\Auth::user();

        // Vérifier si l'utilisateur a déjà une inscription pour cette formation
        $existingInscription = \App\Models\FormationInscription::where('user_id', $user->id)
            ->where('formation_id', $formation->id)
            ->first();

        if ($existingInscription) {
            if ($existingInscription->paiement_valide) {
                return redirect()->route('formation.show', $formation)
                    ->with('info', 'Vous êtes déjà inscrit à cette formation.');
            }
            $inscription = $existingInscription;
        } else {
            $inscription = \App\Models\FormationInscription::create([
                'user_id' => $user->id,
                'formation_id' => $formation->id,
                'date_inscription' => now(),
                'montant_paye' => $formation->prix ?? 0,
                'statut' => 'en_cours',
                'progression' => 0,
                'paiement_valide' => false,
            ]);
        }

        // Si la formation est gratuite, valider directement l'inscription sans paiement
        if ($formation->est_gratuit || $formation->prix == 0) {
            $inscription->update([
                'paiement_valide' => true,
                'montant_paye' => 0,
            ]);

            return redirect()->route('formation.show', $formation)
                ->with('success', 'Vous êtes maintenant inscrit à cette formation. Bon apprentissage !');
        }

        // Sinon, rediriger vers la page de sélection du moyen de paiement
        return redirect()->route('formation.paiement', $formation);
    }

    /**
     * Affiche la page de sélection du moyen de paiement
     */
    public function paiement(Formation $formation)
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour continuer.');
        }

        $user = \Illuminate\Support\Facades\Auth::user();

        // Récupérer l'inscription de l'utilisateur pour cette formation
        $inscription = \App\Models\FormationInscription::where('user_id', $user->id)
            ->where('formation_id', $formation->id)
            ->first();

        if (!$inscription) {
            return redirect()->route('formation.show', $formation)
                ->with('error', 'Aucune inscription trouvée. Veuillez réessayer.');
        }

        if ($inscription->paiement_valide) {
            return redirect()->route('formation.show', $formation)
                ->with('info', 'Vous êtes déjà inscrit à cette formation.');
        }

        // Les formations gratuites ne passent pas par la page de paiement
        if ($formation->est_gratuit || $formation->prix == 0) {
            $inscription->update([
                'paiement_valide' => true,
                'montant_paye' => 0,
            ]);

            return redirect()->route('formation.show', $formation)
                ->with('success', 'Vous êtes maintenant inscrit à cette formation. Bon apprentissage !');
        }

        $formation->load('modules');

        return view('formation.paiement', compact('formation', 'inscription'));
    }

    /**
     * Traiter le paiement selon la méthode choisie
     */
    public function traiterPaiement(Request $request, Formation $formation)
    {
        $request->validate([
            'payment_method' => 'required|in:kkiapay,paypal',
            'inscription_id' => 'required|exists:formation_inscriptions,id',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();
        $inscription = \App\Models\FormationInscription::findOrFail($request->inscription_id);

        // Vérifier que l'inscription appartient à l'utilisateur
        if ($inscription->user_id !== $user->id) {
            abort(403);
        }

        $paymentMethod = $request->payment_method;

        // Rediriger vers le gestionnaire de paiement approprié
        switch ($paymentMethod) {
            case 'kkiapay':
                return redirect()->route('paiement.kkiapay', ['inscription' => $inscription->id]);
            case 'paypal':
                return redirect()->route('paiement.paypal', ['inscription' => $inscription->id]);
            default:
                return redirect()->route('formation.paiement', $formation)
                    ->with('error', 'Méthode de paiement non reconnue.');
        }
    }

    /**
     * Affiche un module (vidéo + ressources) appartenant à une formation
     */
    public function moduleShow(Formation $formation, ModuleModel $module)
    {
        // Vérifie que le module appartient bien à la formation
        if ($module->formation_id !== $formation->id) {
            abort(404);
        }

        // Vérifier que l'utilisateur est connecté
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Vous devez vous connecter pour accéder à ce contenu.');
        }

        // Vérifier que l'utilisateur est inscrit
        $inscription = \App\Models\FormationInscription::where('user_id', $user->id)
            ->where('formation_id', $formation->id)
            ->where('paiement_valide', true)
            ->first();

        if (!$inscription) {
            return redirect()->route('formation.show', $formation)
                ->with('error', 'Vous devez vous inscrire pour accéder aux modules de cette formation.');
        }

        // Charger tous les modules de la formation triés par ordre
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

            foreach ($previousModule->contenus as $contenu) {
                if (!$previousModuleProgressions->has($contenu->id) || !$previousModuleProgressions[$contenu->id]->completed) {
                    $previousModuleCompleted = false;
                    break;
                }
            }

            if (!$previousModuleCompleted) {
                return redirect()->route('formation.module.show', [$formation, $previousModule])
                    ->with('error', 'Vous devez d\'abord terminer le module précédent avant d\'accéder à celui-ci.');
            }

            // Vérifier si tous les quizzes du module précédent sont réussis
            $previousModuleQuizzes = \App\Models\Quiz::where('module_id', $previousModule->id)
                ->where('active', true)
                ->get();

            foreach ($previousModuleQuizzes as $quiz) {
                if (!$quiz->userHasPassed($user->id)) {
                    return redirect()->route('formation.module.show', [$formation, $previousModule])
                        ->with('error', 'Vous devez réussir le quiz du module précédent avant de passer au suivant.');
                }
            }
        }

        // Charger les contenus et quizzes du module
        $module->load(['contenus', 'quizzes']);

        // Récupérer les progressions de l'utilisateur pour ce module
        $userProgressions = \App\Models\UserModuleProgression::where('user_id', $user->id)
            ->where('module_id', $module->id)
            ->get()
            ->keyBy('module_contenu_id');

        return view('formation.module', [
            'module' => $module,
            'formation' => $formation,
            'inscription' => $inscription,
            'userProgressions' => $userProgressions,
            'allModules' => $allModules,
            'moduleIndex' => $moduleIndex,
        ]);
    }

    public function markContenuCompleted(Formation $formation, ModuleModel $module, \App\Models\ModuleContenu $contenu)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Non authentifié'], 401);
        }

        // Vérifier que le contenu appartient au module
        if ($contenu->module_id !== $module->id) {
            return response()->json(['error' => 'Contenu invalide'], 400);
        }

        // Vérifier que l'utilisateur est inscrit
        $inscription = \App\Models\FormationInscription::where('user_id', $user->id)
            ->where('formation_id', $formation->id)
            ->where('paiement_valide', true)
            ->first();

        if (!$inscription) {
            return response()->json(['error' => 'Vous devez être inscrit à cette formation'], 403);
        }

        // Vérifier que les contenus précédents sont complétés
        $allContenus = $module->contenus()->orderBy('ordre')->get();
        $contenuIndex = $allContenus->search(function($item) use ($contenu) {
            return $item->id === $contenu->id;
        });

        if ($contenuIndex === false) {
            return response()->json(['error' => 'Contenu non trouvé'], 404);
        }

        // Vérifier que tous les contenus précédents sont complétés
        for ($i = 0; $i < $contenuIndex; $i++) {
            $previousContenu = $allContenus[$i];
            $previousProgression = \App\Models\UserModuleProgression::where('user_id', $user->id)
                ->where('module_contenu_id', $previousContenu->id)
                ->where('completed', true)
                ->first();

            if (!$previousProgression) {
                return response()->json(['error' => 'Vous devez compléter les contenus précédents dans l\'ordre'], 403);
            }
        }

        // Marquer le contenu comme complété
        $progression = \App\Models\UserModuleProgression::updateOrCreate(
            [
                'user_id' => $user->id,
                'module_id' => $module->id,
                'module_contenu_id' => $contenu->id,
            ],
            [
                'completed' => true,
                'completed_at' => now(),
            ]
        );

        // Vérifier si la formation est terminée (tous les contenus complétés + tous les quizzes réussis)
        $this->checkFormationCompleted($formation, $user, $inscription);

        return response()->json(['success' => true, 'message' => 'Contenu marqué comme complété']);
    }

    public function updateVideoProgress(Request $request, Formation $formation, ModuleModel $module, \App\Models\ModuleContenu $contenu)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Non authentifié'], 401);
        }

        // Vérifier que le contenu appartient au module et est une vidéo
        if ($contenu->module_id !== $module->id || $contenu->type !== 'video') {
            return response()->json(['error' => 'Contenu invalide'], 400);
        }

        $percentage = $request->input('percentage', 0);

        // Mettre à jour la progression
        $progression = \App\Models\UserModuleProgression::updateOrCreate(
            [
                'user_id' => $user->id,
                'module_id' => $module->id,
                'module_contenu_id' => $contenu->id,
            ],
            [
                'video_watch_percentage' => $percentage,
            ]
        );

        return response()->json([
            'success' => true,
            'percentage' => $percentage,
            'can_complete' => $percentage >= 95
        ]);
    }

    public function quiz() {
        return view('formation.quiz');
    }

    public function certification() {
        return view('formation.certification');
    }

    /**
     * Vérifie si un apprenant a terminé une formation (tous contenus + tous quizzes)
     * et envoie une alerte email à l'admin pour générer le certificat
     */
    public static function checkFormationCompleted(Formation $formation, $user, $inscription)
    {
        // Si la formation est déjà marquée terminée, ne pas renvoyer d'alerte
        if ($inscription->statut === 'termine') {
            return false;
        }

        // 1. Vérifier que tous les contenus de tous les modules sont complétés
        $formation->load('modules.contenus');
        $totalContenus = 0;
        $completedContenus = 0;

        foreach ($formation->modules as $module) {
            foreach ($module->contenus as $contenu) {
                $totalContenus++;
                $isCompleted = \App\Models\UserModuleProgression::where('user_id', $user->id)
                    ->where('module_contenu_id', $contenu->id)
                    ->where('completed', true)
                    ->exists();
                if ($isCompleted) {
                    $completedContenus++;
                }
            }
        }

        // Si pas tous les contenus sont complétés, on arrête
        if ($totalContenus === 0 || $completedContenus < $totalContenus) {
            // Mettre à jour la progression
            $progression = $totalContenus > 0 ? round(($completedContenus / $totalContenus) * 100) : 0;
            $inscription->update(['progression' => $progression]);
            return false;
        }

        // 2. Vérifier que tous les quizzes de la formation sont réussis
        $quizzes = \App\Models\Quiz::where('formation_id', $formation->id)
            ->where('active', true)
            ->get();

        $bestScore = null;
        foreach ($quizzes as $quiz) {
            if (!$quiz->userHasPassed($user->id)) {
                // Un quiz n'est pas encore réussi
                $inscription->update(['progression' => 100]);
                return false;
            }
            $quizBestScore = $quiz->getUserBestScore($user->id);
            if ($bestScore === null || $quizBestScore > $bestScore) {
                $bestScore = $quizBestScore;
            }
        }

        // La formation est terminée !
        $inscription->update([
            'statut' => 'termine',
            'progression' => 100,
            'date_fin' => now(),
        ]);

        // Envoyer l'alerte email à l'admin
        try {
            Mail::to(config('mail.from.address'))->queue(new FormationCompleted($inscription, $bestScore));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur envoi email fin formation: ' . $e->getMessage());
        }

        return true;
    }

    /**
     * Demander la génération du certificat
     */
    public function demanderCertificat(Formation $formation)
    {
        $user = auth()->user();

        $inscription = \App\Models\FormationInscription::where('user_id', $user->id)
            ->where('formation_id', $formation->id)
            ->where('paiement_valide', true)
            ->where('statut', 'termine')
            ->first();

        if (!$inscription) {
            return back()->with('error', 'Vous devez terminer la formation avant de demander un certificat.');
        }

        if ($inscription->certificat) {
            return back()->with('info', 'Votre certificat a déjà été généré.');
        }

        if ($inscription->certificat_demande) {
            return back()->with('info', 'Votre demande de certificat est déjà en cours de traitement.');
        }

        $inscription->update([
            'certificat_demande' => true,
            'certificat_demande_at' => now(),
        ]);

        return back()->with('success', 'Votre demande de certificat a été envoyée ! L\'équipe administrative va le générer prochainement.');
    }
}
