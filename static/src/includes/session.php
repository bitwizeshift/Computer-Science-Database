<?php
/**
 * Handles the creation and parsing of php sessions. Password hashing and
 * comparisons are also declared here.
 *   
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.1 2014-06-30
 */

require_once( INCLUDE_PATH . 'phpass.class.php');

/* Session starting/ending
 -------------------------------------------------------------------------- */

/**
 * Starts a secure session for the user to log in
 * 
 * @param int $id The user ID
 * @param string $username The user name
 * @param string $passhash The user pass
 */
function start_secure_session($id, $username, $display_name){
	session_regenerate_id();
	$_SESSION['sess_user_id']  = $id;
	$_SESSION['sess_username'] = $username;
	$_SESSION['sess_display_name'] = $display_name;
	session_write_close();	
}

/**
 * Close Secure Session
 */
function close_secure_session(){
	$_SESSION = array(); // Clear all session values
	session_destroy();
}

/**
 * Check to see if a session is already open
 * 
 * @return boolean True if the session is valid, false otherwise
 */
function is_secure_session(){
	return isset($_SESSION['sess_user_id']) && (trim($_SESSION['sess_user_id']) != '');
}

/* Functions to log in
 -------------------------------------------------------------------------- */

/**
 * Validates login based on session variables.
 * If the user is valid, it automatically creates a secure session
 * 
 * @return boolean True if valid user
 */
function validate_login($username, $password){
	global $query;
	
	$result = $query->query_user( $username );
	if(empty($result))
		return false;

	$id   = $result['id'];
	$user = $result['username'];
	$disp = $result['display_name'];
	$pass = $result['password'];
	$salt = $result['salt'];
	
	$check = check_password($password, $salt, $pass);

	if($check)
		start_secure_session($id, $user, $disp);
	
	return $check;
}

/**
 * Create a hash (encrypt) of a plain text password with the salt.
 *
 * @since 0.1
 *
 * @global object $wp_hasher PHPass object
 * @uses PasswordHash::HashPassword
 *
 * @param string $password Plain text user password to hash
 * @param string $salt Plain text salt to hash with password
 * @return string The hash string of the password
 */
function hash_password($password, $salt){
	global $g_hasher;

	if ( empty($g_hasher) ) 
		$GLOBALS['g_hasher'] = new PasswordHash(8, true);

	return $g_hasher->HashPassword( trim( $password . $salt ) );
}

/**
 * Checks to see if the password is valid
 * 
 * @param string $password The password to compare
 * @param string $salt The salt of the password to compare
 * @param string $hash The hash to compare with
 * @return boolean True if the password is valid, false otherwise
 */
function check_password($password, $salt, $hash){
	global $g_hasher;
	
	if( empty($g_hasher) )
		$GLOBALS['g_hasher'] = new PasswordHash(8, true);
	
	return $g_hasher->CheckPassword( trim($password . $salt), $hash);
}


?>