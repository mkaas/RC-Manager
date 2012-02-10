<?php

	function htmlHeader($title=null,$version=null,$revision=null,$theme=null){
		print '
			<html>
				<head>
					<title>'.$title.' '.$version.''.$revision.'</title>
					<link rel="stylesheet" type="text/css" href="css/'.$theme.'.css" />
				</head>
				<body>
		';
	}
	
	function htmlFooter(){
		print '
				</body>
			</html>
		';
	}

?>