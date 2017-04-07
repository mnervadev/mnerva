<?php 
class UPDATES {
private $db;

public function __construct($db) {
	 $this->db = $db;
}

public $perpage = 10; /*Uploads perpage*/
/*Username Check for Oauth users*/
public function usernameCheck($uid) {
	$uid=mysqli_real_escape_string($this->db,$uid);
	$query=mysqli_query($this->db,"SELECT username FROM users WHERE uid='$uid'");
	if(mysqli_num_rows($query)==1) {
	   $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
	   return $row['username'];
	} else {
		die("failed");
	  return false;
	}
}
/*Settings*/
public function getConfigurations(){
	$query=mysqli_query($this->db,"SELECT applicationName,applicationDesc,applicationLogo,applicationLogoHeader,applicationFavicon FROM configurations WHERE con_id='1'")or die(mysqli_error($this->db));
	$data=mysqli_fetch_array($query,MYSQLI_ASSOC);
    return $data;
}
/*Change Script Mini Logo*/
public function ScriptLogoChange($actual_image_name)  {
 if($actual_image_name) {
	 mysqli_query($this->db,"UPDATE configurations SET applicationLogo='$actual_image_name' WHERE con_id='1'") or die(mysqli_error($this->db));
  }
  return true;
}

/*Change Script Mini Logo*/
public function ScriptHeaderLogoChange($actual_image_name)  {
 if($actual_image_name) {
	 // Change script header mini logo from top left corner
	 mysqli_query($this->db,"UPDATE configurations SET applicationLogoHeader='$actual_image_name' WHERE con_id='1'") or die(mysqli_error($this->db));
  }
  return true;
}
/*Change Script Name*/
public function InsertScriptName($applicationName){
   $applicationName=mysqli_real_escape_string($this->db,$applicationName);// Update Script name
   mysqli_query($this->db,"SET character_set_client=utf8") or die(mysqli_error($this->db));
   mysqli_query($this->db,"SET character_set_connection=utf8") or die(mysqli_error($this->db));
   mysqli_query($this->db,"UPDATE configurations SET applicationName='$applicationName' WHERE con_id='1'")  or die(mysqli_error($this->db));
}	
/*Change Script Description*/
public function InsertScriptDesc($applicationDesc){
   $applicationDesc=mysqli_real_escape_string($this->db,$applicationDesc);// Update script Description
   mysqli_query($this->db,"SET character_set_client=utf8") or die(mysqli_error($this->db));
   mysqli_query($this->db,"SET character_set_connection=utf8") or die(mysqli_error($this->db));
   mysqli_query($this->db,"UPDATE configurations SET applicationDesc='$applicationDesc' WHERE con_id='1'")  or die(mysqli_error($this->db));
} 
/*Recent Sliders*/
public function SliderMainList()
{
   // We can show slider with this query if you want to add another detail you need to add your own
   // added row here
   $query=mysqli_query($this->db,"SELECT slideID,slideTitle,slideDesc,slideImage FROM MainSlider WHERE slideID ORDER BY slideID DESC LIMIT 5")or die(mysqli_error($this->db));
   while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
	   $data[]=$row;
	   }
	  if(!empty($data)) {
	// Store the result into array
	  return $data;
   } 			
}
// All Slider Data
public function SliderListAll(){
  // This query will showing you all shared sliders from admin slider page
  // If you want to add your own row, you need to add also your row name here
  $query = mysqli_query($this->db,"SELECT slideID,slideTitle,slideDesc,slideImage FROM MainSlider WHERE slideID ORDER BY slideID")or die(mysqli_error($this->db));
  while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
	   $data[]=$row;
	   }
	  if(!empty($data)) {
	// Store the result into array
	  return $data;
   }
}
/*User Login Check*/
public function Login_Check($value,$type) {
	$username_email=mysqli_real_escape_string($this->db,$value);
	if($type) {
	   $query=mysqli_query($this->db,"SELECT uid FROM users WHERE username='$username_email' AND status='1' ") or die(mysqli_error($this->db));
	} else {
	  $query=mysqli_query($this->db,"SELECT uid FROM users WHERE email='$username_email' ") or die(mysqli_error($this->db));
	}
	return mysqli_num_rows($query);
}
/* User ID Valid Check*/
public function User_ID($username) {
   $username=mysqli_real_escape_string($this->db,$username);
   //This is user id Cheking for valid
   $query=mysqli_query($this->db,"SELECT uid FROM users WHERE username='$username' AND status='1'");
   if(mysqli_num_rows($query)==1) {
   //This is if user id valid is ok then return user id
   $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
   return $row['uid'];
   } else {
	   return false;
   }
}
/* User Details*/
public function User_Details($uid) {
   $username=mysqli_real_escape_string($this->db,$uid);
   // We are showing all user details here
   // If you want to add some other user detail you need to add your users row here also
   $query=mysqli_query($this->db,"SELECT uid,tour,username,bio,email,friend_count,fb,role,tw,yout,ins,tel,gp,postHide,followingHide,followerHide,socialHide,phoneHide,profile_img,gender,u_website,location,conversation_count,updates_count,cover_img,cover_img_status,group_count,profile_img_status,profile_bg_position,verified,notification_created,photos_count,name AS full_name FROM users WHERE uid='$uid' AND status='1'");
   $data=mysqli_fetch_array($query,MYSQLI_ASSOC);
   return $data;
}
/*User Full Name*/
public function UserFullName($username) {
	$username=mysqli_real_escape_string($this->db,$username);
	// Username is not enouth for your user
	// If your user changed his/her name then thiw query will be start on that time
	// It will show just 25 character if you want more then you can change it easyly
	$query = mysqli_query($this->db,"SELECT name FROM `users` WHERE username='$username' AND status='1'") or die(mysqli_error($this->db));
	$data=mysqli_fetch_array($query,MYSQLI_ASSOC);
	if($data['name']) {
		$name=$data['name'];
		$str_length = strlen($name);
		if($str_length > 25) {
		   $name= substr($name, 0, 25) . "..." ;
		}
		return ucfirst($name);
	} else {
	  return ucfirst($username);
	}
}
/*User Profile Picture */
public function User_MiniProfilepic($uid, $base_url) {
	 $uid=mysqli_real_escape_string($this->db,$uid);
	 //This is checking user uploded profile image or not
	 $query = mysqli_query($this->db,"SELECT email,profile_img,profile_img_status FROM `users` WHERE uid='$uid'") or die(mysqli_error($this->db));
	 $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
	 if($row['profile_img_status']) { // Checking profile image status 1 or 0 
	    if(!empty($row['profile_img'])) {  // If profile image is not empty then show the profile image from user profile image folder
		  $profile_image_path=$base_url.'uploads/profile/';
		  $data= $profile_image_path.$row['profile_img'];
		  return $data;
		 } else { 
		   // If user not uploaded an profile image then show default image from mat_icons folder
		   // If you want to change default image for profile image then you can fined it from mat_cions folder in default.jpg
		   $data=$base_url."css/icons/default.png";
		   return $data;
		 }
		 } else { 
		   // If the profile imag status is 0 then show the user gravatar image from the data link
		   /*Gravator Image*/
		   $data=$base_url."css/icons/default.png";
		   return $data;
		 }
}
/*Profile Image Upload*/
public function Profile_Image_Upload($uid, $actual_image_name) {
	 //Prepare the statement
	 mysqli_query($this->db,"UPDATE users SET profile_img='$actual_image_name',profile_img_status='1' WHERE uid='$uid'") or die(mysqli_error($this->db));
	 // Insert an image if user selected correct formating image
	 
	 //Check the user id for profile_pic from the user table then update it
	 $query = mysqli_query($this->db,"SELECT uid,profile_img FROM users WHERE uid='$uid'") or die(mysqli_error($this->db));
	 $result = mysqli_fetch_array($query, MYSQLI_ASSOC);
	 return $result;
}
// User Cover Image
public function User_Cover($uid, $base_url) {
	 $uid=mysqli_real_escape_string($this->db,$uid);
	 //This is checking user uploded profile image or not
	 $query = mysqli_query($this->db,"SELECT email,cover_img,cover_img_status FROM `users` WHERE uid='$uid'") or die(mysqli_error($this->db));
	 $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
	 if($row['cover_img_status']) { // Checking profile image status 1 or 0 
	    if(!empty($row['cover_img'])) {  // If profile image is not empty then show the profile image from user profile image folder
		  $profile_image_path=$base_url.'uploads/profile/';
		  $data= $profile_image_path.$row['cover_img'];
		  return $data;
		 } else { 
		   // If user not uploaded an profile image then show default image from mat_icons folder
		   // If you want to change default image for profile image then you can fined it from mat_cions folder in default.jpg
		   $data=$base_url."css/icons/defaultCover.png";
		   return $data;
		 }
		 } else { 
		   // If the profile imag status is 0 then show the user gravatar image from the data link
		   /*Gravator Image*/
		   $data=$base_url."css/icons/defaultCover.png";
		   return $data;
		 }
}
/*Cover Image Upload*/
public function Profile_Cover_Upload($uid, $actual_image_name) {
	 //Prepare the statement
	 mysqli_query($this->db,"UPDATE users SET cover_img='$actual_image_name',cover_img_status='1' WHERE uid='$uid'") or die(mysqli_error($this->db));
	 // Insert an image if user selected correct formating image
	 mysqli_query($this->db,"INSERT INTO user_profile_images (profile_image_path,uid_fk) VALUES ('$actual_image_name','$uid')") or die(mysqli_error($this->db));
	 //Check the user id for profile_pic from the user table then update it
	 $query = mysqli_query($this->db,"SELECT uid,cover_img FROM users WHERE uid='$uid'") or die(mysqli_error($this->db));
	 $result = mysqli_fetch_array($query, MYSQLI_ASSOC);
	 return $result;
}
	/*Image Upload*/
public function Image_Upload($uid, $image, $title, $cover) {
	 $path="uploads/"; // User uploads folder
	 $img_src = $path.$image; // User uploads image path
	 $imgbinary = fread(fopen($img_src, "r"), filesize($img_src));  //Let's read the contents of a file into a string,
	 // To get the title of a image src
	 $img_base = base64_encode($imgbinary);//The encoded image is returned as a string.
	 $ids = 0;
	 // Add the insert image
	 $query = mysqli_query($this->db,"insert into user_uploads (image_path,cover, uid_fk, title)values('$image', '$cover', '$uid', '$title')") or die(mysqli_error($this->db));
	 //Increasing the number of pictures uploaded 1
	 $query=mysqli_query($this->db,"UPDATE users SET photos_count=photos_count+1 WHERE uid='$uid'") or die(mysqli_error($this->db));
	 $ids = mysqli_insert_id($this->db);
	 return $ids;
}
	/*get Image Upload*/  
public function Get_Upload_Image($uid, $image) {
	if($image) {
	   //If image is not empty 
	   //The query to select for image path
	  $query = mysqli_query($this->db,"select id,image_path from user_uploads where image_path='$image'") or die(mysqli_error($this->db));
	 } else {
	   //The query to select for image id
	   $query = mysqli_query($this->db,"select id,image_path from user_uploads where uid_fk='$uid' order by id desc ") or die(mysqli_error($thi->db));
	 }
	   $result = mysqli_fetch_array($query,MYSQLI_ASSOC);
	   return $result;
}

	/*get Image Upload*/  
public function Get_eBook_Image($uid, $image) {
	if($image) {
	   //If image is not empty 
	   //The query to select for image path
	  $query = mysqli_query($this->db,"select ebookID,cover from ebooks where cover='$image'") or die(mysqli_error($this->db));
	 } else {
	   //The query to select for image id
	   $query = mysqli_query($this->db,"select ebookID,cover from ebooks where userID_fk='$uid' order by id desc ") or die(mysqli_error($thi->db));
	 }
	   $result = mysqli_fetch_array($query,MYSQLI_ASSOC);
	   return $result;
}

 /* Updates Details*/
    public function eBook_Details()
    {
	   
       $query=mysqli_query($this->db,"SELECT M.msg_id,M.message,M.like_count,M.uploads,U.username,U.name,U.uid  FROM messages M, users U WHERE U.uid=M.uid_fk  ORDER BY msg_id DESC LIMIT " .$this->perpage)or die(mysqli_error($this->db));
       while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
	         $data[]=$row;
	   }
	       if(!empty($data)) {
	    // Store the result into array
	      return $data;
	   } 
    }

    // If the user upload an image with text
public function Insert_eBook_Update($uid, $update,$privacy,$hashtag, $uploads) {   
	 $update=mysqli_real_escape_string($this->db,$update); // Update is for with text update
	 $privacy = mysqli_real_escape_string($this->db, $_POST['privacy']);
	 $time=time(); // Current post time
	 $ip=$_SERVER['REMOTE_ADDR']; // user ip
	 //The query to select for message
	 mysqli_query($this->db,"SET character_set_client=utf8") or die(mysqli_error($this->db));
     mysqli_query($this->db,"SET character_set_connection=utf8") or die(mysqli_error($this->db));
	 $query = mysqli_query($this->db,"SELECT msg_id,message,hashTag FROM `messages` WHERE uid_fk='$uid' order by msg_id desc limit 1") or die(mysqli_error($this->db));
	 $result = mysqli_fetch_array($query, MYSQLI_ASSOC);	
	 $uploads_array=explode(',',$uploads); // Explode the images string value
	 $uploads=implode(',',array_unique($uploads_array)); 
	 // Add the insert message
	 $query = mysqli_query($this->db,"INSERT INTO `messages` (message,hashTag,postPrivacy, uid_fk, ip,created,uploads) VALUES (N'$update','$hashtag','$privacy', '$uid', '$ip','$time','$uploads')") or die(mysqli_error($this->db));
	 // Prepare the statement
	 $v = mysqli_query($this->db,"UPDATE `users` SET updates_count=updates_count+1 WHERE uid='$uid'") or die(mysqli_error($this->db));
	 //The newquery to select for message
	 $newquery = mysqli_query($this->db,"SELECT M.msg_id, M.uid_fk, M.message,M.hashTag,M.postPrivacy,M.hide_show_comment,M.hide_show_share,M.lovedPost, M.created,M.uploads,M.like_count,M.comment_count,U.username FROM messages M, users U where M.uid_fk=U.uid and M.uid_fk='$uid' order by M.msg_id desc limit 1 ") or die(mysqli_error($this->db));
	 $result = mysqli_fetch_array($newquery, MYSQLI_ASSOC);
	 return $result;
}

	public function saveBook($userID, $data, $cover){
        $data = array_map('trim', $data);
        
        /*if( $data['title'] == '' || $data['supdate'] || $cover == null)
        {
            //buckys_add_message(MSG_USERNAME_EMPTY_ERROR, MSG_TYPE_ERROR);
            return false;
        }*/
        
        //Check Email Duplication //checknameduplication
        /*if( BuckysUser::checkEmailDuplication($data['email']) )
        {
            buckys_add_message(MSG_EMAIL_EXIST, MSG_TYPE_ERROR);
            return false;
        }*/
        
        //Create New Account
        /*$newId = $db->insertFromArray(TABLE_EBOOKS, array(
        	'userID' => $userID,
            'title' => $data['title'],
            'content' => $data['content'],
            'cover' => $cover,
            'date' => date('Y-m-d H:i:s'),
            //'thumbnail' => '',
        ));*/
        
        $title2 = $data['title'];
        $content2 = $data['supdate'];

        //$userID = mysqli_real_escape_string($this->db,$userID);
        $query = mysqli_query($this->db,"INSERT INTO ebooks (userID, title, content, cover) VALUES ('$userID', '$title2', '$content2', '$cover')") or die(mysqli_error($this->db));
        //die($query);
        /*if(!$newId)
        {
            //buckys_add_message($db->getLastError(), MSG_TYPE_ERROR);
            return false;
        }
        return $newId;*/
	}

// If the user upload an image with text
public function Insert_Image_Update($uid, $update,$privacy,$hashtag, $uploads) {   
	 $update=mysqli_real_escape_string($this->db,$update); // Update is for with text update
	 $privacy = mysqli_real_escape_string($this->db, $_POST['privacy']);
	 $time=time(); // Current post time
	 $ip=$_SERVER['REMOTE_ADDR']; // user ip
	 //The query to select for message
	 mysqli_query($this->db,"SET character_set_client=utf8") or die(mysqli_error($this->db));
     mysqli_query($this->db,"SET character_set_connection=utf8") or die(mysqli_error($this->db));
	 $query = mysqli_query($this->db,"SELECT msg_id,message,hashTag FROM `messages` WHERE uid_fk='$uid' order by msg_id desc limit 1") or die(mysqli_error($this->db));
	 $result = mysqli_fetch_array($query, MYSQLI_ASSOC);	
	 $uploads_array=explode(',',$uploads); // Explode the images string value
	 $uploads=implode(',',array_unique($uploads_array)); 
	 // Add the insert message
	 $query = mysqli_query($this->db,"INSERT INTO `messages` (message,hashTag,postPrivacy, uid_fk, ip,created,uploads) VALUES (N'$update','$hashtag','$privacy', '$uid', '$ip','$time','$uploads')") or die(mysqli_error($this->db));
	 // Prepare the statement
	 $v = mysqli_query($this->db,"UPDATE `users` SET updates_count=updates_count+1 WHERE uid='$uid'") or die(mysqli_error($this->db));
	 //The newquery to select for message
	 $newquery = mysqli_query($this->db,"SELECT M.msg_id, M.uid_fk, M.message,M.hashTag,M.postPrivacy,M.hide_show_comment,M.hide_show_share,M.lovedPost, M.created,M.uploads,M.like_count,M.comment_count,U.username FROM messages M, users U where M.uid_fk=U.uid and M.uid_fk='$uid' order by M.msg_id desc limit 1 ") or die(mysqli_error($this->db));
	 $result = mysqli_fetch_array($newquery, MYSQLI_ASSOC);
	 return $result;
}
/*Share Post*/
public function Share_Post($uid,$share_uid_fk,$shared_msg_id_fk,$last_shared_uid_fk, $update, $uploads) {   
	 $update=mysqli_real_escape_string($this->db,$update); // Update is for with text update
     $share_uid_fk=mysqli_real_escape_string($this->db,$share_uid_fk); // This is original post user id
	 $shared_msg_id_fk=mysqli_real_escape_string($this->db,$shared_msg_id_fk);
	 $last_shared_uid_fk=mysqli_real_escape_string($this->db,$last_shared_uid_fk);
	 $time=time(); // Current post time
	 $ip=$_SERVER['REMOTE_ADDR']; // user ip
	 //The query to select for message
	 $query = mysqli_query($this->db,"SELECT msg_id,message FROM `messages` WHERE uid_fk='$uid' order by msg_id desc limit 1") or die(mysqli_error($this->db));
	 $result = mysqli_fetch_array($query, MYSQLI_ASSOC);	
	 $uploads_array=explode(',',$uploads); // Explode the images string value
	 $uploads=implode(',',array_unique($uploads_array)); 
	 // Add the insert message
	 $query = mysqli_query($this->db,"INSERT INTO `messages` (message, uid_fk,shared_uid_fk,shared_msg_id_fk,last_shared_uid_fk, ip,created,uploads) VALUES (N'$update', '$uid','$share_uid_fk','$shared_msg_id_fk','$last_shared_uid_fk', '$ip','$time','$uploads')") or die(mysqli_error($this->db));
	 // Prepare the statement
	 $v = mysqli_query($this->db,"UPDATE `users` SET updates_count=updates_count+1 WHERE uid='$uid'") or die(mysqli_error($this->db));
	 //The newquery to select for message
	 $newquery = mysqli_query($this->db,"SELECT M.msg_id, M.uid_fk,M.shared_uid_fk,M.shared_msg_id_fk,M.last_shared_uid_fk, M.message,M.hide_show_comment,M.hide_show_share,M.lovedPost, M.created,M.uploads,M.like_count,M.comment_count,U.username FROM messages M, users U where M.uid_fk=U.uid and M.uid_fk='$uid' order by M.msg_id desc limit 1 ") or die(mysqli_error($this->db));
	 $result = mysqli_fetch_array($newquery, MYSQLI_ASSOC);
	 return $result;
}
/* Status Msg Id Check*/
public function Status_ID($msgid) {
	$msgid=mysqli_real_escape_string($this->db,$msgid);
	$query=mysqli_query($this->db,"SELECT msg_id FROM messages M, users U WHERE  M.uid_fk=U.uid and M.msg_id='$msgid' AND U.status='1'");
	if(mysqli_num_rows($query)>0) {
	   $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
	   return $row['msg_id'];
	} else {
	  return false;
	}
}
/*Status User Check*/
public function Status_User($msgid) {
	$msgid=mysqli_real_escape_string($this->db,$msgid);
	$query=mysqli_query($this->db,"SELECT username FROM messages M, users U WHERE  M.uid_fk=U.uid and M.msg_id='$msgid' AND U.status='1'");
	if(mysqli_num_rows($query)>0) {
	   $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
	   return $row['username'];
	} else {
	  return false;
	}
}
/*Add Friend*/
public function FollowFriend($uid, $fid) {
	 $fid=mysqli_real_escape_string($this->db,$fid); // Visited user id
	 //This query to select friend id and friend role
	 $q=mysqli_query($this->db,"SELECT friend_id FROM friends WHERE friend_one='$uid' AND friend_two='$fid' AND role='fri'");
	 if(mysqli_num_rows($q)==0) {
	    // if user role is not fri then show the follow button
		// and if user role is fri then show unfollow button
	    $time=time(); // current time
		// Add to friend list
	    $query=mysqli_query($this->db,"INSERT INTO friends(friend_one,friend_two,role,created) VALUES ('$uid','$fid','fri','$time')") or die(mysqli_error($this->db));	
		//Increasing the number of friend list 1
	    $query=mysqli_query($this->db,"UPDATE users SET friend_count=friend_count+1 WHERE uid='$uid'") or die(mysqli_error($this->db));	
		return true;
	 }
}
/*Remove Friend*/
public function UnFollowFriend($uid, $fid) {
	 $fid=mysqli_real_escape_string($this->db,$fid); // Visited user id
	 //This query to select friend id and friend role
	 $q=mysqli_query($this->db,"SELECT friend_id FROM friends WHERE friend_one='$uid' AND friend_two='$fid' AND role='fri'");
	 if(mysqli_num_rows($q)==1) {
	   // if user role is fri then show the unfollow button
	   // and if user role is not fri then show follow button
	   // Remove to friend list
	   $query=mysqli_query($this->db,"DELETE FROM friends WHERE friend_one='$uid' AND friend_two='$fid'") or die(mysqli_error($this->db));	
	   //reduce the following count -1
	   $query=mysqli_query($this->db,"UPDATE users SET friend_count=friend_count-1 WHERE uid='$uid'") or die(mysqli_error($this->db));	
	   return true;
	 }
}
/*Friend Valid Check*/
public function Friends_Check($uid, $fid) {
	 //The query to select for friend role status 'me' or 'fri'
	 $query=mysqli_query($this->db,"SELECT role FROM friends WHERE friend_one='$uid' AND friend_two='$fid'") or die(mysqli_error($this->db));	
     $num=mysqli_fetch_array($query,MYSQLI_ASSOC);
	 return $num['role'];
}
/*Friends count*/
public function Friends_Check_Count($uid, $fid) {
	 //This query to select check whether user friends
	 $query=mysqli_query($this->db,"SELECT friend_id FROM friends WHERE friend_one='$uid' AND friend_two='$fid'") or die(mysqli_error($this->db));	
	 $num=mysqli_num_rows($query);
     return $num;
}
// Profile Follower List
public function FollowerUserList($uid) {
     $uid=mysqli_real_escape_string($this->db,$uid);
     // The query to select for showing user details
	 $query=mysqli_query($this->db,"SELECT U.username,U.photos_count,U.updates_count,U.friend_count, U.uid FROM users U, friends F WHERE U.status='1' AND U.uid=F.friend_one AND F.friend_two='$uid' AND F.role='fri' ORDER BY F.friend_id DESC LIMIT 15")or die(mysql_error());
	 while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
		 // Store the result into array
		 $data[]=$row;
	  }
	  if(!empty($data)) {
		 // Store the result into array
		 return $data;
	  }  
}
/*Update Text*/
public function Insert_Text_Update($uid, $update, $hashTag) {
	mysqli_query($this->db,"SET character_set_client=utf8") or die(mysqli_error($this->db));
	mysqli_query($this->db,"SET character_set_connection=utf8") or die(mysqli_error($this->db));
	$update=mysqli_real_escape_string($this->db,$update);// Update is text update
	$time=time();// Current post time
	$ip=$_SERVER['REMOTE_ADDR'];// user ip
	//The query to select for message
	$query = mysqli_query($this->db,"SELECT msg_id,message,hashTag FROM `messages` WHERE uid_fk='$uid' order by msg_id desc limit 1") or die(mysqli_error($this->db));
	$result = mysqli_fetch_array($query,MYSQLI_ASSOC);	
	if($update!=$result['message']) {
	   // Add the insert message
	   $query = mysqli_query($this->db,"INSERT INTO `messages` (message,hashTag, uid_fk,ip,created) VALUES (N'$update','$hashTag','$uid', '$ip','$time')") or die(mysqli_error($this->db));
	   // Prepare the statement
	   $v = mysqli_query($this->db,"UPDATE `users` SET updates_count=updates_count+1 WHERE uid='$uid'") or die(mysqli_error($this->db));
	   //The newquery to select for message
	   $newquery = mysqli_query($this->db,"SELECT M.msg_id, M.uid_fk,M.message,M.hide_show_comment,M.hide_show_share,M.lovedPost,M.hashTag,M.created,M.like_count,M.comment_count,M.share_count, U.username FROM messages M, users U where M.uid_fk=U.uid and M.uid_fk='$uid' order by M.msg_id desc limit 1 ") or die(mysql_error($this->db));
	   $result = mysqli_fetch_array($newquery, MYSQLI_ASSOC);
	   return $result;
	} else {
		return false;
	}   
}
// Profile Follower User List
public function FolloWer_User_List($uid,$lastFrid) {
	$uid=mysqli_real_escape_string($this->db,$uid);
	 if($lastFrid) {
		$lastFrid = "AND F.friend_id >'".$lastFrid."'";	
	 }
	 // The query to select for showing user details
	 $query=mysqli_query($this->db,"SELECT U.username,U.uid,F.friend_id FROM users U, friends F WHERE U.status='1' AND U.uid=F.friend_one AND F.friend_two='$uid' $lastFrid AND F.role='fri' ORDER BY F.friend_id DESC LIMIT " .$this->perpage) or die(mysqli_error($this->db));
	 while($row=mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		   // Store the result into array
		   $data[]=$row;
		 }
	 if(!empty($data)) {
		// Store the result into array
		   return $data;
		}  
}
/*User List*/
public function User_List($uid,$base_url) {
	 $uid=mysqli_real_escape_string($this->db,$uid);
	 $query=mysqli_query($this->db,"SELECT * FROM users ORDER BY rand() LIMIT 16") or die(mysqli_error($this->db));
	 $data = array();
	 while($row=mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		 $data[]=$row;
	  }
	  if(!empty($data)) {
		// Store the result into array
		 return $data;
	  } 
}
//Total User Profile Photos
public function TotalUserUploadsPhotos($uid) {
	// This query to select the total upload image from the user profile
	$query=mysqli_query($this->db,"SELECT users.uid,
	users.username,
	users.updates_count,
	user_uploads.uid_fk,
	user_uploads.id,
	user_uploads.image_path,
	messages.msg_id,
	messages.uid_fk,
	messages.uploads,
	messages.share_count,
	messages.comment_count,
	messages.like_count 
	FROM users 
	INNER JOIN messages
	ON users.uid  = messages.uid_fk
	INNER JOIN user_uploads 
	ON messages.uploads = user_uploads.id
	WHERE uid='$uid' order by msg_id DESC LIMIT 3") or die(mysqli_error($this->db));
	while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
		// Store the result into array
		 $data[]=$row;
		}
		if(!empty($data)) {
			return $data;
		}
}
	
//User Porfile Photos
public function UserUploadsPhotos($uid, $lastrmid) {
	$morequery="";
	if($lastrmid) {
		//build up the query
	   $morequery=" and messages.msg_id<'".$lastrmid."' ";
	 }
	 // The query to selected more uploaded image from the user profile
	 $query=mysqli_query($this->db,"SELECT users.uid,
	 users.username,
	 users.updates_count,
	 user_uploads.uid_fk,
	 user_uploads.id,
	 user_uploads.image_path,
	 messages.msg_id,
	 messages.uid_fk,
	 messages.uploads,
	 messages.share_count,
	 messages.comment_count,
	 messages.like_count 
	 FROM users 
	 INNER JOIN messages
	 ON users.uid  = messages.uid_fk
	 INNER JOIN user_uploads 
	 ON messages.uploads = user_uploads.id
	 WHERE uid='$uid' $morequery order by msg_id DESC LIMIT 3") or die(mysqli_error($this->db));
	 while($row=mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		 // Store the result into array
		   $data[]=$row;
		 }
		 if(!empty($data)) {
			 return $data;
		 }
}
/*Explore Users*/
public function ExploreUserEx($uid,$base_url) {
	 $uid=mysqli_real_escape_string($this->db, $uid);
	 $query=mysqli_query($this->db,"SELECT * FROM users ") or die(mysqli_error($this->db));
	 $data = array();
	 $data=mysqli_num_rows($query);
	return $data;	
 }
/*Explore Total*/
public function ExploreUserTotal($lastuid) {
   
  $morequery="";
  if($lastuid) {
     $morequery=" WHERE uid<'".$lastuid."' ";
  }
   $query=mysqli_query($this->db,"SELECT * FROM users $morequery ORDER BY uid desc LIMIT " .$this->perpage) or die(mysqli_error($this->db));
   $data = array();
   while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
	   $data[]=$row;
	   }
   return $data;
}
/*User Search  */ 	
public function User_Search($searchword) {
    $q=mysqli_real_escape_string($this->db,$_POST['searchword']);
    //Check for the username word.
	$query=mysqli_query($this->db,"SELECT username,uid from users WHERE username like '%$q%' or name like '%$q%' ORDER BY uid LIMIT 10") or die(mysqli_error($this->db));
    while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
		 $data[]=$row;
	  }
	 if(!empty($data)) {
	    // Store the result into array
		return $data;
	  } 
	}
/*User Folower Count*/
public function Follower_Count($uid) {
	$uid = mysqli_real_escape_string($this->db,$uid);
	//This is checking user follower count
	//We use COUNT(*)-1 because of you are not your friend. 
	$q = mysqli_query($this->db,"SELECT COUNT(*)-1 AS ufollowers FROM friends WHERE friend_two = '$uid'") or die(mysqli_error($this->db));
	$row = mysqli_fetch_array($q,MYSQLI_ASSOC);
	if ($row) {
		//This is if user follower is not empty show how many follower
		return $row['ufollowers'];
		} 
		//If user not have follower then show 0
		else return 0;
 }
/*User Folower Count*/
public function Following_Count($uid)
{
	$uid = mysqli_real_escape_string($this->db,$uid);
	//This is checking user follower count
	//We use COUNT(*)-1 because of you are not your friend. 
	$q = mysqli_query($this->db,"SELECT COUNT(*)-1 AS ufollowers FROM friends WHERE friend_one = '$uid'") or die(mysqli_error($this->db));
	$row = mysqli_fetch_array($q,MYSQLI_ASSOC);
	if ($row) {
		//This is if user follower is not empty show how many follower
		return $row['ufollowers'];
		} 
		//If user not have follower then show 0
		else return 0;
 }
// Profile Following User List
public function FolloWingUserList($uid,$lastFrid) {
     $uid=mysqli_real_escape_string($this->db,$uid);
	 if($lastFrid) {
		$lastFrid = "AND F.friend_id <'".$lastFrid."'";	
	 }
	 // The query to select for showing user details
	 $query=mysqli_query($this->db,"SELECT U.username,U.name,U.uid,F.friend_id FROM users U, friends F WHERE U.status='1' AND U.uid=F.friend_two AND F.friend_one='$uid' $lastFrid AND F.role='fri' ORDER BY F.friend_id DESC LIMIT " .$this->perpage)or die(mysqli_error($this->db));
	  while($row=mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		  $data[]=$row;
		 }
	   if(!empty($data)) {
	   // Store the result into array
		 return $data;
	  }     
}
/*Friend check for message for privacy section*/
public function CheckFStatus($uid, $fid) {
	//This query to select for who can see my message button and who can send a message to me
	$query=mysqli_query($this->db,"SELECT role FROM friends WHERE friend_one='$fid' AND friend_two='$uid'") or die(mysqli_error($this->db));
	$num=mysqli_fetch_array($query, MYSQLI_ASSOC);
	return $num['role'];
}
/* Friends_Updates   */	
public function Friends_Updates($uid, $lastid, $lastmid, $lastsid) {
  $moresharequery = "";
  if ($lastsid) {
	   $moresharequery = " and S.share_id > '" . $lastsid . "' ";
   }

  /* More Button*/
  $morequery="";
  if($lastid) {
	  //build up the query
	  $morequery=" and M.msg_id<'".$lastid."' ";
   }
   if($lastmid) {
	  //build up the query
	  $morequery=" and M.msg_id>'".$lastmid."' ";
   }
	$data = null;
	/*More Button End*/
	$v=mysqli_query($this->db,"SELECT share_id FROM message_share") or die(mysqli_error($this->db));
	if(mysqli_num_rows($v)) {
	   //The query to select friend messages
	   $query=mysqli_query($this->db,"(SELECT DISTINCT 
			 M.msg_id,
			 M.uid_fk,
			 M.shared_uid_fk,
			 M.shared_msg_id_fk,
			 M.last_shared_uid_fk,
			 M.message,
			 M.hide_show_comment,
			 M.hide_show_share,
			 M.postPrivacy,
			 M.lovedPost,
			 M.hashTag,
			 M.share_count,
			 S.created,
			 M.like_count,
			 M.comment_count,
			 U.username,
			 M.uploads,
			 S.uid_fk AS share_uid,
			 S.ouid_fk AS share_ouid
			 FROM 
			 messages M
			 JOIN message_share S ON M.msg_id = S.msg_id_fk
			 JOIN friends F ON F.friend_two = S.uid_fk OR S.uid_fk = '$uid'
			 JOIN users U ON S.ouid_fk = U.uid
			 WHERE 
			 F.friend_one='$uid'
			 AND U.uid != F.friend_one 
			 AND U.status='1'
			 AND F.role='fri'
			 $moresharequery
			 )
			 UNION
			 (SELECT DISTINCT 
			 M.msg_id,
			 M.uid_fk,
			 M.shared_uid_fk,
			 M.shared_msg_id_fk,
			 M.last_shared_uid_fk,
			 M.message,
			 M.hide_show_comment,
			 M.postPrivacy,
			 M.hide_show_share,
			 M.lovedPost,
			 M.hashTag,
			 M.share_count,
			 M.created,
			 M.like_count,
			 M.comment_count,
			 U.username,
			 M.uploads,
			 '0' AS share_uid,
			 '0' AS share_ouid
			 FROM 
			  messages M 
			  JOIN users U ON M.uid_fk = U.uid
			  JOIN friends F ON M.uid_fk = F.friend_two
			 WHERE 
			  F.friend_one='$uid'
			  AND U.status='1'
			$morequery ) order by created desc limit " .$this->perpage) or die(mysqli_error($this->db)); 
	   } else {	   
		  $query = mysqli_query($this->db,"SELECT DISTINCT M.msg_id, M.uid_fk,M.shared_uid_fk,M.shared_msg_id_fk,M.last_shared_uid_fk, M.message,M.hide_show_comment,M.postPrivacy,M.hide_show_share,M.lovedPost,M.hashTag,M.like_count,M.comment_count, M.created,U.username,M.uploads FROM messages M, users U, friends F  WHERE U.status='1' AND M.uid_fk=U.uid AND  M.uid_fk = F.friend_two AND F.friend_one='$uid' $morequery order by M.msg_id desc limit " .$this->perpage) or die(mysqli_error($this->db));
	   }
		//Store the result
		while($row=mysqli_fetch_array($query)) {
			// Store the result into array
			$data[]=$row;
			}
			 if(!empty($data)) {
			   // Store the result into array
			   return $data;
			}  
}
	
	/*Total Friends Updates */  	
	public function Total_Friends_Updates($uid)
	{
		$v=mysqli_query($this->db,"SELECT share_id FROM message_share") or die(mysqli_error($this->db)); 
	    if(mysqli_num_rows($v)) {
		    //The query to select total friend messages
		    $query=mysqli_query($this->db,"(SELECT DISTINCT 
				 M.msg_id,
				 M.uid_fk,
				 M.shared_uid_fk,
				 M.shared_msg_id_fk,
				 M.last_shared_uid_fk,
				 M.message,
				 M.hide_show_comment,
				 M.postPrivacy,
				 M.hide_show_share,
				 M.lovedPost,
				 M.hashTag,
				 M.share_count,
				 S.created,
				 M.like_count,
				 M.comment_count,
				 U.username,
				 M.uploads,
				 S.uid_fk AS share_uid,
				 S.ouid_fk AS share_ouid
				 FROM 
				 messages M
				 JOIN message_share S ON M.msg_id = S.msg_id_fk
				 JOIN friends F ON F.friend_two = S.uid_fk OR S.uid_fk = '$uid'
				 JOIN users U ON S.ouid_fk = U.uid
				 WHERE 
				 F.friend_one='$uid'
				 AND U.uid != F.friend_one 
				 AND U.status='1'
				 AND F.role='fri')
				 UNION
				 (SELECT DISTINCT 
				 M.msg_id,
				 M.uid_fk,
				 M.shared_uid_fk,
				 M.shared_msg_id_fk,
				 M.last_shared_uid_fk,
				 M.message,
				 M.hide_show_comment,
				 M.postPrivacy,
				 M.hide_show_share,
				 M.lovedPost,
				 M.hashTag,
				 M.share_count,
				 M.created,
				 M.like_count,
				 M.comment_count,
				 U.username,
				 M.uploads,
				 '0' AS share_uid,
				 '0' AS share_ouid
				 FROM 
				  messages M 
				  JOIN users U ON M.uid_fk = U.uid
				  JOIN friends F ON M.uid_fk = F.friend_two
				 WHERE 
				  F.friend_one='$uid'
				  AND U.status='1'
			  ) order by created desc ") or die(mysqli_error($this->db)); 
		    } else {	   
			    $query = mysqli_query($this->db,"SELECT DISTINCT M.msg_id, M.uid_fk,M.shared_uid_fk,M.shared_msg_id_fk,M.last_shared_uid_fk, M.message,M.hide_show_comment,M.postPrivacy,M.hide_show_share,M.lovedPost,M.hashTag,M.like_count,M.comment_count, M.created, U.username,M.uploads FROM messages M, users U, friends F  WHERE U.status='1' AND M.uid_fk=U.uid AND  M.uid_fk = F.friend_two AND F.friend_one='$uid'  ") or die(mysqli_error($this->db));
		    }
		    // Store the result into array
		    $data=mysqli_num_rows($query);
		    return $data;		
	 }
public function Updates($uid, $lastid,$lastmid) {
	/* More Button*/
	$morequery="";
	if($lastid) {//If posted any message. So the lastid is 0 from the posts.php file
	   //If the last message id greater then the first message id then continue with $morequery=" and M.msg_id<'".$lastid."' ";
	   $morequery=" and M.msg_id<'".$lastid."' ";
	 }
	 if($lastmid) {
		//build up the query
		$morequery=" and M.msg_id>'".$lastmid."' ";
	 }
	 // Create variable $data with a null value before the query
	  $data = null;
	 /* More Button End*/
	 $v=mysqli_query($this->db,"SELECT share_id FROM message_share") or die(mysqli_error($this->db));
	 if(mysqli_num_rows($v)) {
		 //The profile updates relation here
		 //Message and message_share table relationship
		 //Checking the message shared
		 //Checking the message for the profile
		 //Showing the message shared details
		 $query=mysqli_query($this->db,"(SELECT DISTINCT 
		 M.msg_id, 
		 M.uid_fk, 
		 M.shared_uid_fk,
		 M.shared_msg_id_fk,
		 M.last_shared_uid_fk,
		 M.message,
		 M.hide_show_comment,
		 M.postPrivacy,
		 M.hide_show_share,
		 M.lovedPost,
		 M.hashTag,
		 S.created, 
		 M.like_count,
		 M.comment_count,
		 M.share_count,
		 U.username,
		 M.uploads, 
		 S.uid_fk as share_uid,
		 S.ouid_fk as share_ouid 
		 FROM 
		 messages M, users U, message_share S 
		 WHERE 
		 M.uid_fk=U.uid AND
		 U.status='1' AND 
		 S.msg_id_fk=M.msg_id AND
		 S.uid_fk='$uid'
		 $morequery group by msg_id)
		 UNION
		 (SELECT M.msg_id, 
		 M.uid_fk, 
		 M.shared_uid_fk,
		 M.shared_msg_id_fk,
		 M.last_shared_uid_fk,
		 M.message,
		 M.hide_show_comment,
		 M.postPrivacy,
		 M.hide_show_share,
		 M.lovedPost,
		 M.created,
		 M.like_count,
		 M.comment_count,
		 M.share_count,
		 U.username,
		 M.uploads, '0' AS share_uid, '0' as share_ouid  FROM messages M, users U 
		 WHERE
		 U.status='1' AND 
		 M.uid_fk=U.uid and 
		 M.uid_fk='$uid'  $morequery group by msg_id ) 
		 order by created desc limit " .$this->perpage) or die(mysqli_error($this->db));
	   } else {
		   //If the update has not shared then show only user messages and messages details from the message table
		   $query = mysqli_query($this->db,"SELECT M.msg_id, M.uid_fk,M.shared_uid_fk,M.shared_msg_id_fk,M.last_shared_uid_fk, M.message,M.hide_show_comment,M.postPrivacy,M.hide_show_share,M.lovedPost,M.hashTag,M.created,M.like_count,M.comment_count,U.username,M.uploads, '0' AS share_uid, '0' as share_ouid FROM messages M, users U  WHERE U.status='1' AND M.uid_fk=U.uid and M.uid_fk='$uid' $morequery order by M.msg_id desc limit " .$this->perpage) or die(mysqli_error($this->db));
	   }
	   //Store the result
	   while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
			 $data[]=$row;
		   }
		   return $data;
}
/*Id Image Upload*/
public function Get_Upload_Image_Id($id) {
	$query = mysqli_query($this->db,"SELECT id,image_path, cover, title FROM user_uploads WHERE id='$id'") or die(mysqli_error($this->db));
	$result = mysqli_fetch_array($query,MYSQLI_ASSOC);
	return $result;
}

/*Id Image Upload*/
public function Get_eBook_Image_Id($id) {
	$query = mysqli_query($this->db,"SELECT ebookID,cover FROM ebooks WHERE ebookID='5865'") or die(mysqli_error($this->db));
	$result = mysqli_fetch_array($query,MYSQLI_ASSOC);
	return $result;
}


	/* Total Updates   */	
public function Total_Updates($uid) {
	 $v=mysqli_query($this->db,"SELECT share_id FROM message_share") or die(mysqli_error($this->db));
	 if(mysqli_num_rows($v)) {
	 //The query to select friend messages
	 $query=mysqli_query($this->db,"(SELECT DISTINCT 
		   M.msg_id,
		   M.uid_fk, 
		   M.shared_uid_fk,
		   M.shared_msg_id_fk,
		   M.last_shared_uid_fk,
		   M.message,
		   M.hide_show_comment,
		   M.postPrivacy,
		   M.hide_show_share,
		   M.lovedPost,
		   M.created, 
		   M.like_count,
		   M.comment_count,
		   M.share_count,
		   U.username,
		   M.uploads, 
		   S.uid_fk 
		   AS share_uid,S.ouid_fk 
		   AS share_ouid 
		   FROM 
		   messages M, 
		   users U, 
		   message_share S 
		   WHERE 
		   M.uid_fk=U.uid 
		   AND U.status='1' 
		   AND S.msg_id_fk=M.msg_id 
		   AND S.uid_fk='$uid' group by msg_id)
		   UNION
		   (SELECT 
		   M.msg_id, 
		   M.uid_fk, 
		   M.shared_uid_fk,
		   M.shared_msg_id_fk,
		   M.last_shared_uid_fk,
		   M.message,
		   M.hide_show_comment,
		   M.postPrivacy,
		   M.hide_show_share,
		   M.lovedPost,
		   M.created,
		   M.like_count,
		   M.comment_count,
		   M.share_count,
		   U.username,
		   M.uploads, 
		   '0' AS share_uid, '0' AS share_ouid  FROM messages M, users U 
		   WHERE
		   U.status='1' AND 
		   M.uid_fk=U.uid and 
		   M.uid_fk='$uid' group by msg_id ) 
		   order by created desc ");
		  } else {
			  $query = mysqli_query($this->db,"SELECT M.msg_id, M.uid_fk,M.shared_uid_fk,M.shared_msg_id_fk,M.last_shared_uid_fk, M.message,M.hide_show_comment,M.postPrivacy,M.hide_show_share,M.lovedPost, M.created,M.like_count,M.comment_count,U.username,M.uploads, '0' AS share_uid, '0' AS share_ouid FROM messages M, users U  WHERE U.status='1' AND M.uid_fk=U.uid and M.uid_fk='$uid'") or die(mysqli_error($this->db));
		}
		 $data=mysqli_num_rows($query);
		 return $data;
}
/*Comments*/
public function Comments($msg_id,$second_count) {
	$msg_id=mysqli_real_escape_string($this->db,$msg_id);
	$query='';
	if($second_count) {
	   $query="limit $second_count,2";
	}
    $query = mysqli_query($this->db,"SELECT C.com_id, C.uid_fk, C.comment, C.created,C.like_count, U.username FROM comments C, users U WHERE U.status='1' AND C.uid_fk=U.uid and C.msg_id_fk='$msg_id' order by C.com_id asc $query") or die(mysqli_error($this->db));
	while($row=mysqli_fetch_array($query,MYSQLI_ASSOC))
	$data[]=$row;
	if(!empty($data)) {
	   return $data;
	}
}

/*Insert Comments*/
public function Insert_Comment($uid,$msg_id,$comment) {
	$comment=mysqli_real_escape_string($this->db,$comment);
	$time=time();
	$ip=$_SERVER['REMOTE_ADDR'];
	$query = mysqli_query($this->db,"SELECT com_id,comment FROM `comments` WHERE uid_fk='$uid' and msg_id_fk='$msg_id' order by com_id desc limit 1 ") or die(mysqli_error($this->db));
	$result = mysqli_fetch_array($query,MYSQLI_ASSOC);

	if ($comment!=$result['comment']) {
	    $query = mysqli_query($this->db,"INSERT INTO `comments` (comment, uid_fk,msg_id_fk,ip,created) VALUES (N'$comment', '$uid','$msg_id', '$ip','$time')") or die(mysqli_error($this->db));
	    mysqli_query($this->db,"UPDATE messages SET comment_count=comment_count+1 WHERE msg_id='$msg_id'") or die(mysqli_error($this->db));
	    $newquery = mysqli_query($this->db,"SELECT C.com_id, C.uid_fk, C.comment, C.msg_id_fk, C.created, U.username FROM comments C, users U where C.uid_fk=U.uid and C.uid_fk='$uid' and C.msg_id_fk='$msg_id' order by C.com_id desc limit 1 ");
	    $result = mysqli_fetch_array($newquery,MYSQLI_ASSOC);
	   return $result;
	} else {
	  return false;
	}
}


/* Status Updates*/
public function Status_Update($msg_id) {
	$query = mysqli_query($this->db,"SELECT M.msg_id, M.uid_fk,M.shared_uid_fk, M.message,M.postPrivacy,M.hide_show_comment,M.hide_show_share, M.created,M.like_count,M.comment_count,M.share_count, U.username,M.uploads FROM messages M, users U  WHERE U.status='1' AND M.uid_fk=U.uid and M.msg_id='$msg_id'") or die(mysqli_error($this->db));
	while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
	   $data[]=$row;
	}
	if(!empty($data)) {
	   return $data;
	}
}
/*Admin Status Report*/
public function Admin_Status_Update($msg_id) {
	$query = mysqli_query($this->db,"SELECT M.msg_id, M.uid_fk,M.shared_uid_fk, M.message,M.postPrivacy,M.hide_show_comment,M.hide_show_share, M.created,M.like_count,M.comment_count,M.share_count, U.username,M.uploads FROM messages M, users U  WHERE U.status='1' AND M.msg_id='$msg_id'") or die(mysqli_error($this->db));
	while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
	   $data[]=$row;
	}
	if(!empty($data)) {
	   return $data;
	}
}
/*Change post privacy*/
public function Post_privacy($msg_id,$postPrivacy)  {
	$postPrivacy=mysqli_real_escape_string($this->db,$postPrivacy);
    $query = mysqli_query($this->db,"UPDATE messages SET postPrivacy='$postPrivacy' WHERE msg_id='$msg_id'") or die(mysqli_error($this->db)); 
}
/*Change post Comment privacy*/
public function Post_Comment_privacy($msg_id,$CpostPrivacy)  {
   $CpostPrivacy=mysqli_real_escape_string($this->db,$CpostPrivacy);
   $query = mysqli_query($this->db,"UPDATE messages SET hide_show_comment='$CpostPrivacy' WHERE msg_id='$msg_id'") or die(mysqli_error($this->db)); 
}
/*Change post Comment privacy*/
public function Post_Share_privacy($msg_id,$SpostPrivacy)  {
   $SpostPrivacy=mysqli_real_escape_string($this->db,$SpostPrivacy);
   $query = mysqli_query($this->db,"UPDATE messages SET hide_show_share='$SpostPrivacy' WHERE msg_id='$msg_id'") or die(mysqli_error($this->db)); 
}
/*Delete update*/
public function Delete_Update($uid, $msg_id) {
	$msg_id=mysqli_real_escape_string($this->db,$msg_id);
	//The query to select for delete message
	$query=mysqli_query($this->db,"SELECT msg_id FROM `messages` WHERE msg_id = '$msg_id' and uid_fk='$uid'") or die(mysqli_error($this->db));
	// For Share Delete
	$sharequery = mysqli_query($this->db,"SELECT shared_msg_id_fk FROM messages WHERE shared_msg_id_fk = '$msg_id'") or die(mysqli_error($this->db));
	$sharedNum = mysqli_num_rows($sharequery);
	if($sharedNum) {
	  mysqli_query($this->db,"DELETE FROM `messages` WHERE shared_msg_id_fk = '$msg_id'") or die(mysqli_error($this->db));	
	}
	$msg_num=mysqli_num_rows($query);
	if($msg_num) {
	   // Delete the message like
	   mysqli_query($this->db,"DELETE FROM `message_like` WHERE msg_id_fk = '$msg_id'") or die(mysql_error($this->db));
	   //Delete the comments
	   mysqli_query($this->db,"DELETE FROM `comments` WHERE msg_id_fk = '$msg_id'") or die(mysqli_error($this->db));
	   //The query to select for delete upload message
	   $q=mysqli_query($this->db,"SELECT uploads FROM `messages` WHERE msg_id = '$msg_id'") or die(mysqli_error($this->db));
	   $row=mysqli_fetch_array($q, MYSQLI_ASSOC);
	   if(strlen($row['uploads'])>1) {//If more than one image to be deleted
		   $s = explode(",", $row['uploads']); // Define the array which holds the value names
		   $i=1;
		   $f=count($s);
		   foreach($s as $a) {
			  // Delete each image
			  // for each user uploads
			  //The query to select for delete upload image
			$query = mysqli_query($this->db,"SELECT image_path FROM user_uploads WHERE id='$a'") or die(mysqli_error($this->db));
			$newdata = mysqli_fetch_array($query, MYSQLI_ASSOC);
			if($newdata) {
				// Delete each image
				$final_image="uploads/".$newdata['image_path'];
				mysqli_query($this->db,"DELETE FROM user_uploads WHERE id='$a'") or die(mysqli_error($this->db));
				unlink($final_image);
			 }
			 $i=$i+1;
		}
	 }
/* End */
//Delete the msg_id from messages
mysqli_query($this->db,"DELETE FROM `messages` WHERE msg_id = '$msg_id'") or die(mysqli_error($this->db));
//reduce the updates count -1
mysqli_query($this->db,"UPDATE `users` SET updates_count=updates_count-1 WHERE uid='$uid'") or die(mysqli_error($this->db));
return true;
}

} 
/*Delete update*/
public function SharePostDelete($uid, $msg_id) {
	$msg_id=mysqli_real_escape_string($this->db,$msg_id);
	//The query to select for delete message
	$query=mysqli_query($this->db,"SELECT msg_id FROM `messages` WHERE msg_id = '$msg_id' and uid_fk='$uid'") or die(mysqli_error($this->db));
	$msg_num=mysqli_num_rows($query);
	if($msg_num) {
	   // Delete the message like
	   mysqli_query($this->db,"DELETE FROM `message_like` WHERE msg_id_fk = '$msg_id'") or die(mysql_error($this->db));
	   //Delete the comments
	   mysqli_query($this->db,"DELETE FROM `comments` WHERE msg_id_fk = '$msg_id'") or die(mysqli_error($this->db));
/* End */
//Delete the msg_id from messages
mysqli_query($this->db,"DELETE FROM `messages` WHERE msg_id = '$msg_id'") or die(mysqli_error($this->db));
//reduce the updates count -1
mysqli_query($this->db,"UPDATE `users` SET updates_count=updates_count-1 WHERE uid='$uid'") or die(mysqli_error($this->db));
return true;
}

} 
public function EditPostDetails($msg_id, $update, $uploads, $uploadids) {

$query = mysqli_query($this->db,"UPDATE messages SET message='$update' WHERE msg_id='$msg_id'") or die(mysqli_error($this->db)); 
if(strlen($uploads)>1) {
	$query = mysqli_query($this->db,"UPDATE messages SET uploads='$uploadids' WHERE msg_id='$msg_id'") or die(mysqli_error($this->db));
	$iEx = explode(",", $uploads);
	$i = 1;
	$f = count($iEx);
	foreach($iEx as $img_id) {
	   $query = mysqli_query($this->db,"SELECT image_path FROM user_uploads WHERE id='$img_id'") or die(mysqli_error($this->db));	
	   $DelImage = mysqli_fetch_array($query, MYSQLI_ASSOC);
	   if($DelImage) {
		   $final_image = "uploads".$DelImage['image_path'];
		   mysqli_query($this->db,"DELETE FROM user_uploads WHERE id='$img_id'")or die(mysqli_error($this->db));
	   }
	}
}
} 
/*Edit Comments*/
public function EditComment($com_id,$comment) {
$comment=mysqli_real_escape_string($this->db,$comment);
$com_id=mysqli_real_escape_string($this->db,$com_id);
if(!empty($comment)){
	mysqli_query($this->db,"SET character_set_client=utf8") or die(mysqli_error($this->db));
	mysqli_query($this->db,"SET character_set_connection=utf8") or die(mysqli_error($this->db));
	$query = mysqli_query($this->db,"UPDATE comments SET comment='$comment' WHERE com_id='$com_id'") or die(mysqli_error($this->db));
}	
}
/*Make a Loved Post*/
public function MakeFavourite($msg_id,$lovedPost)  {
   $lovedPost=mysqli_real_escape_string($this->db,$lovedPost);
   $query = mysqli_query($this->db,"UPDATE messages SET lovedPost='$lovedPost' WHERE msg_id='$msg_id'") or die(mysqli_error($this->db)); 
}
/*Favourite Post Insert Data*/

public function AddFavourite($uid, $msgID) {
	$uid = mysqli_real_escape_string($this->db, $uid);
	$msgID = mysqli_real_escape_string($this->db, $msgID);
	$query = mysqli_query($this->db,"INSERT INTO favourite(fav_uid,fav_msgID ) VALUES('$uid','$msgID')")or die(mysqli_error($this->db));
	
}

/*Comment Like */
public function Comment_Like($com_id, $uid) {
	$com_id=mysqli_real_escape_string($this->db,$com_id);
	$uid=mysqli_real_escape_string($this->db,$uid);
	//Select the message comment like id from comment_like table
	$q=mysqli_query($this->db,"SELECT clike_id FROM comment_like WHERE  uid_fk='$uid' and com_id_fk='$com_id' ") or die(mysqli_error($this->db));
	if(mysqli_num_rows($q)==0) {// If user not liked this comment before
	   $q=mysqli_query($this->db,"SELECT M.uid_fk FROM messages M, comments C WHERE M.msg_id=C.msg_id_fk AND C.com_id='$com_id'") or die(mysqli_error($this->db));
	   $r=mysqli_fetch_array($q, MYSQLI_ASSOC);
	   $ouid=$r['uid_fk'];
	   $time=time();
	   // Then insert the like from the comment_like table
	   $query=mysqli_query($this->db,"INSERT INTO comment_like (com_id_fk,uid_fk,ouid_fk,created) VALUES('$com_id','$uid','$ouid','$time')") or die(mysqli_error($this->db));
	   // Prepare the statement
	   $q=mysqli_query($this->db,"UPDATE comments SET like_count=like_count+1 WHERE com_id='$com_id'") or die(mysqli_error($this->db));
	   $g=mysqli_query($this->db,"SELECT like_count FROM comments WHERE com_id='$com_id'");
	   $d=mysqli_fetch_array($g, MYSQLI_ASSOC);
	   return $d['like_count'];
	} else {
		return false;
	}
}
/*Comment Unlike Check*/
public function Comment_Unlike($com_id, $uid) {
	$com_id=mysqli_real_escape_string($this->db,$com_id);
	$uid=mysqli_real_escape_string($this->db,$uid);
	//Select the comment like id from comment like table
	$q=mysqli_query($this->db,"SELECT clike_id FROM comment_like WHERE uid_fk='$uid' and com_id_fk='$com_id' ");
	if(mysqli_num_rows($q)>0) {//If user liked the comment before
		// Then user see the liked button
		// If user click the unlike button
		$query=mysqli_query($this->db,"DELETE FROM comment_like WHERE com_id_fk='$com_id' and uid_fk='$uid'");
		//Prepare the statement
		$q=mysqli_query($this->db,"UPDATE comments SET like_count=like_count-1 WHERE com_id='$com_id'") or die(mysqli_error($this->db));
		// Also the comments like count 1 deprecent
		$g=mysqli_query($this->db,"SELECT like_count FROM comments WHERE com_id='$com_id'");
		$d=mysqli_fetch_array($g, MYSQLI_ASSOC);
		return $d['like_count'];
	  } else {
		  return false;
	 }
}
/*Comment Like Check*/
public function Comment_Like_Check($com_id, $uid) {
	$com_id=mysqli_real_escape_string($this->db,$com_id);
	$uid=mysqli_real_escape_string($this->db,$uid);
	$q=mysqli_query($this->db,"SELECT clike_id FROM comment_like WHERE  uid_fk='$uid' and com_id_fk='$com_id' ") or die(mysqli_error($this->db));
	if(mysqli_num_rows($q)==0){ // If the user liked the comment id before then show the liked button
	   return true;
	 } else {//If the user not liked the comment id before then show normal button
	   return false;
	 }
}
/*Delete Comments*/
public function Delete_Comment($uid, $com_id) {
	$uid=mysqli_real_escape_string($this->db,$uid);//User id
	$com_id=mysqli_real_escape_string($this->db,$com_id);// comment id
	// The query to select for delete comment
	$q=mysqli_query($this->db,"SELECT M.uid_fk, M.msg_id FROM comments C, messages M WHERE C.msg_id_fk = M.msg_id AND C.com_id='$com_id'") or die(mysqli_error($this->db));
	$d=mysqli_fetch_array($q, MYSQLI_ASSOC);
	$oid=$d['uid_fk']; // oid is commented user id
	$msgid= $d['msg_id'];
	if($uid==$oid) { // if user id is equal to oid
	   // Delete the comment
	   $query = mysqli_query($this->db,"DELETE FROM `comments` WHERE com_id='$com_id'") or die(mysqli_error($this->db));
	   //reduce the like cound count -1
	   $lam = mysqli_query($this->db,"UPDATE messages SET comment_count=comment_count-1 WHERE msg_id='$msgid'") or die(mysqli_error($this->db));
	   if($lam){
		   echo 'lam='.$lam.'dir';
		   }
	   return true;
	 } else {
		 // The query to select for delete comment
		 $query = mysqli_query($this->db,"DELETE FROM `comments` WHERE uid_fk='$uid' and com_id='$com_id'") or die(mysqli_error($this->db));
		 return true;
	 }
}

/*Like Validate Check*/
public function Like_Check($msg_id, $uid) {
	$msg_id=mysqli_real_escape_string($this->db,$msg_id);
	$uid=mysqli_real_escape_string($this->db,$uid);
	//Check that users Liked the message.
	 $q=mysqli_query($this->db,"SELECT like_id FROM message_like WHERE  uid_fk='$uid' and msg_id_fk='$msg_id'") or die(mysqli_error($this->db));
	// Output the result
	if(mysqli_num_rows($q)==0) {
		return true;
	 } else {
		 return false;
	 }
}
/*Check Favourite*/
public function CheckFavourite($msg_id,$uid) {
	$msg_id=mysqli_real_escape_string($this->db,$msg_id);
	$uid=mysqli_real_escape_string($this->db,$uid);
	$q=mysqli_query($this->db,"SELECT fav_id FROM favourite WHERE  fav_uid='$uid' and fav_msgID='$msg_id' ") or die(mysqli_error($this->db));
	if(mysqli_num_rows($q)==0){ // If the user liked the comment id before then show the liked button
	   return true;
	 } else {//If the user not liked the comment id before then show normal button
	   return false;
	 }
}
/*Remove Favourite*/
public function RemoveFavouriteList($uid, $msg_id) {
	$msg_id=mysqli_real_escape_string($this->db,$msg_id);
	$uid=mysqli_real_escape_string($this->db,$uid);
	 $q=mysqli_query($this->db,"SELECT fav_id FROM favourite WHERE fav_uid='$uid' and fav_msgID='$msg_id'") or die(mysqli_error($this->db));
	if(mysqli_num_rows($q)>0) {
		//If user liked the message id then showing unlike button
		//If user clicked the unlike button then delete the message id and uid from the message like table
		$query=mysqli_query($this->db,"DELETE FROM favourite WHERE fav_msgID='$msg_id' and fav_uid='$uid'") or die(mysqli_error($this->db));
	   } else {
		   return false;
	  }
}

/*Like Users*/
public function Like_Users($msg_id) {
	// This is showing which user liked the updated message
	$msg_id=mysqli_real_escape_string($this->db,$msg_id); 
	$q=mysqli_query($this->db,"SELECT like_id FROM message_like WHERE msg_id_fk='$msg_id' ") or die(mysqli_error($this->db));
	if(mysqli_num_rows($q)>0) { // If any user liked the updated message
		$query=mysqli_query($this->db,"SELECT U.username, U.profile_img, U.uid FROM message_like M, users U WHERE U.uid=M.uid_fk AND M.msg_id_fk='$msg_id' LIMIT 5") or die(mysqli_error($this->db));
		// Then showing the username in liked user. Like: abc,def liked this
		while($row=mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			 $data[]=$row;
		   }
	   return $data;
	}
}
/*Unlike*/
public function Unlike($msg_id, $uid) {
	$msg_id=mysqli_real_escape_string($this->db,$msg_id);
	$uid=mysqli_real_escape_string($this->db,$uid);
	 $q=mysqli_query($this->db,"SELECT like_id FROM message_like WHERE uid_fk='$uid' and msg_id_fk='$msg_id'") or die(mysqli_error($this->db));
	if(mysqli_num_rows($q)>0) {
		//If user liked the message id then showing unlike button
		//If user clicked the unlike button then delete the message id and uid from the message like table
		$query=mysqli_query($this->db,"DELETE FROM message_like WHERE msg_id_fk='$msg_id' and uid_fk='$uid'") or die(mysqli_error($this->db));
		//Prepare the statement
		$q=mysqli_query($this->db,"UPDATE messages SET like_count=like_count-1 WHERE msg_id='$msg_id'") or die(mysql_error());
		$g=mysqli_query($this->db,"SELECT like_count FROM messages WHERE msg_id='$msg_id'") or die(mysqli_error($this->db));
		$d=mysqli_fetch_array($g, MYSQLI_ASSOC);
		return $d['like_count'];
	   } else {
		   return false;
	  }
}


/*Like Message*/
public function Like($msg_id, $uid) {
	$msg_id=mysqli_real_escape_string($this->db,$msg_id);
	$uid=mysqli_real_escape_string($this->db,$uid);
	// Select the message like_id from message_like table
	$q=mysqli_query($this->db,"SELECT like_id FROM message_like WHERE  uid_fk='$uid' and msg_id_fk='$msg_id' ") or die(mysqli_error($this->db));
	if(mysqli_num_rows($q)==0) {// If user not liked the message before
	   $q=mysqli_query($this->db,"SELECT uid_fk FROM messages WHERE msg_id='$msg_id'") or die(mysqli_error($this->db));
	   $r=mysqli_fetch_array($q, MYSQLI_ASSOC);
	   $ouid=$r['uid_fk'];
	   $time=time();
	   // then insert the like from message like table
	   $query=mysqli_query($this->db,"INSERT INTO message_like (msg_id_fk,uid_fk,ouid_fk,created) VALUES('$msg_id','$uid','$ouid','$time')") or die(mysqli_error($this->db));  
	   
	   // Prepare the statement
	   $q=mysqli_query($this->db,"UPDATE messages SET like_count=like_count+1 WHERE msg_id='$msg_id'") or die(mysqli_error($this->db));
	   $g=mysqli_query($this->db,"SELECT like_count FROM messages WHERE msg_id='$msg_id'");
	   $d=mysqli_fetch_array($g, MYSQLI_ASSOC);
	   return $d['like_count'];
	} else {
		return false;
	}
}
/*Like Count Test*/
public function Like_CountT($msg_id, $uid, $reaction_type) {
	$msg_id = mysqli_real_escape_string($this->db,$msg_id);
	$reaction_type = mysqli_real_escape_string($this->db,$reaction_type);
	$q = mysqli_query($this->db,"SELECT COUNT(*) AS reaction_count FROM message_like WHERE msg_id_fk = '$msg_id' AND reaction_type = '$reaction_type'") or die(mysqli_error($this->db));
	$row = mysqli_fetch_array($q, MYSQLI_ASSOC);
	if ($row) {
		 return $row['reaction_count'];
	 } else return 0;
 }
 /*Like Count Test*/
public function Like_CountTotal($msg_id, $uid, $reaction_type) {
	$msg_id = mysqli_real_escape_string($this->db,$msg_id);
	$reaction_type = mysqli_real_escape_string($this->db,$reaction_type);
	$q = mysqli_query($this->db,"SELECT reaction_type, COUNT(*) AS reaction_count FROM message_like WHERE msg_id_fk = '$msg_id' GROUP BY reaction_type") or die(mysqli_error($this->db));
	$row = mysqli_fetch_array($q, MYSQLI_ASSOC);
	if ($row) {
		 return $row['reaction_count'];
	 } else return 0;
 }
// Hashtag
public function Total_Get_Hashtags($lasthid, $hashTag="") {
	$hashTag = mysqli_real_escape_string($this->db,strip_tags(trim($hashTag)));
    $query = mysqli_query($this->db,"SELECT COUNT(*) AS total FROM users INNER JOIN messages ON users.uid =  messages.uid_fk WHERE FIND_IN_SET('$hashTag', hashTag)") or die(mysqli_error($this->db));
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
	if(!empty($row)) {
		 return $row['total'];
	 }
}
/*Favourite List Query*/

public function FavouriteList($uid, $favID){
	$favID = mysqli_real_escape_string($this->db, $favID);
	
	$morFav ='';
	
	if($favID){
		$morFav = "and messages.msg_id < '".$favID."'";
	}
	$query = mysqli_query($this->db,"SELECT 
 favourite.fav_id,
 favourite.fav_uid,
 favourite.fav_msgID,
 messages.message,
 messages.msg_id,
 messages.uploads,
 messages.hashTag,
 messages.like_count,
 messages.uid_fk,
 messages.created,
 messages.postPrivacy,
 messages.hide_show_comment,
 messages.like_count,
 messages.comment_count
 FROM favourite
 JOIN messages
 ON  messages.msg_id = favourite.fav_msgID
 JOIN users
 ON users.uid = favourite.fav_uid
 WHERE favourite.fav_msgID  = messages.msg_id $morFav
  ORDER BY fav_msgID DESC LIMIT
 ".$this->perpage)or die(mysqli_error($this->db));
	while($row=mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		    // Store the result into array
			 $data[]=$row;
	    }
	    if(!empty($data)) {
		   return $data;
	    }
}
// Hashtags	
public function Get_Hashtags($lasthid, $hashTag="") {
	 $hashTag = mysqli_real_escape_string($this->db,strip_tags(trim($hashTag)));
	 // Now if it has commas, you have to explode() it to an array
	 $hashtags_list = explode(',', $hashTag);
	 // A variable to hold all the hashtag LIKE conditions
	 $hashtag_query = array();
	 foreach ($hashtags_list as $ht) {
	 // Each tag has to be checked with LIKE alone
	    $hashtag_query[] = "FIND_IN_SET(LOWER('$ht'), LOWER(hashTag))";
	 }
	 // Make them into AND conditions
	 $hashtag_query = implode(' AND ', $hashtag_query);
   
	 $morequery="";
	 if($lasthid) {
		 //build up the query
	    $morequery=" and messages.msg_id < '".$lasthid."' ";
	 }
	 $query = mysqli_query($this->db,"SELECT users.uid,
	       users.username,
		   users.name,
		   users.last_login,
		   users.profile_img,
		   messages.message,
		   messages.msg_id,
		   messages.hide_show_comment,
		   messages.uid_fk,
		   messages.like_count,
		   messages.created,
		   messages.comment_count,
		   messages.uploads,
		   messages.hashTag
		   FROM users
		   INNER JOIN messages
		   ON users.uid =  messages.uid_fk
		   WHERE ($hashtag_query) $morequery ORDER BY msg_id DESC LIMIT " .$this->perpage) or die(mysqli_error($this->db));
	    while($row=mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		    // Store the result into array
			 $data[]=$row;
	    }
	    if(!empty($data)) {
		   return $data;
	    }
}
 /*Last Login Update*/
public function Notification_Created_Update($uid) {
   $time=time();
	$query=mysqli_query($this->db,"UPDATE users SET notification_created='$time' WHERE uid='$uid'") or die(mysqli_error($this->db));
return true;
}
 /*Notifications*/
public function Notifications($uid, $lastid, $notifications_perpage) {
	$notifications_perpage = 105; // How many notifications showing
	$morequery=""; // query is empty
	$morequery_friend = ""; // query friend is empty
	$morequery_group = "";  // query helper is empty
	$morequery_group_status = ""; // query helper status is empty
	if($lastid) {
	   $morequery=" and S.created<'".$lastid."' "; // query was created
	   $morequery_friend=" and F.created<'".$lastid."' "; // query friend was created
	   $morequery_group=" and X.created<'".$lastid."' "; // query helper was created
	   $morequery_group_status=" and M.created<'".$lastid."' "; // query helper status was created
	  }
	  $uid=mysqli_real_escape_string($this->db,$uid);
	  //The query to select for notifications
	  $query=mysqli_query($this->db,"(SELECT DISTINCT M.msg_id as msg_id, S.uid_fk, S.ouid_fk as ouid_fk , M.group_id_fk,M.message, S.created, '0' as type
	  FROM
	  messages M, users U, friends F,message_share S
	  WHERE
	  F.friend_one='$uid' AND
	  U.uid = F.friend_one AND
	  U.status='1' AND
	  F.friend_two != S.ouid_fk AND
	  S.uid_fk  = F.friend_two AND
	  M.uid_fk = S.ouid_fk AND F.role='fri' AND
	  S.msg_id_fk = M.msg_id AND S.uid_fk<>'$uid' $morequery GROUP BY M.msg_id)
	  UNION
	  
	  (SELECT DISTINCT '0' as msg_id, F.friend_one as uid_fk, '0' as ouid_fk , '0' as group_id_fk, '0' as message, F.created, '3' as type
	  FROM users U, friends F
	  WHERE F.friend_two='$uid' AND U.uid = F.friend_one AND U.status='1' AND F.role='fri' $morequery_friend)
	  UNION
	  
	  (SELECT
	  DISTINCT '0' as msg_id, X.uid as uid_fk, '0' as ouid_fk , X.group_id_fk as group_id_fk, '0' as message, X.created, '4' as type
	  FROM users U, notification X
	  WHERE X.uid=U.uid AND U.uid='$uid' AND X.uid<>'$uid' AND X.help_status='1' AND U.status='1' $morequery_group)
	  UNION
	  (SELECT
	  DISTINCT M.msg_id as msg_id, M.uid_fk as uid_fk, '0' as ouid_fk , M.group_id_fk as group_id_fk, M.message as message, M.created, '5' as type
	  FROM users U, messages M,notification X
	  WHERE X.uid=U.uid AND U.uid='$uid' AND M.uid_fk<>X.uid AND X.help_status='1' AND U.status='1' $morequery_group_status)
	  
	  UNION
	  (SELECT DISTINCT M.msg_id  as msg_id, S.uid_fk, S.ouid_fk as ouid_fk, M.group_id_fk,M.message, S.created, '1' as type
	  FROM
	  messages M, users U, friends F,message_like S
	  WHERE
	  F.friend_one='$uid' AND
	  U.uid = F.friend_one AND
	  U.status='1' AND
	  F.friend_two != S.ouid_fk AND
	  S.uid_fk  = F.friend_two AND
	  M.uid_fk = S.ouid_fk AND F.role='fri' AND
	  S.msg_id_fk = M.msg_id AND S.uid_fk<>S.ouid_fk AND S.uid_fk<>'$uid' $morequery  GROUP BY M.msg_id)
	  
	  UNION
	  (SELECT DISTINCT M.msg_id  as msg_id, S.uid_fk, M.uid_fk as ouid_fk, M.group_id_fk,M.message, S.created, '2' as type
	  FROM
	  messages M, users U, friends F,comments S
	  WHERE
	  F.friend_one='$uid' AND
	  U.uid = F.friend_one AND
	  U.status='1' AND
	  F.friend_two != S.uid_fk AND
	  M.uid_fk = '$uid' AND F.role='fri' AND
	  S.msg_id_fk = M.msg_id  AND S.uid_fk<>'$uid' $morequery  GROUP BY M.msg_id)
	  ORDER BY created DESC LIMIT $notifications_perpage")or die(mysqli_error($this->db));
	  //Store the result
	  while($row=mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		  // Store the result into array
			$data[]=$row;
		  }
		  if(!empty($data)) {
		 // Store the result into array
		   return $data;
		}
}

/*Notifications*/
public function Notifications_Count($uid, $created) {
	$uid=mysqli_real_escape_string($this->db,$uid);
	$created=mysqli_real_escape_string($this->db,$created);
   //The query to select for notifications count
	$query=mysqli_query($this->db,"(SELECT DISTINCT M.msg_id, S.uid_fk, S.ouid_fk, M.group_id_fk,M.message, S.created, '0' as type
	FROM
	messages M, users U, friends F,message_share S
	WHERE
	F.friend_one='$uid' AND
	U.uid = F.friend_one AND
	U.status='1' AND
	F.friend_two != S.ouid_fk AND
	S.uid_fk  = F.friend_two AND
	M.uid_fk = S.ouid_fk AND F.role='fri' AND
	S.msg_id_fk = M.msg_id AND S.uid_fk<>'$uid' AND S.created>'$created' GROUP BY M.msg_id)
	UNION
	(SELECT DISTINCT '1' as msg_id, F.friend_one as uid_fk, '1' as ouid_fk , '1' as group_id_fk, '1' as message, F.created, '3' as type
	FROM users U, friends F
	WHERE F.friend_two='$uid' AND U.uid = F.friend_one AND U.status='1' AND F.role='fri' AND F.created>'$created' )
	UNION
	(SELECT DISTINCT M.msg_id, S.uid_fk, S.ouid_fk, M.group_id_fk,M.message, S.created, '1' as type
	FROM
	messages M, users U, friends F,message_like S
	WHERE
	F.friend_one='$uid' AND
	U.uid = F.friend_one AND
	U.status='1' AND
	F.friend_two != S.ouid_fk AND
	S.uid_fk  = F.friend_two AND
	M.uid_fk = S.ouid_fk AND F.role='fri' AND
	S.msg_id_fk = M.msg_id AND S.uid_fk<>S.ouid_fk AND S.uid_fk<>'$uid' AND S.created>'$created' GROUP BY M.msg_id)
	UNION
	(SELECT
	DISTINCT '0' as msg_id, X.uid as uid_fk, '0' as ouid_fk , X.group_id_fk as group_id_fk, '0' as message, X.created, '4' as type
	FROM users U, notification X
	WHERE X.uid=U.uid AND U.uid='$uid' AND X.uid<>'$uid' AND X.help_status='1' AND U.status='1' AND X.created>'$created')
	UNION
	(SELECT
	DISTINCT M.msg_id as msg_id, M.uid_fk as uid_fk, '0' as ouid_fk , M.group_id_fk as group_id_fk, M.message as message, M.created, '5' as type
	FROM users U, messages M,notification X
	WHERE X.uid=U.uid AND U.uid='$uid' AND M.uid_fk<>X.uid AND X.help_status='1' AND U.status='1' AND M.created>'$created')
	
	UNION
	(SELECT DISTINCT M.msg_id, S.uid_fk, M.uid_fk as ouid_fk, M.group_id_fk,M.message, S.created, '2' as type
	FROM
	messages M, users U, friends F,comments S
	WHERE
	F.friend_one='$uid' AND
	U.uid = F.friend_one AND
	U.status='1' AND
	F.friend_two != S.uid_fk AND
	M.uid_fk = '$uid' AND F.role='fri' AND
	S.msg_id_fk = M.msg_id  AND S.uid_fk<>'$uid' AND S.created>'$created' GROUP BY M.msg_id)
	ORDER BY created DESC")or die(mysqli_error($this->db));
	// Output the result
	return mysqli_num_rows($query);
	}
 /*Edit User Full Name*/
public function Edit_FullName($fullName, $uid) { 
	$uid = mysqli_real_escape_string($this->db, $uid);
	mysqli_query($this->db,"SET character_set_client=utf8") or die(mysqli_error($this->db));
	mysqli_query($this->db,"SET character_set_connection=utf8") or die(mysqli_error($this->db));
	mysqli_query($this->db,"UPDATE users SET name='$fullName' WHERE uid='$uid'") or die(mysqli_error($this->db));
}
// Edit User FullName Ad
public function EEdit_FullName($efullName, $euid) { 
	$euid = mysqli_real_escape_string($this->db, $euid);
	mysqli_query($this->db,"SET character_set_client=utf8") or die(mysqli_error($this->db));
	mysqli_query($this->db,"SET character_set_connection=utf8") or die(mysqli_error($this->db));
	mysqli_query($this->db,"UPDATE users SET name='$efullName' WHERE uid='$euid'") or die(mysqli_error($this->db));
}
// Edit Facebook
public function FaceBook($fb, $uid) {
  $uid = mysqli_real_escape_string($this->db, $uid);
  mysqli_query($this->db,"UPDATE users SET fb='$fb' WHERE uid='$uid'") or die(mysqli_error($this->db));
}
// Edit User Facebook 
public function Efacebook($efb, $euid){
  $euid = mysqli_real_escape_string($this->db, $euid);
  mysqli_query($this->db,"UPDATE users SET fb='$efb' WHERE uid='$euid'") or die(mysqli_error($this->db));
}
// Edit Twitter
public function TwitTer($tw, $uid) {
  $uid = mysqli_real_escape_string($this->db, $uid);
  mysqli_query($this->db,"UPDATE users SET tw='$tw' WHERE uid='$uid'") or die(mysqli_error($this->db));
}
// Edit User Twitter
public function ETwitTer($etw, $euid) {
  $euid = mysqli_real_escape_string($this->db, $euid);
  mysqli_query($this->db,"UPDATE users SET tw='$etw' WHERE uid='$euid'") or die(mysqli_error($this->db));
}
// Edit Google Plus
public function GooglePlusS($gp, $uid) {
  $uid = mysqli_real_escape_string($this->db, $uid);
  mysqli_query($this->db,"UPDATE users SET gp='$gp' WHERE uid='$uid'") or die(mysqli_error($this->db));
}
// Edit User GooglePlus
public function EGooglePlusS($egp, $euid) {
  $euid = mysqli_real_escape_string($this->db, $euid);
  mysqli_query($this->db,"UPDATE users SET gp='$egp' WHERE uid='$euid'") or die(mysqli_error($this->db));
}
// Edit Youtube
public function YoutToBe($yt, $uid) {
  $uid = mysqli_real_escape_string($this->db, $uid);
  mysqli_query($this->db,"UPDATE users SET yout='$yt' WHERE uid='$uid'") or die(mysqli_error($this->db));
}
// Edit User Youtube 
public function EYoutToBe($eyt, $euid) {
  $euid = mysqli_real_escape_string($this->db, $euid);
  mysqli_query($this->db,"UPDATE users SET yout='$eyt' WHERE uid='$euid'") or die(mysqli_error($this->db));
}
// Edit Instagram
public function InsTagRam($in, $uid) {
  $uid = mysqli_real_escape_string($this->db, $uid);
  mysqli_query($this->db,"UPDATE users SET ins='$in' WHERE uid='$uid'") or die(mysqli_error($this->db));
}
// Edit User Instagram
public function EInsTagRam($ein, $euid) {
  $euid = mysqli_real_escape_string($this->db, $euid);
  mysqli_query($this->db,"UPDATE users SET ins='$ein' WHERE uid='$euid'") or die(mysqli_error($this->db));
}
// Edit Phone Number
public function TelepHoneNum($tel, $uid) {
  $uid = mysqli_real_escape_string($this->db, $uid);
  mysqli_query($this->db,"UPDATE users SET tel='$tel' WHERE uid='$uid'") or die(mysqli_error($this->db));
}
// Edit User Phone Number
public function ETelepHoneNum($etel, $euid) {
  $euid = mysqli_real_escape_string($this->db, $euid);
  mysqli_query($this->db,"UPDATE users SET tel='$etel' WHERE uid='$euid'") or die(mysqli_error($this->db));
}
// Edit Location
public function LocationU($loc, $uid) {
  $uid = mysqli_real_escape_string($this->db, $uid);
  mysqli_query($this->db,"UPDATE users SET location='$loc' WHERE uid='$uid'") or die(mysqli_error($this->db));
}
// Edit User Location
public function ELocationU($eloc, $euid) {
  $euid = mysqli_real_escape_string($this->db, $euid);
  mysqli_query($this->db,"UPDATE users SET location='$eloc' WHERE uid='$euid'") or die(mysqli_error($this->db));
}
// Edit Post Privacy
public function PostHide($pst, $uid) {
  $uid = mysqli_real_escape_string($this->db, $uid);
  mysqli_query($this->db,"UPDATE users SET postHide='$pst' WHERE uid='$uid'") or die(mysqli_error($this->db));
}
// Edit User Post Privacy
public function EPostHide($epst, $euid) {
  $euid = mysqli_real_escape_string($this->db, $euid);
  mysqli_query($this->db,"UPDATE users SET postHide='$epst' WHERE uid='$euid'") or die(mysqli_error($this->db));
}
// Edit Following Privacy
public function FolloWingHide($flw, $uid) {
  $uid = mysqli_real_escape_string($this->db, $uid);
  mysqli_query($this->db,"UPDATE users SET followingHide='$flw' WHERE uid='$uid'") or die(mysqli_error($this->db));
}
// Edit User Following Privacy
public function EFolloWingHide($eflw, $euid) {
  $euid = mysqli_real_escape_string($this->db, $euid);
  mysqli_query($this->db,"UPDATE users SET followingHide='$eflw' WHERE uid='$euid'") or die(mysqli_error($this->db));
}
// Edit Follower Privacy
public function FolloWerHide($flwr, $uid) {
  $uid = mysqli_real_escape_string($this->db, $uid);
  mysqli_query($this->db,"UPDATE users SET followerHide='$flwr' WHERE uid='$uid'") or die(mysqli_error($this->db));
}
// Edit User Follower Privacy
public function EFolloWerHide($eflwr, $euid) {
  $euid = mysqli_real_escape_string($this->db, $euid);
  mysqli_query($this->db,"UPDATE users SET followerHide='$eflwr' WHERE uid='$euid'") or die(mysqli_error($this->db));
}
// Edit Social Account Privacy
public function SocialAccountHide($slca, $uid) {
  $uid = mysqli_real_escape_string($this->db, $uid);
  mysqli_query($this->db,"UPDATE users SET socialHide='$slca' WHERE uid='$uid'") or die(mysqli_error($this->db));
}
// Edit Social Account Privacy
public function ESocialAccountHide($eslca, $euid) {
  $euid = mysqli_real_escape_string($this->db, $euid);
  mysqli_query($this->db,"UPDATE users SET socialHide='$eslca' WHERE uid='$euid'") or die(mysqli_error($this->db));
}
// Edit Phone Number Privacy
public function PhoneNumberHide($phn, $uid) {
  $uid = mysqli_real_escape_string($this->db, $uid);
  mysqli_query($this->db,"UPDATE users SET phoneHide='$phn' WHERE uid='$uid'") or die(mysqli_error($this->db));
}
// Edit User Phone Number Privacy
public function EPhoneNumberHide($ephn, $euid) {
  $euid = mysqli_real_escape_string($this->db, $euid);
  mysqli_query($this->db,"UPDATE users SET phoneHide='$ephn' WHERE uid='$euid'") or die(mysqli_error($this->db));
}
// Edit Gender
public function Gender($gend, $uid) {
  $uid = mysqli_real_escape_string($this->db, $uid);
  mysqli_query($this->db,"UPDATE users SET gender='$gend' WHERE uid='$uid'") or die(mysqli_error($this->db));
}
// Edit User Gender
public function EGender($egend, $euid) {
  $euid = mysqli_real_escape_string($this->db, $euid);
  mysqli_query($this->db,"UPDATE users SET gender='$egend' WHERE uid='$euid'") or die(mysqli_error($this->db));
}
// Edit Website
public function WebSite($wb, $uid) {
  $uid = mysqli_real_escape_string($this->db, $uid);
  mysqli_query($this->db,"UPDATE users SET u_website='$wb' WHERE uid='$uid'") or die(mysqli_error($this->db));
}
// Edit User Website
public function EWebSite($ewb, $euid) {
  $euid = mysqli_real_escape_string($this->db, $euid);
  mysqli_query($this->db,"UPDATE users SET u_website='$ewb' WHERE uid='$euid'") or die(mysqli_error($this->db));
}
// Edit Bio
public function UbiO($bio, $uid) {
  $uid = mysqli_real_escape_string($this->db, $uid);
  mysqli_query($this->db,"SET character_set_client=utf8") or die(mysqli_error($this->db));
  mysqli_query($this->db,"SET character_set_connection=utf8") or die(mysqli_error($this->db));
  mysqli_query($this->db,"UPDATE users SET bio='$bio' WHERE uid='$uid'") or die(mysqli_error($this->db));
}
// Edit User Bio
public function EUbiO($ebio, $euid) {
  $euid = mysqli_real_escape_string($this->db, $euid);
  mysqli_query($this->db,"SET character_set_client=utf8") or die(mysqli_error($this->db));
  mysqli_query($this->db,"SET character_set_connection=utf8") or die(mysqli_error($this->db));
  mysqli_query($this->db,"UPDATE users SET bio='$ebio' WHERE uid='$euid'") or die(mysqli_error($this->db));
}
//Change Password
public function Change_Password($oldpassword, $newpassword, $cpassword, $uid) {
	$oldpassword=mysqli_real_escape_string($this->db,$oldpassword); // Currently used password
	$md5_oldpassword=md5($oldpassword); //Currently used password
	$newpassword=mysqli_real_escape_string($this->db,$newpassword); // New password
	$md5_newpassword=md5($newpassword);// new password
	$cpassword=mysqli_real_escape_string($this->db,$cpassword);
	$md5_cpassword=md5($cpassword);
	$uid=mysqli_real_escape_string($this->db,$uid);
	if($newpassword==$cpassword) {
		// If new passwords are equel
		$query=mysqli_query($this->db,"SELECT uid FROM users WHERE uid='$uid' AND password='$md5_oldpassword'") or die(mysqli_error($this->db));
		if(mysqli_num_rows($query)>0){
			// Add a new password
			$query=mysqli_query($this->db,"UPDATE users SET password='$md5_newpassword' WHERE uid='$uid'") or die(mysqli_error($this->db));
			return true;
		 } else {
			 return false;
	  }
	  } else {
		  return false;
	  }
}
// Trend Hashtags
public function TrendHashTags() {
	$query = mysqli_query($this->db,"SELECT * FROM messages WHERE FROM_UNIXTIME(created) > (DATE_SUB(NOW(), INTERVAL 1 WEEK) AND FROM_UNIXTIME(created)) <= CURRENT_DATE AND hashTag != ''") or die(mysqli_error($this->db));	
	while($row = mysqli_fetch_assoc($query)) {
	 // RETURNS ONLY HASHTAG??
	 $data[] = $row['hashTag'];
    }
	 if(!empty($data)) {
		 return $data;
	 }
}
function timeAgo($time) {
$time = strtotime($time);
$cur_time   = time();
$time_elapsed   = $cur_time - $time;
$seconds    = $time_elapsed ;
$minutes    = round($time_elapsed / 60 );
$hours      = round($time_elapsed / 3600);
$days       = round($time_elapsed / 86400 );
$weeks      = round($time_elapsed / 604800);
$months     = round($time_elapsed / 2600640 );
$years      = round($time_elapsed / 31207680 );
// Seconds
if($seconds <= 60){
	return "just now";
}
//Minutes
else if($minutes <=60){
	if($minutes==1){
		return "one minute ago";
	}
	else{
		return "$minutes minutes ago";
	}
}
//Hours
else if($hours <=24){
	if($hours==1){
		return "an hour ago";
	}else{
		return "$hours hrs ago";
	}
}
//Days
else if($days <= 7){
	if($days==1){
		return "yesterday";
	}else{
		return "$days days ago";
	}
}
//Weeks
else if($weeks <= 4.3){
	if($weeks==1){
		return "a week ago";
	}else{
		return "$weeks weeks ago";
	}
}
//Months
else if($months <=12){
	if($months==1){
		return "a month ago";
	}else{
		return "$months months ago";
	}
}
//Years
else{
	if($years==1){
		return "one year ago";
	}else{
		return "$years years ago";
	}
}
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'yr',
        'm' => 'mo',
        'w' => 'wk',
        'd' => 'day',
        'h' => 'hr',
        'i' => 'min',
        's' => 'sec',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '\'s' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
// Admin 
//Total User
public function Users_CountM() {
    $query=mysqli_query($this->db,"SELECT uid FROM users")or die(mysqli_error($this->db));
       return mysqli_num_rows($query);
   }
//Registered Today
public function UserDaily(){
  $query = mysqli_query($this->db,"select count(*) as count_today
  from users
  where FROM_UNIXTIME(registered) >= curdate();
  ")or die(mysqli_error($this->db)); 
  $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
	if ($row) {
		//This is if user follower is not empty show how many follower
		return $row['count_today'];
		} 
		//If user not have follower then show 0
		else return 0;   
} 
// Registered Weekly
public function UserWeek(){
  $query = mysqli_query($this->db,"select count(*) as count_today
  from users
  where yearweek(FROM_UNIXTIME(registered)) = yearweek(curdate());
  ")or die(mysqli_error($this->db));
  $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
	if ($row) {
		//This is if user follower is not empty show how many follower
		return $row['count_today'];
		} 
		//If user not have follower then show 0
		else return 0;       
} 
// Registered Mounthly
public function UserMonth(){
  $query = mysqli_query($this->db,"select count(*) as count_today
  from users
  where year(FROM_UNIXTIME(registered)) = year(curdate())
       and month(FROM_UNIXTIME(registered)) = month(curdate());
  ")or die(mysqli_error($this->db));
  $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
	if ($row) {
		//This is if user follower is not empty show how many follower
		return $row['count_today'];
		} 
		//If user not have follower then show 0
		else return 0;    
} 
// Messages Posted Daily
public function messagesDaily(){
  $query = mysqli_query($this->db,"SELECT count(*) AS count_today FROM messages WHERE FROM_UNIXTIME(created) >= curdate();") or die(mysqli_error($this->db));
  $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
  if($row) {
	  return $row['count_today'];
  
   }else return 0;
}
// Messages Posted Weekly
public function messagesWeekly(){
  $query = mysqli_query($this->db,"select count(*) as count_today
  from messages
  where yearweek(FROM_UNIXTIME(created)) = yearweek(curdate());
  ")or die(mysqli_error($this->db));
  $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
	if ($row) {
		//This is if user follower is not empty show how many follower
		return $row['count_today'];
		} 
		//If user not have follower then show 0
		else return 0;       
} 
// Messages Posted Mounthly
public function MessagesMonth(){
  $query = mysqli_query($this->db,"select count(*) as count_today
  from messages
  where year(FROM_UNIXTIME(created)) = year(curdate())
       and month(FROM_UNIXTIME(created)) = month(curdate());
  ")or die(mysqli_error($this->db));
  $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
	if ($row) {
		//This is if user follower is not empty show how many follower
		return $row['count_today'];
		} 
		//If user not have follower then show 0
		else return 0;    
}
 //Updates Count
public function Messages_Count() {
   $query=mysqli_query($this->db,"SELECT msg_id FROM messages")or die(mysqli_error($this->db));
   return mysqli_num_rows($query);
} 

// Comments Posted Daily
public function commentsDaily(){
  $query = mysqli_query($this->db,"SELECT count(*) AS count_today FROM comments WHERE FROM_UNIXTIME(created) >= curdate();") or die(mysqli_error($this->db));
  $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
  if($row) {
	  return $row['count_today'];
  
   }else return 0;
}
// Comment Posted Weekly
public function commentsWeekly(){
  $query = mysqli_query($this->db,"select count(*) as count_today
  from comments
  where yearweek(FROM_UNIXTIME(created)) = yearweek(curdate());
  ")or die(mysqli_error($this->db));
  $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
	if ($row) {
		//This is if user follower is not empty show how many follower
		return $row['count_today'];
		} 
		//If user not have follower then show 0
		else return 0;       
} 
// Messages Posted Mounthly
public function CommentMonth(){
  $query = mysqli_query($this->db,"select count(*) as count_today
  from comments
  where year(FROM_UNIXTIME(created)) = year(curdate())
       and month(FROM_UNIXTIME(created)) = month(curdate());
  ")or die(mysqli_error($this->db));
  $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
	if ($row) {
		//This is if user follower is not empty show how many follower
		return $row['count_today'];
		} 
		//If user not have follower then show 0
		else return 0;    
}
 //Comment Count
public function Comment_Count() {
   $query=mysqli_query($this->db,"SELECT com_id FROM comments")or die(mysqli_error($this->db));
   return mysqli_num_rows($query);
}

/*Recent Users*/
public function Recent_Users()
{
   $query=mysqli_query($this->db,"SELECT uid,username,email,friend_count,registered,profile_img,conversation_count,updates_count,profile_img_status,name FROM users WHERE status='1' ORDER BY uid DESC LIMIT 4")or die(mysqli_error($this->db));
   while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
	   $data[]=$row;
	   }
	  if(!empty($data)) {
	// Store the result into array
	  return $data;
   } 			
}
// Report Post
public function Report_Post($uid,$msg_id,$report_type)  {
   $msg_id=mysqli_real_escape_string($this->db,$msg_id);
   $report_type=mysqli_real_escape_string($this->db,$report_type);
   $time=time();
   $ip=$_SERVER['REMOTE_ADDR'];
   $query = mysqli_query($this->db,"INSERT INTO `reported_post` (report_type, uid_fk,report_id,ip,created) VALUES('$report_type', '$uid','$msg_id', '$ip','$time')")or die(mysqli_error($this->db));
} 
// Report Post
public function Report_Comment($uid,$com_id,$report_type,$reportedUid)  {
   $com_id=mysqli_real_escape_string($this->db,$com_id);
   $report_type=mysqli_real_escape_string($this->db,$report_type);
   $time=time();
   $ip=$_SERVER['REMOTE_ADDR'];
   $query = mysqli_query($this->db,"INSERT INTO `reported_comment` (report_type, uid_fk,owner_uid,report_id,ip,created) VALUES('$report_type', '$uid','$reportedUid','$com_id', '$ip','$time')")or die(mysqli_error($this->db));
} 
// Report User
public function Report_User($uid,$rep_id,$reporteduser_type)  {
   $rep_id=mysqli_real_escape_string($this->db,$rep_id);
   $reporteduser_type=mysqli_real_escape_string($this->db,$reporteduser_type);
   $time=time();
   $ip=$_SERVER['REMOTE_ADDR'];
   $query = mysqli_query($this->db,"INSERT INTO `reportedUser` (reporteduser_type, reported_uid,reporter_uid,ip,created) VALUES('$reporteduser_type', '$uid','$rep_id', '$ip','$time')")or die(mysqli_error($this->db));
} 
/*Recent Complaints*/
public function Recent_Complaints_Details() {
	$query=mysqli_query($this->db,"SELECT R.r_id,R.report_id,R.report_type,R.uid_fk,U.username,U.name,U.uid FROM  reported_post R, users U WHERE U.uid=R.uid_fk ORDER BY r_id DESC LIMIT 4")or die(mysqli_error($this->db));
	 while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){
	  $data[]=$row;
	 }
	 if(!empty($data)){
		 return $data;
	 }
}
/*Reported Comment List*/
public function Recent_Complaints_Comment_Details() {
	$query=mysqli_query($this->db,"SELECT R.c_id,R.report_id,R.report_type,R.uid_fk,U.username,U.name,U.uid FROM  reported_comment R, users U WHERE U.uid=R.uid_fk ORDER BY c_id DESC LIMIT 4")or die(mysqli_error($this->db));
	 while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){
	  $data[]=$row;
	 }
	 if(!empty($data)){
		 return $data;
	 }
}

 /* Comments Details*/
    public function Comments_Details($com_id)
    {
	   $com_id=mysqli_real_escape_string($this->db,$com_id);
	   $query = mysqli_query($this->db,"SELECT comment FROM `comments` WHERE com_id='$com_id'") or die(mysqli_error($this->db));
       while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
	         $data[]=$row;
	    }
	     if(!empty($data)) {
	   // Store the result into array
	   return $data;
	 }
    }

/*Reported Comment List*/
public function Recent_Complaints_User_Details() {
	$query=mysqli_query($this->db,"SELECT R.rid,R.reported_uid,R.reporteduser_type,R.reporter_uid,U.username,U.name,U.uid FROM  reportedUser R, users U WHERE U.uid=R.reported_uid ORDER BY rid DESC LIMIT 4")or die(mysqli_error($this->db));
	 while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){
	  $data[]=$row;
	 }
	 if(!empty($data)){
		 return $data;
	 }
}
/* User Delete*/
    public function User_Delete($ruid)
    {
	$ruid=mysqli_real_escape_string($this->db,$ruid);

	if(strlen($ruid))
	{
	mysqli_query($this->db,"DELETE FROM user_uploads WHERE uid_fk='$ruid'")or die(mysqli_error($this->db));
	mysqli_query($this->db,"DELETE FROM friends WHERE friend_one='$ruid' OR friend_two='$ruid'")or die(mysqli_error($this->db));
	mysqli_query($this->db,"DELETE FROM reportedUser WHERE reporter_uid='$ruid'")or die(mysqli_error($this->db));
	mysqli_query($this->db,"DELETE FROM reported_comment WHERE owner_uid='$ruid'")or die(mysqli_error($this->db));
	mysqli_query($this->db,"DELETE FROM message_like WHERE uid_fk='$ruid'")or die(mysqli_error($this->db));
	mysqli_query($this->db,"DELETE FROM comments WHERE uid_fk='$ruid'")or die(mysqli_error($this->db));
	mysqli_query($this->db,"DELETE FROM messages WHERE uid_fk='$ruid'")or die(mysqli_error($this->db));
	mysqli_query($this->db,"DELETE FROM users WHERE uid='$ruid'")or die(mysqli_error($this->db));
	}
    }
 /* Latest Updates*/
public function LatestUpdates() {
   $query=mysqli_query($this->db,"SELECT M.msg_id,M.message,M.uploads,U.username,U.name,U.uid  FROM messages M, users U WHERE U.uid=M.uid_fk  ORDER BY msg_id DESC LIMIT 10")or die(mysqli_error($this->db));
   while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){
		 $data[]=$row;
   }
	   if(!empty($data)) {
	// Store the result into array
	  return $data;
   } 
}
 /* User Details*/
public function Users_admin_Details($lastUid) {
	$mq = '';
	if($lastUid) {
	  $mq = "and uid <'".$lastUid."'";
    }
   $query=mysqli_query($this->db,"SELECT uid,username,email,bio,fb,tw,yout,gp,ins,gender,u_website,location,friend_count,profile_img,updates_count,
   profile_img_status,name  FROM users WHERE uid $mq ORDER BY uid DESC LIMIT 6")or die(mysqli_error($this->db));
   while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
		 $data[]=$row;
		}
		if(!empty($data)) {
	// Store the result into array
	  return $data;
   } 
}
// Edit User
/* User Details*/
public function User_Details_Edit($uid) {
   $query=mysqli_query($this->db,"SELECT uid,tour,username,bio,email,friend_count,fb,role,tw,yout,ins,tel,gp,postHide,followingHide,followerHide,socialHide,phoneHide,profile_img,gender,u_website,location,conversation_count,updates_count,cover_img,cover_img_status,group_count,profile_img_status,profile_bg_position,verified,notification_created,photos_count,name FROM users WHERE uid='$uid'")or die(mysqli_error($this->db));
   $data=mysqli_fetch_array($query,MYSQLI_ASSOC);
      if(!empty($data)) {
	// Store the result into array
	  return $data;
   } 
}
// Delete Reported Post
public function DeleteReportedPost($rid){
    $rid=mysqli_real_escape_string($this->db,$rid);
    mysqli_query($this->db,"DELETE FROM reported_post WHERE report_id='$rid'")or die(mysqli_error($this->db));
	mysqli_query($this->db,"DELETE FROM message_like WHERE uid_fk='$rid'")or die(mysqli_error($this->db));
	mysqli_query($this->db,"DELETE FROM comments WHERE msg_id_fk='$rid'")or die(mysqli_error($this->db));
	mysqli_query($this->db,"DELETE FROM messages WHERE msg_id='$rid'")or die(mysqli_error($this->db));

}
// Delete Reported Comment
public function DeleteReportedComment($rcid){
    $rcid=mysqli_real_escape_string($this->db,$rcid);
    mysqli_query($this->db,"DELETE FROM reported_comment WHERE report_id='$rcid'")or die(mysqli_error($this->db));
	mysqli_query($this->db,"DELETE FROM comments WHERE com_id='$rcid'")or die(mysqli_error($this->db));

}
/*User Uploaded Image Count*/
public function PostCount($uid) {
	$uid = mysqli_real_escape_string($this->db,$uid);
	//Calculate how many Image user uploads
	$q = mysqli_query($this->db,"SELECT COUNT(*) AS messaceCount FROM messages WHERE uid_fk = '$uid'")or die(mysqli_error($this->db));
	$row = mysqli_fetch_array($q,MYSQLI_ASSOC);
	if ($row) {
		//If user have uploaded image then show how many image indicate this user
		return $row['messaceCount'];
		} 
		// If user not have upladed image then show 0
		else return 0;
}
/*Slide Delete*/
public function DeleteSlide($sliderId){
	$sliderId = mysqli_real_escape_string($this->db, $sliderId);
	if(strlen($sliderId)) {
	   mysqli_query($this->db,"DELETE FROM MainSlider WHERE slideID='$sliderId'")or die(mysqli_error($this->db));
	}
	return true;
}
 /* Updates Details*/
    public function Posts_Details()
    {
	   
       $query=mysqli_query($this->db,"SELECT M.msg_id,M.message,M.like_count,M.uploads,U.username,U.name,U.uid  FROM messages M, users U WHERE U.uid=M.uid_fk  ORDER BY msg_id DESC LIMIT " .$this->perpage)or die(mysqli_error($this->db));
       while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
	         $data[]=$row;
	   }
	       if(!empty($data)) {
	    // Store the result into array
	      return $data;
	   } 
    }
	public function LatestPostMainAdmin(){
	  $query=mysqli_query($this->db,"SELECT M.msg_id,M.message,M.like_count,M.uploads,U.username,U.name,U.uid  FROM messages M, users U WHERE U.uid=M.uid_fk  ORDER BY msg_id DESC LIMIT 10")or die(mysqli_error($this->db));
       while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
	         $data[]=$row;
	   }
	       if(!empty($data)) {
	    // Store the result into array
	      return $data;
	   } 
    }
	/* Updates Details*/
    public function MorePost($LastPostId)
    {
	   if($LastPostId) {
		$LastPostId = "AND M.msg_id <'".$LastPostId."'";	
	 }
       $query=mysqli_query($this->db,"SELECT M.msg_id,M.message,M.like_count,M.uploads,U.username,U.name,U.uid  FROM messages M, users U WHERE U.uid=M.uid_fk $LastPostId  ORDER BY msg_id DESC LIMIT " .$this->perpage)or die(mysqli_error($this->db));
       while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
	         $data[]=$row;
	   }
	       if(!empty($data)) {
	    // Store the result into array
	      return $data;
	   } 
    }

	/* User Delete*/
    public function Message_Delete($msg_id)
    {
	   $msg_id=mysqli_real_escape_string($this->db,$msg_id);
       if(strlen($msg_id)) {
          $query=mysqli_query($this->db,"SELECT com_id  FROM comments WHERE msg_id_fk='$msg_id'")or die(mysqli_error($this->db));
          while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
	            $cid=$row['com_id'];
	            mysqli_query($this->db,"DELETE FROM comment_like WHERE com_id_fk='$cid'")or die(mysqli_error($this->db));
	   }
    mysqli_query($this->db,"DELETE FROM reported_post WHERE report_id='$msg_id'")or die(mysqli_error($this->db));
	mysqli_query($this->db,"DELETE FROM message_like WHERE uid_fk='$msg_id'")or die(mysqli_error($this->db));
	mysqli_query($this->db,"DELETE FROM comments WHERE msg_id_fk='$msg_id'")or die(mysqli_error($this->db));
	mysqli_query($this->db,"DELETE FROM messages WHERE msg_id='$msg_id'")or die(mysqli_error($this->db));

	}
	return $query;
    }
}
?>