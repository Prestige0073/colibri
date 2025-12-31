# Système de Gestion des Témoignages - Colibri Littéraire

## Vue d'ensemble

Le système de témoignages permet aux utilisateurs de partager leur expérience avec Colibri Littéraire. Les témoignages sont soumis via un formulaire public, modérés par les administrateurs, et affichés sur la page d'accueil.

## Architecture du système

### Base de données

**Table : `testimonials`**
- `id` : Identifiant unique
- `name` : Nom complet de l'auteur (obligatoire)
- `email` : Email (optionnel)
- `role` : Fonction/rôle (optionnel)
- `company` : Organisation (optionnel)
- `message` : Contenu du témoignage (obligatoire, 10-500 caractères)
- `photo` : Photo de profil (optionnel, max 1 Mo)
- `rating` : Note sur 5 étoiles (obligatoire, par défaut 5)
- `status` : Statut de modération (`pending`, `approved`, `rejected`)
- `approved_at` : Date d'approbation
- `user_id` : Liaison avec l'utilisateur (nullable)
- `timestamps` : Dates de création/modification

### Modèle Eloquent

**Fichier : `app/Models/Testimonial.php`**

**Scopes disponibles :**
- `approved()` : Récupère uniquement les témoignages approuvés
- `pending()` : Récupère les témoignages en attente
- `rejected()` : Récupère les témoignages rejetés

**Méthodes :**
- `approve()` : Approuve un témoignage et enregistre la date
- `reject()` : Rejette un témoignage
- `setPending()` : Remet un témoignage en attente
- `getInitialsAttribute()` : Génère les initiales pour l'avatar

## Contrôleurs

### 1. TestimonialController (Public)

**Fichier : `app/Http/Controllers/TestimonialController.php`**

**Méthodes :**
- `index()` : Affiche les témoignages approuvés (non utilisé actuellement)
- `store()` : Soumet un nouveau témoignage

**Validation pour la soumission :**
```php
'name' => 'required|string|max:255'
'email' => 'nullable|email|max:255'
'role' => 'nullable|string|max:255'
'company' => 'nullable|string|max:255'
'message' => 'required|string|min:10|max:500'
'rating' => 'required|integer|min:1|max:5'
'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:1024'
```

### 2. TestimonialAdminController (Administration)

**Fichier : `app/Http/Controllers/Admin/TestimonialAdminController.php`**

**Méthodes :**
- `index()` : Liste tous les témoignages avec statistiques
- `approve($id)` : Approuve un témoignage
- `reject($id)` : Rejette un témoignage
- `pending($id)` : Remet en attente
- `destroy($id)` : Supprime définitivement

## Vues

### 1. Page d'accueil (Section publique)

**Fichier : `resources/views/index.blade.php`**

**Fonctionnalités :**
- Affichage de 6 témoignages approuvés maximum
- Design en cartes avec effet hover
- Photo ou initiales pour chaque témoignage
- Affichage des étoiles de notation
- Bouton pour soumettre un nouveau témoignage
- Modal de soumission responsive

**Modal de soumission :**
- Formulaire complet avec tous les champs
- Pré-remplissage automatique du nom/email pour utilisateurs connectés
- Sélection interactive des étoiles
- Compteur de caractères en temps réel (10-500 caractères)
- Upload d'image avec validation
- Réouverture automatique en cas d'erreur de validation

### 2. Interface d'administration

**Fichier : `resources/views/admin/testimonials.blade.php`**

**Fonctionnalités :**
- Statistiques en temps réel (En attente, Approuvés, Rejetés)
- Tableau paginé de tous les témoignages
- Affichage photo ou initiales
- Informations complètes : nom, rôle, entreprise, message
- Étoiles de notation visuelles
- Badge de statut coloré
- Actions groupées par témoignage :
  - Approuver (bouton vert)
  - Mettre en attente (bouton jaune)
  - Rejeter (bouton gris)
  - Supprimer (bouton rouge avec confirmation)
- Mise en évidence des témoignages en attente (fond jaune clair)

## Routes

### Routes publiques

```php
// Soumission de témoignage
POST /testimonials => testimonials.store
```

### Routes administrateur

```php
// Liste et gestion
GET  /admin/testimonials            => admin.testimonials.index
POST /admin/testimonials/{id}/approve  => admin.testimonials.approve
POST /admin/testimonials/{id}/reject   => admin.testimonials.reject
POST /admin/testimonials/{id}/pending  => admin.testimonials.pending
DELETE /admin/testimonials/{id}        => admin.testimonials.destroy
```

## Workflow de modération

1. **Soumission** : L'utilisateur remplit le formulaire sur la page d'accueil
2. **Statut initial** : Le témoignage est créé avec `status = 'pending'`
3. **Notification** : Badge jaune dans le menu admin avec le nombre de témoignages en attente
4. **Modération** : L'administrateur peut :
   - **Approuver** : Le témoignage devient visible sur la page d'accueil
   - **Rejeter** : Le témoignage est masqué mais conservé
   - **Supprimer** : Le témoignage est définitivement supprimé
5. **Affichage** : Seuls les témoignages approuvés sont visibles publiquement

## Design et UI/UX

### Page d'accueil

**Section Témoignages :**
- Titre centré avec icône
- Grille responsive (1 colonne mobile, 2 colonnes tablette, 3 colonnes desktop)
- Cartes avec ombre et effet de survol
- Étoiles jaunes en haut de chaque carte
- Message en italique
- Profil (photo/initiales + infos) en bas
- Bouton CTA proéminent "Partager votre expérience"

**Modal de soumission :**
- En-tête vert avec icône
- Formulaire en grille responsive
- Champs obligatoires marqués d'un astérisque rouge
- Sélection d'étoiles interactive (survol et clic)
- Zone de texte avec compteur de caractères dynamique :
  - Rouge si < 10 caractères
  - Vert si entre 10 et 450
  - Orange si > 450
- Alert d'information sur la modération
- Boutons Annuler (gris) et Envoyer (vert)

### Interface Admin

**Statistiques :**
- 3 cartes colorées avec icônes :
  - Jaune pour "En attente"
  - Vert pour "Approuvés"
  - Rouge pour "Rejetés"
- Bordure gauche colorée de 4px

**Tableau :**
- En-tête avec fond clair
- Lignes avec effet hover
- Témoignages en attente sur fond jaune pâle
- Photos circulaires ou initiales colorées
- Badges de statut avec icônes
- Groupe de boutons d'action bien espacés

## Menu Admin

Le lien "Témoignages" dans le menu admin affiche :
- Icône : `fa-comment-dots`
- Badge jaune avec le nombre de témoignages en attente
- État actif sur toutes les routes `admin.testimonials.*`

## Gestion des images

**Upload :**
- Stockage dans `storage/app/public/testimonials/`
- Formats acceptés : JPEG, PNG, JPG
- Taille maximum : 1 Mo (1024 Ko)
- Affichage via `asset('storage/' . $testimonial->photo)`

**Fallback :**
- Si pas de photo : affichage des initiales
- Fond vert avec texte blanc
- Initiales automatiques (2 premières lettres du prénom et nom)

## Notifications

**Après soumission :**
```php
'Merci pour votre témoignage ! Il sera publié après validation.'
```

**Après approbation (admin) :**
```php
'Témoignage approuvé avec succès.'
```

**Après rejet (admin) :**
```php
'Témoignage rejeté.'
```

**Après suppression (admin) :**
```php
'Témoignage supprimé définitivement.'
```

## Sécurité

1. **CSRF Protection** : Token sur tous les formulaires
2. **Validation stricte** : Validation côté serveur pour tous les champs
3. **Upload sécurisé** : Validation du type et de la taille des images
4. **Modération** : Aucun témoignage n'est publié automatiquement
5. **Suppression en cascade** : Si un utilisateur est supprimé, `user_id` devient NULL

## Performances

- **Limitation** : Maximum 6 témoignages sur la page d'accueil
- **Tri** : Par date d'approbation décroissante
- **Pagination** : 15 témoignages par page dans l'admin
- **Requêtes optimisées** : Utilisation des scopes Eloquent

## Responsive Design

- **Mobile** : 1 colonne
- **Tablette** : 2 colonnes (à partir de 768px)
- **Desktop** : 3 colonnes (à partir de 992px)
- **Modal** : Centré avec largeur adaptative

## Améliorations futures possibles

1. **Réponses** : Permettre aux admins de répondre aux témoignages
2. **Notifications email** : Notifier l'utilisateur quand son témoignage est approuvé
3. **Partage social** : Boutons de partage sur les témoignages
4. **Filtre par note** : Afficher seulement les 4-5 étoiles
5. **Statistiques avancées** : Graphiques de satisfaction
6. **Vérification** : Badge "Achat vérifié" pour les clients
7. **Galerie** : Page dédiée avec tous les témoignages approuvés
8. **Export** : Export CSV/PDF des témoignages

## Migration et installation

**Créer la table :**
```bash
php artisan migrate
```

**Créer le lien symbolique pour le storage (si pas déjà fait) :**
```bash
php artisan storage:link
```

## Tests recommandés

1. Soumettre un témoignage sans être connecté
2. Soumettre un témoignage en étant connecté
3. Vérifier la pré-remplissage des champs
4. Tester l'upload d'image
5. Tester la validation (message trop court, image trop lourde)
6. Vérifier l'affichage des témoignages sur la page d'accueil
7. Tester toutes les actions de modération
8. Vérifier le compteur de badges dans le menu admin
9. Tester la réouverture du modal en cas d'erreur
10. Vérifier le responsive sur mobile/tablette/desktop
