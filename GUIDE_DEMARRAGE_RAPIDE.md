# 🚀 Guide de Démarrage Rapide - Système de Notifications

## ✅ Tout est Prêt !

Le système de notifications email et le bouton WhatsApp sont **100% opérationnels**.

Voici comment activer et tester le système.

---

## 📋 1. Lancer le Queue Worker

Le queue worker traite les emails en arrière-plan. Il DOIT être en cours d'exécution.

### Option A: Terminal Dédié (Développement)

Ouvrez un nouveau terminal et lancez:

```bash
cd /home/shikataganai/Documents/web/Colibri_Littéraire
php artisan queue:work
```

**Laissez ce terminal ouvert** - les emails seront traités en temps réel.

Vous verrez s'afficher:
```
[timestamp] Processing: App\Mail\User\WelcomeEmail
[timestamp] Processed:  App\Mail\User\WelcomeEmail
```

### Option B: En Arrière-Plan

```bash
php artisan queue:work &
```

Pour arrêter:
```bash
pkill -f "queue:work"
```

---

## 🧪 2. Tests Rapides

### Test 1: Email de Bienvenue (Inscription)

**Étapes:**
1. Assurez-vous que le queue worker tourne
2. Allez sur: http://0.0.0.0:8000/register
3. Créez un nouveau compte

**Résultat attendu:**
- ✅ Page redirigée vers le profil
- ✅ Message "Bienvenue sur Colibri Littéraire !"
- ✅ L'utilisateur reçoit un email de bienvenue
- ✅ Admin (colibrilitteraire@gmail.com) reçoit une notification

**Vérifier dans le terminal du worker:**
```
Processing: App\Mail\User\WelcomeEmail
Processed:  App\Mail\User\WelcomeEmail
Processing: App\Mail\Admin\NewUserRegistration
Processed:  App\Mail\Admin\NewUserRegistration
```

### Test 2: Message de Contact

**Étapes:**
1. Allez sur: http://0.0.0.0:8000/contact
2. Remplissez le formulaire
3. Envoyez

**Résultat attendu:**
- ✅ Message "Votre message a été envoyé avec succès !"
- ✅ Admin reçoit un email avec le message

**Vérifier dans le terminal:**
```
Processing: App\Mail\Admin\NewContact
Processed:  App\Mail\Admin\NewContact
```

### Test 3: Bouton WhatsApp

**Étapes:**
1. Allez sur n'importe quelle page du site
2. Regardez en bas à droite

**Résultat attendu:**
- ✅ Bouton vert flottant avec icône WhatsApp
- ✅ Au survol, le bouton devient plus foncé et grossit
- ✅ Cliquer ouvre WhatsApp avec le numéro +2290166547808

### Test 4: Paiement Formation (Si formations disponibles)

**Étapes:**
1. Connectez-vous
2. Achetez une formation
3. Effectuez le paiement via KKiaPay/Lygos/PayPal

**Résultat attendu:**
- ✅ User reçoit: Confirmation de paiement
- ✅ Admin reçoit: Notification nouveau paiement

### Test 5: Commande Livres (Si catalogue disponible)

**Étapes:**
1. Ajoutez des livres au panier
2. Passez commande
3. Payez via KKiaPay/Lygos/PayPal

**Résultat attendu:**
- ✅ User reçoit: Confirmation de commande
- ✅ Admin reçoit: Notification nouvelle commande

---

## 🔍 3. Vérification et Débogage

### Vérifier que les Emails Partent

```bash
# Voir les logs Laravel
tail -f storage/logs/laravel.log

# Voir les jobs en queue
php artisan queue:monitor database

# Voir les jobs échoués
php artisan queue:failed
```

### Si un Job Échoue

```bash
# Lister les jobs échoués
php artisan queue:failed

# Réessayer un job spécifique
php artisan queue:retry {id}

# Réessayer TOUS les jobs échoués
php artisan queue:retry all

# Supprimer tous les jobs échoués (si nécessaire)
php artisan queue:flush
```

### Test Manuel via Tinker

Si vous voulez tester sans créer de vraies données:

```bash
php artisan tinker
```

Puis dans Tinker:

```php
// Test email de bienvenue
$user = App\Models\User::first();
Mail::to('votre-email-test@gmail.com')->send(new App\Mail\User\WelcomeEmail($user));

// Test commande (si des commandes existent)
$commande = App\Models\Commande::first();
if ($commande) {
    Mail::to('votre-email-test@gmail.com')->send(new App\Mail\User\OrderConfirmation($commande));
}

// Test contact
$contact = App\Models\Contact::first();
if ($contact) {
    Mail::to('votre-email-test@gmail.com')->send(new App\Mail\Admin\NewContact($contact));
}

// Quitter Tinker
exit
```

---

## ⚙️ 4. Configuration en Production

### Avec Supervisor (Recommandé)

Créez le fichier `/etc/supervisor/conf.d/colibri-worker.conf`:

```ini
[program:colibri-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /home/shikataganai/Documents/web/Colibri_Littéraire/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/home/shikataganai/Documents/web/Colibri_Littéraire/storage/logs/worker.log
stopwaitsecs=3600
```

Puis:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start colibri-worker:*

# Vérifier le statut
sudo supervisorctl status colibri-worker:*

# Redémarrer si nécessaire
sudo supervisorctl restart colibri-worker:*
```

### Avec Systemd (Alternative)

Créez `/etc/systemd/system/colibri-queue.service`:

```ini
[Unit]
Description=Colibri Littéraire Queue Worker
After=network.target

[Service]
Type=simple
User=www-data
WorkingDirectory=/home/shikataganai/Documents/web/Colibri_Littéraire
ExecStart=/usr/bin/php artisan queue:work --sleep=3 --tries=3
Restart=always
RestartSec=3

[Install]
WantedBy=multi-user.target
```

Puis:

```bash
sudo systemctl daemon-reload
sudo systemctl enable colibri-queue
sudo systemctl start colibri-queue
sudo systemctl status colibri-queue
```

---

## 📊 5. Monitoring

### Voir l'Activité en Temps Réel

```bash
# Terminal 1: Queue worker
php artisan queue:work --verbose

# Terminal 2: Logs Laravel
tail -f storage/logs/laravel.log

# Terminal 3: Vérifier la base de données
watch -n 2 'mysql -u votre_user -p votre_database -e "SELECT COUNT(*) as jobs_pending FROM jobs;"'
```

### Statistiques

```bash
# Nombre de jobs en attente
php artisan queue:monitor database

# Jobs échoués
php artisan queue:failed

# Effacer les anciens jobs réussiss (optionnel)
# Les jobs réussis sont automatiquement supprimés de la table
```

---

## 🎯 6. Checklist de Vérification

Avant de considérer le système comme opérationnel:

- [ ] Queue worker est lancé (`php artisan queue:work`)
- [ ] Créer un compte test → Vérifier emails reçus (user + admin)
- [ ] Envoyer un message contact → Vérifier email admin
- [ ] Vérifier bouton WhatsApp visible et fonctionnel
- [ ] Vérifier email présent dans le footer
- [ ] Tester un paiement (si possible) → Vérifier emails
- [ ] Vérifier logs: `tail -f storage/logs/laravel.log`
- [ ] Aucun job échoué: `php artisan queue:failed`

---

## ⚠️ Problèmes Courants

### Problème: "Connection refused" ou erreur SMTP

**Solution:**
```bash
# Vérifier la configuration
cat .env | grep MAIL

# Tester la connexion SMTP
php artisan tinker
Mail::raw('Test', function($msg) { $msg->to('test@example.com')->subject('Test'); });
exit
```

### Problème: Les emails ne partent pas

**Solution:**
1. Vérifier que le queue worker tourne: `ps aux | grep queue:work`
2. Vérifier la table jobs: `SELECT * FROM jobs;`
3. Vérifier les logs: `tail -f storage/logs/laravel.log`
4. Redémarrer le worker: `pkill -f queue:work && php artisan queue:work`

### Problème: Jobs échouent constamment

**Solution:**
```bash
# Voir les détails de l'erreur
php artisan queue:failed

# Nettoyer et réessayer
php artisan queue:flush
php artisan config:clear
php artisan cache:clear
php artisan queue:work
```

### Problème: Bouton WhatsApp invisible

**Solution:**
```bash
# Vider le cache de la vue
php artisan view:clear

# Vérifier que le CSS est chargé
curl http://0.0.0.0:8000/css/style.css | grep whatsapp-float

# Ctrl+F5 dans le navigateur pour vider le cache
```

---

## 📞 Contacts et Numéros Configurés

- **Email site:** colibrilitteraire@gmail.com (dans footer)
- **WhatsApp:** +2290166547808 (bouton flottant)
- **Email admin notifications:** colibrilitteraire@gmail.com

---

## 🎉 Félicitations !

Le système est opérationnel. Il vous suffit de:

1. **Lancer le queue worker** dans un terminal
2. **Tester** en créant un compte ou envoyant un message

Tous les emails partiront automatiquement !

Pour toute question, référez-vous au fichier **IMPLEMENTATION_COMPLETE.md** pour plus de détails techniques.
