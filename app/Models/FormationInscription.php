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
        'certificat_demande',
        'certificat_demande_at',
    ];

    protected $casts = [
        'montant_paye' => 'decimal:2',
        'progression' => 'integer',
        'paiement_valide' => 'boolean',
        'certificat_demande' => 'boolean',
        'date_inscription' => 'datetime',
        'date_fin' => 'datetime',
        'certificat_demande_at' => 'datetime',
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
