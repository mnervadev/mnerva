<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>How to convert PDF to JPEG in PHP | PGPGang.com</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <style type="text/css">

      img {border-width: 0}
      * {font-family:'Lucida Grande', sans-serif;}
    </style>
  </head>
  <body>

      <h2>How1 to convert PDF to JPEG in PHP Example.&nbsp;&nbsp;&nbsp;=> <a href="http://www.phpgang.com/">Home</a> | <a href="http://demo.phpgang.com/">More Demos</a></h2>
<?php 


if(isset($_GET['id']) && $_GET['id'] != ''){
     echo $id = $_GET['id'];
}
    
}
$response = array();
exec('whoami', $response);
print_r($response,true);

$message = "";
$display = "";
if($_FILES)
{
    $output_dir = "uploads/";
    ini_set("display_errors",1);
    if(isset($_FILES["myfile"]))
    {
        $RandomNum   = time();

        $ImageName      = str_replace(' ','-',strtolower($_FILES['myfile']['name']));
        $ImageType      = $_FILES['myfile']['type']; //"image/png", image/jpeg etc.

        $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
        $ImageExt       = str_replace('.','',$ImageExt);
        if($ImageExt != "pdf")
        {
            $message = "Invalid file format only <b>\"PDF\"</b> allowed.";
        }
        else
        {
            $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
            $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;

            move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir. $NewImageName);

            $location   = "images";
            $name       = $output_dir. $NewImageName;
            $num = count_pages($name);
            $RandomNum   = time();
            $nameto     = $output_dir.$RandomNum.".jpg";
            $convert    = $location . " " . $name . " ".$nameto;
            exec($convert);
            for($i = 0; $i<$num;$i++)
            {
                $display .= "<img src='$output_dir$RandomNum-$i.jpg' title='Page-$i' /><br>";
            }
            $message = "PDF converted to JPEG sucessfully!!";
        }
    }
}
function count_pages($pdfname) {
      $pdftext = file_get_contents($pdfname);
      $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
      return $num;
    }
$content = $message.'<br />'.$display.'<br><form enctype="multipart/form-data" action="" method="post">
 Please choose a file: <input name="myfile" type="file" /><br />
 <input type="submit" value="Upload" />
 </form>';


echo $content;
?>
</body>
</html>z
