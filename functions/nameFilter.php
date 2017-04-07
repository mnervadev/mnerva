<?php
function nameFilter($name,$number) {
  if($name) {
	 $str_length = strlen($name);
  if($str_length > $number) {
	 $name= substr($name, 0, $number) . "..." ;
	}
    return ucfirst($name);
    }
}
?>