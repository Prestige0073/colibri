# Système de Blog Complet

## Vue d'ensemble

Le système de blog est maintenant complètement fonctionnel avec :
- ✅ Interface d'administration complète pour gérer les articles
- ✅ Éditeur de texte riche (TinyMCE) pour formater le contenu
- ✅ Gestion des brouillons et publications
- ✅ Upload d'images mises en avant
- ✅ Page de liste des articles publics
- ✅ Page d'affichage d'article complet
- ✅ Boutons de partage social (WhatsApp, Facebook, X/Twitter, LinkedIn)
- ✅ Système de vues et statistiques
- ✅ Articles similaires
- ✅ UI/UX ergonomique et responsive

## Architecture

### Base de données

**Table: `articles`**
| Champ | Type | Description |
|-------|------|-------------|
| id | bigint | Clé primaire |
| title | string | Titre de l'article |
| slug | string | URL-friendly (généré automatiquement) |
| excerpt | text | Résumé/extrait (optionnel) |
| content | longText | Contenu complet (HTML formaté) |
| featured_image | string | Chemin de l'image mise en avant |
| author_id | foreignId | ID de l'auteur (users) |
| status | enum | 'draft' ou 'published' |
| published_at | timestamp | Date de publication |
| views | integer | Nombre de vues |
| created_at | timestamp | Date de création |
| updated_at | timestamp | Date de modification |

### Modèle Article

**Fichier**: `app/Models/Article.php`

**Champs fillable**:
- title, slug, excerpt, content, featured_image, author_id, status, published_at, views

**Relations**:
- `author()` - Relation belongsTo avec User

**Scopes**:
- `published()` - Récupère uniquement les articles publiés
- `draft()` - Récupère uniquement les brouillons

**Méthodes**:
- `incrementViews()` - Incrémenter le nombre de vues
- `publish()` - Publier l'article
- `unpublish()` - Mettre en brouillon
- Boot avec génération automatique du slug unique

**Casts**:
```php
'published_at' => 'datetime',
'views' => 'integer',
```

## Interface Admin

### Menu de navigation

Le menu "Événements" a été renommé en "Blog" avec l'icône `fa-newspaper`.

**Route**: `/admin/blog`

### Page liste des articles (`admin/blog/index`)

**Statistiques en haut**:
```
┌────────────────────┬────────────────────┬────────────────────┐
│ Articles publiés   │ Brouillons         │ Total des articles │
│ ✅ 12              │ 📝 5               │ 📰 17              │
│ (vert)             │ (jaune)            │ (bleu)             │
└────────────────────┴────────────────────┴────────────────────┘
```

**Tableau des articles**:
| Image | Titre | Auteur | Statut | Vues | Date | Actions |
|-------|-------|--------|--------|------|------|---------|
| [60x60] | Mon article **[Brouillon]** | Jean Dupont | 📝 Brouillon | 👁 125 | 28/12/2025 | 👁 ✏️ ✓ 🗑 |
| [60x60] | Article publié | Marie Martin | ✅ Publié | 👁 542 | 27/12/2025 | 👁 ✏️ 🔒 🗑 |

**Boutons d'action**:
1. 👁 **Voir** (bleu info) - Ouvre l'article sur le site public
2. ✏️ **Modifier** (bleu primary) - Éditer l'article
3. ✓ **Publier** (vert) OU 🔒 **Dépublier** (jaune)
4. 🗑 **Supprimer** (rouge) - Avec confirmation

**Features**:
- Ligne jaune pour les brouillons
- Badge "Brouillon" sur les articles non publiés
- Pagination
- État vide si aucun article

### Page de création (`admin/blog/create`)

**Formulaire**:
```
┌─────────────────────────────────────────────┐
│ 📝 Titre de l'article *                    │
│ [Input large]                               │
├─────────────────────────────────────────────┤
│ 📄 Extrait (résumé)                        │
│ [Textarea 3 lignes]                         │
├─────────────────────────────────────────────┤
│ 📰 Contenu de l'article *                  │
│ [TinyMCE Editor - 500px]                    │
├─────────────────────────────────────────────┤
│ 🖼️ Image mise en avant                     │
│ [Upload fichier + prévisualisation]         │
├─────────────────────────────────────────────┤
│ 🔘 Statut de publication *                 │
│ ◉ Brouillon  ○ Publié                      │
├─────────────────────────────────────────────┤
│         [Annuler]  [Enregistrer l'article] │
└─────────────────────────────────────────────┘
```

**Éditeur TinyMCE**:
- Barre d'outils complète (gras, italique, titres, listes, liens, images, etc.)
- Prévisualisation en temps réel
- Mode code source
- Plein écran
- Interface en français
- Hauteur: 500px

**Validation**:
- Titre: requis, max 255 caractères
- Contenu: requis
- Image: optionnel, formats JPEG/PNG/JPG/GIF/WEBP, max 2 Mo
- Statut: requis (draft ou published)

### Page d'édition (`admin/blog/edit/{id}`)

Identique à la page de création avec :
- Champs pré-remplis avec les valeurs actuelles
- Affichage de l'image actuelle si présente
- Informations supplémentaires (slug, vues, date de publication)
- Possibilité de changer l'image ou de la conserver

## Interface Publique

### Page de liste (`/blog`)

**En-tête**:
- Titre "Blog"
- Breadcrumb: Accueil > Blog
- Introduction

**Grille d'articles** (3 colonnes sur desktop):
```
┌──────────────┐ ┌──────────────┐ ┌──────────────┐
│  [Image]     │ │  [Image]     │ │  [Image]     │
│              │ │              │ │              │
│ 📅 28/12/25  │ │ 📅 27/12/25  │ │ 📅 26/12/25  │
│ 👁 125 vues  │ │ 👁 542 vues  │ │ 👁 89 vues   │
│              │ │              │ │              │
│ Titre de     │ │ Titre de     │ │ Titre de     │
│ l'article    │ │ l'article    │ │ l'article    │
│              │ │              │ │              │
│ Extrait...   │ │ Extrait...   │ │ Extrait...   │
│              │ │              │ │              │
│ 👤 Jean      │ │ 👤 Marie     │ │ 👤 Paul      │
└──────────────┘ └──────────────┘ └──────────────┘
```

**Features**:
- Cards avec image/icône
- Effet de survol (élévation + zoom image)
- Date et nombre de vues
- Extrait ou début du contenu (120 caractères)
- Avatar de l'auteur avec initiale
- Pagination Bootstrap
- État vide si aucun article

### Page d'article (`/blog/{slug}`)

**Layout**: 2 colonnes (8-4)

**Colonne principale**:
1. **Image mise en avant** (si présente)
2. **Meta informations**:
   - Avatar et nom de l'auteur
   - Date de publication
   - Nombre de vues
3. **Extrait** (si présent) - En surbrillance
4. **Contenu complet** avec formatage HTML
5. **Boutons de partage social**
6. **Articles similaires** (3 derniers articles)
7. **Bouton retour à la liste**

**Colonne sidebar**:
1. **À propos de l'auteur**
2. **Informations**:
   - Date de publication
   - Temps de lecture estimé
   - Nombre de vues
3. **Appel à l'action** (Catalogue et Formations)

**Boutons de partage social**:
```
┌──────────────────────────────────────────┐
│ 🔗 Partager cet article                  │
├──────────────────────────────────────────┤
│ [WhatsApp] [Facebook] [X] [LinkedIn]     │
│ [Copier le lien]                         │
└──────────────────────────────────────────┘
```

**Liens de partage**:
- **WhatsApp**: `https://wa.me/?text={titre} - {url}`
- **Facebook**: `https://www.facebook.com/sharer/sharer.php?u={url}`
- **X (Twitter)**: `https://twitter.com/intent/tweet?text={titre}&url={url}`
- **LinkedIn**: `https://www.linkedin.com/sharing/share-offsite/?url={url}`
- **Copier le lien**: Copie dans le presse-papiers avec toast de confirmation

**Styling du contenu**:
- Police: 1.1rem, line-height 1.8
- Titres en couleur success (#198754)
- Images responsive avec border-radius
- Blockquotes avec bordure verte
- Listes et tableaux formatés
- Code source avec background gris

## Contrôleurs

### BlogAdminController (Admin)

**Méthode `index()`**:
```php
public function index()
{
    $articles = Article::with('author')->latest()->paginate(20);
    $publishedCount = Article::published()->count();
    $draftCount = Article::draft()->count();

    return view('admin.blog.index', compact('articles', 'publishedCount', 'draftCount'));
}
```

**Méthode `create()`**:
```php
public function create()
{
    return view('admin.blog.create');
}
```

**Méthode `store(Request $request)`**:
```php
public function store(Request $request)
{
    // Validation
    // Upload image si présente
    // Définir auteur et date de publication si publié
    $article = Article::create($validated);

    return redirect()->route('admin.blog.index')
                    ->with('success', 'Article créé avec succès.');
}
```

**Méthode `edit($id)`**:
```php
public function edit($id)
{
    $article = Article::findOrFail($id);
    return view('admin.blog.edit', compact('article'));
}
```

**Méthode `update(Request $request, $id)`**:
```php
public function update(Request $request, $id)
{
    // Validation
    // Gérer upload image (supprimer ancienne si nouvelle)
    // Mettre à jour date de publication selon statut
    $article->update($validated);

    return redirect()->route('admin.blog.index')
                    ->with('success', 'Article mis à jour avec succès.');
}
```

**Méthode `destroy($id)`**:
```php
public function destroy($id)
{
    $article = Article::findOrFail($id);

    // Supprimer l'image si elle existe
    if ($article->featured_image && Storage::exists($article->featured_image)) {
        Storage::delete($article->featured_image);
    }

    $article->delete();

    return redirect()->route('admin.blog.index')
                    ->with('success', 'Article supprimé avec succès.');
}
```

**Méthode `toggleStatus($id)`**:
```php
public function toggleStatus($id)
{
    $article = Article::findOrFail($id);

    if ($article->status === 'published') {
        $article->unpublish();
    } else {
        $article->publish();
    }

    return redirect()->back()->with('success', 'Statut modifié.');
}
```

### BlogController (Public)

**Méthode `index()`**:
```php
public function index()
{
    $articles = Article::published()
                      ->with('author')
                      ->latest('published_at')
                      ->paginate(12);

    return view('blog.index', compact('articles'));
}
```

**Méthode `show($slug)`**:
```php
public function show($slug)
{
    $article = Article::where('slug', $slug)
                     ->published()
                     ->with('author')
                     ->firstOrFail();

    // Incrémenter vues
    $article->incrementViews();

    // Articles similaires
    $relatedArticles = Article::published()
                             ->where('id', '!=', $article->id)
                             ->latest('published_at')
                             ->take(3)
                             ->get();

    return view('blog.show', compact('article', 'relatedArticles'));
}
```

## Routes

### Routes publiques
```php
Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
```

### Routes admin
```php
Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    Route::resource('blog', BlogAdminController::class);
    Route::post('blog/{id}/toggle-status', [BlogAdminController::class, 'toggleStatus'])
         ->name('blog.toggleStatus');
});
```

**Routes resource générées**:
- GET `/admin/blog` - index (liste)
- GET `/admin/blog/create` - create (formulaire création)
- POST `/admin/blog` - store (enregistrer)
- GET `/admin/blog/{id}/edit` - edit (formulaire édition)
- PUT `/admin/blog/{id}` - update (mettre à jour)
- DELETE `/admin/blog/{id}` - destroy (supprimer)

**Route personnalisée**:
- POST `/admin/blog/{id}/toggle-status` - toggleStatus (publier/dépublier)

## Vues

### Admin

**resources/views/admin/blog/index.blade.php**:
- Layout: admin.layout
- 3 cartes statistiques (publiés, brouillons, total)
- Tableau avec images miniatures, infos, actions
- Pagination
- État vide

**resources/views/admin/blog/create.blade.php**:
- Formulaire complet avec TinyMCE
- Upload d'image avec prévisualisation
- Radio buttons pour le statut
- Validation côté serveur

**resources/views/admin/blog/edit.blade.php**:
- Identique à create
- Champs pré-remplis
- Affichage image actuelle
- Informations supplémentaires (slug, vues)

### Public

**resources/views/blog/index.blade.php**:
- Layout: layouts.app
- Page header avec breadcrumb
- Grille de cards (3 colonnes)
- Pagination
- État vide
- Animations de survol

**resources/views/blog/show.blade.php**:
- Layout 2 colonnes (8-4)
- Image mise en avant
- Meta informations
- Contenu formaté
- Boutons de partage social
- Articles similaires
- Sidebar avec infos et CTA

## Sécurité

### Protection CSRF
- Token `@csrf` dans tous les formulaires
- Validation automatique par Laravel

### Validation des données
- Validation stricte côté serveur
- Messages d'erreur en français
- Sanitization automatique par Eloquent
- Protection XSS (échappement automatique de Blade)

### Upload de fichiers
- Types autorisés: JPEG, PNG, JPG, GIF, WEBP
- Taille max: 2 Mo
- Stockage dans `storage/app/public/blog`
- Suppression de l'ancienne image lors de la mise à jour

### Permissions
- Routes admin protégées par middleware `admin`
- Vérification d'authentification pour la gestion
- Articles publics accessibles sans authentification

### SQL Injection
- Protection par Eloquent ORM
- Requêtes preparées automatiquement

## Fonctionnalités avancées

### Génération automatique du slug
- Slug créé à partir du titre lors de la création
- Vérification de l'unicité
- Incrémentation automatique si doublon (article-1, article-2, etc.)

### Système de vues
- Incrémentation à chaque consultation
- Affichage dans admin et public
- Stocké en base de données

### Gestion des images
- Upload sécurisé
- Stockage dans `storage/public/blog`
- Suppression automatique lors de la suppression d'article
- Remplacement lors de la mise à jour
- Fallback avec icône si pas d'image

### Partage social
- URLs correctement encodées
- Ouverture dans nouvel onglet
- Attribut `rel="noopener noreferrer"` pour sécurité
- Fonction JavaScript pour copier le lien
- Toast de confirmation

### Articles similaires
- 3 derniers articles publiés
- Exclusion de l'article actuel
- Tri par date de publication
- Cards compactes avec liens

### Temps de lecture
- Calcul automatique basé sur le nombre de mots
- Estimation: 200 mots/minute
- Affichage dans la sidebar

## Éditeur Quill (Gratuit et Open Source)

### Pourquoi Quill ?
- ✅ **100% gratuit** et open source (licence BSD)
- ✅ **Aucune clé API** requise
- ✅ **Léger** (~43 KB) et rapide
- ✅ Interface moderne et intuitive
- ✅ HTML propre et sémantique

### Configuration
```javascript
var quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'align': [] }],
            ['link', 'image', 'video'],
            ['blockquote', 'code-block'],
            ['clean']
        ]
    },
    placeholder: 'Rédigez le contenu de votre article ici...'
});
```

### Fonctionnalités essentielles
- ✅ Mise en forme du texte (gras, italique, souligné, barré)
- ✅ Titres H1 à H6
- ✅ Couleur de texte et surlignage
- ✅ Alignement (gauche, centre, droite, justifié)
- ✅ Listes à puces et numérotées
- ✅ Liens hypertextes
- ✅ Images (via URL)
- ✅ Vidéos (YouTube, Vimeo)
- ✅ Citations (blockquote)
- ✅ Blocs de code
- ✅ Nettoyer le formatage
- ✅ Raccourcis clavier (Ctrl+B, Ctrl+I, etc.)

### Intégration Laravel
```html
<!-- Zone d'édition visible -->
<div id="editor" style="height: 400px;"></div>

<!-- Textarea caché pour soumettre -->
<textarea class="d-none" id="content" name="content"></textarea>

<!-- Script de synchronisation -->
<script>
form.addEventListener('submit', function() {
    document.querySelector('#content').value = quill.root.innerHTML;
});
</script>
```

Pour plus de détails, voir [EDITEUR_QUILL.md](EDITEUR_QUILL.md)

## Styling et UI/UX

### Couleurs
- Primary (success): #198754 (vert)
- Info: #0d6efd (bleu)
- Warning: #ffc107 (jaune)
- Danger: #dc3545 (rouge)

### Animations
- Fade in sur les cards
- Hover avec élévation (translateY -5px)
- Zoom sur les images au survol
- Transitions smooth (0.3s ease)

### Responsive
- Grille 3 colonnes (desktop) > 2 (tablette) > 1 (mobile)
- Layout 8-4 (desktop) > empilé (mobile)
- Boutons adaptés à la taille d'écran
- Images responsive (100% width, auto height)

### Typographie
- Titres: fw-bold, couleur primary
- Contenu article: 1.1rem, line-height 1.8
- Small text: text-muted
- Dates et meta: small, icônes FontAwesome

### Icônes FontAwesome
- 📰 `fa-newspaper` - Blog
- 📅 `fa-calendar` - Date
- 👁 `fa-eye` - Vues
- 👤 `fa-user` - Auteur
- ✏️ `fa-edit` - Modifier
- 🗑️ `fa-trash` - Supprimer
- ✅ `fa-check-circle` - Publié
- 📝 `fa-edit` - Brouillon
- 🔗 `fa-share-alt` - Partager
- 📱 `fa-whatsapp` - WhatsApp
- 📘 `fa-facebook-f` - Facebook
- 🐦 `fa-x-twitter` - X/Twitter
- 💼 `fa-linkedin-in` - LinkedIn
- 🔗 `fa-link` - Copier lien

## Migration

**Fichier**: `database/migrations/2025_12_28_112910_create_articles_table.php`

**Exécution**:
```bash
php artisan migrate
```

**Rollback** (si nécessaire):
```bash
php artisan migrate:rollback --step=1
```

## Tests manuels

### Test 1: Créer un article (brouillon)

1. Se connecter en admin
2. Aller sur `/admin/blog`
3. Cliquer "Nouvel article"
4. Remplir:
   - Titre: "Mon premier article de blog"
   - Extrait: "Ceci est un test d'article"
   - Contenu: "Lorem ipsum avec formatage **gras** et *italique*"
   - Image: Upload une image
   - Statut: Brouillon
5. Cliquer "Enregistrer"
6. **Attendu**: Redirection vers liste, message de succès, article dans tableau avec badge "Brouillon"

### Test 2: Publier un article

1. Dans la liste admin, cliquer sur le bouton vert (publier)
2. **Attendu**: Badge passe à "Publié", statut change, date de publication définie

### Test 3: Affichage public

1. Aller sur `/blog`
2. **Attendu**: L'article publié apparaît dans la liste
3. Cliquer sur l'article
4. **Attendu**: Page complète avec image, contenu, boutons de partage

### Test 4: Partage social

1. Sur un article, cliquer "WhatsApp"
2. **Attendu**: Ouverture de WhatsApp avec titre et lien pré-remplis
3. Cliquer "Copier le lien"
4. **Attendu**: Toast "Lien copié", lien dans le presse-papiers

### Test 5: Éditer un article

1. Dans admin, cliquer "Modifier"
2. Changer le titre
3. Enregistrer
4. **Attendu**: Modifications sauvegardées, slug reste inchangé

### Test 6: Supprimer un article

1. Cliquer sur le bouton poubelle
2. Confirmer
3. **Attendu**: Article supprimé, image supprimée du stockage

### Test 7: Vues d'article

1. Visiter un article public
2. Actualiser la page
3. Retourner à la liste admin
4. **Attendu**: Nombre de vues incrémenté

## Améliorations futures possibles

1. **Catégories et tags** pour organiser les articles
2. **Commentaires** sur les articles
3. **Recherche** par titre/contenu
4. **Filtres** (par auteur, date, catégorie)
5. **Révisions** d'articles (historique des modifications)
6. **Planification** de publication (publish_at dans le futur)
7. **SEO**: meta description, keywords personnalisés
8. **Statistiques avancées** (graphiques de vues, articles populaires)
9. **Newsletter** pour informer des nouveaux articles
10. **RSS feed** pour les agrégateurs
11. **Traduction** multilingue
12. **Modération** des commentaires
13. **Auteurs invités** avec profils détaillés
14. **Système de likes/réactions**
15. **Temps de lecture** plus précis avec images

## Fichiers créés/modifiés

### Créés

1. `database/migrations/2025_12_28_112910_create_articles_table.php`
2. `app/Models/Article.php`
3. `app/Http/Controllers/Admin/BlogAdminController.php`
4. `resources/views/admin/blog/index.blade.php`
5. `resources/views/admin/blog/create.blade.php`
6. `resources/views/admin/blog/edit.blade.php`
7. `resources/views/blog/show.blade.php`

### Modifiés

1. `app/Http/Controllers/BlogController.php` - Ajout méthodes index() et show()
2. `resources/views/blog/index.blade.php` - Refonte complète
3. `resources/views/admin/layout.blade.php` - Renommage "Événements" en "Blog"
4. `routes/web.php` - Ajout routes blog publiques et admin

## Commandes utiles

```bash
# Voir tous les articles
php artisan tinker
>>> \App\Models\Article::all()

# Compter les articles publiés
>>> \App\Models\Article::published()->count()

# Compter les brouillons
>>> \App\Models\Article::draft()->count()

# Publier un article
>>> \App\Models\Article::find(1)->publish()

# Mettre en brouillon
>>> \App\Models\Article::find(1)->unpublish()

# Supprimer tous les articles de test
>>> \App\Models\Article::where('title', 'like', '%test%')->delete()

# Vider les caches
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

## Résultat final

✅ **Système de blog 100% fonctionnel et complet**
✅ **Interface d'administration professionnelle avec TinyMCE**
✅ **Pages publiques avec excellent UI/UX**
✅ **Boutons de partage social correctement formatés**
✅ **Système de vues et statistiques**
✅ **Gestion des images optimisée**
✅ **Code propre et bien organisé**
✅ **Responsive sur tous les écrans**
✅ **Menu admin renommé de "Événements" à "Blog"**

Le système est prêt pour la production! 🎉
