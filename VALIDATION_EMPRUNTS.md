# Système de Validation des Emprunts

## Vue d'ensemble

Le système de validation des emprunts a été mis en place pour sécuriser l'accès aux PDFs des livres empruntables. Les utilisateurs doivent maintenant attendre qu'un administrateur valide leur demande d'emprunt avant de pouvoir lire les PDFs.

## Fonctionnement

### Flux utilisateur

1. **Demande d'emprunt** : L'utilisateur demande à emprunter un livre via le catalogue
   - Statut initial : `en_attente`
   - Le stock n'est PAS encore décrémenté
   - Le champ `valide_le` est NULL

2. **Validation par l'administrateur** : Un admin valide la demande
   - Statut changé à : `en_cours`
   - Le stock est décrémenté
   - Le champ `valide_le` est rempli avec la date/heure actuelle
   - Le champ `valide_par` est rempli avec l'ID de l'admin

3. **Accès au PDF** : L'utilisateur peut maintenant lire le PDF
   - Le contrôleur `SecurePdfController` vérifie que :
     - L'utilisateur est authentifié
     - Il a un emprunt pour ce livre
     - Le statut est `en_cours` ou `en_retard`
     - Le champ `valide_le` n'est pas NULL

4. **Retour du livre** : L'admin marque le livre comme retourné
   - Statut changé à : `retourne`
   - Le stock est incrémenté
   - L'utilisateur ne peut plus accéder au PDF

### Flux administrateur

#### Page d'administration des emprunts

**Section 1 : Demandes en attente**
- Liste toutes les demandes avec statut `en_attente`
- Actions disponibles :
  - ✓ Valider (si stock disponible)
  - ✕ Rejeter (supprime la demande)

**Section 2 : Livres empruntables**
- Liste tous les livres du catalogue avec `type_categorie = 'emprunt'`
- Gestion du stock
- Ajout/modification/suppression de livres

**Section 3 : Emprunts enregistrés**
- Liste tous les emprunts (hors `en_attente`)
- Affiche le statut de validation
- Actions disponibles :
  - ✓ Valider (pour les emprunts non validés)
  - ↺ Retourner (marquer comme retourné)
  - ✕ Supprimer/Annuler

**Section 4 : Créer un nouvel emprunt**
- Permet de créer directement un emprunt validé

## Contrôles de sécurité

### SecurePdfController::view()

```php
// 1. Vérification de l'existence du PDF
if (!$livre->pdf || !file_exists(public_path($livre->pdf))) {
    abort(404, 'PDF non disponible');
}

// 2. Vérification de l'authentification
if (!auth()->check()) {
    abort(403, 'Vous devez être connecté');
}

// 3. Vérification de l'emprunt VALIDÉ
$empruntValide = Emprunt::where('user_id', auth()->id())
    ->where('livre_id', $livre->id)
    ->whereIn('statut', ['en_cours', 'en_retard'])
    ->whereNotNull('valide_le')  // IMPORTANT: emprunt validé
    ->first();

if (!$empruntValide) {
    // Vérifier si demande en attente
    $enAttente = Emprunt::where('user_id', auth()->id())
        ->where('livre_id', $livre->id)
        ->where('statut', 'en_attente')
        ->exists();

    if ($enAttente) {
        abort(403, 'Votre demande est en attente de validation');
    }

    abort(403, 'Vous devez emprunter ce livre');
}

// 4. Génération du token de session
$token = bin2hex(random_bytes(32));
session(['pdf_token_' . $id => $token]);
session(['pdf_access_time_' . $id => now()]);
```

## Pages utilisateur

### /emprunts (Bibliothèque)
- Affiche tous les livres empruntables
- Bouton "Emprunter" crée une demande en attente

### /mes-emprunts (Mes emprunts)
Affiche 4 sections :

1. **Demandes en attente** (badge jaune)
   - Message : "En attente de validation par un administrateur"
   - Bouton "Lire le PDF" désactivé

2. **Emprunts en cours** (badge vert)
   - Emprunts validés avec `valide_le` non NULL
   - Bouton "Lire le PDF" actif

3. **Emprunts en retard** (badge rouge)
   - Message d'alerte
   - Bouton "Lire le PDF" actif

4. **Historique** (badge gris)
   - Emprunts retournés
   - Bouton "Lire le PDF" absent

### /emprunts/{id} (Détails du livre)
Affiche différents messages selon l'état :

- **Demande en attente** : Badge jaune + message
- **Emprunt validé** : Badge vert + bouton "Lire le PDF"
- **Pas d'emprunt** : Formulaire pour emprunter
- **Non connecté** : Bouton de connexion

### /account/profil (Profil utilisateur)
- Section "Mes emprunts" avec les 6 derniers emprunts actifs
- Badges de statut (Non validé / Validé / En retard)
- Bouton "Lire le PDF" seulement si validé

## Structure de la base de données

### Table emprunts

Colonnes clés :
- `user_id` : ID de l'utilisateur
- `livre_id` : ID du livre
- `statut` : en_attente | en_cours | en_retard | retourne
- `valide_le` : DateTime de validation (NULL si non validé)
- `valide_par` : ID de l'admin validateur (NULL si non validé)
- `date_emprunt` : Date d'emprunt
- `date_retour` : Date de retour prévue/effective

## Fichiers modifiés

### Contrôleurs
- `app/Http/Controllers/SecurePdfController.php` - Vérification `whereNotNull('valide_le')`
- `app/Http/Controllers/EmpruntUserController.php` - Séparation des emprunts par statut
- `app/Http/Controllers/Admin/EmpruntController.php` - Ajout méthodes `validerDemande()` et `rejeterDemande()`

### Vues
- `resources/views/emprunts/mes-emprunts.blade.php` - 4 sections (attente/actifs/retard/historique)
- `resources/views/emprunts/show.blade.php` - Affichage conditionnel selon statut
- `resources/views/account/profil.blade.php` - Badges de validation
- `resources/views/admin/emprunts.blade.php` - Section demandes en attente + actions

### Routes
- `routes/web.php` - Ajout routes `admin.emprunts.valider` et `admin.emprunts.rejeter`

## Migration nécessaire

Si la colonne `valide_le` n'existe pas encore :

```php
Schema::table('emprunts', function (Blueprint $table) {
    $table->timestamp('valide_le')->nullable()->after('statut');
    $table->unsignedBigInteger('valide_par')->nullable()->after('valide_le');

    $table->foreign('valide_par')->references('id')->on('users')->onDelete('set null');
});
```

## Tester le système

1. **Créer une demande d'emprunt** (utilisateur)
   - Se connecter comme utilisateur
   - Aller sur `/emprunts`
   - Cliquer sur "Emprunter" pour un livre
   - Vérifier qu'on voit "En attente de validation"

2. **Valider la demande** (administrateur)
   - Se connecter comme admin
   - Aller sur `/admin/emprunts`
   - Dans la section "Demandes en attente", sélectionner "✓ Valider"
   - Vérifier que le stock a été décrémenté

3. **Lire le PDF** (utilisateur)
   - Se reconnecter comme utilisateur
   - Aller sur `/mes-emprunts`
   - Vérifier le badge "Validé"
   - Cliquer sur "Lire le PDF"
   - Vérifier que le PDF s'affiche dans le viewer sécurisé

4. **Retourner le livre** (administrateur)
   - Aller sur `/admin/emprunts`
   - Dans la liste des emprunts, sélectionner "↺ Retourner"
   - Vérifier que le stock a été incrémenté
   - Vérifier que l'utilisateur ne peut plus accéder au PDF

## Sécurité

✅ L'accès au PDF nécessite :
- Authentification
- Emprunt actif (statut `en_cours` ou `en_retard`)
- Validation par un admin (`valide_le NOT NULL`)
- Token de session valide

✅ Protection contre :
- Accès direct aux URLs des PDFs
- Téléchargement non autorisé
- Partage de liens
- Screenshots (protections JS dans le viewer)

## Notes importantes

⚠️ **Stock** : Le stock n'est décrémenté qu'à la validation, pas à la demande

⚠️ **Accès PDF** : Un utilisateur avec une demande en attente verra un message clair expliquant qu'il doit attendre la validation

⚠️ **Suppression** : Rejeter une demande la supprime complètement (pas de trace)

⚠️ **Historique** : Les emprunts retournés restent dans l'historique mais sans accès au PDF
