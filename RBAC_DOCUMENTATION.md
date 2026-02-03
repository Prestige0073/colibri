# 👑 Documentation Système RBAC - Colibri Littéraire

## 📋 Table des Matières
1. [Vue d'ensemble](#vue-densemble)
2. [Architecture](#architecture)
3. [Installation](#installation)
4. [Utilisation](#utilisation)
5. [Rôles Prédéfinis](#rôles-prédéfinis)
6. [Permissions](#permissions)
7. [API & Contrôleurs](#api--contrôleurs)
8. [Sécurité](#sécurité)

---

## 🎯 Vue d'ensemble

Le système RBAC (Role-Based Access Control) de Colibri Littéraire permet de gérer des administrateurs avec des permissions granulaires. Le **Super Admin** peut créer et gérer des **Semi-Admins** avec des rôles personnalisés ou prédéfinis.

### Hiérarchie
```
Super Admin (niveau 0)
    └── Accès total à tous les modules
    └── Seul habilité à gérer les Semi-Admins
    └── Ne peut pas être supprimé

Semi-Admin (niveau 1+)
    └── Permissions définies par le Super Admin
    └── Rôle prédéfini ou personnalisé
    └── Peut être désactivé/supprimé
```

---

## 🏗️ Architecture

### Base de Données

#### Tables créées
- `roles` - Rôles (prédéfinis ou personnalisés)
- `permissions` - Permissions par module/action
- `role_permission` - Table pivot rôle-permissions
- `admins` - Administrateurs
- `audit_logs` - Logs des actions sensibles

### Modèles Eloquent
- **Admin** - `App\Models\Admin`
- **Role** - `App\Models\Role`
- **Permission** - `App\Models\Permission`
- **AuditLog** - `App\Models\AuditLog`

### Relations
```php
Admin -> BelongsTo -> Role -> BelongsToMany -> Permissions
Admin -> HasMany -> AuditLogs
```

---

## 🚀 Installation

### 1. Migrations déjà exécutées
```bash
php artisan migrate
```

Les migrations suivantes ont été créées :
- `2026_02_03_162032_create_roles_table.php`
- `2026_02_03_162033_create_permissions_table.php`
- `2026_02_03_162034_create_role_permission_table.php`
- `2026_02_03_162034_create_admins_table.php`
- `2026_02_03_162035_create_audit_logs_table.php`

### 2. Seeder exécuté
```bash
php artisan db:seed --class=RolesAndPermissionsSeeder
```

Résultat :
- ✅ 49 permissions créées
- ✅ 5 rôles prédéfinis créés

### 3. Super Admin créé
```
Email: admin@colibri.com
Mot de passe: Password123!
```

---

## 💡 Utilisation

### Créer un nouvel administrateur

1. **Via l'interface**
   - Connectez-vous en tant que Super Admin
   - Allez dans **Gestion > Administrateurs**
   - Cliquez sur **Nouvel Administrateur**
   - Remplissez le formulaire
   - Choisissez :
     - **Rôle prédéfini** : Sélectionnez parmi les 5 rôles existants
     - **Personnalisé** : Cochez les permissions manuellement

2. **Via Tinker**
```php
use App\Models\Admin;
use App\Models\Role;

// Créer un admin avec rôle prédéfini
$role = Role::where('name', 'Éditeur')->first();
Admin::create([
    'name' => 'Jean Dupont',
    'email' => 'jean@example.com',
    'password' => 'Password123!',
    'role_id' => $role->id,
    'status' => 'active',
    'created_by' => 1, // ID du Super Admin
]);
```

### Modifier un administrateur

1. **Changer le statut**
   - `active` : Admin peut se connecter
   - `suspended` : Compte temporairement bloqué
   - `inactive` : Compte désactivé

2. **Modifier les permissions**
   - Vous pouvez changer le rôle prédéfini
   - Ou passer en mode personnalisé et ajuster les permissions

### Vérifier les permissions

```php
$admin = Auth::guard('admin')->user();

// Vérifier une permission
if ($admin->hasPermission('users', 'create')) {
    // Admin peut créer des utilisateurs
}

// Vérifier si super admin
if ($admin->isSuperAdmin()) {
    // Admin a tous les droits
}

// Obtenir toutes les permissions
$permissions = $admin->getAllPermissions();
```

---

## 👥 Rôles Prédéfinis

### 1. 📝 Éditeur
**Description** : Peut créer et modifier le contenu (catalogue, formations, blog)

**Permissions** :
- Dashboard : Voir
- Catalogue : Voir, Créer, Modifier
- Formations : Voir, Créer, Modifier
- Modules : Voir, Créer, Modifier
- Quizzes : Voir, Créer, Modifier
- Blog : Voir, Créer, Modifier
- Messages : Voir

**Cas d'usage** : Créateur de contenu, gestionnaire éditorial

---

### 2. 🛡️ Modérateur
**Description** : Peut consulter et modérer le contenu, gérer les emprunts et commandes

**Permissions** :
- Dashboard : Voir
- Utilisateurs : Voir
- Catalogue : Voir
- Emprunts : Voir, Modifier, Gérer
- Commandes : Voir, Modifier, Gérer
- Messages : Voir, Modifier
- Témoignages : Voir, Modifier

**Cas d'usage** : Modération du site, gestion des transactions

---

### 3. 🎓 Gestionnaire de Formation
**Description** : Gestion complète des formations, modules, quiz et certifications

**Permissions** :
- Dashboard : Voir
- Formations : Voir, Créer, Modifier, Supprimer
- Modules : Voir, Créer, Modifier, Supprimer
- Quizzes : Voir, Créer, Modifier, Supprimer
- Certifications : Voir, Créer, Gérer

**Cas d'usage** : Responsable pédagogique, formateur principal

---

### 4. 👁️ Lecteur
**Description** : Accès en lecture seule à tous les modules

**Permissions** :
- Tous les modules : Voir uniquement

**Cas d'usage** : Audit, consultation, stagiaire admin

---

### 5. 🆘 Support Client
**Description** : Gestion des utilisateurs, messages et assistance client

**Permissions** :
- Dashboard : Voir
- Utilisateurs : Voir, Modifier
- Messages : Voir, Modifier, Supprimer
- Témoignages : Voir, Modifier
- Emprunts : Voir
- Commandes : Voir

**Cas d'usage** : Service client, assistance utilisateurs

---

## 🔑 Permissions

### Structure des permissions

Chaque permission suit le format : `{module}.{action}`

### Modules disponibles

| Module | Actions disponibles |
|--------|---------------------|
| **dashboard** | view |
| **users** | view, create, update, delete, manage |
| **catalogue** | view, create, update, delete |
| **emprunts** | view, create, update, delete, manage |
| **commandes** | view, update, manage |
| **formations** | view, create, update, delete |
| **modules** | view, create, update, delete |
| **quizzes** | view, create, update, delete |
| **certifications** | view, create, manage |
| **contacts** | view, update, delete |
| **testimonials** | view, update, delete |
| **blog** | view, create, update, delete |
| **team** | view, create, update, delete |
| **security** | view, manage |

### Actions

- `view` : Consulter les données
- `create` : Créer de nouvelles entrées
- `update` : Modifier les entrées existantes
- `delete` : Supprimer des entrées
- `manage` : Gestion avancée (validation, export, etc.)

---

## 🛠️ API & Contrôleurs

### Routes disponibles

```php
// Liste des administrateurs
GET /admin/admins

// Créer un administrateur
GET /admin/admins/create
POST /admin/admins

// Voir un administrateur
GET /admin/admins/{admin}

// Modifier un administrateur
GET /admin/admins/{admin}/edit
PUT /admin/admins/{admin}

// Supprimer un administrateur
DELETE /admin/admins/{admin}

// Changer le statut (AJAX)
POST /admin/admins/{admin}/change-status

// Obtenir les permissions d'un rôle (AJAX)
GET /admin/admins/roles/{role}/permissions
```

### Middleware de permissions

Le middleware `CheckAdminPermission` vérifie les permissions :

```php
// Dans routes/web.php
Route::middleware(['admin', 'permission:users,create'])->group(function () {
    Route::get('/admin/users/create', [UserController::class, 'create']);
});
```

### Logs d'audit

Toutes les actions sensibles sont enregistrées automatiquement :

```php
use App\Models\AuditLog;

// Enregistrer une action
AuditLog::log('admin_created', $admin, $oldValues, $newValues);

// Les logs incluent :
// - admin_id : Qui a effectué l'action
// - action : Type d'action
// - model_type : Modèle concerné
// - model_id : ID de l'entrée
// - old_values : Anciennes valeurs (JSON)
// - new_values : Nouvelles valeurs (JSON)
// - ip_address : IP de l'utilisateur
// - user_agent : Navigateur
```

---

## 🔐 Sécurité

### Règles de sécurité implémentées

1. **Auto-protection**
   - Un admin ne peut pas modifier ses propres permissions
   - Un admin ne peut pas se supprimer lui-même
   - Le Super Admin ne peut jamais être supprimé

2. **Vérification côté serveur**
   - Toutes les permissions sont vérifiées côté backend
   - Middleware de protection sur toutes les routes sensibles

3. **Statuts des comptes**
   - `active` : Accès complet
   - `suspended` : Connexion bloquée temporairement
   - `inactive` : Compte désactivé

4. **Audit Trail**
   - Toutes les actions sont journalisées
   - Traçabilité complète (qui, quoi, quand, où)

5. **Validation des données**
   - Email unique obligatoire
   - Mot de passe fort (min 8 caractères)
   - Confirmation du mot de passe

### Bonnes pratiques

1. **Principe du moindre privilège**
   - Donnez uniquement les permissions nécessaires
   - Utilisez les rôles prédéfinis quand possible

2. **Révision régulière**
   - Auditez régulièrement les permissions
   - Désactivez les comptes inactifs

3. **Rotation des mots de passe**
   - Changez régulièrement les mots de passe
   - Utilisez des mots de passe forts

4. **Surveillance**
   - Consultez les logs d'audit régulièrement
   - Détectez les comportements anormaux

---

## 📝 Exemples de code

### Créer un rôle personnalisé

```php
use App\Models\Role;
use App\Models\Permission;

$role = Role::create([
    'name' => 'Marketing Manager',
    'description' => 'Gestion du contenu marketing',
    'is_predefined' => false,
]);

$permissions = Permission::whereIn('name', [
    'blog.view',
    'blog.create',
    'blog.update',
    'testimonials.view',
    'testimonials.update',
])->pluck('id');

$role->permissions()->sync($permissions);
```

### Vérifier les permissions dans les vues Blade

```blade
@can('create', App\Models\User::class)
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        Créer un utilisateur
    </a>
@endcan

{{-- Ou via l'admin directement --}}
@if(auth('admin')->user()->hasPermission('users', 'create'))
    <button>Créer</button>
@endif
```

### Protéger une route avec middleware

```php
// Dans un contrôleur
public function __construct()
{
    $this->middleware('permission:users,view')->only(['index', 'show']);
    $this->middleware('permission:users,create')->only(['create', 'store']);
    $this->middleware('permission:users,update')->only(['edit', 'update']);
    $this->middleware('permission:users,delete')->only('destroy');
}
```

---

## 🎨 Interface Utilisateur

### Pages disponibles

1. **Liste des Administrateurs** (`/admin/admins`)
   - Tableau avec filtres (rôle, statut, recherche)
   - Actions rapides (voir, modifier, supprimer)
   - Badges de statut visuels
   - Pagination

2. **Création d'Administrateur** (`/admin/admins/create`)
   - Formulaire d'informations personnelles
   - Sélection de rôle (prédéfini/personnalisé)
   - Matrice de permissions interactive
   - Validation en temps réel

3. **Modification d'Administrateur** (`/admin/admins/{id}/edit`)
   - Identique à la création
   - Champ statut (actif/suspendu/inactif)
   - Mot de passe optionnel

4. **Détails d'Administrateur** (`/admin/admins/{id}`)
   - Informations complètes
   - Liste des permissions par module
   - Historique des actions (audit logs)

### Design
- Interface moderne avec Bootstrap 5
- Dark/Light mode compatible
- Animations fluides
- Responsive (mobile/tablet/desktop)
- Icônes Font Awesome 6

---

## 🔄 Maintenance

### Commandes utiles

```bash
# Recréer les rôles et permissions
php artisan db:seed --class=RolesAndPermissionsSeeder

# Nettoyer les logs d'audit anciens
php artisan tinker
>>> AuditLog::where('created_at', '<', now()->subMonths(6))->delete();

# Lister tous les admins
php artisan tinker
>>> Admin::with('role')->get();

# Désactiver tous les admins inactifs depuis 90 jours
php artisan tinker
>>> Admin::where('last_login_at', '<', now()->subDays(90))
       ->update(['status' => 'inactive']);
```

---

## ✅ Checklist de déploiement

- [x] Migrations exécutées
- [x] Seeder exécuté
- [x] Super Admin créé
- [x] Routes configurées
- [x] Middleware enregistré
- [x] Guards configurés (config/auth.php)
- [x] Menu sidebar ajouté
- [x] Vues créées et testées
- [ ] Tests unitaires (optionnel)
- [ ] Documentation utilisateur (optionnel)

---

## 📞 Support

Pour toute question ou problème :
- Consultez les logs d'audit : Table `audit_logs`
- Vérifiez les permissions : `$admin->hasPermission($module, $action)`
- Consultez la documentation Laravel : https://laravel.com/docs

---

**Créé avec ❤️ pour Colibri Littéraire**

*Dernière mise à jour : 3 février 2026*
