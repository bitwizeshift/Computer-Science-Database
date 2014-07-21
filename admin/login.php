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
	redirect_address( "admin/dashboard.php" );

$message = null;
$level = "";

// If an action is present, interpret it
if(isset($_GET['action']) && $_GET['action']=="logout"){
	set_message(Message::SUCCESS, "Successfully logged out.");
}


// If valid login
if(isset($_GET['action']) && $_GET['action']=="submit"){
	$username = http_value("POST", "username", "");
	$password = http_value("POST", "password", "");
		
	$valid = validate_login($username, $password);
	
	if($valid){
		redirect_address( 'admin/dashboard.php' );
	}else{
		set_message(Message::ERROR, "Invalid login information.");
	}
}


?>

<!DOCTYPE html>
<html>
<head>
<title>Login Form</title>
<?php require('admin-meta.php'); ?>
</head>
 
<body class="admin login">
	<div id="login">

	<?php print_messages(); ?>
	
		<form name="login-form" id="login-form" method="post" action="admin/login.php?action=submit" target="_self">
			<p>
				<label for="username-input">Username<br>
				<input type="text" name="username" id="username-input" value="" size="32"></label>
			</p>
			<p>
				<label for="password-input">Password<br>
				<input type="password" name="password" id="password-input" value="" size="32"></label>
			</p>
			<p class="submit">
				<input type="submit" name="submit" id="submit-button" class="button" value="Log In">
				<!-- <input type="hidden" name="redirect_to" value="">-->
			</p>
		</form>
	</div>
</body>
</html>