<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModuleProgression extends Model
{
    use HasFactory;

    protected $table = 'user_module_progression';

    protected $fillable = [
        'user_id',
        'module_id',
        'module_contenu_id',
        'completed',
        'completed_at',
        'video_watch_percentage',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'completed_at' => 'datetime',
        'video_watch_percentage' => 'decimal:2',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function contenu()
    {
        return $this->belongsTo(ModuleContenu::class, 'module_contenu_id');
    }
}
