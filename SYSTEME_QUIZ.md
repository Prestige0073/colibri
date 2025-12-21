# Système de Quiz/QCM pour Formations

## Structure des tables créées

### 1. `quizzes` - Table principale des quiz
- `id` : Identifiant unique
- `module_id` : Lien vers un module (nullable)
- `formation_id` : Lien vers une formation (nullable)
- `titre` : Titre du quiz
- `description` : Description du quiz
- `duree_minutes` : Temps limite pour compléter le quiz
- `note_passage` : Note minimale pour réussir (défaut: 50%)
- `nombre_tentatives` : Nombre de tentatives autorisées (défaut: 3)
- `afficher_reponses` : Afficher les bonnes réponses après soumission
- `melanger_questions` : Mélanger l'ordre des questions
- `melanger_options` : Mélanger l'ordre des options
- `active` : Quiz actif ou non

### 2. `quiz_questions` - Questions du quiz
- `id` : Identifiant unique
- `quiz_id` : Lien vers le quiz
- `question` : Texte de la question
- `type` : Type de question (qcm, vrai_faux, choix_multiple)
  - **qcm** : Une seule bonne réponse
  - **vrai_faux** : Question vrai/faux
  - **choix_multiple** : Plusieurs bonnes réponses possibles
- `points` : Points attribués pour cette question
- `ordre` : Ordre d'affichage
- `explication` : Explication affichée après la réponse

### 3. `question_options` - Options de réponse
- `id` : Identifiant unique
- `question_id` : Lien vers la question
- `option_text` : Texte de l'option
- `is_correct` : Cette option est-elle correcte?
- `ordre` : Ordre d'affichage

### 4. `user_quiz_attempts` - Tentatives des utilisateurs
- `id` : Identifiant unique
- `user_id` : Utilisateur qui passe le quiz
- `quiz_id` : Quiz passé
- `reponses` : Réponses données (format JSON)
- `score` : Score obtenu (en %)
- `points_obtenus` : Points obtenus
- `points_total` : Total des points possibles
- `reussi` : Quiz réussi ou non
- `debut_at` : Date/heure de début
- `fin_at` : Date/heure de fin
- `duree_secondes` : Temps mis pour compléter

## Fonctionnalités prévues

### Administration
1. **Créer/Modifier/Supprimer des quiz**
   - Associer à un module OU une formation
   - Configurer les paramètres (durée, note de passage, etc.)

2. **Gérer les questions**
   - Ajouter/modifier/supprimer des questions
   - 3 types de questions : QCM, Vrai/Faux, Choix multiple
   - Ajouter des explications pour chaque question

3. **Gérer les options de réponse**
   - Ajouter plusieurs options par question
   - Marquer les bonnes réponses
   - Réordonner les options

4. **Statistiques**
   - Voir les résultats des apprenants
   - Taux de réussite par quiz
   - Questions les plus difficiles

### Front-end (Apprenants)
1. **Passer un quiz**
   - Interface intuitive pour répondre aux questions
   - Timer si durée définie
   - Progression visuelle
   - Sauvegarde automatique des réponses

2. **Voir les résultats**
   - Score obtenu
   - Réponses correctes/incorrectes
   - Explications des bonnes réponses
   - Historique des tentatives

3. **Validation de progression**
   - Débloquer le contenu suivant après réussite du quiz
   - Certificat après complétion de tous les quiz

## État d'avancement

✅ **Complété**
- Migrations des tables créées et exécutées
- Modèles avec relations et méthodes utilitaires
- Contrôleurs admin (QuizController et QuizQuestionController)
- Vues admin CRUD avec gestion des questions en AJAX
- Contrôleur front-end pour passer les quiz
- Vues front-end (affichage, passage, résultats)
- Routes configurées
- Intégration dans le menu admin

## Fonctionnalités implémentées

### Administration (/admin/quizzes)
- ✅ Liste de tous les quiz avec filtres et pagination
- ✅ Création de quiz avec configuration complète
- ✅ Édition de quiz
- ✅ Page de détail avec gestion des questions (AJAX)
- ✅ Ajout/modification/suppression de questions dynamique
- ✅ Support de 3 types de questions : QCM, Vrai/Faux, Choix multiple
- ✅ Réorganisation des questions (ordre)
- ✅ Validation côté serveur

### Front-end utilisateur (/quiz/{id})
- ✅ Page d'information du quiz avec historique des tentatives
- ✅ Vérification du nombre de tentatives
- ✅ Interface de passage du quiz avec timer
- ✅ Sauvegarde automatique des réponses (localStorage)
- ✅ Prévention de sortie accidentelle
- ✅ Soumission et calcul automatique des scores
- ✅ Page de résultats détaillée avec correction
- ✅ Affichage conditionnel des bonnes réponses

## Prochaines étapes (optionnelles)

1. Ajouter des quiz directement depuis les pages de formations/modules
2. Créer des statistiques pour les administrateurs
3. Système de badges/certifications après réussite
4. Export des résultats en PDF
5. Questions avec images/médias
6. Mode examen (verrouillage complet)
