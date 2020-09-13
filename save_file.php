<?php
session_start();

include "db.php";

$file_id = $_REQUEST['file_id'];
$file_context = $_REQUEST['file_context'];

$sql = "SELECT * FROM `files` WHERE file_id = '$file_id'";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result);

$myfile = fopen($row['file_address'], "w") or die("Unable to open file!");
if(fwrite($myfile, $file_context)){
	echo "File saved";
}else{
	echo "Failed to save";
}
fclose($myfile);

?>