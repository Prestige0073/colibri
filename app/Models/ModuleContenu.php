<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleContenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'type',
        'titre',
        'description',
        'fichier',
        'contenu',
        'duree',
        'ordre',
    ];

    protected $casts = [
        'ordre' => 'integer',
    ];

    // Relations
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    // Accesseurs
    public function getFichierUrlAttribute()
    {
        return $this->fichier ? asset($this->fichier) : null;
    }
}
