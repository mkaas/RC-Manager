<?php
	
	session_start();
	include_once('includes/functions.inc.php');
	
	htmlHeader();
	
	crBanner();
	crMenu('index');
	br('2');
	crLoginFrm(); /* Create a SSH2 based login here */
	//chPage('main.php');
	
	htmlFooter();
?>