<?php
$profile_uid=$Mat->User_ID($username); // check profile uid
$check_user=$Mat->User_ID($username); // Check user
$UserDetails=$Mat->User_Details($profile_uid); // User id
$profileUsername = $UserDetails['username'];
$profilebio = $UserDetails['bio'];
$uGender = $UserDetails['gender'];
$website = $UserDetails['u_website'];
$uLoc = $UserDetails['location'];
$facebo = $UserDetails['fb'];
$twTo = $UserDetails['tw'];
$youto = $UserDetails['yout'];
$insto = $UserDetails['ins'];
$gpo = $UserDetails['gp'];
$sessionPostHideCheckProfile = $UserDetails['postHide'];
$miniprofileface=$Mat->User_MiniProfilepic($profile_uid,$base_url); // User profile image
$UserCover=$Mat->User_Cover($profile_uid,$base_url); // User profile image
$ufollowercount=$Mat->Follower_Count($profile_uid,$base_url);
$uifollowingcount=$Mat->Following_Count($profile_uid,$base_url);
$PostCountUser = $Mat->PostCount($profile_uid,$base_url);
$session_update_count=$UserDetails['updates_count']; // User update count
?>