<?php 
$User = new USER($db);
$scrDet = $User->getConfigurations();
$scrLogo = $scrDet['applicationLogo'];
$appName = $scrDet['applicationName'];
//Login
$login_error='';
if($_POST['username'] && $_POST['passcode'] ) {
   $username=$_POST['username'];
   $password=$_POST['passcode'];
   if (strlen($username)>0 && strlen($password)>0) {
      $login=$User->User_Login($username,$password);
   if($login) {
      $_SESSION['uid']=$login;
      header("Location:index.php");
   } else {
     $login_error="<div class='wrong'>".$LANG['iuop']."</div>";
   }
   }
}
//Registration
$reg_error='';
if($_POST['email'] && $_POST['username'] && $_POST['password'] && $_POST['name']) {
   $email=$_POST['email'];
   $username=$_POST['username'];
   $password=$_POST['password'];
   $name=$_POST['name'];
   $username_check = preg_match('~^[A-Za-z0-9_]{3,20}$~i', $username);
   $emain_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
   $password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);
   if (strlen($username)>0 && strlen($password)>0 && strlen($email) && strlen($name) && $emain_check>0 && $username_check>0 && $password_check>0) {
      $reg=$User->User_Registration($username,$password,$email,$name);
   if($reg) {
      $_SESSION['uid']=$reg;
      header("Location:index.php");
   } else {
    $reg_error="<span class='error'>".$LANG['uoeiae']."</span>";
   }
   } else {
     $reg_error="<span class='error'>".$LANG['gveuap']."</span>";
   }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<title><?php echo $appName;?></title>
<link rel="stylesheet" type="text/css" href="css/lgxrg.css" />
<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/loginCheck.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/aLrF.js"></script>

</head>

<body>
<!--Main Container STARTED-->
<div class="ChWrP">
   <!--Left Sidebar STARTED-->
   <div class="app-one">
      <!-- Swiper -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
        
          <?php 
		     $GetSlider = $User->GetSlider();
			 foreach($GetSlider as $data){
				 $slideTitle= $data['slideTitle'];
				 $slideDesc= $data['slideDesc'];
				 $slideImage= $data['slideImage'];
				 echo '<div class="swiper-slide">
                         <img src="images/'.$slideImage.'" />  
						 <div class="slideTitle">
						   <div class="title">'.$slideTitle.'</div>
						   <div class="info">'.$slideDesc.'</div>
						 </div>  
                       </div>';
			 }
		  ?>
        
        
          
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <!-- Swiper JS -->
   </div>
   <!--Left Sidebar FINISHED-->
   <!--Right Sidebar STARTED-->
   <div class="app-two">
      <?php include("requests/login.php");?>
   </div>
   <!--Right Sidebar FINISHED-->
</div>
<!--Main Container FINISHED-->
<!-- Swiper JS -->
    <script src="js/swiper.js"></script>

    <!-- Initialize Swiper -->
    <script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        paginationClickable: true,
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: 5500,
        autoplayDisableOnInteraction: false
    });
    </script>
</body>
</html>
