<?php
session_start();
include "db.php";

$file_id = $_REQUEST['file_id'];

$sql = "SELECT * FROM files WHERE file_id = '$file_id'";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result);

$sql_delete = "DELETE FROM files WHERE file_id = '$file_id'";

if(mysqli_query($con,$sql_delete)){
	if(!unlink($row['file_address'])){
		echo "File not deleted";
	}else{
		echo "File deleted";
	}
}

?>