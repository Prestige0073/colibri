<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Formation;
use App\Models\ResultatExamen;

class Examen extends Model
{
    use HasFactory;
    protected $fillable = [
        'formation_id', 'titre', 'description', 'date'
    ];
    public function formation() {
        return $this->belongsTo(Formation::class);
    }
    public function resultats() {
        return $this->hasMany(ResultatExamen::class);
    }
}
