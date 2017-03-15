<?php
session_start();
ob_start("ob_gzhandler");

error_reporting(0);


include_once 'functions/dbCon.php';

function insert($table,$row=array(),$values=array()){
	global $db;
	  $a=implode(",",$row);
	  $a='('.$a.')';
	  foreach($values as &$value)
	  {
	  mysqli_real_escape_string($conn,$value);
	  $value="'".$value."'";

	  }
	  $b=implode(",",$values);
	  $b='('.$b.')';
	  $query="INSERT INTO ".$table." ".$a." VALUES".$b;

	  $result = mysqli_query($db,$query);
	 if($result)
	 return true;
	}

if(!isset($_POST['q']))
{die();
}

else{
  if(isset($_SESSION['uid'])){

  $data=json_decode($_POST['q'],true);


  $title=$data['title'];
  $desc=$data['descText'];
  $tags=$data['tags'];
  $message=$data['message'];
  $share=$data['shareFb'];
  $show_comments=$data['showComments'];
  $allow_comments=$data['allowComments'];
  $category=$data['category'];
  $file=$_POST['file'];
  echo $file;
  $fields=array("userID","title","cover","content","the_date","upload_file_name");
  $values=array($_SESSION['uid'],$title,"",$desc,date('Y-m-d H:i:s', time()),$file);
  insert("ebooks",$fields,$values);


}

else{

  echo "login";

}
}
 ?>
