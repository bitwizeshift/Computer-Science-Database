<?php
/**
 * Handles the creation and parsing of php sessions. Password hashing and
 * comparisons are also declared here.
 *   
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.1 2014-06-30
 */

load_resource('user.class.php');

/**
 * The user object
 */
global $user;

/**
 * Opens a secure session for the user
 */
function start_secure_session(){
	$session_name = 'sec_session_id';   // Set a custom session name
	$secure = SECURE;                   // This stops JavaScript being able to access the session id.
	$httponly = true;
	// Forces sessions to only use cookies.
	if (ini_set('session.use_only_cookies', 1) === FALSE) {
		header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
		exit();
	}
	// Gets current cookies params.
	$cookieParams = session_get_cookie_params();
	session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
	session_name($session_name); // Sets the session name to the one set above.
	session_start();             // Start the PHP session
	session_regenerate_id();     // regenerated the session, delete the old one.
}

/**
 * Close Secure Session
 */
function close_secure_session(){
	session_destroy();
}

/**
 * Check User Secure Session
 */
function is_session(){
	return isset($_SESSION);
}

/* __login
 -------------------------------------------------------------------------- */

/**
 * Validates login based on session variables
 * 
 * @return boolean True if valid user
 */
function validate_login(){
	global $g_conn;
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$result = false;
	
	
	return $result;
}

/**
 * Create a hash (encrypt) of a plain text password.
 *
 * @since 0.1
 *
 * @global object $wp_hasher PHPass object
 * @uses PasswordHash::HashPassword
 *
 * @param string $password Plain text user password to hash
 * @return string The hash string of the password
 */
function hash_password($password){
	global $g_hasher;

	if ( empty($g_hasher) ) {
		require_resource('phpass.class.php');
		// Use the portable hash from phpass
		$g_hasher = new PasswordHash(8, true);
	}

	return $g_hasher->HashPassword( trim( $password ) );
}

/**
 *
 * @param string $password
 * @param string $hash
 * @param string $user_id
 */
function check_password($password, $hash, $user_id = ''){

}
?>