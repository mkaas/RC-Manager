<?php
	
	session_start();
	include_once('includes/functions.inc.php');
	chkUserSession();
	chkUserLevel($_SESSION['username']);
	
	htmlHeader();
	
	crBanner();
	crMenu($_SESSION['userlevel']);
	br('2');
	getBatDetail($_POST['bat_id']);
	br(1);
	getLogbook('battery',$_POST['tx_id'],$_SESSION['username']);
	
	htmlFooter();
?>