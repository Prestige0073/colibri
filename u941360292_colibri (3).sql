-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 23 fév. 2026 à 00:23
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
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_super_admin` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('active','suspended','inactive') NOT NULL DEFAULT 'active',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `phone`, `avatar`, `role_id`, `is_super_admin`, `status`, `last_login_at`, `created_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Colibri Littéraire', 'colibri@gmail.com', '$2y$12$iUl1lnatOFqs91jebTlyWudebuScAly/Anh2jE6zBAw6s5rc9fNui', NULL, NULL, NULL, 1, 'active', '2026-02-18 03:32:56', NULL, '9Ls6rKOZvp7ZBeIAYvZKjy2KCfAWiVnqOVHiQh8ueGwc6mmFzSePeyUH0sLl', '2026-02-08 21:04:25', '2026-02-18 03:32:56'),
(2, 'Expédie DAKO', 'modestezondoga@gmail.com', '$2y$12$WxVql3aNBZTbgUgkmwhw3uppMSKfOtNRLB9Uv0T9p/vzEX58TI9l6', '90268393', NULL, 1, 0, 'active', '2026-02-12 20:33:58', 1, NULL, '2026-02-12 20:31:26', '2026-02-12 20:33:58');

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
(8, 'Deuxième session de formation du projet \"Colibri Littéraire\" : 60 acteurs africains analysent les modalités d\'application de l\'IA au secteur du livre', 'deuxieme-session-de-formation-du-projet-colibri-litteraire-60-acteurs-africains-analysent-les-modalites-dapplication-de-lia-au-secteur-du-livre', NULL, '<h2 class=\"ql-align-justify\">Du 21 au 23 janvier dernier, s\'est déroulée, au profit d\'environ soixante professionnels ouest africains francophones de la chaine du livre, à la Bibliothèque Bénin Excellence de Godomey et en ligne, la deuxième session de formation hybride entrant dans le cadre de la mise en œuvre du projet \"Colibri Littéraire\". C\'est une initiative de l\'ONG Ecrivains Humanistes du Bénin, réalisée avec le soutien de l\'Organisation internationale de la Francophonie (OIF) dans le cadre du dispositif \"FORCE - Formation et renforcement de compétences en édition\".</h2><p><br></p>', 'img/blog/blog_6977d05268da0.jpg', 1, 'published', '2026-01-26 19:37:53', 10, '2026-01-26 19:36:34', '2026-02-14 07:32:40'),
(9, 'Dynamisation du marché du livre africain : L\'ONG Ecrivains Humanistes outille 60 acteurs de la chaine', 'dynamisation-du-marche-du-livre-africain-long-ecrivains-humanistes-outille-60-acteurs-de-la-chaine', NULL, '<h2 class=\"ql-align-justify\">60 acteurs ouest africains du secteur du livre sont rentrés dans un processus de développement de nouveaux marchés du livre la semaine écoulée. C\'est à la faveur de la première session du volet Formation et mise en réseau du projet \"Colibri Littéraire\", déroulée du 10 au 12 novembre, en présentiel à la Bibliothèque Bénin Excellence de Godomey au Bénin&nbsp;et en ligne. L\'initiative, soutenue par l\'Organisation internationale de la Francophonie (OIF) dans le cadre du dispositif FORCE - Formation et renforcement de compétences en édition\", est mise en œuvre par l\'ONG Ecrivains Humanistes du Bénin.</h2><p><br></p>', 'img/blog/blog_6977d4d818053.jpg', 1, 'published', '2026-01-26 19:55:52', 9, '2026-01-26 19:55:52', '2026-02-19 17:03:41');

-- --------------------------------------------------------

--
-- Structure de la table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `admin_id`, `action`, `model_type`, `model_id`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 1, 'admin_created', 'App\\Models\\Admin', 2, NULL, '{\"name\":\"Exp\\u00e9die DAKO\",\"email\":\"modestezondoga@gmail.com\",\"phone\":\"90268393\",\"role_id\":\"1\",\"status\":\"active\",\"created_by\":1,\"updated_at\":\"2026-02-12T20:31:26.000000Z\",\"created_at\":\"2026-02-12T20:31:26.000000Z\",\"id\":2}', '2a02:6ea0:c31f:6218::17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-02-12 20:31:26');

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
('colibri-litteraire-cache-colibri@gmail.com|194.11.198.18', 'i:2;', 1770926867),
('colibri-litteraire-cache-colibri@gmail.com|194.11.198.18:timer', 'i:1770926867;', 1770926867),
('colibri-litteraire-cache-colibri@gmail.com|197.234.221.231', 'i:1;', 1770592166),
('colibri-litteraire-cache-colibri@gmail.com|197.234.221.231:timer', 'i:1770592166;', 1770592166),
('colibri-litteraire-cache-lelivrovore@gmail.com|197.234.219.46', 'i:1;', 1770614260),
('colibri-litteraire-cache-lelivrovore@gmail.com|197.234.219.46:timer', 'i:1770614260;', 1770614260),
('colibri-litteraire-cache-prestigezondoga@gmail.com|41.79.219.221', 'i:1;', 1771281565),
('colibri-litteraire-cache-prestigezondoga@gmail.com|41.79.219.221:timer', 'i:1771281565;', 1771281565),
('colibri-litteraire-cache-security_attempts_39', 'i:9;', 1771015160);

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

--
-- Déchargement des données de la table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `catalogue_id`, `quantite`, `created_at`, `updated_at`) VALUES
(4, 40, 56, 1, '2026-02-16 22:34:45', '2026-02-16 22:34:45'),
(5, 39, 51, 1, '2026-02-16 22:38:45', '2026-02-16 22:38:45');

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
  `audio` varchar(255) DEFAULT NULL,
  `type_contenu` enum('pdf','audio') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `catalogues`
--

INSERT INTO `catalogues` (`id`, `titre`, `auteur`, `categorie`, `prix`, `quantite`, `type`, `type_categorie`, `resumer`, `image`, `pdf`, `audio`, `type_contenu`, `created_at`, `updated_at`) VALUES
(4, 'La Bataille du Désert', 'Mouhamadou Kpaka', 'Autre', 5000, 1, 'catalogue', 'catalogue', '<p>La Bataille du désert</p>', 'img/livres/img_6966ea3e845a3.jpg', 'pdf/catalogue/pdf_6966ea3e84cdd.pdf', NULL, NULL, '2026-01-13 23:58:38', '2026-01-13 23:58:38'),
(5, 'Une cible dans le dos', 'Balndine Dokoui', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Une cible dans le dos</p>', 'img/livres/img_6966ebf4ea5db.jpg', 'pdf/catalogue/pdf_6966ebf4eaa82.pdf', NULL, NULL, '2026-01-14 00:05:56', '2026-01-14 00:05:56'),
(6, 'Les Tontinières', 'Erroce Yanclo', 'Autre', 5000, 100, 'catalogue', 'catalogue', '<p>Les Tontinières</p>', 'img/livres/img_6966ec73046ae.jpg', 'pdf/catalogue/pdf_6966ec7304a75.pdf', NULL, NULL, '2026-01-14 00:08:03', '2026-01-14 00:08:03'),
(7, 'Un cycliste dans l\'Iroko', 'Ana Baï Dangnivo', 'Autre', 4000, 100, 'catalogue', 'catalogue', '<p>Un cycliste dans l\'Iroko</p>', 'img/livres/img_6966ece430182.jpg', 'pdf/catalogue/pdf_6966ece4305ee.pdf', NULL, NULL, '2026-01-14 00:09:56', '2026-02-07 09:56:49'),
(8, 'Joyeuses Mélancolies', 'Axelle Adiho', 'Poésie', 5000, 100, 'catalogue', 'catalogue', '<p>Joyeuses Mélancolies</p>', 'img/livres/img_6966ed363fa39.jpg', 'pdf/catalogue/pdf_6966ed363ff94.pdf', NULL, NULL, '2026-01-14 00:11:18', '2026-01-14 00:11:18'),
(9, 'Les hommes de ces femmes', 'Elvy Gotiene', 'Autre', 10000, 100, 'catalogue', 'catalogue', '<p>Les hommes de ces femmes&nbsp;</p>', 'img/livres/img_6966edcf52b98.jpg', 'pdf/catalogue/pdf_6966edcf531dd.pdf', NULL, NULL, '2026-01-14 00:13:51', '2026-01-14 00:14:16'),
(10, 'Quand un choix  s\'impose', 'Hervé Ayémèné', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Quand un choix &nbsp;s\'impose</p>', 'img/livres/img_6966ee4c2f03c.jpg', 'pdf/catalogue/pdf_6966ee4c2f440.pdf', NULL, NULL, '2026-01-14 00:15:56', '2026-01-14 00:15:56'),
(11, 'Les contes d\'ici et d\'ailleurs', 'Raymond Orou', 'Conte', 2000, 100, 'catalogue', 'catalogue', '<p>Les contes d\'ici et d\'ailleurs</p>', 'img/livres/img_6966ef00013b0.jpg', 'pdf/catalogue/pdf_6966ef00018ac.pdf', NULL, NULL, '2026-01-14 00:18:56', '2026-02-07 10:06:17'),
(12, 'Fleurs de Bonté', 'Alex André', 'Roman', 3500, 100, 'catalogue', 'catalogue', '<p>Fleurs de Bonté</p>', 'img/livres/img_6966efbfdcee0.jpg', 'pdf/catalogue/pdf_6966efbfdd379.pdf', NULL, NULL, '2026-01-14 00:22:07', '2026-02-07 10:09:06'),
(13, 'Le silence du tambour sacré', 'Archille Yameogo', 'Conte', 2500, 100, 'catalogue', 'catalogue', '<p>Le silence du tambour sacré</p>', 'img/livres/img_6966f05b50037.jpg', 'pdf/catalogue/pdf_6966f05b504a4.pdf', NULL, NULL, '2026-01-14 00:24:43', '2026-02-07 10:15:27'),
(14, 'Quand l\'amour devient une défiance', 'Konan Raoul Kouassi', 'Roman', 3500, 100, 'catalogue', 'catalogue', '<p>Quand l\'amour devient une défiance</p>', 'img/livres/img_6966f1108d1a8.jpg', 'pdf/catalogue/pdf_6966f1108d516.pdf', NULL, NULL, '2026-01-14 00:27:44', '2026-02-07 10:19:08'),
(15, 'Le silence des consciences', 'Nicole Kangah', 'Roman', 2500, 100, 'catalogue', 'catalogue', '<p>Le silence des consciences</p>', 'img/livres/img_6966f1b4d6257.jpg', 'pdf/catalogue/pdf_6966f1b4d66bf.pdf', NULL, NULL, '2026-01-14 00:30:28', '2026-02-07 10:19:57'),
(16, 'Invasion', 'Teki Ivan', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Invasion</p>', 'img/livres/img_6966f27b5e2a3.jpg', 'pdf/catalogue/pdf_6966f27b5e66a.pdf', NULL, NULL, '2026-01-14 00:33:47', '2026-01-14 00:33:47'),
(17, 'Représailles écarlates', 'Lionel Badele', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Représailles écarlates</p>', 'img/livres/img_6966f51a754eb.jpg', 'pdf/catalogue/pdf_6966f51a75a22.pdf', NULL, NULL, '2026-01-14 00:44:58', '2026-01-14 00:44:58'),
(18, 'Le poisson magique', 'Emmanuelle Berny-Lalèyè', 'Jeunesse', 5000, 100, 'catalogue', 'catalogue', '<p>Le poisson magique</p>', 'img/livres/img_6966f5643fc56.jpg', 'pdf/catalogue/pdf_6966f5644018a.pdf', NULL, NULL, '2026-01-14 00:46:12', '2026-02-08 17:45:27'),
(19, 'Le Mystère des assins volés', 'Emmanuelle Berny-Lalèyè', 'Jeunesse', 5000, 100, 'catalogue', 'catalogue', '<p>Le Mystère des assins volés</p>', 'img/livres/img_6966f5f4422a2.jpg', 'pdf/catalogue/pdf_6966f5f4426f8.pdf', NULL, NULL, '2026-01-14 00:48:36', '2026-01-14 00:48:36'),
(20, 'Mika et Miko', 'Gjimm Mokoo', 'Jeunesse', 3500, 100, 'catalogue', 'catalogue', '<p>Mika et Miko</p>', 'img/livres/img_6966f6d3020a5.jpg', 'pdf/catalogue/pdf_6966f6d30241b.pdf', NULL, NULL, '2026-01-14 00:52:19', '2026-02-07 10:31:38'),
(21, 'De la natte à l\'écran', 'Idrissa Sow', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>De la natte à l\'écran</p>', 'img/livres/img_6966f739c12a0.jpg', 'pdf/catalogue/pdf_6966f739c16ea.pdf', NULL, NULL, '2026-01-14 00:54:01', '2026-01-14 00:54:01'),
(22, 'Chants pour une fleur', 'Alvie Mouzita', 'Poésie', 5000, 100, 'catalogue', 'catalogue', '<p>Chants pour une fleur</p>', 'img/livres/img_6966f76d6c502.jpg', 'pdf/catalogue/pdf_6966f76d6c8ff.pdf', NULL, NULL, '2026-01-14 00:54:53', '2026-01-14 00:54:53'),
(23, 'L\'Accordéon veuf', 'Roland Kotcha', 'Poésie', 5000, 100, 'catalogue', 'catalogue', '<p>L\'Accordéon veuf&nbsp;</p>', 'img/livres/img_6966f81bb1fd3.jpg', 'pdf/catalogue/pdf_6966f81bb274a.pdf', NULL, NULL, '2026-01-14 00:57:47', '2026-01-14 00:57:47'),
(24, 'Virage Abrupt', 'Bénédicte Lovi', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Virage Abrupt</p>', 'img/livres/img_6966f87d835c8.jpg', 'pdf/catalogue/pdf_6966f87d83a47.pdf', NULL, NULL, '2026-01-14 00:59:25', '2026-01-14 00:59:25'),
(25, '40 ans de réclusion criminelle', 'Roméo Jérémie Babalao', 'Roman', 4000, 100, 'catalogue', 'catalogue', '<p>40 ans de réclusion criminelle</p>', 'img/livres/img_6966fc28adf4f.jpg', 'pdf/catalogue/pdf_6966fc28ae8f6.pdf', NULL, NULL, '2026-01-14 01:15:04', '2026-02-07 09:58:01'),
(26, '60 Millions', 'Chrys Amegan', 'Autre', 5000, 100, 'catalogue', 'catalogue', '<p>60 Millions</p>', 'img/livres/img_6966fcaa2e03d.jpg', 'pdf/catalogue/pdf_6966fcaa2e982.pdf', NULL, NULL, '2026-01-14 01:17:14', '2026-01-14 01:17:14'),
(27, 'Oxytocine', 'Chrys Amegan', 'Poésie', 5000, 100, 'catalogue', 'catalogue', '<p>Oxytocine</p>', 'img/livres/img_6966fcf847bef.jpg', 'pdf/catalogue/pdf_6966fcf8489b2.pdf', NULL, NULL, '2026-01-14 01:18:32', '2026-01-14 01:18:32'),
(28, 'Ebullition', 'Florent Aïkpé', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Ebullition</p>', 'img/livres/img_6966fd5a679ce.jpg', 'pdf/catalogue/pdf_6966fd5a67da6.pdf', NULL, NULL, '2026-01-14 01:20:10', '2026-01-14 01:20:10'),
(29, 'Le silence du pilon', 'Idrissa Sow', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Le silence du pilon&nbsp;</p>', 'img/livres/img_6966fdfa400e3.jpg', 'pdf/catalogue/pdf_6966fdfa40491.pdf', NULL, NULL, '2026-01-14 01:22:50', '2026-01-14 01:22:50'),
(30, 'La plus belle voix', 'Kodjo Agbemele', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>La plus belle voix</p>', 'img/livres/img_6966feba8f282.jpg', 'pdf/catalogue/pdf_6966feba8f781.pdf', NULL, NULL, '2026-01-14 01:26:02', '2026-01-14 01:26:02'),
(31, 'Le coeur d\'une fille originale', 'Kindenin Sabine Tuo', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Le coeur d\'une fille originale</p>', 'img/livres/img_696a345c2ac6d.jpg', 'pdf/catalogue/pdf_696a345c2b2f4.pdf', NULL, NULL, '2026-01-16 11:51:40', '2026-01-16 11:51:40'),
(32, 'Mon Panégyrique, Mon identité culturelle', 'ONG Ecrivains Humanistes', 'Documentaire', 10000, 100, 'catalogue', 'catalogue', '<p>Mon Panégyrique, Mon identité culturelle</p>', 'img/livres/img_696a34b84988f.jpg', 'pdf/catalogue/pdf_696a34b849c4c.pdf', NULL, NULL, '2026-01-16 11:53:12', '2026-02-07 10:07:16'),
(33, 'Soltices', 'Fabrice Oga', 'Poésie', 3000, 100, 'catalogue', 'catalogue', '<p>Fabrice Oga - Soltices</p>', 'img/livres/img_696a3527aa213.jpg', 'pdf/catalogue/pdf_696a3527aa72b.pdf', NULL, NULL, '2026-01-16 11:55:03', '2026-02-07 10:49:26'),
(34, 'A voix haute : le combat silencieux', 'Dah Sansan', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Dah Sansan - A voix haute : le combat silencieux - 5 000</p>', 'img/livres/img_696a359ae2594.jpg', 'pdf/catalogue/pdf_696a359ae2a00.pdf', NULL, NULL, '2026-01-16 11:56:58', '2026-01-16 11:56:58'),
(35, 'Katus', 'Safiatou Kaba', 'Essai', 5000, 100, 'catalogue', 'catalogue', '<p>Safiatou Kaba - Katus</p>', 'img/livres/img_696a361834098.jpg', 'pdf/catalogue/pdf_696a361834658.pdf', NULL, NULL, '2026-01-16 11:59:04', '2026-01-16 11:59:04'),
(36, 'Jeyna Ly : Taxiwoman', 'Abdoulaye Fodé Ndione', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Taxiwoman : Jeyna Ly</p>', 'img/livres/img_696a36dd9b9f0.jpg', 'pdf/catalogue/pdf_696a36dd9be28.pdf', NULL, NULL, '2026-01-16 12:02:21', '2026-01-16 12:02:21'),
(48, 'Sauvée par l\'amour', 'Jérôme Gnaloko Didi', 'Roman', 3500, 100, 'catalogue', 'catalogue', '<p>Sauvée par l\'amour -&nbsp;</p>', 'img/livres/img_697c7ab6539f3.jpg', 'pdf/catalogue/pdf_697c7ab653f6d.pdf', NULL, NULL, '2026-01-30 08:32:38', '2026-02-08 17:46:42'),
(49, 'Le super-héros', 'Touré Maguèye', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Le super héros - Touré Maguèye&nbsp;</p>', 'img/livres/img_697c7c4d3f9aa.jpg', 'pdf/catalogue/pdf_697c7c4d3fe34.pdf', NULL, NULL, '2026-01-30 08:39:25', '2026-01-30 08:39:25'),
(50, 'Faty, une vie volée', 'Jérôme Gnaloko Didi', 'Roman', 3500, 100, 'catalogue', 'catalogue', '<p>Faty, une vie volée - Jérôme Gnaloko Didi</p>', 'img/livres/img_697c7d8965f6d.jpg', 'pdf/catalogue/pdf_697c7d8966407.pdf', NULL, NULL, '2026-01-30 08:44:41', '2026-02-08 17:47:13'),
(51, 'Le droit d\'avoir mal', 'Marie - Elyse N\'guessan', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Le droit d\'avoir mal - Le droit d\'avoir mal</p>', 'img/livres/img_697c7ec207e8a.jpg', 'pdf/catalogue/pdf_697c7ec2084bf.pdf', NULL, NULL, '2026-01-30 08:49:54', '2026-01-30 08:49:54'),
(52, 'Les déboires d\'un courreur de jupons', 'Jérôme Gnaloko Didi', 'Roman', 3500, 100, 'catalogue', 'catalogue', '<p>Les déboires d\'un courreur de jupons - Jérôme Gnaloko Didi</p>', 'img/livres/img_697c82566a0bc.jpg', 'pdf/catalogue/pdf_697c82566a469.pdf', NULL, NULL, '2026-01-30 09:05:10', '2026-02-08 17:47:55'),
(53, 'L\'énigme de la nuit', 'Billas Kanate', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>L\'énigme de la nuit - Billas Kanate&nbsp;</p>', 'img/livres/img_697c88d1089dc.jpg', 'pdf/catalogue/pdf_697c88d108cf1.pdf', NULL, NULL, '2026-01-30 09:32:49', '2026-01-30 09:32:49'),
(55, 'Un si long voyage', 'Sègnigbindé Camille', 'Roman', 5000, 100, 'catalogue', 'catalogue', '<p>Amy, Moussa, Raficatou, Malick. Quatre étudiants, qui, fuyant leur vie précaire d’Afrique, se sont embarqués, comme passagers clandestins, pour l’ailleurs. Mais ils ont vite fait de comprendre : Il ne fait bon vivre que chez soi, même si le ‘‘chez soi’’ n’est pas toujours aussi confortable que dans leurs rêves d’enfants…</p>', 'img/livres/img_69939922482c1.jpg', NULL, NULL, NULL, '2026-02-16 22:24:34', '2026-02-16 22:24:34'),
(56, 'Au pays de l\'insolite', 'Dr Codjo Rodrigue Abel ASSAVEDO', 'Conte', 3000, 100, 'catalogue', 'catalogue', '<p>Résumé de cinq phrases au plus de l\'oeuvre : Au pays de l’insolite est un recueil de six contes et légendes destinés aussi bien aux enfants et aux jeunes d’aujourd’hui que de demain. Le but, en écrivant cet ouvrage, est d’essayer de ressusciter les inoubliables veillées nocturnes de nos villages africains, en l’occurrence béninois, afin d’y puiser les trésors de sagesse pour la réussite de nos vies.&nbsp;</p>', 'img/livres/img_699399ef56f1f.jpg', NULL, NULL, NULL, '2026-02-16 22:27:59', '2026-02-16 22:27:59'),
(57, 'EPP ALAFIA', 'Collectif', 'Jeunesse', 5000, 100, 'catalogue', 'catalogue', '<p>la stigmatisation de certains peuples est un mal qui compromet la cohésion sociale et le vivre-ensemble entre les communautés au Bénin. La bande dessinée \"EPP Alafia\", fruit d\'un travail collaboratif et expérimental des acteurs béninois de la chaine de création et de fabrication du livre jeunesse s\'attaque au mal à la racine.</p>', 'img/livres/img_69939a416feaa.jpg', NULL, NULL, NULL, '2026-02-16 22:29:21', '2026-02-16 22:29:21'),
(58, 'Eglise - Entreprise', 'Happi Marie', 'Essai', 10000, 100, 'catalogue', 'catalogue', '<p>Dans \"Église - Entreprise\" l\'auteure analyse avec lucidité la dérive inquiétante de certaines églises contemporaines qui, sous la direction de certains pasteurs et dirigeants religieux, se sont progressivement transformées en véritables entreprises financières. Ce livre se veut une critique constructive, visant à sensibiliser les croyants et les responsables religieux sur les impacts négatifs de cette situation, particulièrement sur les fidèles les plus vulnérables.</p>', 'img/livres/img_69939ac87baca.jpg', NULL, NULL, NULL, '2026-02-16 22:31:36', '2026-02-16 22:31:36');

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
  `logo_path` varchar(255) DEFAULT NULL,
  `cachet_path` varchar(255) DEFAULT NULL,
  `signature_path` varchar(255) DEFAULT NULL,
  `note_obtenue` int(11) NOT NULL,
  `date_delivrance` timestamp NOT NULL DEFAULT current_timestamp(),
  `lieu_delivrance` varchar(255) NOT NULL DEFAULT 'Cotonou',
  `signataire_nom` varchar(255) NOT NULL DEFAULT 'SEGNIGBINDE A. Camille',
  `signataire_titre` varchar(255) NOT NULL DEFAULT 'Directeur Exécutif',
  `envoye_email` tinyint(1) NOT NULL DEFAULT 0,
  `date_envoi_email` timestamp NULL DEFAULT NULL,
  `statut` enum('genere','envoye','reclame','valide','annule') DEFAULT 'genere',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `certificats`
--

INSERT INTO `certificats` (`id`, `formation_inscription_id`, `user_id`, `nom_manuel`, `email_manuel`, `formation_id`, `numero_certificat`, `fichier_pdf`, `logo_path`, `cachet_path`, `signature_path`, `note_obtenue`, `date_delivrance`, `lieu_delivrance`, `signataire_nom`, `signataire_titre`, `envoye_email`, `date_envoi_email`, `statut`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'SEGNIGBINDE Camille', 'paternecamille@yahoo.fr', 7, 'CL-2026-00001', 'certificats/certificat-CL-2026-00001.pdf', NULL, 'certificats/cachets/TYul8oSUqIHYfUSHNeSrTJ8XlEDRcRst8eCw6pBh.png', 'certificats/signatures/hqMrhsgt3tIth8ZTnoCvQ5xccInvRp31dUZGSB33.png', 100, '2026-02-12 00:00:00', 'Cotonou', 'SEGNIGBINDE A. Camille', 'Président', 1, '2026-02-12 20:21:17', 'envoye', '2026-02-12 20:21:13', '2026-02-12 20:21:17'),
(2, NULL, NULL, 'ZONDOGA Prestige', 'prestigezondoga@gmail.com', 7, 'CL-2026-00002', 'certificats/certificat-CL-2026-00002.pdf', NULL, 'certificats/cachets/f9RTTJtx1MK4IqEv2eJSdn3UHr0jq913qBjkZrso.png', 'certificats/signatures/jqUTKAq7qAACx5G9MqeJtFz1bHGqzmTtOFaJj0wL.png', 90, '2026-02-12 00:00:00', 'Cotonou', 'SEGNIGBINDE A. Camille', 'Directeur Exécutif', 0, NULL, 'genere', '2026-02-12 20:21:24', '2026-02-12 20:21:26');

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
(2, NULL, NULL, NULL, NULL, 5000.00, 'confirmee', 1, 'TEST-69706534DEB8B', 'test', NULL, '2026-01-21 03:33:33', '2026-01-21 03:33:40'),
(3, 32, NULL, NULL, NULL, 5000.00, 'confirmee', 1, 'TEST-69794F35F38CC', 'test', NULL, '2026-01-27 22:50:11', '2026-01-27 22:50:13'),
(4, 33, 'Herve AYEMENE', '+2250707702219', 'Bp 366 Dabou', 10000.00, 'en_preparation', 0, NULL, NULL, 'cod_69845b0be2fa88.18832301', '2026-02-05 07:55:39', '2026-02-10 04:49:51'),
(5, 32, 'Prestige ZONDOGA', '+22968732300', 'prestigezondoga@gmail.com', 7000.00, 'paid', 1, 'cQSG4G8Ko', 'kkiapay', NULL, '2026-02-08 21:44:56', '2026-02-08 21:45:27'),
(6, 32, 'Prestige ZONDOGA', '+22968732300', 'prestigezondoga@gmail.com', 3500.00, 'paid', 1, 'UnLkS4w2l', 'kkiapay', NULL, '2026-02-08 23:10:48', '2026-02-08 23:11:22'),
(7, 39, 'Modeste Prestige ZONDOGA', '+22990268393', 'C/BN COTONOU BENIN', 5000.00, 'paid', 1, 'vQNFZ5y07', 'kkiapay', NULL, '2026-02-12 20:12:13', '2026-02-12 20:12:56'),
(8, 40, 'camille', '+2290166547808', 'Abomey-Calavi', 3000.00, 'pending', 0, NULL, 'kkiapay', NULL, '2026-02-16 22:36:12', '2026-02-16 22:36:12'),
(9, 39, 'Modeste Prestige ZONDOGA', '+22990268393', 'C/BN COTONOU BENIN', 5000.00, 'pending', 0, NULL, 'kkiapay', NULL, '2026-02-16 22:38:56', '2026-02-16 22:38:56');

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
(2, 2, 36, NULL, 1, 0.00, '2026-01-21 03:33:33', '2026-01-21 03:33:33'),
(3, 3, 36, NULL, 1, 0.00, '2026-01-27 22:50:11', '2026-01-27 22:50:11'),
(4, 4, 53, 'L\'énigme de la nuit', 2, 5000.00, '2026-02-05 07:55:39', '2026-02-05 07:55:39'),
(5, 5, 52, 'Les déboires d\'un courreur de jupons', 2, 3500.00, '2026-02-08 21:44:56', '2026-02-08 21:44:56'),
(6, 6, 14, 'Quand l\'amour devient une défiance', 1, 3500.00, '2026-02-08 23:10:48', '2026-02-08 23:10:48'),
(7, 7, 53, 'L\'énigme de la nuit', 1, 5000.00, '2026-02-12 20:12:13', '2026-02-12 20:12:13'),
(8, 8, 56, 'Au pays de l\'insolite', 1, 3000.00, '2026-02-16 22:36:12', '2026-02-16 22:36:12'),
(9, 9, 51, 'Le droit d\'avoir mal', 1, 5000.00, '2026-02-16 22:38:56', '2026-02-16 22:38:56');

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
(1, 'Hello http://colibri-litteraire.com/fekal0911 Owner', 'pirduhina96@gmail.com', 'Dear http://colibri-litteraire.com/fekal0911 Webmaster', 'To the http://colibri-litteraire.com/fekal0911 Webmaster', 1, '2026-01-27 09:33:06', '2026-01-26 09:38:16', '2026-01-27 09:33:06');

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
(1, 'Camille SEGNIGBINDE', 'Président - Coordonateur \"Colibri Littéraire\"', NULL, 'img/team/camille.png', 'camille.segnigbinde@colibri-litteraire.org', 1, '2025-12-30 13:33:41', '2026-01-17 13:38:36'),
(2, 'Catira DODO', 'Responsable à la Formation', NULL, 'img/team/catira.png', 'catira.dodo@colibri-litteraire.org', 1, '2025-12-30 13:33:41', '2026-01-17 13:36:12'),
(3, 'Hervé AYEMENE', 'Point Focal - Côte d\'Ivoire', NULL, 'img/team/Hervé.png', 'herve.ayemene@colibri-litteraire.org', 1, '2025-12-30 13:33:41', '2026-01-17 13:36:27'),
(4, 'Prudentienne GBAGUIDI', 'Experte Formatrice', NULL, 'img/team/prudentienne.jpg', 'prudentienne.gbaguidi@colibri-litteraire.org', 1, '2025-12-30 13:33:41', '2026-01-17 13:36:38'),
(5, 'Augustino AGBEMAVO', 'Expert Formateur', NULL, 'img/team/augustino.jpg', 'augustino.agbemavo@colibri-litteraire.org', 1, '2025-12-30 13:33:41', '2026-01-17 13:36:56'),
(6, 'Rodrigue ATCHAOUE', 'Expert Formateur', NULL, 'img/team/rodrigue.jpg', 'rodrigue.atchaoue@colibri-litteraire.org', 1, '2025-12-30 13:33:41', '2026-01-17 13:37:06'),
(7, 'Adèle KIEMA', 'Point focal Colibri Littéraire - Niger', NULL, 'img/team/adele.png', 'adele.kiema@colibri-litteraire.org', 1, '2025-12-30 13:33:42', '2026-01-17 13:35:09'),
(8, 'Idrissa SOW', 'Point focal Colibri Littéraire - Sénégal', NULL, 'img/team/idrissa.jpg', 'idrissa.sow@colibri-litteraire.org', 1, '2025-12-30 13:33:42', '2026-01-17 11:36:18'),
(9, 'Yawavi MBOUKE', 'Point focal Colibri Littéraire - Togo', NULL, 'img/team/yawavi.png', 'yawavi.mbouke@colibri-litteraire.org', 1, '2025-12-30 13:33:42', '2026-01-17 11:38:10'),
(10, 'Vivien Zanou', 'Responsable à la logistique', NULL, 'img/team/vivien.png', 'vivien.zanou@colibri-litteraire.org', 1, '2025-12-30 13:33:42', '2026-01-17 13:35:35'),
(11, 'Corneille ANOUMON', 'Responsable à la communication', NULL, 'img/team/corneille.png', 'corneille.anoumon@colibri-litteraire.org', 1, '2025-12-30 13:33:42', '2026-01-17 13:35:47');

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
  `est_gratuit` tinyint(1) NOT NULL DEFAULT 0,
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

INSERT INTO `formations` (`id`, `titre`, `description`, `objectifs`, `image`, `prix`, `est_gratuit`, `niveau`, `duree`, `nombre_modules`, `active`, `categorie`, `prerequis`, `note_minimale_certification`, `inscrits_count`, `created_at`, `updated_at`) VALUES
(2, 'Marketing digital appliqué à la chaine du livre en Afrique francophone', 'Cette formation est développée pour permettre aux professionnels de la chaine du livre d\'acquérir les compétences nécessaires en marketing digital en vue de donner de la visibilité aux livres africains francophones et de croitre leur vente. \r\nElle est créée dans le cadre du dispositif Formation et renforcement de compétences en édition - FORCE de l\'Organisation internationale de la Francophonie (OIF).\r\n\r\nCette formation est créée par Augustino AGBEMAVO (Expert en digitalisation) et SEGNIGBINDE A. Camille (Expert Industrie Culturelle et Créative (ICC) - Livre', 'L\'objectif de cette formation est d\'acquérir les compétences nécessaires en marketing digital appliqué aux entreprises de la chaine du livre en Afrique francophone', 'img/formations/formation_696bd0c54646d.PNG', 0.00, 0, 'debutant', '4 heures', 0, 1, 'Marketing digital', 'Cette formation est réservée aux personnes en charge de la communication au sein des entreprises de la chaine du livre. Disposer d\'un poste ordinateur et de la connexion internet sont les préalables pour réussir cette formation', 100, 0, '2026-01-17 17:11:17', '2026-01-18 20:43:12'),
(3, 'MARKETING DES RÉSEAUX SOCIAUX : Quel réseau pour quel objectif ?', 'Cette formation est un prolongement de celle portant sur le marketing digital. Elle est développée pour permettre aux professionnels de la chaine du livre d\'acquérir les compétences nécessaires à l\'utilisation des réseaux sociaux pour donner de la visibilité aux livres africains francophones et de croitre leur vente. \r\nElle est créée dans le cadre du dispositif Formation et renforcement de compétences en édition - FORCE de l\'Organisation internationale de la Francophonie (OIF).\r\n\r\nCette formation est créée par Augustino AGBEMAVO (Expert en digitalisation) et SEGNIGBINDE A. Camille (Expert ICC - Livre)', 'L\'objectif de cette formation est de faire découvrir aux acteurs de la chaine du livre, les outils nécessaires à la connaissance des réseaux sociaux pour leur permettre d\'en faire un usage rentable à leurs activités liées l\'industrie du livre.', 'img/formations/formation_696bdebd9e46a.PNG', 0.00, 0, 'intermediaire', '2', 0, 1, 'Marketing digital', 'Il est nécessaire de maitriser l\'outil internet, de disposer d\'un ordinateur ou un smartphone, de la connexion internet et de savoir les manipuler.', 100, 0, '2026-01-17 18:10:53', '2026-01-17 18:10:53'),
(7, 'Les enjeux et défis du droit d\'auteurs à l\'ère du numérique : protection, partage et innovation dans le domaine littéraire', 'Cette formation présente les principes essentiels du droit d’auteur appliqués au domaine littéraire et aux pratiques professionnelles de la chaine du livre. Elle vise à mieux comprendre les enjeux et les risques liés au numérique (piratage, intelligence artificielle, plateformes de diffusion), à concilier la protection des œuvres avec le partage des connaissances et l’innovation, à promouvoir l’adoption de bonnes pratiques chez les auteurs, lecteurs, enseignants et diffuseurs, et à encourager la coopération régionale.\r\nCette formation porte sur un sujet central pour tous les métiers du livre aujourd’hui : comment protéger les œuvres littéraires à l’ère du numérique, sans freiner la création ni l’accès au savoir.Étant donné la diversité des pays représentés, nous avons fait le choix d’un cadre juridique commun : l’Annexe VII de l’Accord de Bangui, applicable dans l’espace OAPI.\r\n\r\nL’objectif n’est pas de faire de vous des juristes, mais de vous donner des repères clairs, directement utiles dans vos pratiques quotidiennes : écrire, éditer, diffuser, vendre ou enseigner le livre.\r\nChaque pays a ses textes nationaux, mais pour éviter un éclatement juridique, nous nous appuyons sur un socle commun.Lorsque ce sera pertinent, je ferai ponctuellement référence à des exemples du Bénin, de la Côte d’Ivoire ou du Togo.\r\n\r\nL’OAPI regroupe plusieurs États africains autour d’un droit unifié de la propriété intellectuelle.L’Annexe VII est le texte de référence pour le droit d’auteur et les droits voisins.', '- Comprendre les fondements du droit d’auteur appliqués à la filière du livre, \r\n- Identifier les enjeux et risques du numérique (piratage, IA, plateformes),\r\n- Concilier protection des œuvres, partage des savoirs et innovation,\r\n- Adopter de bonnes pratiques en tant qu’auteur, lecteur, enseignant ou diffuseur.', 'img/formations/formation_69871d5d762ab.PNG', 0.00, 1, 'debutant', '2 Heures', 0, 1, 'Droit d\'auteurs', 'Aucun prérequis n\'est exigé pour suivre cette formation', 100, 0, '2026-02-07 10:09:17', '2026-02-10 03:17:13'),
(8, 'Partenariat gagnant-gagnant et synergie d’actions saine et fructueuse', 'La chaîne du livre africain est riche de talents, mais encore fragilisée par l’isolement des acteurs, la faiblesse des réseaux structurés et le manque de synergies durables. Ce module vise à doter les participants d’outils pratiques pour penser, construire et entretenir des partenariats gagnant-gagnant, capables de renforcer la circulation des œuvres et la professionnalisation du secteur', 'À l’issue de la formation, les participants seront capables de :\r\n- Comprendre les fondements d’un partenariat gagnant-gagnant.\r\n- Identifier les conditions d’une collaboration saine et durable.\r\n- Développer des synergies d’actions entre acteurs du livre.\r\n- Structurer et entretenir un réseau professionnel efficace.\r\n- Utiliser des plateformes collaboratives comme Colibri Littéraire pour renforcer leur impact.', 'img/formations/formation_698a48ef08241.PNG', 0.00, 1, NULL, '1 Heure 20 minutes', 0, 1, 'Partenariat gagnant-gagnant', 'Aucun prérequis n\'est exigé pour suivre cette formation', 100, 0, '2026-02-09 20:51:59', '2026-02-11 05:34:02'),
(9, 'Les livres audio et numériques : exploration d’un marché de niche marginalisé', 'Ce module met en lumière ce que sont les livres audio et numérique ainsi que leur différence', 'À la fin de cette formation, les participants seront capables de :\r\n1. Comprendre les enjeux économiques, sociaux et culturels des livres audios et numériques.\r\n2. Identifier les opportunités de croissance dans ces formats émergents.\r\n3. Concevoir un projet éditorial innovant autour du livre audio/numérique.\r\n4. Promouvoir l’inclusion et l’accessibilité à travers ces formats.\r\n5. Collaborer efficacement avec les auteurs et narrateurs dans le respect du cadre juridique.', 'img/formations/formation_698c1fc983685.PNG', 0.00, 0, NULL, '2 Heures 30', 0, 1, 'Livres audios et numériques', 'Aucun prérequis n\'est nécessaire pour ce module', 100, 0, '2026-02-11 06:20:57', '2026-02-11 07:21:40'),
(10, 'L\'IA et le secteur du livre : Défis et Opportunités', 'Ce module propose une introduction complète à l’intelligence artificielle (IA), en retraçant ses origines, son évolution et son impact croissant sur la société et le monde du travail. Il permet aux participants de comprendre comment l’IA s’est développée, depuis ses bases théoriques jusqu’à ses applications actuelles dans de nombreux secteurs.\r\n\r\nUne attention particulière est accordée à la transformation des métiers, notamment ceux liés au livre — auteurs, éditeurs, libraires, bibliothécaires — afin d’identifier les opportunités, les mutations des compétences et les défis professionnels engendrés par ces technologies.\r\n\r\nLe module aborde également les enjeux sociaux et éthiques associés à l’IA, tels que la responsabilité, la protection des données, l’équité, l’emploi et l’accès à la culture, afin de favoriser une utilisation éclairée et responsable.\r\n\r\nEnfin, un atelier de groupe permet aux participants d’échanger, d’analyser des situations concrètes et de réfléchir collectivement aux usages pertinents de l’IA dans leur contexte professionnel.', 'À l’issue du module, les participants seront capables de :\r\n\r\n1. Comprendre les bases de l’IA\r\nIdentifier les origines, les concepts fondamentaux et les grandes étapes de son évolution.\r\n\r\n2. Analyser l’impact de l’IA sur les métiers\r\nComprendre comment l’IA transforme les pratiques professionnelles, les compétences et l’organisation du travail.\r\n\r\n3. Appréhender les applications de l’IA dans le secteur du livre\r\nIdentifier les usages possibles pour l’écriture, l’édition, la diffusion, la médiation culturelle et la gestion documentaire.\r\n\r\n4. Évaluer les enjeux sociaux et éthiques\r\nRéfléchir aux questions de responsabilité, d’équité, de droits d’auteur, d’emploi, de biais et de protection des données.\r\n\r\n5. Développer un regard critique et responsable\r\nSavoir distinguer opportunités, limites et risques liés à l’utilisation de l’IA.\r\n\r\n6. Collaborer pour imaginer des usages pertinents\r\nParticiper à un travail collectif pour concevoir des applications concrètes adaptées à leur environnement professionnel.', 'img/formations/formation_69953cbac4a52.png', 0.00, 0, NULL, '2 Heures 35', 0, 1, 'Livres audios et numériques', NULL, 100, 0, '2026-02-18 04:14:50', '2026-02-18 04:59:30');

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
(3, 20, 3, 0.00, 'en_cours', 0, '2026-01-23 11:31:17', NULL, 0, NULL, '2026-01-23 11:31:17', '2026-01-23 11:31:17'),
(4, 7, 2, 0.00, 'en_cours', 0, '2026-01-23 11:32:03', NULL, 0, NULL, '2026-01-23 11:32:03', '2026-01-23 11:32:03'),
(5, 32, 2, 0.00, 'en_cours', 0, '2026-01-27 21:45:41', NULL, 1, 'TEST-6979402057C55', '2026-01-27 21:45:41', '2026-01-27 21:45:52'),
(6, 14, 3, 0.00, 'en_cours', 0, '2026-02-09 09:07:55', NULL, 0, NULL, '2026-02-09 09:07:55', '2026-02-09 09:07:55'),
(7, 39, 9, 0.00, 'en_cours', 0, '2026-02-12 20:06:31', NULL, 0, NULL, '2026-02-12 20:06:31', '2026-02-12 20:06:31'),
(8, 40, 9, 0.00, 'en_cours', 0, '2026-02-12 20:12:36', NULL, 0, NULL, '2026-02-12 20:12:36', '2026-02-12 20:12:36'),
(9, 45, 8, 0.00, 'en_cours', 0, '2026-02-13 01:56:39', NULL, 0, NULL, '2026-02-13 01:56:39', '2026-02-13 01:56:39');

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
(1, 'default', '{\"uuid\":\"5b9df128-cb9f-4a2f-bcb9-44dc73080152\",\"displayName\":\"App\\\\Mail\\\\User\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:31:\\\"App\\\\Mail\\\\User\\\\OrderConfirmation\\\":3:{s:8:\\\"commande\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\Commande\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:25:\\\"prestigezondoga@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770590727,\"delay\":null}', 0, NULL, 1770590727, 1770590727),
(2, 'default', '{\"uuid\":\"72028823-7bf0-490c-aa52-0bd046d0627b\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewOrder\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:23:\\\"App\\\\Mail\\\\Admin\\\\NewOrder\\\":3:{s:8:\\\"commande\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\Commande\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770590727,\"delay\":null}', 0, NULL, 1770590727, 1770590727),
(3, 'default', '{\"uuid\":\"89baeea7-2977-4084-abab-e1cde9eda5e1\",\"displayName\":\"App\\\\Mail\\\\User\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:31:\\\"App\\\\Mail\\\\User\\\\OrderConfirmation\\\":3:{s:8:\\\"commande\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\Commande\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:25:\\\"prestigezondoga@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770592282,\"delay\":null}', 0, NULL, 1770592282, 1770592282),
(4, 'default', '{\"uuid\":\"f8f6f003-4d28-4efd-a376-3482e3e3676a\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewOrder\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:23:\\\"App\\\\Mail\\\\Admin\\\\NewOrder\\\":3:{s:8:\\\"commande\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\Commande\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770592282,\"delay\":null}', 0, NULL, 1770592282, 1770592282),
(5, 'default', '{\"uuid\":\"388d3060-0180-49de-a9f1-efdd89338a23\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:36;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:21:\\\"lelivrovore@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770614311,\"delay\":null}', 0, NULL, 1770614311, 1770614311),
(6, 'default', '{\"uuid\":\"51c84a49-49cd-4017-ad2a-6e4a1c4147f4\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:36;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770614311,\"delay\":null}', 0, NULL, 1770614311, 1770614311),
(7, 'default', '{\"uuid\":\"f474f70e-07eb-4d67-b892-b664cdf879d2\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:37;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:19:\\\"jdgnaloko@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770636479,\"delay\":null}', 0, NULL, 1770636479, 1770636479),
(8, 'default', '{\"uuid\":\"a446c83b-5c8a-4ca2-b8da-76a8f0cac5a7\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:37;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770636479,\"delay\":null}', 0, NULL, 1770636479, 1770636479),
(9, 'default', '{\"uuid\":\"8b5a2a6f-4cce-4cb3-94b0-10db79873501\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:38;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:19:\\\"basilevie@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770894886,\"delay\":null}', 0, NULL, 1770894886, 1770894886),
(10, 'default', '{\"uuid\":\"1f70495f-3180-4cd4-a5b5-1a3c4cc12c71\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:38;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770894886,\"delay\":null}', 0, NULL, 1770894886, 1770894886),
(11, 'default', '{\"uuid\":\"0fa3b1e6-7d0f-46fa-8da5-d1df8fd224ce\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:39;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:24:\\\"modestezondoga@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770926749,\"delay\":null}', 0, NULL, 1770926749, 1770926749),
(12, 'default', '{\"uuid\":\"30471a51-378d-46a9-94bd-ed72fc87a3a6\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:39;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770926749,\"delay\":null}', 0, NULL, 1770926749, 1770926749),
(13, 'default', '{\"uuid\":\"008d56c8-8431-4b1b-ac51-a8dab6c2929f\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:40;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:23:\\\"paternecamille@yahoo.fr\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770927111,\"delay\":null}', 0, NULL, 1770927111, 1770927111),
(14, 'default', '{\"uuid\":\"e9e4ac76-5ddd-4650-83c0-f97983ea8ee2\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:40;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770927111,\"delay\":null}', 0, NULL, 1770927111, 1770927111),
(15, 'default', '{\"uuid\":\"e000bc5c-83cb-4607-ac12-3114a7f08107\",\"displayName\":\"App\\\\Mail\\\\User\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:31:\\\"App\\\\Mail\\\\User\\\\OrderConfirmation\\\":3:{s:8:\\\"commande\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\Commande\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:24:\\\"modestezondoga@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770927176,\"delay\":null}', 0, NULL, 1770927176, 1770927176),
(16, 'default', '{\"uuid\":\"56a74372-929f-42b5-a77b-7ff274491d32\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewOrder\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:23:\\\"App\\\\Mail\\\\Admin\\\\NewOrder\\\":3:{s:8:\\\"commande\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\Commande\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770927176,\"delay\":null}', 0, NULL, 1770927176, 1770927176),
(17, 'default', '{\"uuid\":\"c4d4ba4f-cf0d-4d79-8641-033c2961038c\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:41;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:26:\\\"editionlivrelart@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770929743,\"delay\":null}', 0, NULL, 1770929743, 1770929743),
(18, 'default', '{\"uuid\":\"df0564ea-bf1e-403e-85f4-dd42bb8f7979\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:41;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770929743,\"delay\":null}', 0, NULL, 1770929743, 1770929743),
(19, 'default', '{\"uuid\":\"a7d71ec6-58e4-417e-8ad1-32aa6dfefba2\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:42;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"richardakassibou6@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770929965,\"delay\":null}', 0, NULL, 1770929965, 1770929965),
(20, 'default', '{\"uuid\":\"afcb7cd9-3237-4aeb-bdcf-5943ba5e729e\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:42;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770929965,\"delay\":null}', 0, NULL, 1770929965, 1770929965),
(21, 'default', '{\"uuid\":\"02c443bd-90b9-459f-ac16-24f044899849\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:43;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:18:\\\"aikpef37@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770931814,\"delay\":null}', 0, NULL, 1770931814, 1770931814),
(22, 'default', '{\"uuid\":\"b84094ff-0df8-4865-a43c-c955a3d48113\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:43;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770931814,\"delay\":null}', 0, NULL, 1770931814, 1770931814),
(23, 'default', '{\"uuid\":\"35d5f944-40b5-42f8-9b9c-5a32624344ce\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:44;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:22:\\\"adelekiema30@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770933214,\"delay\":null}', 0, NULL, 1770933214, 1770933214),
(24, 'default', '{\"uuid\":\"15886ec1-920a-495b-9019-5e34be8a65e6\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:44;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770933214,\"delay\":null}', 0, NULL, 1770933214, 1770933214),
(25, 'default', '{\"uuid\":\"2f08e846-d988-4cba-a1ab-52b19e561d47\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:45;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:33:\\\"mounirou1234abdoulhayou@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770947708,\"delay\":null}', 0, NULL, 1770947708, 1770947708),
(26, 'default', '{\"uuid\":\"622f291b-fbc4-4434-9eba-e96c91c0d678\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:45;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770947708,\"delay\":null}', 0, NULL, 1770947708, 1770947708),
(27, 'default', '{\"uuid\":\"b5152069-e55c-45b9-b5de-69dc56ad0786\",\"displayName\":\"App\\\\Mail\\\\User\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\User\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:46;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:22:\\\"elvy.gotiene@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770969789,\"delay\":null}', 0, NULL, 1770969789, 1770969789),
(28, 'default', '{\"uuid\":\"9fc43a67-3541-4b06-9c14-925bd24a5d6e\",\"displayName\":\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":16:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\Admin\\\\NewUserRegistration\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:46;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"colibrilitteraire@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1770969789,\"delay\":null}', 0, NULL, 1770969789, 1770969789);

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
(43, '2026_01_19_130000_make_catalogues_required_fields_nullable', 17),
(44, '2026_01_27_230721_add_payment_columns_to_commandes_table', 18),
(45, '2026_01_27_235908_create_security_blocks_table', 19),
(46, '2026_01_28_003813_add_est_gratuit_to_formations_table', 20),
(47, '2026_01_28_004406_add_audio_and_type_contenu_to_catalogues_table', 21),
(48, '2026_02_02_045313_add_logo_cachet_to_certificats_table', 22),
(49, '2026_02_03_162032_create_roles_table', 23),
(50, '2026_02_03_162033_create_permissions_table', 23),
(51, '2026_02_03_162034_create_admins_table', 23),
(52, '2026_02_03_162034_create_role_permission_table', 23),
(53, '2026_02_03_162035_create_audit_logs_table', 23);

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
(2, 2, 'marketing traditionnel', 'Le marketing traditionnel désigne l\'ensemble des techniques de promotion utilisées avant l\'ère numérique : Publicité dans les journaux et magazines Spots radio et télévision Affiches publicitaires Flyers et prospectus Participation aux salons du livre\r\nBouche-à-oreille. \r\n\r\nCaractéristiques principales du marketing traditionnel : \r\n\r\nCommunication unidirectionnelle (de l\'entreprise vers le client)\r\nCoûts élevés et fixes \r\nDifficile à mesurer précisément\r\nPortée géographiquement limitée\r\nDélais de mise en œuvre longs', 1, '10 minutes', 1, '2026-01-17 17:17:09', '2026-01-17 17:17:09'),
(3, 2, 'Le Marketing Digital / Marketing Numérique) : outils et supports', 'Le marketing digital englobe toutes les techniques marketing utilisant les supports et canaux numériques :\r\n\r\nLe Marketing Digital (ou Marketing Numérique) :\r\n\r\nRéseaux sociaux (Facebook, Instagram, LinkedIn, TikTok)\r\n\r\nSite web et e-commerce\r\n\r\nEmail marketing (newsletters)\r\n\r\nPublicité en ligne (Google Ads, Facebook Ads)\r\n\r\nRéférencement (SEO)\r\n\r\nMarketing de contenu (blogs, vidéos)\r\n\r\nApplications mobiles', 1, '10', 1, '2026-01-17 17:24:20', '2026-01-17 17:24:20'),
(4, 2, 'Le Marketing Digital / Marketing Numérique) : Caractéristiques principales', 'les caractéristiques principales du Marketing Digital sont : \r\n\r\nCommunication bidirectionnelle (dialogue avec les clients)\r\n\r\nCoûts variables et contrôlables\r\n\r\nRésultats mesurables en temps réel\r\n\r\nPortée mondiale potentielle\r\n\r\nMise en œuvre rapide', 1, '10', 1, '2026-01-17 17:26:03', '2026-01-17 17:26:03'),
(5, 2, 'Les avantages spécifiques du marketing digital pour le secteur du livre', 'VISIBILITÉ ACCRUE :\r\nUn éditeur à Cotonou peut vendre à Abidjan, Dakar, Paris \r\nPrésence 24h/24, 7j/7 - Pas de limitation géographique\r\n\r\nCOÛT MAÎTRISÉ :\r\nBudget flexible : vous pouvez commencer avec 0 FCFA\r\nPay-per-click : vous payez uniquement quand quelqu\'un clic\r\nROI (retour sur investissement) mesurable\r\n\r\nCIBLAGE PRÉCIS :\r\nÂge, sexe, localisation géographique\r\nCentres d\'intérêt (lecture, littérature africaine, romans policiers)\r\nComportements (acheteurs en ligne, lecteurs assidus)\r\n\r\nINTERACTION DIRECTE :\r\nRépondre aux questions en temps réel\r\nCréer une communauté de lecteurs fidèles\r\nRecevoir des avis et témoignages\r\nOrganiser des événements en ligne (lives, webinaires)\r\n\r\nMESURE DES PERFORMANCES :\r\nNombre de personnes atteintes\r\nTaux d\'engagement (likes, commentaires, partages)\r\nConversions en ventes\r\nCoût par acquisition client\r\n\r\nPROMOTION DES AUTEURS :\r\nVidéos d\'interviews\r\nLectures en direct\r\nSéances de dédicaces virtuelles\r\nMise en avant des coulisses de l\'écriture', 1, '10', 1, '2026-01-17 17:30:18', '2026-01-17 17:30:18'),
(6, 2, 'Cas pratiques de réussite en Afrique', 'CAS 1 : ÉDITIONS ÉBURNIE - ABIDJAN, CÔTE D\'IVOIRE\r\nSituation initiale : Maison d\'édition méconnue, ventes limitées aux librairies partenaires\r\nAction digital : Blog littéraire +\r\ncampagnes Facebook Ads ciblées + newsletter mensuelle\r\nRésultat : 5000 abonnés newsletter, ventes directes en ligne = 40% du CA\r\n\r\n\r\nCAS 2 : AUTEUR INDÉPENDANT - MARIE KOUASSI, LOMÉ, TOGO\r\nSituation initiale : Roman auto-édité, pas de distributeur\r\nAction digital : Campagne Facebook Ads (budget 30 000 FCFA) + groupe Facebook de lecteurs\r\nRésultat : 800 exemplaires vendus en 3 mois, invitation dans des émissions radio', 1, '10', 1, '2026-01-17 17:33:00', '2026-01-17 17:33:00'),
(7, 2, 'Les 5 piliers du marketing digital', 'Dans un premier temps, nous avons LES RÉSEAUX SOCIAUX (Social Media Marketing) :\r\nUtilisation des plateformes sociales pour promouvoir vos livres, créer une communauté et interagir avec vos clients à travers plusieurs plateformes.  \r\n\r\nPrincipales plateformes : \r\n\r\nFacebook : Réseau généraliste, idéal pour créer une communauté de lecteurs.\r\nInstagram : Réseau visuel, parfait pour les couvertures de livres attractives.\r\nLinkedIn : Réseau professionnel, pour les partenariats B2B.\r\nTikTok : Réseau des jeunes, tendance BookTok très puissante.\r\nWhatsApp Business : Messagerie professionnelle pour le service client.\r\n\r\nAprès les reseaux sociaux, nous avons L\'EMAIL MARKETING : \r\nEnvoi d\'emails ciblés à une liste de contacts qui ont donné leur accord (newsletter).\r\n\r\nTypes d\'emails : Newsletter mensuelle avec nouveautés,  Emails promotionnels (réductions, offres, spéciales), Emails de bienvenue pour nouveaux abonnés, Emails d\'anniversaire avec cadeau, Rappel de panier abandonné (e-commerce).\r\n\r\nLES SITES WEB ET E-COMMERCE constituent également des supports du marketing digital.\r\nVotre propriété digitale, vitrine professionnelle ouverte 24h/24.\r\n\r\nOn distingue plusieurs types de sites : \r\n\r\nSite vitrine : Présentation de votre structure, catalogue, contact.\r\nSite e-commerce : Boutique en ligne pour vendre directement.\r\nSite institutionnel : Pour les grandes maisons d\'édition\r\n\r\nCes sites coûtent, à titre indicatif : \r\n\r\nSite vitrine simple : 100 000 - 300 000 FCFA\r\nSite e-commerce : 500 000 - 2 000 000 FCFA\r\nMaintenance : 20 000 - 50 000 FCFA/mois\r\n\r\nLES BLOGS ET MARKETING DE CONTENU :\r\nC\'est la création régulière de contenus de valeur pour attirer et fidéliser des lecteurs. \r\n\r\nTypes de contenus pour le secteur du livre :\r\n\r\nCritiques et recommandations de\r\nlivres.\r\nInterviews d\'auteurs\r\nTop 10 des livres sur un thème\r\nCoulisses de l\'édition\r\nConseils de lecture selon les prof ils\r\nActualités littéraires...\r\n\r\nPour finir, nous avons LA PUBLICITÉ EN LIGNE (SEM - Search Engine Marketing) :\r\n\r\nPublicité payante sur les plateformes digitales pour booster votre visibilité rapidement et attirer plus de personnes. Les \r\nPrincipales plateformes publicitaires utilisées sont : \r\nFacebook Ads / Instagram Ads : Publicité sur les réseaux Meta.\r\nGoogle Ads : Publicité sur le moteur de recherche Google.\r\nYouTube Ads : Publicité vidéo.\r\nLinkedIn Ads : Publicité B2B', 1, '20', 1, '2026-01-17 17:57:52', '2026-01-17 17:57:52'),
(8, 3, 'Quel réseau pour quel objectif ?', 'FACEBOOK\r\nAudience : 25-65 ans, tous profils.\r\nMeilleur pour créer une communauté, organiser des événements, service client, ventes directes.\r\nFormat : Publications avec photos, vidéos, événements. \r\nFréquence idéale : 3-5 fois / semaine\r\n\r\nLINKEDIN\r\nAudience : Professionnels, décideurs, institutions...\r\nMeilleur pour : Partenariats B2B, vente aux bibliothèques / écoles, image d\'expert.\r\nFormat star : Articles longs, partages professionnels\r\nFréquence idéale : 2-3 fois/semaine\r\n\r\nTIKTOK\r\nAudience : 16-25 ans, génération Z.\r\nMeilleur pour : BookTok, challenges, contenus décalés, toucher les jeunes.\r\nFormat star : Vidéos courtes 15 - 60 secondes\r\nFréquence idéale : 1-3 fois / jour\r\n\r\nAudience : Tous\r\nâges,\r\nparticulièrement\r\nen Af rique\r\nMeilleur pour :\r\nService client,\r\ncommandes,\r\nconf irmations,\r\ncatalogue produits\r\nFormat star :\r\nMessages directs,\r\ncatalogues\r\nFréquence : Selon\r\ndemandes clients\r\n\r\nWHATSAPP BUSINESS\r\nAudience : Tous âges, particulièrement en Afrique\r\nMeilleur pour : Service client, commandes, confirmations, catalogue produits\r\nFormat star : Messages directs, catalogues\r\nFréquence : Selon demandes clients', 1, '10', 1, '2026-01-17 18:21:05', '2026-01-17 18:21:05'),
(9, 3, 'Facebook pour les professionnels du livre', 'POURQUOI FACEBOOK EST INCONTOURNABLE EN AFRIQUE\r\nCHIFFRES CLÉS :\r\n2,9 milliards d\'utilisateurs dans le monde\r\n40% de pénétration en Afrique subsaharienne\r\nRéseau n°1 en Afrique francophone\r\n2h24 de temps passé quotidiennement en\r\nmoyenne.\r\n\r\nAVANTAGES SPÉCIFIQUES POUR LE LIVRE :\r\nCréation de groupes de lecteurs\r\nOrganisation d\'événements (dédicaces,\r\nlancements)\r\nFacebook Shop pour vendre directement\r\nPublicité très ciblée et abordable\r\nInteraction immédiate avec les lecteurs\r\n\r\nLES DIFFÉRENTS TYPES DE PRÉSENCE SUR FACEBOOK :\r\n\r\nLE PROFIL PERSONNEL (NON RECOMMANDÉ POUR ENTREPRISE)\r\nLimité à 5000 amis\r\nPas d\'outils professionnels\r\nRisque de mélanger pro et perso\r\n\r\nLA PAGE PROFESSIONNELLE (RECOMMANDÉ)\r\nNombre illimité de followers\r\nStatistiques détaillées\r\nPossibilité de faire de la publicité\r\nBoutons d\'action (Appeler, Envoyer un\r\nmessage, Réserver)\r\nCrédibilité professionnelle\r\n\r\nLE GROUPE FACEBOOK (COMPLÉMENTAIRE)\r\nCréation de communauté engagée\r\nDiscussions entre membres\r\nParfait pour \"Club de lecture\" ou \"Amis de notre librairie\r\n\r\nCréer une page Facebook efficace :\r\nÉléments indispensables :\r\nPHOTO DE PROFIL :\r\nLogo de votre maison d\'édition / librairie\r\nFormat : carré, 180x180 pixels minimum\r\nPHOTO DE COUVERTURE :\r\nDimension : 820x312 pixels\r\nChanger régulièrement (nouveautés, événements)\r\nÉviter texte trop petit (illisible sur mobile)\r\nÀ PROPOS :\r\nDescription claire en 1-2 paragraphes\r\nInclure mots-clés (librairie, édition, livres\r\nafricains)\r\nMentionner votre spécialité\r\n\r\nINFORMATIONS DE CONTACT :\r\nAdresse physique complète\r\nNuméro de téléphone\r\nWhatsApp Business\r\nSite web - Email -\r\nHoraires d\'ouverture\r\n\r\nBOUTON D\'ACTION\r\nEnvoyer un message\" (WhatsApp)\r\n\"Appeler maintenant\" - \"Réserver\"\r\n(pour événements)\r\n\"Acheter\" (si boutique en ligne)\r\n\r\nStratégie de contenu Facebook.\r\nLA RÈGLE 80-20;\r\n80% DE CONTENUS DE VALEUR (GRATUITS, NON PROMOTIONNELS) : extraits de livres inspirants, citations d\'auteurs, conseils de lecture, culture générale littéraire, quiz et sondages, témoignages de lecteurs\r\n20% DE CONTENU PROMOTIONNEL : Annonce de nouveautés, promotions et réductions, événements commerciaux, appels à l\'achat directs', 1, '15', 1, '2026-01-17 18:31:57', '2026-01-17 18:31:57'),
(10, 3, 'LINKEDIN POUR LES PROFESSIONNELS DU LIVRE', 'Pourquoi LinkedIn est différent de Facebook\r\n\r\nLinkedIn n\'est PAS Facebook !\r\n\r\nDifférences fondamentales :\r\nFACEBOOK : Social, personnel ; Décontracté, émotionnel ; Divertissement,\r\nlifestyle ; B2C (grand public); Court, visuel\r\nLINKEDIN : Professionnel, expert, business ; Expertise, analyse, réflexion ;\r\nB2B (professionnels) ; Long, approfondi\r\nERREUR COURANTE : Publier exactement le même contenu sur Facebook et LinkedIn. ❌\r\n\r\nÀ quoi sert LinkedIn pour votre activité ?\r\n\r\nDÉVELOPPER DES PARTENARIATS B2B\r\nVendre aux bibliothèques municipales\r\nPartenariats avec les écoles et universités\r\nCollaborations avec d\'autres éditeurs\r\nContacts avec des distributeurs internationaux\r\nRelations avec médias et journalistes\r\n\r\nRECRUTER DES TALENTS\r\nÉditeurs, Commerciaux, Graphistes\r\nTraducteurs, Correcteurs\r\n\r\nÉTABLIR VOTRE CRÉDIBILITÉ D\'EXPERT\r\nPublier des analyses sur le marché du livre en Afrique, Partager vos réflexions sur l\'édition, Démontrer votre expertise du secteur\r\nAttirer l\'attention de décideurs,\r\n\r\nVEILLE SECTORIELLE\r\nSuivre les tendances de l\'édition mondiale\r\nS\'inspirer des best practices\r\nRester informé des innovations\r\n\r\nOptimiser son profil LinkedIn\r\nPHOTO DE PROFIL\r\nPhoto professionnelle : Fond neutre - Sourire - Vêtements\r\nprofessionnels - Visage bien visible\r\nPhoto de bannière : 1584 x 396 pixels - Représenter votre activité - Livres, librairie, auteurs - Peut inclure slogan ou\r\naccroche,\r\nTitre professionnel (sous votre nom) : Maximum 120 caractères - Inclure mots-clés - Être explicite\r\nMauvais exemple : \"Directeur chez ABC Éditions\"\r\nBon exemple : \"Directeur éditorial | Spécialiste littérature africaine francophone | 15 ans d\'expérience édition jeunesse\"\r\nRésumé (section À propos) : 2-3 paragraphes maximum - Parler de votre passion pour le livre - Mentionner votre expertise - Inclure réalisations concrètes - Terminer par un appel à l\'action\r\n\r\nExemple de résumé efficace : Passionné par la promotion de la littérature africaine depuis plus de 10 ans, je dirige XYZ Éditions, maison spécialisée dans la publication d\'auteurs émergents d\'Afrique francophone. Nous avons publié plus de 50 titres qui touchent des lecteurs dans 15 pays.\r\n\r\nNotre mission : faire rayonner les voix africaines à l\'international tout en rendant la lecture accessible localement. Toujours à la recherche de partenariats avec bibliothèques, institutions éducatives et distributeurs pour élargir notre impact.\r\nContactez-moi pour discuter collaborations : email@example.com\r\n\r\nExpérience professionnelle : Détailler vos fonctions actuelles et passées - Utiliser des\r\nbullet points - Quantifier vos réalisations (chiffres) -\r\nInclure mots-clés du secteur\r\n\r\nCompétences : Ajouter 10-15 compétences pertinentes\r\nEx: Édition, Distribution, Marketing du livre, Négociation droits d\'auteur\r\n- Demander des recommandations à vos contacts', 1, '10', 1, '2026-01-17 18:42:36', '2026-01-17 18:46:42'),
(17, 7, 'Les bases du droit d\'auteur en littérature', '1- (Définition et principes fondamentaux)\r\n« Le droit d\'auteur, c\'est tout simplement l\'ensemble des règles qui protègent les œuvres de l\'esprit.Dès qu\'une personne écrit un texte original - un roman, un manuel scolaire, un poème, un essai - cette œuvre est automatiquement protégée par le droit d\'auteur.\r\n- Il n\'y a pas besoin de dépôt préalable pour que la protection existe.\r\n- Dans l\'espace OAPI, cette protection est organisée par l\'Annexe VII de l\'Accord de Bangui.\r\n- Le principe fondamental, c\'est que l\'auteur doit garder le contrôle sur l\'utilisation de son œuvre et pouvoir en tirer une rémunération\r\n\r\n2-Œuvres protégées dans le domaine littéraire\r\n\r\n« Dans le domaine littéraire, sont protégés tous les textes dès lors qu\'ils sont originaux.Cela inclut les romans, les nouvelles, la poésie, les pièces de théâtre, les essais, les manuels scolaires, les livres scientifiques ou pédagogiques.\r\n- Un point très important : la protection ne dépend pas du support.\r\n- Un texte est protégé qu\'il soit imprimé sur papier, diffusé en PDF, publié en ligne ou partagé sous forme numérique.\r\n- Le passage au numérique ne fait pas perdre les droits de l\'auteur. »\r\n\r\n3- Titulaire des droits : qui possède les droits ?\r\n\r\n« Le titulaire des droits, c\'est en principe l\'auteur, c\'est-à-dire la personne physique qui a créé l\'œuvre.\r\n- Même lorsqu\'un éditeur publie le livre, l\'auteur reste titulaire de ses droits, sauf pour ceux qu\'il a expressément cédés par contrat.\r\n- L\'éditeur n\'est donc pas automatiquement propriétaire de l\'œuvre : il exploite les droits que l\'auteur lui a accordés.\r\n- Après le décès de l\'auteur, les droits sont transmis aux ayants droit, souvent les héritiers.\r\n- C\'est pourquoi il est important de bien comprendre à qui appartiennent les droits à chaque étape de la chaîne du livre. »\r\n\r\nLes droits de l\'auteur : une double protection\r\n\r\n« Le droit d\'auteur repose sur deux grandes catégories de droits : les droits moraux et les droits patrimoniaux.Ces deux types de droits sont complémentaires. »\r\n\r\n4- Les droits moraux\r\n(Paternité, respect de l\'œuvre)\r\n\r\n« Les droits moraux protègent le lien personnel entre l\'auteur et son œuvre.\r\n- Le premier, c\'est le droit à la paternité : le nom de l\'auteur doit toujours être mentionné.\r\n- Le second, c\'est le droit au respect de l\'œuvre : on ne peut pas modifier un texte, le tronquer ou le dénaturer sans l\'accord de l\'auteur.\r\n- Ces droits sont très forts : ils sont inaliénables, ce qui signifie que l\'auteur ne peut pas les vendre, et ils sont perpétuels, même après sa mort. »\r\n\r\n5- Les droits patrimoniaux\r\n(Reproduction, diffusion, adaptation)\r\n« Les droits patrimoniaux sont les droits économiques de l\'auteur.\r\n- Ils concernent toutes les formes d\'exploitation de l\'œuvre : la reproduction, par exemple l\'impression ou la numérisation ; la diffusion, comme la vente, le prêt ou la mise en ligne ; et l\'adaptation, par exemple une traduction ou une transformation en autre format.\r\n- Ce sont ces droits qui permettent à l\'auteur et à l\'éditeur de générer des revenus.\r\n- Toute utilisation de l\'œuvre sans autorisation sur ces aspects constitue une atteinte au droit d\'auteur. »\r\n\r\n6- La durée de protection\r\n« La protection par le droit d\'auteur n\'est pas éternelle, mais elle est longue.\r\n- En règle générale, l\'œuvre est protégée pendant toute la vie de l\'auteur, puis pendant plusieurs années après son décès. 50-70 ans en général,\r\n- Pendant cette période, toute exploitation doit être autorisée par l\'auteur ou ses ayants droit.\r\n- Une fois ce délai écoulé, l\'œuvre entre dans le domaine public et peut être utilisée librement, ce qui ouvre de nouvelles opportunités pour les éditeurs et les acteurs du livre. »', 1, '30 minutes', 1, '2026-02-07 10:25:50', '2026-02-07 10:41:13'),
(18, 7, 'Les défis du numérique pour les droits d’auteur dans le domaine littéraire', '« Le numérique a profondément transformé la manière dont les livres circulent aujourd’hui. En quelques minutes, un livre peut être scanné, transformé en PDF et partagé à grande échelle. On voit très souvent des livres édités circuler sous forme de PDF, parfois quelques jours ou quelques semaines seulement après leur sortie officielle. »', 1, '30 minutes', 1, '2026-02-09 10:53:22', '2026-02-09 10:53:22'),
(19, 7, 'Partage, accès à la culture et exceptions', 'Jusqu’ici, nous avons beaucoup parlé de protection, de droits et de piratage. Mais le droit d’auteur n’est pas là pour empêcher l’accès à la culture. Il cherche au contraire à trouver un équilibre entre la protection des créateurs et le partage des savoirs. C’est dans cet esprit que la loi prévoit des exceptions et des mécanismes de diffusion contrôlée.', 1, '30 Minutes', 1, '2026-02-09 11:30:19', '2026-02-09 11:56:52'),
(20, 7, 'Innover et sécuriser le marché du livre africain', 'Après avoir analysé les risques, les défis et les contraintes juridiques, il est temps de se poser une question essentielle : comment innover sans fragiliser davantage le marché du livre africain ? La protection du droit d’auteur n’a de sens que si elle s’accompagne de modèles économiques adaptés à nos réalités.', 1, '30 Minutes', 1, '2026-02-09 11:55:12', '2026-02-09 11:56:39'),
(21, 8, 'Les fondements du partenariat gagnant-gagnant', 'Ce module présente le concept de partenariat gagnant-gagnant comme une collaboration équilibrée dans laquelle chaque partie tire des bénéfices réels tout en contribuant activement à l’atteinte d’un objectif commun. Il met en avant les valeurs fondamentales nécessaires à la réussite d’une coopération durable : transparence, confiance, clarification des objectifs et respect des engagements.\r\n\r\nÀ travers l’exemple concret de la collaboration entre éditeurs, diffuseurs et plateformes locales pour promouvoir la visibilité des auteurs africains, le texte illustre comment des partenariats bien structurés peuvent générer des retombées positives pour tous les acteurs et assurer la pérennité des projets.\r\n\r\nEnfin, il propose cinq règles d’or pratiques pour réussir tout partenariat : formaliser les accords, communiquer en amont, garantir l’équité, évaluer régulièrement les actions et célébrer les succès afin de renforcer la motivation et la cohésion entre partenaires.', 1, '20 Minutes', 1, '2026-02-11 04:51:58', '2026-02-11 04:51:58'),
(22, 8, 'Synergie d’actions saine et fructueuse', 'L’objectif principal est de montrer comment les efforts combinés peuvent produire des résultats supérieurs à ceux obtenus individuellement, tout en renforçant la crédibilité et la durabilité des projets.', 1, '20 Minutes', 1, '2026-02-11 05:08:58', '2026-02-11 05:08:58'),
(23, 8, 'Construire un réseau professionnel solide', 'Ce module met en avant la logique progressive (identification → cartographie → entretien → exploitation numérique) et l’importance de la complémentarité et de l’interaction pour développer un réseau efficace.', 1, '20 Minutes', 1, '2026-02-11 05:17:53', '2026-02-11 05:17:53'),
(24, 8, 'Les obstacles à éviter dans un partenariat', 'Le module souligne que la communication, la fiabilité, l’équilibre et la coopération constructive sont des piliers essentiels pour une collaboration efficace et durable.', 1, '20 Minutes', 1, '2026-02-11 05:28:09', '2026-02-11 05:28:09'),
(25, 9, 'Comprendre le marché et ses spécificités', 'Ce module analyse le marché du livre audio et numérique, en mettant en lumière ses groupes cibles, habitudes de consommation, plateformes principales, initiatives locales en Afrique et obstacles à son développement. Malgré ces obstacles, le marché du livre numérique offre un terrain vierge d’opportunités. Le numérique n’élimine pas le livre, il étend son champ de vie, en permettant un accès plus large et inclusif à la culture.', 1, '40 Minutes', 1, '2026-02-11 06:28:45', '2026-02-11 06:29:36'),
(26, 9, 'Déconstruire les préjugés', 'Le module met en lumière les préjugés fréquents et propose de réponses adaptées.', 1, '20 Minutes', 1, '2026-02-11 06:38:41', '2026-02-11 07:20:18'),
(27, 9, 'Les dynamiques économiques', 'Le module présente l’écosystème du livre audio et numérique, en détaillant les acteurs, les modèles économiques, les niches prometteuses et les tendances actuelles.\r\nLe secteur du livre audio repose sur un écosystème collaboratif où acteurs, modèles économiques et niches spécifiques interagissent pour créer de la valeur culturelle et économique.', 1, '30 Minutes', 1, '2026-02-11 06:50:13', '2026-02-11 06:50:13'),
(28, 9, 'Innover et entreprendre', 'Le module explore les nouvelles niches à développer dans le secteur du livre et de l’audio numérique, ainsi que les outils innovants permettant d’améliorer l’expérience utilisateur. \r\nIl met l’accent sur la créativité et l’innovation technologique pour développer des formats immersifs, accessibles et adaptés aux besoins locaux, tout en valorisant l’éducation et la culture.', 1, '40 Minutes', 1, '2026-02-11 06:59:13', '2026-02-11 06:59:13'),
(29, 9, 'Inclusion et accessibilité', 'Le module met l’accent sur le rôle social et culturel du livre audio et numérique, en soulignant l’inclusion, l’innovation et les partenariats stratégiques.\r\nIl montre que les livres audio et numériques, loin d’être marginaux, sont des leviers d’avenir, où innovation, inclusion et culture se rencontrent pour créer des projets impactants et accessibles.', 1, '20 Minutes', 1, '2026-02-11 07:12:19', '2026-02-11 07:12:19'),
(30, 10, 'Origines et évolution de l’IA', 'Le document présente une frise chronologique de l’évolution de l’intelligence artificielle (IA) depuis les années 1950 jusqu’aux années 2020. Il met en évidence les principales phases de développement, les avancées technologiques majeures ainsi que les périodes d’enthousiasme et de recul.\r\nL’ensemble montre que l’IA s’est construite par cycles d’innovations, de limites et de relances, jusqu’à son rôle central actuel.', 1, '20 Minutes', 1, '2026-02-18 04:20:29', '2026-02-18 04:20:29'),
(31, 10, 'Applications et évolution des métiers', 'Ce module illustre l’impact de l’intelligence artificielle sur les métiers et les organisations à travers une comparaison entre les pratiques avant l’IA et celles avec l’IA. Il montre que l’IA agit à trois niveaux complémentaires : usages transverses, transformation des métiers et automatisation des processus.\r\n\r\nD’une part, des outils généralistes comme Gemini, ChatGPT ou Mistral permettent un usage transversal dans de nombreux domaines (rédaction, analyse, assistance). D’autre part, l’IA spécialisée transforme les métiers en facilitant la production de code, la rédaction de documents ou l’utilisation d’outils métiers intelligents. Enfin, l’automatisation permet de déléguer certaines tâches répétitives, notamment dans le service client ou le reporting.\r\nDans l’ensemble, le document montre que l’IA ne remplace pas seulement les tâches humaines : elle modifie les méthodes de travail, améliore la prise de décision et augmente l’efficacité dans de nombreux secteurs.', 1, '45 Minutes', 1, '2026-02-18 04:34:41', '2026-02-18 04:48:54'),
(32, 10, 'Les métiers du livre et l’IA', 'Ce module présente l’impact de l’intelligence artificielle sur l’ensemble de la chaîne du livre, depuis la création par l’auteur jusqu’à la vente au lecteur. Il montre que l’IA n’agit pas sur un seul métier, mais transforme progressivement toutes les étapes : écriture, édition, fabrication, distribution et commercialisation.\r\nDans l’ensemble, le module montre que l’IA agit comme un outil d’optimisation, de créativité et d’aide à la décision tout au long de la chaîne du livre, sans se limiter à la seule écriture.', 1, '45 Minutes', 1, '2026-02-18 04:48:35', '2026-02-18 04:48:35'),
(33, 10, 'Enjeux sociaux et éthiques', 'Ce module met en lumière la nécessité d’encadrer le développement de l’intelligence artificielle par des politiques publiques et des règles éthiques, afin d’en maximiser les bénéfices tout en limitant ses risques pour la société.\r\nGlobalement, le module insiste sur l’idée que l’IA n’est pas seulement une question technologique : c’est un enjeu juridique, social, éthique et environnemental qui nécessite une gouvernance adaptée.', 1, '45 Minutes', 1, '2026-02-18 04:55:17', '2026-02-18 04:55:17');

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
-- Structure de la table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `action` enum('view','create','update','delete','export','manage') NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `module`, `action`, `description`, `created_at`, `updated_at`) VALUES
(1, 'dashboard.view', 'dashboard', 'view', 'View dashboard', '2026-02-08 21:04:09', '2026-02-08 21:04:09'),
(2, 'users.view', 'users', 'view', 'View users', '2026-02-08 21:04:09', '2026-02-08 21:04:09'),
(3, 'users.create', 'users', 'create', 'Create users', '2026-02-08 21:04:09', '2026-02-08 21:04:09'),
(4, 'users.update', 'users', 'update', 'Update users', '2026-02-08 21:04:09', '2026-02-08 21:04:09'),
(5, 'users.delete', 'users', 'delete', 'Delete users', '2026-02-08 21:04:10', '2026-02-08 21:04:10'),
(6, 'users.manage', 'users', 'manage', 'Manage users', '2026-02-08 21:04:10', '2026-02-08 21:04:10'),
(7, 'catalogue.view', 'catalogue', 'view', 'View catalogue', '2026-02-08 21:04:10', '2026-02-08 21:04:10'),
(8, 'catalogue.create', 'catalogue', 'create', 'Create catalogue', '2026-02-08 21:04:10', '2026-02-08 21:04:10'),
(9, 'catalogue.update', 'catalogue', 'update', 'Update catalogue', '2026-02-08 21:04:10', '2026-02-08 21:04:10'),
(10, 'catalogue.delete', 'catalogue', 'delete', 'Delete catalogue', '2026-02-08 21:04:10', '2026-02-08 21:04:10'),
(11, 'emprunts.view', 'emprunts', 'view', 'View emprunts', '2026-02-08 21:04:10', '2026-02-08 21:04:10'),
(12, 'emprunts.create', 'emprunts', 'create', 'Create emprunts', '2026-02-08 21:04:10', '2026-02-08 21:04:10'),
(13, 'emprunts.update', 'emprunts', 'update', 'Update emprunts', '2026-02-08 21:04:10', '2026-02-08 21:04:10'),
(14, 'emprunts.delete', 'emprunts', 'delete', 'Delete emprunts', '2026-02-08 21:04:10', '2026-02-08 21:04:10'),
(15, 'emprunts.manage', 'emprunts', 'manage', 'Manage emprunts', '2026-02-08 21:04:10', '2026-02-08 21:04:10'),
(16, 'commandes.view', 'commandes', 'view', 'View commandes', '2026-02-08 21:04:10', '2026-02-08 21:04:10'),
(17, 'commandes.update', 'commandes', 'update', 'Update commandes', '2026-02-08 21:04:10', '2026-02-08 21:04:10'),
(18, 'commandes.manage', 'commandes', 'manage', 'Manage commandes', '2026-02-08 21:04:10', '2026-02-08 21:04:10'),
(19, 'formations.view', 'formations', 'view', 'View formations', '2026-02-08 21:04:10', '2026-02-08 21:04:10'),
(20, 'formations.create', 'formations', 'create', 'Create formations', '2026-02-08 21:04:11', '2026-02-08 21:04:11'),
(21, 'formations.update', 'formations', 'update', 'Update formations', '2026-02-08 21:04:11', '2026-02-08 21:04:11'),
(22, 'formations.delete', 'formations', 'delete', 'Delete formations', '2026-02-08 21:04:11', '2026-02-08 21:04:11'),
(23, 'modules.view', 'modules', 'view', 'View modules', '2026-02-08 21:04:11', '2026-02-08 21:04:11'),
(24, 'modules.create', 'modules', 'create', 'Create modules', '2026-02-08 21:04:11', '2026-02-08 21:04:11'),
(25, 'modules.update', 'modules', 'update', 'Update modules', '2026-02-08 21:04:11', '2026-02-08 21:04:11'),
(26, 'modules.delete', 'modules', 'delete', 'Delete modules', '2026-02-08 21:04:11', '2026-02-08 21:04:11'),
(27, 'quizzes.view', 'quizzes', 'view', 'View quizzes', '2026-02-08 21:04:11', '2026-02-08 21:04:11'),
(28, 'quizzes.create', 'quizzes', 'create', 'Create quizzes', '2026-02-08 21:04:11', '2026-02-08 21:04:11'),
(29, 'quizzes.update', 'quizzes', 'update', 'Update quizzes', '2026-02-08 21:04:11', '2026-02-08 21:04:11'),
(30, 'quizzes.delete', 'quizzes', 'delete', 'Delete quizzes', '2026-02-08 21:04:11', '2026-02-08 21:04:11'),
(31, 'certifications.view', 'certifications', 'view', 'View certifications', '2026-02-08 21:04:12', '2026-02-08 21:04:12'),
(32, 'certifications.create', 'certifications', 'create', 'Create certifications', '2026-02-08 21:04:12', '2026-02-08 21:04:12'),
(33, 'certifications.manage', 'certifications', 'manage', 'Manage certifications', '2026-02-08 21:04:12', '2026-02-08 21:04:12'),
(34, 'contacts.view', 'contacts', 'view', 'View contacts', '2026-02-08 21:04:12', '2026-02-08 21:04:12'),
(35, 'contacts.update', 'contacts', 'update', 'Update contacts', '2026-02-08 21:04:12', '2026-02-08 21:04:12'),
(36, 'contacts.delete', 'contacts', 'delete', 'Delete contacts', '2026-02-08 21:04:12', '2026-02-08 21:04:12'),
(37, 'testimonials.view', 'testimonials', 'view', 'View testimonials', '2026-02-08 21:04:12', '2026-02-08 21:04:12'),
(38, 'testimonials.update', 'testimonials', 'update', 'Update testimonials', '2026-02-08 21:04:12', '2026-02-08 21:04:12'),
(39, 'testimonials.delete', 'testimonials', 'delete', 'Delete testimonials', '2026-02-08 21:04:12', '2026-02-08 21:04:12'),
(40, 'blog.view', 'blog', 'view', 'View blog', '2026-02-08 21:04:12', '2026-02-08 21:04:12'),
(41, 'blog.create', 'blog', 'create', 'Create blog', '2026-02-08 21:04:12', '2026-02-08 21:04:12'),
(42, 'blog.update', 'blog', 'update', 'Update blog', '2026-02-08 21:04:12', '2026-02-08 21:04:12'),
(43, 'blog.delete', 'blog', 'delete', 'Delete blog', '2026-02-08 21:04:12', '2026-02-08 21:04:12'),
(44, 'team.view', 'team', 'view', 'View team', '2026-02-08 21:04:12', '2026-02-08 21:04:12'),
(45, 'team.create', 'team', 'create', 'Create team', '2026-02-08 21:04:13', '2026-02-08 21:04:13'),
(46, 'team.update', 'team', 'update', 'Update team', '2026-02-08 21:04:13', '2026-02-08 21:04:13'),
(47, 'team.delete', 'team', 'delete', 'Delete team', '2026-02-08 21:04:13', '2026-02-08 21:04:13'),
(48, 'security.view', 'security', 'view', 'View security', '2026-02-08 21:04:13', '2026-02-08 21:04:13'),
(49, 'security.manage', 'security', 'manage', 'Manage security', '2026-02-08 21:04:13', '2026-02-08 21:04:13');

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
(4, 7, 'Une protection juridique automatique pour toute œuvre originale de l’esprit dès sa mise en forme concrète sans formalité préalable', 1, 1, '2026-02-07 11:24:14', '2026-02-07 11:24:14'),
(5, 7, 'Une protection juridique conditionnelle uniquement pour les œuvres déclarées après enregistrement officiel auprès d’une autorité compétente avec formalités administratives obligatoires', 0, 2, '2026-02-07 11:24:14', '2026-02-07 11:24:14'),
(6, 2, 'Vrai', 0, 1, '2026-02-08 21:50:51', '2026-02-08 21:50:51'),
(7, 2, 'Faux', 1, 2, '2026-02-08 21:50:51', '2026-02-08 21:50:51'),
(8, 3, 'Utilise la publicité dans les journaux, la radio et la télévision', 1, 1, '2026-02-08 21:50:51', '2026-02-08 21:50:51'),
(9, 3, 'Est une communication unidirectionnelle avec des coûts élevés', 1, 2, '2026-02-08 21:50:51', '2026-02-08 21:50:51'),
(10, 3, 'Permet une interaction directe et instantanée avec les clients', 0, 3, '2026-02-08 21:50:51', '2026-02-08 21:50:51'),
(11, 3, 'A une portée géographiquement limitée', 1, 4, '2026-02-08 21:50:51', '2026-02-08 21:50:51'),
(12, 4, 'Vrai', 0, 1, '2026-02-08 21:50:51', '2026-02-08 21:50:51'),
(13, 4, 'Faux', 1, 2, '2026-02-08 21:50:51', '2026-02-08 21:50:51'),
(14, 5, 'Vrai', 0, 1, '2026-02-08 21:50:51', '2026-02-08 21:50:51'),
(15, 5, 'Faux', 1, 2, '2026-02-08 21:50:51', '2026-02-08 21:50:51'),
(16, 6, 'Communication bidirectionnelle et résultats mesurables en temps réel', 1, 1, '2026-02-08 21:50:51', '2026-02-08 21:50:51'),
(17, 6, 'Coûts variables et contrôlables avec une portée mondiale', 1, 2, '2026-02-08 21:50:51', '2026-02-08 21:50:51'),
(18, 6, 'Communication unidirectionnelle avec des coûts fixes élevés', 0, 3, '2026-02-08 21:50:51', '2026-02-08 21:50:51'),
(19, 6, 'Mise en œuvre rapide', 1, 4, '2026-02-08 21:50:51', '2026-02-08 21:50:51'),
(24, 9, 'La cession des droits doit se faire par contrat écrit', 1, 1, '2026-02-09 10:37:12', '2026-02-09 10:37:12'),
(25, 9, 'En édition classique, l’auteur perd définitivement tous ses droits', 0, 2, '2026-02-09 10:37:12', '2026-02-09 10:37:12'),
(26, 9, 'La reproduction d’un livre n’a pas de conséquences juridiques', 0, 3, '2026-02-09 10:37:12', '2026-02-09 10:37:12'),
(27, 9, 'Les exceptions permettent de copier librement tout ouvrage', 0, 4, '2026-02-09 10:37:12', '2026-02-09 10:37:12'),
(28, 8, 'Protéger l’auteur tout en permettant l’exploitation économique de l’œuvre', 1, 1, '2026-02-09 10:38:34', '2026-02-09 10:38:34'),
(29, 8, 'Protéger uniquement les éditeurs', 0, 2, '2026-02-09 10:38:34', '2026-02-09 10:38:34'),
(30, 8, 'Permettre uniquement la vente des œuvres', 0, 3, '2026-02-09 10:38:34', '2026-02-09 10:38:34'),
(31, 8, 'Interdire toute diffusion', 0, 4, '2026-02-09 10:38:34', '2026-02-09 10:38:34'),
(32, 10, 'Trouver un équilibre entre l’accès à la culture, la protection des créateurs et une innovation durable.', 1, 1, '2026-02-09 11:20:18', '2026-02-09 11:20:18'),
(33, 10, 'Favoriser uniquement la diffusion massive des œuvres numériques, sans tenir compte des droits des créateurs ni des impacts à long terme sur le secteur culturel.', 0, 2, '2026-02-09 11:20:18', '2026-02-09 11:20:18'),
(34, 10, 'Donner la priorité à l’accès le plus large possible aux œuvres numériques, tout en considérant que la protection des créateurs et l’innovation s’ajusteront naturellement avec le temps.', 0, 3, '2026-02-09 11:20:18', '2026-02-09 11:20:18'),
(37, 11, 'Le droit d’auteur protège les créateurs tout en garantissant l’accès du public aux œuvres dans l’intérêt général.', 1, 1, '2026-02-09 11:51:55', '2026-02-09 11:51:55'),
(38, 11, 'Le droit d’auteur vise avant tout à protéger les créateurs, même si cela réduit l’accès du public aux œuvres.', 0, 2, '2026-02-09 11:51:55', '2026-02-09 11:51:55'),
(41, 12, 'La protection du droit d’auteur doit s’accompagner de modèles économiques adaptés au contexte africain, afin de favoriser l’innovation sans fragiliser le marché.', 1, 1, '2026-02-09 12:12:13', '2026-02-09 12:12:13'),
(42, 12, 'Le droit d’auteur doit être strictement appliqué, même si cela bloque l’accès des lecteurs aux livres.', 0, 2, '2026-02-09 12:12:13', '2026-02-09 12:12:13'),
(45, 13, 'La coopération régionale et le respect du droit d’auteur sont essentiels pour construire un marché du livre africain solide et durable.', 1, 1, '2026-02-09 12:32:56', '2026-02-09 12:32:56'),
(46, 13, 'Chaque pays doit se concentrer uniquement sur son marché national et ignorer les pratiques et cadres juridiques des autres pays.', 0, 2, '2026-02-09 12:32:56', '2026-02-09 12:32:56'),
(47, 14, 'Parce que la formalisation clarifie les attentes, définit les responsabilités de chaque partie, prévient les malentendus et garantit une collaboration équitable et durable.', 1, 1, '2026-02-11 04:59:36', '2026-02-11 04:59:36'),
(48, 14, 'Parce qu’un partenariat efficace repose uniquement sur la confiance informelle, sans besoin d’accords écrits ni de règles précises.', 0, 2, '2026-02-11 04:59:36', '2026-02-11 04:59:36'),
(49, 15, 'Une synergie efficace transforme les efforts individuels en succès collectif et augmente la durabilité des projets.', 1, 1, '2026-02-11 05:12:58', '2026-02-11 05:12:58'),
(50, 15, 'Une synergie efficace consiste uniquement à partager les responsabilités sans viser de résultats tangibles.', 0, 2, '2026-02-11 05:12:58', '2026-02-11 05:12:58'),
(51, 16, 'Identifier ses partenaires stratégiques selon leurs compétences et leur complémentarité.', 1, 1, '2026-02-11 05:22:28', '2026-02-11 05:22:28'),
(52, 16, 'Exploiter les outils numériques et plateformes collaboratives pour structurer le réseau.', 0, 2, '2026-02-11 05:22:28', '2026-02-11 05:22:28'),
(53, 17, 'Il entraîne des malentendus, des frustrations et ralentit la progression des projets.', 1, 1, '2026-02-11 05:31:16', '2026-02-11 05:31:16'),
(54, 17, 'Il favorise la créativité et accélère la prise de décision.', 0, 2, '2026-02-11 05:31:16', '2026-02-11 05:31:16'),
(55, 18, 'Ils offrent un accès autonome à la littérature et facilitent la lecture malgré leurs difficultés visuelles ou de lecture.', 1, 1, '2026-02-11 06:33:29', '2026-02-11 06:33:29'),
(56, 18, 'Ils remplacent complètement le livre papier et empêchent l’apprentissage de la lecture.', 0, 2, '2026-02-11 06:33:29', '2026-02-11 06:33:29'),
(57, 19, 'Vrai', 0, 1, '2026-02-11 06:44:48', '2026-02-11 06:44:48'),
(58, 19, 'Faux', 1, 2, '2026-02-11 06:44:48', '2026-02-11 06:44:48'),
(59, 20, 'Ils apportent la dimension émotionnelle et technique, rendant le récit immersif et vivant.', 1, 1, '2026-02-11 06:53:39', '2026-02-11 06:53:39'),
(60, 20, 'Ils se contentent de lire le texte sans contribution créative ou technique.', 0, 2, '2026-02-11 06:53:39', '2026-02-11 06:53:39'),
(61, 21, 'Ils combinent texte, son et animation, offrant une expérience sensorielle complète.', 1, 1, '2026-02-11 07:03:36', '2026-02-11 07:03:36'),
(62, 21, 'Ils remplacent totalement la lecture traditionnelle et éliminent le besoin d’apprendre à lire.', 0, 2, '2026-02-11 07:03:36', '2026-02-11 07:03:36'),
(63, 22, 'Ils permettent de promouvoir l’inclusion culturelle et de rendre ces formats accessibles à tous, en particulier aux publics empêchés.', 1, 1, '2026-02-11 07:15:32', '2026-02-11 07:15:32'),
(64, 22, 'Ils sont uniquement utiles pour réduire les coûts de production.', 0, 2, '2026-02-11 07:15:32', '2026-02-11 07:15:32'),
(65, 23, 'Les années 2000 et 2010.', 1, 1, '2026-02-18 04:26:32', '2026-02-18 04:26:32'),
(66, 23, 'Les années 1990.', 0, 2, '2026-02-18 04:26:32', '2026-02-18 04:26:32'),
(67, 24, 'L’automatisation des tâches répétitives et l’aide à la décision grâce à l’analyse de données.', 1, 1, '2026-02-18 04:37:33', '2026-02-18 04:37:33'),
(68, 24, 'La suppression totale du travail humain dans tous les secteurs.', 0, 2, '2026-02-18 04:37:33', '2026-02-18 04:37:33'),
(69, 25, 'Elle améliore et optimise chaque étape, de la création à la vente grâce à l’automatisation, l’analyse de données et l’assistance aux professionnels.', 1, 1, '2026-02-18 04:51:45', '2026-02-18 04:51:45'),
(70, 25, 'Elle remplace entièrement tous les métiers du livre et rend les professionnels inutiles.', 0, 2, '2026-02-18 04:51:45', '2026-02-18 04:51:45'),
(71, 26, 'Pour protéger les individus, garantir un usage responsable de l’IA et limiter ses impacts négatifs sur la société et l’environnement.', 1, 1, '2026-02-18 04:57:33', '2026-02-18 04:57:33'),
(72, 26, 'Pour empêcher totalement l’utilisation de l’IA et bloquer toute innovation technologique.', 0, 2, '2026-02-18 04:57:33', '2026-02-18 04:57:33');

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
(2, 2, 2, 'Les différents types de marketing', 'Marketing appliqué à la chaine du livre', 2, 100, 3, 1, 0, 0, 1, '2026-01-17 18:54:34', '2026-01-17 18:55:20'),
(3, 3, 2, 'Le marketing digital', 'Le marketing digital englobe toutes les techniques marketing utilisant les supports et canaux numériques', 2, 100, 3, 1, 0, 0, 1, '2026-01-17 19:05:01', '2026-01-17 19:05:01'),
(4, 4, 2, 'Le Marketing Digital / Marketing Numérique)', 'Les caractéristiques principales du marketing', 5, 100, 3, 1, 0, 0, 1, '2026-01-17 19:12:32', '2026-01-17 19:12:32'),
(5, 4, 2, 'Le Marketing Digital / Marketing Numérique', 'Les Caractéristiques principales du marketing numérique', 5, 100, 3, 1, 0, 0, 1, '2026-01-17 19:15:29', '2026-01-17 19:15:29'),
(9, 17, 7, 'QU’EST-CE QUE LE DROIT D’AUTEUR ?', 'Le droit d’auteur, ce n’est pas une démarche administrative compliquée.\r\n- Il naît automatiquement dès qu’une œuvre est créée et mise en forme.\r\n- Une idée seule ne suffit pas : il faut qu’elle soit écrite, structurée, matérialisée.\r\n- Dès ce moment, l’auteur devient titulaire d’un droit de propriété… mais un droit immatériel.\r\n- C’est exactement ce que reconnaît l’Annexe VII de l’Accord de Bangui : une œuvre de l’esprit, dès qu’elle est originale, mérite protection.', 1, 100, 3, 1, 0, 0, 1, '2026-02-07 11:08:01', '2026-02-07 11:08:01'),
(10, 17, 7, 'Le droit d’auteur vise principalement à :', 'Le droit d’auteur repose sur un équilibre fondamental.\r\nD’un côté, le droit moral : il protège la personne de l’auteur. On ne peut pas enlever son nom, ni dénaturer son texte. Même un contrat ne peut pas supprimer cela.\r\nDe l’autre côté, les droits patrimoniaux : ce sont les droits économiques. C’est grâce à eux qu’un livre peut être vendu, diffusé, adapté ou numérisé. Et c’est précisément ces droits-là que l’auteur peut céder… mais jamais à l’aveugle', 1, 100, 3, 1, 0, 0, 1, '2026-02-09 09:25:53', '2026-02-09 09:25:53'),
(11, 17, 7, 'Laquelle des affirmations est correcte ?', 'En autoédition, l’auteur reste maître de tout : diffusion, formats, revenus. En édition classique, il cède une partie de ses droits à l’éditeur, mais uniquement par contrat écrit. Attention : céder ses droits ne veut pas dire les abandonner définitivement. La reproduction – photocopie, scan, numérisation – est un acte juridique sensible. Les exceptions existent, mais elles sont strictes.\r\nPhotocopier un chapitre pour un cours n’est pas la même chose que reproduire un livre entier. C’est pour gérer ces usages à grande échelle que les organismes de gestion collective jouent un rôle clé.', 1, 100, 3, 1, 0, 0, 1, '2026-02-09 10:32:08', '2026-02-09 10:32:08'),
(12, 18, 7, 'Quel est l’enjeu principal du numérique, des plateformes et de l’intelligence artificielle pour le développement du livre africain ?', '« Le numérique, les plateformes et l’intelligence artificielle ne sont ni bons ni mauvais en soi. Tout dépend de la manière dont nous les utilisons. L’enjeu pour le livre africain est de trouver un équilibre entre accès à la culture, protection des créateurs et innovation durable. »', 1, 100, 3, 1, 0, 0, 1, '2026-02-09 11:17:14', '2026-02-09 11:17:14'),
(13, 19, 7, 'Quel principe fondamental guide le droit d’auteur selon le traité de MARRAKECH?', 'Le traité de MARRAKECH nous rappelle une chose importante : le droit d’auteur cherche en permanence un équilibre entre protection des créateurs et intérêt général', 1, 100, 3, 1, 0, 0, 1, '2026-02-09 11:44:20', '2026-02-09 11:51:17'),
(14, 20, 7, 'Quel principe est essentiel pour que la protection du droit d’auteur ait un impact positif sur le marché du livre africain ?', 'Modèles économiques adaptés au contexte africain\r\n« Le marché du livre africain fait face à des défis spécifiques : coûts élevés de production, faibles réseaux de distribution, piratage, mais aussi un fort besoin d’accès à la lecture. Pour y répondre, il faut inventer ou adapter des modèles économiques plus souples et plus intelligents. »', 1, 100, 3, 1, 0, 0, 1, '2026-02-09 12:09:25', '2026-02-09 12:09:25'),
(15, 20, 7, 'Quel est le message central de cette conclusion sur la chaîne du livre africaine ?', '« Le livre ne s’arrête pas aux frontières. Les auteurs, les œuvres et les lecteurs circulent d’un pays à l’autre, surtout dans notre espace ouest et centre africain. C’est pourquoi la coopération régionale est aujourd’hui indispensable pour construire un marché du livre solide et durable. »\r\n\r\nCoopération régionale\r\n« Coopérer, c’est partager les expériences, les bonnes pratiques, les catalogues, mais aussi les outils de protection. C’est travailler ensemble entre auteurs, éditeurs, libraires et diffuseurs des différents pays pour renforcer la visibilité du livre africain. Dans l’espace OAPI, nous disposons déjà d’un cadre juridique commun : à nous de le faire vivre dans nos pratiques professionnelles. »\r\n\r\nHarmonisation des pratiques\r\n« L’harmonisation ne signifie pas l’uniformité, mais la cohérence. Cela veut dire appliquer les mêmes principes de respect du droit d’auteur, que l’on soit au Bénin, en Côte d’Ivoire, au Togo, au Sénégal, en Guinée ou au Tchad. Quand les pratiques sont claires et partagées, la confiance s’installe entre les acteurs et les partenariats deviennent possibles. »\r\n\r\nCulture du respect du droit d’auteur\r\n« Le respect du droit d’auteur n’est pas seulement une obligation juridique, c’est une culture à construire.C’est comprendre que derrière chaque livre, il y a du travail, du temps, des investissements et des métiers. Respecter le droit d’auteur, c’est reconnaître la valeur de la création et garantir la survie de la chaîne du livre. »', 1, 100, 3, 1, 0, 0, 1, '2026-02-09 12:31:42', '2026-02-09 12:31:42'),
(16, 21, 8, 'Pourquoi est-il important de formaliser et structurer un partenariat gagnant-gagnant dès le départ ?', 'La confiance seule ne suffit pas : une organisation structurée et des accords clairs sont essentiels pour assurer la réussite et la durabilité de la collaboration.', 1, 100, 3, 1, 0, 0, 1, '2026-02-11 04:58:28', '2026-02-11 04:58:28'),
(17, 22, 8, 'Quelle affirmation décrit le mieux une synergie efficace dans un partenariat ?', 'Le module cible la capacité à relier valeurs relationnelles et performance collective dans le cadre d’un partenariat.', 1, 100, 3, 1, 0, 0, 1, '2026-02-11 05:11:51', '2026-02-11 05:11:51'),
(18, 23, 8, 'Quelle est la première étape recommandée pour construire un réseau stratégique efficace selon le texte ?', 'Cette question teste la compréhension de l’ordre logique et des priorités dans la construction d’un réseau. Elle vérifie si l’apprenant sait qu’une identification claire des partenaires est la première étape essentielle avant toute action numérique ou collaborative.', 1, 100, 3, 1, 0, 0, 1, '2026-02-11 05:20:42', '2026-02-11 05:20:42'),
(19, 24, 8, 'Quelle est la conséquence principale d’un manque de communication dans une équipe selon le texte ?', 'Cette question vise à vérifier la compréhension des obstacles à une collaboration efficace. Elle oblige l’apprenant à identifier les effets négatifs de la communication insuffisante, et à distinguer les conséquences réelles (malentendus, frustration, ralentissement) d’idées contraires ou contre-intuitives (comme une créativité accrue).', 1, 100, 3, 1, 0, 0, 1, '2026-02-11 05:29:52', '2026-02-11 05:29:52'),
(20, 25, 9, 'Quel est l’avantage principal des livres audio pour les personnes malvoyantes et dyslexiques ?', 'Cette question vérifie la compréhension des bénéfices inclusifs du livre audio. Elle oblige l’apprenant à identifier le rôle d’accessibilité et d’autonomie pour les personnes malvoyantes ou dyslexiques, et à ne pas confondre accessibilité avec substitution totale du livre papier.', 1, 100, 3, 1, 0, 0, 1, '2026-02-11 06:32:11', '2026-02-11 06:32:11'),
(21, 26, 9, 'Le livre audio est pour les paresseux', 'Le livre audio n’est pas un “livre pour paresseux”, c’est plutôt un outil d’accessibilité et de flexibilité. En fait, écouter un livre demande concentration et réflexion, tout comme le lire ! Le format change juste la manière dont on absorbe l’information.', 1, 100, 3, 1, 0, 0, 1, '2026-02-11 06:42:45', '2026-02-11 06:42:45'),
(22, 27, 9, 'Quel rôle jouent les narrateurs et ingénieurs du son dans le livre audio ?', 'Cette question vérifie la compréhension du rôle clé des professionnels du son dans la réussite d’un livre audio. Elle distingue les contributions techniques et artistiques réelles des idées fausses selon lesquelles la narration serait mécanique ou sans valeur ajoutée.', 1, 100, 3, 1, 0, 0, 1, '2026-02-11 06:52:34', '2026-02-11 06:52:34'),
(23, 28, 9, 'Quel avantage principal offrent les livres interactifs par rapport aux livres audio classiques ?', 'Cette question permet de vérifier la compréhension de l’innovation dans les formats de lecture. L’apprenant doit identifier que les livres interactifs enrichissent l’expérience utilisateur en combinant plusieurs médias, plutôt que de supprimer l’apprentissage de la lecture.', 1, 100, 3, 1, 0, 0, 1, '2026-02-11 07:02:00', '2026-02-11 07:02:00'),
(24, 29, 9, 'Pourquoi les partenariats avec les associations, bibliothèques et ONG sont-ils importants dans les projets de livres audio et numériques ?', 'Cette question vérifie la compréhension de l’importance des partenariats stratégiques pour l’inclusion et l’impact culturel. Elle aide à distinguer la valeur sociale et pédagogique de ces collaborations par rapport à une vision purement économique ou logistique.', 1, 100, 3, 1, 0, 0, 1, '2026-02-11 07:14:06', '2026-02-11 07:14:06'),
(25, 30, 10, 'Quelle période marque l’essor de l’IA grâce au machine learning et au big data ?', 'Cette question vérifie la capacité à identifier les grandes étapes historiques de l’IA et à associer correctement les innovations à leur période. La mauvaise réponse constitue un piège plausible, car les années 1990 comportent aussi un événement marquant (Deep Blue), mais correspondent globalement à une phase de ralentissement plutôt qu’à un essor.', 1, 100, 3, 1, 0, 0, 1, '2026-02-18 04:23:57', '2026-02-18 04:23:57'),
(26, 31, 10, 'Quel est l’un des principaux apports de l’IA dans les métiers ?', 'Cette question vise à vérifier la compréhension globale du rôle de l’IA dans la transformation du travail. Elle encourage les apprenants à distinguer entre automatisation intelligente (réaliste) et remplacement complet de l’humain (idée simpliste et erronée). La mauvaise réponse constitue un piège fréquent, car l’IA est souvent perçue comme une menace absolue plutôt que comme un outil d’augmentation des capacités humaines.', 1, 100, 3, 1, 0, 0, 1, '2026-02-18 04:36:24', '2026-02-18 04:36:24'),
(27, 32, 10, 'Quel est l’effet principal de l’intelligence artificielle sur la chaîne du livre selon le document ?', 'Cette question vise à vérifier la compréhension globale du rôle systémique de l’IA dans l’écosystème du livre. Elle met l’accent sur la notion de transformation et d’augmentation des capacités humaines plutôt que sur l’idée erronée d’un remplacement total des acteurs. La mauvaise réponse constitue un piège pédagogique courant, fondé sur une vision alarmiste de l’IA, tandis que la bonne réponse reflète la complémentarité entre technologie et expertise humaine.', 1, 100, 3, 1, 0, 0, 1, '2026-02-18 04:50:16', '2026-02-18 04:50:16'),
(28, 33, 10, 'Pourquoi est-il nécessaire d’encadrer l’intelligence artificielle par des règles et des politiques publiques ?', 'Cette question vise à vérifier que l’apprenant comprend le rôle régulateur des politiques publiques : encadrer sans interdire. Elle permet de distinguer une approche équilibrée (innovation responsable) d’une vision extrême qui confond régulation et interdiction.', 1, 100, 3, 1, 0, 0, 1, '2026-02-18 04:56:30', '2026-02-18 04:56:30');

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
(2, 2, 'Le marketing traditionnel : désigne l\'ensemble des techniques de promotion à l\'ère du numérique', 'choix_multiple', 2, 1, NULL, '2026-01-17 18:58:38', '2026-01-17 18:58:38'),
(3, 2, 'Le marketing traditionnel :', 'choix_multiple', 4, 2, NULL, '2026-01-17 19:02:04', '2026-01-17 19:02:04'),
(4, 3, 'Le téléphone portable et l\'ordinateur ne sont pas nécessaires au marketing digital', 'vrai_faux', 2, 1, NULL, '2026-01-17 19:07:34', '2026-01-17 19:07:34'),
(5, 4, 'Le marketing digital n\'est pas adapté au marché africain', 'vrai_faux', 2, 1, NULL, '2026-01-17 19:13:45', '2026-01-17 19:13:45'),
(6, 5, 'les caractéristiques principales du Marketing Digital sont :', 'choix_multiple', 5, 1, NULL, '2026-01-17 19:18:32', '2026-01-17 19:18:32'),
(7, 9, 'Le droit d\'auteur c\'est :', 'qcm', 5, 1, NULL, '2026-02-07 11:24:14', '2026-02-07 11:24:14'),
(8, 10, 'Le droit d’auteur vise principalement à :', 'qcm', 5, 1, NULL, '2026-02-09 09:32:57', '2026-02-09 10:38:34'),
(9, 11, 'Laquelle des affirmations est correcte ?', 'qcm', 5, 1, NULL, '2026-02-09 10:37:12', '2026-02-09 10:37:12'),
(10, 12, 'Quel est l’enjeu principal du numérique, des plateformes et de l’intelligence artificielle pour le développement du livre africain ?', 'qcm', 5, 1, NULL, '2026-02-09 11:20:18', '2026-02-09 11:20:18'),
(11, 13, 'Quel principe fondamental guide le droit d’auteur selon le traité de MARRAKECH ?', 'qcm', 5, 1, NULL, '2026-02-09 11:48:41', '2026-02-09 11:51:55'),
(12, 14, 'Quel principe est essentiel pour que la protection du droit d’auteur ait un impact positif sur le marché du livre africain ?', 'qcm', 5, 1, NULL, '2026-02-09 12:11:08', '2026-02-09 12:11:08'),
(13, 15, 'Quel est le message central de cette conclusion sur la chaîne du livre africaine ?', 'qcm', 5, 1, NULL, '2026-02-09 12:32:45', '2026-02-09 12:32:56'),
(14, 16, 'Pourquoi est-il important de formaliser et structurer un partenariat gagnant-gagnant dès le départ ?', 'qcm', 5, 1, NULL, '2026-02-11 04:59:36', '2026-02-11 04:59:36'),
(15, 17, 'Quelle affirmation décrit le mieux une synergie efficace dans un partenariat ?', 'qcm', 5, 1, NULL, '2026-02-11 05:12:58', '2026-02-11 05:12:58'),
(16, 18, 'Quelle est la première étape recommandée pour construire un réseau stratégique efficace selon le module ?', 'qcm', 5, 1, NULL, '2026-02-11 05:22:28', '2026-02-11 05:22:28'),
(17, 19, 'Quelle est la conséquence principale d’un manque de communication dans une équipe selon le texte ?', 'qcm', 5, 1, NULL, '2026-02-11 05:31:16', '2026-02-11 05:31:16'),
(18, 20, 'Quel est l’avantage principal des livres audio pour les personnes malvoyantes et dyslexiques ?', 'qcm', 5, 1, NULL, '2026-02-11 06:33:29', '2026-02-11 06:33:29'),
(19, 21, 'Le livre audio est pour les paresseux', 'qcm', 5, 1, NULL, '2026-02-11 06:44:48', '2026-02-11 06:44:48'),
(20, 22, 'Quel rôle jouent les narrateurs et ingénieurs du son dans le livre audio ?', 'qcm', 5, 1, NULL, '2026-02-11 06:53:39', '2026-02-11 06:53:39'),
(21, 23, 'Quel avantage principal offrent les livres interactifs par rapport aux livres audio classiques ?', 'qcm', 5, 1, NULL, '2026-02-11 07:03:36', '2026-02-11 07:03:36'),
(22, 24, 'Pourquoi les partenariats avec les associations, bibliothèques et ONG sont-ils importants dans les projets de livres audio et numériques ?', 'qcm', 5, 1, NULL, '2026-02-11 07:15:32', '2026-02-11 07:15:32'),
(23, 25, 'Quelle période marque l’essor de l’IA grâce au machine learning et au big data ?', 'qcm', 5, 1, NULL, '2026-02-18 04:26:32', '2026-02-18 04:26:32'),
(24, 26, 'Quel est l’un des principaux apports de l’IA dans les métiers ?', 'qcm', 5, 1, NULL, '2026-02-18 04:37:33', '2026-02-18 04:37:33'),
(25, 27, 'Quel est l’effet principal de l’intelligence artificielle sur la chaîne du livre selon le document ?', 'qcm', 5, 1, NULL, '2026-02-18 04:51:45', '2026-02-18 04:51:45'),
(26, 28, 'Pourquoi est-il nécessaire d’encadrer l’intelligence artificielle par des règles et des politiques publiques ?', 'qcm', 5, 1, NULL, '2026-02-18 04:57:33', '2026-02-18 04:57:33');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_predefined` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `is_predefined`, `created_at`, `updated_at`) VALUES
(1, 'Éditeur', 'Peut créer et modifier le contenu (catalogue, formations, blog)', 1, '2026-02-08 21:04:13', '2026-02-08 21:04:13'),
(2, 'Modérateur', 'Peut consulter et modérer le contenu, gérer les emprunts et commandes', 1, '2026-02-08 21:04:14', '2026-02-08 21:04:14'),
(3, 'Gestionnaire de Formation', 'Gestion complète des formations, modules, quiz et certifications', 1, '2026-02-08 21:04:15', '2026-02-08 21:04:15'),
(4, 'Lecteur', 'Accès en lecture seule à tous les modules', 1, '2026-02-08 21:04:16', '2026-02-08 21:04:16'),
(5, 'Support Client', 'Gestion des utilisateurs, messages et assistance client', 1, '2026-02-08 21:04:17', '2026-02-08 21:04:17');

-- --------------------------------------------------------

--
-- Structure de la table `role_permission`
--

CREATE TABLE `role_permission` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role_permission`
--

INSERT INTO `role_permission` (`role_id`, `permission_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(2, 2),
(4, 2),
(5, 2),
(5, 4),
(1, 7),
(2, 7),
(4, 7),
(1, 8),
(1, 9),
(2, 11),
(4, 11),
(5, 11),
(2, 13),
(2, 15),
(2, 16),
(4, 16),
(5, 16),
(2, 17),
(2, 18),
(1, 19),
(3, 19),
(4, 19),
(1, 20),
(3, 20),
(1, 21),
(3, 21),
(3, 22),
(1, 23),
(3, 23),
(4, 23),
(1, 24),
(3, 24),
(1, 25),
(3, 25),
(3, 26),
(1, 27),
(3, 27),
(4, 27),
(1, 28),
(3, 28),
(1, 29),
(3, 29),
(3, 30),
(3, 31),
(4, 31),
(3, 32),
(3, 33),
(1, 34),
(2, 34),
(4, 34),
(5, 34),
(2, 35),
(5, 35),
(5, 36),
(2, 37),
(4, 37),
(5, 37),
(2, 38),
(5, 38),
(1, 40),
(4, 40),
(1, 41),
(1, 42),
(4, 44);

-- --------------------------------------------------------

--
-- Structure de la table `security_attempts`
--

CREATE TABLE `security_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `document_id` int(10) UNSIGNED DEFAULT NULL,
  `document_type` varchar(50) DEFAULT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `security_attempts`
--

INSERT INTO `security_attempts` (`id`, `user_id`, `type`, `document_id`, `document_type`, `ip_address`, `user_agent`, `details`, `created_at`) VALUES
(1, 32, 'document_loaded', 52, 'catalogue', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '[]', '2026-02-08 21:45:51'),
(2, 39, 'screenshot_attempt', 53, 'catalogue', '2a02:6ea0:c31f:6218::17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '{\"reason\":\"window_blur\",\"attempt\":1}', '2026-02-12 20:37:39'),
(3, 39, 'document_loaded', 53, 'catalogue', '2a02:6ea0:c31f:6218::17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '[]', '2026-02-12 20:37:40'),
(4, 39, 'screenshot_attempt', 53, 'catalogue', '2a02:6ea0:c31f:6218::17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '{\"reason\":\"window_blur\",\"attempt\":2}', '2026-02-12 20:37:47'),
(5, 39, 'screenshot_attempt', 53, 'catalogue', '2a02:6ea0:c31f:6218::17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '{\"reason\":\"window_blur\",\"attempt\":3}', '2026-02-12 20:37:53'),
(6, 39, 'screenshot_attempt', 53, 'catalogue', '2a02:6ea0:c31f:6218::17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '{\"reason\":\"window_blur\",\"attempt\":4}', '2026-02-12 20:37:55'),
(7, 39, 'screenshot_attempt', 53, 'catalogue', '2a02:6ea0:c31f:6218::17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '{\"reason\":\"Save\",\"attempt\":5}', '2026-02-12 20:38:08'),
(8, 39, 'access_blocked', 53, 'catalogue', '2a02:6ea0:c31f:6218::17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '{\"total_attempts\":5}', '2026-02-12 20:38:08'),
(9, 39, 'document_loaded', 53, 'catalogue', '2a02:6ea0:c31f:6218::17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '[]', '2026-02-12 20:39:01'),
(10, 39, 'screenshot_attempt', 53, 'catalogue', '2a02:6ea0:c31f:6218::17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '{\"reason\":\"visibility_hidden\",\"attempt\":1}', '2026-02-12 20:39:02'),
(11, 39, 'screenshot_attempt', 53, 'catalogue', '2a02:6ea0:c31f:6218::17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '{\"reason\":\"window_blur\",\"attempt\":2}', '2026-02-12 20:39:02'),
(12, 39, 'screenshot_attempt', 53, 'catalogue', '2a02:6ea0:c31f:6218::17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '{\"reason\":\"visibility_hidden\",\"attempt\":3}', '2026-02-12 20:39:20'),
(13, 39, 'screenshot_attempt', 53, 'catalogue', '2a02:6ea0:c31f:6218::17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '{\"reason\":\"window_blur\",\"attempt\":4}', '2026-02-12 20:39:20');

-- --------------------------------------------------------

--
-- Structure de la table `security_blocks`
--

CREATE TABLE `security_blocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(255) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `blocked_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `unblocked_at` timestamp NULL DEFAULT NULL,
  `unblocked_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `security_blocks`
--

INSERT INTO `security_blocks` (`id`, `user_id`, `reason`, `ip_address`, `user_agent`, `blocked_at`, `unblocked_at`, `unblocked_by`, `created_at`, `updated_at`) VALUES
(1, 39, 'capture', '2a02:6ea0:c31f:6218::17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-02-12 20:39:58', NULL, NULL, '2026-02-12 20:39:58', '2026-02-12 20:39:58');

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
('52XaL5iNezcE0S0IUXjEwS5CVDE9khqmCTNKyLDL', NULL, '15.204.161.7', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN2prMmUwWGNwMWZQdDljaUdDME9yME83eVoyV2xhWjRxOFRzVUd6TyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1771790139),
('6LB3HIVs3nUacEFxU3kZrC0uXwfnL5SJLBPi5OJ3', NULL, '80.76.49.88', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQTh2dmUyVkRKd3hkZ2NXRlhLejZtWm1iN1dHdnV0Z09tSUZ2SmdVayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1771786705),
('7yL4iBUOhchRHL7J3BVF2wwYSzQdYrnzRJRZ71BL', NULL, '15.204.161.7', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZnlmb0JJY0xNZ3hZTXkwSVJCWEdTc3RhWVc5SXlKamFTbDZDRVlqNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vd3d3LmNvbGlicmktbGl0dGVyYWlyZS5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1771792163),
('82OcaENSeOHsummQfVa0NEkKG9D1AGmZ8ylyYjON', NULL, '2a01:4f8:c013:9ca0::1', 'Mozilla/5.0 (compatible; bot/1.0)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMWlQU2VUbXRYdFRhejdUcjJEdHdBSHA0UXFzNHJDR1h6YzNYNjJOMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1771779945),
('C7nEXIx4w4bjPRc9cacziULO20hmPjtBpsoJTuxj', NULL, '2001:42d8:3379:bd00:13:c3eb:4abc:b1de', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 OPR/127.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSEJmREpTV1N0dllWTmdTRjJqQ3h3b3RjalZLajVWZlNaY0dmcFRDUSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0OToiaHR0cHM6Ly93d3cuY29saWJyaS1saXR0ZXJhaXJlLmNvbS9hY2NvdW50L3Byb2ZpbCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQwOiJodHRwczovL3d3dy5jb2xpYnJpLWxpdHRlcmFpcmUuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1771759494),
('CWTgMZPJhTq3QH1G77VQhn9eHQnXBA6UyrIeDvlx', NULL, '180.153.236.44', 'User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0; 360Spider', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYTllZlJ0NWRoWkY2WUV6YXA1T2R5aXIzM2FPbUxBV1psREdIM3N2QSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vd3d3LmNvbGlicmktbGl0dGVyYWlyZS5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1771783995),
('DNkjdFuEfT6IWBZWJCKaoIzSnb1VkuLgClA9GQGd', NULL, '66.249.66.200', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.7559.132 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS0ZxMncxckpxRk1yaHJDUzRsOUNzWFhtbXFIZWg3a3QzTDJLalI4MCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vd3d3LmNvbGlicmktbGl0dGVyYWlyZS5jb20vYWJvdXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1771800287),
('dOVASaOvZUSlh5RmMYlxo6CYQ2GTzaYjFUp9nz22', NULL, '180.153.236.180', 'User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0; 360Spider', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTUVuNHFuVXoyMXVFa2dIY2FzMTBnS3JZM1NZSVZDYkpzMTBjdHV4WSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1771761500),
('DP35aZrD7jTwjTu3LrOsM88q6oQsnX7lggf2YEbC', NULL, '51.195.183.67', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicXRma0N2SklqOUE0VVhQWjREU3owQnBlMjJ5NUJ0b0JjNlZOd0t4eiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbS9mb3JtYXRpb24vcXVpeiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1771753903),
('epRv0rXzwRKS7zo5m9GvOdNeLKiDy3FLYKCMGbQf', NULL, '51.89.129.209', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT01la0M5WHY2NGk3MGR2ZlRIUGNlQldYZXBuWWVPbWwyZ2ZGa2xNMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbS9jYXRhbG9ndWU/cGFnZT0yIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1771798000),
('F5eleGxlI2uVc8qK4uAby9z6yHSzdwVTxPc7kHqx', NULL, '95.108.213.173', 'Mozilla/5.0 (compatible; YaDirectFetcher/1.0; +http://yandex.com/bots) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT1ZHN1UxRjhTUVp4WGFLNW5DUDVnNFRVS1F0bXN6TzJCODZvcFlMdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vd3d3LmNvbGlicmktbGl0dGVyYWlyZS5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1771754338),
('fyEOySWHrFRp8hZiq92td5y9ML5kMtQxH5rHvHkL', NULL, '2001:4ca0:108:42::7', 'quic-go-HTTP/3', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiYlI3YWowUll4ZlZmamlaeFlKRjZDcnpJcTRJOEJscklXOW1BQTgzciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1771779581),
('iKo4YYFYL0ZEPjSaFsm1Hyz3ztD3TxoO3FeLJk4B', NULL, '216.73.216.56', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; ClaudeBot/1.0; +claudebot@anthropic.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTW43T0JWaW5yMzI2aVJkaDlqdzdBemNNbjBuanhERGlZc1Bmd2xOSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1771794964),
('jkFn0Ct3B1qDM9UjYqTz2GOyZeafx2ZnT2ZRb3ui', NULL, '198.244.242.135', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNjV3c3dTeHM2enhPbU1RUG41TmtES1Jac0hwMFg2d21tT28yV2NwUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbS9mb3JtYXRpb24vNyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1771755803),
('JY0RdFuY0KM58KhF0v2bvLR3gEPRomhSorBOqIoM', NULL, '198.244.240.82', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid01jUXI5eTNhUWx3R2x0M1dDcG1mNGdxM2pIcTQyNjhZaUo2clNuYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDM6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbS9jYXRhbG9ndWUvMzQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1771764116),
('lxd55uqmES1vPg2sCSK1rsYOaX5hTgg5F2uyr0cR', NULL, '198.244.240.18', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUDIyOE40dzhyV1ZMaVlkcUJKNmpqTmhrbVJXYWdjUnJudlgzMmRobiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbS9jb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1771800950),
('mcu24iy8WgN9lAvJhdn3XK4T2geuWY1G8UP5KRdU', NULL, '2a03:2880:f814:22::', 'meta-externalagent/1.1 (+https://developers.facebook.com/docs/sharing/webmasters/crawler)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVHNrenRYaFpIRmx0RGRJY0ZZRlhHYkdVQzR1YXd3Q1VBcjV6T3I0NiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vd3d3LmNvbGlicmktbGl0dGVyYWlyZS5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1771801495),
('NzHH4jNbOs8vud0jVkWYaunBRFZuLDVlVvmPTGvN', NULL, '198.244.183.147', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYVRESktoRnZFa0VFNExINHZQSVJDaWVwMjRQcGpUdWVidVJpT0dIayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbS9jYXRhbG9ndWU/cGFnZT00Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1771787367),
('OashvD1WLCo6lGxAfAd8eeGmIXrbejOmE7SoFqKb', NULL, '40.77.167.7', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibVA0NnRteHdQM3VKMVphRzhNZnlTcXJsTjI3a0lVT2ZyZFB5endScSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbS9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1771752117),
('QubgiigzeRweh8S3DXtpTMOAW5E11bsBhkCoymVj', NULL, '98.84.151.38', 'Googlebot-Video/1.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibEMzVDFCTWlYbGtaMXNRYmZXOUhqVDJvOHMzVFBSTVV2T0s1cEhjWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1771793081),
('QvXMEsuTftljpvKaSkuLxxwGSZCn2iQALfP2WccL', NULL, '51.195.215.12', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRHBYdGtPWGVRajM3aW85SGdncmNYY0s3MW4xa3I1d0pZRUN0S3dMaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDM6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbS9jYXRhbG9ndWUvNDgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1771761334),
('SNoDJ3rNCiI13VMB3NYPaisOzfMCrCURrjcKnzVk', NULL, '54.38.147.126', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWlNQaVZLdWRDNXpDQUhDV0xTd1FhdXhKazg1VmxUbmhYRTFwb2VkTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDM6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbS9jYXRhbG9ndWUvMzUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1771757645),
('vxukH2U6MS2ePVZYA4YU6uzhj8vI3Irx1aFW5LGg', NULL, '51.195.244.63', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR3JuMGpyYzBLZ2FvU29QVjNiYVBYQ0VtbmdhQURSZHljTHlTdW9aZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbS9jYXRhbG9ndWU/cGFnZT0zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1771796615),
('VzaR8WZAjewM9TjVumCnyXd3lCxfj4yS9O1s2DWs', NULL, '2001:4ca0:108:42::7', 'quic-go-HTTP/3', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiYTdjVGhITlNYRVc0U3ExelJOQzZreGFCcjQ5SjZSN0dBNmwxWTZ5WCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1771777547),
('WRYTfSUMCzoLaFxVtVw27Iw6tljNdKnzn2wENG0S', NULL, '80.76.49.88', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYUZSRWI4b05uVnhlNEpWV1RNcUlYQTYyRVNzRDNMUXAyREpCZGgxQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1771786705),
('YubfyBapI065VXXnKqzso1kIpxITJndz0r92wkfI', NULL, '198.244.168.193', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNEJkRWpaRHNzMUc2bzVaMGptZ3lSOVFIZk5JaVRiY2U5ekgxUmRxRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHBzOi8vY29saWJyaS1saXR0ZXJhaXJlLmNvbS9jYXRhbG9ndWUvYWNoZXRlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1771799489);

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
(1, 'Colibi Litteraire', 'colibri@gmail.com', NULL, NULL, NULL, 'admin', 0, NULL, '$2y$12$p0y/MrJ9xnEpWZOV2/lXy.MfbnaXV3Qv/jXTOr10F65BViAXGvrQ2', 0, 'Al3rijcBVoNm9dmvzAfG3ULnDT329QwHvMtxgUDukqzEtHtYa3HZbgMFjlq8', '2026-01-08 09:35:51', '2026-01-08 09:35:51'),
(3, 'ASSOMOU N\'DEDE ALEXANDRE', 'analex1er@gmail.com', '0707464325', NULL, NULL, 'membre', 0, NULL, '$2y$12$KXq6nuIp9boB5U1b3PLx.OFRwwZdA0HBBNT2Eq3qcSkpkZMxo3K4G', 0, NULL, '2026-01-16 10:09:47', '2026-01-16 10:09:47'),
(4, 'Gnaloko Didi Jérôme', 'gnalokodidijerome@gmail.com', '0708966892', NULL, NULL, 'membre', 0, NULL, '$2y$12$DmB28vzbYIy1uJC.fpi4CuXD6Phexj.5i8/gZ4EqYYzg5IIvcwMf.', 0, NULL, '2026-01-16 10:40:39', '2026-01-16 10:40:39'),
(5, 'Ange Emmanuel Sonh Kah', 'angesonhkah@gmail.com', '0788791482', NULL, NULL, 'membre', 0, NULL, '$2y$12$7uI2B2WCuRAHx..fFbTb9eFHN0dw7YxX3Qr0v7KvyyMzGFHNePKv.', 0, 'KH1tfUlijaq9w407Vmwbj79Dw0vIWAvPHF2iKqDsCCVNS1zJOQ7ZqYDbFORJ', '2026-01-16 11:19:00', '2026-01-16 11:19:00'),
(7, 'GUIDJIME Enock', 'guidji336@gmail.com', '0196534791', NULL, 'avatars/F9763u9gSYxNzVfTRm0LlfP6q8GEkGLZHTkGUTgS.jpg', NULL, 0, NULL, '$2y$12$PUExtYCkZ1KqvgVonaPt/O6ENKoQguIUcprmAyt2n24dttLBrMFiy', 0, NULL, '2026-01-23 11:24:04', '2026-01-23 11:26:14'),
(8, 'Dassi Gervais', 'gervaisdassi@gmail.com', '+22966471281', NULL, 'avatars/Hypup4CnaiOefsV555lsHTYaJqHt5ISkBJ4Yv1Vz.jpg', NULL, 0, NULL, '$2y$12$8fELneF1pApoDVcGxZG9tO7odg5fluMrIirehRuM.yG3w9HXdKjFS', 0, NULL, '2026-01-23 11:25:26', '2026-01-23 11:35:18'),
(9, 'Sendrine Anago', 'anagosendrine@gmail.com', '0156406714', 'Calavi', NULL, NULL, 0, NULL, '$2y$12$admXrPKga23IkEth9kz/1uI.z.jY0KLp9jZaymTFo4sJYgQNtyumu', 0, NULL, '2026-01-23 11:25:34', '2026-01-23 11:25:34'),
(10, 'PADONOU Larissa', 'larissapadonou2@gmail.com', '0160508266', 'Calavi', NULL, NULL, 0, NULL, '$2y$12$at9gd6X/Caiv4uFQLWO45.lth7T1vVmoqvJcXl3cxsrzs8KoFfGDq', 0, NULL, '2026-01-23 11:25:57', '2026-01-23 11:25:57'),
(11, 'ZODEHOUGAN  Édith olive Senan', 'edolive3@gmail.com', '0166876545', 'Ouèdo', NULL, NULL, 0, NULL, '$2y$12$at96Qq.nKtIVcFKJZeGgD.kWYC8.I.1OtOEepZFpb.UXPFIvzJdja', 0, NULL, '2026-01-23 11:26:03', '2026-01-23 11:26:03'),
(12, 'MONTCHO Alphonse', 'samedialphonse98@gmail.com', '0167186299', NULL, NULL, NULL, 0, NULL, '$2y$12$cc7NKGkV0IsbA5fNMSrmjOyPfGCqpuuUI4cogQlSg5ZlbI4xOG14C', 0, NULL, '2026-01-23 11:26:20', '2026-01-23 11:26:20'),
(13, 'DANGNIVO Koty Anna Bai', 'annabaidangnivo2017@gmail.com', '+2290166955111', 'Cotonou Fidjrossè', NULL, NULL, 0, NULL, '$2y$12$G5q3pGn2IO/59MXesVc0MuV4Ao5qHUojKg/sG3RlepvzV2PSmxNHK', 0, NULL, '2026-01-23 11:26:41', '2026-01-23 11:26:41'),
(14, 'Makhfous cissé', 'makhfouslegrand@gmail.com', '00221777934366', 'dakar senegal', NULL, NULL, 0, NULL, '$2y$12$EHt2vy8BL2vi2hiycfehWeDrro6Q3blWUpASBvkcggDuleNSJ1r8O', 0, 'YCx7Lfpw3DTSWH8DUf3bO537toLrjD5ycnKRFRjxK4kRrLmy0ANH6odAajRH', '2026-01-23 11:26:49', '2026-02-09 09:05:29'),
(15, 'Moïse NONVIGNON', 'dmoisenonvignon@gmail.com', '(00229) 0166424948', NULL, NULL, NULL, 0, NULL, '$2y$12$AbetTEbV4FCbOFPqlKgePO3MpfOERl.B.mz6P2u5YbTUojKoATs.2', 0, NULL, '2026-01-23 11:26:57', '2026-01-23 11:26:57'),
(16, 'CODJO BLIGUI Marius', 'mcodjobligui@gmail.com', '+2290162160155', NULL, 'avatars/IdDIXEKZIAPwx4SaeGAF3JWQCAP9i0ao69sUKWrI.jpg', NULL, 0, NULL, '$2y$12$xjzHEFS5Z8FXhLoEkdOEjuFDuVF.DpwzsdA384jWcIvRzCVsRWFrG', 0, NULL, '2026-01-23 11:27:37', '2026-01-23 11:28:08'),
(17, 'MBOUKE YAWAVI', 'yawavi.mbouke@gmail.com', '0022893075585', 'Lomé Togo', NULL, NULL, 0, NULL, '$2y$12$XExg6ww0isGrTr2sgp5tN.TF1h.81H8NLEEjF48peNKJbQ2fOtMli', 0, NULL, '2026-01-23 11:27:41', '2026-01-23 11:27:41'),
(18, 'Adiho Axelle', 'adorasse@yahoo.fr', '0197586600', NULL, NULL, NULL, 0, NULL, '$2y$12$JUunu68uK5FbcOi6o223pOT9eZmiz2uL2wMg8qU7CR8XpOcdRZ2DC', 0, NULL, '2026-01-23 11:27:44', '2026-01-23 11:27:44'),
(19, 'COVI Alida', 'covialida43@gmail.com', '0169559041', 'Sinoutin', NULL, NULL, 0, NULL, '$2y$12$5Xjlss.Hha5vOxGNwKUUquQanwbpVFP8l6zYkR1LxSnrGxHKcVe0S', 0, NULL, '2026-01-23 11:28:22', '2026-01-23 11:28:22'),
(20, 'OGA Atchéni Fabrice', 'ogafabrice3@gmail.com', '0196095176', 'TCHAOUROU', 'avatars/sdQRXKHgVwSUwNLsvhuCDoaYvVjaOkg7Zzo70ufA.jpg', NULL, 0, NULL, '$2y$12$EXItMxz52TDc9z9CKtXGKehi86h.DK61Y/DFKJ7Av0ZyQBWDUorEW', 0, NULL, '2026-01-23 11:28:38', '2026-01-23 11:28:55'),
(21, 'MABOUDOU Abdou Rahim', 'maboudourahim@gmail.com', '+2290196841305', 'Ladjifarani, vons de cap finances', NULL, NULL, 0, NULL, '$2y$12$cd6lTEtE16hjYvndjiNBge/hBJWqRqLJmeY7.LKuAq6W0/RxYFDcm', 0, NULL, '2026-01-23 11:28:41', '2026-01-23 11:28:41'),
(22, 'Théophile Sèwanou', 'sewat369@gmail.com', '+229 0196746339', NULL, 'avatars/xGyxWzrJ14RlEkMCuv5YTaGZdrYyiJ0WJm4S3GWC.jpg', NULL, 0, NULL, '$2y$12$9ClZhskWFsk/w4ufzPIMh.704AP/CuAxtuHf5Dg9Fzju6jJkcY0FK', 0, NULL, '2026-01-23 11:28:54', '2026-01-23 11:30:52'),
(23, 'ABOU Nassirou', 'abounassirou5@gmail.com', '0195287693', NULL, NULL, NULL, 0, NULL, '$2y$12$BcsAyQR7Z7dKDOZUEMHcP.paEjXG9smuYEx/qPsxYkXec4HF16sb2', 0, NULL, '2026-01-23 11:29:26', '2026-01-23 11:29:26'),
(24, 'Ornella', 'ornellaadjanohoun@gmail.com', '0197482502', NULL, NULL, NULL, 0, NULL, '$2y$12$4qD3as.nDf1VMsWI55./UeY/x5OSdw/waHgd6IdLCDQSXXUzvt4d.', 0, NULL, '2026-01-23 11:30:23', '2026-01-23 11:31:18'),
(25, 'YAHOUÉDÉHOU Assouan', 'arysassouan@gmail.com', '0197556653', NULL, NULL, NULL, 0, NULL, '$2y$12$aqrV4JheUmCR/fStDs6b/OSiPS/Xxiijmk9DgrGibAb5XHqayMmJ.', 0, NULL, '2026-01-23 11:31:01', '2026-01-23 11:31:01'),
(26, 'HOUNHATOHOU S.Anicette', 'anicettesemevo@gmail.com', '+2290162902599', NULL, NULL, NULL, 0, NULL, '$2y$12$xJiUtPYaPapv1oqsb6zF1O7qkqHuwpuzPVCcwY0fR4mrDDYhXjBrO', 0, NULL, '2026-01-23 11:32:23', '2026-01-23 11:32:23'),
(27, 'Gandébagni Assiba Mireille', 'acrabole2008@yahoo.fr', '0197067055', NULL, NULL, NULL, 0, NULL, '$2y$12$tkF5w3i5sFneCPt6JBYlge5YIl3SfLTZLsbdbrdh1u6zK14x77Hfy', 0, NULL, '2026-01-23 11:35:07', '2026-01-23 11:35:07'),
(28, 'DEGUENON Sonia Gloriane', 'soniadeguenon@gmail.com', '+229 0161151235', '02BP1111, Cotonou Agla', NULL, NULL, 0, NULL, '$2y$12$QpZS9GTIIg8NZQC1/.2svO0PJahEErrqA1eqUWYT8/lQDyLbHiuta', 0, NULL, '2026-01-23 11:35:17', '2026-01-23 11:35:17'),
(29, 'Agbeko kossi', 'innocentagbeko@yahoo.fr', '0163400441', NULL, 'avatars/7oiagCYm3iCcZxYT4Dvo2Vcw2axj2k8S4Q8xcc5Y.jpg', NULL, 0, NULL, '$2y$12$Mif6Lmq1NnI8Wq.POUbJ5eCdFNf73IRkcIHUuAlejnrr8dn873JEC', 0, NULL, '2026-01-23 11:38:18', '2026-01-23 11:39:14'),
(30, 'AFFIDJI ABDEL MOUHAZOU', 'affidjiabdelmouhazou@gmail.com', '0195368883', 'Non spécifié', NULL, NULL, 0, NULL, '$2y$12$t/F9VBzIHE2EpaWQy1oHduPNzHkUrgf4vuLgiH0OcNJpiQKKRaNSC', 0, NULL, '2026-01-23 11:38:25', '2026-01-23 11:38:25'),
(31, 'DOSSOU Affolabi Stanislas', 'stanedossou977@gmail.com', '+229 0161590116', 'BENIN, Borgou', NULL, NULL, 0, NULL, '$2y$12$MYe0a3EeOXhQbD7u5FE.Y.V2ciP5R25FggaAFFmHlndNYtIQtyKFK', 0, NULL, '2026-01-26 09:57:09', '2026-01-26 10:02:59'),
(32, 'Prestige ZONDOGA', 'prestigezondoga@gmail.com', '+22968732300', 'prestigezondoga@gmail.com', NULL, 'user', 0, NULL, '$2y$12$8f4ZEnY2KRdDgnRLF5SnBO/Y9NuhNOnM.iOWMdR7VJ7Ld5yUNidRm', 0, NULL, '2026-01-27 21:45:29', '2026-02-08 21:43:59'),
(33, 'Herve AYEMENE', 'ayemeneh@yahoo.fr', '+2250707702219', 'Bp 366 Dabou', 'avatars/HYp2Qg3QL6Oxv3adhrMAZk3L9rZPXZpEOnbcsWVa.png', NULL, 0, NULL, '$2y$12$y3q0hhVgLZJiQCTkttEsvOSDJMWwUjnPK/ZcVZIK4SmdZl0m/VlBS', 0, NULL, '2026-02-05 07:54:04', '2026-02-05 07:54:27'),
(34, 'Kodjo AGBEMELE', 'agbemelekodjo1@gmail.com', '91727462', NULL, 'avatars/Dp5kBG8zG0AJS59mVZ32AMPRl1sE6Mnx904osgrn.png', NULL, 0, NULL, '$2y$12$.vaW1kcRlEZKYUMoHYcP3Ok.pOxmIRG2dJh.BJcZ4LnOsYzbpmyK.', 0, NULL, '2026-02-07 11:51:44', '2026-02-07 11:52:04'),
(35, 'KOFFI EVELYNE', 'evelynefkoffi@yahoo.fr', '0758532709', 'Abidjan - Côte d\'Ivoire', NULL, NULL, 0, NULL, '$2y$12$Qa1JyPIxT0TLqQABP15yXOCMRgtXwarwN914oYSLIRhFh0f2auwPe', 0, NULL, '2026-02-08 13:55:50', '2026-02-08 13:55:50'),
(36, 'ANOUMON Esaïe Corneille', 'lelivrovore@gmail.com', '0161314311', 'Calavi', NULL, NULL, 0, NULL, '$2y$12$kCcsKgpOVxUiO4yuSA3SuemRHbc9ihtA92a.BUGXZENNN17kf8Pwy', 0, NULL, '2026-02-09 05:18:31', '2026-02-09 05:18:31'),
(37, 'Gnaloko Didi Jérôme', 'jdgnaloko@gmail.com', '0708966892', NULL, NULL, NULL, 0, NULL, '$2y$12$6AwtyCztNwAkzfUbs0mQEeCOCgYxqBRczchnmntc7oK2K9e2DqEsy', 0, NULL, '2026-02-09 11:27:59', '2026-02-09 11:27:59'),
(38, 'Basile Ané', 'basilevie@gmail.com', '0707665484', NULL, NULL, NULL, 0, NULL, '$2y$12$Uj4h7IfneN/qt2Ij5OtJC.qZA/HyChrVGyd.pHxynxhPZ/n.LLqkm', 0, NULL, '2026-02-12 11:14:46', '2026-02-12 11:14:46'),
(39, 'Modeste Prestige ZONDOGA', 'modestezondoga@gmail.com', '+22990268393', 'C/BN COTONOU BENIN', NULL, NULL, 0, NULL, '$2y$12$1R1EzdM.H.k/Vmqat7sNUOK4jOrqagi1FtKIM/mv/6WhAc9oaiIqW', 1, NULL, '2026-02-12 20:05:49', '2026-02-12 20:39:58'),
(40, 'camille', 'paternecamille@yahoo.fr', '+2290166547808', 'Abomey-Calavi', NULL, NULL, 0, NULL, '$2y$12$MZef2M1hqZOcx1WglYHaRelziHc8bMwnEX8nQqrZKN4UGCsWqeIpG', 0, NULL, '2026-02-12 20:11:51', '2026-02-12 20:11:51'),
(41, 'SOUMAHORO ABDOUL KESSE', 'editionlivrelart@gmail.com', '+225 0779300092', NULL, 'avatars/Xr3iML5SrzMO6kMzB2tSPCP1jmVzxoOmRmBjwNji.jpg', NULL, 0, NULL, '$2y$12$rCa/mod6Pl/mXMevTZAAn.VsvBZgkGKYmmcqiLqspBroMq8TEo3k6', 0, NULL, '2026-02-12 20:55:43', '2026-02-12 20:56:45'),
(42, 'AKASSIBOU Wiyao Richard', 'richardakassibou6@gmail.com', '22893082638', 'Aného Togo', NULL, NULL, 0, NULL, '$2y$12$bsf/NjkOMUMqzZ.bDSw5w.yEBjZvNM9OuQ8qkRyqGohSIzTHm1Pse', 0, NULL, '2026-02-12 20:59:25', '2026-02-12 20:59:25'),
(43, 'AÏKPE Florent', 'aikpef37@gmail.com', '0161279392', 'Bembèrèkè, Gamia', 'avatars/UmGpSnDhVMjszSp7tZuxctxl8EAiL4NFqcmXmROf.jpg', NULL, 0, NULL, '$2y$12$leGPkPWJWqiPNGaKmuYbO.XQzcbpvMQwD2wOybKIo4d4o9nOlzdLa', 0, NULL, '2026-02-12 21:30:14', '2026-02-12 21:32:05'),
(44, 'Adèle Fernand Kiema', 'adelekiema30@gmail.com', '00227 91 32 40 01', 'Niger', NULL, NULL, 0, NULL, '$2y$12$77icXereOIJu3fsKW40rOOSB397wiXcm.fn25zVMO6/yGD5iktJ26', 0, NULL, '2026-02-12 21:53:34', '2026-02-12 21:53:34'),
(45, 'Abdoulhayou Alhassane Mounirou', 'mounirou1234abdoulhayou@gmail.com', '(+227)85500373', 'Niamey/Niger', NULL, NULL, 0, NULL, '$2y$12$FDD61IVzcmtI2MFEZ5kqL.Yzl2oY4pHMhRmO5u./o9do0B6mCEfdG', 0, NULL, '2026-02-13 01:55:08', '2026-02-13 01:55:08'),
(46, 'Elvy GOTIENE', 'elvy.gotiene@gmail.com', '+2250596629090', 'riviera abidjan', NULL, NULL, 0, NULL, '$2y$12$2slpwp0OI0y5BDuPTgwY7uVWStTeN7ECdfZfN6QsQBDTLUUSQ39xq', 0, NULL, '2026-02-13 08:03:09', '2026-02-13 08:03:09');

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
(1, 32, 2, '[]', 0.00, 0, 6, 0, '2026-01-27 21:46:03', '2026-01-27 21:57:25', 683, '2026-01-27 21:46:03', '2026-01-27 21:57:25');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD KEY `admins_role_id_foreign` (`role_id`),
  ADD KEY `admins_created_by_foreign` (`created_by`),
  ADD KEY `admins_status_index` (`status`),
  ADD KEY `admins_is_super_admin_index` (`is_super_admin`);

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `articles_slug_unique` (`slug`),
  ADD KEY `articles_author_id_foreign` (`author_id`);

--
-- Index pour la table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_admin_id_created_at_index` (`admin_id`,`created_at`),
  ADD KEY `audit_logs_model_type_model_id_index` (`model_type`,`model_id`);

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
-- Index pour la table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`),
  ADD KEY `permissions_module_action_index` (`module`,`action`);

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
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Index pour la table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `role_permission_permission_id_foreign` (`permission_id`);

--
-- Index pour la table `security_attempts`
--
ALTER TABLE `security_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `security_attempts_user_id_created_at_index` (`user_id`,`created_at`),
  ADD KEY `security_attempts_type_created_at_index` (`type`,`created_at`);

--
-- Index pour la table `security_blocks`
--
ALTER TABLE `security_blocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `security_blocks_unblocked_by_foreign` (`unblocked_by`),
  ADD KEY `security_blocks_user_id_blocked_at_index` (`user_id`,`blocked_at`);

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
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `catalogues`
--
ALTER TABLE `catalogues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT pour la table `certificats`
--
ALTER TABLE `certificats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `commande_items`
--
ALTER TABLE `commande_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `formation_inscriptions`
--
ALTER TABLE `formation_inscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `module_contenus`
--
ALTER TABLE `module_contenus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `question_options`
--
ALTER TABLE `question_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT pour la table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `security_attempts`
--
ALTER TABLE `security_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `security_blocks`
--
ALTER TABLE `security_blocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

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
-- Contraintes pour la table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `admins_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

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
-- Contraintes pour la table `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `role_permission_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permission_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `security_attempts`
--
ALTER TABLE `security_attempts`
  ADD CONSTRAINT `security_attempts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `security_blocks`
--
ALTER TABLE `security_blocks`
  ADD CONSTRAINT `security_blocks_unblocked_by_foreign` FOREIGN KEY (`unblocked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `security_blocks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
