<?php
	include("connection.php");
	if(empty($_SESSION['user_id']))
	{
		header("Location: " . $APP_URL . 'login');
		die();
	}elseif(empty($_SESSION['googleVerifyCode'])){
		header("Location: " . $APP_URL . 'user_login_confirm');
		die();
	}
	
	$user_id = $_SESSION['user_id'];
	$user_result = mysqli_query($conn,"select * from tbl_users where user_id='$user_id'") or die(mysqli_error($conn));
	$user_row = mysqli_fetch_array($user_result);
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>EVOLVE - Profile</title>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="css/dashboard-style.css" type="text/css" media="all" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<style>
		#ok,#error{
			display: none;
		}
		</style>
	</head>
	<body>
		<!-- Header -->
		<div id="header">
			<div class="shell">
				<!-- Logo + Top Nav -->
				<div id="top">
					<h1><a href="dashboard">-- EVOLVE --</a></h1>
					<div id="top-navigation"> Welcome <a href="profile"><strong><?php echo ucfirst($user_row['profile_name']); ?></strong></a> <span>|</span> <a href="#">Help</a> <span>|</span> <a href="profile">Profile Settings</a> <span>|</span> <a href="logout.php">Log out</a> </div>
				</div>
				<!-- End Logo + Top Nav -->
				<!-- Main Nav -->
				<div id="navigation">
					<ul>
						<li><a href="dashboard#dashboard"><span>Dashboard</span></a></li>
						<li><a href="dashboard#upload"><span>Upload</span></a></li>
						<li><a href="profile" class="active"><span>Profile Settings</span></a></li>
					</ul>
				</div>
				<!-- End Main Nav -->
			</div>
		</div>
		<!-- End Header -->
		<!-- Container -->
		<div id="container">
			<div class="shell" id="dashboard">
				<!-- Message OK -->
				<div class="msg msg-ok" id="ok">
					<p><strong>Request completed successfully !</strong></p>
					<a class="close" onclick="close()">close</a> 
				</div>
				<!-- End Message OK -->
				<!-- Message Error -->
				<div class="msg msg-error" id="error">
					<p><strong>Error in completing your Request !</strong></p>
					<a class="close" onclick="close()">close</a> 
				</div>
				<!-- End Message Error -->
				<br />
				<!-- Main -->
				<div id="main">
					<div class="cl">&nbsp;</div>
					<!-- Content -->
					<div id="content">
						<!-- Box -->
						<div class="box" id="upload">
							<!-- Box Head -->
							<div class="box-head">
								<h2>Change Password</h2>
							</div>
							<!-- End Box Head -->
							<!-- Form -->
							<form method="post" id="changepswd">
								<div class="form">
									<input type="hidden" name="process_name" value="change-password" />
									<p> <span class="req">* Required</span>
										<label>Current Password <span></span></label>
										<input required name="old_password" type="password" class="field size1" />
									</p>
									<p> <span class="req">* Required</span>
										<label>New Password <span></span></label>
										<input required type="password" name="new_password" class="newpw field size1" />
									</p><p> <span class="req">* Required</span>
										<label>Retype Password <span>(Should be same as above)</span></label>
										<input required type="password" class="newpw field size1" />
									</p>
								</div>
								<div class="buttons">
									<input type="submit" class="button" value="Change Password">
								</div>
							</form>
							<!-- End Form -->
						</div>
						<!-- End Box -->
						
						<!-- Box -->
						<div class="box" id="upload">
							<!-- Box Head -->
							<div class="box-head">
								<h2>2 Factor Authentication</h2>
							</div>
							<!-- End Box Head -->
							<!-- Form -->
							<form method="post" id="LI-form">
								<div class="form">
									<input type="hidden" id="process_name" name="process_name" value="verify_code" />
									<input type="hidden" id="process_name" name="new_reg" value="true" />
									<p> <span class="req">* Required</span>
										<label>Place Code Here <span>(TOTP is required to Authenticate from registered device)</span></label>
										<input autocomplete="off" required name="scan_code" type="text" class="field size1" />
									</p>
								</div>
								<div class="buttons">
									<input type="submit" class="button" value="Verify Code & Register">
								</div>
							</form>
							<!-- End Form -->
						</div>
						<!-- End Box -->
					</div>
					<!-- End Content -->
					<!-- Sidebar -->
					<div id="sidebar">
						<!-- Box -->
						<div class="box">
							<!-- Box Head -->
							<div class="box-head">
								<h2>Directory</h2>
							</div>
							<!-- End Box Head-->
							<div class="box-content">
								
							</div>
						</div>
						<!-- End Box -->
					</div>
					<!-- End Sidebar -->
					<div class="cl">&nbsp;</div>
				</div>
				<!-- Main -->
			</div>
		</div>
		<!-- End Container -->
		<!-- Footer -->
		<div id="footer">
			<div class="shell"> <span class="left">&copy; 2020 - EVOLVE</span> <span class="right"> Template by <a href="http://chocotemplates.com">Chocotemplates.com</a> </span> </div>
		</div>
		<!-- End Footer -->
	</body>
	<script>
	$(document).ready(function(){
		/* password change */
		$(document).on('submit', '#changepswd', function(ev){
			if(document.getElementsByClassName('newpw')[0].value != document.getElementsByClassName('newpw')[1].value){
				$('#error').show();
				alert("New Password Mismatch !");
			}
			else{
				var data = $("#changepswd").serialize();
				$.post('check_user.php', data, function(data,status){
					if( data == "done"){
						$('#ok').show();
						alert("Password Changed Successfully !");
					}
					else{
						$('#error').show();
						alert(data);
					}
					
				});
			}
		});
		
		/* Authenticator New Register */
		$(document).on('submit', '#LI-form', function(ev){
			var data = $("#LI-form").serialize();
			$.post('check_user.php', data, function(data,status){
				if( data == "done"){
					window.location = 'user_confirm';
				}
				else{
					alert("Invalid Code");
				}
			});
		});
	});
	</script>
</html>