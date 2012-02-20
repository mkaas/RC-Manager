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
	
	/* --- VEHICLES --- */
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
			
			if(strlen($unit_description) >= 3){
				$ud = str_split($unit_description, '3');
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
			<p><a href="edit_unit_detail.php"><img src="pics/edit.png" alt="" width="10px" height="10px" /></a> Details</p>
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
			
			/*if(strlen($unit_description) >= 60){
				$ud = str_split($unit_description, '60');
				$unit_description = $ud[0] . '<br />' . $ud[1] . '<br />' . $ud[2] . '<br />' . $ud[3] . '<br />' . $ud[4] . '<br />' . $ud[5] . '<br />' . $ud[6] . '<br />' . $ud[7] . '<br />' . $ud[8] . '<br />' . $ud[9] . '<br />' . $ud[10];
			}*/
			
			if(strlen($unit_description) >= 60){
				$ud = explode(' ', $unit_description);
				for($i=0;$i<=count($ud);$i++){
					if($i=10){$ud='<br />';}
					$unit_description = $unit_description . ' ' . $ud;
				}
			}
			
			print '
				<tr>
					<td class="tblContent"><img src="pics/'.$unit_picture.'" alt="" width="256px" height="256px" /></td>
					<td class="tblContent">'.$unit_powered.'</td>
					<td class="tblContent">'.$unit_type.'</td>
					<td class="tblContent">'.$unit_company.'</td>
					<td class="tblContent">'.$unit_model.'</td>
					<td class="tblContent" style="width:320px">'.$unit_description.'</td>
				</tr>
			';
		}
		print '</table>';
	}
	
	function frmEditUnitDetail($unit_id){
		include_once('includes/db.inc.php');
		print '<p>Edit Unit Details</p>';
		$eudSQL=mysql_query("SELECT * FROM rc_units WHERE unt_user='".$_SESSION['username']."' AND unt_active='true' AND unt_id='".$unit_id."'") or die(mysql_error());
		while($arEUD=mysql_fetch_array($eudSQL)){
			$unit_id=$arEUD['unt_id'];
			$unit_type=$arEUD['unt_type'];
			$unit_company=$arEUD['unt_company'];
			$unit_model=$arEUD['unt_model'];
			$unit_power=$arEUD['unt_powered'];
			$unit_picture=$arEUD['unt_picture'];
			$unit_description=$arEUD['unt_description'];
			
			/* build edit form */
			print '
				<form action="do_edit.php" method="POST">
					<table border="0" cellspacing="0" cellpadding="0" class="tblSpace">
						<tr>
							<td class="tblHeader" style="width:120px">Power</td>
							<td class="tblContent" style="width:400px"><input type="text" name="eud_power" value="'.$unit_power.'" class="" style="width:400px" /></td>
						</tr>
						<tr>
							<td class="tblHeader" style="width:120px">Type</td>
							<td class="tblContent"><input type="text" name="eud_type" value="'.$unit_type.'" class="" style="width:400px" /></td>
						</tr>
						<tr>
							<td class="tblHeader" style="width:120px">Company</td>
							<td class="tblContent"><input type="text" name="eud_company" value="'.$unit_company.'" class="" style="width:400px" /></td>
						</tr>
						<tr>
							<td class="tblHeader" style="width:120px">Model</td>
							<td class="tblContent"><input type="text" name="eud_model" value="'.$unit_model.'" class="" style="width:400px" /></td>
						</tr>
						<tr>
							<td class="tblHeader" style="width:120px">Description</td>
							<td class="tblContent"><textarea type="text" name="eud_description" class="" style="width:400px">'.$unit_description.'</textarea></td>
						</tr>
						<tr>
							<td class="tblHeader" style="width:120px">Picture</td>
							<td class="tblContent"><input type="text" name="eud_picture" value="'.$unit_picture.'" class="" style="width:400px" /></td>
						</tr>
						<tr>
							<td class="tblHeader">&nbsp;</td>
							<td class="tblContent" style="text-align:right"><input type="submit" value="Edit" class="button" style="width:50px" /></td>
						</tr>
					</table>
				</form>
			';
		}
	}
	
	/* LOGBOOK */
	function getLogbook($type,$unit_id,$username){
		switch($type){
			case 'unit':
				include_once('includes/db.inc.php');
				print '<p><a href="add_log.php"><img src="pics/add.png" alt="" width="10px" height="10px" /></a> <a href="edit_log.php"><img src="pics/edit.png" alt="" width="10px" height="10px" /></a> Logbook</p><table border="0" cellspacing="0" cellpadding="0" class="tblspace">';
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
					
					if(strlen($description) >= 60){
						$ud = explode(' ', $description);
						for($i=0;$i<=count($ud);$i++){
							if($i=10){$ud='<br />';}
							$description = $description . ' ' . $ud;
						}
					}
					
					print '
						<tr>
							<td class="tblContent">'.$date.' - '.$time.'</td>
							<td class="tblContent">'.$location.'</td>
							<td class="tblContent">'.$weather.'</td>
							<td class="tblContent" style="width:595px">'.$description.'</td>
							<td class="tblContent">'.$length.' min.</td>
						</tr>
					';
				}
				print '</table>';
				break;
			case 'battery':
				include_once('includes/db.inc.php');
				print '<p><a href="add_log.php"><img src="pics/add.png" alt="" width="10px" height="10px" /></a> <a href="edit_log.php"><img src="pics/edit.png" alt="" width="10px" height="10px" /></a> Logbook</p><table border="0" cellspacing="0" cellpadding="0" class="tblspace">';
				print '
					<tr>
						<td style="width:120px" class="tblHeader">Date & Time</td>
						<td style="width:120px" class="tblHeader">Location</td>
						<td style="width:120px" class="tblHeader">Weather</td>
						<td style="width:595px" class="tblHeader">Description</td>
						<td style="width:120px" class="tblHeader">Run Length</td>
					</tr>
				';
				$logSQL=mysql_query("SELECT * FROM rc_battery_logbook WHERE blb_unit_id='".$unit_id."' AND blb_user='".$username."' AND blb_active='true'") or die(mysql_query());
				while($arLOG=mysql_fetch_array($logSQL)){
					$date = $arLOG['blb_date'];
					$time = $arLOG['blb_time'];
					$location = $arLOG['blb_location'];
					$weather = $arLOG['blb_weather'];
					$description = $arLOG['blb_description'];
					$length = $arLOG['blb_length'];
					
					if(strlen($description) >= 60){
						$ud = explode(' ', $description);
						for($i=0;$i<=count($ud);$i++){
							if($i=10){$ud='<br />';}
							$description = $description . ' ' . $ud;
						}
					}
					
					print '
						<tr>
							<td class="tblContent">'.$date.' - '.$time.'</td>
							<td class="tblContent">'.$location.'</td>
							<td class="tblContent">'.$weather.'</td>
							<td class="tblContent" style="width:595px">'.$description.'</td>
							<td class="tblContent">'.$length.' min.</td>
						</tr>
					';
				}
				print '</table>';
				break;
			case 'transmitter':
				include_once('includes/db.inc.php');
				print '<p><a href="add_log.php"><img src="pics/add.png" alt="" width="10px" height="10px" /></a> <a href="edit_log.php"><img src="pics/edit.png" alt="" width="10px" height="10px" /></a> Logbook</p><table border="0" cellspacing="0" cellpadding="0" class="tblspace">';
				print '
					<tr>
						<td style="width:120px" class="tblHeader">Date & Time</td>
						<td style="width:120px" class="tblHeader">Location</td>
						<td style="width:120px" class="tblHeader">Weather</td>
						<td style="width:595px" class="tblHeader">Description</td>
						<td style="width:120px" class="tblHeader">Run Length</td>
					</tr>
				';
				$logSQL=mysql_query("SELECT * FROM rc_tx_logbook WHERE tlb_unit_id='".$unit_id."' AND tlb_user='".$username."' AND tlb_active='true'") or die(mysql_query());
				while($arLOG=mysql_fetch_array($logSQL)){
					$date = $arLOG['tlb_date'];
					$time = $arLOG['tlb_time'];
					$location = $arLOG['tlb_location'];
					$weather = $arLOG['tlb_weather'];
					$description = $arLOG['tlb_description'];
					$length = $arLOG['tlb_length'];
					
					if(strlen($description) >= 60){
						$ud = explode(' ', $description);
						for($i=0;$i<=count($ud);$i++){
							if($i=10){$ud='<br />';}
							$description = $description . ' ' . $ud;
						}
					}
					
					print '
						<tr>
							<td class="tblContent">'.$date.' - '.$time.'</td>
							<td class="tblContent">'.$location.'</td>
							<td class="tblContent">'.$weather.'</td>
							<td class="tblContent" style="width:595px">'.$description.'</td>
							<td class="tblContent">'.$length.' min.</td>
						</tr>
					';
				}
				print '</table>';
				break;
			default:
				break;
		}
	}
	
	/* Transmitter */
	function getTx(){
		include_once('includes/db.inc.php');
		print '
			<p>Transmitters</p>
			<table border="0" cellspacing="0" cellpadding="0" class="tblspace">
				<tr>
					<td style="width:120px" class="tblHeader">Type</td>
					<td style="width:120px" class="tblHeader">Company</td>
					<td style="width:120px" class="tblHeader">Model</td>
					<td style="width:120px" class="tblHeader">Power</td>
					<td style="width:320px" class="tblHeader">Description</td>
				</tr>
		';
		$txSQL=mysql_query("SELECT * FROM rc_transmitters WHERE tx_user='".$_SESSION['username']."' AND tx_active='true'") or die(mysql_error());
		while($arTX=mysql_fetch_array($txSQL)){
			$tx_id=$arTX['tx_id'];
			$tx_type=$arTX['tx_type'];
			$tx_company=$arTX['tx_company'];
			$tx_model=$arTX['tx_model'];
			$tx_powered=$arTX['tx_powered'];
			$tx_picture=$arTX['tx_picture'];
			$tx_description=$arTX['tx_description'];
			
			if($tx_picture==''){
				$tx_picture='pics/nophoto.png';
			}
			
			if(strlen($tx_description) >= 3){
				$ud = str_split($tx_description, '3');
				$tx_description = $ud[0] . '...';
			}
			
			print '
				<tr>
					
					<td class="tblContent">'.$tx_type.'</td>
					<td class="tblContent">'.$tx_company.'</td>
					<td class="tblContent"><form action="tx_detail.php" method="POST"><input type="hidden" name="tx_id" value="'.$tx_id.'" /><input class="input" type="submit" value="'.$tx_model.'" /></form></td>
					<td class="tblContent">'.$tx_powered.'</td>
					<td class="tblContent">'.$tx_description.'</td>
				</tr>
			';
		}
		print '</table>';
	}
	
	function getTxDetail($tx_id){
		include_once('includes/db.inc.php');
		print '
			<p>Details</p>
			<table border="0" cellspacing="0" cellpadding="0" class="tblspace">
				<tr>
					<td style="width:270px" class="tblHeader">&nbsp;</td>
					<td style="width:120px" class="tblHeader">Type</td>
					<td style="width:120px" class="tblHeader">Company</td>
					<td style="width:120px" class="tblHeader">Model</td>
					<td style="width:120px" class="tblHeader">Power</td>
					<td style="width:320px" class="tblHeader">Description</td>
				</tr>
		';
		$txSQL=mysql_query("SELECT * FROM rc_transmitters WHERE tx_user='".$_SESSION['username']."' AND tx_active='true' AND tx_id='".$tx_id."'") or die(mysql_error());
		while($arTX=mysql_fetch_array($txSQL)){
			$tx_id=$arTX['tx_id'];
			$tx_type=$arTX['tx_type'];
			$tx_company=$arTX['tx_company'];
			$tx_model=$arTX['tx_model'];
			$tx_powered=$arTX['tx_powered'];
			$tx_picture=$arTX['tx_picture'];
			$tx_description=$arTX['tx_description'];
			
			if($tx_picture==''){
				$tx_picture='pics/nophoto.png';
			}
			
			/*if(strlen($unit_description) >= 60){
				$ud = str_split($unit_description, '60');
				$unit_description = $ud[0] . '<br />' . $ud[1] . '<br />' . $ud[2] . '<br />' . $ud[3] . '<br />' . $ud[4] . '<br />' . $ud[5] . '<br />' . $ud[6] . '<br />' . $ud[7] . '<br />' . $ud[8] . '<br />' . $ud[9] . '<br />' . $ud[10];
			}*/
			
			if(strlen($tx_description) >= 60){
				$ud = explode(' ', $tx_description);
				for($i=0;$i<=count($ud);$i++){
					if($i=10){$ud='<br />';}
					$tx_description = $tx_description . ' ' . $ud;
				}
			}
			
			print '
				<tr>
					<td class="tblContent"><img src="pics/'.$tx_picture.'" alt="" width="256px" height="256px" /></td>
					<td class="tblContent">'.$tx_type.'</td>
					<td class="tblContent">'.$tx_company.'</td>
					<td class="tblContent">'.$tx_model.'</td>
					<td class="tblContent">'.$tx_powered.'</td>
					<td class="tblContent" style="width:320px">'.$tx_description.'</td>
				</tr>
			';
		}
		print '</table>';
	}
?>