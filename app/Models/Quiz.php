<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'formation_id',
        'titre',
        'description',
        'duree_minutes',
        'note_passage',
        'nombre_tentatives',
        'afficher_reponses',
        'melanger_questions',
        'melanger_options',
        'active',
    ];

    protected $casts = [
        'afficher_reponses' => 'boolean',
        'melanger_questions' => 'boolean',
        'melanger_options' => 'boolean',
        'active' => 'boolean',
    ];

    // Relations
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('ordre');
    }

    public function attempts()
    {
        return $this->hasMany(UserQuizAttempt::class);
    }

    // Méthodes utilitaires
    public function getTotalPointsAttribute()
    {
        return $this->questions->sum('points');
    }

    public function userCanAttempt($userId)
    {
        $attempts = $this->attempts()->where('user_id', $userId)->count();
        return $attempts < $this->nombre_tentatives;
    }

    public function getUserAttemptsCount($userId)
    {
        return $this->attempts()->where('user_id', $userId)->count();
    }

    public function getUserBestScore($userId)
    {
        return $this->attempts()
            ->where('user_id', $userId)
            ->max('score');
    }
}
