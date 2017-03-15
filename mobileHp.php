<?php 
$db_name = "mnerva_ca";
$mysql_username = "mnerva_ca";
$mysql_password = "bzQnie6z";
$server_name = "mnerva.ca.mysql";
$conn = mysqli_connect($server_name, $mysql_username, $mysql_password,$db_name) or die('Unable to connect');

$mysql_qry = "select * from ebooks";

$result = mysqli_query($conn ,$mysql_qry);

if($result) {
	while($row = mysqli_fetch_array($result)) {
		$flag[]=$row;
	}

	print(json_encode($flag));
}

/*if(mysqli_num_rows($result) > 0) {
echo "login success !!!!! Welcome user";
}
else {
echo "login not success";
}*/

mysqli_close($conn);