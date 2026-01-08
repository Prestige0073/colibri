# 🔍 Diagnostic Erreur KKiaPay - "Unexpected end of JSON input"

## 📊 État Actuel

### Configuration Vérifiée
```bash
✅ KKIAPAY_PUBLIC_KEY=800b843c0b...
✅ KKIAPAY_PRIVATE_KEY=sk_6b1cec... (commence bien par sk_)
✅ KKIAPAY_SECRET=sk_6b1cec...
✅ KKIAPAY_SANDBOX=true
```

### Erreur JavaScript
```
Uncaught (in promise) SyntaxError: Unexpected end of JSON input
at JSON.parse (<anonymous>)
at LA (index.7dd3e927.js:1:162077)
at vB.createSession (index.7dd3e927.js:1:1293184)
```

## 🔎 Cause Probable

L'erreur se produit quand KKiaPay tente de créer une session de paiement mais reçoit une réponse vide ou invalide de leur API.

**Causes possibles :**

1. **Clés invalides ou expirées**
   - Les clés dans le `.env` ne sont pas valides
   - Les clés ne correspondent pas au mode (sandbox/production)

2. **Désynchronisation Sandbox/Production**
   - `KKIAPAY_SANDBOX=true` mais clés de production
   - Ou inversement

3. **Compte KKiaPay non activé**
   - Le compte sandbox n'est pas complètement configuré
   - Vérification d'email requise
   - Compte bloqué ou suspendu

4. **Problème de clés publique**
   - La clé publique `800b843c0b...` pourrait ne pas être la bonne
   - Vérifier qu'elle correspond bien au mode sandbox

## ✅ Solutions à Essayer

### Solution 1 : Vérifier les Clés sur le Dashboard

1. **Connectez-vous** à https://dashboard.kkiapay.me
2. **Allez dans** Settings → API Keys
3. **Vérifiez le mode actuel** : Test (Sandbox) ou Live (Production)
4. **Copiez EXACTEMENT** les 3 clés affichées :
   - Public Key
   - Private Key (ou API Key)
   - Secret Key

### Solution 2 : Utiliser les Clés de Test Officielles

KKiaPay fournit parfois des clés de test publiques. Essayez avec ces valeurs :

```bash
# Clés de test KKiaPay (si disponibles sur leur doc)
KKIAPAY_PUBLIC_KEY=votre_clé_test_publique
KKIAPAY_PRIVATE_KEY=votre_clé_test_privée
KKIAPAY_SECRET=votre_clé_test_secrète
KKIAPAY_SANDBOX=true
```

### Solution 3 : Passer en Mode Production Temporairement

Si votre compte production est activé, essayez :

```bash
KKIAPAY_PUBLIC_KEY=votre_clé_live_publique
KKIAPAY_PRIVATE_KEY=votre_clé_live_privée
KKIAPAY_SECRET=votre_clé_live_secrète
KKIAPAY_SANDBOX=false  # ⚠️ PRODUCTION - paiements réels
```

**⚠️ ATTENTION :** En mode production, les paiements sont réels !

### Solution 4 : Créer un Nouveau Compte Sandbox

1. Allez sur https://dashboard.kkiapay.me
2. Créez un nouveau compte
3. Activez le compte (vérification email)
4. Récupérez les clés de test
5. Mettez-les dans votre `.env`

### Solution 5 : Vérifier la Structure des Clés

Les clés KKiaPay ont généralement ces formats :

**Sandbox (Test) :**
```
Public Key: hash de 40 caractères OU pk_test_xxxxx
Private Key: sk_test_xxxxx (commence par sk_test_)
Secret: sk_test_xxxxx
```

**Production (Live) :**
```
Public Key: hash de 40 caractères OU pk_live_xxxxx
Private Key: sk_live_xxxxx (commence par sk_live_)
Secret: sk_live_xxxxx
```

Vérifiez si vos clés contiennent `_test_` ou `_live_` dans leur structure.

## 🧪 Test de Diagnostic

### Étape 1 : Vérifier dans la Console du Navigateur

Ouvrez la console de votre navigateur (F12) et exécutez :

```javascript
// Vérifier la clé publique utilisée
console.log('Public Key:', document.querySelector('script[src*="kkiapay"]'));

// Vérifier le mode sandbox
console.log('Widget config:', {
    sandbox: true,
    key: '800b843c0b0e20bf99c04262415e7c94bdcf2d34'
});
```

### Étape 2 : Test avec Clé Publique Simple

Essayez temporairement de changer uniquement la clé publique :

```bash
# Dans .env, essayez différentes valeurs pour PUBLIC_KEY
# Si vous avez plusieurs clés dans votre dashboard, testez-les une par une
```

### Étape 3 : Vérifier la Requête Réseau

Dans l'onglet **Network** de votre navigateur :
1. Rechargez la page de paiement
2. Cherchez les requêtes vers `kkiapay.me` ou `api.kkiapay.me`
3. Vérifiez la réponse de ces requêtes
4. Si la réponse est vide ou contient une erreur, notez le message

## 📞 Contact Support KKiaPay

Si rien ne fonctionne, contactez le support avec ces informations :

**Email :** support@kkiapay.me
**Téléphone :** +229 61 15 15 61

**Informations à fournir :**
- Erreur : "Unexpected end of JSON input" lors de l'initialisation du widget
- Mode : Sandbox
- Clé publique utilisée : `800b843c0b...` (10 premiers caractères)
- Navigateur : Chrome/Firefox/Safari (version)
- Message d'erreur complet de la console

## 🔄 Commandes à Exécuter Après Modification

Après chaque modification du `.env` :

```bash
# 1. Nettoyer les caches
php artisan config:clear
php artisan cache:clear

# 2. Vérifier la configuration
php artisan tinker --execute="
echo 'Public Key: ' . substr(config('services.kkiapay.public_key'), 0, 10) . '...' . PHP_EOL;
echo 'Private Key: ' . substr(config('services.kkiapay.private_key'), 0, 10) . '...' . PHP_EOL;
echo 'Sandbox: ' . (config('services.kkiapay.sandbox') ? 'true' : 'false') . PHP_EOL;
"

# 3. Tester dans le navigateur
```

## 📝 Checklist de Vérification

- [ ] Les clés sont copiées depuis le dashboard KKiaPay
- [ ] Le mode (sandbox/production) correspond aux clés
- [ ] Le compte KKiaPay est activé (email vérifié)
- [ ] La clé privée commence bien par `sk_`
- [ ] Les caches Laravel sont nettoyés
- [ ] La page est rechargée en mode incognito (Ctrl+Shift+N)
- [ ] La console du navigateur montre l'erreur exacte
- [ ] L'onglet Network montre les requêtes KKiaPay

## 💡 Solution Alternative : Test avec Widget Minimal

Créez une page de test minimaliste :

```html
<!DOCTYPE html>
<html>
<head>
    <title>Test KKiaPay</title>
    <script src="https://cdn.kkiapay.me/k.js"></script>
</head>
<body>
    <button onclick="openPayment()">Payer 100 FCFA</button>

    <script>
        function openPayment() {
            openKkiapayWidget({
                amount: 100,
                position: "center",
                callback: "",
                data: "test-123",
                theme: "#1e88e5",
                key: "800b843c0b0e20bf99c04262415e7c94bdcf2d34",
                sandbox: true
            });
        }

        addKkiapayListener('success', function(response) {
            console.log('Succès:', response);
            alert('Paiement réussi: ' + response.transactionId);
        });

        addKkiapayListener('failed', function(response) {
            console.log('Échec:', response);
            alert('Paiement échoué');
        });
    </script>
</body>
</html>
```

Testez cette page simple. Si elle fonctionne, le problème vient de l'intégration Laravel. Sinon, le problème vient des clés KKiaPay.

## 🎯 Prochaine Étape Recommandée

**ACTION IMMÉDIATE :**
1. Allez sur https://dashboard.kkiapay.me
2. Vérifiez que vous êtes en mode **Test/Sandbox**
3. Copiez les **3 clés exactement comme affichées**
4. Collez-les dans votre `.env`
5. Exécutez `php artisan config:clear`
6. Testez

Si le problème persiste, **contactez le support KKiaPay** avec le message d'erreur.

---

**Date :** 2026-01-08
**Statut :** 🔴 En cours de diagnostic
**Priorité :** URGENTE
