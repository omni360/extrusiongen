-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 21, 2014 at 01:13 AM
-- Server version: 5.5.37-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `dildogenerator`
--

-- --------------------------------------------------------

--
-- Table structure for table `custom_dildos`
--

CREATE TABLE IF NOT EXISTS `custom_dildos` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique table id.',
  `user_id` int(11) NOT NULL DEFAULT '-1' COMMENT 'A user ID from the auth system.',
  `bezier_path` varchar(4096) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The bezier path as a JSON string.',
  `bend` int(11) NOT NULL DEFAULT '0' COMMENT 'The bend settings (an integer from 0 to 180).',
  `date_created` int(18) NOT NULL DEFAULT '0' COMMENT 'The date of creation,',
  `date_updated` int(18) NOT NULL DEFAULT '0' COMMENT 'The date of last update.',
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'The dong''s name.',
  `user_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'The creator''s name/alias/pseudonym.',
  `email_address` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'The creator''s email address.',
  `hide_email_address` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Y' COMMENT 'Indicates if the email address must be hidden.',
  `allow_download` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Y' COMMENT 'Indicates if the model may be downloaded.',
  `allow_edit` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'Indicates if the bezier curve may be edited.',
  `preview_image` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'A base64 encoded png file. 136533bytes = 100kB in Bas64',
  `public_hash` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '00000000000000000000000000000000' COMMENT 'A public ID to address the design entry.',
  PRIMARY KEY (`id`),
  KEY `hide_email_address` (`hide_email_address`,`allow_download`,`allow_edit`),
  KEY `public_hash` (`public_hash`),
  KEY `date_created` (`date_created`,`date_updated`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='This table stores the custom dildo settings.' AUTO_INCREMENT=67 ;
