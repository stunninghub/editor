<?php
session_start();

include "db.php";

$sql = "SELECT * FROM `files` WHERE file_owner = '".$_SESSION['username']."' ORDER BY file_name";
$result = mysqli_query($con,$sql);

if(mysqli_num_rows($result) <= 0 ){
	?>
	<div class="text-center">Empty</div>

	<?php
}else{
	while ( $row = mysqli_fetch_array($result)) {
		if($row['file_type'] == "html"){
			echo "<div class='list-group-item list-group-item-action' onclick='open_file(`".$row['file_id']."`);file_name_display(`".$row['file_name'].".".$row['file_type']."`);' style='cursor:pointer;'>".$row['file_name'].".".$row['file_type']."</div>";
		}elseif ($row['file_type'] == "css") {
			echo "<div class='list-group-item list-group-item-action' onclick='open_file(`".$row['file_id']."`);file_name_display(`".$row['file_name'].".".$row['file_type']."`);' style='cursor:pointer;'>".$row['file_name'].".".$row['file_type']."</div>";
		}elseif ($row['file_type'] == "js") {
			echo "<div class='list-group-item list-group-item-action' onclick='open_file(`".$row['file_id']."`);file_name_display(`".$row['file_name'].".".$row['file_type']."`);' style='cursor:pointer;'>".$row['file_name'].".".$row['file_type']."</div>";
		}
	}
}
?>