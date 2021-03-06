<?php
session_start();
if(empty($_SESSION['username'])){
	?>
		<script type="text/javascript">
			document.location = "login.php";
		</script>
	<?php
}
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
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Overpass+Mono&display=swap" rel="stylesheet">
	<style type="text/css">
		<?php
		if($_SESSION['dark_mode']=="dark"){
			echo "
			:root{
				--BGcolor:#333;
				--anctcolor:#222;
				--text:#fff;
			}
			";
		}elseif($_SESSION['dark_mode']=="light"){
			echo "
			:root{
				--BGcolor:#f3f3f3;
				--anctcolor:#eee;
				--text:#333;
			}
			";
		}else{
			echo "
			:root{
				--BGcolor:#f3f3f3;
				--anctcolor:#eee;
				--text:#333;
			}
			";
		}
		?>
		::-webkit-scrollbar {
			width: 6px;
			appearance:none;
		}
		::-webkit-scrollbar-track {
			background: transparent;
			appearance:none;
		}
		::-webkit-scrollbar-thumb {
			background: rgba(100,100,100,0.4);
			border-radius: 50px;
		}
		.user_files{
			width:200px;
			height: 200px;
		}
		.alert_div{
			width:200px;
			position: fixed;
			color:var(--anctcolor);
			border-radius:5px;
			bottom:-100px;
			left:10px;
			padding:15px;
			background:var(--text);
			z-index: 9999;
			white-space: pre-wrap;
			word-wrap: break-word;
		}
		@media screen and (max-width:400px){
			.nav_buttons{
				display: none;
			}
			.desk_nav{
				display: none;
			}
			.desk_file_container{
				display: none;
			}
		}
		@media screen and (min-width:400px){
			.mob_nav{
				display: none;
			}
			.mob_bottom_btn{
				display: none;
			}
		}
	</style>
</head>
<body style="background: var(--BGcolor);color:var(--text);">
	<div class="alert_div">Alert</div>
	<nav class="navbar mob_nav navbar-expand-md bg-light navbar-light sticky-top">
	  <!-- Brand -->
	  <a class="navbar-brand" href="#"><?php echo ucfirst(strtolower($_SESSION['username']));?></a>

	  <!-- Toggler/collapsibe Button -->
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <!-- Navbar links -->
	  <div class="collapse navbar-collapse" id="collapsibleNavbar">
	    <ul class="navbar-nav files_container mt-3">
	    </ul>
	  </div>
	</nav>
	<br>
	<div class="container">
	<h3 class="desk_nav">Hello <?php echo ucfirst(strtolower($_SESSION['username']));?> !</h3>
	<div class="nav_buttons">
		<button class="btn btn-primary" data-target="#new_file" data-toggle="modal">New File</button>
		<button class="btn btn-success save_btn" onclick="save_file();">Save</button>
		<button class="btn btn-warning" onclick="run_project();">Run</button>
		<div class="btn material-icons" onclick="dark_light_mode();" style="background:var(--anctcolor);color:var(--text);">
			brightness_medium
		</div>
		<button class="btn btn-danger float-right" onclick="document.location = 'logout.php'">Sign Out</button>
	<br>
	<br>
	</div>
	<div class="row">
		<div class="col-4 desk_file_container">
			<div class="user_files card" style="width: 100%;height:400px;background: var(--anctcolor);">
				<div class="card-header pb-1">
					<h5>Files</h5>
				</div>
				<div class="card-body files_container" style="overflow-y: scroll;border:0px;">
				</div>
			</div>
		</div>
		<div class="col">
			<div class="user_files card" style="width: 100%;height:400px;background: var(--anctcolor);">
				<div class="card-header pb-1 bg-warning">
					<h5 class="file_name_display text-dark">File name</h5>
				</div>
				<div class="card-body p-0" style="overflow-y:scroll;background:var(--BGcolor);">
					<textarea style="width:	100%;height:100vh;outline:none; border:0px;background:var(--anctcolor);color:var(--text);font-family: 'Overpass Mono', monospace;" id="code_field" placeholder="Code" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="off" class="form-control"></textarea>
				</div>
			</div>
		</div>
	</div>
</div>
<br>

<div class="dropup mob_bottom_btn" style="position:fixed;z-index: 99;bottom:10px;right:10px;">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"></button>
    <div class="dropdown-menu">
    	<button class="dropdown-item btn btn-warning" onclick="run_project();">Run</button>
		<button class="dropdown-item btn btn-primary" onclick="toggle_modal();">New File</button>
		<button class="dropdown-item btn btn-success save_btn" onclick="save_file();">Save</button>
		<button class="dropdown-item btn btn-danger float-right" onclick="document.location = 'logout.php'">Sign Out</button>
    </div>
 </div>

<div class="modal" id="new_file">
	<div class="modal-dialog">
		<div class="modal-content" style="background: var(--BGcolor);">
			<div class="modal-header" style="border:0px;">
				<h3>Create new file</h3>
			</div>
			<div class="modal-body">
				<label>File name :</label>
				<input type="text" autocomplete="off" name="new_file_name" id="new_file_name" class="form-control" autofocus=""style="background: var(--anctcolor);border:0px;color:var(--text);" placeholder="text here ...">
			</div>
			<div class="modal-footer" style="border:0px;">
				<button class="btn btn-success" onclick="create_new_file();">Create</button>
				<button class="btn btn-danger" data-target="#new_file" data-toggle="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
	<script type="text/javascript">
		function run_project(){
			window.open("<?php echo $_SESSION['username'];?>/");
		}
		var open_file_id = "";
		var five_save_status = "";
		window.onbeforeunload = function(e) { return "Save your work otherwise your work will be lost."; };
		window.onload = function(){
			fetch_files();
			if(open_file_id == "" || open_file_id == null){
				$(".save_btn").attr("disabled",'disabled');
			}
		}

		function dark_light_mode(){
			var CssRoot = getComputedStyle(document.body);
			var BGcolor = CssRoot.getPropertyValue('--BGcolor');

			if(BGcolor == "#f3f3f3"){
				document.documentElement.style.setProperty('--BGcolor', '#333');
				document.documentElement.style.setProperty('--anctcolor', '#222');
				document.documentElement.style.setProperty('--text', '#fff');
				update_dark_mode("dark");
			}else{
				document.documentElement.style.setProperty('--BGcolor', '#f3f3f3');
				document.documentElement.style.setProperty('--anctcolor', '#eee');
				document.documentElement.style.setProperty('--text', '#333');
				update_dark_mode("light");
			}
		}
		function toggle_modal(){
			if($('#new_file').modal('toggle')){
				setTimeout(function(){
					document.getElementById('new_file_name').focus();
				},200);
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
		$("#code_field").bind("keydown", function(){
			$('.save_btn').attr('disabled',false);
			five_save_status = "unsaved";
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
			$(".alert_div").animate({'bottom':'10px','opacity':'1'},300);
			alert_div_time = setTimeout(function(){
				$(".alert_div").animate({'bottom':'-100px','opacity':'0'},300);
			},3500);
		}
		function file_name_display(name){
			$(".file_name_display").html(name);
		}
		function save_file(){
			if(five_save_status == "unsaved"){
				var data = new FormData();
				data.append("file_id",open_file_id);
				data.append("file_context",$("#code_field").val());
				var req = new XMLHttpRequest;
				req.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						alert_div(this.responseText);
						fetch_files();
						$(".save_btn").attr("disabled",'disabled');
						five_save_status = "saved";
					}
				}
				req.open("post","save_file.php",true);
				req.send(data);
			}
		}
		function update_dark_mode(dark_mode){
			var req = new XMLHttpRequest;
			req.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					alert_div(this.responseText);
				}
			}
			req.open("post","update_dark_mode.php?dark_mode="+dark_mode,false);
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