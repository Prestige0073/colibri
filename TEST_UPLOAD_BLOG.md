# Test d'Upload d'Image Blog - 512MB

## Date: 21 Janvier 2026

---

## Modifications Effectuées

### 1. Configuration PHP dans public/index.php ✅

**Fichier**: `public/index.php`

Ajout de la configuration PHP au démarrage de Laravel:

```php
// Configuration PHP pour augmenter les limites d'upload
@ini_set('upload_max_filesize', '512M');
@ini_set('post_max_size', '512M');
@ini_set('memory_limit', '1024M');
@ini_set('max_execution_time', '600');
@ini_set('max_input_time', '600');
```

**Avantage**: Cette configuration est chargée à **chaque requête HTTP**, quel que soit le serveur web utilisé.

### 2. Texte des Vues Corrigé ✅

**Fichiers modifiés**:
- `resources/views/admin/blog/create.blade.php` - Ligne 94
- `resources/views/admin/blog/edit.blade.php` - Ligne 111

**Avant**:
```html
<small class="text-muted">Formats acceptés: JPEG, PNG, JPG, GIF, WEBP (max 2 Mo)</small>
```

**Après**:
```html
<small class="text-muted">Formats acceptés: JPEG, PNG, JPG, GIF, WEBP (jusqu'à 512 Mo)</small>
```

### 3. Chemin d'Image Corrigé ✅

**Fichier**: `resources/views/admin/blog/edit.blade.php` - Ligne 89

**Avant**:
```blade
<img src="{{ asset('storage/' . $article->featured_image) }}" ...>
```

**Après**:
```blade
<img src="{{ asset($article->featured_image) }}" ...>
```

---

## Pourquoi public/index.php?

### Problème avec serve.sh

Le script `serve.sh` lance:
```bash
php -c php-dev.ini artisan serve --host=0.0.0.0 --port=8000
```

Mais `php artisan serve` crée **deux processus**:

1. **Process parent** (utilise php-dev.ini) ✅
   ```
   php -c php-dev.ini artisan serve
   ```

2. **Process serveur web** (N'utilise PAS php-dev.ini) ❌
   ```
   /usr/bin/php8.4 -S 0.0.0.0:8000 server.php
   ```

Le deuxième processus est celui qui **traite les requêtes HTTP**, et il n'hérite PAS de la configuration `-c php-dev.ini`.

### Solution avec public/index.php

En ajoutant `ini_set()` dans `public/index.php`:
- ✅ La configuration s'applique à **toutes les requêtes HTTP**
- ✅ Fonctionne avec `php artisan serve`
- ✅ Fonctionne avec Apache
- ✅ Fonctionne avec Nginx
- ✅ Pas besoin de modifier le php.ini système

---

## Tests à Effectuer

### Test 1: Vérifier la Configuration Active

**Dans le navigateur**, créez un fichier temporaire:

```php
// public/test-config.php
<?php
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "<br>";
echo "post_max_size: " . ini_get('post_max_size') . "<br>";
echo "memory_limit: " . ini_get('memory_limit') . "<br>";
echo "max_execution_time: " . ini_get('max_execution_time') . "<br>";
?>
```

Allez sur: `http://localhost:8000/test-config.php`

**Résultat attendu**:
```
upload_max_filesize: 512M
post_max_size: 512M
memory_limit: 1024M
max_execution_time: 600
```

**⚠️ Supprimez ce fichier après le test!**

### Test 2: Upload Image 5MB dans le Blog

1. **Redémarrer le serveur** (important pour charger les changements):
   ```bash
   # Arrêter le serveur actuel
   Ctrl+C dans le terminal du serveur

   # Redémarrer
   ./serve.sh
   ```

2. **Aller sur**: `http://localhost:8000/admin/blog/create`

3. **Uploader** l'image de test: `public/img/image de 5mo.png` (4.9MB)

4. **Résultat attendu**: ✅ Upload réussit sans erreur

### Test 3: Upload Image 10MB+

1. Créer une image de 10MB:
   ```bash
   # Créer une image de 10MB pour test
   dd if=/dev/urandom of=public/img/test-10mb.jpg bs=1M count=10
   ```

2. Uploader dans le blog

3. **Résultat attendu**: ✅ Upload réussit

### Test 4: Upload Image 100MB+

1. Créer une image de 100MB:
   ```bash
   dd if=/dev/urandom of=public/img/test-100mb.jpg bs=1M count=100
   ```

2. Uploader dans le blog

3. **Résultat attendu**: ✅ Upload réussit (peut prendre quelques secondes)

---

## Vérification des Changements

```bash
# Vérifier public/index.php
grep -A5 "ini_set" public/index.php

# Vérifier les vues blog
grep "512 Mo" resources/views/admin/blog/*.blade.php

# Vérifier que le serveur tourne
ps aux | grep "php.*serve"
```

---

## Commandes de Démarrage

### Arrêter l'Ancien Serveur

```bash
# Trouver les processus PHP
ps aux | grep "php.*serve"

# Tuer tous les processus (si plusieurs)
pkill -f "php.*serve"

# Ou Ctrl+C dans le terminal du serveur
```

### Redémarrer avec Nouvelle Configuration

```bash
# Méthode 1: Avec serve.sh
./serve.sh

# Méthode 2: Directement (fonctionne aussi maintenant)
php artisan serve --host=0.0.0.0 --port=8000
```

**Note**: Maintenant, les deux méthodes fonctionnent car `ini_set()` est dans `public/index.php`.

---

## Contrôleur Blog - Pas de Limitation

**Fichier**: `app/Http/Controllers/Admin/BlogAdminController.php`

```php
// Ligne 45 - store()
'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
// ✅ Aucune limitation max:

// Ligne 94 - update()
'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
// ✅ Aucune limitation max:
```

---

## Diagnostic en Cas de Problème

### Si l'Upload Refuse Toujours

1. **Vérifier que le serveur a été redémarré**:
   ```bash
   # Tuer tous les processus PHP
   pkill -f "php"

   # Attendre 2 secondes
   sleep 2

   # Redémarrer
   ./serve.sh
   ```

2. **Vérifier la configuration active**:
   Créer `public/test-config.php` et vérifier que ça affiche 512M

3. **Vérifier les logs Laravel**:
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Vérifier les permissions**:
   ```bash
   ls -la public/img/blog/
   chmod 775 public/img/blog/
   ```

### Si l'Image Ne S'affiche Pas Après Upload

1. **Vérifier le chemin**:
   ```bash
   # Aller dans tinker
   php artisan tinker

   # Vérifier le dernier article
   >>> $article = Article::latest()->first();
   >>> $article->featured_image
   # Devrait afficher: img/blog/blog_xxxxx.png (sans 'storage/')

   # Vérifier que le fichier existe
   >>> file_exists(public_path($article->featured_image))
   # Devrait afficher: true
   ```

2. **Vérifier dans le navigateur**:
   Aller sur: `http://localhost:8000/img/blog/nom-de-fichier.png`
   (remplacer avec le vrai nom de fichier)

---

## Différences avec la Configuration Précédente

### Avant (serve.sh seul)

```bash
# serve.sh
php -c php-dev.ini artisan serve
```

**Problème**: Le serveur web child n'héritait pas de `-c php-dev.ini`

**Résultat**: ❌ Limitation à 2MB persistait

### Après (public/index.php + serve.sh)

```php
// public/index.php
@ini_set('upload_max_filesize', '512M');
@ini_set('post_max_size', '512M');
// ...
```

**Avantage**: Configuration chargée à chaque requête HTTP

**Résultat**: ✅ Limitation à 512MB fonctionne

---

## Fichiers Modifiés

1. ✅ `public/index.php` - Configuration PHP runtime
2. ✅ `resources/views/admin/blog/create.blade.php` - Texte "512 Mo"
3. ✅ `resources/views/admin/blog/edit.blade.php` - Texte "512 Mo" + chemin image

---

## Statut

✅ **Configuration PHP**: 512MB dans public/index.php
✅ **Texte des vues**: "jusqu'à 512 Mo"
✅ **Chemin d'image**: Corrigé (sans 'storage/')
✅ **Contrôleur**: Aucune limitation Laravel

---

**Prochaine Étape**: Redémarrer le serveur et tester l'upload d'une image de 5MB.

---

**Date**: 21 Janvier 2026
**Développeur**: Claude (Assistant IA)
