-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3302
-- Généré le : lun. 15 juin 2020 à 14:52
-- Version du serveur :  8.0.19
-- Version de PHP : 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

INSERT INTO `role` (`role`) VALUES
('admin'),
('subscriber');

INSERT INTO `permit` (`status`) VALUES
('rejected'),
('valid'),
('waiting');

INSERT INTO `user` (`id`, `pseudo`, `password`, `email`, `date_creation`, `activation_key`, `enabled`) VALUES
(1, 'Admin', '$2y$10$rdf.N.ckoaS4e7dcKD/ndeAM8mVYpnSP0et7GaZ8TRo2RM496ka/C', '', '2020-04-24 11:49:10', 'd033e22ae348aeb5660fc2140aec35850c4da997', 2),
(2, 'Subscriber1', '$2y$10$.JW./lJMHdaz445iF/FtYuyEgK4hwiz03gkzb21UyhVYlZOY/A.o.', '', '2020-04-24 12:49:10', '91c52dbf5a162f3c86acc3573c30c41d20fb0116', 2),
(3, 'Subscriber2', '$2y$10$OJeUngXjD7R2o4Mgv/fFpue4YGJRnTKabAXr7BshvVd0PpxWM8xBa', '', '2020-04-24 13:49:10', '65e64e4c90596adabf931564367bb93a005bedf0', 2),
(4, 'Subscriber3', '$2y$10$CYEM2DTYo7AZs8/K37872eaeJVszZJZZRjb7VpJsUc/kio9rVbGjq', '', '2020-04-24 15:49:10', '1c47c74e7ce48e93909c2f22dd130257f872ad63', 1);

INSERT INTO `post` (`id`, `title`, `slug`, `content`, `abstract`, `date_creation`, `date_update`, `id_user`) VALUES
(1, 'Titre du premier article', 'titre-du-premier-article', 'Contenu du premier article.\r\n\r\n\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"\r\n\r\n\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 'Un premier article comme support de travail à la construction du site', '2020-04-24 11:49:10', '2020-04-24 11:49:10', 1),
(2, 'Titre du deuxième article', 'titre-du-deuxieme-article', 'Contenu du deuxième article.\r\n\r\n\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"\r\n\r\n\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 'Un deuxième article comme support de travail à la construction du site', '2020-04-24 11:49:10', '2020-04-25 11:49:10', 1),
(3, 'Titre du troisième article', 'titre-du-troisième-article', 'Contenu du troisième article.\r\n\r\n\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"\r\n\r\n\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 'Un troisième article comme support de travail à la construction du site', '2020-04-24 11:49:10', '2020-04-26 11:49:10', 1),
(4, 'Titre du quatrième article', 'titre-du-quatrième-article', 'Contenu du quatrième article.\r\n\r\n\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"\r\n\r\n\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 'Un quatrième article comme support de travail à la construction du site', '2020-04-24 11:49:10', '2020-04-27 11:49:10', 1);

INSERT INTO `comment` (`id`, `content`, `date_creation`, `status`, `id_post`, `id_user`) VALUES
(1, 'Je suis le commentaire n°1 de l\'article n°1, et dont l\'auteur est admin, et je suis validé', '2020-04-24 11:49:10', 'valid', 1, 1),
(2, 'Je suis le commentaire n°2 de l\'article n°1, et dont l\'auteur est subscriber1, et je suis validé', '2020-04-24 12:49:10', 'valid', 1, 2),
(3, 'Je suis le commentaire n°3 de l\'article n°1, et dont l\'auteur est subscriber1, et je suis en attente', '2020-04-24 13:49:10', 'waiting', 1, 2),
(4, 'Je suis le commentaire n°4 de l\'article n°1, et dont l\'auteur est subscriber2, et je suis rejeté', '2020-04-24 14:49:10', 'rejected', 1, 3),
(5, 'Je suis le commentaire n°5 surl\'article n°1, et dont l\'auteur est subscriber2, et je suis en attente', '2020-04-24 15:49:10', 'waiting', 1, 3);

INSERT INTO `role_user` (`id`, `role`) VALUES
(1, 'admin'),
(2, 'subscriber'),
(3, 'subscriber'),
(4, 'subscriber');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
