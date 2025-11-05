<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    use HasFactory;

    protected $fillable = [
    'titre',
    'auteur',
    'categorie',
    'prix',
    'quantite',
    'type',
    'type_categorie',
    'resumer',
    'image',
    'pdf',
    ];
}
