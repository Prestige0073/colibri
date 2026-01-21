<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'poste',
        'bio',
        'photo',
        'email',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];
}
