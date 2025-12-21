<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct',
        'ordre',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    // Relations
    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }
}
