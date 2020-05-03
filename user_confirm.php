<?php
include('connection.php');
require_once 'googleLib/GoogleAuthenticator.php';
$gauth = new GoogleAuthenticator();

if(empty($_SESSION['user_id']) || empty($_SESSION['gauth']))
{
	header("Location: " . $APP_URL . 'login');
	die();
}

$user_id = $_SESSION['user_id'];
$user_result = mysqli_query($conn,"select * from tbl_users where user_id='$user_id'") or die(mysqli_error($conn));
$user_row = mysqli_fetch_array($user_result);

$secret_key	= $user_row['google_auth_code'];
$email		= $user_row['email'];

$google_QR_Code = $gauth->getQRCodeGoogleUrl($email, $secret_key,'EVOLVE');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>2-Step Google Authenticator</title>
		<link rel="stylesheet" type="text/css" href="css/app_style.css" charset="utf-8" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<style>
			.app{
				width:150px;
			}
		</style>
	</head>
	<body>
		<div id="container">
			<center><h1>2<sup>nd</sup> Step Verification Registration</h1></center>
			<table class="table" style="width:80%; margin-left:10%;">
			<div id='device'>
			<tr><td align="right"><a href="logout.php" class="btn btn-xs btn-danger" ><b>Back to Login Page</b></a></td></tr>
			<tr><td align="center">
			<div id="img"><img src='<?php echo $google_QR_Code; ?>' /></div></br>
			<p>Scan with <b>Google Authenticator</b> application on your smart phone.</p>
			</td></tr>
			<tr><td align="center">
			<form id="LI-form">
			<input type="hidden" id="process_name" name="process_name" value="verify_code" />
				<div class="form-group">
					<label for="email">Place generated code here:</label>
					<input autocomplete="off" type="text" name="scan_code" class="form-control" id="scan_code" required />
				  </div>
				  </td></tr>
				  <tr><td align="center"><input type="submit" class="btn btn-success btn-submit" value="Verify Code"/></td></tr>
			</form>
			</div>
			<tr><td align="center">
			<div style="text-align:center">
				<h6>Download Google Authenticator <br/> application using this link(s),</h6>
			<a href="https://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8" target="_blank"><img class='app' src="img/iphone.png" /></a>

			<a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank"><img class="app" src="img/android.png" /></a>
			</div>
			</td></tr>
			</table>
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