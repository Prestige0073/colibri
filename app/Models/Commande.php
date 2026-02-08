<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    /**
     * ═══════════════════════════════════════════════════════
     * ACHAT EN LIGNE (KKiaPay, PayPal, etc.) - Paiement immédiat
     * L'utilisateur a déjà payé → achat terminé, documents accessibles
     * ═══════════════════════════════════════════════════════
     */
    const STATUT_PAID = 'paid';                 // Achat payé et terminé

    /**
     * ═══════════════════════════════════════════════════════
     * COMMANDE À LA LIVRAISON (COD) - Cycle de livraison
     * L'utilisateur n'a pas encore payé → livraison puis encaissement
     * ═══════════════════════════════════════════════════════
     */
    const STATUT_PENDING = 'pending';           // En attente (commande reçue)
    const STATUT_EN_PREPARATION = 'en_preparation'; // En préparation
    const STATUT_EN_LIVRAISON = 'en_livraison'; // En cours de livraison
    const STATUT_LIVRE = 'livre';               // Livré et payé à réception

    /**
     * COMMUN
     */
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
            self::STATUT_PAID => 'Payé',
            self::STATUT_PENDING => 'En attente',
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
            self::STATUT_PAID => 'bg-success',
            self::STATUT_PENDING => 'bg-warning text-dark',
            self::STATUT_EN_PREPARATION => 'bg-info',
            self::STATUT_EN_LIVRAISON => 'bg-primary',
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

    /**
     * Vérifie si c'est un achat en ligne (déjà payé)
     */
    public function isOnlinePayment()
    {
        return in_array($this->payment_method, ['kkiapay', 'paypal']);
    }

    /**
     * Vérifie si c'est une commande à la livraison (COD)
     */
    public function isCOD()
    {
        return $this->payment_method === 'livraison' || $this->payment_method === null;
    }
}
