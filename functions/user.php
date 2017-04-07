<?php 

class USER {
   /*Database connection*/
   private $db;
public function __construct($db) {
    $this->db = $db;
}
   /* User Login Check */
public function User_Login($username,$password) {
   $username=mysqli_real_escape_string($this->db,$username);
   $password=mysqli_real_escape_string($this->db,$password);
   $md5_password=md5($password);
   $query=mysqli_query($this->db,"SELECT uid,notification_created FROM users WHERE (username='$username' or email='$username') and password='$md5_password' AND status='1'");
   if(mysqli_num_rows($query)==1) {
      $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
      $uid=$row['uid'];
      $notification_created=$row['notification_created'];
      $time=time();
      /* Count Reset */
      $photos_query=mysqli_query($this->db,"SELECT id FROM user_uploads WHERE uid_fk='$uid' and group_id_fk='0'");
      $photos_count=mysqli_num_rows($photos_query);

      $updates_query=mysqli_query($this->db,"SELECT msg_id FROM messages WHERE uid_fk='$uid' and group_id_fk='0'");
      $updates_count=mysqli_num_rows($updates_query);

      mysqli_query($this->db,"UPDATE users SET last_login='$time',photos_count='$photos_count',updates_count='$updates_count' WHERE uid='$uid'") or die(mysqli_error($this->db));
      if(empty($notification_created)) {
         mysqli_query($this->db,"UPDATE users SET notification_created='$time' WHERE uid='$uid'") or die(mysqli_error($this->db));
      }
      return $uid;
    } else {
      return false;
    }
} 
/* User Registration */
public function User_Registration($username,$password,$email,$name) {
   $username=mysqli_real_escape_string($this->db,$username);
   $email=mysqli_real_escape_string($this->db,$email);
   $password=mysqli_real_escape_string($this->db,$password);
   $name=mysqli_real_escape_string($this->db, $name);
   $md5_password=md5($password);
   mysqli_query($this->db,"SET character_set_client=utf8") or die(mysqli_error($this->db));
   mysqli_query($this->db,"SET character_set_connection=utf8") or die(mysqli_error($this->db));
   $q=mysqli_query($this->db,"SELECT uid FROM users WHERE username='$username' or email='$email' or name='$name'");
   $time=time();
   if(mysqli_num_rows($q)==0) {
     $time=time();
     $query=mysqli_query($this->db,"INSERT INTO users(username,name,password,email,last_login,registered)VALUES('$username','$name','$md5_password','$email','$time','$time')");
     $sql=mysqli_query($this->db,"SELECT uid FROM users WHERE username='$username'");
     $row=mysqli_fetch_array($sql,MYSQLI_ASSOC);
     $uid=$row['uid'];
     $friend_query=mysqli_query($this->db,"INSERT INTO friends(friend_one,friend_two,role,created)VALUES('$uid','$uid','me','$time')");
     mysqli_query($this->db,"UPDATE users SET last_login='$time',notification_created='$time' WHERE uid='$uid'") or die(mysqli_error($this->db));
     return $uid ;
  } else {
    return false;
  }
  }	
  /*Configuration*/
public function getConfigurations(){
	$query=mysqli_query($this->db,"SELECT applicationName,applicationDesc,applicationLogo,applicationLogoHeader,applicationFavicon FROM configurations WHERE con_id='1'")or die(mysqli_error($this->db));
	$data=mysqli_fetch_array($query,MYSQLI_ASSOC);
    return $data;
}

// Get Slider 
public function GetSlider(){
  $query = mysqli_query($this->db,"SELECT slideTitle,slideDesc,slideImage FROM MainSlider WHERE slideID ORDER BY slideID DESC LIMIT 5")or die(mysqli_error($this->db));
  while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
	   $data[]=$row;
	   }
	  if(!empty($data)) {
	// Store the result into array
	  return $data;
   }
}
}
?>