<?php
	
	session_start();
	include_once('includes/functions.inc.php');
	chkUserSession();
	chkUserLevel($_SESSION['username']);
	
	$_SESSION['edit_type'] = 'unit';
	
	htmlHeader();
	
	crBanner();
	crMenu($_SESSION['userlevel']);
	br('2');
	frmEditUnitDetail($_SESSION['unit_id']);
	
	htmlFooter();
?>