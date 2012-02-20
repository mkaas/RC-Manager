<?php
	
	session_start();
	include_once('includes/functions.inc.php');
	chkUserSession();
	chkUserLevel($_SESSION['username']);
	
	htmlHeader();
	
	crBanner();
	crMenu($_SESSION['userlevel']);
	br('2');
	getTxDetail($_POST['tx_id']);
	br(1);
	getLogbook('transmitter',$_POST['tx_id'],$_SESSION['username']);
	
	htmlFooter();
?>