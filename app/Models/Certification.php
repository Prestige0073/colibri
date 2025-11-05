<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Formation;

class Certification extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'formation_id', 'date_obtention', 'code_certificat', 'validite'
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function formation() {
        return $this->belongsTo(Formation::class);
    }
}
