# Configuration des limites d'upload

## Problème
L'erreur "POST data is too large" apparaît lors de l'upload de fichiers volumineux (vidéos, PDFs, etc.).

## Cause
Les limites PHP par défaut sont trop basses:
- `upload_max_filesize` = 2M
- `post_max_size` = 8M

L'application nécessite des uploads jusqu'à 100M pour les contenus de formation.

## Solution

### Pour le serveur de développement (php artisan serve)

**Option 1 - Utiliser le script fourni (Recommandé)**
```bash
./serve.sh
```

**Option 2 - Démarrer manuellement avec la config personnalisée**
```bash
php -c php-dev.ini artisan serve --host=0.0.0.0 --port=8000
```

### Pour un serveur Apache/Nginx en production

**Apache avec PHP-FPM:**
Le fichier `public/.user.ini` est déjà configuré avec les bonnes limites.

**Nginx avec PHP-FPM:**
Ajoutez ces directives dans votre fichier de configuration nginx:
```nginx
client_max_body_size 100M;
```

Et dans votre fichier php.ini (généralement `/etc/php/8.x/fpm/php.ini`):
```ini
upload_max_filesize = 100M
post_max_size = 100M
max_execution_time = 300
```

Puis redémarrez PHP-FPM:
```bash
sudo systemctl restart php8.4-fpm
```

## Vérification

Pour vérifier les limites actuelles:
```bash
php -i | grep -E "(upload_max_filesize|post_max_size)"
```

## Fichiers de configuration créés

- `php-dev.ini` - Configuration PHP pour le développement
- `public/.user.ini` - Configuration pour PHP-FPM en production
- `serve.sh` - Script de démarrage avec configuration personnalisée
