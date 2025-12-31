<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\UserQuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Afficher un quiz
     */
    public function show(Quiz $quiz)
    {
        // Vérifier que le quiz est actif
        if (!$quiz->active) {
            abort(403, 'Ce quiz n\'est pas disponible pour le moment.');
        }

        // Charger les questions avec leurs options
        $quiz->load(['questions.options', 'formation', 'module']);

        // Vérifier si l'utilisateur peut encore passer le quiz
        $user = Auth::user();

        // Vérifier si le quiz appartient à une formation et si l'utilisateur a payé
        if ($quiz->formation_id) {
            $inscription = \App\Models\FormationInscription::where('user_id', $user->id)
                ->where('formation_id', $quiz->formation_id)
                ->where('paiement_valide', true)
                ->first();

            if (!$inscription) {
                return redirect()->route('formation.show', $quiz->formation_id)
                    ->with('error', 'Vous devez vous inscrire et valider votre paiement pour accéder aux quiz de cette formation.');
            }
        }

        // Vérifier si le quiz appartient à un module et si tous les contenus sont complétés
        if ($quiz->module_id) {
            $module = \App\Models\Module::find($quiz->module_id);
            if ($module) {
                $allContenusCompleted = true;
                $userProgressions = \App\Models\UserModuleProgression::where('user_id', $user->id)
                    ->where('module_id', $module->id)
                    ->get()
                    ->keyBy('module_contenu_id');

                foreach ($module->contenus as $contenu) {
                    if (!$userProgressions->has($contenu->id) || !$userProgressions[$contenu->id]->completed) {
                        $allContenusCompleted = false;
                        break;
                    }
                }

                if (!$allContenusCompleted) {
                    return redirect()->route('formation.module.show', [$quiz->formation_id, $quiz->module_id])
                        ->with('error', 'Vous devez compléter tous les contenus du module avant d\'accéder au quiz.');
                }
            }
        }

        $attemptsCount = $quiz->attempts()->where('user_id', $user->id)->count();
        $canAttempt = $quiz->userCanAttempt($user->id);
        $bestScore = $quiz->getUserBestScore($user->id);

        // Récupérer les tentatives précédentes
        $previousAttempts = $quiz->attempts()
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('quiz.show', compact('quiz', 'canAttempt', 'attemptsCount', 'bestScore', 'previousAttempts'));
    }

    /**
     * Démarrer une tentative de quiz
     */
    public function start(Request $request, Quiz $quiz)
    {
        $user = Auth::user();

        // Vérifier si le quiz appartient à une formation et si l'utilisateur a payé
        if ($quiz->formation_id) {
            $inscription = \App\Models\FormationInscription::where('user_id', $user->id)
                ->where('formation_id', $quiz->formation_id)
                ->where('paiement_valide', true)
                ->first();

            if (!$inscription) {
                return redirect()->route('formation.show', $quiz->formation_id)
                    ->with('error', 'Vous devez vous inscrire et valider votre paiement pour accéder aux quiz de cette formation.');
            }
        }

        // Vérifier que l'utilisateur peut passer le quiz
        if (!$quiz->userCanAttempt($user->id)) {
            return redirect()->route('quiz.show', $quiz->id)
                ->with('error', 'Vous avez atteint le nombre maximum de tentatives pour ce quiz.');
        }

        // Charger les questions avec mélange si nécessaire
        $questions = $quiz->questions()->with('options')->get();

        if ($quiz->melanger_questions) {
            $questions = $questions->shuffle();
        }

        // Mélanger les options si nécessaire
        if ($quiz->melanger_options) {
            $questions->each(function ($question) {
                $question->setRelation('options', $question->options->shuffle());
            });
        }

        // Créer une nouvelle tentative
        $attempt = UserQuizAttempt::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'debut_at' => now(),
            'reponses' => [],
        ]);

        return view('quiz.take', compact('quiz', 'questions', 'attempt'));
    }

    /**
     * Soumettre les réponses du quiz
     */
    public function submit(Request $request, Quiz $quiz, UserQuizAttempt $attempt)
    {
        $user = Auth::user();

        // Vérifier que cette tentative appartient à l'utilisateur
        if ($attempt->user_id !== $user->id) {
            abort(403);
        }

        // Vérifier que la tentative n'a pas déjà été soumise
        if ($attempt->fin_at) {
            return redirect()->route('quiz.result', [$quiz->id, $attempt->id])
                ->with('info', 'Cette tentative a déjà été soumise.');
        }

        $reponses = $request->input('reponses', []);
        $pointsObtenus = 0;
        $pointsTotal = 0;

        // Charger toutes les questions du quiz
        $questions = $quiz->questions()->with('options')->get();

        // Calculer le score
        foreach ($questions as $question) {
            $pointsTotal += $question->points;

            $selectedOptions = isset($reponses[$question->id]) ? $reponses[$question->id] : null;

            if ($question->isCorrectAnswer($selectedOptions)) {
                $pointsObtenus += $question->points;
            }
        }

        // Calculer le pourcentage
        $score = $pointsTotal > 0 ? ($pointsObtenus / $pointsTotal) * 100 : 0;
        $reussi = $score >= $quiz->note_passage;

        // Calculer la durée
        $debut = $attempt->debut_at;
        $fin = now();
        $dureeSecondes = $debut->diffInSeconds($fin);

        // Mettre à jour la tentative
        $attempt->update([
            'reponses' => $reponses,
            'score' => $score,
            'points_obtenus' => $pointsObtenus,
            'points_total' => $pointsTotal,
            'reussi' => $reussi,
            'fin_at' => $fin,
            'duree_secondes' => $dureeSecondes,
        ]);

        return redirect()->route('quiz.result', [$quiz->id, $attempt->id]);
    }

    /**
     * Afficher les résultats d'une tentative
     */
    public function result(Quiz $quiz, UserQuizAttempt $attempt)
    {
        $user = Auth::user();

        // Vérifier que cette tentative appartient à l'utilisateur
        if ($attempt->user_id !== $user->id) {
            abort(403);
        }

        // Charger les questions avec options
        $quiz->load(['questions.options']);

        $questions = $quiz->questions;
        $userAnswers = $attempt->reponses;

        return view('quiz.result', compact('quiz', 'attempt', 'questions', 'userAnswers'));
    }
}
