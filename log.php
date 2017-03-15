<?php 

$db_name = "mnerva_ca";
$mysql_username = "mnerva_ca";
$mysql_password = "bzQnie6z";
$server_name = "mnerva.ca.mysql";

$conn = mysqli_connect($server_name, $mysql_username, $mysql_password,$db_name);

$user_name = $_POST["user_name"];
$user_pass = $_POST["password"];
$md5_password = md5($user_pass);

$mysql_qry = "SELECT * from users WHERE (username='$user_name' or email='$user_name') AND password='$md5_password' AND status='1'";

$result = mysqli_query($conn ,$mysql_qry);

if(mysqli_num_rows($result) > 0) {
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
echo $row['uid'];
}
else {
echo "login not success";
}