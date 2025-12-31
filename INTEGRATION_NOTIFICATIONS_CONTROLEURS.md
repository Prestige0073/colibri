# Intégration des Notifications dans les Contrôleurs

## ✅ Configuration Actuelle

### Emails créés
1. ✅ `WelcomeEmail` - Email de bienvenue utilisateur
2. ✅ `OrderConfirmation` - Confirmation de commande
3. ✅ `NewUserRegistration` - Notification admin nouveau user
4. ✅ `NewOrder` - Notification admin nouvelle commande
5. ✅ `PaymentConfirmation` - Confirmation paiement
6. ✅ `NewPayment` - Notification admin paiement
7. ✅ `FormationEnrollment` - Inscription formation
8. ✅ `NewFormationEnrollment` - Notification admin formation
9. ✅ `NewContact` - Notification admin contact

### Templates créés
1. ✅ `emails/layouts/template.blade.php` - Template de base
2. ✅ `emails/user/welcome.blade.php` - Bienvenue
3. ✅ `emails/user/order-confirmation.blade.php` - Confirmation commande
4. ✅ `emails/admin/new-user.blade.php` - Nouveau user
5. ✅ `emails/admin/new-order.blade.php` - Nouvelle commande

## 📝 Modifications à faire dans les Contrôleurs

### 1. Inscription Utilisateur

**Fichier**: Chercher où l'utilisateur est créé (probablement `app/Http/Controllers/Auth/RegisterController.php` ou dans `routes/web.php` si custom)

**Ajouter en haut du fichier**:
```php
use App\Mail\User\WelcomeEmail;
use App\Mail\Admin\NewUserRegistration;
use Illuminate\Support\Facades\Mail;
```

**Après la création de l'utilisateur, ajouter**:
```php
// Envoyer email de bienvenue à l'utilisateur
Mail::to($user->email)->queue(new WelcomeEmail($user));

// Notifier l'admin
Mail::to(config('mail.from_address'))->queue(new NewUserRegistration($user));
```

**Exemple complet**:
```php
// Dans la méthode register() ou create()
$user = User::create([
    'name' => $data['name'],
    'email' => $data['email'],
    'password' => Hash::make($data['password']),
]);

// ===== AJOUTER ICI =====
Mail::to($user->email)->queue(new WelcomeEmail($user));
Mail::to(config('mail.from_address'))->queue(new NewUserRegistration($user));
// =======================

Auth::login($user);
return redirect('/');
```

---

### 2. Nouvelle Commande

**Fichier**: Chercher `CommandeController.php` ou `PanierController.php` - méthode qui crée la commande

**Imports à ajouter**:
```php
use App\Mail\User\OrderConfirmation;
use App\Mail\Admin\NewOrder;
use Illuminate\Support\Facades\Mail;
```

**Après création/validation de la commande**:
```php
// Confirmer la commande au client
Mail::to($commande->user->email)->queue(new OrderConfirmation($commande));

// Notifier l'admin
Mail::to(config('mail.from_address'))->queue(new NewOrder($commande));
```

**Exemple**: Dans `CommandeController::storeCod()` ou similaire:
```php
$commande = Commande::create([
    'user_id' => auth()->id(),
    'total' => $total,
    'statut' => 'en_attente',
    'methode_paiement' => 'cod',
    // ...
]);

// Items de commande
foreach ($panier as $item) {
    $commande->items()->create([...]);
}

// ===== AJOUTER ICI =====
Mail::to($commande->user->email)->queue(new OrderConfirmation($commande));
Mail::to(config('mail.from_address'))->queue(new NewOrder($commande));
// =======================

return redirect()->route('commandes.show', $commande);
```

---

### 3. Paiement

**Fichier**: `PaiementController.php` - callbacks de paiement (KKiaPay, Lygos, PayPal)

**Imports**:
```php
use App\Mail\User\PaymentConfirmation;
use App\Mail\Admin\NewPayment;
use Illuminate\Support\Facades\Mail;
```

**Dans chaque callback de succès (kkiapayCallback, lygosCallback, paypalCallback)**:
```php
// Après validation du paiement
$inscription->statut_paiement = 'payé';
$inscription->save();

// ===== AJOUTER ICI =====
Mail::to($inscription->user->email)->queue(new PaymentConfirmation($inscription));
Mail::to(config('mail.from_address'))->queue(new NewPayment($inscription));
// =======================
```

---

### 4. Inscription Formation

**Fichier**: Chercher où `Inscription::create()` est appelée (probablement dans `FormationController` ou `InscriptionController`)

**Imports**:
```php
use App\Mail\User\FormationEnrollment;
use App\Mail\Admin\NewFormationEnrollment;
use Illuminate\Support\Facades\Mail;
```

**Après création de l'inscription**:
```php
$inscription = Inscription::create([
    'user_id' => auth()->id(),
    'formation_id' => $formation->id(),
    // ...
]);

// ===== AJOUTER ICI =====
Mail::to($inscription->user->email)->queue(new FormationEnrollment($inscription));
Mail::to(config('mail.from_address'))->queue(new NewFormationEnrollment($inscription));
// =======================
```

---

### 5. Contact

**Fichier**: `ContactController.php` - méthode `store()`

**Imports**:
```php
use App\Mail\Admin\NewContact;
use Illuminate\Support\Facades\Mail;
```

**Après création du message**:
```php
$contact = Contact::create([
    'nom' => $request->nom,
    'email' => $request->email,
    'objet' => $request->objet,
    'message' => $request->message,
]);

// ===== AJOUTER ICI =====
Mail::to(config('mail.from_address'))->queue(new NewContact($contact));
// =======================

return back()->with('success', 'Message envoyé avec succès!');
```

---

## 🔧 Configuration de la Queue

### 1. Créer la table jobs
```bash
php artisan queue:table
php artisan migrate
```

### 2. Configurer .env
Vérifier que:
```
QUEUE_CONNECTION=database
```

### 3. Lancer le worker (en développement)
```bash
php artisan queue:work
```

### 4. En production (avec supervisor ou systemd)
Créer un service qui lance:
```bash
php artisan queue:work --daemon --tries=3
```

---

## 🧪 Test des Emails

### Test manuel via Tinker
```bash
php artisan tinker
```

```php
// Test email bienvenue
$user = App\Models\User::first();
Mail::to('test@example.com')->send(new App\Mail\User\WelcomeEmail($user));

// Test commande
$commande = App\Models\Commande::first();
Mail::to('test@example.com')->send(new App\Mail\User\OrderConfirmation($commande));
```

### Vérifier les logs
```bash
tail -f storage/logs/laravel.log
```

### Vérifier la queue
```bash
php artisan queue:work --once
```

---

## ⚠️ Points d'Attention

### 1. Relations Eloquent
Assurez-vous que les relations sont bien définies:
- `Commande` → `user()`, `items()`
- `CommandeItem` → `catalogue()`
- `Inscription` → `user()`, `formation()`
- `Contact` → aucune relation nécessaire

### 2. Gestion des erreurs
Entourer l'envoi d'emails dans un try-catch pour ne pas bloquer le processus:
```php
try {
    Mail::to($user->email)->queue(new WelcomeEmail($user));
} catch (\Exception $e) {
    \Log::error('Erreur envoi email: ' . $e->getMessage());
}
```

### 3. Limite Gmail
- Maximum ~500 emails/jour
- Pour production, considérer SendGrid, Mailgun, AWS SES

### 4. Test en local
Si Gmail bloque en local, utiliser Mailtrap:
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=votre_username
MAIL_PASSWORD=votre_password
```

---

## 📋 Checklist d'Intégration

- [ ] Modifier RegisterController pour envoi bienvenue
- [ ] Modifier CommandeController pour confirmation commande
- [ ] Modifier PaiementController (3 callbacks) pour confirmation paiement
- [ ] Modifier FormationController pour inscription formation
- [ ] Modifier ContactController pour notification admin
- [ ] Créer table queue (`php artisan queue:table && migrate`)
- [ ] Lancer queue worker
- [ ] Tester chaque type d'email
- [ ] Vérifier logs d'erreurs
- [ ] Documenter pour l'équipe

---

## 🚀 Prochaines Étapes

Une fois l'intégration terminée:
1. Créer les emails restants (certificat, emprunt, etc.)
2. Ajouter des templates PDF pour les factures
3. Créer une interface admin pour voir l'historique des emails
4. Implémenter des notifications SMS (optionnel)
5. Ajouter des webhooks pour suivre les ouvertures d'emails
