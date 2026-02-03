<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'module',
        'action',
        'description',
    ];

    /**
     * Les rôles ayant cette permission
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }

    /**
     * Grouper les permissions par module
     */
    public static function groupedByModule(): array
    {
        return static::all()->groupBy('module')->toArray();
    }

    /**
     * Obtenir toutes les permissions pour un module spécifique
     */
    public static function forModule(string $module)
    {
        return static::where('module', $module)->get();
    }
}
