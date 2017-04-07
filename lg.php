<?php 
session_start();
ob_start("ob_gzhandler");

error_reporting(0);
include_once 'functions/dbCon.php';
include_once 'functions/user.php';
include_once 'functions/lang.php';

$User = new USER($db);

/*$user = strip_tags($_POST['user']);
$pass = strip_tags($_POST['pass']);

$user = stripslashes($user);
$pass = stripslashes($pass);

$user = mysqli_real_escape_string($user);
$pass = mysqli_real_escape_string($pass);*/

$uid = $User->User_Login($_POST['user'], $_POST['pass']);

if(!empty($uid)) {
   $_SESSION['uid'] = $uid;
   header('Location: index.php');
} else  {
    echo "error1"; 
}
?>