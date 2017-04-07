<?
session_start();
include_once '../functions/dbCon.php'; 

$json = file_get_contents('https://www.googleapis.com/oauth2/v3/tokeninfo?id_token='.$_POST['idtoken']);
$userdata = json_decode($json, true);

		$gp_id = $userdata['kid'];
		$name = $userdata['name'];
		$gp_email= $userdata['email'];
		$gp_picture = $userdata['picture'];
		$sql=$db->query("SELECT * FROM `users` where email = '".$gp_email."'");
		if($sql->num_rows !=0){
			$db->query("UPDATE `users` SET `gp` = '$gp_id', `profile_img` = '$gp_picture', `name` = '$name' where email = '".$gp_email."' or gp = '".$gp_id."'");
	
			$gp = $sql->fetch_assoc();
			$_SESSION['uid']= $gp['uid'];
		}else{
			$rs = $db->query("INSERT INTO `users` (`gp`, `username`, `email`, `password`, `profile_img`, `name`) VALUES ('".$userdata['kid']."', '$name', '$gp_email', '', '$gp_picture', '$name')");
			
			if($rs===TRUE){
			$uid = mysqli_insert_id($db);
			$user = $db->query("SELECT * FROM `users` where uid = '$uid'");
			if($user->num_rows > 0){
				
				$rows = $user->fetch_assoc();
				
				$_SESSION['uid'] = $rows['uid'];
				}
			}
		}
?>