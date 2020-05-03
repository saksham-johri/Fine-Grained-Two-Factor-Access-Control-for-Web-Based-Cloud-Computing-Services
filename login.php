<?php
include("connection.php");
if(!empty($_SESSION['googleVerifyCode'])){
	header('Location: /dashboard');
	die();	
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Evolves</title>
    <link rel="icon" href="img/favicon.png" type="image/png">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes"><link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'><link rel="stylesheet" href="css/style.css">
  <style>
	#scan_code {
	  background-color: #3CBC8D;
	  width:50%;
	  text-align:center;
	  font-size:20px;
	  padding-right:15px;
	  margin-left:25%;
	  border-radius: 4px;
	}
	#scan_code:focus {
	  background-color: #5DDCAD;
	}
	#verify_code{
		width:70%;
		left:15%;
	}
  </style>
  
</head>
<body>
<!-- partial:index.partial.html -->
<div id="session" style="display: none;"><?php echo !empty($_SESSION['user_id']) ?></div>
<div class="cont">
  <div class="demo">
    <div class="login">
	<form method="post" id="login-form">
  <input type="hidden" id="process_name" name="process_name" value="user_login" />
      <img src="img/Evolves.png" style="height: 200px; width: 200px; border-radius: 100px; margin: 50px;"> 
      <div class="login__form">
        <div class="login__row">
          <svg class="login__icon name svg-icon" viewBox="0 0 20 20">
            <path d="M0,20 a10,8 0 0,1 20,0z M10,0 a4,4 0 0,1 0,8 a4,4 0 0,1 0,-8" />
          </svg>
          <input autofocus required type="text" name="login_email" class="login__input name" placeholder="Email"/>
        </div>
        <div class="login__row">
          <svg class="login__icon pass svg-icon" viewBox="0 0 20 20">
            <path d="M0,20 20,20 20,8 0,8z M10,13 10,16z M4,8 a6,8 0 0,1 12,0" />
          </svg>
          <input required type="password" name="login_password" class="login__input pass" placeholder="Password"/>
        </div>
        <button type="submit" id="login" class="login__submit">Sign in</button>
        <p class="login__signup">Don't have an account? &nbsp;<a href="register.php">Sign up</a></p>
      </div>
	</form>
    </div>
    <div class="app">
      <div class="app__top">
        <p class="app__hello">Verification Required!</p>
		<img src="img/google_authenticator.png" alt="Google Authenticator" class="" style="width:45%; position:relative; top:-10px;"/>
        <div class="app__month">
          <p class="app__month-name">Place your MFA Code here</p>
        </div>
      </div>
      <div class="app__bot">

        <div class="app__meetings">
		<form id="LI-form" method="post">
          <input type="hidden" id="process_name" name="process_name" value="verify_code" />
		  <div class="app__meeting">
            <input autocomplete="off" type="text" name="scan_code" class="login__input name" maxlength="6" placeholder="______" id="scan_code" required />
          </div>
            <button type="submit" id="verify_code" class="login__submit" >Verify Code</button>
		</form>
		  
        </div>
      </div>
      <div class="app__logout">
        <svg class="app__logout-icon svg-icon" viewBox="0 0 20 20">
          <path d="M6,3 a8,8 0 1,0 8,0 M10,0 10,12"/>
        </svg>
      </div>
    </div>
  </div>
</div>
<!-- partial -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script  src="js/script.js"></script>

    <script src="js/jquery.validate.min.js"></script>
</body>
</html>
