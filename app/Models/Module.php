<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'formation_id',
        'titre',
        'description',
        'ordre',
        'duree',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'ordre' => 'integer',
    ];

    // Relations
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function contenus()
    {
        return $this->hasMany(ModuleContenu::class)->orderBy('ordre');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class)->orderBy('created_at', 'desc');
    }
}
