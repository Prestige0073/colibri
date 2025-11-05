<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Module;

class Suivi extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'module_id', 'date_debut', 'date_fin', 'statut', 'score'
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function module() {
        return $this->belongsTo(Module::class);
    }
}
