<?php
session_start();
include "db.php";
$dark_mode = $_REQUEST['dark_mode'];

$sql = "UPDATE `users` SET `dark_mode`='$dark_mode' WHERE uname= '".$_SESSION['username']."'";
if(mysqli_query($con,$sql)){
	$_SESSION['dark_mode']= $dark_mode;
	if($dark_mode == "dark"){
		echo "Dark mode on";
	}else{
		echo "Light mode on";
	}
}else{
	echo "No effect";
}
?>