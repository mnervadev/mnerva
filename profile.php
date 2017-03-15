<?php 
include('incl/header.php'); 
if(isset($_SESSION['uid'])){
		$uid = $_SESSION['uid'];
}
if(isset($_POST['edit-data'])){
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $bio = $_POST['bio'];
    $website = $_POST['Website'];
    
    $sql = "update users set name = '$fullname', email = '$email', bio = '$bio', Website = '$website' where uid = '$uid' ";
    $result = mysqli_query($db,$sql);
    
    $sql = "select username from users where username = '$username'";
    $result = mysqli_query($db,$sql);
    if(mysqli_num_rows($result) > 0){
            $f_msg = 'This username is not available';
        }else{
            $sql = "Update users set username = '$username' where uid = '$uid' ";
            $result = mysqli_query($db,$sql);
    }
}

if(isset($_POST['pass-update'])){
    $old = $_POST['old'];
    $new = $_POST['new'];
    $confirm = $_POST['confirm'];
    
    $sql = "select password from users where password = '$old' ";
    $result = mysqli_query($db,$sql);
    if(mysqli_num_rows($result) > 0 ){
        if($new = $confirm ){
            $sql = "Update users set password = '$new' where uid = '$uid' ";
            $result = mysqli_query($db,$sql);
        }else{
            $fconfirm_pass = 'New password and confirm don`t match';
        }
    }else{
        $fpass_msg = 'Old password is not correct';
    }
}
if(isset($_POST['btn-upload'])){
define ("MAX_SIZE","5000"); // 2MB MAX file size
function getExtension($str)
{
$i = strrpos($str,".");
if (!$i) { return ""; }
$l = strlen($str) - $i;
$ext = substr($str,$i+1,$l);
return $ext;
}
// Valid image formats 
$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") 
{
$uploaddir = "uploads/"; //Image upload directory
foreach ($_FILES['photos']['name'] as $name => $value)
{
$filename = stripslashes($_FILES['photos']['name'][$name]);
$size=filesize($_FILES['photos']['tmp_name'][$name]);
//Convert extension into a lower case format
$ext = getExtension($filename);
$ext = strtolower($ext);
//File extension check
if(in_array($ext,$valid_formats))
{
//File size check
if ($size < (MAX_SIZE*1024))
{ 
$image_name=time().$filename; 
$newname=$uploaddir.$image_name; 
//Moving file to uploads folder
if (move_uploaded_file($_FILES['photos']['tmp_name'][$name], $newname)) 
{ 
$time=time(); 
//Insert upload image files names into user_uploads table
mysqli_query($db,"UPDATE users SET profile_img ='$image_name' where uid = '$uid'");
}

}


} 

} //foreach end

} 
}



 /*$file = rand(1000,100000)."-".$_FILES['file']['name'];
 $file_loc = $_FILES['file']['tmp_name'];
 $file_size = $_FILES['file']['size'];
 $file_type = $_FILES['file']['type'];
 $folder="uploads/";
 
 // new file size in KB
 $new_size = $file_size/1024;  
 // new file size in KB
 
 // make file name in lower case
 $new_file_name = strtolower($file);
 // make file name in lower case
 
 $final_file=str_replace(' ','-',$new_file_name);
     if(move_uploaded_file($file_loc,$folder.$final_file)){
         $db->query("UPDATE users SET profile_img ='$final_file' where uid = '$uid'");
     }
}*/


        if(isset($_GET['remove'])){
            $sql = "update users set profile_img = '' where uid = '$uid' ";
            $result = mysqli_query($db,$sql);
            if(!$result){
                echo'<script>window.location.href = "http://mnerva.online/profile.php";</script>';
            }else{
                echo'<script>window.location.href = "http://mnerva.online/profile.php";</script>';
            }
        }
?>
<style type="text/css">
input[type=file] {
	padding: 6px;
	background: #FFF;
	border-radius: 5px;
}
#submit-btn {
	border: none;
	padding: 10px;
	background: #61BAE4;
	border-radius: 5px;
	color: #FFF;
}
#output{
	padding: 5px;
	font-size: 12px;
}

/* prograss bar */
#progressbox {
	border: 1px solid #4885ED;
	padding: 1px; 
	position:relative;
	width:92%;
	border-radius: 3px;
	margin: 10px;
	display:none;
	text-align:left;
}
#progressbar {
	height:5px;
	border-radius: 3px;
	background-color: #4885ED;
	width:1%;
}
</style>
<div class="main-content" >
    <div class="main-content_tab-panels">

          <div class="panel panel-home active">
<div class="profile-header">
    <center>
        <div class="profile-details">
        <div class="block">
            <table class="profile-detail">
                <tbody>
                    <tr>
                        <?php
                $sql = "select * from users where uid = '$uid' ";
                $result = mysqli_query($db,$sql);
                if(mysqli_num_rows($result)){
                    while($row = $result->fetch_assoc()){
                ?>
                        <td>
                            <?php
                            if($row['profile_img'] == ''){
                                echo'<img src="images/user.png" alt="Profile image" onclick="profile_img();" width="105" height="105" />';
                            }else{
                                echo'<img id="pfImage" src="';
                                echo$row['profile_img']; 
                                echo'" alt="Profile image" onclick="profile_img();" width="105" height="105" />';
                            }
                            ?>
                            
                        </td>
                        <td>
                            
            <h3 style="display:inline-block">
                <?php echo$row['username']; ?>
            </h3>
            <div>
                
            <p style="font-weight:600;font-size: 24px;">
                <?php echo$row['name']; ?>
            </p>
            <p>
                <?php echo$row['bio']; ?>
            </p>
            <p>
                <a href="<?php echo$row['website']; ?>" target="blank" style="text-decoration:underlin; color:#4885ED">
                <?php echo$row['website']; ?>
                </a>
            </p>
            <?php
                    }
                }
            ?>
            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="block">
           <center>
                <div class="part">
                <ul class="stats">
                <li>
                    <h3>
                      <?php
                      $sql = "SELECT COUNT(*) AS posts FROM ebooks WHERE userID = '$uid'";
                      $query = mysqli_query($db, $sql);
                      if (mysqli_num_rows($query) > 0){
                          $row = mysqli_fetch_object($query);
                      echo $row->posts;
                      }else{
                          echo'0';
                      }
                      ?>
                    </h3>
                    <p>
                        posts
                    </p>
                </li>
                <li onclick="followers_list();" style="Cursor:pointer">
                    <h3>
                      <?php
                      $sql = "SELECT COUNT(*) AS followers FROM follow WHERE following = '$uid'";
                      $query = mysqli_query($db, $sql);
                      if (mysqli_num_rows($query) > 0){
                          $row = mysqli_fetch_object($query);
                      echo $row->followers;
                      }else{
                          echo'0';
                      }
                      ?>
                    </h3>
                    <p>
                        followers
                    </p>
                </li>
                <li onclick="following_list();" style="Cursor:pointer">
                    <h3>
                      <?php
                      $sql = "SELECT COUNT(*) AS following FROM follow WHERE follower = '$uid'";
                      $query = mysqli_query($db, $sql);
                      if (mysqli_num_rows($query) > 0){
                          $row = mysqli_fetch_object($query);
                      echo $row->following;
                      }else{
                          echo'0';
                      }
                      ?>
                    </h3>
                    <p>
                        following
                    </p>
                </li>
            </ul>
            </div>
            <div class="part">
                <div class="edit-btn">
                    <p onclick="edit_profile();" style="display:inline-block;margin:0px">
                        Edit Profile
                    </p>
                    <a class="btn-content" onclick="profile_menu();" >
                        <i class="fa fa-sort-desc" aria-hidden="true"></i>
                    </a>
                    <ul class="profile-menu" id="profile-menu">
                        <li>
                            <a href="/logout.php">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                            Log-out
                            </a>
                        </li>
                    </ul>
                    <center>
                        <div id="edit-profile">
            <form class="edit-profile" method="POST" style="margin-bottom: -20px;border-bottom: 0px;" >
                <?php
                $sql = "select * from users where uid = '$uid'";
                $result = mysqli_query($db,$sql);
                if(mysqli_num_rows($result)> 0){
                    while($row = $result->fetch_assoc()){
                ?>
            <div class="row edit">
                <input type="text" name="fullname" placeholder="Name" value="<?php echo$row['name']; ?>" />
            </div>
            <div class="row edit">
                <input type="text" name="username" placeholder="Username" value="<?php echo$row['username']; ?>" />
            </div>
            <div class="row edit">
                <input type="email" name="email" placeholder="Email" value="<?php echo$row['email']; ?>" />
            </div>
            <div class="row edit">
                <input type="text" name='bio' placeholder="Bio" value="<?php echo$row['bio']; ?>" />
            </div>
            <div class="row edit">
                <input type="text" name='Website' placeholder="Website" value="<?php if($row['website'] == ''){echo'http://';}else{echo$row['website'];}}} ?>" />
            </div>
            <button type="submit" name="edit-data" >
                Submit
            </button>
        </form>
        <br />
        <form class="edit-profile" method="POST">
            <div class="row edit">
                <input type="password" name="old" autocomplete="false" placeholder="Old password" />
            </div>
            <div class="row edit">
                <input type="password" name="new" autocomplete="false" placeholder="New password" />
            </div>
            <div class="row edit">
                <input type="password" name="confirm" autocomplete="false" placeholder="Confirm Password" />
            </div>
            <button type="submit" name="pass-update" >
                Change
            </button>
        </form>
		</div>
                    </center>
                </div>
            </div>
           </center>
        </div>
        </div>
    </center>
</div>
<center>
    <div class="profile-data" >
    <div class="grid-list_row-container" id="profile-data">
       <?php
                    $trend = "SELECT * FROM ebooks where userID = '$uid' ";
			        $trenddata = mysqli_query($db,$trend);
                    while($trend=mysqli_fetch_assoc($trenddata)){ 
				   ?>
                  <div class="grid-list_row--item">
				    <a>
                    <div class="book-card_container canvas2" data-cover="<?php echo explode('/',$trend['upload_file_name'])[1];?>">
                      <p class="book-card_link" style="width:100%"><?php echo $trend['title'];?></p>
                      <div class="book-card-mini-list">
                          <p title="Username of uploader" style="width:100%;display:block">
                               <?php echo $trend['user']; ?>
                          </p>
                          <p title="Notes" style="display:inline-block" >
                              <i class="fa fa-globe" aria-hidden="true"></i>
                              <?php
                              if($trend['notes'] >0){
                                  echo $trend['notes'];
                              }else{
                                  echo'0';
                              }
                               ?>
                          </p>
                          <p title="Upload date" style="display:inline-block">
                              •
                               3 months ago
                          </p>
                      </div>
                      
                    </div>
					</a>
				  </div>
               <?php } ?>
    </div>
    </center>
</div>




    
    
    
        
        
    </div>







</div></div></div>
<div class="overlay" id="profile-image" style="display:none">
    <ul class="profile-upload-menu">
        <li>
            <a href="profile.php?remove">
                Remove Current Photo
            </a>
        </li>
        <li>
            <form action="processupload.php" method="post" enctype="multipart/form-data" id="MyUploadForm">
                <ul class="uploader">
                    <li style="width:100%">
                        <div class="fileUpload" style="margin:17px;margin-bottom:-10px">
    <span id="file-path">Choose Photo</span>
    <input name="FileInput" id="FileInput" type="file" onchange="theimage();" class="upload" />
</div>
<div id="progressbox" ><div id="progressbar"></div ></div>
<div id="output">

</div>
                    </li>
                </ul>
            </form>
        </li>
        <li style="border-bottom:none">
            <a href="#" onclick="cancel_profile();">
                Cancel
            </a>
        </li>
    </ul>
</div>

<div class="overlay" id="followers-list" style="display:none" >
    <ul class="follow-list">
        <li style="padding:15px; font-weight:bold" >
            Followers <a onclick="followers_list_close();" href="#" style="float:right;font-size:20px;line-height: initial;font-weight:normal;color: rgba(0, 0, 0, 0.26);"><i class="fa fa-close"></i></a>
        </li>
        <?php
        $sql = "select * from users right join follow on uid = follower where following = '$uid'";
             $result = mysqli_query($db,$sql);
             if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <li>
            <table>
                <tbody>
                    <tr>
                        <td>
                            <?php
                            if($row['profile_img'] == ''){
                                echo'<img src="images/user.png" alt="Profile image"  />';
                            }else{
                                echo'<img src="uploads/';
                                echo$row['profile_img']; 
                                echo'" alt="Profile image"  />';
                            }
                            ?>
                        </td>
                        <td style="width:70%">
                            <p style="font-weight:bold">
                                 <?php echo$row['username']; ?>
                            </p>
                            <p>
                                <?php echo$row['name']; ?>
                            </p>
                        </td>
                        <td>
                            <a href="#" class="btn-follow">
                Follow
            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </li>
        <?php } } ?>
    </ul>
</div>

<div class="overlay" id="following-list" style="display:none" >
    <ul class="follow-list">
        <li style="padding:15px; font-weight:bold" >
            Following <a onclick="following_list_close();" href="#" style="float:right;font-size:20px;line-height: initial;font-weight:normal;color: rgba(0, 0, 0, 0.26);"><i class="fa fa-close"></i></a>
        </li>
        <?php
        $sql = "select * from users right join follow on uid = following where follower = '$uid'";
             $result = mysqli_query($db,$sql);
             if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <li>
            <table>
                <tbody>
                    <tr>
                        <td>
                            <?php
                            if($row['profile_img'] == ''){
                                echo'<img src="images/user.png" alt="Profile image"  />';
                            }else{
                                echo'<img src="uploads/';
                                echo$row['profile_img']; 
                                echo'" alt="Profile image"  />';
                            }
                            ?>
                        </td>
                        <td style="width:70%">
                            <p style="font-weight:bold">
                                 <?php echo$row['username']; ?>
                            </p>
                            <p>
                                <?php echo$row['name']; ?>
                            </p>
                        </td>
                        <td>
                            <a href="#" class="btn-follow">
                           Follow
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </li>
        <?php } } ?>
    </ul>
</div>

<script>
    function cancel_profile(){
        document.getElementById('profile-image').style.display = "none";
    }
    function profile_img(){
        document.getElementById('profile-image').style.display = "block";
    }
    function followers_list(){
        document.getElementById('followers-list').style.display = "block";
    }
    function followers_list_close(){
        document.getElementById('followers-list').style.display = "none";
    }
    function following_list(){
        document.getElementById('following-list').style.display = "block";
    }
    function following_list_close(){
        document.getElementById('following-list').style.display = "none";
    }
</script>

<script>
    function theimage(){
 var filename = document.getElementById('photoimg').value;
 document.getElementById('file-path').innerHTML  = filename;
}
</script>
<script>
    function profile_menu(){
    var x = document.getElementById('profile-menu');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
    }
}
   function edit_profile(){
    var x = document.getElementById('edit-profile');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
    }
}
</script>
<script type="text/javascript" src="ajaxupload/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="ajaxupload/js/jquery.form.min.js"></script>
<script type="text/javascript">

jQuery(document).ready(function() { 

var options = { 
			target:   '#output', 
			beforeSubmit:  beforeSubmit,
			success:       afterSuccess,
			uploadProgress: OnProgress, 
			resetForm: true       
		}; 

jQuery('#FileInput').change(function() { 

	                //alert("file");
		        jQuery('#MyUploadForm').ajaxSubmit(options);  			
			
			return false; 
		});
		
		function afterSuccess(data)
{
document.getElementById('profile-image').style.display = "none";
	jQuery('#submit-btn').show(); 
	jQuery('#loading-img').hide(); 
	jQuery('#progressbox').delay( 1000 ).fadeOut();
	
	var src=jQuery("#output").html();
	//alert(src);
	jQuery("#pfImage").attr("src", src);
	
}

function beforeSubmit(){
//alert('before');
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		if( !jQuery('#FileInput').val()) 
		{
			jQuery("#output").html("Are you kidding me?");
			return false
		}
		
		var fsize = jQuery('#FileInput')[0].files[0].size; 
		var ftype = jQuery('#FileInput')[0].files[0].type;
		

		switch(ftype)
        {
            case 'image/png': 
			case 'image/gif': 
			case 'image/jpeg': 
			case 'image/pjpeg':
			case 'image/png':
			case 'image/bmp':
			case 'image/gif':
                break;
            default:
                jQuery("#output").html("Unsupported file type!");
				return false
        }
		
		if(fsize>5242880) 
		{
			jQuery("#output").html("Too big file! Max 5 MB");
			return false
		}
				
		jQuery('#submit-btn').hide();
		jQuery('#loading-img').hide();
		jQuery("#output").html("");  
	}
	else
	{
		
		jQuery("#output").html("Please upgrade your browser");
		return false;
	}
}


function OnProgress(event, position, total, percentComplete)
{
    
	jQuery('#progressbox').show();
    jQuery('#progressbar').width(percentComplete + '%') 
    jQuery('#statustxt').html(percentComplete + '%'); 
    if(percentComplete>50)
        {
            jQuery('#statustxt').css('color','#000'); 
        }
}

function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}


			
}); 
		


</script>

<?php include('incl/footer.php'); ?>