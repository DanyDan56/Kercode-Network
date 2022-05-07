-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 26 avr. 2022 à 15:49
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `kercode_network`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `images` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Booléen servant à savoir si on doit charger des images ou pas',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `user_id`, `content`, `images`, `created_at`, `updated_at`) VALUES
(1, 1, 'Test de post sans images !', 0, '2022-03-24 09:46:10', '2022-03-24 09:46:10'),
(2, 1, 'Test de post avec 1 image !', 1, '2022-03-24 09:46:31', '2022-03-24 09:46:31'),
(3, 1, 'Test de post avec 2 images !', 1, '2022-03-24 09:46:53', '2022-03-24 09:46:53'),
(4, 1, 'Test de post avec 3 images !', 1, '2022-03-24 09:47:25', '2022-03-24 09:47:25'),
(5, 1, 'Test de post avec 5 images !', 1, '2022-03-24 09:47:56', '2022-03-24 09:47:56'),
(6, 1, 'Test de publication avec le temps !', 0, '2022-03-24 09:58:03', '2022-03-24 09:58:03'),
(7, 1, '', 1, '2022-04-05 10:09:38', '2022-04-05 10:09:38'),
(15, 1, '', 1, '2022-04-06 14:56:31', '2022-04-06 14:56:31'),
(18, 3, 'Test de publication avec un compte utilisateur !', 1, '2022-04-06 11:10:06', '2022-04-06 11:10:06'),
(25, 1, 'test', 1, '2022-04-07 14:40:39', '2022-04-07 14:40:39'),
(27, 1, 'Blabla', 0, '2022-04-08 09:57:58', '2022-04-08 09:57:58'),
(28, 1, 'Ceci est un post de test !', 1, '2022-04-08 09:58:15', '2022-04-08 09:58:15'),
(29, 1, 'Article de test contenant beaucoup de caractères pour pouvoir faire des tests dans le panneau d&#039;administration ! J&#039;espère que le nombre de caractères sera suffisant pour les tests ! Blabla !!!', 1, '2022-04-08 14:28:33', '2022-04-08 15:28:55'),
(30, 1, 'test', 1, '2022-04-13 16:05:04', '2022-04-19 13:51:09'),
(31, 1, 'Test', 0, '2022-04-19 13:55:57', '2022-04-19 13:55:57'),
(32, 1, 'Blablabla123', 1, '2022-04-20 13:56:46', '2022-04-20 13:56:46'),
(33, 1, 'Test blablacar', 1, '2022-04-20 14:52:20', '2022-04-20 14:52:20'),
(34, 1, 'test....', 0, '2022-04-21 08:20:48', '2022-04-21 10:49:14'),
(35, 1, 'test blabla', 1, '2022-04-21 08:21:14', '2022-04-21 10:48:04'),
(36, 1, 'Test', 1, '2022-04-21 11:21:07', '2022-04-21 11:21:07'),
(37, 1, 'Voici quelques photos de mon dernier voyage ! En espérant y retourner rapidement !', 1, '2022-04-22 09:41:20', '2022-04-22 14:28:53');

-- --------------------------------------------------------

--
-- Structure de la table `article_image`
--

CREATE TABLE `article_image` (
  `name` varchar(255) NOT NULL,
  `id` int(11) NOT NULL COMMENT 'id de l''article'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article_image`
--

INSERT INTO `article_image` (`name`, `id`) VALUES
('1648111591_0.jpeg', 2),
('1648111613_0.jpeg', 3),
('1648111613_1.jpeg', 3),
('1648111645_0.jpeg', 4),
('1648111645_1.jpeg', 4),
('1648111645_2.jpeg', 4),
('1648111676_0.jpeg', 5),
('1648111676_1.jpeg', 5),
('1648111676_2.jpeg', 5),
('1648111676_3.jpeg', 5),
('1648111676_4.jpeg', 5),
('1648112978_0.png', 7),
('1648112978_1.jpeg', 7),
('1648112978_2.jpeg', 7),
('1648112978_3.jpeg', 7),
('1648112978_4.jpeg', 7),
('1648130191_0.jpeg', 15),
('1648130191_1.jpeg', 15),
('1648130191_2.jpeg', 15),
('1648130191_3.jpeg', 15),
('1648130191_4.jpeg', 15),
('1648203006_0.jpeg', 18),
('1648730439_0.jpeg', 25),
('1648730439_1.jpeg', 25),
('1648730439_2.jpeg', 25),
('1649404695_0.jpeg', 28),
('1649420913_0.jpeg', 29),
('1649420913_1.jpeg', 29),
('1649858704_0.jpeg', 30),
('1650455806_0.jpeg', 32),
('1650455806_1.jpeg', 32),
('1650459140_0.jpeg', 33),
('1650459140_1.jpeg', 33),
('1650459140_2.jpeg', 33),
('1650459140_3.jpeg', 33),
('1650459140_4.jpeg', 33),
('1650522074_0.jpeg', 35),
('1650532867_0.png', 36),
('1650613280_0.jpeg', 37),
('1650613280_1.jpeg', 37),
('1650613280_2.jpeg', 37),
('1650613280_3.jpeg', 37),
('1650613280_4.jpeg', 37);

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `article_id`, `user_id`, `content`, `created_at`, `updated_at`) VALUES
(1, 37, 3, 'Les photos sont superbes !', '2022-04-25 09:04:51', '2022-04-25 09:04:51'),
(2, 37, 5, 'Ca donne envie de partir en voyage !', '2022-04-25 09:05:54', '2022-04-25 09:05:54'),
(3, 37, 6, 'J\'y ai été il y a 2 ans aussi. Que de bons souvenirs ! Une destination de rêve ! Je conseil vraiment ;)', '2022-04-25 09:08:04', '2022-04-25 09:08:04'),
(4, 36, 1, 'po\r\n', '2022-04-26 11:16:47', '2022-04-26 11:16:47'),
(5, 36, 1, 'Commentaire de test\r\n', '2022-04-26 11:17:22', '2022-04-26 11:17:22'),
(6, 35, 1, 'Blabla\r\n', '2022-04-26 11:17:36', '2022-04-26 11:17:36'),
(7, 36, 1, 'Blablabla\r\n', '2022-04-26 11:18:57', '2022-04-26 11:18:57'),
(8, 37, 1, 'Test\r\n', '2022-04-26 11:24:39', '2022-04-26 11:24:39'),
(9, 37, 1, 'Test\r\n', '2022-04-26 11:24:45', '2022-04-26 11:24:45'),
(10, 37, 1, 'Hello World!', '2022-04-26 11:27:19', '2022-04-26 11:27:19'),
(11, 37, 1, 'Blabla !', '2022-04-26 11:28:38', '2022-04-26 11:28:38'),
(12, 36, 3, 'Super test de commentaire !', '2022-04-26 11:32:37', '2022-04-26 11:32:37'),
(13, 37, 3, 'Superbes photos !', '2022-04-26 11:33:07', '2022-04-26 11:33:07'),
(14, 37, 1, 'Blabla !', '2022-04-26 11:34:30', '2022-04-26 11:34:30'),
(15, 37, 1, 'tttttt', '2022-04-26 11:35:54', '2022-04-26 11:35:54'),
(16, 37, 1, 'ttttt', '2022-04-26 11:55:02', '2022-04-26 11:55:02');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `lastname` varchar(80) NOT NULL,
  `firstname` varchar(80) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL DEFAULT 'undefined',
  `job` varchar(120) NOT NULL DEFAULT 'undefined',
  `birthday_date` date NOT NULL,
  `gender` tinyint(1) NOT NULL COMMENT '0 = woman; 1 = man',
  `image_profile` varchar(40) NOT NULL COMMENT 'Nom de l''image de profil',
  `image_cover` varchar(40) NOT NULL COMMENT 'Nom de l''image de couverture',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `lastname`, `firstname`, `email`, `password`, `address`, `job`, `birthday_date`, `gender`, `image_profile`, `image_cover`, `created_at`, `updated_at`, `admin`) VALUES
(1, 'Admin', 'Administrateur', 'admin@gmail.com', '$2y$10$UOv7KMlJshzsWqbj5m19Ter3e/Sc0W.rBr7TEipM0nHViwELmB.RO', 'Vannes (56)', 'Développeur Web', '2022-03-01', 0, '1646321094.png', '', '2022-03-03 10:58:25', '2022-04-20 15:01:09', 1),
(2, 'User', 'Utilisateur', 'user@gmail.com', '$2y$10$bhAnv5va7ZQ/rJOC5zrbMeXlHNG1uvtkoHYMyKrVrOD3i1gYE1L2S', 'undefined', 'undefined', '2022-03-01', 1, '', '', '2022-03-03 11:02:01', '2022-03-03 11:02:01', 0),
(3, 'Goulard', 'Daniel', 'dgd.contact@gmail.com', '$2y$10$NOkHd8q.st6CT0zcL9J2OOaGOtL9HIZiFkzNAi54Sy4LfN/UsRj0q', 'undefined', 'undefined', '1983-12-15', 0, '1648133355.png', '', '2022-03-24 15:49:15', '2022-03-24 15:49:15', 0),
(4, 'Goulard', 'Daniel', 'contact@gmail.com', '$2y$10$cHg3zhQYOBVioMox/aAuI.kjO2XgsouAzn.VLWRrlDfhNYip0qWW.', 'undefined', 'undefined', '1111-12-13', 0, '1648203975.png', '', '2022-03-25 11:26:15', '2022-03-25 11:26:15', 0),
(5, 'User', 'Test', 'test@gmail.com', '$2y$10$GoToRK0vwU.b2bi6XbvfdOFonQRktt75rKVdezJ7UqRMZCNH8pUhS', 'undefined', 'undefined', '1983-12-15', 0, '1649399732.png', '', '2022-04-08 08:35:32', '2022-04-08 08:35:32', 0),
(6, 'One', 'Test', 'testone@gmail.com', '$2y$10$CQlJpZNnNoUX0bgkkjtluO8OJ93EqAQIzXws0wlNi13eMic4XP1ku', 'undefined', 'undefined', '2022-01-01', 0, '1650360929.png', '', '2022-04-19 11:35:29', '2022-04-19 11:39:15', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_ibfk_1` (`user_id`);

--
-- Index pour la table `article_image`
--
ALTER TABLE `article_image`
  ADD KEY `article_id` (`id`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `article_image`
--
ALTER TABLE `article_image`
  ADD CONSTRAINT `article_image_ibfk_1` FOREIGN KEY (`id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
