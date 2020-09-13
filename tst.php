<?php
$data = "123ksjdlsjdlksjdlk_String";    
$whatIWant = substr($data, strpos($data, "_") + 1);    
$whatIWant = strpos($data, "_")+1;    


$arr = explode("_", $data);
echo $arr[0];
?>