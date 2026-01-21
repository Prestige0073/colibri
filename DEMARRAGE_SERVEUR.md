# Démarrage du Serveur - Colibri Littéraire

## ⚠️ IMPORTANT

**NE PAS utiliser** `php artisan serve` directement!

**TOUJOURS utiliser** le script `serve.sh` pour démarrer le serveur.

---

## Pourquoi?

Le script `serve.sh` charge la configuration PHP personnalisée qui permet:
- ✅ Upload de fichiers jusqu'à **512MB** (au lieu de 2MB)
- ✅ Mémoire de **1024MB** (au lieu de 128MB)
- ✅ Timeout de **600 secondes** (au lieu de 30s)

Sans cette configuration, les uploads de gros fichiers (blog, catalogue, formations) seront **REFUSÉS**.

---

## Démarrage du Serveur

### Méthode Correcte ✅

```bash
cd /home/shikataganai/Documents/web/Colibri_Littéraire
./serve.sh
```

### Méthode Incorrecte ❌

```bash
# ❌ NE PAS FAIRE CECI
php artisan serve
```

---

## Sortie du Script

Quand vous démarrez avec `./serve.sh`, vous verrez:

```
🚀 Démarrage du serveur Laravel avec configuration PHP personnalisée...
📁 Projet: Colibri Littéraire
⚙️  Configuration: php-dev.ini (512M upload, 1024M memory)

Limites configurées:
  - upload_max_filesize: 512M
  - post_max_size: 512M
  - memory_limit: 1024M
  - max_execution_time: 600s

🌐 Serveur accessible sur: http://0.0.0.0:8000
🌐 Ou sur: http://localhost:8000

Appuyez sur Ctrl+C pour arrêter le serveur
─────────────────────────────────────────────────────

   INFO  Server running on [http://0.0.0.0:8000].

  Press Ctrl+C to stop the server
```

---

## Vérification de la Configuration

Pour vérifier que la configuration est bien chargée:

```bash
# Dans un autre terminal (pendant que le serveur tourne)
php -c php-dev.ini -r "echo 'Upload max: ' . ini_get('upload_max_filesize') . PHP_EOL;"
```

**Résultat attendu**: `Upload max: 512M`

---

## Arrêt du Serveur

Appuyez sur **Ctrl+C** dans le terminal où le serveur tourne.

---

## Dépannage

### Problème: Permission Denied

```bash
chmod +x serve.sh
./serve.sh
```

### Problème: Fichier php-dev.ini Introuvable

Assurez-vous d'être dans le bon répertoire:

```bash
pwd
# Devrait afficher: /home/shikataganai/Documents/web/Colibri_Littéraire

ls php-dev.ini
# Devrait afficher: php-dev.ini
```

### Problème: Port 8000 Déjà Utilisé

```bash
# Trouver le processus qui utilise le port
sudo lsof -i :8000

# Ou tuer tous les processus PHP
pkill -f "php.*serve"

# Puis redémarrer
./serve.sh
```

---

## Configuration Complète

Le fichier `php-dev.ini` contient:

```ini
upload_max_filesize = 512M
post_max_size = 512M
max_execution_time = 600
max_input_time = 600
memory_limit = 1024M
```

---

**Date**: 21 Janvier 2026
**Développeur**: Claude (Assistant IA)
