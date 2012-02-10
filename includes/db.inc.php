<?php

  $dbhost = 'localhost';
  $dbbase = '';
  
  $dbuser = '';
  $dbpass = '';
  
  mysql_connect($dbhost,$dbuser,$dbpass) or die(mysql_error());
  mysql_select_db($dbbase) or die(mysql_error());

?>