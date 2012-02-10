<?php

	/* Create an install script here... */
	include_once('../includes/db.inc.php');
	mysql_query("CREATE DATABASE rcman;") or die(mysql_error());
	mysql_query("CREATE TABLE IF NOT EXISTS `app_setup` (`set_id` bigint(64) NOT NULL AUTO_INCREMENT,`set_title` varchar(20) NOT NULL,`set_version` varchar(20) NOT NULL,`set_revision` varchar(20) NOT NULL,`set_theme` varchar(60) NOT NULL,`set_active` enum('false','true') NOT NULL DEFAULT 'false',PRIMARY KEY (`set_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;") or die(mysql_error());

?>
