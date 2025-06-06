-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : chaudiere-db
-- Généré le : ven. 06 juin 2025 à 09:10
-- Version du serveur : 11.4.6-MariaDB
-- Version de PHP : 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lachaudiere`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Concert'),
(3, 'Conférence'),
(2, 'Exposition');

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `price`, `start_date`, `end_date`, `time`, `category_id`, `created_by`, `created_at`) VALUES
(1, 'Rock à La Chaudière', 'Un concert énergique de rock indépendant.', 15.00, '2025-06-20', NULL, '20:30:00', 1, 1, '2025-06-05 12:33:09'),
(2, 'Expo Photo Noir & Blanc', 'Une collection de photographies classiques.', 0.00, '2025-07-01', '2025-07-15', NULL, 2, 2, '2025-06-05 12:33:09'),
(3, 'Conférence : Écologie et Climat', 'Présentation sur les enjeux écologiques actuels.', 5.00, '2025-06-22', NULL, '18:00:00', 3, 1, '2025-06-05 12:33:09'),
(4, 'Enim nulla.', 'Et adipisci ut sapiente dolore aut eos quis. Eum deserunt dolorum iusto laborum. Distinctio blanditiis neque et veritatis amet. Illo magnam in veritatis sint quia.', 11.80, '2025-10-16', '2025-10-18', NULL, 1, 2, '2025-06-06 08:58:55'),
(7, 'Aliquid rerum est.', 'Excepturi a ea et officia dolores non et. A minima dignissimos dolorem error ratione ea ut. Facere dolores doloribus qui quidem voluptatem ratione consequuntur. Dolorem eveniet quam asperiores sequi beatae omnis sunt.', 18.89, '1985-07-14', '1974-01-27', NULL, 1, 1, '2025-06-06 09:07:43'),
(8, 'Natus incidunt.', 'Hic porro sint mollitia consequatur. Laudantium dolorem facilis ut quia reprehenderit pariatur. Impedit et id nobis ut odit repudiandae.', 16.96, '1980-06-30', '1977-07-12', NULL, 2, 2, '2025-06-06 09:07:43'),
(9, 'Dolores voluptate aut ad.', 'Odio dolorum est similique dolorem molestiae nihil. Eos vero animi molestiae. Dolorem doloremque qui aut nulla dolorum neque et. Est ratione ducimus perspiciatis eos.', 62.27, '1992-09-16', '1987-06-05', NULL, 3, 2, '2025-06-06 09:07:43'),
(10, 'Voluptate similique dolores quidem.', 'Repudiandae est dolore hic eum impedit sit. Magni iste fugiat eaque accusamus. Totam temporibus et et non voluptate atque.', 22.61, '1985-07-19', '1979-07-23', NULL, 3, 2, '2025-06-06 09:07:43'),
(11, 'Ipsum aut voluptatem sapiente qui.', 'Asperiores eos harum fuga. Cum reiciendis cumque unde nam est ea molestias. Nihil eveniet eos voluptatem consectetur aut accusantium soluta. Quo voluptatem soluta aut excepturi sit.', 53.81, '2007-03-29', '2002-05-29', NULL, 2, 1, '2025-06-06 09:07:43'),
(12, 'Et vero sequi est.', 'Eveniet tempora error eveniet dolorem voluptatum sit itaque. Labore laborum quae debitis itaque odio. Eos similique aliquam velit doloribus quia cupiditate ducimus. Eos cumque non aut qui maiores sapiente. Pariatur soluta provident odit officia blanditiis doloremque quo sed.', 22.72, '1990-03-12', '1990-01-17', NULL, 2, 2, '2025-06-06 09:07:43'),
(13, 'Non odit quia.', 'Est non in et rerum at id autem. Placeat id omnis et ut sit quo tempore. Illo qui qui est eum corporis ut. Vel et consequuntur ea in et reprehenderit facere.', 52.72, '1998-01-13', '1978-03-28', NULL, 3, 1, '2025-06-06 09:07:43'),
(14, 'Reiciendis sit fuga quia et.', 'Ducimus ipsum nam illo autem sed voluptas. Soluta amet dicta officiis qui laboriosam. Error unde iusto debitis consequuntur saepe exercitationem optio. Laboriosam amet sed ea velit eos.', 36.29, '2016-02-23', '1983-07-31', NULL, 1, 2, '2025-06-06 09:07:43'),
(15, 'Praesentium sed aperiam voluptatem.', 'Quam consectetur dolore aperiam laborum quis autem. Nostrum et ipsam quis temporibus debitis velit. Voluptatem porro a necessitatibus aperiam.', 18.58, '1975-06-24', '1973-02-28', NULL, 3, 2, '2025-06-06 09:07:43'),
(16, 'Cumque officia perferendis deleniti.', 'Recusandae qui temporibus sint voluptatem. Assumenda ullam eum illum iste porro aut repellat. Non omnis aut corrupti voluptatem ad molestiae animi.', 69.24, '2023-07-19', '1992-08-18', NULL, 1, 1, '2025-06-06 09:07:43'),
(17, 'Rerum enim accusamus enim dicta.', 'Id delectus dolorem enim debitis numquam. Voluptatem itaque eaque veritatis blanditiis quia. Rerum dolorem aut optio minima et est possimus illo. Minima non aut qui dolor est.', 95.57, '1984-07-23', '1975-07-22', NULL, 1, 1, '2025-06-06 09:07:43'),
(18, 'Aut exercitationem iure dolores.', 'Iusto dolor perferendis aut eligendi cum. Suscipit qui aut iste provident ab nisi.', 34.54, '1989-06-20', '1989-05-30', NULL, 3, 2, '2025-06-06 09:07:43'),
(19, 'Iure culpa.', 'Quis maxime sit eveniet et ut placeat. Et rerum autem ad sed sit eaque.', 9.05, '2013-10-13', '1996-03-20', NULL, 1, 2, '2025-06-06 09:07:43'),
(20, 'Autem fugiat id consequatur.', 'Consequuntur blanditiis neque vitae qui. Optio consequatur quae ipsam nostrum dolores odio sed. Ut sit at fugiat non quia. Sequi id rem dolor.', 36.48, '2001-12-28', '1977-10-08', NULL, 1, 2, '2025-06-06 09:07:43'),
(21, 'Nobis est suscipit ut.', 'Dolorum sapiente provident repudiandae aut similique numquam. Quam est molestiae dolores praesentium culpa maiores.', 5.45, '2005-05-24', '1983-02-24', NULL, 2, 2, '2025-06-06 09:07:43'),
(22, 'Ad in animi.', 'Expedita dolorum repellendus nihil porro dolores hic. Adipisci assumenda eum et architecto. Minima atque iste deleniti consequatur. Commodi at et tempore consequuntur consequatur quidem eos.', 41.80, '1992-06-12', '1987-06-06', NULL, 3, 2, '2025-06-06 09:07:43'),
(23, 'Autem sapiente repellendus.', 'Quia id porro praesentium perspiciatis ipsa corporis et iure. Quae et est veritatis. Consequatur rem ab nemo et.', 62.32, '2006-10-14', '1995-11-28', NULL, 3, 2, '2025-06-06 09:07:43'),
(24, 'Praesentium eum exercitationem exercitationem.', 'Laudantium eveniet quo nemo. Est ex laborum qui iusto iste ea voluptatem commodi. Et nesciunt vitae eum quae hic. Dignissimos dignissimos qui eos harum doloribus culpa voluptatem.', 28.41, '1991-09-21', '1976-08-17', NULL, 2, 1, '2025-06-06 09:07:43'),
(25, 'Mollitia quia natus.', 'Quisquam nihil temporibus neque cum quam saepe et. Maiores culpa voluptatibus eius id sapiente incidunt ullam. Nesciunt corrupti in eius rem.', 26.74, '1972-05-23', '1972-04-10', NULL, 3, 1, '2025-06-06 09:07:43'),
(26, 'Itaque aut quo.', 'Rem adipisci tempore asperiores maxime atque atque ipsa vel. Vel commodi eos corrupti non ut.', 21.01, '1995-10-07', '1971-07-23', NULL, 3, 2, '2025-06-06 09:07:43');

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','super-admin') NOT NULL DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin01', '$2y$10$z6MPHEDbscCh0cW7XsLHPuTxv/hKMdrL1eFVoDKRkzFv/yWsvKoCi', 'admin', '2025-06-05 12:33:09'),
(2, 'superadmin01', '$2y$10$6f1zUd.NUR2zZj3mTklD0uC2DK6UmsfnxCwz8Hhx0/6rULpguUG7a', 'super-admin', '2025-06-05 12:33:09');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_events_category` (`category_id`),
  ADD KEY `fk_events_user` (`created_by`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_images_event` (`event_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk_events_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_events_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `fk_images_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
