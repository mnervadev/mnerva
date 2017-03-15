<?php
session_start();
include('dbCon.php'); 
if(isset($_SESSION['uid'])){
		$uid = $_SESSION['uid'];
}

if(isset($_FILES["FileInput"]) && $_FILES["FileInput"]["error"]== UPLOAD_ERR_OK)
{
	$UploadDirectory	= 'uploads/'; 
	
	if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		die();
	}
	
	if ($_FILES["FileInput"]["size"] > 5242880) {
		die("File size is too big!");
	}
		
	switch(strtolower($_FILES['FileInput']['type']))
		{
			case 'image/png': 
			case 'image/gif': 
			case 'image/jpeg': 
			case 'image/pjpeg':
			case 'text/plain':
			case 'text/html': 
			case 'application/x-zip-compressed':
			case 'application/pdf':
			case 'application/msword':
			case 'application/vnd.ms-excel':
			case 'video/mp4':
				break;
			default:
				die('Unsupported File!'); 
				}
	
	$File_Name          = strtolower($_FILES['FileInput']['name']);
	$File_Ext           = substr($File_Name, strrpos($File_Name, '.'));
	
	//$Random_Number      = rand(0, 9999999999);
	$Random_Number=uniqid();
	$NewFileName 		= $Random_Number.$File_Ext;
	$pth=$UploadDirectory.$NewFileName;
	if(move_uploaded_file($_FILES['FileInput']['tmp_name'], $UploadDirectory.$NewFileName ))
	   {
		  $res= mysqli_query($db,"UPDATE users SET profile_img ='$pth' where uid = '$uid'") or die(mysqli_error());
		  
		  if($res)
		  {
		//die('Success! File Uploaded.');
		die($UploadDirectory.$NewFileName);
		}
		else
		{
		die(mysqli_error());
		}
	}else{
		die('error uploading File!');
	}
	
	}
else
{
	die('Something wrong with upload! Is "upload_max_filesize" set correctly?');
}