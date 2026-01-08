# 📧 Configuration Email - Colibri Littéraire

## ✅ Système 100% Opérationnel

### Configuration Active

```
SMTP: smtp.gmail.com:587 (TLS)
From: colibrilitteraire@gmail.com
Logo: LOGO-COLIBRI-LITTERAIRE.png
Site: https://colibri-litteraire.com
```

## 📝 Commandes Utiles

### Vérifier la Queue

```bash
php artisan tinker --execute="
    echo 'Jobs en attente: ' . \DB::table('jobs')->count() . PHP_EOL;
    echo 'Jobs échoués: ' . \DB::table('failed_jobs')->count() . PHP_EOL;
"
```

### Traiter les Emails en Attente

```bash
# Option 1: Traiter tous les jobs
php artisan queue:work --stop-when-empty

# Option 2: Utiliser le script helper
./process-emails.sh

# Option 3: Worker permanent (développement)
php artisan queue:work
```

### Tester l'Envoi d'Email

```bash
php artisan tinker --execute="
    \$user = \App\Models\User::first();
    Mail::to(\$user->email)->send(new \App\Mail\User\WelcomeEmail(\$user));
    echo 'Email envoyé!';
"
```

## 🚀 Production - Worker Permanent

### Avec Supervisor (Recommandé)

1. Créer `/etc/supervisor/conf.d/colibri-worker.conf`
2. Configurer le worker
3. Lancer: `sudo supervisorctl start colibri-queue-worker:*`

### Avec Systemd

1. Créer `/etc/systemd/system/colibri-queue.service`
2. Activer: `sudo systemctl enable colibri-queue`
3. Lancer: `sudo systemctl start colibri-queue`

**Voir [CORRECTION_EMAIL_FINAL.md](CORRECTION_EMAIL_FINAL.md) pour les détails complets.**

## 📊 Emails Disponibles

- **WelcomeEmail** - Email de bienvenue après inscription
- **NewUserRegistration** - Notification admin nouveau compte
- **OrderConfirmation** - Confirmation de commande
- **PaymentConfirmation** - Confirmation de paiement formation

## ⚠️ Important

**Les emails sont mis en queue.** Sans worker actif, ils ne seront pas envoyés automatiquement.

En développement, exécuter manuellement:
```bash
php artisan queue:work --stop-when-empty
```

En production, configurer un worker permanent (voir ci-dessus).

## 📁 Fichiers de Documentation

- `CORRECTION_EMAIL_FINAL.md` - Documentation complète
- `CORRECTION_MAIL_ENCRYPTION.md` - Correction encryption TLS
- `PROBLEME_QUEUE_EMAIL.md` - Résolution problème queue
- `PROBLEME_EMAIL_CACHE.md` - Résolution problème cache
- `VERIFICATION_EMAIL_BIENVENUE.md` - Vérification système email

## 🎯 Statut Actuel

✅ Configuration SMTP validée
✅ Encryption TLS active
✅ Logo officiel intégré
✅ URLs de production configurées
✅ 0 jobs en attente
✅ 0 jobs échoués
✅ Tests validés

**Dernière mise à jour:** 2026-01-08
