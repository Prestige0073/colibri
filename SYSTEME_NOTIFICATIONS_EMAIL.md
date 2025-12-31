# Système de Notifications Email - Colibri Littéraire

## Configuration Gmail
- **Email**: colibrilitteraire@gmail.com
- **Mot de passe d'application**: mjdv cctd gcmj geda
- **SMTP**: smtp.gmail.com:587 (TLS)

## Notifications Utilisateurs

### 1. Inscription / Création de compte
**Destinataire**: Nouvel utilisateur
**Sujet**: Bienvenue sur Colibri Littéraire
**Contenu**:
- Message de bienvenue personnalisé
- Confirmation de création de compte
- Lien vers le profil
- Informations sur la plateforme

**Admin notifié**: OUI
- Notification de nouvelle inscription
- Nom et email de l'utilisateur
- Date d'inscription

### 2. Achat / Commande de livre (Catalogue)
**Destinataire**: Acheteur
**Sujet**: Confirmation de commande #[ID]
**Contenu**:
- Récapitulatif de la commande
- Liste des livres achetés
- Montant total
- Méthode de paiement
- Adresse de livraison
- Statut de la commande

**Admin notifié**: OUI
- Nouvelle commande reçue
- Détails client et commande
- Montant

### 3. Inscription à une formation
**Destinataire**: Participant
**Sujet**: Inscription confirmée - Formation [Nom]
**Contenu**:
- Confirmation d'inscription
- Informations sur la formation
- Date de début
- Lien d'accès aux modules
- Montant payé

**Admin notifié**: OUI
- Nouvelle inscription formation
- Nom formation et participant
- Montant

### 4. Paiement effectué
**Destinataire**: Payeur
**Sujet**: Paiement confirmé - [Type]
**Contenu**:
- Confirmation de paiement
- Montant payé
- Méthode de paiement
- Référence de transaction
- Facture (si applicable)

**Admin notifié**: OUI
- Notification de paiement reçu
- Montant et méthode
- Référence

### 5. Certification générée
**Destinataire**: Certifié
**Sujet**: Félicitations! Votre certificat est prêt
**Contenu**:
- Message de félicitations
- Lien de téléchargement du certificat PDF
- Détails de la formation complétée
- Validité du certificat

**Admin notifié**: NON

### 6. Changement de statut de commande
**Destinataire**: Client
**Sujet**: Mise à jour de votre commande #[ID]
**Contenu**:
- Nouveau statut (En attente, Validée, En livraison, Livrée)
- Informations de suivi (si applicable)
- Message personnalisé selon le statut

**Admin notifié**: NON

### 7. Emprunt de livre validé
**Destinataire**: Emprunteur
**Sujet**: Emprunt validé - [Titre du livre]
**Contenu**:
- Confirmation de validation d'emprunt
- Date limite de retour
- Instructions d'accès au livre PDF
- Lien de téléchargement

**Admin notifié**: NON

## Notifications Admin Uniquement

### 1. Nouveau message de contact
**Destinataire**: Admin
**Sujet**: Nouveau message de contact - [Objet]
**Contenu**:
- Nom et email de l'expéditeur
- Objet du message
- Contenu complet
- Lien vers l'admin pour répondre

### 2. Nouveau témoignage soumis
**Destinataire**: Admin
**Sujet**: Nouveau témoignage en attente de validation
**Contenu**:
- Nom de l'auteur
- Note donnée
- Contenu du témoignage
- Lien pour approuver/rejeter

### 3. Don reçu
**Destinataire**: Admin
**Sujet**: Nouveau don reçu - [Montant]
**Contenu**:
- Montant du don
- Nom du donateur
- Message (si fourni)
- Méthode de paiement

### 4. Demande d'emprunt en attente
**Destinataire**: Admin
**Sujet**: Nouvelle demande d'emprunt - [Livre]
**Contenu**:
- Nom de l'utilisateur
- Livre demandé
- Date de demande
- Lien pour valider/rejeter

## Priorités d'implémentation

### Phase 1 (Immédiate)
1. ✅ Configuration Gmail
2. 🔄 Notification inscription utilisateur
3. 🔄 Notification commande (user + admin)
4. 🔄 Notification paiement (user + admin)

### Phase 2 (Rapide)
5. Notification inscription formation (user + admin)
6. Notification certification (user)
7. Notification contact (admin)

### Phase 3 (À venir)
8. Notification changement statut commande
9. Notification emprunt
10. Notification témoignage
11. Notification don

## Classes Mailable à créer

```
app/Mail/
├── User/
│   ├── WelcomeEmail.php              # Bienvenue nouvel inscrit
│   ├── OrderConfirmation.php          # Confirmation commande
│   ├── PaymentConfirmation.php        # Confirmation paiement
│   ├── FormationEnrollment.php        # Inscription formation
│   ├── CertificateReady.php           # Certificat prêt
│   ├── OrderStatusUpdate.php          # Maj statut commande
│   └── LoanApproved.php               # Emprunt validé
│
└── Admin/
    ├── NewUserRegistration.php        # Nouvelle inscription
    ├── NewOrder.php                   # Nouvelle commande
    ├── NewPayment.php                 # Nouveau paiement
    ├── NewFormationEnrollment.php     # Nouvelle inscription formation
    ├── NewContact.php                 # Nouveau message contact
    ├── NewTestimonial.php             # Nouveau témoignage
    ├── NewDonation.php                # Nouveau don
    └── NewLoanRequest.php             # Demande emprunt
```

## Templates Email

Tous les emails utiliseront un template Blade cohérent avec:
- Logo Colibri Littéraire
- Couleurs de la marque
- Footer avec liens réseaux sociaux
- Informations de contact

## Configuration
- **Mode**: SMTP Gmail
- **Encryption**: TLS
- **Port**: 587
- **Queue**: Database (pour envoi asynchrone)
