<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question',
        'type',
        'points',
        'ordre',
        'explication',
    ];

    // Relations
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class, 'question_id')->orderBy('ordre');
    }

    // Méthodes utilitaires
    public function getCorrectOptions()
    {
        return $this->options()->where('is_correct', true)->get();
    }

    public function getCorrectOptionIds()
    {
        return $this->options()->where('is_correct', true)->pluck('id')->toArray();
    }

    public function isCorrectAnswer($selectedOptions)
    {
        $correctIds = $this->getCorrectOptionIds();

        if ($this->type === 'qcm' || $this->type === 'vrai_faux') {
            // Une seule bonne réponse
            return is_array($selectedOptions)
                ? in_array($correctIds[0] ?? null, $selectedOptions)
                : $selectedOptions == ($correctIds[0] ?? null);
        } else {
            // Choix multiple - toutes les bonnes réponses doivent être sélectionnées
            if (!is_array($selectedOptions)) {
                $selectedOptions = [$selectedOptions];
            }
            sort($correctIds);
            sort($selectedOptions);
            return $correctIds === array_map('intval', $selectedOptions);
        }
    }
}
