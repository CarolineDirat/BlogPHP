-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Version du serveur :  8.0.19
-- Version de PHP :  7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


-- status table

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  PRIMARY KEY (`status`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- user table

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activation_key` char(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) DEFAULT 0 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- post table

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `abstract` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- comment table

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `id_post` int NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- role table

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`role`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- role_user table

DROP TABLE IF EXISTS `role_user`;
CREATE TABLE IF NOT EXISTS `role_user` (
  `id` int NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`,`role`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =========================================================================
-- FOREIGN KEYS
-- ==========================================================================
ALTER TABLE post ADD CONSTRAINT user_post_fk
FOREIGN KEY (id_user)
REFERENCES user (id)
ON DELETE CASCADE;

ALTER TABLE comment ADD CONSTRAINT status_comment_fk
FOREIGN KEY (`status`)
REFERENCES status (`status`);

ALTER TABLE comment ADD CONSTRAINT user_comment_fk
FOREIGN KEY (id_user)
REFERENCES user (id)
ON DELETE CASCADE;

ALTER TABLE comment ADD CONSTRAINT post_comment_fk
FOREIGN KEY (id_post)
REFERENCES post (id)
ON DELETE CASCADE;

ALTER TABLE role_user ADD CONSTRAINT user_role_user_fk
FOREIGN KEY (id)
REFERENCES user (id)
ON DELETE CASCADE;

ALTER TABLE role_user ADD CONSTRAINT role_role_user_fk
FOREIGN KEY (`role`)
REFERENCES `role` (`role`);
