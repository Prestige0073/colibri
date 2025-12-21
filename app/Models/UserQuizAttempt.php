<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'reponses',
        'score',
        'points_obtenus',
        'points_total',
        'reussi',
        'debut_at',
        'fin_at',
        'duree_secondes',
    ];

    protected $casts = [
        'reponses' => 'array',
        'score' => 'decimal:2',
        'points_obtenus' => 'decimal:2',
        'points_total' => 'decimal:2',
        'reussi' => 'boolean',
        'debut_at' => 'datetime',
        'fin_at' => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Méthodes utilitaires
    public function getDureeFormatted()
    {
        if (!$this->duree_secondes) {
            return 'N/A';
        }

        $minutes = floor($this->duree_secondes / 60);
        $secondes = $this->duree_secondes % 60;

        if ($minutes > 0) {
            return "{$minutes}min {$secondes}s";
        }
        return "{$secondes}s";
    }

    public function getScorePercentage()
    {
        return round($this->score, 2) . '%';
    }

    public function isPassed()
    {
        return $this->reussi;
    }
}
