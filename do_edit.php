<?php

	session_start();
	include_once('includes/functions.inc.php');
	chkUserSession();
	chkUserLevel($_SESSION['username']);
	
	htmlHeader();
	
	crBanner();
	crMenu($_SESSION['userlevel']);
	br('2');
	switch($_SESSION['edit_type']){
		case 'unit':
			$id				= $_SESSION['unit_id'];
			$power			= $_POST['eud_power'];
			$type			= $_POST['eud_type'];
			$company		= $_POST['eud_company'];
			$model			= $_POST['eud_model'];
			$description	= $_POST['eud_description'];
			$picture		= $_POST['eud_picture'];
			
			include_once('includes/db.inc.php');
			$editSQL=mysql_query("UPDATE rc_units SET unt_powered='".$power."', unt_type='".$type."', unt_company='".$company."', unt_model='".$model."', unt_description='".$description."', unt_picture='".$picture."' WHERE unt_id='".$id."'") or die(mysql_error());
			chPage('units.php');
			break;
		case '':
			
			break;
		default:
			break;
	}

?>
