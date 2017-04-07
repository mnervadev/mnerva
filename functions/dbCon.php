<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'mnerva_arsal');
define('DB_PASSWORD', 'mnerva_arsal01');
define('DB_DATABASE', 'mnerva_ca');
$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
mysqli_query ($db,"set character_set_results='utf8'");
$base_url='http://mnerva.ca/';
$upload_path = "uploads/logo/";  // Updates images path
$path = 'uploads/';
$sliderPath = 'images/';
$profile_image_path = "uploads/profile/";
$admin_path = $upload_path;
$admin_base_url=$base_url.'admin/';
$uploadPrefix='upload/';// Image prefix name
/*SMTP Details */
$smtpUsername='SMTP Username'; //yourname@gmail.com
$smtpPassword='SMTP Passwor';  //gmail password
$smtpHost='SMTP Host'; //tls://smtp.gmail.com
$smtpPort='SMTP Port'; //465
$smtpFrom='SMTP From Email'; //yourname@gmail.com
?>