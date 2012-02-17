<?php

	function htmlHeader(){
		include_once('includes/db.inc.php');
		$appSQL=mysql_query("SELECT * FROM app_setup WHERE set_active='true' LIMIT 1") or die(mysql_error());
		while($arAPP=mysql_fetch_array($appSQL)){
			$title = $arAPP['set_title'];
			$version = $arAPP['set_version'];
			$revision = $arAPP['set_revision'];
			$theme = $arAPP['set_theme'];
			
			print '
				<html>
					<head>
						<title>'.$title.' '.$version.''.$revision.'</title>
						<link rel="stylesheet" type="text/css" href="css/'.$theme.'.css" />
					</head>
					<body>
			';
		}
	}
	
	function htmlFooter(){
		print '
				</body>
			</html>
		';
	}

	function crBanner(){
		include_once('includes/db.inc.php');
		$appSQL=mysql_query("SELECT * FROM app_setup WHERE set_active='true' LIMIT 1") or die(mysql_error());
		while($arAPP=mysql_fetch_array($appSQL)){
			$title = $arAPP['set_title'];
			$version = $arAPP['set_version'];
			$revision = $arAPP['set_revision'];
		}
		print '
			<table border="0" cellspacing="0" cellpadding="0" class="banner" style="width:100%">
				<tr>
					<td class="banner-bg">'.$title.' '.$version.''.$revision.'</td>
				</tr>
			</table>
		';
	}
	
	function crMenu($type){
		switch($type){ /* Differencierer mellem om menu-punkter skal vises eller ej. */
			case 'index':
				include_once('includes/db.inc.php');
				print '<table border="0" cellspacing="0" cellpadding="0" class="menu-bg" style="width:100%"><tr><td><table border="0" cellspacing="0" cellpadding="0" class="menu-bg"><tr>';
				print '<td class="menu">&nbsp;</td>';
				print '</tr></table></td></tr></table>';
				break;
			case 'user':
				include_once('includes/db.inc.php');
				print '<table border="0" cellspacing="0" cellpadding="0" class="menu-bg" style="width:100%"><tr><td><table border="0" cellspacing="0" cellpadding="0" class="menu-bg"><tr>';
				$mnuSQL=mysql_query("SELECT * FROM rc_menu WHERE mnu_active='true' AND mnu_group='user' ORDER BY mnu_order") or die(mysql_error());
				while($arMNU=mysql_fetch_array($mnuSQL)){
					$title = $arMNU['mnu_title'];
					$link = $arMNU['mnu_link'];
					print '<td class="menu"><a href="'.$link.'">'.$title.'&nbsp;&nbsp;&nbsp;</a></td>';
				}
				print '</tr></table></td></tr></table>';
				break;
			case 'root':
				include_once('includes/db.inc.php');
				print '<table border="0" cellspacing="0" cellpadding="0" class="menu-bg" style="width:100%"><tr><td><table border="0" cellspacing="0" cellpadding="0" class="menu-bg"><tr>';
				$mnuSQL=mysql_query("SELECT * FROM rc_menu WHERE mnu_active='true' ORDER BY mnu_order") or die(mysql_error());
				while($arMNU=mysql_fetch_array($mnuSQL)){
					$title = $arMNU['mnu_title'];
					$link = $arMNU['mnu_link'];
					print '<td class="menu"><a href="'.$link.'">'.$title.'&nbsp;&nbsp;&nbsp;</a></td>';
				}
				print '</tr></table></td></tr></table>';
				break;
			default:
				break;
		}
	}
	
	function crLoginFrm(){
		print '
			<center>
				<form method="post" action="chkLogin.php">
					<table border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td class="tblHeader" style="width:304px">Login</td>
						</tr>
					</table>
					<table border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td class="tblHeader2" style="width:100px">Username:</td>
							<td class="tblContent" style="width:200px"><input type="text" name="username" class="" style="width:200px" /></td>
						</tr>
						<tr>
							<td class="tblHeader2" style="width:100px">Password:</td>
							<td class="tblContent" style="width:200px"><input type="password" name="password" class="" style="width:200px" /></td>
						</tr>
						<tr>
							<td class="tblHeader2" style="width:100px">&nbsp;</td>
							<td class="tblContent" style="width:200px"><input type="submit" value="Validate" class="" style="width:200px" /></td>
						</tr>
					</table>
				</form>
			</center>
		';
	}
	
	function br($count){
		for($i=1;$i<=$count;$i++){
			print '<br />';
		}
	}
	
	function crUser($username,$password,$email){
		/* Semi-Automatic way to create new users. */
		$passwd = md5($password);
		$mail = base64_encode($email);
		echo ''.$username.' | '.$passwd.' | '.$mail.'';
	}
	
	function chPage($page){
		print '<script language="javascript">document.location="'.$page.'";</script>';
	}
	
	function chkLogin($username,$password){
		include_once('includes/db.inc.php');
		$chkSQL = mysql_query("SELECT * FROM rc_users WHERE usr_username='".$username."' AND usr_password='".md5($password)."' AND usr_active='true' LIMIT 1") or die(mysql_error());
		$num = mysql_num_rows($chkSQL) or die(mysql_error());
		if ($num != '1'){
			session_destroy();
			chPage('index.php');
		} else {
			$_SESSION['user_ok'] = '1';
			chPage('main.php');
		}
	}
	
	function chkUserLevel($username=null){
		include_once('includes/db.inc.php');
		$lvlSQL=mysql_query("SELECT * FROM rc_users WHERE usr_username='".$username."' AND usr_active='true' LIMIT 1");
		while($arLVL=mysql_fetch_array($lvlSQL)){
			$_SESSION['userlevel'] = $arLVL['usr_userlevel'];
		}
	}
	
	function chkUserSession(){
		if(!$_SESSION['user_ok']){
			chPage('index.php');
		}
	}
	
	/* --- CONTENT --- */
	function getUnits(){
		include_once('includes/db.inc.php');
		print '
			<p>Vehicles</p>
			<table border="0" cellspacing="0" cellpadding="0" class="tblspace">
				<tr>
					<td style="width:120px" class="tblHeader">Power</td>
					<td style="width:120px" class="tblHeader">Type</td>
					<td style="width:120px" class="tblHeader">Company</td>
					<td style="width:120px" class="tblHeader">Model</td>
					<td style="width:320px" class="tblHeader">Description</td>
				</tr>
		';
		$untSQL=mysql_query("SELECT * FROM rc_units WHERE unt_user='".$_SESSION['username']."' AND unt_active='true'") or die(mysql_error());
		while($arUNT=mysql_fetch_array($untSQL)){
			$unit_id=$arUNT['unt_id'];
			$unit_type=$arUNT['unt_type'];
			$unit_company=$arUNT['unt_company'];
			$unit_model=$arUNT['unt_model'];
			$unit_powered=$arUNT['unt_powered'];
			$unit_picture=$arUNT['unt_picture'];
			$unit_description=$arUNT['unt_description'];
			
			if($unit_picture==''){
				$unit_picture='pics/nophoto.png';
			}
			
			if(strlen($unit_description) >= 60){
				$ud = str_split($unit_description, '60');
				$unit_description = $ud[0] . '...';
			}
			
			print '
				<tr>
					<td class="tblContent">'.$unit_powered.'</td>
					<td class="tblContent">'.$unit_type.'</td>
					<td class="tblContent">'.$unit_company.'</td>
					<td class="tblContent"><form action="unit_detail.php" method="POST"><input type="hidden" name="unit_id" value="'.$unit_id.'" /><input class="input" type="submit" value="'.$unit_model.'" /></form></td>
					<td class="tblContent">'.$unit_description.'</td>
				</tr>
			';
		}
		print '</table>';
	}
	
	function getUnitDetail($unit_id){
		include_once('includes/db.inc.php');
		print '
			<p>Details</p>
			<table border="0" cellspacing="0" cellpadding="0" class="tblspace">
				<tr>
					<td style="width:270px" class="tblHeader">&nbsp;</td>
					<td style="width:120px" class="tblHeader">Power</td>
					<td style="width:120px" class="tblHeader">Type</td>
					<td style="width:120px" class="tblHeader">Company</td>
					<td style="width:120px" class="tblHeader">Model</td>
					<td style="width:320px" class="tblHeader">Description</td>
				</tr>
		';
		$untSQL=mysql_query("SELECT * FROM rc_units WHERE unt_user='".$_SESSION['username']."' AND unt_active='true' AND unt_id='".$unit_id."'") or die(mysql_error());
		while($arUNT=mysql_fetch_array($untSQL)){
			$unit_id=$arUNT['unt_id'];
			$unit_type=$arUNT['unt_type'];
			$unit_company=$arUNT['unt_company'];
			$unit_model=$arUNT['unt_model'];
			$unit_powered=$arUNT['unt_powered'];
			$unit_picture=$arUNT['unt_picture'];
			$unit_description=$arUNT['unt_description'];
			
			if($unit_picture==''){
				$unit_picture='pics/nophoto.png';
			}
			
			if(strlen($unit_description) >= 60){
				$ud = str_split($unit_description, '60');
				$unit_description = $ud[0] . '<br />' . $ud[1] . '<br />' . $ud[2] . '<br />' . $ud[3] . '<br />' . $ud[4] . '<br />' . $ud[5] . '<br />' . $ud[6] . '<br />' . $ud[7] . '<br />' . $ud[8] . '<br />' . $ud[9] . '<br />' . $ud[10];
			}
			
			print '
				<tr>
					<td class="tblContent"><img src="pics/'.$unit_picture.'" alt="" width="256px" height="256px" /></td>
					<td class="tblContent">'.$unit_powered.'</td>
					<td class="tblContent">'.$unit_type.'</td>
					<td class="tblContent">'.$unit_company.'</td>
					<td class="tblContent">'.$unit_model.'</td>
					<td class="tblContent">'.$unit_description.'</td>
				</tr>
			';
		}
		print '</table>';
	}
	
	function getLogbook($type,$unit_id,$username){
		switch($type){
			case 'unit':
				include_once('includes/db.inc.php');
				print '<p>Logbook</p><table border="0" cellspacing="0" cellpadding="0" class="tblspace">';
				print '
					<tr>
						<td style="width:120px" class="tblHeader">Date & Time</td>
						<td style="width:120px" class="tblHeader">Location</td>
						<td style="width:120px" class="tblHeader">Weather</td>
						<td style="width:595px" class="tblHeader">Description</td>
						<td style="width:120px" class="tblHeader">Run Length</td>
					</tr>
				';
				$logSQL=mysql_query("SELECT * FROM rc_units_logbook WHERE ulb_unit_id='".$unit_id."' AND ulb_user='".$username."' AND ulb_active='true'") or die(mysql_query());
				while($arLOG=mysql_fetch_array($logSQL)){
					$date = $arLOG['ulb_date'];
					$time = $arLOG['ulb_time'];
					$location = $arLOG['ulb_location'];
					$weather = $arLOG['ulb_weather'];
					$description = $arLOG['ulb_description'];
					$length = $arLOG['ulb_length'];
					
					print '
						<tr>
							<td class="tblContent">'.$date.' - '.$time.'</td>
							<td class="tblContent">'.$location.'</td>
							<td class="tblContent">'.$weather.'</td>
							<td class="tblContent">'.$description.'</td>
							<td class="tblContent">'.$length.' min.</td>
						</tr>
					';
				}
				print '</table>';
				break;
			case 'battery':
				
				break;
			case 'transmitter':
				
				break;
			default:
				break;
		}
	}
?>