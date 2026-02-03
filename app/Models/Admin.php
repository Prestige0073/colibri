<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'role_id',
        'is_super_admin',
        'status',
        'last_login_at',
        'created_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_super_admin' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    /**
     * Le rôle de l'administrateur
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * L'admin qui a créé cet admin
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    /**
     * Les admins créés par cet admin
     */
    public function createdAdmins()
    {
        return $this->hasMany(Admin::class, 'created_by');
    }

    /**
     * Les logs d'audit de cet admin
     */
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    /**
     * Vérifier si l'admin est super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin === true;
    }

    /**
     * Vérifier si l'admin est actif
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Vérifier si l'admin a une permission
     */
    public function hasPermission(string $module, string $action): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if (!$this->role) {
            return false;
        }

        return $this->role->hasPermission($module, $action);
    }

    /**
     * Obtenir toutes les permissions de l'admin
     */
    public function getAllPermissions()
    {
        if ($this->isSuperAdmin()) {
            return Permission::all();
        }

        return $this->role ? $this->role->permissions : collect();
    }

    /**
     * Mutateur pour le mot de passe
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }

    /**
     * Scope pour les admins actifs
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope pour les admins suspendus
     */
    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }

    /**
     * Scope pour les semi-admins (non super admin)
     */
    public function scopeSemiAdmins($query)
    {
        return $query->where('is_super_admin', false);
    }
}
