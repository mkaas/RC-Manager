<?php
	
	session_start();
	include_once('includes/functions.inc.php');
	chkUserSession();
	chkUserLevel($_SESSION['username']);
	
	htmlHeader();
	
	crBanner();
	crMenu($_SESSION['userlevel']);
	br('2');
	
	
	htmlFooter();
?>