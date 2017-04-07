<?php 

$db_name = "mnerva_ca";
$mysql_username = "mnerva_ca";
$mysql_password = "bzQnie6z";
$server_name = "mnerva.ca.mysql";

$conn = mysqli_connect($server_name, $mysql_username, $mysql_password,$db_name) or die('Unable to connect');
$uid = $_GET['u'];
$mysql_qry = "select * from ebooks WHERE userID='$uid'";

$result = mysqli_query($conn ,$mysql_qry);

if($result) {
	while($row = mysqli_fetch_array($result)) {
		$flag[]=$row;
	}
	print(json_encode($flag));
}

mysqli_close($conn);