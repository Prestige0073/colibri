<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormationInscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'formation_id',
        'montant_paye',
        'statut',
        'progression',
        'date_inscription',
        'date_fin',
        'paiement_valide',
        'reference_paiement',
    ];

    protected $casts = [
        'montant_paye' => 'decimal:2',
        'progression' => 'integer',
        'paiement_valide' => 'boolean',
        'date_inscription' => 'datetime',
        'date_fin' => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function evaluation()
    {
        return $this->hasOne(Evaluation::class);
    }

    public function certificat()
    {
        return $this->hasOne(Certificat::class);
    }
}
