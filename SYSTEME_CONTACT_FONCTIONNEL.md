# Système de Contact Fonctionnel

## Vue d'ensemble

Le formulaire de contact est maintenant complètement fonctionnel avec:
- ✅ Enregistrement des messages en base de données
- ✅ Interface admin pour gérer les messages
- ✅ Badge de notification pour les messages non lus
- ✅ Système de marquage lu/non lu
- ✅ Validation des données
- ✅ Messages de succès et d'erreur

## Architecture

### Base de données

**Table: `contacts`**
| Champ | Type | Description |
|-------|------|-------------|
| id | bigint | Clé primaire |
| name | string | Nom de l'expéditeur |
| email | string | Email de l'expéditeur |
| subject | string | Sujet du message |
| message | text | Contenu du message |
| is_read | boolean | Statut lu/non lu (défaut: false) |
| read_at | timestamp | Date de lecture (nullable) |
| created_at | timestamp | Date d'envoi |
| updated_at | timestamp | Date de modification |

### Modèle Contact

**Fichier**: `app/Models/Contact.php`

**Champs fillable**:
- name, email, subject, message, is_read, read_at

**Méthodes**:
- `markAsRead()` - Marque le message comme lu
- `scopeUnread($query)` - Scope pour les messages non lus
- `scopeRead($query)` - Scope pour les messages lus

**Casts**:
```php
'is_read' => 'boolean',
'read_at' => 'datetime',
```

## Flux utilisateur (Frontend)

### Page de contact: `/contact`

**Formulaire**:
```html
<form method="POST" action="{{ route('contact.store') }}">
    @csrf
    <input name="name" required>
    <input type="email" name="email" required>
    <input name="subject" required>
    <textarea name="message" required minlength="10"></textarea>
    <button type="submit">Envoyer le message</button>
</form>
```

**Validation côté serveur**:
- Nom: requis, string, max 255 caractères
- Email: requis, format email valide, max 255 caractères
- Sujet: requis, string, max 255 caractères
- Message: requis, string, minimum 10 caractères

**Messages de validation personnalisés** (en français)

**Après envoi réussi**:
- Message de succès affiché
- Formulaire réinitialisé
- Redirection avec message: "Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais."

## Interface Admin

### Page liste: `/admin/contacts`

**Statistiques en haut**:

```
┌────────────────────┬────────────────────┬────────────────────┐
│ Messages non lus   │ Messages lus       │ Total des messages │
│ 🔴 5               │ ✅ 12              │ 📥 17              │
│ (rouge)            │ (vert)             │ (bleu)             │
└────────────────────┴────────────────────┴────────────────────┘
```

**Badge dans le menu admin**:
```
Contacts [5]  ← Badge rouge avec nombre de non lus
```

**Tableau des messages**:
| Statut | Nom | Email | Sujet | Message | Date | Actions |
|--------|-----|-------|-------|---------|------|---------|
| 🔴 | Jean Dupont **[Nouveau]** | jean@... | Demande info | Bonjour... | 27/12 14:30 | 👁 ✓ 🗑 |
| ⚪ | Marie Martin | marie@... | Remerciements | Merci... | 26/12 10:15 | 👁 ✉ 🗑 |

**Légende des couleurs**:
- Ligne **jaune clair** = message non lu
- 🔴 **Cercle rouge** = non lu
- ⚪ **Cercle gris** = lu
- Badge **"Nouveau"** rouge = message non lu

**Boutons d'action**:
1. 👁 **Voir** (bleu) - Affiche le message complet
2. ✓ **Marquer lu** (vert) OU ✉ **Marquer non lu** (jaune)
3. 🗑 **Supprimer** (rouge) - Avec confirmation

### Page détails: `/admin/contacts/{id}`

**Layout**: 2 colonnes

**Colonne gauche (8/12)**:
- Sujet du message (gros titre)
- Badge lu/non lu
- Date d'envoi
- Contenu complet du message

**Colonne droite (4/12)**:
- **Card Informations**:
  - Nom
  - Email (cliquable mailto:)
  - Date d'envoi
  - Date de lecture (si lu)

- **Card Actions**:
  - Répondre par email (ouvre le client mail)
  - Marquer lu/non lu
  - Supprimer le message

**Comportement automatique**:
- Quand un admin ouvre un message non lu, il est automatiquement marqué comme lu
- `read_at` est mis à jour avec l'heure actuelle

## Routes

### Frontend
```php
Route::resource('contact', ContactController::class);
// Génère:
// GET /contact => ContactController@index (affiche le formulaire)
// POST /contact => ContactController@store (enregistre le message)
```

### Admin
```php
Route::resource('contacts', ContactAdminController::class);
// Génère:
// GET /admin/contacts => index (liste)
// GET /admin/contacts/{id} => show (détails)
// DELETE /admin/contacts/{id} => destroy (suppression)

Route::post('contacts/{id}/toggle-read', [ContactAdminController::class, 'toggleRead'])
     ->name('contacts.toggleRead');
```

## Contrôleurs

### ContactController (Frontend)

**Méthode `store()`**:
```php
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|min:10',
    ], [
        // Messages personnalisés en français
    ]);

    Contact::create($validated);

    return redirect()->back()->with('success', 'Votre message a été envoyé avec succès !');
}
```

### ContactAdminController (Admin)

**Méthode `index()`**:
```php
public function index()
{
    $contacts = Contact::latest()->paginate(20);
    $unreadCount = Contact::unread()->count();

    return view('admin.contacts', compact('contacts', 'unreadCount'));
}
```

**Méthode `show($id)`**:
```php
public function show($id)
{
    $contact = Contact::findOrFail($id);

    // Auto-marquage comme lu
    if (!$contact->is_read) {
        $contact->markAsRead();
    }

    return view('admin.contacts-show', compact('contact'));
}
```

**Méthode `toggleRead($id)`**:
```php
public function toggleRead($id)
{
    $contact = Contact::findOrFail($id);

    if ($contact->is_read) {
        $contact->update(['is_read' => false, 'read_at' => null]);
    } else {
        $contact->markAsRead();
    }

    return redirect()->back()->with('success', 'Statut modifié.');
}
```

**Méthode `destroy($id)`**:
```php
public function destroy($id)
{
    Contact::findOrFail($id)->delete();

    return redirect()->route('admin.contacts.index')
        ->with('success', 'Message supprimé avec succès.');
}
```

## Badge de notification

### Dans le menu admin

**Code**: `resources/views/admin/layout.blade.php`

```blade
<li class="nav-item">
    <a href="{{ route('admin.contacts.index') }}" class="nav-link">
        <i class="fa fa-envelope me-2"></i>Contacts
        @php
            $unreadContactsCount = \App\Models\Contact::unread()->count();
        @endphp
        @if($unreadContactsCount > 0)
            <span class="badge bg-danger rounded-pill ms-2">{{ $unreadContactsCount }}</span>
        @endif
    </a>
</li>
```

**Apparence**:
```
☰ Menu Admin
├─ Dashboard
├─ Utilisateurs
├─ Commandes
└─ Contacts [3]  ← Badge rouge avec le nombre
```

**Comportement**:
- Badge visible uniquement si > 0 messages non lus
- Mis à jour en temps réel au rechargement de la page
- Couleur rouge (danger) pour attirer l'attention

## Vues

### resources/views/contact.blade.php

**Modifications**:
- Form `method="POST" action="{{ route('contact.store') }}"`
- Token CSRF: `@csrf`
- Attributs `name` sur tous les inputs
- Classes `@error()` pour afficher les erreurs
- `old()` pour garder les valeurs après erreur
- Icône envelope sur le bouton submit

### resources/views/admin/contacts.blade.php

**Structure**:
1. En-tête avec titre + badge non lus
2. 3 cartes statistiques (non lus, lus, total)
3. Messages de succès (si présents)
4. État vide (si aucun message)
5. Tableau avec pagination

**Features**:
- Fond jaune pour les lignes non lues
- Icône cercle rouge/gris pour statut
- Badge "Nouveau" sur les non lus
- Email cliquable (mailto:)
- Groupe de boutons d'action
- Pagination Bootstrap

### resources/views/admin/contacts-show.blade.php

**Structure**:
- Bouton retour
- 2 colonnes (8-4)
- Message complet avec fond gris
- Sidebar avec infos + actions
- Bouton "Répondre par email" pré-remplit le sujet

## Sécurité

### Protection CSRF
- Token `@csrf` dans tous les formulaires
- Validation automatique par Laravel

### Validation des données
- Validation stricte côté serveur
- Sanitization automatique par Eloquent
- Protection XSS (échappement automatique de Blade)

### Permissions
- Routes admin protégées par middleware auth
- Vérification admin dans le middleware

### SQL Injection
- Protection par Eloquent ORM
- Requêtes preparées automatiquement

## Migration

**Fichier**: `database/migrations/2025_12_27_220201_create_contacts_table.php`

**Exécution**:
```bash
php artisan migrate
```

**Rollback** (si nécessaire):
```bash
php artisan migrate:rollback --step=1
```

## Tests manuels

### Test 1: Envoi d'un message

1. Aller sur `http://0.0.0.0:8000/contact`
2. Remplir le formulaire:
   - Nom: "Jean Test"
   - Email: "jean@test.com"
   - Sujet: "Test du formulaire"
   - Message: "Ceci est un message de test avec plus de 10 caractères"
3. Cliquer sur "Envoyer le message"
4. **Attendu**: Message de succès + formulaire vide

### Test 2: Validation

1. Essayer d'envoyer avec email invalide
2. **Attendu**: Message d'erreur en français
3. Essayer message < 10 caractères
4. **Attendu**: "Le message doit contenir au moins 10 caractères."

### Test 3: Badge admin

1. Se connecter en tant qu'admin
2. Regarder le menu sidebar
3. **Attendu**: Badge rouge avec le nombre de messages non lus

### Test 4: Liste admin

1. Aller sur `/admin/contacts`
2. **Attendu**:
   - Statistiques en haut
   - Ligne jaune pour message non lu
   - Badge "Nouveau"
   - Icône cercle rouge

### Test 5: Marquage lu

1. Cliquer sur le message
2. **Attendu**:
   - Message s'affiche
   - Badge passe à "Lu" (vert)
   - Retour à la liste → ligne normale (pas jaune)
   - Badge menu diminue de 1

### Test 6: Suppression

1. Cliquer sur bouton poubelle
2. Confirmer
3. **Attendu**: Message supprimé + redirection avec succès

## Améliorations futures possibles

1. **Email de notification** à l'admin lors d'un nouveau message
2. **Réponse directe** depuis l'interface admin
3. **Catégories** de messages (demande, partenariat, bug, etc.)
4. **Pièces jointes** dans le formulaire
5. **Statistiques** graphiques des messages
6. **Recherche** et filtres dans la liste admin
7. **Export CSV** des messages
8. **Templates de réponse** pré-définis
9. **Archivage automatique** des vieux messages
10. **Webhook** pour intégration Slack/Discord

## Fichiers modifiés/créés

### Créés
1. `database/migrations/2025_12_27_220201_create_contacts_table.php`
2. `app/Models/Contact.php`
3. `app/Http/Controllers/Admin/ContactAdminController.php`
4. `resources/views/admin/contacts-show.blade.php`

### Modifiés
1. `app/Http/Controllers/ContactController.php` - Ajout méthode `store()`
2. `resources/views/contact.blade.php` - Form fonctionnel avec validation
3. `resources/views/admin/contacts.blade.php` - Interface complète
4. `resources/views/admin/layout.blade.php` - Badge de notification
5. `routes/web.php` - Route `toggleRead`

## Commandes utiles

```bash
# Voir tous les messages
php artisan tinker
>>> \App\Models\Contact::all()

# Compter les non lus
>>> \App\Models\Contact::unread()->count()

# Marquer tous comme lus
>>> \App\Models\Contact::unread()->get()->each->markAsRead()

# Supprimer tous les messages de test
>>> \App\Models\Contact::where('email', 'like', '%test%')->delete()

# Vider les caches
php artisan view:clear
php artisan cache:clear
php artisan config:clear
```

## Résultat final

✅ **Formulaire de contact 100% fonctionnel**
✅ **Sauvegarde en base de données**
✅ **Interface admin professionnelle**
✅ **Badge de notification en temps réel**
✅ **Système lu/non lu complet**
✅ **Validation robuste**
✅ **Messages en français**
✅ **Design cohérent avec le reste de l'admin**

Le système est prêt pour la production! 🎉
