<?php
session_start();
if(!empty($_SESSION['username'])){
	?>
		<script type="text/javascript">
			document.location = "editor.php";
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
</head>
<body>
	<div class="container">
		<br>
		<h1>CODE EDITOR</h1>
		<br>
		<div class="card form">
			<div class="card-header">
				<h4>Login</h4>
			</div>
			<div class="card-body">
				<label>Username</label>
				<input type="username" name="username" id="username" class="form-control">
				<br>
				<label>Password</label>
				<input type="password" name="password" id="password" class="form-control">
				<div class="alerts">
				</div>
				<br>
				<button class="btn btn-success" onclick="login();">Login</button>
				<span class="float-right mt-2">Don't have account <a href="createaccount.php">Create now</a>.</span>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		function login(){
			var req = new XMLHttpRequest;
			req.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					if(this.responseText == "ok"){
						document.location = "editor.php";
					}else{
						alert(this.responseText);
					}
				}
			}
			req.open("post","login_process.php?username="+$("#username").val()+"&password="+$("#password").val(),false);
			req.send();
		}
	</script>
</body>
</html>