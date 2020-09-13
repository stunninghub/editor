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
	</style>
</head>
<body>
	<br>
	<div class="container">
	<h1>Hello <?php echo ucfirst(strtolower($_SESSION['username']));?> !</h1>
	<button class="btn btn-warning" onclick="run_code();">Run</button>
	<button class="btn btn-primary" data-target="#new_file" data-toggle="modal">New File</button>
	<button class="btn btn-success">Save</button>
	<button class="btn btn-danger float-right" onclick="document.location = 'logout.php'">Sign Out</button>
	<br><br>
	<div class="row">
		<div class="col">
			<div class="user_files card" style="width: 100%;height:300px;">
				<div class="card-header py-1">
					<h5>Files</h5>
				</div>
				<div class="card-body files_container" style="overflow-y: scroll;">
				</div>
			</div>
		</div>
		<div class="col">
			<div class="user_files card" style="width: 100%;height:300px;">
				<div class="card-header py-1 bg-warning">
					<h5>index.html</h5>
				</div>
				<div class="card-body p-0">
					<textarea style="width: 100%;height:100%;outline:none; border:0px;" id="code_field" placeholder="Code" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="off"></textarea>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="user_files card" style="width: 100%;height:300px;">
				<div class="card-header py-1 bg-success text-light">
					<h5>Output</h5>
				</div>
				<div class="card-body p-0">
					<iframe style="width: 100%;height:100%;" class="op_container card" id="op_container">
					</iframe>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="new_file">
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
				<button class="btn btn-success" onclick="create_new_file();">Create</button>
			</div>
		</div>
	</div>
</div>
	<script type="text/javascript">
		/*if($("#code_field").val() == ""){
			$('#code_field').attr("disabled","disabled");
		}*/
		var open_file_id = "";

		window.onload = function(){
			fetch_files();
		}

		function open_file(file_id){
			var req = new XMLHttpRequest;
			req.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					$.ajax({
					   url : this.responseText,
					   dataType: "text",
					   success : function (data) {
					       $("#code_field").text(data);
					   }
					});
				}
			}
			req.open("post","open_file.php?file_id="+file_id,false);
			req.send();
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
		function run_code(){
			var code_field = document.getElementById("code_field");
			var op_container = document.getElementById("op_container").contentWindow.document;

			//document.body.onkeyup = function() {
	        op_container.open();
	        op_container.writeln(code_field.value);
	        op_container.close();
	      //};
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
						alert(this.responseText);
					}
				}
			}
			req.open("post","create_new_file.php?new_file_name="+$("#new_file_name").val(),false);
			req.send();
		}


	</script>
</body>
</html>