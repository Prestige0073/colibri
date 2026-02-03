<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'objectifs',
        'image',
        'prix',
        'est_gratuit',
        'duree',
        'nombre_modules',
        'active',
        'categorie',
        'prerequis',
        'note_minimale_certification',
        'inscrits_count',
    ];

    protected $casts = [
        'active' => 'boolean',
        'est_gratuit' => 'boolean',
        'prix' => 'decimal:2',
        'nombre_modules' => 'integer',
        'note_minimale_certification' => 'integer',
        'inscrits_count' => 'integer',
    ];

    // Relations
    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('ordre');
    }

    public function inscriptions()
    {
        return $this->hasMany(FormationInscription::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function certificats()
    {
        return $this->hasMany(Certificat::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class)->orderBy('created_at', 'desc');
    }

    // Accesseurs
    public function getImageUrlAttribute()
    {
        return $this->image ? asset($this->image) : asset('img/default-formation.jpg');
    }

    public function getIsActiveAttribute()
    {
        return $this->active;
    }
}
