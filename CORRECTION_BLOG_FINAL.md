# Correction Finale - Problème Blog

## Date: 21 Janvier 2026

## Problème Signalé

Sur la page `/blog`:
1. ❌ L'image ne s'affiche pas
2. ❌ Le clic sur l'article ne redirige pas vers la page show

## Cause Racine

### Problème 1: Slug Vide
L'article avait un **slug vide** en base de données, ce qui causait l'erreur:
```
UrlGenerationException: Missing required parameter for [Route: blog.show] [URI: blog/{slug}]
```

**Pourquoi?** Le modèle Article ne générait le slug que lors de la création (`creating`), pas lors de la mise à jour (`updating`) si le slug était vide.

### Problème 2: Ancien Format d'Image
L'image était stockée avec l'ancien chemin `blog/...` au lieu de `img/blog/...`

## Solutions Appliquées

### 1. Correction du Modèle Article

**Fichier:** `app/Models/Article.php`

Ajout de la logique dans `static::updating()` pour générer le slug s'il est vide:

```php
static::updating(function ($article) {
    // Générer slug s'il est vide
    if (empty($article->slug)) {
        if (!empty($article->title)) {
            $article->slug = Str::slug($article->title);
        } else {
            $article->slug = 'article-' . uniqid();
        }

        // Vérifier l'unicité
        $count = 1;
        $originalSlug = $article->slug;
        while (static::where('slug', $article->slug)->where('id', '!=', $article->id)->exists()) {
            $article->slug = $originalSlug . '-' . $count;
            $count++;
        }
    }
    // Regénérer le slug si le titre a changé
    elseif ($article->isDirty('title') && !empty($article->title)) {
        // ... code existant
    }
});
```

### 2. Migration de l'Image

L'image a été migrée de `public/storage/blog/` vers `public/img/blog/` et le chemin en BDD a été mis à jour.

### 3. Correction Vue blog/index.blade.php

Ajout de vérification du slug avant de créer le lien:

```blade
@if($article->slug)
    <a href="{{ route('blog.show', $article->slug) }}">
        {{ $article->title ?? 'Sans titre' }}
    </a>
@else
    <span class="text-dark">{{ $article->title ?? 'Sans titre' }}</span>
@endif
```

## Vérification

```bash
php artisan tinker
>>> $article = Article::find(3);
>>> $article->slug
=> "fdvfdfds"
>>> $article->featured_image
=> "img/blog/t8mevZVeklu8XCsIjth4AzJlDg3zen1js4gQF5yR.png"
>>> file_exists(public_path($article->featured_image))
=> true
```

## Script de Correction Automatique

Si d'autres articles ont le même problème, utilisez ce script:

```bash
php artisan tinker
>>> $articles = Article::all();
>>> foreach ($articles as $article) {
    // Corriger slug vide
    if (empty($article->slug)) {
        $article->slug = !empty($article->title)
            ? Str::slug($article->title)
            : 'article-' . uniqid();
        $article->save();
    }

    // Migrer anciennes images
    if ($article->featured_image && strpos($article->featured_image, 'blog/') === 0) {
        $filename = basename($article->featured_image);
        $oldPath = 'public/storage/blog/' . $filename;
        $newPath = 'public/img/blog/' . $filename;

        if (file_exists($oldPath)) {
            if (!file_exists('public/img/blog')) {
                mkdir('public/img/blog', 0775, true);
            }
            copy($oldPath, $newPath);
            $article->featured_image = 'img/blog/' . $filename;
            $article->save();
        }
    }
}
>>> echo "Tous les articles corrigés!";
```

## Prévention Future

### Pour Éviter le Problème de Slug Vide

Le modèle Article génère maintenant automatiquement le slug:
- ✅ Lors de la création (si titre fourni)
- ✅ Lors de la mise à jour (si slug vide)
- ✅ Avec unicité garantie

### Pour Éviter le Problème d'Images

Le contrôleur BlogAdminController sauvegarde maintenant directement dans `public/img/blog/`:

```php
// CORRECT (nouveau)
$imagePath = 'img/blog';
$request->featured_image->move(public_path($imagePath), $imageName);
$validated['featured_image'] = $imagePath . '/' . $imageName;

// ANCIEN (ne plus utiliser)
$validated['featured_image'] = $request->file('featured_image')->store('blog', 'public');
```

## État Actuel

✅ **Slug:** Généré automatiquement
✅ **Image:** Stockée dans `public/img/blog/`
✅ **Affichage:** L'image s'affiche correctement
✅ **Lien:** Le clic fonctionne et redirige vers `/blog/fdvfdfds`

## Test Final

1. ✅ Aller sur `/blog` → L'image s'affiche
2. ✅ Cliquer sur l'article → Redirige vers `/blog/fdvfdfds`
3. ✅ La page détail s'affiche avec l'image

## Fichiers Modifiés

1. ✅ `app/Models/Article.php` - Génération slug lors update
2. ✅ `resources/views/blog/index.blade.php` - Vérification slug
3. ✅ BDD: Article ID 3 - Slug et image corrigés

---

**Status:** ✅ RÉSOLU
**Date:** 21 Janvier 2026
**Développeur:** Claude
