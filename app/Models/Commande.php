<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    /**
     * Statuts valides pour une commande
     */
    const STATUT_PENDING = 'pending';           // En attente de paiement
    const STATUT_CONFIRMED = 'confirmed';       // Commande confirmée (payée)
    const STATUT_EN_PREPARATION = 'en_preparation'; // En préparation
    const STATUT_EN_LIVRAISON = 'en_livraison'; // En cours de livraison
    const STATUT_LIVRE = 'livre';               // Livré
    const STATUT_ANNULE = 'annule';             // Annulé

    protected $fillable = [
        'user_id', 'nom', 'telephone', 'adresse', 'total', 'statut', 'idempotency_key',
        'paiement_valide', 'reference_paiement', 'payment_method'
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'paiement_valide' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(CommandeItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Retourne le libellé du statut en français pour affichage.
     */
    public function getStatutLabelAttribute()
    {
        $map = [
            self::STATUT_PENDING => 'En attente de paiement',
            self::STATUT_CONFIRMED => 'Commande confirmée',
            self::STATUT_EN_PREPARATION => 'En préparation',
            self::STATUT_EN_LIVRAISON => 'En livraison',
            self::STATUT_LIVRE => 'Livré',
            self::STATUT_ANNULE => 'Annulé',
        ];

        $key = $this->attributes['statut'] ?? null;
        if (!$key) return '—';

        return $map[$key] ?? ucfirst(str_replace(['_', '-'], ' ', $key));
    }

    /**
     * Retourne la classe CSS pour le badge de statut
     */
    public function getStatutBadgeClassAttribute()
    {
        $map = [
            self::STATUT_PENDING => 'bg-secondary',
            self::STATUT_CONFIRMED => 'bg-success',
            self::STATUT_EN_PREPARATION => 'bg-warning text-dark',
            self::STATUT_EN_LIVRAISON => 'bg-info',
            self::STATUT_LIVRE => 'bg-success',
            self::STATUT_ANNULE => 'bg-danger',
        ];

        $key = $this->attributes['statut'] ?? null;
        return $map[$key] ?? 'bg-secondary';
    }

    /**
     * Vérifie si la commande est payée
     */
    public function isPaid()
    {
        return $this->paiement_valide === true;
    }
}
