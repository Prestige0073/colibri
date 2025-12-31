# Système de Livraison à Domicile (COD - Cash On Delivery)

## Vue d'ensemble

Ce système permet aux utilisateurs de commander des livres avec paiement à la livraison. La commande est créée automatiquement et apparaît dans l'interface admin pour traitement.

## Architecture

### Flux utilisateur

1. **Ajout au panier** → L'utilisateur ajoute des livres à son panier
2. **Page de paiement** (`/paiement`) → L'utilisateur accède à la page de choix de paiement
3. **Clic sur "Livraison à domicile"** → Bouton jaune en bas de page
4. **Traitement AJAX** → Envoi automatique de la commande au serveur
5. **Création de commande** → Enregistrement dans la base de données
6. **Confirmation** → Modal de succès avec numéro de commande
7. **Redirection** → L'utilisateur peut voir ses commandes ou continuer ses achats

### Flux technique

```
User clicks button
    ↓
JavaScript (AJAX)
    ↓
POST /panier/traiter-paiement
    payment_method: "livraison"
    ↓
PanierController::traiterPaiement()
    ↓
Create Commande (status: pending)
    ↓
Create CommandeItems
    ↓
Empty user cart
    ↓
Return JSON response
    ↓
JavaScript shows success modal
    ↓
User redirected or continues shopping
```

## Fichiers modifiés

### 1. Controller: `app/Http/Controllers/PanierController.php`

**Méthode**: `traiterPaiement(Request $request)`
- Ligne 179-311

**Fonctionnalité**:
- Valide que `payment_method` est "livraison"
- Vérifie l'authentification utilisateur
- Vérifie que le panier n'est pas vide
- Crée une commande avec statut "pending"
- Crée les items de commande (CommandeItem)
- Vide le panier utilisateur
- Retourne une réponse JSON pour AJAX

**Champs créés dans Commande**:
```php
[
    'user_id' => $user->id,
    'nom' => $user->name,
    'telephone' => $user->phone ?? '',
    'adresse' => $user->address ?? '',
    'total' => $total,
    'statut' => 'pending',
    'idempotency_key' => uniqid('cod_', true),
]
```

**Réponse JSON**:
```json
{
    "success": true,
    "message": "Commande enregistrée avec succès ! Vous payerez à la réception...",
    "commande_id": 123,
    "redirect_url": "/account/commandes"
}
```

### 2. Vue: `resources/views/panier/paiement.blade.php`

**Structure**:

1. **Résumé du panier** (lignes 10-53)
   - Affichage des livres, quantités, prix
   - Total de la commande

2. **Section paiement en ligne** (lignes 56-108)
   - Form avec radio buttons pour Kkiapay, Lygos, PayPal
   - Soumission normale (POST)

3. **Section livraison à domicile** (lignes 110-124)
   - Card avec fond jaune (warning)
   - Bouton `id="livraisonBtn"`
   - Placé EN BAS de la page

4. **Modal de chargement** (lignes 149-162)
   - `id="loadingModal"`
   - Spinner Bootstrap
   - Bloqué (backdrop static, keyboard false)

5. **Modal de confirmation** (lignes 164-198)
   - `id="livraisonModal"`
   - Affiche le numéro de commande `#commandeNumber`
   - Boutons pour voir commandes ou continuer achats

6. **JavaScript AJAX** (lignes 237-318)
   - Event listener sur bouton livraison
   - Affiche modal de chargement
   - Envoie FormData avec CSRF token et payment_method
   - Gère la réponse JSON
   - Affiche modal de succès
   - Logs console détaillés pour debug

### 3. Modèles

**Commande** (`app/Models/Commande.php`):
```php
protected $fillable = [
    'user_id', 'nom', 'telephone', 'adresse',
    'total', 'statut', 'idempotency_key'
];

public function items() {
    return $this->hasMany(CommandeItem::class);
}

public function getStatutLabelAttribute() {
    // Retourne "En préparation" pour "pending"
}
```

**CommandeItem** (`app/Models/CommandeItem.php`):
```php
protected $fillable = [
    'commande_id', 'catalogue_id', 'titre', 'quantite', 'prix'
];
```

## Routes

```php
// Affiche la page de paiement
GET /paiement → PanierController@showPaiement
Route name: paiement.show

// Traite le paiement (online ou livraison)
POST /panier/traiter-paiement → PanierController@traiterPaiement
Route name: panier.traiter-paiement

// Affiche les commandes de l'utilisateur
GET /account/commandes → CommandeController@mesCommandes
Route name: account.commandes
```

## Base de données

### Table: `commandes`

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint | Clé primaire |
| user_id | bigint | Référence vers users |
| nom | string | Nom de l'utilisateur |
| telephone | string | Numéro de téléphone |
| adresse | text | Adresse de livraison |
| total | decimal(10,2) | Montant total |
| statut | string | pending, en_livraison, livre, annule |
| idempotency_key | string | Clé unique pour éviter doublons |
| created_at | timestamp | Date de création |
| updated_at | timestamp | Date de modification |

### Table: `commande_items`

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint | Clé primaire |
| commande_id | bigint | Référence vers commandes |
| catalogue_id | bigint | Référence vers catalogues |
| titre | string | Titre du livre |
| quantite | integer | Quantité commandée |
| prix | decimal(10,2) | Prix unitaire |
| created_at | timestamp | Date de création |
| updated_at | timestamp | Date de modification |

## Gestion admin

Les commandes apparaissent automatiquement dans:
- **URL**: `/admin/commandes`
- **Controller**: `Admin\CommandeController`
- **Vue**: `resources/views/admin/commandes/index.blade.php`

Les admins peuvent:
- Voir toutes les commandes groupées par utilisateur
- Changer le statut (pending → en_livraison → livre)
- Voir les détails de chaque commande
- Contacter l'utilisateur (WhatsApp, téléphone, email)

## Statuts de commande

| Statut | Label français | Description |
|--------|----------------|-------------|
| pending | En préparation | Commande reçue, en attente de traitement |
| en_livraison | En livraison | Commande en cours de livraison |
| livre/livree | Livré | Commande livrée et payée |
| annule | Annulé | Commande annulée |

## Sécurité

1. **CSRF Protection**: Token CSRF dans chaque requête POST
2. **Authentication**: Vérification `Auth::user()` avant traitement
3. **Validation**: Validation de `payment_method` (in: kkiapay,lygos,paypal,livraison)
4. **Idempotency**: Clé unique `uniqid('cod_', true)` pour éviter les doublons
5. **Error Handling**: Try-catch avec logs Laravel
6. **AJAX Detection**: `$request->wantsJson() || $request->ajax()`

## Debugging

### Console logs (côté client)
```javascript
console.log('Bouton livraison cliqué');
console.log('Envoi de la requête AJAX...');
console.log('Réponse reçue, status:', response.status);
console.log('Données reçues:', data);
console.log('Commande créée avec succès, ID:', data.commande_id);
```

### Laravel logs (côté serveur)
```php
\Log::error('Erreur création commande livraison: ' . $e->getMessage());
```

## Tests manuels

Pour tester le système:

1. Se connecter en tant qu'utilisateur
2. Ajouter des livres au panier
3. Aller sur `/paiement`
4. Cliquer sur "Commander avec livraison à domicile"
5. Vérifier:
   - Modal de chargement apparaît
   - Console log: "Bouton livraison cliqué"
   - Console log: "Envoi de la requête AJAX..."
   - Console log: "Réponse reçue, status: 200"
   - Console log: "Données reçues: {success: true, ...}"
   - Modal de succès avec numéro de commande
6. Vérifier dans `/account/commandes` que la commande apparaît
7. Vérifier dans `/admin/commandes` (en tant qu'admin)

## Performance

Optimisations effectuées:
- ✅ Suppression des images dans l'affichage du panier (chargement plus rapide)
- ✅ Eager loading `with('catalogue')` pour éviter N+1 queries
- ✅ Structure HTML simplifiée
- ✅ AJAX au lieu de rechargement de page
- ✅ Caches Laravel vidés (view, config, cache)

## Erreurs courantes et solutions

### "Route [home] not defined"
**Cause**: Cache de vue contenant une référence obsolète
**Solution**:
```bash
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

### "Modal de chargement introuvable"
**Cause**: ID du modal mal orthographié ou modal absent du DOM
**Solution**: Vérifier que `<div id="loadingModal">` existe dans le HTML

### "Votre panier est vide"
**Cause**: L'utilisateur essaie de commander sans articles au panier
**Solution**: Ajouter des livres au panier avant d'accéder à `/paiement`

### "Veuillez vous connecter"
**Cause**: Utilisateur non authentifié
**Solution**: Se connecter avant d'accéder à la page de paiement

## Améliorations futures possibles

1. **Email de confirmation** après création de commande
2. **SMS de notification** pour l'admin
3. **Tracking de livraison** avec statuts intermédiaires
4. **Estimation de délai** de livraison
5. **Zone de livraison** avec calcul de frais
6. **Historique de statuts** (audit trail)
7. **Annulation de commande** par l'utilisateur (si pending)
8. **Modification de commande** avant livraison

## Contact développeur

Pour toute question sur ce système, consulter:
- Ce document
- Code source dans les fichiers mentionnés
- Logs Laravel dans `storage/logs/laravel.log`
