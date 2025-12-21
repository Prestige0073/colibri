# Guide d'utilisation du Système de Quiz

## 🎯 Vue d'ensemble

Le système de quiz permet de créer des évaluations pour tester les connaissances des apprenants. Chaque quiz peut être associé à une formation ou à un module spécifique.

## 📋 Accès rapide

### Administration
- **Liste des quiz** : http://localhost:8000/admin/quizzes
- **Créer un quiz** : http://localhost:8000/admin/quizzes/create

### Utilisateurs
- **Voir un quiz** : http://localhost:8000/quiz/{id}
- **Passer un quiz** : Cliquer sur "Commencer le Quiz" depuis la page du quiz

## 🔧 Comment créer un quiz

### 1. Créer le quiz de base

1. Allez sur `/admin/quizzes`
2. Cliquez sur "Créer un Quiz"
3. Remplissez les informations :
   - **Titre** : Nom du quiz
   - **Description** : Description optionnelle
   - **Formation/Module** : Lier à une formation OU un module
   - **Durée** : Temps limite en minutes (optionnel)
   - **Note de passage** : Pourcentage minimum pour réussir (défaut: 50%)
   - **Nombre de tentatives** : Combien de fois un utilisateur peut passer le quiz (1-10)
   - **Options** :
     - Afficher les bonnes réponses après soumission
     - Mélanger l'ordre des questions
     - Mélanger l'ordre des options de réponse
   - **Statut** : Actif ou inactif

4. Cliquez sur "Créer le Quiz"

### 2. Ajouter des questions

Après avoir créé le quiz, vous serez redirigé vers la page de détail où vous pouvez ajouter des questions.

#### Types de questions disponibles :

**1. QCM (Questionnaire à Choix Multiple)**
- Une seule bonne réponse
- Minimum 2 options
- Exemple : "Quelle est la capitale de la France ?"

**2. Vrai/Faux**
- Question binaire avec deux options : Vrai et Faux
- Une seule bonne réponse
- Exemple : "Le soleil est une étoile. Vrai ou Faux ?"

**3. Choix Multiple**
- Plusieurs bonnes réponses possibles
- L'utilisateur doit sélectionner TOUTES les bonnes réponses pour avoir les points
- Exemple : "Quels sont des langages de programmation ? (PHP, HTML, Python, CSS)"

#### Pour ajouter une question :

1. Cliquez sur "Ajouter une question"
2. Remplissez :
   - **Question** : Le texte de la question
   - **Type** : QCM, Vrai/Faux ou Choix multiple
   - **Points** : Nombre de points pour cette question
   - **Options** : Ajoutez au moins 2 options
     - Cochez la case pour marquer une option comme correcte
     - Pour les QCM et Vrai/Faux : UNE SEULE option correcte
     - Pour les Choix multiples : Une ou plusieurs options correctes
   - **Explication** : Texte affiché après la réponse (optionnel)

3. Cliquez sur "Enregistrer"

### 3. Modifier/Supprimer des questions

- **Modifier** : Cliquez sur l'icône crayon à droite de la question
- **Supprimer** : Cliquez sur l'icône poubelle (confirmation demandée)

## 👥 Expérience utilisateur

### Passage d'un quiz

1. L'utilisateur accède au quiz via `/quiz/{id}`
2. Il voit :
   - Informations sur le quiz (nombre de questions, points, durée)
   - Ses tentatives précédentes
   - Son meilleur score
3. Il clique sur "Commencer le Quiz"
4. Le quiz démarre avec :
   - Timer si une durée est définie
   - Questions affichées
   - Sauvegarde automatique des réponses (localStorage)
   - Prévention de sortie accidentelle
5. Il soumet ses réponses
6. Il voit ses résultats :
   - Score obtenu
   - Nombre de bonnes/mauvaises réponses
   - Durée passée
   - Correction détaillée (si activée)

### Limitations

- Le nombre de tentatives est limité (configuré dans le quiz)
- Une fois le nombre de tentatives atteint, l'utilisateur ne peut plus passer le quiz
- Le timer (si activé) force la soumission automatique à la fin du temps

## 🎨 Fonctionnalités avancées

### Timer automatique
- Si une durée est configurée, un compte à rebours s'affiche
- Avertissement visuel quand il reste moins de 2 minutes
- Soumission automatique quand le temps est écoulé

### Sauvegarde automatique
- Les réponses sont sauvegardées dans le navigateur
- Si l'utilisateur ferme la page par accident, ses réponses sont récupérées
- Nettoyage automatique après soumission

### Mélange des questions/options
- Permet de réduire la triche
- L'ordre change à chaque tentative
- Configurable par quiz

### Correction détaillée
- Affiche les bonnes et mauvaises réponses
- Indique les réponses de l'utilisateur
- Affiche les explications pour chaque question
- Peut être désactivée pour les quiz d'examen

## 📊 Statistiques disponibles

Pour chaque tentative :
- Score en pourcentage
- Points obtenus / Points total
- Durée de passage
- Date et heure
- Statut (réussi/échoué)

Pour chaque utilisateur :
- Historique de toutes les tentatives
- Meilleur score
- Nombre de tentatives restantes

## ⚙️ Configuration recommandée

### Quiz d'entraînement
- Note de passage : 50-60%
- Tentatives : 3-5
- Afficher les réponses : ✅ Oui
- Mélanger : Optionnel
- Durée : Optionnelle

### Quiz d'évaluation
- Note de passage : 70-80%
- Tentatives : 1-2
- Afficher les réponses : ❌ Non (ou après toutes les tentatives)
- Mélanger : ✅ Oui
- Durée : ✅ Définie

### Quiz d'examen final
- Note de passage : 80%+
- Tentatives : 1
- Afficher les réponses : ❌ Non
- Mélanger : ✅ Oui
- Durée : ✅ Stricte

## 🔍 Dépannage

### Le quiz ne s'affiche pas
- Vérifiez que le quiz est actif
- Vérifiez qu'il est lié à une formation ou un module
- Vérifiez qu'il contient au moins une question

### Erreur lors de la création de question
- Vérifiez qu'il y a au moins 2 options
- Pour QCM/Vrai-Faux : UNE SEULE option doit être correcte
- Pour Choix multiple : AU MOINS UNE option doit être correcte

### L'utilisateur ne peut pas passer le quiz
- Vérifiez le nombre de tentatives restantes
- Vérifiez que le quiz est actif
- Vérifiez que l'utilisateur est connecté

## 🚀 Améliorations futures possibles

1. Questions avec images/médias
2. Export des résultats en PDF
3. Statistiques avancées pour les administrateurs
4. Badges/Certifications automatiques
5. Quiz aléatoires (banque de questions)
6. Mode examen (verrouillage écran)
7. Intégration avec système de progression
