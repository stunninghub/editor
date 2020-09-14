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
			echo "<div class='list-group-item list-group-item-action'  style='cursor:pointer;background:var(--BGcolor);'><div class='btn' style='background:#f16529;color:#fff;' onclick='open_file(`".$row['file_id']."`);file_name_display(`".$row['file_name'].".".$row['file_type']."`);'>".$row['file_name'].".".$row['file_type']."</div><div style='font-size:30px;margin-top:-10px;color:var(--text);' class='btn rounded-circle float-right' onclick='return confirm(`Are you sure ?`)?delete_file(`".$row['file_id']."`):``;'>&times;</div></div>";
		}elseif ($row['file_type'] == "css") {
			echo "<div class='list-group-item list-group-item-action'  style='cursor:pointer;background:var(--BGcolor);'><div class='btn' style='background:#2965f1;color:#fff;' onclick='open_file(`".$row['file_id']."`);file_name_display(`".$row['file_name'].".".$row['file_type']."`);'>".$row['file_name'].".".$row['file_type']."</div><div style='font-size:30px;margin-top:-10px;color:var(--text);' class='btn rounded-circle float-right' onclick='return confirm(`Are you sure ?`)?delete_file(`".$row['file_id']."`):``;'>&times;</div></div>";
		}elseif ($row['file_type'] == "js") {
			echo "<div class='list-group-item list-group-item-action'  style='cursor:pointer;background:var(--BGcolor);'><div class='btn' style='background:#f0db4f;color:#333;' onclick='open_file(`".$row['file_id']."`);file_name_display(`".$row['file_name'].".".$row['file_type']."`);'>".$row['file_name'].".".$row['file_type']."</div><div style='font-size:30px;margin-top:-10px;color:var(--text);' class='btn rounded-circle float-right' onclick='return confirm(`Are you sure ?`)?delete_file(`".$row['file_id']."`):``;'>&times;</div></div>";
		}
	}
}
?>