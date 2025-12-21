<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuestionOption;
use Illuminate\Http\Request;

class QuizQuestionController extends Controller
{
    /**
     * Store a new question for a quiz
     */
    public function store(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'type' => 'required|in:qcm,vrai_faux,choix_multiple',
            'points' => 'required|integer|min:1',
            'explication' => 'nullable|string',
            'options' => 'required|array|min:2',
            'options.*.option_text' => 'required|string',
            'options.*.is_correct' => 'required|boolean',
        ]);

        // Validation spécifique par type
        $correctCount = collect($validated['options'])->where('is_correct', true)->count();

        if ($validated['type'] === 'qcm' || $validated['type'] === 'vrai_faux') {
            if ($correctCount !== 1) {
                return response()->json([
                    'error' => 'Pour un QCM ou Vrai/Faux, il doit y avoir exactement une bonne réponse.'
                ], 422);
            }
        } else {
            if ($correctCount < 1) {
                return response()->json([
                    'error' => 'Pour un choix multiple, il doit y avoir au moins une bonne réponse.'
                ], 422);
            }
        }

        // Déterminer l'ordre
        $ordre = $quiz->questions()->max('ordre') + 1;

        $question = $quiz->questions()->create([
            'question' => $validated['question'],
            'type' => $validated['type'],
            'points' => $validated['points'],
            'explication' => $validated['explication'],
            'ordre' => $ordre,
        ]);

        // Créer les options
        foreach ($validated['options'] as $index => $optionData) {
            $question->options()->create([
                'option_text' => $optionData['option_text'],
                'is_correct' => $optionData['is_correct'],
                'ordre' => $index + 1,
            ]);
        }

        $question->load('options');

        return response()->json([
            'success' => true,
            'question' => $question,
            'message' => 'Question ajoutée avec succès.'
        ]);
    }

    /**
     * Update a question
     */
    public function update(Request $request, QuizQuestion $question)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'type' => 'required|in:qcm,vrai_faux,choix_multiple',
            'points' => 'required|integer|min:1',
            'explication' => 'nullable|string',
            'options' => 'required|array|min:2',
            'options.*.option_text' => 'required|string',
            'options.*.is_correct' => 'required|boolean',
        ]);

        // Validation spécifique par type
        $correctCount = collect($validated['options'])->where('is_correct', true)->count();

        if ($validated['type'] === 'qcm' || $validated['type'] === 'vrai_faux') {
            if ($correctCount !== 1) {
                return response()->json([
                    'error' => 'Pour un QCM ou Vrai/Faux, il doit y avoir exactement une bonne réponse.'
                ], 422);
            }
        } else {
            if ($correctCount < 1) {
                return response()->json([
                    'error' => 'Pour un choix multiple, il doit y avoir au moins une bonne réponse.'
                ], 422);
            }
        }

        $question->update([
            'question' => $validated['question'],
            'type' => $validated['type'],
            'points' => $validated['points'],
            'explication' => $validated['explication'],
        ]);

        // Supprimer les anciennes options et créer les nouvelles
        $question->options()->delete();

        foreach ($validated['options'] as $index => $optionData) {
            $question->options()->create([
                'option_text' => $optionData['option_text'],
                'is_correct' => $optionData['is_correct'],
                'ordre' => $index + 1,
            ]);
        }

        $question->load('options');

        return response()->json([
            'success' => true,
            'question' => $question,
            'message' => 'Question mise à jour avec succès.'
        ]);
    }

    /**
     * Delete a question
     */
    public function destroy(QuizQuestion $question)
    {
        $question->delete();

        return response()->json([
            'success' => true,
            'message' => 'Question supprimée avec succès.'
        ]);
    }

    /**
     * Update question order
     */
    public function reorder(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'questions' => 'required|array',
            'questions.*.id' => 'required|exists:quiz_questions,id',
            'questions.*.ordre' => 'required|integer|min:1',
        ]);

        foreach ($validated['questions'] as $questionData) {
            QuizQuestion::where('id', $questionData['id'])
                ->where('quiz_id', $quiz->id)
                ->update(['ordre' => $questionData['ordre']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Ordre des questions mis à jour.'
        ]);
    }
}
