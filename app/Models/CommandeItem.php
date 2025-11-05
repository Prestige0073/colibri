<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandeItem extends Model
{
    protected $fillable = [
        'commande_id', 'catalogue_id', 'titre', 'quantite', 'prix'
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
