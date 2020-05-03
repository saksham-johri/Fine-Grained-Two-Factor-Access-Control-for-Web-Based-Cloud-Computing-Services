<?php
include('connection.php');
require_once 'googleLib/GoogleAuthenticator.php';

if(empty($_SESSION['user_id']))
{
	header("Location: " . $APP_URL . 'login');
	die();
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>2-Step Google Authenticator</title>
		<link rel="stylesheet" type="text/css" href="css/app_style.css" charset="utf-8" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div id="container">
			<center><h1>2<sup>nd</sup> Step Verification Required</h1></center>
			<div id='device'>
			<form id="LI-form">
			<input type="hidden" id="process_name" name="process_name" value="verify_code" />
				<div class="form-group">
				<table class="table" style="width:80%; margin-left:10%;">
					<tr><td align="right"><a href="logout.php" class="btn btn-xs btn-danger" ><b>Back to Login Page</b></a></td></tr>
					<tr><td align="center"><label for="email">Place your code here:</label><input autocomplete="off" type="text" name="scan_code" class="form-control" id="scan_code" required /></td></tr>
				  </div>
					<tr><td align="center"><input type="submit" class="btn btn-success btn-submit" value="Verify Code"/></td></tr>
				</table>
			</form>
			</div>
		</div>
		
	<script src="js/jquery.validate.min.js"></script>

	<script>
		$(document).ready(function(){
			$(document).on('submit', '#LI-form', function(ev){
				if($("#LI-form").valid() == true){
					var data = $("#LI-form").serialize();
					$.post('check_user.php', data, function(data,status){
						if( data == "done"){
							window.location = 'dashboard';
						}
						else{
							alert("Invalid Code");
						}
					});
				}
			});
		});
	</script>
	</body>
</html>
