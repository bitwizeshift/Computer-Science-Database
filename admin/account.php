<?php 
/**
 * The Account administration page. From here, users can change their password
 * and display name, or even add more users provided they have high enough 
 * clearance.
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.4 2014-07-13
 * 
 * @package AffinityFramework
 * @subpackage Admin
 */

/* Bootstrap the framework  */
require_once( dirname(__FILE__) . '/admin-bootstrap.php' );

if(!is_secure_session()){
	redirect_address( "admin/login.php" );
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Your Account</title>
<?php require('admin-meta.php'); ?>
</head>

<body class="admin account">
<?php require('admin-header.php'); ?>
<div id="wrapper">
	<div id="content" class="container">
		<div class="panel">
			<h2 class="heading">Profile Information for <?=$_SESSION['sess_display_name']; ?></h2>
			<form name="account-info-form" id="account-info-form" method="post" action="admin/account.php?action=change_info" target="_self">
				<p>
					<label for="first-name-input">First Name<br>
					<input type="text" name="first-name" id="first-name-input" class="half-size" size="100"></label>
				</p>
				<p>
					<label for="last-name-input">Last Name<br>
					<input type="text" name="last-name" id="last-name-input" class="half-size" size="100"></label>
				</p>
				<p>
					<label for="display-name-input">Display Name<br>
					<input type="text" name="display-name" id="display-name-input" class="half-size" size="100" value="<?= $_SESSION['sess_display_name'];?>">
					</label>
				</p>
				<p>
					<label for="email-input">Email Address<br>
					<input type="email" name="email" id="email-input" class="half-size" size="100"></label>
				</p>
				<p class="submit">
					<input type="submit" name="submit" id="submit-button" class="button" value="Change Information" disabled="disabled">
				</p>
			</form>
		</div>
		<div class="panel">
			<h3 class="heading">Change Password</h3>
			<form name="account-password-form" id="account-password-form" method="post" action="admin/account.php?action=change_password" target="_self">
				<p>
					<label for="current-password-input">Current Password<br>
					<input type="password" name="current-password" id="current-password-input" value="" size="32"></label>
				</p>
				<p>
					<label for="new-password-input">New Password<br>
					<input type="password" name="new-password" id="new-password-input"  value="" size="32"></label>
				</p>
				<p>
					<label for="retype-password-input">Retype Password<br>
					<input type="password" name="retype-password" id="retype-password-input" value="" size="32"></label>
				</p>
				<p class="submit">
					<input type="submit" name="submit" id="submit-button" class="button" value="Change Password">
				</p>
			</form>
		</div>
		
		<div class="panel">
			<h3 class="heading">Add New Account</h3>
		</div>
	</div>
</div>

</body>

</html>