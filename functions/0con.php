<?php
error_reporting(E_ALL);
$db_name = "mnerva_ca";
$mysql_username = "mnerva_5ee293_cg";
$mysql_password = "1x1c1v";
$server_name = "localhost";
try {
	  $con = new PDO('mysql:host='.$server_name.';dbname='.$db_name,$mysql_username,$mysql_password);
	  $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
	  echo $e->getMessage();
	  die();
}
require_once('0sql.php');