<?php
session_start();

include "db.php";

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];


$sql_select = "SELECT * FROM `users` WHERE uname = '$username'";
$result = mysqli_query($con, $sql_select);
$row_num = mysqli_num_rows($result);

if($row_num <= 0){
	$sql_insert = "INSERT INTO `users` (`u_id`,`uname`,`pass`,`up_date`) VALUES('','$username','$password','')";
	if(mysqli_query($con,$sql_insert)){
		if(mkdir($username)){
			echo "ok";
			$_SESSION['username']= $username;
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