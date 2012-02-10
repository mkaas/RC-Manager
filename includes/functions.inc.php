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
						<center>
			';
		}
	}
	
	function htmlFooter(){
		print '
					</center>
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
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="banner">'.$title.' '.$version.''.$revision.'</td>
				</tr>
			</table>
		';
	}
	
?>