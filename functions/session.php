<?php
$session_uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : NULL;
// Session Private
$username = '';
if(!empty($session_uid) ? $session_uid : NULL) {
	$uid=$session_uid;
	$login='1';
	} else if(isset($_GET['username']) ? $_GET['username'] : NULL) {
		$uid=$Mat->User_ID($username);
		$login='0';
	} else {
	  $url=$base_url.'index.php';
       echo "<script>window.location='$url'</script>";
}

?>
