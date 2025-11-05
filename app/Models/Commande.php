<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nom', 'telephone', 'adresse', 'total', 'statut', 'idempotency_key'
    ];

    public function items()
    {
        return $this->hasMany(CommandeItem::class);
    }

    /**
     * Retourne le libellé du statut en français pour affichage.
     * Exemple: 'pending' => 'En préparation'
     */
    public function getStatutLabelAttribute()
    {
        $map = [
            'pending' => 'En préparation',
            'en_livraison' => 'En livraison',
            'livre' => 'Livré',
            'annule' => 'Annulé',
        ];

        $key = $this->attributes['statut'] ?? null;
        if (!$key) return '—';

        return $map[$key] ?? ucfirst(str_replace(['_', '-'], ' ', $key));
    }
}
