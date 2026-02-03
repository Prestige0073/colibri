<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_predefined',
    ];

    protected $casts = [
        'is_predefined' => 'boolean',
    ];

    /**
     * Les permissions associées à ce rôle
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    /**
     * Les administrateurs ayant ce rôle
     */
    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class);
    }

    /**
     * Vérifier si le rôle a une permission spécifique
     */
    public function hasPermission(string $module, string $action): bool
    {
        return $this->permissions()
            ->where('module', $module)
            ->where('action', $action)
            ->exists();
    }

    /**
     * Assigner des permissions au rôle
     */
    public function givePermissions(array $permissionIds): void
    {
        $this->permissions()->sync($permissionIds);
    }
}
