<?php 
session_start();
//ob_start("ob_gzhandler");
ob_start();

include_once 'functions/dbCon.php';

$user_name = $_POST["user_name"];
$full_name = $_POST["full_name"];
$email = $_POST["email"];
$user_pass = md5($_POST["password"]);

$mysql_query = "INSERT INTO users (username, name, email, password) values ('{$user_name}','{$full_name}', '{$email}', '{$user_pass}')";
$result = mysqli_query($db, $mysql_query);

if(!$result){
   die("DB Record Insert Error: ".$mysql_query."<br>".$db->error);
}

$uid = mysqli_insert_id($db);



if(!empty($uid)) {
   // Check if user loged in success main page
   $_SESSION['uid'] = $uid;
   header("Location: index.php");
	die();
}else {
  // If user not loged in show login page
  die("not works");
  //include("login.php");	
  //exit();
}


$conn->close();
?>