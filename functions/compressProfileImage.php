<?php
//Compress Image
function compressProfileImage($ext, $uploadedfile, $profile_image_path, $actual_image_name, $newwidth,$prefix) {
if($ext=="jpg" || $ext=="jpeg" || $ext=="JPG") {
	// Check the image extencion
	// If image extension is jpg then create upload file
   $src = imagecreatefromjpeg($uploadedfile);
 } else if($ext=="png") {
	 // If iamge extension is png then create upload file
     $src = imagecreatefrompng($uploadedfile);
 } else if($ext=="gif") {
	 // If image extension is gif then create upload file
	 $src = imagecreatefromgif($uploadedfile);
 } else {
     $src = imagecreatefrombmp($uploadedfile);
 }
  list($width,$height)=getimagesize($uploadedfile);
  $newheight=($height/$width)*$newwidth;
  // New image with and height
  $tmp=imagecreatetruecolor($newwidth,$newheight);
  imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
  // The uploaded image name with prefix like user_1234323.jpg
  $filename = $profile_image_path.$prefix.'_'.$actual_image_name;
  imagejpeg($tmp,$filename);
  imagedestroy($tmp);
  // This is the new file 
  return $filename;
}
?>
