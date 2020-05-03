<?php
include("connection.php");

require_once 'googleLib/GoogleAuthenticator.php';
$gauth = new GoogleAuthenticator();
$secret_key = $gauth->createSecret();

if(!isset($_POST['process_name'])){
	header("Location: " . $APP_URL . "login");
	die();
}
$process_name = $_POST['process_name'];



if($process_name == "user_registor"){
	$reg_name		= $_POST['reg_name'];
	$reg_email		= $_POST['reg_email'];
	$reg_password	= md5($_POST['reg_password']);
    
	$chk_user = mysqli_query($conn,"select * from tbl_users where email='$reg_email'") or die(mysqli_error($conn));
	if(mysqli_num_rows($chk_user) == 0){
    	$query = "insert into tbl_users(profile_name, email, password, google_auth_code, password_last_change, last_login, gauth_qr_last_scan) values('$reg_name', '$reg_email', '$reg_password', '$secret_key', now(), now(), now() )";
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		$_SESSION['user_id'] = mysqli_insert_id($conn);
		$_SESSION['gauth'] = 'new';
		echo "done";
    }
    else{
		echo "This Email already exits in system.";
    }
}

if($process_name == "change-password"){
	$old_password	= md5($_POST['old_password']);
	$new_password	= md5($_POST['new_password']);
    
	$user_id = $_SESSION['user_id'];
	$result = mysqli_query($conn,"select * from tbl_users where user_id='$user_id'") or die(mysqli_error($conn));
	$user_row = mysqli_fetch_array($result);
	if($user_row['password'] == $old_password){
		$query = "UPDATE tbl_users SET password = '$new_password', password_last_change = now() WHERE user_id = '$user_id'";
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		echo "done";
	}else{
		echo "Wrong Current Password !";
	}
}

if($process_name == "user_login"){
	$login_email		= $_POST['login_email'];
	$login_password		= md5($_POST['login_password']);
    
	$user_result = mysqli_query($conn,"select * from tbl_users where email='$login_email' and password='$login_password'") or die(mysqli_error($conn));
	if(mysqli_num_rows($user_result) == 1){
    	$user_row = mysqli_fetch_array($user_result);
		$_SESSION['user_id'] = $user_row['user_id'];
		$_SESSION['login_at'] = date('Y-m-d H:i:s',time());
		echo "done";
    }
    else{
		echo "Check your user login details.";
    }
}

if($process_name == "verify_code"){
	$scan_code = $_POST['scan_code'];
	$user_id = $_SESSION['user_id'];
	
	$user_result = mysqli_query($conn,"select * from tbl_users where user_id='$user_id'") or die(mysqli_error($conn));
	$user_row = mysqli_fetch_array($user_result);
	$secret_key	= $user_row['google_auth_code'];
	
	$checkResult = $gauth->verifyCode($secret_key, $scan_code, 2);    // 2 = 2*30sec clock tolerance

	if ($checkResult){
		$_SESSION['googleVerifyCode'] = $scan_code;
		if(isset($_SESSION['gauth'])){
			unset($_SESSION['gauth']);
		}
		if(isset($_POST['new_reg'])){
			$_SESSION['gauth'] = 'reg';
			$query = "UPDATE tbl_users SET gauth_qr_last_scan = now() WHERE user_id = '$user_id'";
			$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		}
		echo "done";
	} 
	else{
		echo 'Note : Code not matched.';
	}
}
?>