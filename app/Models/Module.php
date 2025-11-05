<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Formation;
use App\Models\Video;
use App\Models\Suivi;

class Module extends Model
{
    use HasFactory;
    protected $fillable = [
        'formation_id', 'titre', 'description', 'ordre', 'image', 'video_path', 'video_url'
    ];
    public function formation() {
        return $this->belongsTo(Formation::class);
    }
    public function videos() {
        return $this->hasMany(Video::class);
    }
    public function suivis() {
        return $this->hasMany(Suivi::class);
    }
}
