-- Host: localhost
-- Generation Time: Jun 11, 2014 at 04:14 PM
-- Server version: 5.5.37-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `dildogenerator`
--

--
-- Table structure for table `custom_dildos`
--

CREATE TABLE IF NOT EXISTS `custom_dildos` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique table id.',
  `user_id` int(11) NOT NULL DEFAULT '-1' COMMENT 'A user ID from the auth system.',
  `bezier_path` varchar(4096) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The bezier path as a JSON string.',
  `bend` int(11) NOT NULL DEFAULT '0' COMMENT 'The bend settings (an integer from 0 to 180).',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='This table stores the custom dildo settings.' AUTO_INCREMENT=5 ;
