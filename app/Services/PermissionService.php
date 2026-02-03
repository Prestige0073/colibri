<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class PermissionService
{
    /**
     * Mapping des routes vers les permissions requises
     */
    protected static $routePermissions = [
        // Dashboard
        'admin.dashboard' => ['dashboard', 'view'],

        // Users
        'admin.users.index' => ['users', 'view'],
        'admin.users.create' => ['users', 'create'],
        'admin.users.store' => ['users', 'create'],
        'admin.users.show' => ['users', 'view'],
        'admin.users.edit' => ['users', 'update'],
        'admin.users.update' => ['users', 'update'],
        'admin.users.destroy' => ['users', 'delete'],
        'admin.users.change-role' => ['users', 'manage'],
        'admin.users.toggle-block' => ['users', 'manage'],

        // Catalogue
        'admin.catalogue.index' => ['catalogue', 'view'],
        'admin.catalogue.create' => ['catalogue', 'create'],
        'admin.catalogue.store' => ['catalogue', 'create'],
        'admin.catalogue.show' => ['catalogue', 'view'],
        'admin.catalogue.edit' => ['catalogue', 'update'],
        'admin.catalogue.update' => ['catalogue', 'update'],
        'admin.catalogue.destroy' => ['catalogue', 'delete'],

        // Emprunts
        'admin.emprunts.index' => ['emprunts', 'view'],
        'admin.emprunts.create' => ['emprunts', 'create'],
        'admin.emprunts.store' => ['emprunts', 'create'],
        'admin.emprunts.show' => ['emprunts', 'view'],
        'admin.emprunts.edit' => ['emprunts', 'update'],
        'admin.emprunts.update' => ['emprunts', 'update'],
        'admin.emprunts.destroy' => ['emprunts', 'delete'],
        'admin.emprunts.updateStatus' => ['emprunts', 'manage'],
        'admin.emprunts.valider' => ['emprunts', 'manage'],
        'admin.emprunts.rejeter' => ['emprunts', 'manage'],

        // Commandes
        'admin.commandes.index' => ['commandes', 'view'],
        'admin.commandes.show' => ['commandes', 'view'],
        'admin.commandes.updateStatus' => ['commandes', 'update'],
        'admin.commandes.bulkStatus' => ['commandes', 'manage'],

        // Formations
        'admin.formations.index' => ['formations', 'view'],
        'admin.formations.create' => ['formations', 'create'],
        'admin.formations.store' => ['formations', 'create'],
        'admin.formations.show' => ['formations', 'view'],
        'admin.formations.edit' => ['formations', 'update'],
        'admin.formations.update' => ['formations', 'update'],
        'admin.formations.destroy' => ['formations', 'delete'],

        // Modules
        'admin.modules.index' => ['modules', 'view'],
        'admin.modules.create' => ['modules', 'create'],
        'admin.modules.store' => ['modules', 'create'],
        'admin.modules.show' => ['modules', 'view'],
        'admin.modules.edit' => ['modules', 'update'],
        'admin.modules.update' => ['modules', 'update'],
        'admin.modules.destroy' => ['modules', 'delete'],

        // Quizzes
        'admin.quizzes.index' => ['quizzes', 'view'],
        'admin.quizzes.create' => ['quizzes', 'create'],
        'admin.quizzes.store' => ['quizzes', 'create'],
        'admin.quizzes.show' => ['quizzes', 'view'],
        'admin.quizzes.edit' => ['quizzes', 'update'],
        'admin.quizzes.update' => ['quizzes', 'update'],
        'admin.quizzes.destroy' => ['quizzes', 'delete'],

        // Certifications
        'admin.certifications.index' => ['certifications', 'view'],
        'admin.certifications.generate' => ['certifications', 'create'],
        'admin.certifications.download' => ['certifications', 'view'],
        'admin.certifications.regenerate' => ['certifications', 'manage'],
        'admin.certifications.send-email' => ['certifications', 'manage'],

        // Contacts
        'admin.contacts.index' => ['contacts', 'view'],
        'admin.contacts.show' => ['contacts', 'view'],
        'admin.contacts.edit' => ['contacts', 'update'],
        'admin.contacts.update' => ['contacts', 'update'],
        'admin.contacts.destroy' => ['contacts', 'delete'],
        'admin.contacts.toggleRead' => ['contacts', 'update'],

        // Testimonials
        'admin.testimonials.index' => ['testimonials', 'view'],
        'admin.testimonials.approve' => ['testimonials', 'update'],
        'admin.testimonials.reject' => ['testimonials', 'update'],
        'admin.testimonials.pending' => ['testimonials', 'update'],
        'admin.testimonials.destroy' => ['testimonials', 'delete'],

        // Blog
        'admin.blog.index' => ['blog', 'view'],
        'admin.blog.create' => ['blog', 'create'],
        'admin.blog.store' => ['blog', 'create'],
        'admin.blog.show' => ['blog', 'view'],
        'admin.blog.edit' => ['blog', 'update'],
        'admin.blog.update' => ['blog', 'update'],
        'admin.blog.destroy' => ['blog', 'delete'],

        // Team
        'admin.team.index' => ['team', 'view'],
        'admin.team.create' => ['team', 'create'],
        'admin.team.store' => ['team', 'create'],
        'admin.team.edit' => ['team', 'update'],
        'admin.team.update' => ['team', 'update'],
        'admin.team.destroy' => ['team', 'delete'],

        // Security
        'admin.security.index' => ['security', 'view'],
        'admin.security.unblock' => ['security', 'manage'],
        'admin.security.block' => ['security', 'manage'],

        // Admins (Super Admin only)
        'admin.admins.index' => 'super_admin_only',
        'admin.admins.create' => 'super_admin_only',
        'admin.admins.store' => 'super_admin_only',
        'admin.admins.show' => 'super_admin_only',
        'admin.admins.edit' => 'super_admin_only',
        'admin.admins.update' => 'super_admin_only',
        'admin.admins.destroy' => 'super_admin_only',
    ];

    /**
     * Vérifier si l'admin a accès à une route
     */
    public static function canAccessRoute(string $routeName): bool
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return false;
        }

        // Super admin a accès à tout
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Si la route n'est pas dans le mapping, autoriser par défaut
        if (!isset(self::$routePermissions[$routeName])) {
            return true;
        }

        $permission = self::$routePermissions[$routeName];

        // Si c'est réservé au super admin
        if ($permission === 'super_admin_only') {
            return false;
        }

        // Vérifier la permission
        if (is_array($permission)) {
            [$module, $action] = $permission;
            return $admin->hasPermission($module, $action);
        }

        return false;
    }

    /**
     * Obtenir le message d'erreur pour une route non autorisée
     */
    public static function getAccessDeniedMessage(string $routeName): string
    {
        $permission = self::$routePermissions[$routeName] ?? null;

        if ($permission === 'super_admin_only') {
            return 'Cette fonctionnalité est réservée aux Super Administrateurs uniquement.';
        }

        if (is_array($permission)) {
            [$module, $action] = $permission;
            $actionText = [
                'view' => 'consulter',
                'create' => 'créer',
                'update' => 'modifier',
                'delete' => 'supprimer',
                'manage' => 'gérer',
            ][$action] ?? $action;

            return "Vous n'avez pas la permission de {$actionText} les données du module \"{$module}\".";
        }

        return "Vous n'avez pas la permission d'accéder à cette page.";
    }

    /**
     * Vérifier si un module est accessible
     */
    public static function canAccessModule(string $module): bool
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin || !$admin->isActive()) {
            return false;
        }

        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Vérifier si l'admin a au moins une permission pour ce module
        return $admin->hasPermission($module, 'view');
    }
}
