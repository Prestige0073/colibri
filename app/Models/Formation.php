<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module;
use App\Models\Achat;
use App\Models\Examen;
use App\Models\Certification;

class Formation extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre', 'description', 'prix', 'duree', 'niveau', 'image'
    ];
    public function modules() {
        return $this->hasMany(Module::class);
    }
    public function achats() {
        return $this->hasMany(Achat::class);
    }
    public function examens() {
        return $this->hasMany(Examen::class);
    }
    public function certifications() {
        return $this->hasMany(Certification::class);
    }
}
