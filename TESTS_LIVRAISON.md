# Guide de Test - Système de Livraison à Domicile

## Prérequis

Avant de commencer les tests:
1. ✅ Serveur Laravel lancé: `php artisan serve`
2. ✅ Base de données accessible
3. ✅ Compte utilisateur créé
4. ✅ Au moins un livre dans le catalogue

## Test 1: Flux complet utilisateur

### Étapes:

1. **Connexion**
   - URL: `http://0.0.0.0:8000/login`
   - Se connecter avec un compte utilisateur valide

2. **Ajout au panier**
   - Aller sur: `http://0.0.0.0:8000/catalogue/emprunts`
   - Cliquer sur "Ajouter au panier" pour 1-3 livres
   - Vérifier que le compteur du panier s'incrémente

3. **Voir le panier**
   - Aller sur: `http://0.0.0.0:8000/panier`
   - Vérifier que les livres ajoutés sont affichés
   - Noter le total

4. **Accéder au paiement**
   - Cliquer sur "Procéder au paiement"
   - Ou aller directement sur: `http://0.0.0.0:8000/paiement`
   - La page doit se charger rapidement (< 2 secondes)

5. **Vérifier la page de paiement**
   - ✅ Section "Résumé de votre commande" visible
   - ✅ Section "Paiement en ligne" avec 3 options (Kkiapay, Lygos, PayPal)
   - ✅ Section "Livraison à domicile" avec fond jaune EN BAS
   - ✅ Bouton "Commander avec livraison à domicile" visible

6. **Ouvrir la console du navigateur**
   - Chrome/Edge: F12 ou Ctrl+Shift+I
   - Firefox: F12 ou Ctrl+Shift+K
   - Safari: Cmd+Option+I
   - Onglet "Console"

7. **Cliquer sur "Commander avec livraison à domicile"**

   **Attendu dans la console**:
   ```
   Bouton livraison cliqué
   Envoi de la requête AJAX...
   Réponse reçue, status: 200
   Données reçues: {success: true, message: "...", commande_id: 123, redirect_url: "..."}
   Commande créée avec succès, ID: 123
   ```

   **Attendu visuellement**:
   - Modal de chargement apparaît immédiatement (spinner)
   - Modal disparaît après 1-3 secondes
   - Modal de confirmation apparaît avec:
     - ✅ Icône de camion
     - ✅ "Votre commande a été enregistrée avec succès !"
     - ✅ Numéro de commande: #123
     - ✅ Message "Vous payerez à la réception..."
     - ✅ Bouton "Voir mes commandes"
     - ✅ Bouton "Continuer mes achats"

8. **Cliquer sur "Voir mes commandes"**
   - Redirigé vers: `http://0.0.0.0:8000/account/commandes`
   - La commande doit apparaître dans la liste
   - Vérifier:
     - ✅ Numéro de commande (même que dans le modal)
     - ✅ Date et heure actuelles
     - ✅ Total correct
     - ✅ Badge "En préparation" (jaune/warning)
     - ✅ Liste des livres commandés

9. **Vérifier que le panier est vide**
   - Aller sur: `http://0.0.0.0:8000/panier`
   - Le panier doit être vide
   - Message: "Votre panier est vide."

## Test 2: Vérification admin

1. **Se connecter en tant qu'admin**
   - URL: `http://0.0.0.0:8000/login`
   - Utiliser un compte admin

2. **Accéder aux commandes**
   - URL: `http://0.0.0.0:8000/admin/commandes`
   - La commande créée doit apparaître
   - Vérifier:
     - ✅ Nom de l'utilisateur
     - ✅ Total
     - ✅ Statut "pending"
     - ✅ Détails des livres

3. **Changer le statut**
   - Cliquer sur la commande
   - Changer le statut: pending → en_livraison
   - Vérifier que le changement est persisté

## Test 3: Cas d'erreur - Panier vide

1. **Se connecter**
2. **Vider le panier** (si non vide)
3. **Aller sur**: `http://0.0.0.0:8000/paiement`
4. **Attendu**: Redirection vers panier avec message d'erreur "Votre panier est vide"

OU si vous arrivez sur la page:
5. **Cliquer sur "Commander avec livraison à domicile"**
6. **Attendu dans console**:
   ```
   Bouton livraison cliqué
   Envoi de la requête AJAX...
   Réponse reçue, status: 400
   Erreur catch: Votre panier est vide.
   ```
7. **Attendu visuellement**: Alert "Une erreur est survenue: Votre panier est vide."

## Test 4: Cas d'erreur - Non connecté

1. **Se déconnecter**
2. **Aller sur**: `http://0.0.0.0:8000/paiement`
3. **Attendu**: Redirection vers `/login` avec message "Veuillez vous connecter..."

## Test 5: Performance

1. **Vider le cache du navigateur**
   - Chrome: Ctrl+Shift+Delete
   - Cocher "Images et fichiers en cache"
   - Vider

2. **Recharger la page de paiement**
   - Ouvrir l'onglet "Network" dans DevTools
   - Recharger: `http://0.0.0.0:8000/paiement`
   - Vérifier le temps de chargement total
   - **Attendu**: < 2 secondes

3. **Vérifier les ressources**
   - Aucune image lourde ne doit se charger dans le résumé du panier
   - Seulement Bootstrap CSS/JS et FontAwesome

## Test 6: Vérification base de données

Après avoir créé une commande:

```sql
-- Vérifier la commande
SELECT * FROM commandes ORDER BY id DESC LIMIT 1;

-- Vérifier les items
SELECT ci.*, c.titre as catalogue_titre
FROM commande_items ci
LEFT JOIN catalogues c ON c.id = ci.catalogue_id
WHERE ci.commande_id = [ID_DE_LA_COMMANDE];

-- Vérifier que le panier est vide
SELECT * FROM cart_items WHERE user_id = [ID_UTILISATEUR];
```

**Attendu**:
- ✅ 1 ligne dans `commandes` avec statut "pending"
- ✅ N lignes dans `commande_items` (N = nombre de livres différents)
- ✅ 0 ligne dans `cart_items` pour cet utilisateur

## Test 7: Idempotence (éviter les doublons)

1. **Ajouter des livres au panier**
2. **Aller sur la page de paiement**
3. **Ouvrir la console**
4. **Cliquer PLUSIEURS FOIS rapidement** sur "Commander avec livraison à domicile"

**Attendu**:
- Le modal de chargement apparaît et bloque les clics suivants
- Une seule commande est créée
- Vérifier dans la base de données: `SELECT COUNT(*) FROM commandes WHERE idempotency_key LIKE 'cod_%'`

## Checklist complète

### Interface utilisateur
- [ ] Page de paiement se charge rapidement
- [ ] Résumé du panier affiché correctement
- [ ] 3 options de paiement en ligne visibles
- [ ] Section livraison à domicile en bas, fond jaune
- [ ] Bouton "Commander avec livraison à domicile" visible et stylé

### Fonctionnalité
- [ ] Clic sur le bouton déclenche l'AJAX
- [ ] Modal de chargement apparaît
- [ ] Requête POST envoyée à `/panier/traiter-paiement`
- [ ] Réponse JSON reçue avec succès
- [ ] Modal de confirmation s'affiche
- [ ] Numéro de commande correct
- [ ] Panier vidé après commande

### Base de données
- [ ] Commande créée dans table `commandes`
- [ ] Items créés dans table `commande_items`
- [ ] Panier vidé (table `cart_items`)
- [ ] Statut = "pending"
- [ ] `idempotency_key` présent et unique

### Admin
- [ ] Commande visible dans `/admin/commandes`
- [ ] Informations complètes affichées
- [ ] Statut modifiable

### Console logs (debug)
- [ ] "Bouton livraison cliqué"
- [ ] "Envoi de la requête AJAX..."
- [ ] "Réponse reçue, status: 200"
- [ ] "Données reçues: {...}"
- [ ] "Commande créée avec succès, ID: X"
- [ ] Aucune erreur JavaScript

### Erreurs gérées
- [ ] Panier vide → Message d'erreur
- [ ] Non connecté → Redirection login
- [ ] Erreur serveur → Alert avec message

## Résolution de problèmes

### Le bouton ne répond pas

1. Vérifier la console:
   - Erreur JavaScript?
   - "Bouton livraison cliqué" apparaît?

2. Vérifier l'élément HTML:
   ```javascript
   console.log(document.getElementById('livraisonBtn'));
   ```
   - Doit retourner l'élément `<button>`
   - Si `null`, le bouton n'existe pas dans le DOM

3. Vérifier Bootstrap:
   ```javascript
   console.log(typeof bootstrap);
   ```
   - Doit retourner "object"
   - Si "undefined", Bootstrap n'est pas chargé

### Le modal ne s'affiche pas

1. Vérifier que Bootstrap CSS est chargé:
   - Inspecter la page
   - Chercher `<link>` vers Bootstrap

2. Vérifier que Bootstrap JS est chargé:
   - Console: `typeof bootstrap.Modal`
   - Doit retourner "function"

3. Vérifier l'élément modal:
   ```javascript
   console.log(document.getElementById('loadingModal'));
   console.log(document.getElementById('livraisonModal'));
   ```

### Erreur 500 du serveur

1. Vérifier les logs Laravel:
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. Problèmes courants:
   - Champ manquant dans `$fillable`
   - Relation non définie
   - Contrainte de base de données

### Erreur CSRF token mismatch

1. Vider les caches:
   ```bash
   php artisan view:clear
   php artisan config:clear
   php artisan cache:clear
   ```

2. Vérifier que `{{ csrf_token() }}` génère bien un token:
   - Inspecter l'élément dans le navigateur
   - Le token ne doit pas être vide

## Données de test suggérées

### Utilisateur test
```
Email: test@example.com
Password: password
Name: Jean Dupont
Phone: +229 97 00 00 00
Address: Cotonou, Bénin
```

### Livre test dans catalogue
```
Titre: Le Petit Prince
Auteur: Antoine de Saint-Exupéry
Prix: 5000 FCFA
Quantité en stock: 10
```

## Commandes utiles

```bash
# Lancer le serveur
php artisan serve

# Vider les caches
php artisan view:clear
php artisan config:clear
php artisan cache:clear

# Voir les logs en temps réel
tail -f storage/logs/laravel.log

# Vérifier les routes
php artisan route:list | grep paiement

# Accéder à la base de données
php artisan tinker
>>> \App\Models\Commande::latest()->first()
>>> \App\Models\CartItem::where('user_id', 1)->get()
```

## Résultat attendu final

✅ **Utilisateur**:
- Peut commander en 2 clics
- Reçoit confirmation immédiate
- Peut suivre sa commande

✅ **Admin**:
- Reçoit la commande automatiquement
- Peut traiter et livrer
- Peut contacter l'utilisateur

✅ **Système**:
- Pas de doublon
- Panier vidé automatiquement
- Logs pour debug
- Performance optimale
