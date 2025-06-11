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
    `name` VARCHAR(100) NOT NULL UNIQUE,
    `description` TEXT DEFAULT NULL
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
    `is_published` BOOLEAN NOT NULL DEFAULT 0,
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
INSERT INTO `users` (`id`, `password`, `email`, `role`, `created_at`) VALUES
('7518ff26-e3c3-42a6-9e55-a732a5e6d3aa', '$2y$10$.KuWiwwGXSM7vJZALi.r0OnSqbLckxnGk2b0uJFXE5yIU9DRBHSnW', 'superadmin@example.com', 'super-admin', '2025-06-06 09:39:30'),
('d4447e5d-ab66-4dfc-9c52-89cd383816bc', '$2y$10$.KuWiwwGXSM7vJZALi.r0OnSqbLckxnGk2b0uJFXE5yIU9DRBHSnW', 'admin@example.com', 'admin', '2025-06-06 09:39:30');

-- 8) Insertion des catégories
INSERT INTO `categories` (`id`, `name`, `description`) VALUES
('d87ce908-039d-4989-bfbe-55211de45d85', 'Concert', 'Événements musicaux en direct, allant des concerts de rock aux performances acoustiques.'),
('61392df6-6bd1-4d7b-aeda-520b55171c53', 'Exposition', 'Expositions d’art, de photographie et d’autres formes d’art visuel.'),
('acc63b80-b9f7-4fb8-8e8a-66582eabb203', 'Conférence', 'Conférences et séminaires sur divers sujets, allant de la science à la culture.');

-- 9) Insertion des événements
INSERT INTO `events` (`id`, `title`, `description`, `price`, `start_date`, `end_date`, `time`, `category_id`, `created_by`, `created_at`) VALUES
('d2b7f1e8-222e-4f90-9c4d-8b0f90fe15f1', 'Rock à La Chaudière', 'Un concert énergique de rock indépendant.', 15.00, '2025-06-20', NULL, '20:30:00', 'd87ce908-039d-4989-bfbe-55211de45d85', '7518ff26-e3c3-42a6-9e55-a732a5e6d3aa', '2025-06-05 12:33:09'),
('45ea2b4f-201e-48b0-9b7a-9102f89f4bd2', 'Expo Photo Noir & Blanc', 'Une collection de photographies classiques.', 0.00, '2025-07-01', '2025-07-15', NULL, '61392df6-6bd1-4d7b-aeda-520b55171c53', 'd4447e5d-ab66-4dfc-9c52-89cd383816bc', '2025-06-05 12:33:09'),
('e5f7c3be-c43a-4d7a-8f69-d56db3f9d063', 'Conférence : Écologie et Climat', 'Présentation sur les enjeux écologiques actuels.', 5.00, '2025-06-22', NULL, '18:00:00', 'acc63b80-b9f7-4fb8-8e8a-66582eabb203', '7518ff26-e3c3-42a6-9e55-a732a5e6d3aa', '2025-06-05 12:33:09'),
('3ab4ede8-3d39-4d29-91f7-662ee3b4e150', 'Enim nulla.', 'Et adipisci ut sapiente douleur aut eos quis. Eum deserunt dolorum iusto laborum.', 11.80, '2025-10-16', '2025-10-18', NULL, 'd87ce908-039d-4989-bfbe-55211de45d85', 'd4447e5d-ab66-4dfc-9c52-89cd383816bc', '2025-06-06 08:58:55'),
('9dcd10a2-2fa5-447a-a3c8-df4e84dfcdfe', 'Aliquid rerum est.', 'Excepturi a ea et officia dolores non et.', 18.89, '1985-07-14', '1974-01-27', NULL, 'd87ce908-039d-4989-bfbe-55211de45d85', '7518ff26-e3c3-42a6-9e55-a732a5e6d3aa', '2025-06-06 09:07:43'),
('a94e90a3-62b3-404f-9a64-d4c8f9e6b1b4', 'Natus incidunt.', 'Hic porro sint mollitia consequatur.', 16.96, '1980-06-30', '1977-07-12', NULL, '61392df6-6bd1-4d7b-aeda-520b55171c53', 'd4447e5d-ab66-4dfc-9c52-89cd383816bc', '2025-06-06 09:07:43'),
('1bf3a4e2-66a9-4c24-9a4b-cf34bf5afe1c', 'Dolores voluptate aut ad.', 'Odio dolorum est similique dolorem molestiae nihil.', 62.27, '1992-09-16', '1987-06-05', NULL, 'acc63b80-b9f7-4fb8-8e8a-66582eabb203', 'd4447e5d-ab66-4dfc-9c52-89cd383816bc', '2025-06-06 09:07:43'),
('7e69c2f4-2219-4559-9ee8-b9841e380e6d', 'Voluptate similique dolores quidem.', 'Repudiandae est douleur hic eum impedit sit.', 22.61, '1985-07-19', '1979-07-23', NULL, 'acc63b80-b9f7-4fb8-8e8a-66582eabb203', 'd4447e5d-ab66-4dfc-9c52-89cd383816bc', '2025-06-06 09:07:43'),
('f51c586b-1345-48c1-8fa2-5e8c5b2c0b48', 'Ipsum aut voluptatem sapiente qui.', 'Asperiores eos harum fuga.', 53.81, '2007-03-29', '2002-05-29', NULL, '61392df6-6bd1-4d7b-aeda-520b55171c53', '7518ff26-e3c3-42a6-9e55-a732a5e6d3aa', '2025-06-06 09:07:43'),
('cd9a946d-0914-4e99-b1f7-cc58f6b474d2', 'Et vero sequi est.', 'Eveniet tempora error eveniet dolorem.', 22.72, '1990-03-12', '1990-01-17', NULL, '61392df6-6bd1-4d7b-aeda-520b55171c53', 'd4447e5d-ab66-4dfc-9c52-89cd383816bc', '2025-06-06 09:07:43'),
('8f10d73a-efce-4bb2-9f23-afafc9c8ed0e', 'Non odit quia.', 'Est non in et rerum at id autem.', 52.72, '1998-01-13', '1978-03-28', NULL, 'acc63b80-b9f7-4fb8-8e8a-66582eabb203', '7518ff26-e3c3-42a6-9e55-a732a5e6d3aa', '2025-06-06 09:07:43'),
('69e50f7e-4e1f-489d-80de-fc8c7c7a4e1d', 'Reiciendis sit fuga quia et.', 'Ducimus ipsum nam illo autem sed.', 36.29, '2016-02-23', '1983-07-31', NULL, 'd87ce908-039d-4989-bfbe-55211de45d85', 'd4447e5d-ab66-4dfc-9c52-89cd383816bc', '2025-06-06 09:07:43'),
('23793d89-bf47-41b7-a1f9-24d3bd2a8a5a', 'Praesentium sed aperiam voluptatem.', 'Quam consectetur dolore aperiam laborum quis.', 18.58, '1975-06-24', '1973-02-28', NULL, 'acc63b80-b9f7-4fb8-8e8a-66582eabb203', 'd4447e5d-ab66-4dfc-9c52-89cd383816bc', '2025-06-06 09:07:43'),
('4e9b0bff-3a07-4b8c-895c-aa3bb7b6d78c', 'Cumque officia perferendis deleniti.', 'Recusandae qui temporibus sint voluptatem.', 69.24, '2023-07-19', '1992-08-18', NULL, 'd87ce908-039d-4989-bfbe-55211de45d85', '7518ff26-e3c3-42a6-9e55-a732a5e6d3aa', '2025-06-06 09:07:43'),
('e2e047fd-2d91-4b0d-bf9c-6d9c5b5c82d3', 'Rerum enim accusamus enim dicta.', 'Id delectus dolorem enim debitis numquam.', 95.57, '1984-07-23', '1975-07-22', NULL, 'd87ce908-039d-4989-bfbe-55211de45d85', '7518ff26-e3c3-42a6-9e55-a732a5e6d3aa', '2025-06-06 09:07:43'),
('b25cdda6-83ec-4f8d-91f3-0d0a5f4ae987', 'Aut exercitationem iure dolores.', 'Iusto dolor perferendis aut eligendi.', 34.54, '1989-06-20', '1989-05-30', NULL, 'acc63b80-b9f7-4fb8-8e8a-66582eabb203', 'd4447e5d-ab66-4dfc-9c52-89cd383816bc', '2025-06-06 09:07:43'),
('a12e3b44-51d2-4169-8fcd-cc1d9a9eeba3', 'Iure culpa.', 'Quis maxime sit eveniet et ut placeat.', 9.05, '2013-10-13', '1996-03-20', NULL, 'd87ce908-039d-4989-bfbe-55211de45d85', 'd4447e5d-ab66-4dfc-9c52-89cd383816bc', '2025-06-06 09:07:43'),
('f7aaf8e4-0224-4f64-a054-d60a3dcd4f8f', 'Autem fugiat id consequatur.', 'Consequuntur blanditiis neque vitae qui.', 36.48, '2001-12-28', '1977-10-08', NULL, 'd87ce908-039d-4989-bfbe-55211de45d85', 'd4447e5d-ab66-4dfc-9c52-89cd383816bc', '2025-06-06 09:07:43'),
('1c9ba9f7-9f3e-4c07-8891-54d2a7ea9e3e', 'Nobis est suscipit ut.', 'Dolorum sapiente provident repudiandae.', 5.45, '2005-05-24', '1983-02-24', NULL, '61392df6-6bd1-4d7b-aeda-520b55171c53', 'd4447e5d-ab66-4dfc-9c52-89cd383816bc', '2025-06-06 09:07:43'),
('c8f4a123-359e-42b4-bb8a-3f5f7c25d8e1', 'Ad in animi.', 'Expedita dolorum repellendus nihil.', 41.80, '1992-06-12', '1987-06-06', NULL, 'acc63b80-b9f7-4fb8-8e8a-66582eabb203', 'd4447e5d-ab66-4dfc-9c52-89cd383816bc', '2025-06-06 09:07:43'),
('97e2bc5d-624d-4a6a-bf2b-d5a933b46c12', 'Autem sapiente repellendus.', 'Quia id porro praesentium perspiciatis.', 62.32, '2006-10-14', '1995-11-28', NULL, 'acc63b80-b9f7-4fb8-8e8a-66582eabb203', 'd4447e5d-ab66-4dfc-9c52-89cd383816bc', '2025-06-06 09:07:43'),
('3be96e74-87b9-4afe-afd1-1e5af8c0d6c3', 'Praesentium eum exercitationem exercitationem.', 'Laudantium eveniet quo nemo.', 28.41, '1991-09-21', '1976-08-17', NULL, '61392df6-6bd1-4d7b-aeda-520b55171c53', '7518ff26-e3c3-42a6-9e55-a732a5e6d3aa', '2025-06-06 09:07:43'),
('2f4b6c03-6a38-42e2-815b-ad8f6aee2a79', 'Mollitia quia natus.', 'Quisquam nihil temporibus neque cum.', 26.74, '1972-05-23', '1972-04-10', NULL, 'acc63b80-b9f7-4fb8-8e8a-66582eabb203', '7518ff26-e3c3-42a6-9e55-a732a5e6d3aa', '2025-06-06 09:07:43'),
('5ebfaec7-b1cd-4f7e-bf97-d8f4716c9c76', 'Itaque aut quo.', 'Rem adipisci tempore asperiores maxime.', 21.01, '1995-10-07', '1971-07-23', NULL, 'acc63b80-b9f7-4fb8-8e8a-66582eabb203', 'd4447e5d-ab66-4dfc-9c52-89cd383816bc', '2025-06-06 09:07:43');