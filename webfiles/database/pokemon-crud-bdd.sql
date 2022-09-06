-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           5.7.33 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour crud-pokemon
CREATE DATABASE IF NOT EXISTS `crud-pokemon` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `crud-pokemon`;

-- Listage de la structure de la table crud-pokemon. pokemon_games
CREATE TABLE IF NOT EXISTS `pokemon_games` (
  `pkmn_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pkmn_game_name` varchar(255) DEFAULT '',
  `pkmn_generation` int(11) DEFAULT '0',
  `pkmn_release_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pkmn_support` varchar(255) DEFAULT '',
  `pkmn_img` varchar(255) DEFAULT '',
  PRIMARY KEY (`pkmn_id`),
  UNIQUE KEY `pkmn_id` (`pkmn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Listage des données de la table crud-pokemon.pokemon_games : ~5 rows (environ)
/*!40000 ALTER TABLE `pokemon_games` DISABLE KEYS */;
INSERT INTO `pokemon_games` (`pkmn_id`, `pkmn_game_name`, `pkmn_generation`, `pkmn_release_date`, `pkmn_support`, `pkmn_img`) VALUES
	(1, 'pokemon rouge', 2, '2005-10-11 00:00:00', 'game boy', 'https://image.winudf.com/v2/image/Y29tLnBjaGF0LnBjaGF0X2ljb25fMF9jMzY3NjliNw/icon.png?fakeurl=1&h=240&type=webp'),
	(2, 'pokemon jaune', 2, '2001-10-11 00:00:00', 'game boy', NULL),
	(3, 'pokemon rouge', 2, '2022-08-29 00:00:00', 'game boy', NULL),
	(4, 'pokemon rouge', 1, '2022-08-29 00:00:00', 'game boy', NULL),
	(5, 'sasas', 6, '2022-08-29 00:00:00', 'sasa', 'https://image.winudf.com/v2/image/Y29tLnBjaGF0LnBjaGF0X2ljb25fMF9jMzY3NjliNw/icon.png?fakeurl=1&h=240&type=webp');
/*!40000 ALTER TABLE `pokemon_games` ENABLE KEYS */;

-- Listage de la structure de la table crud-pokemon. users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_img` varchar(255) NOT NULL DEFAULT 'https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Listage des données de la table crud-pokemon.users : ~6 rows (environ)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_img`, `created_at`) VALUES
	(2, 'name_test', 'email_test', 'password_email', 'img_email', '2022-08-30 01:58:45'),
	(3, '?', '?', '?', '?', '2022-08-30 01:59:26'),
	(11, 'Leona', 'leon.kennedy@gmail.com', 'd85f2fdda07fb418d5efd5842ac54a8edd25a8ea7e8bd63beac52f59e0d30a8a6b03853d007c6ad54e222f8ea1f5338356d8d8f03ae04178eba68e86e75e54f1', 'https://www.science-et-vie.com/wp-content/uploads/scienceetvie/2021/08/quel-est-ancetre-chat-scaled.jpg', '2022-08-31 23:22:39'),
	(12, 'yaya', 'aaa@gg.col', 'd85f2fdda07fb418d5efd5842ac54a8edd25a8ea7e8bd63beac52f59e0d30a8a6b03853d007c6ad54e222f8ea1f5338356d8d8f03ae04178eba68e86e75e54f1', 'https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png', '2022-09-04 23:21:28'),
	(13, 'tata', 'ata@gg.col', 'ce5dd9cf199d681bda47f303c74349d1ab02502ed0edb1411d744ce482ff3d304740c7223946bfa678a53a7bef87ff696910781a2f4e515b81ffeb1d0cb23d02', 'https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png', '2022-09-04 23:21:54'),
	(15, 'Leon', 'leon.kennedy@gmail.com', 'a5bf92853455e7306c5db87766f9277ca22a24c1307ac6ce94ba171c92d152d5dc7f9b5102b550c057240d0134e43e8739424e11c1ed56143d15496fd3e59a9a', 'https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png', '2022-09-06 23:37:07');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
