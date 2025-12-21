<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'formation_inscription_id',
        'formation_id',
        'user_id',
        'note',
        'nombre_questions',
        'reponses_correctes',
        'reponses',
        'date_evaluation',
        'reussie',
    ];

    protected $casts = [
        'note' => 'integer',
        'nombre_questions' => 'integer',
        'reponses_correctes' => 'integer',
        'reponses' => 'array',
        'reussie' => 'boolean',
        'date_evaluation' => 'datetime',
    ];

    public function inscription()
    {
        return $this->belongsTo(FormationInscription::class, 'formation_inscription_id');
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
