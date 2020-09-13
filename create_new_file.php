<?php
session_start();
include "db.php";

$date=date("Y-m-d H:i:s");
$n=10; 
function getName($n) { 
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $randomString = ''; 
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 
  
    return $randomString; 
}
$u_id=strtolower(getName($n));


$fname = $_REQUEST['new_file_name'];

$name_array = explode(".",$fname);
$new_file_name = $name_array[0];
$new_file_type = strtolower($name_array[1]);

$sql_insert_file_name = "INSERT INTO `files` (`file_id`,`file_owner`,`file_name`,`file_address`,`file_type`) VALUES ('".$_SESSION['username']."_$new_file_name"."_$u_id','".$_SESSION['username']."','$new_file_name','".$_SESSION['username']."/$new_file_name".".$new_file_type','$new_file_type')";

if(mysqli_query($con,$sql_insert_file_name)){
	if(fopen($_SESSION['username']."/".$new_file_name.".".$new_file_type, "w")){
		echo "ok";
	}else{
		echo"File creation failed";
	}
}else{
	echo "SQL Error";
}

?>