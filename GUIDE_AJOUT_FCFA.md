# 📘 GUIDE COMPLET - Ajout de "FCFA" sur tous les prix

**Date :** 2026-01-07
**Objectif :** Ajouter "FCFA" après chaque prix affiché sur le site (utilisateur + admin)
**Solution :** Helper global `fcfa()` ou `format_price()`

---

## ✅ HELPER CRÉÉ

### Fichier
`app/Helpers/PriceHelper.php`

### Fonctions disponibles

```php
// Fonction complète
format_price($price, $showCurrency = true)
// Exemple : format_price(15000) → "15 000 FCFA"
// Exemple : format_price(15000, false) → "15 000"

// Alias court (recommandé)
fcfa($price)
// Exemple : fcfa(15000) → "15 000 FCFA"
```

### Chargement
✅ Ajouté dans `composer.json` → `autoload > files`
✅ `composer dump-autoload` exécuté

---

## 🔄 PATTERNS À REMPLACER

### Pattern 1 : `{{ $variable->prix }}`
**AVANT :**
```blade
<p>Prix : {{ $formation->prix }}</p>
```

**APRÈS :**
```blade
<p>Prix : {{ fcfa($formation->prix) }}</p>
```

### Pattern 2 : `{{ number_format($prix) }}`
**AVANT :**
```blade
<p>{{ number_format($livre->prix, 0, ',', ' ') }}</p>
```

**APRÈS :**
```blade
<p>{{ fcfa($livre->prix) }}</p>
```

### Pattern 3 : Prix avec "€" ou "$"
**AVANT :**
```blade
<p>{{ $prix }}€</p>
```

**APRÈS :**
```blade
<p>{{ fcfa($prix) }}</p>
```

### Pattern 4 : Total
**AVANT :**
```blade
<strong>Total : {{ $commande->total }}</strong>
```

**APRÈS :**
```blade
<strong>Total : {{ fcfa($commande->total) }}</strong>
```

---

## 📋 FICHIERS À MODIFIER (Par Priorité)

### 🔴 PRIORITÉ 1 - Vues Utilisateur Principales (10 fichiers)

| Fichier | Variable Prix | Ligne Approx. |
|---------|---------------|---------------|
| `resources/views/formation/show.blade.php` | `$formation->prix` | Multiple |
| `resources/views/catalogue/decouvrir.blade.php` | `$livre->prix` | Multiple |
| `resources/views/panier/index.blade.php` | `$item->prix`, `$total` | Multiple |
| `resources/views/panier/paiement.blade.php` | `$total` | Multiple |
| `resources/views/account/commandes.blade.php` | `$commande->total` | Multiple |
| `resources/views/formation/modules.blade.php` | `$formation->prix` | Si affiché |
| `resources/views/catalogue/acheter.blade.php` | `$livre->prix` | Multiple |
| `resources/views/commandes/show.blade.php` | `$commande->total` | Multiple |
| `resources/views/formation/paiement.blade.php` | `$formation->prix` | Multiple |
| `resources/views/paiement/show.blade.php` | Divers prix | Multiple |

### 🟠 PRIORITÉ 2 - Vues Admin (15 fichiers)

| Fichier | Variable Prix | Notes |
|---------|---------------|-------|
| `resources/views/admin/dashboard.blade.php` | Statistiques | Totaux, ventes |
| `resources/views/admin/formations/index.blade.php` | `$formation->prix` | Liste |
| `resources/views/admin/formations/show.blade.php` | `$formation->prix` | Détail |
| `resources/views/admin/formations/edit.blade.php` | Input prix | Label "FCFA" |
| `resources/views/admin/formations/create.blade.php` | Input prix | Label "FCFA" |
| `resources/views/admin/catalogue.blade.php` | `$livre->prix` | Liste |
| `resources/views/admin/commandes.blade.php` | `$commande->total` | Liste |
| `resources/views/admin/commandes_show.blade.php` | Détails commande | Totaux |
| `resources/views/admin/achats.blade.php` | Transactions | Prix |
| `resources/views/admin/users/show.blade.php` | Achats user | Prix |
| `resources/views/admin/donations.blade.php` | Montants | Si applicable |

### 🟡 PRIORITÉ 3 - Emails & Paiement (10 fichiers)

| Fichier | Variable Prix |
|---------|---------------|
| `resources/views/emails/user/payment-confirmation.blade.php` | `$prix` |
| `resources/views/emails/user/order-confirmation.blade.php` | `$total` |
| `resources/views/emails/admin/new-payment.blade.php` | `$prix` |
| `resources/views/emails/admin/new-order.blade.php` | `$total` |
| `resources/views/paiement/kkiapay.blade.php` | `$montant` |
| `resources/views/paiement/paypal.blade.php` | `$montant` |
| `resources/views/paiement/lygos.blade.php` | `$montant` |
| `resources/views/paiement/catalogue/*.blade.php` | `$montant` |

### 🟢 PRIORITÉ 4 - Pages Secondaires (Reste)

- `resources/views/index.blade.php`
- `resources/views/about.blade.php`
- `resources/views/feature.blade.php`
- Etc.

---

## 🛠️ FORMULAIRES - Labels "FCFA"

### Pattern Formulaire
**AVANT :**
```blade
<label>Prix</label>
<input type="number" name="prix" placeholder="Ex: 15000">
```

**APRÈS :**
```blade
<label>Prix (FCFA)</label>
<input type="number" name="prix" placeholder="Ex: 15000" step="1" min="0">
<small class="text-muted">Montant en Francs CFA</small>
```

---

## ✅ LISTE DE VÉRIFICATION

### Vues Utilisateur
- [ ] Formation (liste)
- [ ] Formation (détail)
- [ ] Catalogue (liste livres)
- [ ] Panier
- [ ] Paiement
- [ ] Commandes (liste)
- [ ] Commandes (détail)
- [ ] Emprunts (si prix)
- [ ] Index/Accueil

### Vues Admin
- [ ] Dashboard (statistiques)
- [ ] Formations (liste, détail, créer, éditer)
- [ ] Catalogue (liste, détail, créer, éditer)
- [ ] Commandes (liste, détail)
- [ ] Users (détail avec achats)
- [ ] Achats/Transactions

### Emails
- [ ] Confirmation paiement utilisateur
- [ ] Confirmation commande utilisateur
- [ ] Notification admin nouveau paiement
- [ ] Notification admin nouvelle commande

### Pages Paiement
- [ ] KKiaPay
- [ ] PayPal
- [ ] Lygos
- [ ] COD (si prix affiché)

---

## 🧪 TESTS À FAIRE

### Test 1 : Pages Utilisateur
1. Aller sur `/formations`
2. ✅ Vérifier : Prix affiché avec "FCFA"
3. Cliquer sur une formation
4. ✅ Vérifier : Prix formatté "X XXX FCFA"

### Test 2 : Panier
1. Ajouter un livre au panier
2. ✅ Vérifier : Prix unitaire en FCFA
3. ✅ Vérifier : Total en FCFA

### Test 3 : Admin
1. Connexion admin
2. Dashboard → ✅ Totaux en FCFA
3. Formations → ✅ Prix en FCFA
4. Catalogue → ✅ Prix en FCFA

### Test 4 : Emails
1. Faire un achat
2. ✅ Email confirmation : Prix en FCFA
3. ✅ Email admin : Prix en FCFA

---

## 📝 COMMANDES UTILES

### Rechercher tous les prix non formatés
```bash
grep -r "\$.*->prix" resources/views/ | grep -v "fcfa"
grep -r "\$.*->total" resources/views/ | grep -v "fcfa"
grep -r "number_format" resources/views/ | grep -v "fcfa"
```

### Vider caches après modifications
```bash
php artisan view:clear
php artisan cache:clear
```

---

## 💡 EXEMPLES CONCRETS

### Exemple 1 : Formation
```blade
<!-- AVANT -->
<div class="price">{{ $formation->prix }}€</div>

<!-- APRÈS -->
<div class="price">{{ fcfa($formation->prix) }}</div>
```

### Exemple 2 : Total Panier
```blade
<!-- AVANT -->
<h3>Total : {{ number_format($total, 2) }} €</h3>

<!-- APRÈS -->
<h3>Total : {{ fcfa($total) }}</h3>
```

### Exemple 3 : Input Admin
```blade
<!-- AVANT -->
<input type="number" name="prix" placeholder="Prix">

<!-- APRÈS -->
<label for="prix">Prix (FCFA)</label>
<input type="number" name="prix" id="prix" placeholder="15000" min="0">
<small class="form-text text-muted">Montant en Francs CFA</small>
```

---

## 🎯 OBJECTIF FINAL

**TOUS les prix du site doivent être formatés ainsi :**
- `15 000 FCFA` (avec espace comme séparateur de milliers)
- Pas de centimes (0 décimales)
- "FCFA" toujours affiché

**Exception :** Formulaires de saisie → Juste le label "(FCFA)"

---

**Prochaine étape :** Modifier les fichiers un par un en commençant par la Priorité 1.
