<?php
require 'lib/facebook.php';
require 'lib/fbconfig.php';
$button=0;
$user = $facebook->getUser();
$currentUrl = siteUrl;
if ($user)
 {
 $logoutUrl = $facebook->getLogoutUrl();
	 try{
 		$userdata=$facebook->api('/me?fields=email,name,gender,link,about,age_range,education');
 	 }
	 catch (FacebookApiException $e){
		error_log($e);
		$user = null;
	 }
		$_SESSION['facebook']=$_SESSION;
		$_SESSION['userdata'] = $userdata;
		$_SESSION['logout'] =  $logoutUrl;
	}else{ 
		$loginUrl = $facebook->getLoginUrl(array(
			'scope'		=> 'email,public_profile', // Permissions to request from the user
		));
		$button=1;
	}
 ?>
