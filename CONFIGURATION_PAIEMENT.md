# Configuration des Moyens de Paiement

Ce document explique comment configurer les différentes plateformes de paiement intégrées dans Colibri Littéraire.

## 🎯 Vue d'ensemble

Le système de paiement supporte trois plateformes :
1. **Kkiapay** - Mobile Money (MTN, Moov) et cartes bancaires (Afrique)
2. **Lygos** - Paiement sécurisé en ligne
3. **PayPal** - Paiement international

## 📋 Flux de paiement

1. L'utilisateur clique sur "Acheter / S'inscrire" sur une formation
2. Une inscription est créée avec `paiement_valide = false`
3. L'utilisateur est redirigé vers la page de sélection du moyen de paiement
4. Il choisit parmi Kkiapay, Lygos ou PayPal
5. Il est redirigé vers la plateforme de paiement
6. Après paiement, la plateforme renvoie vers notre callback
7. On valide le paiement et on met à jour l'inscription

## 🔧 Configuration Kkiapay

### 1. Créer un compte Kkiapay
- Rendez-vous sur [https://kkiapay.me](https://kkiapay.me)
- Créez un compte marchand
- Vérifiez votre identité

### 2. Obtenir les clés API
- Connectez-vous à votre tableau de bord Kkiapay
- Allez dans "Paramètres" > "Clés API"
- Copiez votre **Clé Publique** et **Clé Privée**

### 3. Configuration dans l'application

Ajoutez dans votre fichier `.env` :
```env
KKIAPAY_PUBLIC_KEY=votre_cle_publique_kkiapay
KKIAPAY_PRIVATE_KEY=votre_cle_privee_kkiapay
KKIAPAY_SECRET=votre_secret_kkiapay
KKIAPAY_SANDBOX=true  # false en production
```

### 4. Modifier le fichier de vue

Dans `resources/views/paiement/kkiapay.blade.php`, ligne 60 :
```javascript
key: "{{ env('KKIAPAY_PUBLIC_KEY') }}",
sandbox: {{ env('KKIAPAY_SANDBOX', 'true') ? 'true' : 'false' }}
```

### 5. Documentation Kkiapay
- [Documentation officielle](https://docs.kkiapay.me)
- [SDK JavaScript](https://docs.kkiapay.me/v1/sdk-javascript)

---

## 🔧 Configuration Lygos

### 1. Créer un compte Lygos
- Contactez Lygos pour obtenir un compte marchand
- Obtenez vos identifiants API

### 2. Configuration dans l'application

Ajoutez dans votre fichier `.env` :
```env
LYGOS_API_KEY=votre_cle_api_lygos
LYGOS_SECRET_KEY=votre_cle_secrete_lygos
LYGOS_MERCHANT_ID=votre_merchant_id
LYGOS_SANDBOX=true  # false en production
```

### 3. Implémenter l'API Lygos

Dans `app/Http/Controllers/PaiementController.php`, méthode `lygos()` :
```php
// Créer une transaction Lygos
$response = Http::post('https://api.lygos.com/v1/transactions', [
    'amount' => $montant,
    'merchant_id' => env('LYGOS_MERCHANT_ID'),
    'api_key' => env('LYGOS_API_KEY'),
    // ... autres paramètres
]);
```

---

## 🔧 Configuration PayPal

### 1. Créer un compte PayPal Business
- Rendez-vous sur [https://www.paypal.com/businessmanage](https://www.paypal.com/businessmanage)
- Créez un compte Business
- Vérifiez votre compte

### 2. Obtenir les clés API
- Connectez-vous à votre compte PayPal
- Allez dans "Développeur" > "Mes Apps & Identifiants"
- Créez une nouvelle application
- Copiez le **Client ID** et le **Secret**

### 3. Configuration dans l'application

Ajoutez dans votre fichier `.env` :
```env
PAYPAL_CLIENT_ID=votre_client_id_paypal
PAYPAL_SECRET=votre_secret_paypal
PAYPAL_MODE=sandbox  # live en production
```

### 4. Modifier le fichier de vue

Dans `resources/views/paiement/paypal.blade.php`, ligne 42 :
```html
<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&currency=EUR"></script>
```

### 5. Documentation PayPal
- [Documentation officielle](https://developer.paypal.com/docs/api/overview/)
- [SDK JavaScript](https://developer.paypal.com/sdk/js/)

---

## 🔒 Sécurité

### Validation des paiements

Pour chaque plateforme, il est **CRUCIAL** de valider les paiements côté serveur avant de marquer l'inscription comme payée.

#### Exemple pour Kkiapay :
```php
public function kkiapayCallback(Request $request)
{
    $transactionId = $request->input('transaction_id');

    // Vérifier la transaction auprès de Kkiapay
    $response = Http::withHeaders([
        'x-api-key' => env('KKIAPAY_PRIVATE_KEY')
    ])->get("https://api.kkiapay.me/api/v1/transactions/{$transactionId}");

    if ($response->successful() && $response->json('status') === 'SUCCESS') {
        // Valider le paiement
        $inscription->update([
            'paiement_valide' => true,
            'reference_paiement' => $transactionId,
        ]);
    }
}
```

### Webhooks

Configurez les webhooks pour être notifié automatiquement des paiements :

- **Kkiapay** : `https://votre-domaine.com/webhooks/kkiapay`
- **Lygos** : `https://votre-domaine.com/webhooks/lygos`
- **PayPal** : `https://votre-domaine.com/webhooks/paypal`

---

## 🧪 Tests

### Mode Sandbox

Tous les modes sandbox sont activés par défaut. Pour tester :

1. **Kkiapay Sandbox** :
   - Utilisez les numéros de test fournis par Kkiapay
   - MTN : +22997000001
   - Moov : +22996000001

2. **PayPal Sandbox** :
   - Créez des comptes de test dans le Developer Dashboard
   - Utilisez les comptes sandbox pour simuler les paiements

3. **Lygos** :
   - Contactez Lygos pour obtenir des identifiants de test

### Passage en production

1. Changez `KKIAPAY_SANDBOX=false` dans `.env`
2. Changez `PAYPAL_MODE=live` dans `.env`
3. Remplacez toutes les clés de test par les clés de production
4. Testez avec de petits montants réels avant le déploiement

---

## 📊 Suivi des transactions

Les informations de paiement sont stockées dans la table `formation_inscriptions` :

- `paiement_valide` : Boolean (true si payé)
- `reference_paiement` : ID de transaction de la plateforme
- `montant_paye` : Montant en FCFA

Pour voir l'historique :
```sql
SELECT * FROM formation_inscriptions WHERE paiement_valide = true;
```

---

## 🆘 Support

En cas de problème :

1. Vérifiez les logs Laravel : `storage/logs/laravel.log`
2. Consultez la console du navigateur pour les erreurs JavaScript
3. Vérifiez que les clés API sont correctes
4. Assurez-vous que le mode sandbox est activé pour les tests

---

## 📝 Notes importantes

- Les montants sont en **FCFA** pour Kkiapay et Lygos
- PayPal utilise l'**EUR** (conversion automatique : 1 EUR ≈ 655.957 FCFA)
- Ne stockez **jamais** les informations de carte bancaire
- Utilisez **HTTPS** en production
- Testez tous les scénarios (succès, échec, annulation)
