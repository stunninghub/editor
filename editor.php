<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Code Editor</title>
</head>
<body>
	<h1><?php echo $_SESSION['username'];?></h1>
	<div class="user_files">
		
	</div>
	<textarea id="code_field" rows="10" placeholder="Code"></textarea>
	<button onclick="run_code();">Run</button>
	<iframe class="op_container" id="op_container"></iframe>
	<a href="logout.php">Sign Out</a>
	<script type="text/javascript">
		function run_code(){
			var code_field = document.getElementById("code_field");
			var op_container = document.getElementById("op_container").contentWindow.document;

			//document.body.onkeyup = function() {
	        op_container.open();
	        op_container.writeln(code_field.value);
	        op_container.close();
	      //};
		}
	</script>
</body>
</html>