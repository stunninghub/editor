<?php
session_start();
include "db.php";

$file_id = $_REQUEST['file_id'];
$sql = "SELECT * FROM `files` WHERE file_id = '$file_id'";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result);

//echo show_source($row['file_address']);
echo $row['file_address'];
?>