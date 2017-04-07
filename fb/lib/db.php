<?php
define('DB_SERVER', 'mnerva.ca.mysql');
define('DB_USERNAME', 'mnerva_ca');
define('DB_PASSWORD', 'zmznsj988');
define('DB_DATABASE', 'mnerva_ca');
$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
mysqli_query ($db,"set character_set_results='utf8'");
?>  
 