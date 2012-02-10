-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 10 feb 2012 kl 12:41
-- Serverversion: 5.5.20
-- PHP-version: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `rcman`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `app_setup`
--

CREATE TABLE IF NOT EXISTS `app_setup` (
  `set_id` bigint(64) NOT NULL AUTO_INCREMENT,
  `set_title` varchar(20) NOT NULL,
  `set_version` varchar(20) NOT NULL,
  `set_revision` varchar(20) NOT NULL,
  `set_theme` varchar(60) NOT NULL,
  `set_active` enum('false','true') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`set_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumpning av Data i tabell `app_setup`
--

INSERT INTO `app_setup` (`set_id`, `set_title`, `set_version`, `set_revision`, `set_theme`, `set_active`) VALUES
(1, 'RC-Manager', '1.0', 'a', 'default', 'true');

-- --------------------------------------------------------

--
-- Tabellstruktur `rc_menu`
--

CREATE TABLE IF NOT EXISTS `rc_menu` (
  `mnu_id` bigint(64) NOT NULL AUTO_INCREMENT,
  `mnu_title` varchar(20) NOT NULL,
  `mnu_link` varchar(100) NOT NULL,
  `mnu_order` bigint(64) NOT NULL,
  `mnu_active` enum('false','true') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`mnu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumpning av Data i tabell `rc_menu`
--

INSERT INTO `rc_menu` (`mnu_id`, `mnu_title`, `mnu_link`, `mnu_order`, `mnu_active`) VALUES
(1, 'menu1', 'index.php', 10, 'true'),
(2, 'menu2', 'index.php', 20, 'true');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
