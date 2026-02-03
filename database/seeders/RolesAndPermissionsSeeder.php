<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Liste des modules et leurs permissions
        $modules = [
            'dashboard' => ['view'],
            'users' => ['view', 'create', 'update', 'delete', 'manage'],
            'catalogue' => ['view', 'create', 'update', 'delete'],
            'emprunts' => ['view', 'create', 'update', 'delete', 'manage'],
            'commandes' => ['view', 'update', 'manage'],
            'formations' => ['view', 'create', 'update', 'delete'],
            'modules' => ['view', 'create', 'update', 'delete'],
            'quizzes' => ['view', 'create', 'update', 'delete'],
            'certifications' => ['view', 'create', 'manage'],
            'contacts' => ['view', 'update', 'delete'],
            'testimonials' => ['view', 'update', 'delete'],
            'blog' => ['view', 'create', 'update', 'delete'],
            'team' => ['view', 'create', 'update', 'delete'],
            'security' => ['view', 'manage'],
        ];

        // Créer toutes les permissions
        $permissions = [];
        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                $permissionName = "{$module}.{$action}";
                $permission = Permission::firstOrCreate([
                    'name' => $permissionName,
                    'module' => $module,
                    'action' => $action,
                ], [
                    'description' => ucfirst($action) . ' ' . $module,
                ]);
                $permissions[$permissionName] = $permission->id;
            }
        }

        // Rôle 1: Éditeur (Création + Modification)
        $editorRole = Role::firstOrCreate([
            'name' => 'Éditeur',
        ], [
            'description' => 'Peut créer et modifier le contenu (catalogue, formations, blog)',
            'is_predefined' => true,
        ]);

        $editorPermissions = [
            'dashboard.view',
            'catalogue.view', 'catalogue.create', 'catalogue.update',
            'formations.view', 'formations.create', 'formations.update',
            'modules.view', 'modules.create', 'modules.update',
            'quizzes.view', 'quizzes.create', 'quizzes.update',
            'blog.view', 'blog.create', 'blog.update',
            'contacts.view',
        ];
        $editorRole->permissions()->sync(array_intersect_key($permissions, array_flip($editorPermissions)));

        // Rôle 2: Modérateur (Lecture + Validation)
        $moderatorRole = Role::firstOrCreate([
            'name' => 'Modérateur',
        ], [
            'description' => 'Peut consulter et modérer le contenu, gérer les emprunts et commandes',
            'is_predefined' => true,
        ]);

        $moderatorPermissions = [
            'dashboard.view',
            'users.view',
            'catalogue.view',
            'emprunts.view', 'emprunts.update', 'emprunts.manage',
            'commandes.view', 'commandes.update', 'commandes.manage',
            'contacts.view', 'contacts.update',
            'testimonials.view', 'testimonials.update',
        ];
        $moderatorRole->permissions()->sync(array_intersect_key($permissions, array_flip($moderatorPermissions)));

        // Rôle 3: Gestionnaire de Formation (E-Learning complet)
        $trainingManagerRole = Role::firstOrCreate([
            'name' => 'Gestionnaire de Formation',
        ], [
            'description' => 'Gestion complète des formations, modules, quiz et certifications',
            'is_predefined' => true,
        ]);

        $trainingPermissions = [
            'dashboard.view',
            'formations.view', 'formations.create', 'formations.update', 'formations.delete',
            'modules.view', 'modules.create', 'modules.update', 'modules.delete',
            'quizzes.view', 'quizzes.create', 'quizzes.update', 'quizzes.delete',
            'certifications.view', 'certifications.create', 'certifications.manage',
        ];
        $trainingManagerRole->permissions()->sync(array_intersect_key($permissions, array_flip($trainingPermissions)));

        // Rôle 4: Lecteur (Lecture seule - Accès tableau de bord)
        $readerRole = Role::firstOrCreate([
            'name' => 'Lecteur',
        ], [
            'description' => 'Accès en lecture seule à tous les modules',
            'is_predefined' => true,
        ]);

        $readerPermissions = [
            'dashboard.view',
            'users.view',
            'catalogue.view',
            'emprunts.view',
            'commandes.view',
            'formations.view',
            'modules.view',
            'quizzes.view',
            'certifications.view',
            'contacts.view',
            'testimonials.view',
            'blog.view',
            'team.view',
        ];
        $readerRole->permissions()->sync(array_intersect_key($permissions, array_flip($readerPermissions)));

        // Rôle 5: Support Client
        $supportRole = Role::firstOrCreate([
            'name' => 'Support Client',
        ], [
            'description' => 'Gestion des utilisateurs, messages et assistance client',
            'is_predefined' => true,
        ]);

        $supportPermissions = [
            'dashboard.view',
            'users.view', 'users.update',
            'contacts.view', 'contacts.update', 'contacts.delete',
            'testimonials.view', 'testimonials.update',
            'emprunts.view',
            'commandes.view',
        ];
        $supportRole->permissions()->sync(array_intersect_key($permissions, array_flip($supportPermissions)));

        $this->command->info('✓ Rôles et permissions créés avec succès!');
        $this->command->info('✓ ' . Permission::count() . ' permissions créées');
        $this->command->info('✓ ' . Role::where('is_predefined', true)->count() . ' rôles prédéfinis créés');
    }
}
