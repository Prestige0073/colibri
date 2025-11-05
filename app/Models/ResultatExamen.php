<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Examen;

class ResultatExamen extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'examen_id', 'score', 'date_passage', 'reussi'
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function examen() {
        return $this->belongsTo(Examen::class);
    }
}
