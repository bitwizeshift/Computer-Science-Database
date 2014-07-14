<?php
/**
 * The main edit screen for the administrators to handle creation
 * of articles
 *
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.4 2014-07-13
 * 
 * @package
 * @subpackage Admin
 */

/* Bootstrap the framework  */
require_once( dirname(__FILE__) . '/admin-bootstrap.php' );

// If already logged in, redirect to the hub page
if(is_secure_session())
	redirect_address( "admin/edit.php" );

$message = null;
$level = "";

// If an action is present, interpret it
if(isset($_GET['action'])){
	$action = $_GET['action'];
	
	switch($action){
		case "logout":
			$message = "<strong>Info</strong>: Successfully logged out.";
			$level = "success";
			break;
	}
}
// If an error message is present, interpret it
if(isset($_GET['error'])){
	$error = $_GET['error'];
	$level = "error";
	
	switch($error){
		case "no_username":
			$message = "<strong>Error</strong>: The username field was left empty.";
			break;
		case "no_password":
			$message = "<strong>Error</strong>: The password field was left empty.";
			break;
		case "invalid_login":
			$message = "<strong>Error</strong>: Invalid username or password.";
			break; 
		default:
			redirect_address( "admin/login.php" );
			break;
	}
	
}

// If valid login
if(isset($_POST['username']) && isset($_POST['password'])){
	$username = $_POST['username'];
	$password = $_POST['password'];
		
	$valid = validate_login($username, $password);
		
	if(!$valid){
		header('Location: login.php?error=invalid_login');
		exit();
	}else{
		header('Location: edit.php');
		exit();
	}
}


?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='stylesheet' type='text/css' href='../static/css/style.css?ver=0.3' media='screen' />
<title>Login Form</title>
<style>
.login{
	background: #f1f1f1;
}
#login-form{
	margin: 20px auto 0;
	width: 272px;
	background: #fff;
	-webkit-box-shadow: 0 1px 3px rgba(0,0,0,.13);
	box-shadow: 0 1px 3px rgba(0,0,0,.13);
	padding: 26px 24px 46px;
	font-weight: 400;
	overflow: hidden;
}
.input{
	font-size: 24px;
	line-height: 1;
	width: 100%;
	padding: 3px;
	margin: 2px 6px 16px 0;
}
label{
	cursor: pointer;
	color: #777;
	font-size: 14px;
}
.login .callout{
	width: 274px;
	margin: 0 auto;
}
#login {
	width: 320px;
	padding: 10% 0 0;
	margin: auto;
}
</style>
</head>
 
<body class="login">

<div id="login">

	<?php 
		if($message){
			echo '<div class="callout callout-' . $level . '" role="alert">' . $message . '</div>';
		}
	?>
	
	<form name="login-form" id="login-form" method="post" action="?action=submit">
		<p>
			<label for="username-input">Username<br>
			<input type="text" name="username" id="username-input" class="input" value="" size="32"></label>
		</p>
		<p>
			<label for="password-input">Password<br>
			<input type="password" name="password" id="password-input" class="input" value="" size="32"></label>
		</p>
		<p class="submit">
			<input type="submit" name="submit" id="submit-button" class="button" value="Log In">
			<!-- <input type="hidden" name="redirect_to" value="">-->
		</p>
	</form>

</div>

</body>
</html>