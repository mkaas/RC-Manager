<?php
	
	session_start();
	include_once('includes/functions.inc.php');
	chkUserSession();
	chkUserLevel($_SESSION['username']);
	
	htmlHeader();
	
	crBanner();
	crMenu($_SESSION['usermenu']);
	br('2');
	echo $_SESSION['username'];
	echo ' | '.$_SESSION['userlevel'];
	echo ' | '.$_SESSION['usermenu'];
	
	htmlFooter();
?>