<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module;

class Video extends Model
{
    use HasFactory;
    protected $fillable = [
        'module_id', 'titre', 'description', 'url', 'ordre'
    ];
    public function module() {
        return $this->belongsTo(Module::class);
    }
}
