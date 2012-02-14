<?php

  $dbhost = 'localhost';
  $dbbase = 'rcman';
  
  $dbuser = 'webdev';
  $dbpass = 'webdev';
  
  mysql_connect($dbhost,$dbuser,$dbpass) or die(mysql_error());
  mysql_select_db($dbbase) or die(mysql_error());

?>