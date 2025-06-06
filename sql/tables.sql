-- ------------------------------------------------------------------
-- Base de données : lachaudiere
-- ------------------------------------------------------------------

-- 1) Création de la base
CREATE DATABASE IF NOT EXISTS `lachaudiere`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `lachaudiere`;

-- 2) Suppression des tables dans l’ordre inverse des dépendances
DROP TABLE IF EXISTS `images`;
DROP TABLE IF EXISTS `events`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `users`;

-- 3) Table users
CREATE TABLE `users` (
    `id` CHAR(36) PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'super-admin') NOT NULL DEFAULT 'admin',
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4) Table categories
CREATE TABLE `categories` (
    `id` CHAR(36) PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5) Table events
CREATE TABLE `events` (
    `id` CHAR(36) PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `start_date` DATE DEFAULT NULL,
    `end_date` DATE DEFAULT NULL,
    `time` TIME DEFAULT NULL,
    `category_id` CHAR(36) NOT NULL,
    `created_by` CHAR(36) DEFAULT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT `fk_events_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT `fk_events_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6) Table images
CREATE TABLE `images` (
    `id` CHAR(36) PRIMARY KEY,
    `url` VARCHAR(255) NOT NULL,
    `event_id` CHAR(36) NOT NULL,

    CONSTRAINT `fk_images_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7) Insertion des utilisateurs
INSERT INTO `users` (`id`, `email`, `password`, `role`, `created_at`) VALUES
('1', 'admin@lachaudiere.fr', '$2y$10$z6MPHEDbscCh0cW7XsLHPuTxv/hKMdrL1eFVoDKRkzFv/yWsvKoCi', 'admin', '2025-06-05 12:33:09'),
('2', 'superadmin@lachaudiere.fr', '$2y$10$6f1zUd.NUR2zZj3mTklD0uC2DK6UmsfnxCwz8Hhx0/6rULpguUG7a', 'super-admin', '2025-06-05 12:33:09');

-- 8) Insertion des catégories
INSERT INTO `categories` (`id`, `name`) VALUES
('1', 'Concert'),
('2', 'Exposition'),
('3', 'Conférence');

-- 9) Insertion des événements
INSERT INTO `events` (`id`, `title`, `description`, `price`, `start_date`, `end_date`, `time`, `category_id`, `created_by`, `created_at`) VALUES
('1', 'Rock à La Chaudière', 'Un concert énergique de rock indépendant.', 15.00, '2025-06-20', NULL, '20:30:00', '1', '1', '2025-06-05 12:33:09'),
('2', 'Expo Photo Noir & Blanc', 'Une collection de photographies classiques.', 0.00, '2025-07-01', '2025-07-15', NULL, '2', '2', '2025-06-05 12:33:09'),
('3', 'Conférence : Écologie et Climat', 'Présentation sur les enjeux écologiques actuels.', 5.00, '2025-06-22', NULL, '18:00:00', '3', '1', '2025-06-05 12:33:09'),
('4', 'Enim nulla.', 'Et adipisci ut sapiente dolore aut eos quis. Eum deserunt dolorum iusto laborum.', 11.80, '2025-10-16', '2025-10-18', NULL, '1', '2', '2025-06-06 08:58:55'),
('7', 'Aliquid rerum est.', 'Excepturi a ea et officia dolores non et.', 18.89, '1985-07-14', '1974-01-27', NULL, '1', '1', '2025-06-06 09:07:43'),
('8', 'Natus incidunt.', 'Hic porro sint mollitia consequatur.', 16.96, '1980-06-30', '1977-07-12', NULL, '2', '2', '2025-06-06 09:07:43'),
('9', 'Dolores voluptate aut ad.', 'Odio dolorum est similique dolorem molestiae nihil.', 62.27, '1992-09-16', '1987-06-05', NULL, '3', '2', '2025-06-06 09:07:43'),
('10', 'Voluptate similique dolores quidem.', 'Repudiandae est dolore hic eum impedit sit.', 22.61, '1985-07-19', '1979-07-23', NULL, '3', '2', '2025-06-06 09:07:43'),
('11', 'Ipsum aut voluptatem sapiente qui.', 'Asperiores eos harum fuga.', 53.81, '2007-03-29', '2002-05-29', NULL, '2', '1', '2025-06-06 09:07:43'),
('12', 'Et vero sequi est.', 'Eveniet tempora error eveniet dolorem.', 22.72, '1990-03-12', '1990-01-17', NULL, '2', '2', '2025-06-06 09:07:43'),
('13', 'Non odit quia.', 'Est non in et rerum at id autem.', 52.72, '1998-01-13', '1978-03-28', NULL, '3', '1', '2025-06-06 09:07:43'),
('14', 'Reiciendis sit fuga quia et.', 'Ducimus ipsum nam illo autem sed.', 36.29, '2016-02-23', '1983-07-31', NULL, '1', '2', '2025-06-06 09:07:43'),
('15', 'Praesentium sed aperiam voluptatem.', 'Quam consectetur dolore aperiam laborum quis.', 18.58, '1975-06-24', '1973-02-28', NULL, '3', '2', '2025-06-06 09:07:43'),
('16', 'Cumque officia perferendis deleniti.', 'Recusandae qui temporibus sint voluptatem.', 69.24, '2023-07-19', '1992-08-18', NULL, '1', '1', '2025-06-06 09:07:43'),
('17', 'Rerum enim accusamus enim dicta.', 'Id delectus dolorem enim debitis numquam.', 95.57, '1984-07-23', '1975-07-22', NULL, '1', '1', '2025-06-06 09:07:43'),
('18', 'Aut exercitationem iure dolores.', 'Iusto dolor perferendis aut eligendi.', 34.54, '1989-06-20', '1989-05-30', NULL, '3', '2', '2025-06-06 09:07:43'),
('19', 'Iure culpa.', 'Quis maxime sit eveniet et ut placeat.', 9.05, '2013-10-13', '1996-03-20', NULL, '1', '2', '2025-06-06 09:07:43'),
('20', 'Autem fugiat id consequatur.', 'Consequuntur blanditiis neque vitae qui.', 36.48, '2001-12-28', '1977-10-08', NULL, '1', '2', '2025-06-06 09:07:43'),
('21', 'Nobis est suscipit ut.', 'Dolorum sapiente provident repudiandae.', 5.45, '2005-05-24', '1983-02-24', NULL, '2', '2', '2025-06-06 09:07:43'),
('22', 'Ad in animi.', 'Expedita dolorum repellendus nihil.', 41.80, '1992-06-12', '1987-06-06', NULL, '3', '2', '2025-06-06 09:07:43'),
('23', 'Autem sapiente repellendus.', 'Quia id porro praesentium perspiciatis.', 62.32, '2006-10-14', '1995-11-28', NULL, '3', '2', '2025-06-06 09:07:43'),
('24', 'Praesentium eum exercitationem exercitationem.', 'Laudantium eveniet quo nemo.', 28.41, '1991-09-21', '1976-08-17', NULL, '2', '1', '2025-06-06 09:07:43'),
('25', 'Mollitia quia natus.', 'Quisquam nihil temporibus neque cum.', 26.74, '1972-05-23', '1972-04-10', NULL, '3', '1', '2025-06-06 09:07:43'),
('26', 'Itaque aut quo.', 'Rem adipisci tempore asperiores maxime.', 21.01, '1995-10-07', '1971-07-23', NULL, '3', '2', '2025-06-06 09:07:43');
