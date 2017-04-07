<?php
ob_start("ob_gzhandler");
session_start();
error_reporting(0);
error_reporting(E_ALL  & ~E_DEPRECATED);
ini_set('display_errors', -1);
include_once 'dbCon.php'; // Database connection
include_once 'functions.php'; // Functions
include_once 'textlink.php'; // Text link
include_once 'tolink.php'; // Text link
include 'nameFilter.php'; // Name filter
include_once 'htmlcode.php'; // html code 
include 'Mat_Expand.php';  // Link Embed
//include 'language.php';
$Mat = new UPDATES($db); 
include_once 'session.php'; // session
$session_data=$Mat->User_Details($uid);
$session_uid=$session_data['uid'];
$session_username=$session_data['username'];
$sessionGender=$session_data['gender'];
$sessionWeb=$session_data['u_website'];
$session_bio = $session_data['bio'];
$sessionfb = $session_data['fb'];
$sessionTw =$session_data['tw'];
$sessionYoutube = $session_data['yout'];
$sessionInstagram = $session_data['ins'];
$sessionGooglePlus = $session_data['gp'];
$sessionTelepHoneNumber =$session_data['tel'];
$sessionLocation = $session_data['location'];
$sessionPostHideCheck = $session_data['postHide'];
$sessionPhoneHideCheck = $session_data['phoneHide'];
$sessionSocialHideCheck = $session_data['socialHide'];
$sessionFollowerHideCheck = $session_data['followerHide'];
$sessionFollowingHideCheck = $session_data['followingHide'];
$sessionEmail = $session_data['email'];
$LoginRole = $session_data['role'];
$session_face=$Mat->User_MiniProfilepic($uid,$base_url);
$session_cover=$Mat->User_Cover($uid,$base_url);
$session_notification_created=$session_data['notification_created'];
$notifications_count=$Mat->Notifications_Count($uid,$session_notification_created);
$url404=$base_url.'404.php';
$index_url=$base_url.'dashboard.php';
//Admin
$Users_Count=$Mat->Users_CountM();
$DaiLy = $Mat->UserDaily();
$WeekLy = $Mat->UserWeek();
$MounthLy = $Mat->UserMonth();
$MDaily = $Mat->messagesDaily();
$MWeekly = $Mat->messagesWeekly();
$MMounthLy = $Mat->MessagesMonth();
$MCnt = $Mat->Messages_Count();
$CDaily = $Mat->commentsDaily();
$CWekkly = $Mat->commentsWeekly();
$CMounthly = $Mat->CommentMonth();
$CCount = $Mat->Comment_Count();
$sessionConfiguration = $Mat->getConfigurations();
$WebsiteName = $sessionConfiguration['applicationName'];
$WebsiteDesc = $sessionConfiguration['applicationDesc'];
$WebsiteLogoHeader = $sessionConfiguration['applicationLogoHeader'];
?>