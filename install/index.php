<?php

	/* Create an install script here... */
	include_once('../includes/db.inc.php');
	$cr_database = mysql_query("CREATE DATABASE rcman") or die(mysql_error());


?>
