<?php
	
	session_start();
	include_once('includes/functions.inc.php');
	
	$_SESSION['unit_id'] = $_POST['unit_id'];
	
	chkUserSession();
	chkUserLevel($_SESSION['username']);
	
	htmlHeader();
	
	crBanner();
	crMenu($_SESSION['userlevel']);
	br('2');
	getUnitDetail($_POST['unit_id']);
	br(1);
	getLogbook('unit',$_POST['unit_id'],$_SESSION['username']);
	
	htmlFooter();
?>