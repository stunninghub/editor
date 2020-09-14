<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Code Editor</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<style type="text/css">
		.user_files{
			width:200px;
			height: 200px;
		}
		.alert_div{
			width:150px;
			position: fixed;
			color:#fff;
			border-radius:5px;
			bottom:-300px;
			left:30px;
			padding:15px;
			background:#444;
			text-align:center;
			z-index: 9999;
		}
	</style>
</head>
<body>
	<div class="alert_div">Alert</div>
	<br>
	<div class="container">
	<h1>Hello <?php echo ucfirst(strtolower($_SESSION['username']));?> !</h1>
	<button class="btn btn-warning" onclick="run_project();">Run</button>
	<button class="btn btn-primary" data-target="#new_file" data-toggle="modal">New File</button>
	<button class="btn btn-success save_btn" onclick="save_file();">Save</button>
	<button class="btn btn-danger float-right" onclick="document.location = 'logout.php'">Sign Out</button>
	<br><br>
	<div class="row">
		<div class="col-4">
			<div class="user_files card" style="width: 100%;height:300px;">
				<div class="card-header pb-1">
					<h5>Files</h5>
				</div>
				<div class="card-body files_container" style="overflow-y: scroll;">
				</div>
			</div>
		</div>
		<div class="col-8">
			<div class="user_files card" style="width: 100%;height:300px;">
				<div class="card-header pb-1 bg-warning">
					<h5 class="file_name_display">File name</h5>
				</div>
				<div class="card-body p-0">
					<textarea style="width: 100%;height:100%;outline:none; border:0px;" id="code_field" placeholder="Code" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="off" class="form-control"></textarea>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="new_file">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Create new file</h3>
			</div>
			<div class="modal-body">
				<label>File name :</label>
				<input type="text" autocomplete="off" name="new_file_name" id="new_file_name" class="form-control" >
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger" data-target="#new_file" data-toggle="modal">Cancel</button>
				<button class="btn btn-success" onclick="create_new_file();">Create</button>
			</div>
		</div>
	</div>
</div>
	<script type="text/javascript">
		function run_project(){
			window.open("<?php echo $_SESSION['username'];?>/");
		}
		var open_file_id = "";

		window.onload = function(){
			fetch_files();
			if(open_file_id == "" || open_file_id == null){
				$(".save_btn").attr("disabled",'disabled');
			}
		}
		$(document).bind("keyup keydown", function(e){
		    if(e.ctrlKey && e.which == 83){
		    	e.preventDefault();
		    	if(open_file_id != ""){
			        save_file();
			    }
		    }
		});
		$("#code_field").bind("keyup keydown", function(){
			$(document).bind("keyup keydown", function(e){
				if(!(e.ctrlKey && e.which == 83)){
					$('.save_btn').attr('disabled',false);
				}
			});
		});
		function open_file(file_id){
			open_file_id = file_id;
			var req = new XMLHttpRequest;
			req.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					$.ajax({
					   url : this.responseText,
					   dataType: "text",
					   success : function (data) {
					       $("#code_field").val(data);
					   }
					});
				}
			}
			req.open("post","open_file.php?file_id="+file_id,false);
			req.send();
		}
		var alert_div_time = "";
		function alert_div(alert){
			clearTimeout(alert_div_time);
			$(".alert_div").html(alert);
			$(".alert_div").animate({'bottom':'40px'},600);
			alert_div_time = setTimeout(function(){
				$(".alert_div").animate({'bottom':'-300px'},600);
			},3500);
		}
		function file_name_display(name){
			$(".file_name_display").html(name);
		}
		function save_file(){
			var data = new FormData();
			data.append("file_id",open_file_id);
			data.append("file_context",$("#code_field").val());
			var req = new XMLHttpRequest;
			req.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					alert_div(this.responseText);
					fetch_files();
					$(".save_btn").attr("disabled",'disabled');
				}
			}
			req.open("post","save_file.php",true);
			req.send(data);
		}
		function fetch_files(){
			var req = new XMLHttpRequest;
			req.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					$(".files_container").html(this.responseText);
				}
			}
			req.open("post","fetch_files.php",false);
			req.send();
		}

		function create_new_file(){
			var req = new XMLHttpRequest;
			req.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					if(this.responseText == "ok"){
						$("#new_file_name").val("");
						$('#new_file').modal('toggle');	
						fetch_files();
					}else{
						alert_div(this.responseText);
					}
				}
			}
			req.open("post","create_new_file.php?new_file_name="+$("#new_file_name").val(),false);
			req.send();
		}

		function delete_file(file_id){
			var req = new XMLHttpRequest;
			req.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					$("#code_field").val("");
					fetch_files();
					alert_div(this.responseText);
				}
			}
			req.open("post","delete_file.php?file_id="+file_id,false);
			req.send();
		}
	</script>
</body>
</html>