<?php
include("connection.php");
if(!empty($_SESSION['user_id']))
{
	header('Location: /dashboard');
	die();
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scale=yes">
    <link rel="icon" href="img/favicon.png" type="image/png">
  <title>Evolves</title>
  <link rel="stylesheet" href="css/style.css">

</head>
<body id ="bd">
<div class="panda">
  <div class="ear"></div>
  <div class="face">
    <div class="eye-shade"></div>
    <div class="eye-white">
      <div class="eye-ball"></div>
    </div>
    <div class="eye-shade rgt"></div>
    <div class="eye-white rgt">
      <div class="eye-ball"></div>
    </div>
    <div class="nose"></div>
    <div class="mouth"></div>
  </div>
  <div class="body"> </div>
  <div class="foot">
    <div class="finger"></div>
  </div>
  <div class="foot rgt">
    <div class="finger"></div>
  </div>
</div>
<form onsubmit="login()" id="login-form">
  <div class="hand"></div>
  <div class="hand rgt"></div>
  <h1>Login</h1>
  <input type="hidden" id="process_name" name="process_name" value="user_login" />
  <div class="form-group">
    <input name="login_email" id="login_email" required="required" class="form-control"/>
    <label class="form-label">Email    </label>
  </div>
  <div class="form-group">
    <input id="password" name="login_password" type="password" required="required" class="form-control"/>
    <label class="form-label">Password</label>
    <p class="alert">Invalid Credentials..!!</p>
    <button class="btn btn-login-submit">Login </button>
  </div>
</form>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script  src="js/script.js"></script>
  
  <!-- Is this Useful -->
  <script src="js/jquery.validate.min.js"></script>

  <script>
  $(document).ready(function(){
		$(document).on('click', '.btn-login-submit', function login(ev){
			if($("#login-form").valid() == true){
				var data = $("#login-form").serialize();
				$.post('check_user.php', data, function(data,status){
					if( data == "done"){
						window.location = 'user_login_confirm.php';
					}
					else{
						alert("Something went wrong!");
					}
				});
			}
		});
	});
  </script>

</body>
</html>
