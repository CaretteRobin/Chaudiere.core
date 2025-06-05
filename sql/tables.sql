-- ------------------------------------------------------------------
-- Base de données : lachaudiere
-- ------------------------------------------------------------------

-- 1) Création de la base (si elle n’existe pas déjà)
CREATE DATABASE IF NOT EXISTS `lachaudiere`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE `lachaudiere`;

-- 2) Table users (utilisateurs / authentification)
--    - id           : identifiant unique
--    - username     : identifiant de connexion (unique)
--    - password     : mot de passe (hashé)
--    - role         : rôle de l’utilisateur (admin, super-admin)
--    - created_at   : date de création du compte
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','super-admin') NOT NULL DEFAULT 'admin',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- 3) Table categories (types d’événements)
--    - id   : identifiant unique
--    - name : libellé du type (ex. "concert", "expo", "conférence")
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- 4) Table events (événements)
--    - id           : identifiant unique
--    - title        : titre de l’événement
--    - description  : description (texte libre, markdown possible)
--    - price        : tarif (décimal, deux décimales)
--    - start_date   : date de début (ou date unique)
--    - end_date     : date de fin (NULL si événement ponctuel)
--    - time         : horaire (NULL si non concerné)
--    - category_id  : référence vers categories(id)
--    - created_by   : référence vers users(id) (éditeur/créateur)
--    - created_at   : date de création de l’enregistrement
CREATE TABLE IF NOT EXISTS `events` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  `price` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
  `start_date` DATE NULL,
  `end_date` DATE NULL,
  `time` TIME NULL,
  `category_id` INT NOT NULL,
  `created_by` INT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_events_category`
    FOREIGN KEY (`category_id`)
    REFERENCES `categories` (`id`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
  CONSTRAINT `fk_events_user`
    FOREIGN KEY (`created_by`)
    REFERENCES `users` (`id`)
    ON UPDATE CASCADE
    ON DELETE SET NULL
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- 5) Table images (liées aux événements)
--    - id       : identifiant unique
--    - url      : URL ou chemin relatif de l’image
--    - event_id : référence vers events(id)
CREATE TABLE IF NOT EXISTS `images` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `url` VARCHAR(255) NOT NULL,
  `event_id` INT NOT NULL,
  CONSTRAINT `fk_images_event`
    FOREIGN KEY (`event_id`)
    REFERENCES `events` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

  
