-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 08 fév. 2026 à 21:46
-- Version du serveur : 11.8.3-MariaDB-log
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `u941360292_colibri`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `author_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `author_id`, `status`, `published_at`, `views`, `created_at`, `updated_at`) VALUES
(8, 'Deuxième session de formation du projet \"Colibri Littéraire\" : 60 acteurs africains analysent les modalités d’application de l’IA au secteur du livre', 'deuxieme-session-de-formation-du-projet-colibri-litteraire-60-acteurs-africains-analysent-les-modalites-dapplication-de-lia-au-secteur-du-livre', NULL, '<h2 class=\"ql-align-justify\">Du 21 au 23 janvier dernier, s’est déroulée, au profit d’environ soixante professionnels ouest africains francophones de la chaine du livre, à la Bibliothèque Bénin Excellence de Godomey et en ligne, la deuxième session de formation hybride entrant dans le cadre de la mise en œuvre du projet \"Colibri Littéraire\". C’est une initiative de l’ONG Ecrivains Humanistes du Bénin, réalisée avec le soutien de l’Organisation internationale de la Francophonie (OIF) dans le cadre du dispositif \"FORCE - Formation et renforcement de compétences en édition\".</h2><p><br></p>', 'img/blog/blog_6977d05268da0.jpg', 1, 'published', '2026-01-26 20:37:53', 9, '2026-01-26 20:36:34', '2026-02-02 16:56:03'),
(9, 'Dynamisation du marché du livre africain : L’ONG Ecrivains Humanistes outille 60 acteurs de la chaine', 'dynamisation-du-marche-du-livre-africain-long-ecrivains-humanistes-outille-60-acteurs-de-la-chaine', NULL, '<h2 class=\"ql-align-justify\">60 acteurs ouest africains du secteur du livre sont rentrés dans un processus de développement de nouveaux marchés du livre la semaine écoulée. C’est à la faveur de la première session du volet Formation et mise en réseau du projet \"Colibri Littéraire\", déroulée du 10 au 12 novembre, en présentiel à la Bibliothèque Bénin Excellence de Godomey au Bénin&nbsp;et en ligne. L’initiative, soutenue par l’Organisation internationale de la Francophonie (OIF) dans le cadre du dispositif FORCE – Formation et renforcement de compétences en édition\", est mise en œuvre par l’ONG Ecrivains Humanistes du Bénin.</h2><p><br></p>', 'img/blog/blog_6977d4d818053.jpg', 1, 'published', '2026-01-26 20:55:52', 6, '2026-01-26 20:55:52', '2026-02-07 00:05:44');

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('colibri-litteraire-cache-abounassirou5@gmail.com|41.216.53.193', 'i:2;', 1769171075),
('colibri-litteraire-cache-abounassirou5@gmail.com|41.216.53.193:timer', 'i:1769171075;', 1769171075),
('colibri-litteraire-cache-adorasse@yahoo.fr|41.79.219.112', 'i:1;', 1769171157),
('colibri-litteraire-cache-adorasse@yahoo.fr|41.79.219.112:timer', 'i:1769171157;', 1769171157),
('colibri-litteraire-cache-afrikartsstars@gmail.com|137.255.44.122', 'i:1;', 1769171293),
('colibri-litteraire-cache-afrikartsstars@gmail.com|137.255.44.122:timer', 'i:1769171293;', 1769171293),
('colibri-litteraire-cache-anicettefalonne@gmail.com|197.234.223.237', 'i:1;', 1769171535),
('colibri-litteraire-cache-anicettefalonne@gmail.com|197.234.223.237:timer', 'i:1769171535;', 1769171535),
('colibri-litteraire-cache-anicettesemevo@gmail.com|197.234.223.237', 'i:2;', 1769171455),
('colibri-litteraire-cache-anicettesemevo@gmail.com|197.234.223.237:timer', 'i:1769171455;', 1769171455),
('colibri-litteraire-cache-ayemeneh@gmail.com|160.154.150.17', 'i:2;', 1770281657),
('colibri-litteraire-cache-ayemeneh@gmail.com|160.154.150.17:timer', 'i:1770281657;', 1770281657),
('colibri-litteraire-cache-maboudourahim@gmail.com|137.255.44.122', 'i:2;', 1769171253),
('colibri-litteraire-cache-maboudourahim@gmail.com|137.255.44.122:timer', 'i:1769171253;', 1769171253),
('colibri-litteraire-cache-mcodjobligui@gmail.com|154.72.117.239', 'i:1;', 1769171128),
('colibri-litteraire-cache-mcodjobligui@gmail.com|154.72.117.239:timer', 'i:1769171128;', 1769171128),
('colibri-litteraire-cache-ogafabrice3@gmail.com|41.85.163.102', 'i:2;', 1769171255),
('colibri-litteraire-cache-ogafabrice3@gmail.com|41.85.163.102:timer', 'i:1769171255;', 1769171255),
('colibri-litteraire-cache-opheli2014@gmail.com|41.79.219.13', 'i:1;', 1769171208),
('colibri-litteraire-cache-opheli2014@gmail.com|41.79.219.13:timer', 'i:1769171208;', 1769171208),
('colibri-litteraire-cache-sewanout9@gmail.com|137.255.44.122', 'i:1;', 1769171243),
('colibri-litteraire-cache-sewanout9@gmail.com|137.255.44.122:timer', 'i:1769171243;', 1769171243),
('colibri-litteraire-cache-sewat369@gmail.com|137.255.44.122', 'i:1;', 1769171273),
('colibri-litteraire-cache-sewat369@gmail.com|137.255.44.122:timer', 'i:1769171273;', 1769171273);

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `catalogue_id` bigint(20) UNSIGNED NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `catalogues`
--

CREATE TABLE `catalogues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `auteur` varchar(255) DEFAULT NULL,
  `categorie` varchar(255) DEFAULT NULL,
  `prix` int(11) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'catalogue',
  `type_categorie` varchar(255) NOT NULL DEFAULT 'catalogue',
  `resumer` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `pdf` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `catalogues`
--

INSERT INTO `catalogues` (`id`, `titre`, `auteur`, `categorie`, `prix`, `quantite`, `type`, `type_categorie`, `resumer`, `image`, `pdf`, `created_at`, `updated_at`) VALUES
(4, 'La Bataille du Désert', 'Mouhamadou Kpaka', 'Autre', 5000, 1, 'catalogue', 'catalogue', '<p>La Bataille du désert</p>', 'img/livres/img_6966ea3e845a3.jpg', 'pdf/catalogue/pdf_6966ea3e84cdd.pdf', '2026-01-14 00:58:38', '2026-01-14 00:58:38'),
(5, 'Une cible dans le dos', 'Balndine Dokoui', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Une cible dans le dos</p>', 'img/livres/img_6966ebf4ea5db.jpg', 'pdf/catalogue/pdf_6966ebf4eaa82.pdf', '2026-01-14 01:05:56', '2026-01-14 01:05:56'),
(6, 'Les Tontinières', 'Erroce Yanclo', 'Autre', 5000, 100, 'catalogue', 'catalogue', '<p>Les Tontinières</p>', 'img/livres/img_6966ec73046ae.jpg', 'pdf/catalogue/pdf_6966ec7304a75.pdf', '2026-01-14 01:08:03', '2026-01-14 01:08:03'),
(7, 'Un cycliste dans l\'Iroko', 'Ana Baï Dangnivo', 'Autre', 4000, 100, 'catalogue', 'catalogue', '<p>Un cycliste dans l\'Iroko</p>', 'img/livres/img_6966ece430182.jpg', 'pdf/catalogue/pdf_6966ece4305ee.pdf', '2026-01-14 01:09:56', '2026-02-07 10:56:49'),
(8, 'Joyeuses Mélancolies', 'Axelle Adiho', 'Poésie', 5000, 100, 'catalogue', 'catalogue', '<p>Joyeuses Mélancolies</p>', 'img/livres/img_6966ed363fa39.jpg', 'pdf/catalogue/pdf_6966ed363ff94.pdf', '2026-01-14 01:11:18', '2026-01-14 01:11:18'),
(9, 'Les hommes de ces femmes', 'Elvy Gotiene', 'Autre', 10000, 100, 'catalogue', 'catalogue', '<p>Les hommes de ces femmes&nbsp;</p>', 'img/livres/img_6966edcf52b98.jpg', 'pdf/catalogue/pdf_6966edcf531dd.pdf', '2026-01-14 01:13:51', '2026-01-14 01:14:16'),
(10, 'Quand un choix  s\'impose', 'Hervé Ayémèné', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Quand un choix &nbsp;s\'impose</p>', 'img/livres/img_6966ee4c2f03c.jpg', 'pdf/catalogue/pdf_6966ee4c2f440.pdf', '2026-01-14 01:15:56', '2026-01-14 01:15:56'),
(11, 'Les contes d\'ici et d\'ailleurs', 'Raymond Orou', 'Conte', 2000, 100, 'catalogue', 'catalogue', '<p>Les contes d\'ici et d\'ailleurs</p>', 'img/livres/img_6966ef00013b0.jpg', 'pdf/catalogue/pdf_6966ef00018ac.pdf', '2026-01-14 01:18:56', '2026-02-07 11:06:17'),
(12, 'Fleurs de Bonté', 'Alex André', 'Roman', 3500, 100, 'catalogue', 'catalogue', '<p>Fleurs de Bonté</p>', 'img/livres/img_6966efbfdcee0.jpg', 'pdf/catalogue/pdf_6966efbfdd379.pdf', '2026-01-14 01:22:07', '2026-02-07 11:09:06'),
(13, 'Le silence du tambour sacré', 'Archille Yameogo', 'Conte', 2500, 100, 'catalogue', 'catalogue', '<p>Le silence du tambour sacré</p>', 'img/livres/img_6966f05b50037.jpg', 'pdf/catalogue/pdf_6966f05b504a4.pdf', '2026-01-14 01:24:43', '2026-02-07 11:15:27'),
(14, 'Quand l\'amour devient une défiance', 'Konan Raoul Kouassi', 'Roman', 3500, 100, 'catalogue', 'catalogue', '<p>Quand l\'amour devient une défiance</p>', 'img/livres/img_6966f1108d1a8.jpg', 'pdf/catalogue/pdf_6966f1108d516.pdf', '2026-01-14 01:27:44', '2026-02-07 11:19:08'),
(15, 'Le silence des consciences', 'Nicole Kangah', 'Roman', 2500, 100, 'catalogue', 'catalogue', '<p>Le silence des consciences</p>', 'img/livres/img_6966f1b4d6257.jpg', 'pdf/catalogue/pdf_6966f1b4d66bf.pdf', '2026-01-14 01:30:28', '2026-02-07 11:19:57'),
(16, 'Invasion', 'Teki Ivan', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Invasion</p>', 'img/livres/img_6966f27b5e2a3.jpg', 'pdf/catalogue/pdf_6966f27b5e66a.pdf', '2026-01-14 01:33:47', '2026-01-14 01:33:47'),
(17, 'Représailles écarlates', 'Lionel Badele', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Représailles écarlates</p>', 'img/livres/img_6966f51a754eb.jpg', 'pdf/catalogue/pdf_6966f51a75a22.pdf', '2026-01-14 01:44:58', '2026-01-14 01:44:58'),
(18, 'Le poisson magique', 'Emmanuelle Berny-Lalèyè', 'Jeunesse', 5000, 100, 'catalogue', 'catalogue', '<p>Le poisson magique</p>', 'img/livres/img_6966f5643fc56.jpg', 'pdf/catalogue/pdf_6966f5644018a.pdf', '2026-01-14 01:46:12', '2026-02-08 18:45:27'),
(19, 'Le Mystère des assins volés', 'Emmanuelle Berny-Lalèyè', 'Jeunesse', 5000, 100, 'catalogue', 'catalogue', '<p>Le Mystère des assins volés</p>', 'img/livres/img_6966f5f4422a2.jpg', 'pdf/catalogue/pdf_6966f5f4426f8.pdf', '2026-01-14 01:48:36', '2026-01-14 01:48:36'),
(20, 'Mika et Miko', 'Gjimm Mokoo', 'Jeunesse', 3500, 100, 'catalogue', 'catalogue', '<p>Mika et Miko</p>', 'img/livres/img_6966f6d3020a5.jpg', 'pdf/catalogue/pdf_6966f6d30241b.pdf', '2026-01-14 01:52:19', '2026-02-07 11:31:38'),
(21, 'De la natte à l\'écran', 'Idrissa Sow', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>De la natte à l\'écran</p>', 'img/livres/img_6966f739c12a0.jpg', 'pdf/catalogue/pdf_6966f739c16ea.pdf', '2026-01-14 01:54:01', '2026-01-14 01:54:01'),
(22, 'Chants pour une fleur', 'Alvie Mouzita', 'Poésie', 5000, 100, 'catalogue', 'catalogue', '<p>Chants pour une fleur</p>', 'img/livres/img_6966f76d6c502.jpg', 'pdf/catalogue/pdf_6966f76d6c8ff.pdf', '2026-01-14 01:54:53', '2026-01-14 01:54:53'),
(23, 'L\'Accordéon veuf', 'Roland Kotcha', 'Poésie', 5000, 100, 'catalogue', 'catalogue', '<p>L\'Accordéon veuf&nbsp;</p>', 'img/livres/img_6966f81bb1fd3.jpg', 'pdf/catalogue/pdf_6966f81bb274a.pdf', '2026-01-14 01:57:47', '2026-01-14 01:57:47'),
(24, 'Virage Abrupt', 'Bénédicte Lovi', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Virage Abrupt</p>', 'img/livres/img_6966f87d835c8.jpg', 'pdf/catalogue/pdf_6966f87d83a47.pdf', '2026-01-14 01:59:25', '2026-01-14 01:59:25'),
(25, '40 ans de réclusion criminelle', 'Roméo Jérémie Babalao', 'Roman', 4000, 100, 'catalogue', 'catalogue', '<p>40 ans de réclusion criminelle</p>', 'img/livres/img_6966fc28adf4f.jpg', 'pdf/catalogue/pdf_6966fc28ae8f6.pdf', '2026-01-14 02:15:04', '2026-02-07 10:58:01'),
(26, '60 Millions', 'Chrys Amegan', 'Autre', 5000, 100, 'catalogue', 'catalogue', '<p>60 Millions</p>', 'img/livres/img_6966fcaa2e03d.jpg', 'pdf/catalogue/pdf_6966fcaa2e982.pdf', '2026-01-14 02:17:14', '2026-01-14 02:17:14'),
(27, 'Oxytocine', 'Chrys Amegan', 'Poésie', 5000, 100, 'catalogue', 'catalogue', '<p>Oxytocine</p>', 'img/livres/img_6966fcf847bef.jpg', 'pdf/catalogue/pdf_6966fcf8489b2.pdf', '2026-01-14 02:18:32', '2026-01-14 02:18:32'),
(28, 'Ebullition', 'Florent Aïkpé', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Ebullition</p>', 'img/livres/img_6966fd5a679ce.jpg', 'pdf/catalogue/pdf_6966fd5a67da6.pdf', '2026-01-14 02:20:10', '2026-01-14 02:20:10'),
(29, 'Le silence du pilon', 'Idrissa Sow', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Le silence du pilon&nbsp;</p>', 'img/livres/img_6966fdfa400e3.jpg', 'pdf/catalogue/pdf_6966fdfa40491.pdf', '2026-01-14 02:22:50', '2026-01-14 02:22:50'),
(30, 'La plus belle voix', 'Kodjo Agbemele', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>La plus belle voix</p>', 'img/livres/img_6966feba8f282.jpg', 'pdf/catalogue/pdf_6966feba8f781.pdf', '2026-01-14 02:26:02', '2026-01-14 02:26:02'),
(31, 'Le coeur d\'une fille originale', 'Kindenin Sabine Tuo', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Le coeur d\'une fille originale</p>', 'img/livres/img_696a345c2ac6d.jpg', 'pdf/catalogue/pdf_696a345c2b2f4.pdf', '2026-01-16 12:51:40', '2026-01-16 12:51:40'),
(32, 'Mon Panégyrique, Mon identité culturelle', 'ONG Ecrivains Humanistes', 'Documentaire', 10000, 100, 'catalogue', 'catalogue', '<p>Mon Panégyrique, Mon identité culturelle</p>', 'img/livres/img_696a34b84988f.jpg', 'pdf/catalogue/pdf_696a34b849c4c.pdf', '2026-01-16 12:53:12', '2026-02-07 11:07:16'),
(33, 'Soltices', 'Fabrice Oga', 'Poésie', 3000, 100, 'catalogue', 'catalogue', '<p>Fabrice Oga - Soltices</p>', 'img/livres/img_696a3527aa213.jpg', 'pdf/catalogue/pdf_696a3527aa72b.pdf', '2026-01-16 12:55:03', '2026-02-07 11:49:26'),
(34, 'A voix haute : le combat silencieux', 'Dah Sansan', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Dah Sansan - A voix haute : le combat silencieux - 5 000</p>', 'img/livres/img_696a359ae2594.jpg', 'pdf/catalogue/pdf_696a359ae2a00.pdf', '2026-01-16 12:56:58', '2026-01-16 12:56:58'),
(35, 'Katus', 'Safiatou Kaba', 'Essai', 5000, 100, 'catalogue', 'catalogue', '<p>Safiatou Kaba - Katus</p>', 'img/livres/img_696a361834098.jpg', 'pdf/catalogue/pdf_696a361834658.pdf', '2026-01-16 12:59:04', '2026-01-16 12:59:04'),
(36, 'Jeyna Ly : Taxiwoman', 'Abdoulaye Fodé Ndione', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Taxiwoman : Jeyna Ly</p>', 'img/livres/img_696a36dd9b9f0.jpg', 'pdf/catalogue/pdf_696a36dd9be28.pdf', '2026-01-16 13:02:21', '2026-01-16 13:02:21'),
(48, 'Sauvée par l\'amour', 'Jérôme Gnaloko Didi', 'Roman', 3500, 100, 'catalogue', 'catalogue', '<p>Sauvée par l\'amour -&nbsp;</p>', 'img/livres/img_697c7ab6539f3.jpg', 'pdf/catalogue/pdf_697c7ab653f6d.pdf', '2026-01-30 09:32:38', '2026-02-08 18:46:42'),
(49, 'Le super-héros', 'Touré Maguèye', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Le super héros - Touré Maguèye&nbsp;</p>', 'img/livres/img_697c7c4d3f9aa.jpg', 'pdf/catalogue/pdf_697c7c4d3fe34.pdf', '2026-01-30 09:39:25', '2026-01-30 09:39:25'),
(50, 'Faty, une vie volée', 'Jérôme Gnaloko Didi', 'Roman', 3500, 100, 'catalogue', 'catalogue', '<p>Faty, une vie volée - Jérôme Gnaloko Didi</p>', 'img/livres/img_697c7d8965f6d.jpg', 'pdf/catalogue/pdf_697c7d8966407.pdf', '2026-01-30 09:44:41', '2026-02-08 18:47:13'),
(51, 'Le droit d\'avoir mal', 'Marie - Elyse N\'guessan', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Le droit d\'avoir mal - Le droit d\'avoir mal</p>', 'img/livres/img_697c7ec207e8a.jpg', 'pdf/catalogue/pdf_697c7ec2084bf.pdf', '2026-01-30 09:49:54', '2026-01-30 09:49:54'),
(52, 'Les déboires d\'un courreur de jupons', 'Jérôme Gnaloko Didi', 'Roman', 3500, 100, 'catalogue', 'catalogue', '<p>Les déboires d\'un courreur de jupons - Jérôme Gnaloko Didi</p>', 'img/livres/img_697c82566a0bc.jpg', 'pdf/catalogue/pdf_697c82566a469.pdf', '2026-01-30 10:05:10', '2026-02-08 18:47:55'),
(53, 'L\'énigme de la nuit', 'Billas Kanate', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>L\'énigme de la nuit - Billas Kanate&nbsp;</p>', 'img/livres/img_697c88d1089dc.jpg', 'pdf/catalogue/pdf_697c88d108cf1.pdf', '2026-01-30 10:32:49', '2026-01-30 10:32:49');

-- --------------------------------------------------------

--
-- Structure de la table `certificats`
--

CREATE TABLE `certificats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `formation_inscription_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nom_manuel` varchar(255) DEFAULT NULL,
  `email_manuel` varchar(255) DEFAULT NULL,
  `formation_id` bigint(20) UNSIGNED NOT NULL,
  `numero_certificat` varchar(255) NOT NULL,
  `fichier_pdf` varchar(255) DEFAULT NULL,
  `note_obtenue` int(11) NOT NULL,
  `date_delivrance` timestamp NOT NULL DEFAULT current_timestamp(),
  `envoye_email` tinyint(1) NOT NULL DEFAULT 0,
  `date_envoi_email` timestamp NULL DEFAULT NULL,
  `statut` enum('genere','envoye','reclame','valide','annule') DEFAULT 'genere',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `statut` varchar(255) NOT NULL DEFAULT 'pending',
  `paiement_valide` tinyint(1) NOT NULL DEFAULT 0,
  `reference_paiement` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `idempotency_key` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `user_id`, `nom`, `telephone`, `adresse`, `total`, `statut`, `paiement_valide`, `reference_paiement`, `payment_method`, `idempotency_key`, `created_at`, `updated_at`) VALUES
(2, NULL, NULL, NULL, NULL, 5000.00, 'confirmee', 1, 'TEST-69706534DEB8B', 'test', NULL, '2026-01-21 04:33:33', '2026-01-21 04:33:40'),
(3, 32, NULL, NULL, NULL, 5000.00, 'confirmee', 1, 'TEST-69794F35F38CC', 'test', NULL, '2026-01-27 23:50:11', '2026-01-27 23:50:13'),
(4, 33, 'Herve AYEMENE', '+2250707702219', 'Bp 366 Dabou', 10000.00, 'pending', 0, NULL, NULL, 'cod_69845b0be2fa88.18832301', '2026-02-05 08:55:39', '2026-02-05 08:55:39');

-- --------------------------------------------------------

--
-- Structure de la table `commande_items`
--

CREATE TABLE `commande_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `commande_id` bigint(20) UNSIGNED NOT NULL,
  `catalogue_id` bigint(20) UNSIGNED DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `quantite` int(11) NOT NULL DEFAULT 1,
  `prix` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commande_items`
--

INSERT INTO `commande_items` (`id`, `commande_id`, `catalogue_id`, `titre`, `quantite`, `prix`, `created_at`, `updated_at`) VALUES
(2, 2, 36, NULL, 1, 0.00, '2026-01-21 04:33:33', '2026-01-21 04:33:33'),
(3, 3, 36, NULL, 1, 0.00, '2026-01-27 23:50:11', '2026-01-27 23:50:11'),
(4, 4, 53, 'L\'énigme de la nuit', 2, 5000.00, '2026-02-05 08:55:39', '2026-02-05 08:55:39');

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 'Hello http://colibri-litteraire.com/fekal0911 Owner', 'pirduhina96@gmail.com', 'Dear http://colibri-litteraire.com/fekal0911 Webmaster', 'To the http://colibri-litteraire.com/fekal0911 Webmaster', 1, '2026-01-27 10:33:06', '2026-01-26 10:38:16', '2026-01-27 10:33:06');

-- --------------------------------------------------------

--
-- Structure de la table `emprunts`
--

CREATE TABLE `emprunts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `livre_id` bigint(20) UNSIGNED NOT NULL,
  `date_emprunt` date NOT NULL,
  `date_retour` date DEFAULT NULL,
  `statut` varchar(255) NOT NULL DEFAULT 'En cours',
  `valide_par` bigint(20) UNSIGNED DEFAULT NULL,
  `valide_le` timestamp NULL DEFAULT NULL,
  `access_expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `equipes`
--

CREATE TABLE `equipes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `poste` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `equipes`
--

INSERT INTO `equipes` (`id`, `nom`, `poste`, `bio`, `photo`, `email`, `actif`, `created_at`, `updated_at`) VALUES
(1, 'Camille SEGNIGBINDE', 'Président - Coordonateur \"Colibri Littéraire\"', NULL, 'img/team/camille.png', 'camille.segnigbinde@colibri-litteraire.org', 1, '2025-12-30 14:33:41', '2026-01-17 14:38:36'),
(2, 'Catira DODO', 'Responsable à la Formation', NULL, 'img/team/catira.png', 'catira.dodo@colibri-litteraire.org', 1, '2025-12-30 14:33:41', '2026-01-17 14:36:12'),
(3, 'Hervé AYEMENE', 'Point Focal - Côte d\'Ivoire', NULL, 'img/team/Hervé.png', 'herve.ayemene@colibri-litteraire.org', 1, '2025-12-30 14:33:41', '2026-01-17 14:36:27'),
(4, 'Prudentienne GBAGUIDI', 'Experte Formatrice', NULL, 'img/team/prudentienne.jpg', 'prudentienne.gbaguidi@colibri-litteraire.org', 1, '2025-12-30 14:33:41', '2026-01-17 14:36:38'),
(5, 'Augustino AGBEMAVO', 'Expert Formateur', NULL, 'img/team/augustino.jpg', 'augustino.agbemavo@colibri-litteraire.org', 1, '2025-12-30 14:33:41', '2026-01-17 14:36:56'),
(6, 'Rodrigue ATCHAOUE', 'Expert Formateur', NULL, 'img/team/rodrigue.jpg', 'rodrigue.atchaoue@colibri-litteraire.org', 1, '2025-12-30 14:33:41', '2026-01-17 14:37:06'),
(7, 'Adèle KIEMA', 'Point focal Colibri Littéraire - Niger', NULL, 'img/team/adele.png', 'adele.kiema@colibri-litteraire.org', 1, '2025-12-30 14:33:42', '2026-01-17 14:35:09'),
(8, 'Idrissa SOW', 'Point focal Colibri Littéraire - Sénégal', NULL, 'img/team/idrissa.jpg', 'idrissa.sow@colibri-litteraire.org', 1, '2025-12-30 14:33:42', '2026-01-17 12:36:18'),
(9, 'Yawavi MBOUKE', 'Point focal Colibri Littéraire - Togo', NULL, 'img/team/yawavi.png', 'yawavi.mbouke@colibri-litteraire.org', 1, '2025-12-30 14:33:42', '2026-01-17 12:38:10'),
(10, 'Vivien Zanou', 'Responsable à la logistique', NULL, 'img/team/vivien.png', 'vivien.zanou@colibri-litteraire.org', 1, '2025-12-30 14:33:42', '2026-01-17 14:35:35'),
(11, 'Corneille ANOUMON', 'Responsable à la communication', NULL, 'img/team/corneille.png', 'corneille.anoumon@colibri-litteraire.org', 1, '2025-12-30 14:33:42', '2026-01-17 14:35:47');

-- --------------------------------------------------------

--
-- Structure de la table `evaluations`
--

CREATE TABLE `evaluations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `formation_inscription_id` bigint(20) UNSIGNED NOT NULL,
  `formation_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `note` int(11) NOT NULL DEFAULT 0,
  `nombre_questions` int(11) NOT NULL DEFAULT 0,
  `reponses_correctes` int(11) NOT NULL DEFAULT 0,
  `reponses` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`reponses`)),
  `date_evaluation` timestamp NOT NULL DEFAULT current_timestamp(),
  `reussie` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `formations`
--

CREATE TABLE `formations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `objectifs` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `niveau` enum('debutant','intermediaire','avance') DEFAULT NULL,
  `duree` varchar(255) DEFAULT NULL,
  `nombre_modules` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `categorie` varchar(255) DEFAULT NULL,
  `prerequis` text DEFAULT NULL,
  `note_minimale_certification` int(11) NOT NULL DEFAULT 70,
  `inscrits_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `formations`
--

INSERT INTO `formations` (`id`, `titre`, `description`, `objectifs`, `image`, `prix`, `niveau`, `duree`, `nombre_modules`, `active`, `categorie`, `prerequis`, `note_minimale_certification`, `inscrits_count`, `created_at`, `updated_at`) VALUES
(2, 'Marketing digital appliqué à la chaine du livre en Afrique francophone', 'Cette formation est développée pour permettre aux professionnels de la chaine du livre d\'acquérir les compétences nécessaires en marketing digital en vue de donner de la visibilité aux livres africains francophones et de croitre leur vente. \r\nElle est créée dans le cadre du dispositif Formation et renforcement de compétences en édition - FORCE de l\'Organisation internationale de la Francophonie (OIF).\r\n\r\nCette formation est créée par Augustino AGBEMAVO (Expert en digitalisation) et SEGNIGBINDE A. Camille (Expert Industrie Culturelle et Créative (ICC) - Livre', 'L\'objectif de cette formation est d\'acquérir les compétences nécessaires en marketing digital appliqué aux entreprises de la chaine du livre en Afrique francophone', 'img/formations/formation_696bd0c54646d.PNG', 0.00, 'debutant', '4 heures', 0, 1, 'Marketing digital', 'Cette formation est réservée aux personnes en charge de la communication au sein des entreprises de la chaine du livre. Disposer d\'un poste ordinateur et de la connexion internet sont les préalables pour réussir cette formation', 100, 0, '2026-01-17 18:11:17', '2026-01-18 21:43:12'),
(3, 'MARKETING DES RÉSEAUX SOCIAUX : Quel réseau pour quel objectif ?', 'Cette formation est un prolongement de celle portant sur le marketing digital. Elle est développée pour permettre aux professionnels de la chaine du livre d\'acquérir les compétences nécessaires à l\'utilisation des réseaux sociaux pour donner de la visibilité aux livres africains francophones et de croitre leur vente. \r\nElle est créée dans le cadre du dispositif Formation et renforcement de compétences en édition - FORCE de l\'Organisation internationale de la Francophonie (OIF).\r\n\r\nCette formation est créée par Augustino AGBEMAVO (Expert en digitalisation) et SEGNIGBINDE A. Camille (Expert ICC - Livre)', 'L\'objectif de cette formation est de faire découvrir aux acteurs de la chaine du livre, les outils nécessaires à la connaissance des réseaux sociaux pour leur permettre d\'en faire un usage rentable à leurs activités liées l\'industrie du livre.', 'img/formations/formation_696bdebd9e46a.PNG', 0.00, 'intermediaire', '2', 0, 1, 'Marketing digital', 'Il est nécessaire de maitriser l\'outil internet, de disposer d\'un ordinateur ou un smartphone, de la connexion internet et de savoir les manipuler.', 100, 0, '2026-01-17 19:10:53', '2026-01-17 19:10:53'),
(7, 'Les enjeux et défis du droit d\'auteurs à l\'ère du numérique : protection, partage et innovation dans le domaine littéraire', 'Cette formation présente les principes essentiels du droit d’auteur appliqués au domaine littéraire et aux pratiques professionnelles de la chaine du livre. Elle vise à mieux comprendre les enjeux et les risques liés au numérique (piratage, intelligence artificielle, plateformes de diffusion), à concilier la protection des œuvres avec le partage des connaissances et l’innovation, à promouvoir l’adoption de bonnes pratiques chez les auteurs, lecteurs, enseignants et diffuseurs, et à encourager la coopération régionale.\r\nCette formation porte sur un sujet central pour tous les métiers du livre aujourd’hui : comment protéger les œuvres littéraires à l’ère du numérique, sans freiner la création ni l’accès au savoir.Étant donné la diversité des pays représentés, nous avons fait le choix d’un cadre juridique commun : l’Annexe VII de l’Accord de Bangui, applicable dans l’espace OAPI.\r\n\r\nL’objectif n’est pas de faire de vous des juristes, mais de vous donner des repères clairs, directement utiles dans vos pratiques quotidiennes : écrire, éditer, diffuser, vendre ou enseigner le livre.\r\nChaque pays a ses textes nationaux, mais pour éviter un éclatement juridique, nous nous appuyons sur un socle commun.Lorsque ce sera pertinent, je ferai ponctuellement référence à des exemples du Bénin, de la Côte d’Ivoire ou du Togo.\r\n\r\nL’OAPI regroupe plusieurs États africains autour d’un droit unifié de la propriété intellectuelle.L’Annexe VII est le texte de référence pour le droit d’auteur et les droits voisins.', '- Comprendre les fondements du droit d’auteur appliqués à la filière du livre, \r\n- Identifier les enjeux et risques du numérique (piratage, IA, plateformes),\r\n- Concilier protection des œuvres, partage des savoirs et innovation,\r\n- Adopter de bonnes pratiques en tant qu’auteur, lecteur, enseignant ou diffuseur.', 'img/formations/formation_69871d5d762ab.PNG', 0.00, 'debutant', '5 Heures', 0, 1, 'Droit d\'auteurs', 'Aucun prérequis n\'est exigé pour suivre cette formation', 100, 0, '2026-02-07 11:09:17', '2026-02-07 11:14:47');

-- --------------------------------------------------------

--
-- Structure de la table `formation_inscriptions`
--

CREATE TABLE `formation_inscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `formation_id` bigint(20) UNSIGNED NOT NULL,
  `montant_paye` decimal(10,2) NOT NULL,
  `statut` enum('en_cours','termine','abandonne') NOT NULL DEFAULT 'en_cours',
  `progression` int(11) NOT NULL DEFAULT 0,
  `date_inscription` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_fin` timestamp NULL DEFAULT NULL,
  `paiement_valide` tinyint(1) NOT NULL DEFAULT 0,
  `reference_paiement` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `formation_inscriptions`
--

INSERT INTO `formation_inscriptions` (`id`, `user_id`, `formation_id`, `montant_paye`, `statut`, `progression`, `date_inscription`, `date_fin`, `paiement_valide`, `reference_paiement`, `created_at`, `updated_at`) VALUES
(3, 20, 3, 0.00, 'en_cours', 0, '2026-01-23 12:31:17', NULL, 0, NULL, '2026-01-23 12:31:17', '2026-01-23 12:31:17'),
(4, 7, 2, 0.00, 'en_cours', 0, '2026-01-23 12:32:03', NULL, 0, NULL, '2026-01-23 12:32:03', '2026-01-23 12:32:03'),
(5, 32, 2, 0.00, 'en_cours', 0, '2026-01-27 22:45:41', NULL, 1, 'TEST-6979402057C55', '2026-01-27 22:45:41', '2026-01-27 22:45:52');

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"dde9893f-9c83-4036-bdd0-d1405bcb250c\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"raoulkouassikonan@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1767981888,\"delay\":null}', 0, NULL, 1767981888, 1767981888),
(2, 'default', '{\"uuid\":\"4362862a-6f56-4a24-8108-0ea960c0c6e6\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1767981888,\"delay\":null}', 0, NULL, 1767981888, 1767981888),
(3, 'default', '{\"uuid\":\"a70d0a38-7b84-48c7-b8f2-be18ce6a4a77\",\"displayName\":\"App\\\\Mail\\\\User\\\\PaymentConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:33:\\\"App\\\\Mail\\\\User\\\\PaymentConfirmation\\\":3:{s:11:\\\"inscription\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:31:\\\"App\\\\Models\\\\FormationInscription\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:17:\\\"colibri@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1768227885,\"delay\":null}', 0, NULL, 1768227885, 1768227885),
(4, 'default', '{\"uuid\":\"8a707744-f50f-435f-9311-58857247fbd9\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewPayment\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:25:\\\"App\\\\Mail\\\\Admin\\\\NewPayment\\\":3:{s:11:\\\"inscription\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:31:\\\"App\\\\Models\\\\FormationInscription\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1768227885,\"delay\":null}', 0, NULL, 1768227885, 1768227885),
(5, 'default', '{\"uuid\":\"74448a1a-dd7d-4189-84fc-d519ff689f4f\",\"displayName\":\"App\\\\Mail\\\\User\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:31:\\\"App\\\\Mail\\\\User\\\\OrderConfirmation\\\":3:{s:8:\\\"commande\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\Commande\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:17:\\\"colibri@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1768231773,\"delay\":null}', 0, NULL, 1768231773, 1768231773),
(6, 'default', '{\"uuid\":\"d5384899-1191-4681-b3a5-254803f9821e\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewOrder\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:23:\\\"App\\\\Mail\\\\Admin\\\\NewOrder\\\":3:{s:8:\\\"commande\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\Commande\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1768231773,\"delay\":null}', 0, NULL, 1768231773, 1768231773),
(7, 'default', '{\"uuid\":\"7cb6e4df-6b8a-4baf-a291-4ac1e4750c5b\",\"displayName\":\"App\\\\Mail\\\\User\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:31:\\\"App\\\\Mail\\\\User\\\\OrderConfirmation\\\":3:{s:8:\\\"commande\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\Commande\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:17:\\\"colibri@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1768231784,\"delay\":null}', 0, NULL, 1768231784, 1768231784),
(8, 'default', '{\"uuid\":\"c1c3b957-f406-4b4e-82be-60e301b0e053\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewOrder\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:23:\\\"App\\\\Mail\\\\Admin\\\\NewOrder\\\":3:{s:8:\\\"commande\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\Commande\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1768231784,\"delay\":null}', 0, NULL, 1768231784, 1768231784),
(9, 'default', '{\"uuid\":\"ae792614-7e48-47a7-9189-1e709e49aeab\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewContact\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:25:\\\"App\\\\Mail\\\\Admin\\\\NewContact\\\":3:{s:7:\\\"contact\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Contact\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1768233808,\"delay\":null}', 0, NULL, 1768233808, 1768233808),
(10, 'default', '{\"uuid\":\"9dc619a4-361b-41b4-9adb-76497fe3a878\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:19:\\\"analex1er@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1768561787,\"delay\":null}', 0, NULL, 1768561787, 1768561787),
(11, 'default', '{\"uuid\":\"6a234c91-1f68-4811-bff5-d246cef78194\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1768561787,\"delay\":null}', 0, NULL, 1768561787, 1768561787),
(12, 'default', '{\"uuid\":\"227d79a0-c4c5-4a4e-92bf-169c4372e076\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:4;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"gnalokodidijerome@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1768563639,\"delay\":null}', 0, NULL, 1768563639, 1768563639),
(13, 'default', '{\"uuid\":\"74be3bd9-e534-4434-8aee-fb1dc741ce06\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:4;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1768563639,\"delay\":null}', 0, NULL, 1768563639, 1768563639),
(14, 'default', '{\"uuid\":\"705bffce-9228-48e9-be7c-38a3c5f243db\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:21:\\\"angesonhkah@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1768565940,\"delay\":null}', 0, NULL, 1768565940, 1768565940),
(15, 'default', '{\"uuid\":\"768853a5-621c-4b35-819e-bc7066d478ab\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1768565940,\"delay\":null}', 0, NULL, 1768565940, 1768565940),
(16, 'default', '{\"uuid\":\"5d2bae6a-93c0-4212-91bf-03a0b18e559a\",\"displayName\":\"App\\\\Mail\\\\User\\\\PaymentConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:33:\\\"App\\\\Mail\\\\User\\\\PaymentConfirmation\\\":3:{s:11:\\\"inscription\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:31:\\\"App\\\\Models\\\\FormationInscription\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:17:\\\"colibri@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1768681260,\"delay\":null}', 0, NULL, 1768681260, 1768681260),
(17, 'default', '{\"uuid\":\"3268c7c1-5663-4add-8668-15e17cf90c80\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewPayment\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:25:\\\"App\\\\Mail\\\\Admin\\\\NewPayment\\\":3:{s:11:\\\"inscription\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:31:\\\"App\\\\Models\\\\FormationInscription\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1768681260,\"delay\":null}', 0, NULL, 1768681260, 1768681260),
(18, 'default', '{\"uuid\":\"f2c5f6a3-6f65-4c11-8e8e-173a7c258545\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:25:\\\"prestigezondoga@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1768973592,\"delay\":null}', 0, NULL, 1768973592, 1768973592),
(19, 'default', '{\"uuid\":\"c8167056-8233-4b38-be62-9ca5e50af7b2\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1768973593,\"delay\":null}', 0, NULL, 1768973593, 1768973593),
(20, 'default', '{\"uuid\":\"b1633b58-b577-49f9-b95b-2059bc9c6c1d\",\"displayName\":\"App\\\\Mail\\\\User\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:31:\\\"App\\\\Mail\\\\User\\\\OrderConfirmation\\\":3:{s:8:\\\"commande\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\Commande\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:25:\\\"prestigezondoga@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1768973621,\"delay\":null}', 0, NULL, 1768973621, 1768973621),
(21, 'default', '{\"uuid\":\"c10ae4ce-837e-4e8a-bdfc-c0bed5aa6c18\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewOrder\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:23:\\\"App\\\\Mail\\\\Admin\\\\NewOrder\\\":3:{s:8:\\\"commande\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\Commande\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1768973621,\"delay\":null}', 0, NULL, 1768973621, 1768973621),
(22, 'default', '{\"uuid\":\"0ae23c81-4dd4-4ae0-b9a7-3cc287832514\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:19:\\\"guidji336@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171044,\"delay\":null}', 0, NULL, 1769171044, 1769171044),
(23, 'default', '{\"uuid\":\"f79f3ee6-0c3e-40a0-89a3-29e1b64447cb\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171044,\"delay\":null}', 0, NULL, 1769171044, 1769171044),
(24, 'default', '{\"uuid\":\"0e5a140b-0165-4a3f-80b5-090f6de70825\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:22:\\\"gervaisdassi@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171126,\"delay\":null}', 0, NULL, 1769171126, 1769171126),
(25, 'default', '{\"uuid\":\"c2f28e9b-032e-4230-bb56-d2a21ced3d7f\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171126,\"delay\":null}', 0, NULL, 1769171126, 1769171126),
(26, 'default', '{\"uuid\":\"2373ae11-49dc-40d6-8ebd-f5900311e8da\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:9;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:23:\\\"anagosendrine@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171134,\"delay\":null}', 0, NULL, 1769171134, 1769171134),
(27, 'default', '{\"uuid\":\"07200bd1-945b-4fca-baa4-26dc40765a3b\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:9;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171134,\"delay\":null}', 0, NULL, 1769171134, 1769171134),
(28, 'default', '{\"uuid\":\"a61b871a-60b4-4456-8ee0-4bab31a1e829\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:10;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:25:\\\"larissapadonou2@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171157,\"delay\":null}', 0, NULL, 1769171157, 1769171157),
(29, 'default', '{\"uuid\":\"831f65d2-0b43-4c37-b717-70d31190ffbe\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:10;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171157,\"delay\":null}', 0, NULL, 1769171157, 1769171157),
(30, 'default', '{\"uuid\":\"d17f9390-55d8-4e3e-b862-a3a1b92f8012\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:11;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:18:\\\"edolive3@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171163,\"delay\":null}', 0, NULL, 1769171163, 1769171163),
(31, 'default', '{\"uuid\":\"28868668-3084-440b-b8be-0ca768230f4b\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:11;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171163,\"delay\":null}', 0, NULL, 1769171163, 1769171163),
(32, 'default', '{\"uuid\":\"0722b8c7-d8d6-4edc-956c-365bd285fdbf\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:12;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:26:\\\"samedialphonse98@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171180,\"delay\":null}', 0, NULL, 1769171180, 1769171180),
(33, 'default', '{\"uuid\":\"9caacf75-bcd7-4e2f-a6fe-d0f832f4fdda\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:12;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171180,\"delay\":null}', 0, NULL, 1769171180, 1769171180),
(34, 'default', '{\"uuid\":\"c4228998-c7b2-44be-98a6-6418e15fc799\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:13;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:29:\\\"annabaidangnivo2017@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171201,\"delay\":null}', 0, NULL, 1769171201, 1769171201),
(35, 'default', '{\"uuid\":\"326b79af-7384-4ff9-a2d6-325c2612913f\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:13;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171201,\"delay\":null}', 0, NULL, 1769171201, 1769171201);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(36, 'default', '{\"uuid\":\"ea62ded7-4efb-47f3-a050-145b2450e368\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:14;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:25:\\\"makhfouslegrand@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171209,\"delay\":null}', 0, NULL, 1769171209, 1769171209),
(37, 'default', '{\"uuid\":\"82b015d9-33e4-4eac-ad71-f70176f1d4fc\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:14;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171209,\"delay\":null}', 0, NULL, 1769171209, 1769171209),
(38, 'default', '{\"uuid\":\"2c4f33e7-80a8-4852-a517-9d52be01d6c2\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:15;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:25:\\\"dmoisenonvignon@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171217,\"delay\":null}', 0, NULL, 1769171217, 1769171217),
(39, 'default', '{\"uuid\":\"0f40d495-c2c5-4099-97c0-b1cfe2829c69\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:15;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171217,\"delay\":null}', 0, NULL, 1769171217, 1769171217),
(40, 'default', '{\"uuid\":\"716669d8-9c9d-4b09-814b-c73f94fae8ef\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:16;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:22:\\\"mcodjobligui@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171257,\"delay\":null}', 0, NULL, 1769171257, 1769171257),
(41, 'default', '{\"uuid\":\"0dc38ad5-a3f3-4fd0-9b07-865165f22bfd\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:16;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171257,\"delay\":null}', 0, NULL, 1769171257, 1769171257),
(42, 'default', '{\"uuid\":\"368655d8-e1ab-4dce-a598-9dec005fe922\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:17;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:23:\\\"yawavi.mbouke@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171261,\"delay\":null}', 0, NULL, 1769171261, 1769171261),
(43, 'default', '{\"uuid\":\"c0788e71-a260-4fa4-96d8-a47d894baca7\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:17;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171261,\"delay\":null}', 0, NULL, 1769171261, 1769171261),
(44, 'default', '{\"uuid\":\"3aa42aa6-ed71-4365-812b-d113a12596f3\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:18;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:17:\\\"adorasse@yahoo.fr\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171264,\"delay\":null}', 0, NULL, 1769171264, 1769171264),
(45, 'default', '{\"uuid\":\"26e5fae0-42d9-4d79-933d-8498c52efc66\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:18;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171264,\"delay\":null}', 0, NULL, 1769171264, 1769171264),
(46, 'default', '{\"uuid\":\"02b9d503-a814-455c-a8ed-3d3219b5921d\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:19;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:21:\\\"covialida43@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171302,\"delay\":null}', 0, NULL, 1769171302, 1769171302),
(47, 'default', '{\"uuid\":\"1e2eb002-b665-4401-b2f8-50ad0ec4ac93\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:19;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171302,\"delay\":null}', 0, NULL, 1769171302, 1769171302),
(48, 'default', '{\"uuid\":\"4161046e-69a6-4768-88d3-1e42a3ab3818\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:20;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:21:\\\"ogafabrice3@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171318,\"delay\":null}', 0, NULL, 1769171318, 1769171318),
(49, 'default', '{\"uuid\":\"3dbde984-ca3f-4169-b328-c836d9f3f5b5\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:20;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171318,\"delay\":null}', 0, NULL, 1769171318, 1769171318),
(50, 'default', '{\"uuid\":\"fff94d3f-1850-40ee-b758-b62977c4a2f4\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:21;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:23:\\\"maboudourahim@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171321,\"delay\":null}', 0, NULL, 1769171321, 1769171321),
(51, 'default', '{\"uuid\":\"393ac974-082f-413a-9918-53f5e6e48765\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:21;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171321,\"delay\":null}', 0, NULL, 1769171321, 1769171321),
(52, 'default', '{\"uuid\":\"ed10fd51-f0e7-4d3c-9cff-1be26585130d\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:22;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:18:\\\"sewat369@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171334,\"delay\":null}', 0, NULL, 1769171334, 1769171334),
(53, 'default', '{\"uuid\":\"1311052d-97ec-4c90-af30-e74e200ee7c5\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:22;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171334,\"delay\":null}', 0, NULL, 1769171334, 1769171334),
(54, 'default', '{\"uuid\":\"0c95e1de-f133-44c5-bdb0-74cc5e5f812f\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:23;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:23:\\\"abounassirou5@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171366,\"delay\":null}', 0, NULL, 1769171366, 1769171366),
(55, 'default', '{\"uuid\":\"b39cc2cf-9662-4986-bfb6-4efc4c5a815c\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:23;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171366,\"delay\":null}', 0, NULL, 1769171366, 1769171366),
(56, 'default', '{\"uuid\":\"03c17ccf-ba3d-49e0-9b2a-a8914b04c4e5\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:24;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"ornellaadjanohoun@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171423,\"delay\":null}', 0, NULL, 1769171423, 1769171423),
(57, 'default', '{\"uuid\":\"d9943049-999f-4304-befa-84ce2e3ad853\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:24;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171423,\"delay\":null}', 0, NULL, 1769171423, 1769171423),
(58, 'default', '{\"uuid\":\"2f7d9e1e-350e-4e50-aef9-da544f4f1593\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:25;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:21:\\\"arysassouan@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171461,\"delay\":null}', 0, NULL, 1769171461, 1769171461),
(59, 'default', '{\"uuid\":\"a976ae4d-061b-4223-b894-cfc203cb49b7\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:25;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171461,\"delay\":null}', 0, NULL, 1769171461, 1769171461),
(60, 'default', '{\"uuid\":\"a6807756-7055-4c6c-9faf-813fd7695e83\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:26;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:24:\\\"anicettesemevo@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171543,\"delay\":null}', 0, NULL, 1769171543, 1769171543),
(61, 'default', '{\"uuid\":\"4aedf487-39e2-4b3a-b8c9-cc944df9f304\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:26;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171543,\"delay\":null}', 0, NULL, 1769171543, 1769171543),
(62, 'default', '{\"uuid\":\"8d00742b-7585-4752-bab7-5c4a76a3a046\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:27;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:21:\\\"acrabole2008@yahoo.fr\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171707,\"delay\":null}', 0, NULL, 1769171707, 1769171707),
(63, 'default', '{\"uuid\":\"5352c06a-27fc-4013-af6a-039e24578e96\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:27;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171707,\"delay\":null}', 0, NULL, 1769171707, 1769171707),
(64, 'default', '{\"uuid\":\"b2e63eee-a24a-46a4-95a7-4e5c18bdb3f5\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:28;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:23:\\\"soniadeguenon@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171717,\"delay\":null}', 0, NULL, 1769171717, 1769171717),
(65, 'default', '{\"uuid\":\"1452e0ec-6061-4b96-9d6f-c686c12121cc\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:28;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171717,\"delay\":null}', 0, NULL, 1769171717, 1769171717),
(66, 'default', '{\"uuid\":\"0bdbdd9c-32c9-4c1f-92e4-62d067e4ddc7\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:23:\\\"innocentagbeko@yahoo.fr\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171898,\"delay\":null}', 0, NULL, 1769171898, 1769171898),
(67, 'default', '{\"uuid\":\"62fea3dc-b4b8-4a83-bd01-7df40f9238b2\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171898,\"delay\":null}', 0, NULL, 1769171898, 1769171898),
(68, 'default', '{\"uuid\":\"7ac01161-6259-47be-aea9-5e6662d035ed\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:30;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:30:\\\"affidjiabdelmouhazou@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171905,\"delay\":null}', 0, NULL, 1769171905, 1769171905),
(69, 'default', '{\"uuid\":\"1a35a81b-0b66-4a99-a528-2fb9aaa1b845\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:30;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769171905,\"delay\":null}', 0, NULL, 1769171905, 1769171905),
(70, 'default', '{\"uuid\":\"119803d9-eb15-4a98-93f0-f3c0fac8af3b\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewContact\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:25:\\\"App\\\\Mail\\\\Admin\\\\NewContact\\\":3:{s:7:\\\"contact\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Contact\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769423896,\"delay\":null}', 0, NULL, 1769423896, 1769423896);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(71, 'default', '{\"uuid\":\"27b18894-9730-42a5-bda8-3f0d81858495\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:31;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:24:\\\"stanedossou977@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769425029,\"delay\":null}', 0, NULL, 1769425029, 1769425029),
(72, 'default', '{\"uuid\":\"2429f653-ecb7-41ee-b9f1-4ed18aa13cdc\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:31;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769425029,\"delay\":null}', 0, NULL, 1769425029, 1769425029),
(73, 'default', '{\"uuid\":\"57f3658d-970d-4728-bc5c-6c2f93f21189\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:32;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:25:\\\"prestigezondoga@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769553929,\"delay\":null}', 0, NULL, 1769553929, 1769553929),
(74, 'default', '{\"uuid\":\"3a63deb8-c216-4a7e-9bca-f0454383c519\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:32;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769553929,\"delay\":null}', 0, NULL, 1769553929, 1769553929),
(75, 'default', '{\"uuid\":\"2b41605c-1dda-4663-ac20-d8545626394b\",\"displayName\":\"App\\\\Mail\\\\User\\\\PaymentConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:33:\\\"App\\\\Mail\\\\User\\\\PaymentConfirmation\\\":3:{s:11:\\\"inscription\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:31:\\\"App\\\\Models\\\\FormationInscription\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:25:\\\"prestigezondoga@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769553952,\"delay\":null}', 0, NULL, 1769553952, 1769553952),
(76, 'default', '{\"uuid\":\"410ac6a2-0f55-435e-a27f-adb8569f1a52\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewPayment\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:25:\\\"App\\\\Mail\\\\Admin\\\\NewPayment\\\":3:{s:11:\\\"inscription\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:31:\\\"App\\\\Models\\\\FormationInscription\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769553952,\"delay\":null}', 0, NULL, 1769553952, 1769553952),
(77, 'default', '{\"uuid\":\"7b509648-07db-44af-880f-3cd866546d12\",\"displayName\":\"App\\\\Mail\\\\User\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:31:\\\"App\\\\Mail\\\\User\\\\OrderConfirmation\\\":3:{s:8:\\\"commande\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\Commande\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:25:\\\"prestigezondoga@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769557814,\"delay\":null}', 0, NULL, 1769557814, 1769557814),
(78, 'default', '{\"uuid\":\"df159518-48a4-4afa-a5da-345079e2c7b0\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewOrder\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:23:\\\"App\\\\Mail\\\\Admin\\\\NewOrder\\\":3:{s:8:\\\"commande\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\Commande\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769557814,\"delay\":null}', 0, NULL, 1769557814, 1769557814),
(79, 'default', '{\"uuid\":\"6fc32a35-eddb-4e74-955a-2003406a3261\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:33;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:17:\\\"ayemeneh@yahoo.fr\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770281644,\"delay\":null}', 0, NULL, 1770281644, 1770281644),
(80, 'default', '{\"uuid\":\"0bfbc792-38c5-442f-a297-fea2bf26f31a\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:33;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770281644,\"delay\":null}', 0, NULL, 1770281644, 1770281644),
(81, 'default', '{\"uuid\":\"349c2ef1-d8be-4076-9bd2-23faf97b4420\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:34;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:24:\\\"agbemelekodjo1@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770468704,\"delay\":null}', 0, NULL, 1770468704, 1770468704),
(82, 'default', '{\"uuid\":\"d1b5a8f2-22fd-43ee-9487-859755bd5d21\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:34;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770468704,\"delay\":null}', 0, NULL, 1770468704, 1770468704),
(83, 'default', '{\"uuid\":\"14018469-a3b3-4a2a-a28e-5464f372ffe7\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:35;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:22:\\\"evelynefkoffi@yahoo.fr\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770562550,\"delay\":null}', 0, NULL, 1770562550, 1770562550),
(84, 'default', '{\"uuid\":\"8750586f-ad7c-4b0f-a035-8669d20267c7\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:35;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770562550,\"delay\":null}', 0, NULL, 1770562550, 1770562550);

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_24_000000_create_catalogues_table', 1),
(5, '2025_09_24_000003_create_cart_items_table', 1),
(6, '2025_09_24_000004_create_emprunts_table', 1),
(7, '2025_11_26_000000_add_avatar_to_users_table', 1),
(8, '2025_12_19_155151_modify_catalogues_table_nullable_fields', 1),
(9, '2025_12_19_182008_add_validation_fields_to_emprunts_table', 1),
(10, '2025_12_19_233855_add_access_expires_at_to_emprunts_table', 1),
(11, '2025_12_20_141810_create_formations_table', 1),
(12, '2025_12_20_141811_create_modules_table', 1),
(13, '2025_12_20_141813_create_module_contenus_table', 1),
(14, '2025_12_20_141814_create_formation_inscriptions_table', 1),
(15, '2025_12_20_141815_create_evaluations_table', 1),
(16, '2025_12_20_141816_create_certificats_table', 1),
(17, '2025_12_20_191233_create_commandes_table', 1),
(18, '2025_12_20_191238_create_commande_items_table', 1),
(19, '2025_12_21_003715_create_quizzes_table', 1),
(20, '2025_12_21_003716_create_quiz_questions_table', 1),
(21, '2025_12_21_003717_create_question_options_table', 1),
(22, '2025_12_21_003718_create_user_quiz_attempts_table', 1),
(23, '2025_12_27_105834_modify_user_quiz_attempts_nullable_fields', 2),
(24, '2025_12_27_122858_create_user_module_progression_table', 3),
(25, '2025_12_27_124402_add_video_watch_percentage_to_user_module_progression', 4),
(26, '2025_12_27_124433_add_transcription_to_module_contenus', 4),
(27, '2025_12_27_220201_create_contacts_table', 5),
(28, '2025_12_28_112910_create_articles_table', 6),
(29, '2025_12_28_115632_create_testimonials_table', 7),
(30, '2025_12_28_202838_add_nom_manuel_to_certificats_table', 8),
(31, '2025_12_28_202958_make_user_id_nullable_in_certificats_table', 9),
(32, '2025_12_28_213933_add_email_manuel_to_certificats_table', 10),
(33, '2025_12_28_214620_update_statut_enum_in_certificats_table', 11),
(34, '2025_12_30_150127_create_equipes_table', 12),
(35, '2026_01_07_234421_add_payment_fields_to_commandes_table', 13),
(36, '2026_01_08_092524_remove_unused_columns_from_equipes_table', 14),
(37, '2026_01_19_120000_make_formations_fields_nullable', 15),
(38, '2026_01_19_013535_make_modules_columns_nullable', 16),
(39, '2026_01_19_013817_make_users_columns_nullable', 16),
(40, '2026_01_19_014055_make_articles_columns_nullable', 16),
(41, '2026_01_19_014443_make_quizzes_columns_nullable', 16),
(42, '2026_01_19_014810_make_module_contenus_columns_nullable', 16),
(43, '2026_01_19_130000_make_catalogues_required_fields_nullable', 17);

-- --------------------------------------------------------

--
-- Structure de la table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `formation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ordre` int(11) DEFAULT NULL,
  `duree` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `modules`
--

INSERT INTO `modules` (`id`, `formation_id`, `titre`, `description`, `ordre`, `duree`, `active`, `created_at`, `updated_at`) VALUES
(2, 2, 'marketing traditionnel', 'Le marketing traditionnel désigne l\'ensemble des techniques de promotion utilisées avant l\'ère numérique : Publicité dans les journaux et magazines Spots radio et télévision Affiches publicitaires Flyers et prospectus Participation aux salons du livre\r\nBouche-à-oreille. \r\n\r\nCaractéristiques principales du marketing traditionnel : \r\n\r\nCommunication unidirectionnelle (de l\'entreprise vers le client)\r\nCoûts élevés et fixes \r\nDifficile à mesurer précisément\r\nPortée géographiquement limitée\r\nDélais de mise en œuvre longs', 1, '10 minutes', 1, '2026-01-17 18:17:09', '2026-01-17 18:17:09'),
(3, 2, 'Le Marketing Digital / Marketing Numérique) : outils et supports', 'Le marketing digital englobe toutes les techniques marketing utilisant les supports et canaux numériques :\r\n\r\nLe Marketing Digital (ou Marketing Numérique) :\r\n\r\nRéseaux sociaux (Facebook, Instagram, LinkedIn, TikTok)\r\n\r\nSite web et e-commerce\r\n\r\nEmail marketing (newsletters)\r\n\r\nPublicité en ligne (Google Ads, Facebook Ads)\r\n\r\nRéférencement (SEO)\r\n\r\nMarketing de contenu (blogs, vidéos)\r\n\r\nApplications mobiles', 1, '10', 1, '2026-01-17 18:24:20', '2026-01-17 18:24:20'),
(4, 2, 'Le Marketing Digital / Marketing Numérique) : Caractéristiques principales', 'les caractéristiques principales du Marketing Digital sont : \r\n\r\nCommunication bidirectionnelle (dialogue avec les clients)\r\n\r\nCoûts variables et contrôlables\r\n\r\nRésultats mesurables en temps réel\r\n\r\nPortée mondiale potentielle\r\n\r\nMise en œuvre rapide', 1, '10', 1, '2026-01-17 18:26:03', '2026-01-17 18:26:03'),
(5, 2, 'Les avantages spécifiques du marketing digital pour le secteur du livre', 'VISIBILITÉ ACCRUE :\r\nUn éditeur à Cotonou peut vendre à Abidjan, Dakar, Paris \r\nPrésence 24h/24, 7j/7 - Pas de limitation géographique\r\n\r\nCOÛT MAÎTRISÉ :\r\nBudget flexible : vous pouvez commencer avec 0 FCFA\r\nPay-per-click : vous payez uniquement quand quelqu\'un clic\r\nROI (retour sur investissement) mesurable\r\n\r\nCIBLAGE PRÉCIS :\r\nÂge, sexe, localisation géographique\r\nCentres d\'intérêt (lecture, littérature africaine, romans policiers)\r\nComportements (acheteurs en ligne, lecteurs assidus)\r\n\r\nINTERACTION DIRECTE :\r\nRépondre aux questions en temps réel\r\nCréer une communauté de lecteurs fidèles\r\nRecevoir des avis et témoignages\r\nOrganiser des événements en ligne (lives, webinaires)\r\n\r\nMESURE DES PERFORMANCES :\r\nNombre de personnes atteintes\r\nTaux d\'engagement (likes, commentaires, partages)\r\nConversions en ventes\r\nCoût par acquisition client\r\n\r\nPROMOTION DES AUTEURS :\r\nVidéos d\'interviews\r\nLectures en direct\r\nSéances de dédicaces virtuelles\r\nMise en avant des coulisses de l\'écriture', 1, '10', 1, '2026-01-17 18:30:18', '2026-01-17 18:30:18'),
(6, 2, 'Cas pratiques de réussite en Afrique', 'CAS 1 : ÉDITIONS ÉBURNIE - ABIDJAN, CÔTE D\'IVOIRE\r\nSituation initiale : Maison d\'édition méconnue, ventes limitées aux librairies partenaires\r\nAction digital : Blog littéraire +\r\ncampagnes Facebook Ads ciblées + newsletter mensuelle\r\nRésultat : 5000 abonnés newsletter, ventes directes en ligne = 40% du CA\r\n\r\n\r\nCAS 2 : AUTEUR INDÉPENDANT - MARIE KOUASSI, LOMÉ, TOGO\r\nSituation initiale : Roman auto-édité, pas de distributeur\r\nAction digital : Campagne Facebook Ads (budget 30 000 FCFA) + groupe Facebook de lecteurs\r\nRésultat : 800 exemplaires vendus en 3 mois, invitation dans des émissions radio', 1, '10', 1, '2026-01-17 18:33:00', '2026-01-17 18:33:00'),
(7, 2, 'Les 5 piliers du marketing digital', 'Dans un premier temps, nous avons LES RÉSEAUX SOCIAUX (Social Media Marketing) :\r\nUtilisation des plateformes sociales pour promouvoir vos livres, créer une communauté et interagir avec vos clients à travers plusieurs plateformes.  \r\n\r\nPrincipales plateformes : \r\n\r\nFacebook : Réseau généraliste, idéal pour créer une communauté de lecteurs.\r\nInstagram : Réseau visuel, parfait pour les couvertures de livres attractives.\r\nLinkedIn : Réseau professionnel, pour les partenariats B2B.\r\nTikTok : Réseau des jeunes, tendance BookTok très puissante.\r\nWhatsApp Business : Messagerie professionnelle pour le service client.\r\n\r\nAprès les reseaux sociaux, nous avons L\'EMAIL MARKETING : \r\nEnvoi d\'emails ciblés à une liste de contacts qui ont donné leur accord (newsletter).\r\n\r\nTypes d\'emails : Newsletter mensuelle avec nouveautés,  Emails promotionnels (réductions, offres, spéciales), Emails de bienvenue pour nouveaux abonnés, Emails d\'anniversaire avec cadeau, Rappel de panier abandonné (e-commerce).\r\n\r\nLES SITES WEB ET E-COMMERCE constituent également des supports du marketing digital.\r\nVotre propriété digitale, vitrine professionnelle ouverte 24h/24.\r\n\r\nOn distingue plusieurs types de sites : \r\n\r\nSite vitrine : Présentation de votre structure, catalogue, contact.\r\nSite e-commerce : Boutique en ligne pour vendre directement.\r\nSite institutionnel : Pour les grandes maisons d\'édition\r\n\r\nCes sites coûtent, à titre indicatif : \r\n\r\nSite vitrine simple : 100 000 - 300 000 FCFA\r\nSite e-commerce : 500 000 - 2 000 000 FCFA\r\nMaintenance : 20 000 - 50 000 FCFA/mois\r\n\r\nLES BLOGS ET MARKETING DE CONTENU :\r\nC’est la création régulière de contenus de valeur pour attirer et fidéliser des lecteurs. \r\n\r\nTypes de contenus pour le secteur du livre :\r\n\r\nCritiques et recommandations de\r\nlivres.\r\nInterviews d\'auteurs\r\nTop 10 des livres sur un thème\r\nCoulisses de l\'édition\r\nConseils de lecture selon les prof ils\r\nActualités littéraires...\r\n\r\nPour finir, nous avons LA PUBLICITÉ EN LIGNE (SEM - Search Engine Marketing) :\r\n\r\nPublicité payante sur les plateformes digitales pour booster votre visibilité rapidement et attirer plus de personnes. Les \r\nPrincipales plateformes publicitaires utilisées sont : \r\nFacebook Ads / Instagram Ads : Publicité sur les réseaux Meta.\r\nGoogle Ads : Publicité sur le moteur de recherche Google.\r\nYouTube Ads : Publicité vidéo.\r\nLinkedIn Ads : Publicité B2B', 1, '20', 1, '2026-01-17 18:57:52', '2026-01-17 18:57:52'),
(8, 3, 'Quel réseau pour quel objectif ?', 'FACEBOOK\r\nAudience : 25-65 ans, tous profils.\r\nMeilleur pour créer une communauté, organiser des événements, service client, ventes directes.\r\nFormat : Publications avec photos, vidéos, événements. \r\nFréquence idéale : 3-5 fois / semaine\r\n\r\nLINKEDIN\r\nAudience : Professionnels, décideurs, institutions...\r\nMeilleur pour : Partenariats B2B, vente aux bibliothèques / écoles, image d\'expert.\r\nFormat star : Articles longs, partages professionnels\r\nFréquence idéale : 2-3 fois/semaine\r\n\r\nTIKTOK\r\nAudience : 16-25 ans, génération Z.\r\nMeilleur pour : BookTok, challenges, contenus décalés, toucher les jeunes.\r\nFormat star : Vidéos courtes 15 - 60 secondes\r\nFréquence idéale : 1-3 fois / jour\r\n\r\nAudience : Tous\r\nâges,\r\nparticulièrement\r\nen Af rique\r\nMeilleur pour :\r\nService client,\r\ncommandes,\r\nconf irmations,\r\ncatalogue produits\r\nFormat star :\r\nMessages directs,\r\ncatalogues\r\nFréquence : Selon\r\ndemandes clients\r\n\r\nWHATSAPP BUSINESS\r\nAudience : Tous âges, particulièrement en Afrique\r\nMeilleur pour : Service client, commandes, confirmations, catalogue produits\r\nFormat star : Messages directs, catalogues\r\nFréquence : Selon demandes clients', 1, '10', 1, '2026-01-17 19:21:05', '2026-01-17 19:21:05'),
(9, 3, 'Facebook pour les professionnels du livre', 'POURQUOI FACEBOOK EST INCONTOURNABLE EN AFRIQUE\r\nCHIFFRES CLÉS :\r\n2,9 milliards d\'utilisateurs dans le monde\r\n40% de pénétration en Afrique subsaharienne\r\nRéseau n°1 en Afrique francophone\r\n2h24 de temps passé quotidiennement en\r\nmoyenne.\r\n\r\nAVANTAGES SPÉCIFIQUES POUR LE LIVRE :\r\nCréation de groupes de lecteurs\r\nOrganisation d\'événements (dédicaces,\r\nlancements)\r\nFacebook Shop pour vendre directement\r\nPublicité très ciblée et abordable\r\nInteraction immédiate avec les lecteurs\r\n\r\nLES DIFFÉRENTS TYPES DE PRÉSENCE SUR FACEBOOK :\r\n\r\nLE PROFIL PERSONNEL (NON RECOMMANDÉ POUR ENTREPRISE)\r\nLimité à 5000 amis\r\nPas d\'outils professionnels\r\nRisque de mélanger pro et perso\r\n\r\nLA PAGE PROFESSIONNELLE (RECOMMANDÉ)\r\nNombre illimité de followers\r\nStatistiques détaillées\r\nPossibilité de faire de la publicité\r\nBoutons d\'action (Appeler, Envoyer un\r\nmessage, Réserver)\r\nCrédibilité professionnelle\r\n\r\nLE GROUPE FACEBOOK (COMPLÉMENTAIRE)\r\nCréation de communauté engagée\r\nDiscussions entre membres\r\nParfait pour \"Club de lecture\" ou \"Amis de notre librairie\r\n\r\nCréer une page Facebook efficace :\r\nÉléments indispensables :\r\nPHOTO DE PROFIL :\r\nLogo de votre maison d\'édition / librairie\r\nFormat : carré, 180x180 pixels minimum\r\nPHOTO DE COUVERTURE :\r\nDimension : 820x312 pixels\r\nChanger régulièrement (nouveautés, événements)\r\nÉviter texte trop petit (illisible sur mobile)\r\nÀ PROPOS :\r\nDescription claire en 1-2 paragraphes\r\nInclure mots-clés (librairie, édition, livres\r\nafricains)\r\nMentionner votre spécialité\r\n\r\nINFORMATIONS DE CONTACT :\r\nAdresse physique complète\r\nNuméro de téléphone\r\nWhatsApp Business\r\nSite web - Email -\r\nHoraires d\'ouverture\r\n\r\nBOUTON D\'ACTION\r\nEnvoyer un message\" (WhatsApp)\r\n\"Appeler maintenant\" - \"Réserver\"\r\n(pour événements)\r\n\"Acheter\" (si boutique en ligne)\r\n\r\nStratégie de contenu Facebook.\r\nLA RÈGLE 80-20;\r\n80% DE CONTENUS DE VALEUR (GRATUITS, NON PROMOTIONNELS) : extraits de livres inspirants, citations d\'auteurs, conseils de lecture, culture générale littéraire, quiz et sondages, témoignages de lecteurs\r\n20% DE CONTENU PROMOTIONNEL : Annonce de nouveautés, promotions et réductions, événements commerciaux, appels à l\'achat directs', 1, '15', 1, '2026-01-17 19:31:57', '2026-01-17 19:31:57'),
(10, 3, 'LINKEDIN POUR LES PROFESSIONNELS DU LIVRE', 'Pourquoi LinkedIn est différent de Facebook\r\n\r\nLinkedIn n\'est PAS Facebook !\r\n\r\nDifférences fondamentales :\r\nFACEBOOK : Social, personnel ; Décontracté, émotionnel ; Divertissement,\r\nlifestyle ; B2C (grand public); Court, visuel\r\nLINKEDIN : Professionnel, expert, business ; Expertise, analyse, réflexion ;\r\nB2B (professionnels) ; Long, approfondi\r\nERREUR COURANTE : Publier exactement le même contenu sur Facebook et LinkedIn. ❌\r\n\r\nÀ quoi sert LinkedIn pour votre activité ?\r\n\r\nDÉVELOPPER DES PARTENARIATS B2B\r\nVendre aux bibliothèques municipales\r\nPartenariats avec les écoles et universités\r\nCollaborations avec d\'autres éditeurs\r\nContacts avec des distributeurs internationaux\r\nRelations avec médias et journalistes\r\n\r\nRECRUTER DES TALENTS\r\nÉditeurs, Commerciaux, Graphistes\r\nTraducteurs, Correcteurs\r\n\r\nÉTABLIR VOTRE CRÉDIBILITÉ D\'EXPERT\r\nPublier des analyses sur le marché du livre en Afrique, Partager vos réflexions sur l\'édition, Démontrer votre expertise du secteur\r\nAttirer l\'attention de décideurs,\r\n\r\nVEILLE SECTORIELLE\r\nSuivre les tendances de l\'édition mondiale\r\nS\'inspirer des best practices\r\nRester informé des innovations\r\n\r\nOptimiser son profil LinkedIn\r\nPHOTO DE PROFIL\r\nPhoto professionnelle : Fond neutre - Sourire - Vêtements\r\nprofessionnels - Visage bien visible\r\nPhoto de bannière : 1584 x 396 pixels - Représenter votre activité - Livres, librairie, auteurs - Peut inclure slogan ou\r\naccroche,\r\nTitre professionnel (sous votre nom) : Maximum 120 caractères - Inclure mots-clés - Être explicite\r\nMauvais exemple : \"Directeur chez ABC Éditions\"\r\nBon exemple : \"Directeur éditorial | Spécialiste littérature africaine francophone | 15 ans d\'expérience édition jeunesse\"\r\nRésumé (section À propos) : 2-3 paragraphes maximum - Parler de votre passion pour le livre - Mentionner votre expertise - Inclure réalisations concrètes - Terminer par un appel à l\'action\r\n\r\nExemple de résumé efficace : Passionné par la promotion de la littérature africaine depuis plus de 10 ans, je dirige XYZ Éditions, maison spécialisée dans la publication d\'auteurs émergents d\'Afrique francophone. Nous avons publié plus de 50 titres qui touchent des lecteurs dans 15 pays.\r\n\r\nNotre mission : faire rayonner les voix africaines à l\'international tout en rendant la lecture accessible localement. Toujours à la recherche de partenariats avec bibliothèques, institutions éducatives et distributeurs pour élargir notre impact.\r\nContactez-moi pour discuter collaborations : email@example.com\r\n\r\nExpérience professionnelle : Détailler vos fonctions actuelles et passées - Utiliser des\r\nbullet points - Quantifier vos réalisations (chiffres) -\r\nInclure mots-clés du secteur\r\n\r\nCompétences : Ajouter 10-15 compétences pertinentes\r\nEx: Édition, Distribution, Marketing du livre, Négociation droits d\'auteur\r\n- Demander des recommandations à vos contacts', 1, '10', 1, '2026-01-17 19:42:36', '2026-01-17 19:46:42'),
(17, 7, 'Les bases du droit d’auteur en littérature', '1- (Définition et principes fondamentaux)\r\n« Le droit d’auteur, c’est tout simplement l’ensemble des règles qui protègent les œuvres de l’esprit.Dès qu’une personne écrit un texte original – un roman, un manuel scolaire, un poème, un essai – cette œuvre est automatiquement protégée par le droit d’auteur.\r\n- Il n’y a pas besoin de dépôt préalable pour que la protection existe.\r\n- Dans l’espace OAPI, cette protection est organisée par l’Annexe VII de l’Accord de Bangui.\r\n- Le principe fondamental, c’est que l’auteur doit garder le contrôle sur l’utilisation de son œuvre et pouvoir en tirer une rémunération\r\n\r\n2-Œuvres protégées dans le domaine littéraire\r\n\r\n« Dans le domaine littéraire, sont protégés tous les textes dès lors qu’ils sont originaux.Cela inclut les romans, les nouvelles, la poésie, les pièces de théâtre, les essais, les manuels scolaires, les livres scientifiques ou pédagogiques.\r\n- Un point très important : la protection ne dépend pas du support.\r\n- Un texte est protégé qu’il soit imprimé sur papier, diffusé en PDF, publié en ligne ou partagé sous forme numérique.\r\n- Le passage au numérique ne fait pas perdre les droits de l’auteur. »\r\n\r\n3- Titulaire des droits : qui possède les droits ?\r\n\r\n« Le titulaire des droits, c’est en principe l’auteur, c’est-à-dire la personne physique qui a créé l’œuvre.\r\n- Même lorsqu’un éditeur publie le livre, l’auteur reste titulaire de ses droits, sauf pour ceux qu’il a expressément cédés par contrat.\r\n- L’éditeur n’est donc pas automatiquement propriétaire de l’œuvre : il exploite les droits que l’auteur lui a accordés.\r\n- Après le décès de l’auteur, les droits sont transmis aux ayants droit, souvent les héritiers.\r\n- C’est pourquoi il est important de bien comprendre à qui appartiennent les droits à chaque étape de la chaîne du livre. »\r\n\r\nLes droits de l’auteur : une double protection\r\n\r\n« Le droit d’auteur repose sur deux grandes catégories de droits : les droits moraux et les droits patrimoniaux.Ces deux types de droits sont complémentaires. »\r\n\r\n4- Les droits moraux\r\n(Paternité, respect de l’œuvre)\r\n\r\n« Les droits moraux protègent le lien personnel entre l’auteur et son œuvre.\r\n- Le premier, c’est le droit à la paternité : le nom de l’auteur doit toujours être mentionné.\r\n- Le second, c’est le droit au respect de l’œuvre : on ne peut pas modifier un texte, le tronquer ou le dénaturer sans l’accord de l’auteur.\r\n- Ces droits sont très forts : ils sont inaliénables, ce qui signifie que l’auteur ne peut pas les vendre, et ils sont perpétuels, même après sa mort. »\r\n\r\n5- Les droits patrimoniaux\r\n(Reproduction, diffusion, adaptation)\r\n« Les droits patrimoniaux sont les droits économiques de l’auteur.\r\n- Ils concernent toutes les formes d’exploitation de l’œuvre : la reproduction, par exemple l’impression ou la numérisation ; la diffusion, comme la vente, le prêt ou la mise en ligne ; et l’adaptation, par exemple une traduction ou une transformation en autre format.\r\n- Ce sont ces droits qui permettent à l’auteur et à l’éditeur de générer des revenus.\r\n- Toute utilisation de l’œuvre sans autorisation sur ces aspects constitue une atteinte au droit d’auteur. »\r\n\r\n6- La durée de protection\r\n« La protection par le droit d’auteur n’est pas éternelle, mais elle est longue.\r\n- En règle générale, l’œuvre est protégée pendant toute la vie de l’auteur, puis pendant plusieurs années après son décès. 50-70 ans en général,\r\n- Pendant cette période, toute exploitation doit être autorisée par l’auteur ou ses ayants droit.\r\n- Une fois ce délai écoulé, l’œuvre entre dans le domaine public et peut être utilisée librement, ce qui ouvre de nouvelles opportunités pour les éditeurs et les acteurs du livre. »', 1, '30 minutes', 1, '2026-02-07 11:25:50', '2026-02-07 11:41:13');

-- --------------------------------------------------------

--
-- Structure de la table `module_contenus`
--

CREATE TABLE `module_contenus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `fichier` varchar(255) DEFAULT NULL,
  `contenu` text DEFAULT NULL,
  `transcription` text DEFAULT NULL,
  `duree` varchar(255) DEFAULT NULL,
  `ordre` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `question_options`
--

CREATE TABLE `question_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `option_text` text NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `ordre` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `question_options`
--

INSERT INTO `question_options` (`id`, `question_id`, `option_text`, `is_correct`, `ordre`, `created_at`, `updated_at`) VALUES
(4, 7, 'Une protection juridique automatique pour toute œuvre originale de l’esprit dès sa mise en forme concrète sans formalité préalable', 1, 1, '2026-02-07 12:24:14', '2026-02-07 12:24:14'),
(5, 7, 'Une protection juridique conditionnelle uniquement pour les œuvres déclarées après enregistrement officiel auprès d’une autorité compétente avec formalités administratives obligatoires', 0, 2, '2026-02-07 12:24:14', '2026-02-07 12:24:14');

-- --------------------------------------------------------

--
-- Structure de la table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED DEFAULT NULL,
  `formation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `duree_minutes` int(11) DEFAULT NULL COMMENT 'Durée en minutes pour compléter le quiz',
  `note_passage` int(11) DEFAULT NULL,
  `nombre_tentatives` int(11) DEFAULT NULL,
  `afficher_reponses` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Afficher les bonnes réponses après la soumission',
  `melanger_questions` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Mélanger l''ordre des questions',
  `melanger_options` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Mélanger l''ordre des options',
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `quizzes`
--

INSERT INTO `quizzes` (`id`, `module_id`, `formation_id`, `titre`, `description`, `duree_minutes`, `note_passage`, `nombre_tentatives`, `afficher_reponses`, `melanger_questions`, `melanger_options`, `active`, `created_at`, `updated_at`) VALUES
(2, 2, 2, 'Les différents types de marketing', 'Marketing appliqué à la chaine du livre', 2, 100, 3, 1, 0, 0, 1, '2026-01-17 19:54:34', '2026-01-17 19:55:20'),
(3, 3, 2, 'Le marketing digital', 'Le marketing digital englobe toutes les techniques marketing utilisant les supports et canaux numériques', 2, 100, 3, 1, 0, 0, 1, '2026-01-17 20:05:01', '2026-01-17 20:05:01'),
(4, 4, 2, 'Le Marketing Digital / Marketing Numérique)', 'Les caractéristiques principales du marketing', 5, 100, 3, 1, 0, 0, 1, '2026-01-17 20:12:32', '2026-01-17 20:12:32'),
(5, 4, 2, 'Le Marketing Digital / Marketing Numérique', 'Les Caractéristiques principales du marketing numérique', 5, 100, 3, 1, 0, 0, 1, '2026-01-17 20:15:29', '2026-01-17 20:15:29'),
(7, 17, 7, 'QU’EST-CE QUE LE DROIT D’AUTEUR ?', 'Le droit d’auteur est :', 1, 100, 3, 1, 0, 0, 1, '2026-02-07 11:58:04', '2026-02-07 11:58:04'),
(8, 17, 7, 'QU’EST-CE QUE LE DROIT D’AUTEUR ?', 'Le droit d’auteur, ce n’est pas une démarche administrative compliquée.\r\n- Il naît automatiquement dès qu’une œuvre est créée et mise en forme.\r\n- Une idée seule ne suffit pas : il faut qu’elle soit écrite, structurée, matérialisée.\r\n- Dès ce moment, l’auteur devient titulaire d’un droit de propriété… mais un droit immatériel.\r\n- C’est exactement ce que reconnaît l’Annexe VII de l’Accord de Bangui : une œuvre de l’esprit, dès qu’elle est originale, mérite protection.', 1, 100, 3, 1, 0, 0, 1, '2026-02-07 12:01:26', '2026-02-07 12:01:26'),
(9, 17, 7, 'QU’EST-CE QUE LE DROIT D’AUTEUR ?', 'Le droit d’auteur, ce n’est pas une démarche administrative compliquée.\r\n- Il naît automatiquement dès qu’une œuvre est créée et mise en forme.\r\n- Une idée seule ne suffit pas : il faut qu’elle soit écrite, structurée, matérialisée.\r\n- Dès ce moment, l’auteur devient titulaire d’un droit de propriété… mais un droit immatériel.\r\n- C’est exactement ce que reconnaît l’Annexe VII de l’Accord de Bangui : une œuvre de l’esprit, dès qu’elle est originale, mérite protection.', 1, 100, 3, 1, 0, 0, 1, '2026-02-07 12:08:01', '2026-02-07 12:08:01');

-- --------------------------------------------------------

--
-- Structure de la table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quiz_id` bigint(20) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `type` enum('qcm','vrai_faux','choix_multiple') NOT NULL DEFAULT 'qcm' COMMENT 'qcm=une seule réponse, choix_multiple=plusieurs réponses',
  `points` int(11) NOT NULL DEFAULT 1 COMMENT 'Points attribués pour cette question',
  `ordre` int(11) NOT NULL DEFAULT 0,
  `explication` text DEFAULT NULL COMMENT 'Explication affichée après la réponse',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `quiz_questions`
--

INSERT INTO `quiz_questions` (`id`, `quiz_id`, `question`, `type`, `points`, `ordre`, `explication`, `created_at`, `updated_at`) VALUES
(2, 2, 'Le marketing traditionnel : désigne l\'ensemble des techniques de promotion à l\'ère du numérique', 'choix_multiple', 2, 1, NULL, '2026-01-17 19:58:38', '2026-01-17 19:58:38'),
(3, 2, 'Le marketing traditionnel :', 'choix_multiple', 4, 2, NULL, '2026-01-17 20:02:04', '2026-01-17 20:02:04'),
(4, 3, 'Le téléphone portable et l\'ordinateur ne sont pas nécessaires au marketing digital', 'vrai_faux', 2, 1, NULL, '2026-01-17 20:07:34', '2026-01-17 20:07:34'),
(5, 4, 'Le marketing digital n\'est pas adapté au marché africain', 'vrai_faux', 2, 1, NULL, '2026-01-17 20:13:45', '2026-01-17 20:13:45'),
(6, 5, 'les caractéristiques principales du Marketing Digital sont :', 'choix_multiple', 5, 1, NULL, '2026-01-17 20:18:32', '2026-01-17 20:18:32'),
(7, 9, 'Le droit d\'auteur c\'est :', 'qcm', 5, 1, NULL, '2026-02-07 12:24:14', '2026-02-07 12:24:14');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0wkeuGbkqy6QTR3CuadyAMQXgT8KvO47zHVaoluM', NULL, '98.80.121.174', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_4_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.4 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoianhiWnVUSUhBbzJKR2cxU050ajlGckNzQUtlTWFWbEhPdGxISjN0WCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770583648),
('2ftZcoSA8CffdvwT6CyBj6SVbz1xwYKEEhMvaMEy', NULL, '156.0.214.2', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibWRIbUNpSFBMb2lIZFNRRXNiZHFuNFFCTmt6V2lUeGdlcTlNd2lHSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770538963),
('2WdvakjAMmvuW9y0kwf1punPqiHnhOoSvndNLw6m', NULL, '2001:4ca0:108:42::7', 'quic-go-HTTP/3', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiTVVKUHBWNlJvemFKclloVFBsTGZBS2k1ZTk5emtJbGU5WmFOUzRhUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770585153),
('3V4GhihkcRx6uIi5TXn8UH12bPprw5B3W9qlzkWB', NULL, '65.55.210.108', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/100.0.4896.127 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU3M2Q3plZDJKdmxTbjBwbHdLSkFQTEU2ckNPMVBVZEIwOEFjcnF0ViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjQ6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbS9hcGkvY2F0YWxvZ3VlL2NhdGVnb3JpZXM/dHlwZT1hbGwiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770562897),
('68rwmnW2JyEjC6teBUTdXs5CVmsa37fOqhl0oR26', NULL, '2a03:2880:27ff:76::', 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibFlLd1dtTVIzNldCQ0hNeTRPOWZPY3poZE9pR0xtOXg0NWhQeGRXeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vd3d3LmNvbGlicmktbGl0dGVyYWlyZS5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770546060),
('6RV1THRg3MZ1SJovsZpJz6oyOweMRZdamFfFdRoE', NULL, '40.77.179.208', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/100.0.4896.127 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYW82TzYxZHNGVm9pZXh3WFZ0a2dkckg5dDdHZG83Y1h6aWphV0NwYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjU6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbS9hcGkvY2F0YWxvZ3VlL3ByaWNlLXN0YXRzP3R5cGU9YWxsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770562897),
('6w7BayCgRHnvXPFTupb0rQWMnkhwQN7GC2FDPQqS', NULL, '34.174.163.33', 'Mozilla/5.0 Firefox/33.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZW9GU3V6d0RPSmpFZzBHY0I0amFzSnlDcWhXSmdFRmd6dWd6dGVqdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770540836),
('9fa5GUWsZIq98aSRyoQJEgeOfV58xJW5CgclscOq', NULL, '34.174.163.33', 'Mozilla/5.0 Firefox/33.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVGM1Sm5ReExtaHZHaWRucExSTDFrV3VmTVBzYXlqZkY2eGtaWlhZNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770540838),
('bCEyHqSMtkUI0xl70dYD7oVFgxNnVgQBgVuNwH4Y', NULL, '66.249.93.165', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUGZTNjgxV2lMZU50elRUY1J6a3M0NTMzNFFNek9tWURUNldPN2loZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vd3d3LmNvbGlicmktbGl0dGVyYWlyZS5jb20vY2F0YWxvZ3VlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770545751),
('bVANzN6SMQH0OP5BEzpIutEESKWU5YNbtU0njEu7', NULL, '20.169.78.158', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko); compatible; ChatGPT-User/1.0; +https://openai.com/bot', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid3JLODQyUTh2RHpIUE9nb3NGVFBJVVlGdzA1UFFlNGtoSVpuZzk1dSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770578569),
('csp1pkNeL8lcGHBJalw6BNF92EF44ZTcqwzb6tSu', NULL, '2a03:2880:3ff:9::', 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidEllaG9SWVR2Q21zT09oWGpqYUFBUjFFelNGZWFEckdtRElLQnJ1ZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770558473),
('cVLHHIIXNAftrFhADiwJOfuQSeL6vFGvxkTutfJS', NULL, '180.153.236.94', 'User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0; 360Spider', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMmRBajVyZHpTdnVBTEhnQ1BWSFYwMU1UQWZ2czNYUTZpOG1hdXh1MCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vd3d3LmNvbGlicmktbGl0dGVyYWlyZS5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770560396),
('d4aXY0wzA1sH8pDZEiaIV0yUk6Ugh9NneAI7ZyGS', NULL, '180.153.236.37', 'User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0; 360Spider', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQmY2YjJSWUZSNWJBcFk2OTFEd1JERGswQXB0TjJmTGFLSHRHZDBYVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770546164),
('DkQ9zN65PXqygtMqfPu1zlz3XgzgCefB36nuvi2E', NULL, '2001:41d0:801:2000::4ec4', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRlcyOTBjRUhSZ2xPR2xkR0FZcGRsY0NrWEpmZG9lbEY1RHY0OWo4USI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770571291),
('DpDVWVzGTyIlv5GUE3Ww3IvddGUkmyr19drAUhSZ', NULL, '2001:41d0:801:2000::4ec4', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.107 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieVBzZXdSZncxY01CRmRabTYwUkZ3MFlpbWVBN0QyOTJNTkJhekxWciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vd3d3LmNvbGlicmktbGl0dGVyYWlyZS5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770571291),
('fMbkiIc020QqnmodaQgtrImgm7gx7X4QNJn4Ygpu', NULL, '2001:41d0:801:2000::4ec4', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:91.0) Gecko/20100101 Firefox/91.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMDBSNTVTTGRXdTNRM2V2V2M0WXhIY0p0bk5kdDZKeU5lbXJBN3dkWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770571291),
('FpPh1jemFzVMy8fDy7VTfDqQBQQsrwF00L5gW7H9', NULL, '66.102.8.228', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZHI3QjVFSHFDUUo2Q0l3eUx5TUNxUEJmV1NsMVA0eFZqVzdwOHdCOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vd3d3LmNvbGlicmktbGl0dGVyYWlyZS5jb20vY2F0YWxvZ3VlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770545751),
('fYxf0uvmeSQK35pZQlrCyYT3ti4ejRsa98vycKsw', NULL, '52.167.144.229', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSEVTS0xnT0RzTGVoMmVZR2JpSkM0cTh4SDBrRGVzalRuT0U2MVo3VSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770561921),
('gHBvPPPJ4Fl7GdsBTM93iKlJc4cJ5yqSRIcI4RMc', NULL, '160.154.247.117', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibWhtVml5REVCZm1DejF1ek44Rmo2Y2J1aENmdzBYaXl5T29kU0FDcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Njk6Imh0dHBzOi8vd3d3LmNvbGlicmktbGl0dGVyYWlyZS5jb20vYXBpL2NhdGFsb2d1ZS9wcmljZS1zdGF0cz90eXBlPWFsbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770545758),
('jHYFyJaaAvzagUAlQBE8msjBiNUBe2y8dqVIooEo', NULL, '2a03:2880:3ff:4f::', 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidkR6c1pHVmVJTU5jVmp3TENqWFRTVmN6ZTUzOUJCVnllbWVjVTVQNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770558472),
('JPWdlGRPkB0ZSKpyX5K5Zcg9wM86sOfMO3wXLPKG', 35, '2001:42d8:3379:bd00:4dfe:a051:171d:6621', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 OPR/126.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib0d6V3NKN2UzNmN3ek1IcUFJN3pWcXJhVXZydEZMVkdmTDJwRjkzZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDk6Imh0dHBzOi8vd3d3LmNvbGlicmktbGl0dGVyYWlyZS5jb20vYWNjb3VudC9wcm9maWwiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozNTt9', 1770562550),
('kiloyiyNwbv89RH8zajpsxSDj0nwUzbgAHtCrBBW', NULL, '2a03:2880:21ff:44::', 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY2JUUGg4cXVnZ1dhNk05d214eHIwWFBxWHBWQWRsREtOcjVBMUM2TyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vd3d3LmNvbGlicmktbGl0dGVyYWlyZS5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770558140),
('KPYmdS1oruw4YK4BxbU0TinFEr7xRndMxbuS7Jmx', 1, '194.11.197.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUVpmd3dISG9tb2x5Uml5eE9hQW8zZWtpdk9wbjN2TGR5RElRYzhmeiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbS9hZG1pbi9jYXRhbG9ndWUiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1770576475),
('lDBFBSxJhlSAaJuWr9p3LADCooi9sPPF1xST2sJK', NULL, '2001:41d0:801:2000::4ec4', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiakp1SUVzY1BCaEsySG80RUtWdGVHRWtPaDR2SXpqaU1McGJxWlB5RyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vd3d3LmNvbGlicmktbGl0dGVyYWlyZS5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770571291),
('MjDt2qeJkq58MiSduNloAEZFRtaAQ5keZTHRwKYV', NULL, '66.249.93.163', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS0owTkdRNTN3UEgyNjh3NkVDcXhNbWh3VHRIa0tjaGVuR3ZhZjhXViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Njk6Imh0dHBzOi8vd3d3LmNvbGlicmktbGl0dGVyYWlyZS5jb20vYXBpL2NhdGFsb2d1ZS9wcmljZS1zdGF0cz90eXBlPWFsbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770545752),
('nxM1KaUGZ8F9zNcfcipTkKOZIeoUKCUD1586bOoS', NULL, '2a03:2880:21ff:41::', 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT2gxWWdMZjN4M1poTm9TWGd0UnFjMlJlQnpGQ0RQTk9EOE5EMmZoZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vd3d3LmNvbGlicmktbGl0dGVyYWlyZS5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770585885),
('PD4FSzkpHhe0awRHse7JXePwiO5JsiaOuhlVhpZc', NULL, '213.180.203.211', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSlYyMXo3Qm44Qk9HUXhDVlNNYnZqSzZLRUhkZWZLSXhiejFmNFpYWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770562750),
('PlXsV6IbnQhKiZhAAwSOe1WYusM0coZ9e0N2K1uo', 1, '41.79.219.207', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNGlPVldtNmQ3Z1ZFRVg1eFZnTzZMd1l0dlpDUEtTWGVPYVdxYWRldiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbS9mb3JtYXRpb24vbW9kdWxlcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1770587149),
('Q7pX0axe03aeeKT34j4PHQWpKgv6lTx6zKX271OI', NULL, '135.148.195.8', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiazVKQ2Y2T1EzbU5DRTFSYnF1WjJHb21MSFM1TExFM2ZpYXl0dVFFSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770542951),
('qyVnmhwR6zHmnhxaWxJskWNVNZrY3AU2NaDOxKyd', NULL, '57.129.137.190', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.107 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNlU2eGtEaGhkYmRweDN3V3psNVhwMnZsU2tmZnlnd1RLS2s0bkVLRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vd3d3LmNvbGlicmktbGl0dGVyYWlyZS5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770571291),
('uJOM0QEYCSzWaWGea95JBpu4a6lnHo395MTDCsFZ', NULL, '198.244.183.225', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT1ZpQjFNeExjeXZYajduNVpMeUtvbzVsMEZNWDJqWTFWcHFWQVQ5cCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbS9ibG9nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770546351),
('W0HqOezw0xhv2OmFpIWpKTqDLZ4c84UqdPbv8Ovz', NULL, '2001:4ca0:108:42::7', 'quic-go-HTTP/3', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiU0J5RDBhcUMwTThGYURxQjV6U3ZnSlc1bVlNMDZOV21aekZNS1d3QiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770577011),
('yQ6cLdzmpNIA9SmwcasVkxQ1OjUtby1o9Td4nH2V', NULL, '57.129.137.190', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.107 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNktRdUxKWkd3T0NKNVJTVGxXY1pSNGlNdDVZQnVja3F1RjFyNXhzbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770571291),
('Z7jU9lDfViOM5JF8ZXJhSq0IBITQTodWGWU9yDJy', NULL, '2a02:4780:27:c0de::3cc', 'Go-http-client/2.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiV1JGcnV0eFFrd2JxbURudUx3ZTlzaUNUUDZDOEh0NVFLUlVpS2FrWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770544503),
('ZAj08AkNX6yr9Zv96si8Mt5EFPXf6UBIAVzZuULZ', NULL, '2a03:2880:31ff:46::', 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ3BCdWNoUmUxTWtRTEJSNXR5OWs0Z0lSb1g5S3BVeFY2ODM2c3FNciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vd3d3LmNvbGlicmktbGl0dGVyYWlyZS5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770543235),
('zwYzd1jGAu7mdhFb4LO6ACMBS28O6Wnrt8aJIaIB', NULL, '2a03:2880:24ff:59::', 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicWtiRmJtbUJCOGNVU0Y2bDI0WXlRcmxoZVJKZVQzRkE4aW9OblBjciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vd3d3LmNvbGlicmktbGl0dGVyYWlyZS5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770542789);

-- --------------------------------------------------------

--
-- Structure de la table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `avatar`, `role`, `is_admin`, `email_verified_at`, `password`, `blocked`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Colibi Litteraire', 'colibri@gmail.com', NULL, NULL, NULL, 'admin', 0, NULL, '$2y$12$p0y/MrJ9xnEpWZOV2/lXy.MfbnaXV3Qv/jXTOr10F65BViAXGvrQ2', 0, 'sy6cGczZKWeXdt7EBFoEjQ1fytc54YYuWd6l0MdIoChp91kGZQnfF1MjTIdE', '2026-01-08 10:35:51', '2026-01-08 10:35:51'),
(3, 'ASSOMOU N\'DEDE ALEXANDRE', 'analex1er@gmail.com', '0707464325', NULL, NULL, 'membre', 0, NULL, '$2y$12$KXq6nuIp9boB5U1b3PLx.OFRwwZdA0HBBNT2Eq3qcSkpkZMxo3K4G', 0, NULL, '2026-01-16 11:09:47', '2026-01-16 11:09:47'),
(4, 'Gnaloko Didi Jérôme', 'gnalokodidijerome@gmail.com', '0708966892', NULL, NULL, 'membre', 0, NULL, '$2y$12$DmB28vzbYIy1uJC.fpi4CuXD6Phexj.5i8/gZ4EqYYzg5IIvcwMf.', 0, NULL, '2026-01-16 11:40:39', '2026-01-16 11:40:39'),
(5, 'Ange Emmanuel Sonh Kah', 'angesonhkah@gmail.com', '0788791482', NULL, NULL, 'membre', 0, NULL, '$2y$12$7uI2B2WCuRAHx..fFbTb9eFHN0dw7YxX3Qr0v7KvyyMzGFHNePKv.', 0, 'KH1tfUlijaq9w407Vmwbj79Dw0vIWAvPHF2iKqDsCCVNS1zJOQ7ZqYDbFORJ', '2026-01-16 12:19:00', '2026-01-16 12:19:00'),
(7, 'GUIDJIME Enock', 'guidji336@gmail.com', '0196534791', NULL, 'avatars/F9763u9gSYxNzVfTRm0LlfP6q8GEkGLZHTkGUTgS.jpg', NULL, 0, NULL, '$2y$12$PUExtYCkZ1KqvgVonaPt/O6ENKoQguIUcprmAyt2n24dttLBrMFiy', 0, NULL, '2026-01-23 12:24:04', '2026-01-23 12:26:14'),
(8, 'Dassi Gervais', 'gervaisdassi@gmail.com', '+22966471281', NULL, 'avatars/Hypup4CnaiOefsV555lsHTYaJqHt5ISkBJ4Yv1Vz.jpg', NULL, 0, NULL, '$2y$12$8fELneF1pApoDVcGxZG9tO7odg5fluMrIirehRuM.yG3w9HXdKjFS', 0, NULL, '2026-01-23 12:25:26', '2026-01-23 12:35:18'),
(9, 'Sendrine Anago', 'anagosendrine@gmail.com', '0156406714', 'Calavi', NULL, NULL, 0, NULL, '$2y$12$admXrPKga23IkEth9kz/1uI.z.jY0KLp9jZaymTFo4sJYgQNtyumu', 0, NULL, '2026-01-23 12:25:34', '2026-01-23 12:25:34'),
(10, 'PADONOU Larissa', 'larissapadonou2@gmail.com', '0160508266', 'Calavi', NULL, NULL, 0, NULL, '$2y$12$at9gd6X/Caiv4uFQLWO45.lth7T1vVmoqvJcXl3cxsrzs8KoFfGDq', 0, NULL, '2026-01-23 12:25:57', '2026-01-23 12:25:57'),
(11, 'ZODEHOUGAN  Édith olive Senan', 'edolive3@gmail.com', '0166876545', 'Ouèdo', NULL, NULL, 0, NULL, '$2y$12$at96Qq.nKtIVcFKJZeGgD.kWYC8.I.1OtOEepZFpb.UXPFIvzJdja', 0, NULL, '2026-01-23 12:26:03', '2026-01-23 12:26:03'),
(12, 'MONTCHO Alphonse', 'samedialphonse98@gmail.com', '0167186299', NULL, NULL, NULL, 0, NULL, '$2y$12$cc7NKGkV0IsbA5fNMSrmjOyPfGCqpuuUI4cogQlSg5ZlbI4xOG14C', 0, NULL, '2026-01-23 12:26:20', '2026-01-23 12:26:20'),
(13, 'DANGNIVO Koty Anna Bai', 'annabaidangnivo2017@gmail.com', '+2290166955111', 'Cotonou Fidjrossè', NULL, NULL, 0, NULL, '$2y$12$G5q3pGn2IO/59MXesVc0MuV4Ao5qHUojKg/sG3RlepvzV2PSmxNHK', 0, NULL, '2026-01-23 12:26:41', '2026-01-23 12:26:41'),
(14, 'Makhfous cissé', 'makhfouslegrand@gmail.com', '00221777934366', 'dakar senegal', NULL, NULL, 0, NULL, '$2y$12$szVHiwssZ9tH9blorU4f.uP7ru5JPjFbIHQ8pqPzxy7AzTSgKbU3C', 0, '0MB6lbI5O3CmUtEnvmMtT2zIuzvPC1FfzKahTnh9Qz3epEXXG1HkD8GnQaBB', '2026-01-23 12:26:49', '2026-01-23 12:26:49'),
(15, 'Moïse NONVIGNON', 'dmoisenonvignon@gmail.com', '(00229) 0166424948', NULL, NULL, NULL, 0, NULL, '$2y$12$AbetTEbV4FCbOFPqlKgePO3MpfOERl.B.mz6P2u5YbTUojKoATs.2', 0, NULL, '2026-01-23 12:26:57', '2026-01-23 12:26:57'),
(16, 'CODJO BLIGUI Marius', 'mcodjobligui@gmail.com', '+2290162160155', NULL, 'avatars/IdDIXEKZIAPwx4SaeGAF3JWQCAP9i0ao69sUKWrI.jpg', NULL, 0, NULL, '$2y$12$xjzHEFS5Z8FXhLoEkdOEjuFDuVF.DpwzsdA384jWcIvRzCVsRWFrG', 0, NULL, '2026-01-23 12:27:37', '2026-01-23 12:28:08'),
(17, 'MBOUKE YAWAVI', 'yawavi.mbouke@gmail.com', '0022893075585', 'Lomé Togo', NULL, NULL, 0, NULL, '$2y$12$XExg6ww0isGrTr2sgp5tN.TF1h.81H8NLEEjF48peNKJbQ2fOtMli', 0, NULL, '2026-01-23 12:27:41', '2026-01-23 12:27:41'),
(18, 'Adiho Axelle', 'adorasse@yahoo.fr', '0197586600', NULL, NULL, NULL, 0, NULL, '$2y$12$JUunu68uK5FbcOi6o223pOT9eZmiz2uL2wMg8qU7CR8XpOcdRZ2DC', 0, NULL, '2026-01-23 12:27:44', '2026-01-23 12:27:44'),
(19, 'COVI Alida', 'covialida43@gmail.com', '0169559041', 'Sinoutin', NULL, NULL, 0, NULL, '$2y$12$5Xjlss.Hha5vOxGNwKUUquQanwbpVFP8l6zYkR1LxSnrGxHKcVe0S', 0, NULL, '2026-01-23 12:28:22', '2026-01-23 12:28:22'),
(20, 'OGA Atchéni Fabrice', 'ogafabrice3@gmail.com', '0196095176', 'TCHAOUROU', 'avatars/sdQRXKHgVwSUwNLsvhuCDoaYvVjaOkg7Zzo70ufA.jpg', NULL, 0, NULL, '$2y$12$EXItMxz52TDc9z9CKtXGKehi86h.DK61Y/DFKJ7Av0ZyQBWDUorEW', 0, NULL, '2026-01-23 12:28:38', '2026-01-23 12:28:55'),
(21, 'MABOUDOU Abdou Rahim', 'maboudourahim@gmail.com', '+2290196841305', 'Ladjifarani, vons de cap finances', NULL, NULL, 0, NULL, '$2y$12$cd6lTEtE16hjYvndjiNBge/hBJWqRqLJmeY7.LKuAq6W0/RxYFDcm', 0, NULL, '2026-01-23 12:28:41', '2026-01-23 12:28:41'),
(22, 'Théophile Sèwanou', 'sewat369@gmail.com', '+229 0196746339', NULL, 'avatars/xGyxWzrJ14RlEkMCuv5YTaGZdrYyiJ0WJm4S3GWC.jpg', NULL, 0, NULL, '$2y$12$9ClZhskWFsk/w4ufzPIMh.704AP/CuAxtuHf5Dg9Fzju6jJkcY0FK', 0, NULL, '2026-01-23 12:28:54', '2026-01-23 12:30:52'),
(23, 'ABOU Nassirou', 'abounassirou5@gmail.com', '0195287693', NULL, NULL, NULL, 0, NULL, '$2y$12$BcsAyQR7Z7dKDOZUEMHcP.paEjXG9smuYEx/qPsxYkXec4HF16sb2', 0, NULL, '2026-01-23 12:29:26', '2026-01-23 12:29:26'),
(24, 'Ornella', 'ornellaadjanohoun@gmail.com', '0197482502', NULL, NULL, NULL, 0, NULL, '$2y$12$4qD3as.nDf1VMsWI55./UeY/x5OSdw/waHgd6IdLCDQSXXUzvt4d.', 0, NULL, '2026-01-23 12:30:23', '2026-01-23 12:31:18'),
(25, 'YAHOUÉDÉHOU Assouan', 'arysassouan@gmail.com', '0197556653', NULL, NULL, NULL, 0, NULL, '$2y$12$aqrV4JheUmCR/fStDs6b/OSiPS/Xxiijmk9DgrGibAb5XHqayMmJ.', 0, NULL, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(26, 'HOUNHATOHOU S.Anicette', 'anicettesemevo@gmail.com', '+2290162902599', NULL, NULL, NULL, 0, NULL, '$2y$12$xJiUtPYaPapv1oqsb6zF1O7qkqHuwpuzPVCcwY0fR4mrDDYhXjBrO', 0, NULL, '2026-01-23 12:32:23', '2026-01-23 12:32:23'),
(27, 'Gandébagni Assiba Mireille', 'acrabole2008@yahoo.fr', '0197067055', NULL, NULL, NULL, 0, NULL, '$2y$12$tkF5w3i5sFneCPt6JBYlge5YIl3SfLTZLsbdbrdh1u6zK14x77Hfy', 0, NULL, '2026-01-23 12:35:07', '2026-01-23 12:35:07'),
(28, 'DEGUENON Sonia Gloriane', 'soniadeguenon@gmail.com', '+229 0161151235', '02BP1111, Cotonou Agla', NULL, NULL, 0, NULL, '$2y$12$QpZS9GTIIg8NZQC1/.2svO0PJahEErrqA1eqUWYT8/lQDyLbHiuta', 0, NULL, '2026-01-23 12:35:17', '2026-01-23 12:35:17'),
(29, 'Agbeko kossi', 'innocentagbeko@yahoo.fr', '0163400441', NULL, 'avatars/7oiagCYm3iCcZxYT4Dvo2Vcw2axj2k8S4Q8xcc5Y.jpg', NULL, 0, NULL, '$2y$12$Mif6Lmq1NnI8Wq.POUbJ5eCdFNf73IRkcIHUuAlejnrr8dn873JEC', 0, NULL, '2026-01-23 12:38:18', '2026-01-23 12:39:14'),
(30, 'AFFIDJI ABDEL MOUHAZOU', 'affidjiabdelmouhazou@gmail.com', '0195368883', 'Non spécifié', NULL, NULL, 0, NULL, '$2y$12$t/F9VBzIHE2EpaWQy1oHduPNzHkUrgf4vuLgiH0OcNJpiQKKRaNSC', 0, NULL, '2026-01-23 12:38:25', '2026-01-23 12:38:25'),
(31, 'DOSSOU Affolabi Stanislas', 'stanedossou977@gmail.com', '+229 0161590116', 'BENIN, Borgou', NULL, NULL, 0, NULL, '$2y$12$MYe0a3EeOXhQbD7u5FE.Y.V2ciP5R25FggaAFFmHlndNYtIQtyKFK', 0, NULL, '2026-01-26 10:57:09', '2026-01-26 11:02:59'),
(32, 'Prestige ZONDOGA', 'prestigezondoga@gmail.com', '+22968732300', 'prestigezondoga@gmail.com', NULL, NULL, 0, NULL, '$2y$12$MHLs8hbDlxVKQCqBBnwlyu9TV2JzxpNmDAkX5B9wpUfV/hiI4BYc2', 0, NULL, '2026-01-27 22:45:29', '2026-01-27 22:45:29'),
(33, 'Herve AYEMENE', 'ayemeneh@yahoo.fr', '+2250707702219', 'Bp 366 Dabou', 'avatars/HYp2Qg3QL6Oxv3adhrMAZk3L9rZPXZpEOnbcsWVa.png', NULL, 0, NULL, '$2y$12$y3q0hhVgLZJiQCTkttEsvOSDJMWwUjnPK/ZcVZIK4SmdZl0m/VlBS', 0, NULL, '2026-02-05 08:54:04', '2026-02-05 08:54:27'),
(34, 'Kodjo AGBEMELE', 'agbemelekodjo1@gmail.com', '91727462', NULL, 'avatars/Dp5kBG8zG0AJS59mVZ32AMPRl1sE6Mnx904osgrn.png', NULL, 0, NULL, '$2y$12$.vaW1kcRlEZKYUMoHYcP3Ok.pOxmIRG2dJh.BJcZ4LnOsYzbpmyK.', 0, NULL, '2026-02-07 12:51:44', '2026-02-07 12:52:04'),
(35, 'KOFFI EVELYNE', 'evelynefkoffi@yahoo.fr', '0758532709', 'Abidjan - Côte d\'Ivoire', NULL, NULL, 0, NULL, '$2y$12$Qa1JyPIxT0TLqQABP15yXOCMRgtXwarwN914oYSLIRhFh0f2auwPe', 0, NULL, '2026-02-08 14:55:50', '2026-02-08 14:55:50');

-- --------------------------------------------------------

--
-- Structure de la table `user_module_progression`
--

CREATE TABLE `user_module_progression` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `module_contenu_id` bigint(20) UNSIGNED NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `video_watch_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_quiz_attempts`
--

CREATE TABLE `user_quiz_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `quiz_id` bigint(20) UNSIGNED NOT NULL,
  `reponses` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'Réponses de l''utilisateur au format JSON' CHECK (json_valid(`reponses`)),
  `score` decimal(5,2) DEFAULT NULL,
  `points_obtenus` int(11) DEFAULT NULL,
  `points_total` int(11) DEFAULT NULL,
  `reussi` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Quiz réussi ou non',
  `debut_at` timestamp NULL DEFAULT NULL,
  `fin_at` timestamp NULL DEFAULT NULL,
  `duree_secondes` int(11) DEFAULT NULL COMMENT 'Temps mis pour compléter (en secondes)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_quiz_attempts`
--

INSERT INTO `user_quiz_attempts` (`id`, `user_id`, `quiz_id`, `reponses`, `score`, `points_obtenus`, `points_total`, `reussi`, `debut_at`, `fin_at`, `duree_secondes`, `created_at`, `updated_at`) VALUES
(1, 32, 2, '[]', 0.00, 0, 6, 0, '2026-01-27 22:46:03', '2026-01-27 22:57:25', 683, '2026-01-27 22:46:03', '2026-01-27 22:57:25');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `articles_slug_unique` (`slug`),
  ADD KEY `articles_author_id_foreign` (`author_id`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_user_id_foreign` (`user_id`),
  ADD KEY `cart_items_catalogue_id_foreign` (`catalogue_id`);

--
-- Index pour la table `catalogues`
--
ALTER TABLE `catalogues`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `certificats`
--
ALTER TABLE `certificats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificats_numero_certificat_unique` (`numero_certificat`),
  ADD KEY `certificats_formation_inscription_id_foreign` (`formation_inscription_id`),
  ADD KEY `certificats_user_id_foreign` (`user_id`),
  ADD KEY `certificats_formation_id_foreign` (`formation_id`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `commandes_idempotency_key_unique` (`idempotency_key`),
  ADD KEY `commandes_user_id_foreign` (`user_id`);

--
-- Index pour la table `commande_items`
--
ALTER TABLE `commande_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_items_commande_id_foreign` (`commande_id`),
  ADD KEY `commande_items_catalogue_id_foreign` (`catalogue_id`);

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `emprunts`
--
ALTER TABLE `emprunts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emprunts_user_id_foreign` (`user_id`),
  ADD KEY `emprunts_livre_id_foreign` (`livre_id`);

--
-- Index pour la table `equipes`
--
ALTER TABLE `equipes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evaluations_formation_inscription_id_foreign` (`formation_inscription_id`),
  ADD KEY `evaluations_formation_id_foreign` (`formation_id`),
  ADD KEY `evaluations_user_id_foreign` (`user_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `formations`
--
ALTER TABLE `formations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `formation_inscriptions`
--
ALTER TABLE `formation_inscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formation_inscriptions_user_id_foreign` (`user_id`),
  ADD KEY `formation_inscriptions_formation_id_foreign` (`formation_id`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modules_formation_id_foreign` (`formation_id`);

--
-- Index pour la table `module_contenus`
--
ALTER TABLE `module_contenus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_contenus_module_id_foreign` (`module_id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `question_options`
--
ALTER TABLE `question_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_options_question_id_foreign` (`question_id`);

--
-- Index pour la table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quizzes_module_id_foreign` (`module_id`),
  ADD KEY `quizzes_formation_id_foreign` (`formation_id`);

--
-- Index pour la table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_questions_quiz_id_foreign` (`quiz_id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `testimonials_user_id_foreign` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Index pour la table `user_module_progression`
--
ALTER TABLE `user_module_progression`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_module_progression_user_id_module_contenu_id_unique` (`user_id`,`module_contenu_id`),
  ADD KEY `user_module_progression_module_id_foreign` (`module_id`),
  ADD KEY `user_module_progression_module_contenu_id_foreign` (`module_contenu_id`);

--
-- Index pour la table `user_quiz_attempts`
--
ALTER TABLE `user_quiz_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_quiz_attempts_quiz_id_foreign` (`quiz_id`),
  ADD KEY `user_quiz_attempts_user_id_quiz_id_index` (`user_id`,`quiz_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `catalogues`
--
ALTER TABLE `catalogues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `certificats`
--
ALTER TABLE `certificats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `commande_items`
--
ALTER TABLE `commande_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `emprunts`
--
ALTER TABLE `emprunts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `equipes`
--
ALTER TABLE `equipes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `formations`
--
ALTER TABLE `formations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `formation_inscriptions`
--
ALTER TABLE `formation_inscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `module_contenus`
--
ALTER TABLE `module_contenus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `question_options`
--
ALTER TABLE `question_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `user_module_progression`
--
ALTER TABLE `user_module_progression`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user_quiz_attempts`
--
ALTER TABLE `user_quiz_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_catalogue_id_foreign` FOREIGN KEY (`catalogue_id`) REFERENCES `catalogues` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `certificats`
--
ALTER TABLE `certificats`
  ADD CONSTRAINT `certificats_formation_id_foreign` FOREIGN KEY (`formation_id`) REFERENCES `formations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificats_formation_inscription_id_foreign` FOREIGN KEY (`formation_inscription_id`) REFERENCES `formation_inscriptions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `commande_items`
--
ALTER TABLE `commande_items`
  ADD CONSTRAINT `commande_items_catalogue_id_foreign` FOREIGN KEY (`catalogue_id`) REFERENCES `catalogues` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `commande_items_commande_id_foreign` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `emprunts`
--
ALTER TABLE `emprunts`
  ADD CONSTRAINT `emprunts_livre_id_foreign` FOREIGN KEY (`livre_id`) REFERENCES `catalogues` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `emprunts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `evaluations`
--
ALTER TABLE `evaluations`
  ADD CONSTRAINT `evaluations_formation_id_foreign` FOREIGN KEY (`formation_id`) REFERENCES `formations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluations_formation_inscription_id_foreign` FOREIGN KEY (`formation_inscription_id`) REFERENCES `formation_inscriptions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `formation_inscriptions`
--
ALTER TABLE `formation_inscriptions`
  ADD CONSTRAINT `formation_inscriptions_formation_id_foreign` FOREIGN KEY (`formation_id`) REFERENCES `formations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `formation_inscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `modules`
--
ALTER TABLE `modules`
  ADD CONSTRAINT `modules_formation_id_foreign` FOREIGN KEY (`formation_id`) REFERENCES `formations` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `module_contenus`
--
ALTER TABLE `module_contenus`
  ADD CONSTRAINT `module_contenus_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `question_options`
--
ALTER TABLE `question_options`
  ADD CONSTRAINT `question_options_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_formation_id_foreign` FOREIGN KEY (`formation_id`) REFERENCES `formations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quizzes_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `user_module_progression`
--
ALTER TABLE `user_module_progression`
  ADD CONSTRAINT `user_module_progression_module_contenu_id_foreign` FOREIGN KEY (`module_contenu_id`) REFERENCES `module_contenus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_module_progression_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_module_progression_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user_quiz_attempts`
--
ALTER TABLE `user_quiz_attempts`
  ADD CONSTRAINT `user_quiz_attempts_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_quiz_attempts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
