<?php
	
	session_start();
	include_once('includes/functions.inc.php');
	chkUserSession();
	chkUserLevel($_SESSION['username']);
	
	htmlHeader();
	
	crBanner();
	crMenu($_SESSION['userlevel']);
	br('2');

	$power = $_POST['add_power'];
	$type = $_POST['add_type'];
	$company = $_POST['add_company'];
	$model = $_POST['add_model'];
	$description = $_POST['add_description'];
	$picture = $_POST['add_picture'];
	
	addUnit($_SESSION['username'],$power,$type,$company,$model,$description,$picture);
	
	htmlFooter();
?>