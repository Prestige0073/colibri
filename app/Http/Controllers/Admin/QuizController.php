<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Formation;
use App\Models\Module;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Quiz::with(['formation', 'module', 'questions'])->latest()->paginate(15);
        return view('admin.quiz.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $formations = Formation::where('active', true)->orderBy('titre')->get();
        $modules = Module::orderBy('titre')->get();
        return view('admin.quiz.create', compact('formations', 'modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'formation_id' => 'nullable|exists:formations,id',
            'module_id' => 'nullable|exists:modules,id',
            'duree_minutes' => 'nullable|integer|min:1',
            'note_passage' => 'required|integer|min:0|max:100',
            'nombre_tentatives' => 'required|integer|min:1|max:10',
            'afficher_reponses' => 'boolean',
            'melanger_questions' => 'boolean',
            'melanger_options' => 'boolean',
            'active' => 'boolean',
        ]);

        // S'assurer qu'au moins un lien existe (formation OU module)
        if (!$request->formation_id && !$request->module_id) {
            return back()->withErrors(['formation_id' => 'Vous devez lier le quiz à une formation ou un module.'])->withInput();
        }

        $quiz = Quiz::create($validated);

        return redirect()->route('admin.quizzes.show', $quiz->id)
            ->with('success', 'Quiz créé avec succès. Ajoutez maintenant des questions.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        $quiz->load(['questions.options', 'formation', 'module']);
        return view('admin.quiz.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        $formations = Formation::where('active', true)->orderBy('titre')->get();
        $modules = Module::orderBy('titre')->get();
        return view('admin.quiz.edit', compact('quiz', 'formations', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'formation_id' => 'nullable|exists:formations,id',
            'module_id' => 'nullable|exists:modules,id',
            'duree_minutes' => 'nullable|integer|min:1',
            'note_passage' => 'required|integer|min:0|max:100',
            'nombre_tentatives' => 'required|integer|min:1|max:10',
            'afficher_reponses' => 'boolean',
            'melanger_questions' => 'boolean',
            'melanger_options' => 'boolean',
            'active' => 'boolean',
        ]);

        // S'assurer qu'au moins un lien existe
        if (!$request->formation_id && !$request->module_id) {
            return back()->withErrors(['formation_id' => 'Vous devez lier le quiz à une formation ou un module.'])->withInput();
        }

        $quiz->update($validated);

        return redirect()->route('admin.quizzes.show', $quiz->id)
            ->with('success', 'Quiz mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz supprimé avec succès.');
    }
}
