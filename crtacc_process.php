<?php
session_start();

include "db.php";

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];


$sql_select = "SELECT * FROM `users` WHERE uname = '$username'";
$result = mysqli_query($con, $sql_select);
$row_num = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);

if($row_num <= 0){
	$sql_insert = "INSERT INTO `users` (`u_id`,`uname`,`pass`,`dark_mode`,`up_date`) VALUES('','$username','$password','','')";
	if(mysqli_query($con,$sql_insert)){
		if(mkdir($username)){
			$_SESSION['username']= $username;
			$_SESSION['dark_mode']= $row['dark_mode'];
			echo "ok";
		}else{
			echo "Directory error";
		}
	}else{
		echo "SQL Error";
	}
}else{
	echo "Sorry this username is already exist.";
}

?>