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
			case 'normal':
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
		$chkSQL = mysql_query("SELECT * FROM rc_users WHERE usr_username='' AND usr_password='' AND usr_active='true'") or die(mysql_error());
		$num = mysql_num_rows($chkSQL);
		if ($num != 1){
			chPage('index.php');
		} else {
			chPage('main.php');
		}
	}
?>