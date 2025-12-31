<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificat extends Model
{
    use HasFactory;

    protected $fillable = [
        'formation_inscription_id',
        'user_id',
        'nom_manuel',
        'email_manuel',
        'formation_id',
        'numero_certificat',
        'fichier_pdf',
        'note_obtenue',
        'date_delivrance',
        'envoye_email',
        'date_envoi_email',
        'statut',
    ];

    protected $casts = [
        'note_obtenue' => 'integer',
        'envoye_email' => 'boolean',
        'date_delivrance' => 'datetime',
        'date_envoi_email' => 'datetime',
    ];

    public function inscription()
    {
        return $this->belongsTo(FormationInscription::class, 'formation_inscription_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
}
