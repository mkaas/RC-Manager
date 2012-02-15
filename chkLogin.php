<?php
	
	session_start();
	include_once('includes/functions.inc.php');
	
	htmlHeader();
	
	crBanner();
	crMenu('index');
	
	$_SESSION['username'] = $_POST['username'];
	
	chkLogin($_SESSION['username'],$_POST['password']);
	
	htmlFooter();
?>