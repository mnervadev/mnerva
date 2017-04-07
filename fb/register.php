<?php ob_start("ob_gzhandler");
	session_start(); 
	
	
	$name='';
	$lastname='';
	$dob='';
	$email='';
	$gender='';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: Sponacts ::</title>

</head>

<body>


<div id="innerWrapper">
			<h2 class="page_Heading">New Member, Sign Up here.</h2>
				<div id="steps"><img src="images/steps_08.png" /></div>
				<div id="formLeft">
					<?php 
						include("fblogin.php");
						
					?>
					<?php if($button==1){ echo '<a href="'.$loginUrl.'"><img src="../images/Sign_up.png" title="Login with Facebook" /></a>'; } ?>
					<a href="javascript:void(0);" onclick="activelogin()">Already a member? Sign In »</a>
				</div>
				<div id="formCenter">
					or
				</div>
                                <?php  
                                      if(isset($_SESSION['userdata'])){
									  print_r($userdata);
					 $name= $userdata['first_name'];
					 $lastname= $userdata['last_name']; 
					 $email= $userdata['email']; 
					}
                                 ?>
 				<form id="regFrom" method="post" enctype="multipart/form-data" action="processpage.php">
						<div id="et_contact_left">
							<p class="clearfix">
								<label class="et_contact_form_label" for="et_contact_name">Name</label>
								<input type="text" class="input" id="et_contact_name" value="<?php echo $name; ?>" placeholder="First Name" name="name" style="width:31%;" required>
								<input type="text" class="input" id="et_contact_name" value="<?php echo $lastname; ?>" placeholder="Last Name" name="lname" style="width:32%; margin-left:1%;" required>
							</p>

							<p class="clearfix">
								<label class="et_contact_form_label" for="et_contact_email">Username</label>
								<input type="text" class="input" id="username"  placeholder="Username" name="username" required>
							</p>
							
							
						
							<p class="clearfix">
								<label class="et_contact_form_label" for="et_contact_email">Email</label>
								<input type="email" class="input" id="email" value="<?php echo $email; ?>"  placeholder="Email Address" name="email" required>
							</p>
							
						   
						    <p class="clearfix">
								<label class="et_contact_form_label" for="et_contact_subject">Phone</label>
								<input type="text" class="input" id="phone" name="phone"   placeholder="Phone No.">
							</p>  
							<p class="clearfix">
									<label class="et_contact_form_label" for="et_contact_subject" style="display:inline-block;">Profile Pic</label>
									<input name="proflephoto" type="file" />
							</p>
						  
						</div> <!-- #et_contact_left -->


						<div class="clear"></div>
							

						<input type="hidden" value="regUser" name="action">

						<input type="reset" value="Reset" id="et_contact_reset">
						<input type="submit" id="et_contact_submit" value="Submit" class="et_contact_submit"> <ul id="cordinate">
			<li><input type="hidden" name="cordinates" data-geo="location"/></li>
			<li><input type="hidden" name="State" data-geo="State"/></li>
			
		  </ul>

	</form>
	
	
    <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
    
    <script src="js/jquery.geocomplete.js"></script>
    
    <script>
      $(function(){
        $("#geocomplete").geocomplete({
          details: "form#regFrom ul#cordinate",
          detailsAttribute: "data-geo"
        });
        
        $("#find").click(function(){
          $("#geocomplete").trigger("geocode");
        });
      });
    </script>
						
						<div id="clr">	</div>
</div>

<?php unset($_SESSION); ?>

</body>
</html>