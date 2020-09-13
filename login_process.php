<?php
session_start();

include "db.php";

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];


$sql_select = "SELECT * FROM `users` WHERE uname = '$username' and pass='$password'";
$result = mysqli_query($con, $sql_select);
$row_num = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);

if($row_num <= 0){
	echo "Sorry i can't find this username.";
}else{

	$_SESSION['username']= $row['uname'];
	echo "ok";
}

?>