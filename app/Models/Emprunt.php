<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Emprunt extends Model
{
    /**
     * Statuts valides pour un emprunt
     */
    const STATUT_EN_ATTENTE = 'en_attente';
    const STATUT_EN_COURS = 'en_cours';
    const STATUT_RETOURNE = 'retourne';
    const STATUT_EN_RETARD = 'en_retard';
    const STATUT_REFUSE = 'refuse';

    protected $fillable = [
        'user_id',
        'livre_id',
        'date_emprunt',
        'date_retour',
        'statut',
        'valide_par',
        'valide_le',
        'access_expires_at',
    ];

    protected $casts = [
        'date_emprunt' => 'date',
        'date_retour' => 'date',
        'valide_le' => 'datetime',
        'access_expires_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function livre(): BelongsTo
    {
        return $this->belongsTo(Catalogue::class, 'livre_id');
    }

    public function validateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'valide_par');
    }

    /**
     * Retourne le libellé du statut en français
     */
    public function getStatutLabelAttribute()
    {
        $map = [
            self::STATUT_EN_ATTENTE => 'En attente',
            self::STATUT_EN_COURS => 'En cours',
            self::STATUT_RETOURNE => 'Retourné',
            self::STATUT_EN_RETARD => 'En retard',
            self::STATUT_REFUSE => 'Refusé',
        ];

        return $map[$this->statut] ?? ucfirst($this->statut);
    }

    /**
     * Retourne la classe CSS pour le badge de statut
     */
    public function getStatutBadgeClassAttribute()
    {
        $map = [
            self::STATUT_EN_ATTENTE => 'bg-warning text-dark',
            self::STATUT_EN_COURS => 'bg-info',
            self::STATUT_RETOURNE => 'bg-success',
            self::STATUT_EN_RETARD => 'bg-danger',
            self::STATUT_REFUSE => 'bg-secondary',
        ];

        return $map[$this->statut] ?? 'bg-secondary';
    }

    /**
     * Vérifie si l'emprunt est actif (accès numérique valide)
     */
    public function isAccessValid()
    {
        if (!$this->access_expires_at) {
            return false;
        }
        return $this->access_expires_at->isFuture();
    }
}
