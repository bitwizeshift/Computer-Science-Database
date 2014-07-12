<?php
/**
 * Handles the creation and parsing of php sessions. Password hashing and
 * comparisons are also declared here.
 *   
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.1 2014-06-30
 */

require_once( INCLUDE_PATH . 'phpass.class.php');

/**
 * Starts a secure session for the user to log in
 * 
 * @param int $id The user ID
 * @param string $username The user name
 * @param string $passhash The user pass
 */
function start_secure_session($id, $username){
	ob_start();
	session_start();
	session_regenerate_id();
	$_SESSION['sess_user_id']  = $id;
	$_SESSION['sess_username'] = $username;
	session_write_close();	
}

/**
 * Close Secure Session
 */
function close_secure_session(){
	session_start();
	session_destroy();
}

/**
 * Check to see if a session is set or valid
 * 
 * @return boolean True if the session is valid, false otherwise
 */
function is_valid_session(){
	return isset($_SESSION['sess_user_id']) && (trim($_SESSION['sess_user_id']) != '');
}

/* __login
 -------------------------------------------------------------------------- */

/**
 * Validates login based on session variables
 * 
 * @return boolean True if valid user
 */
function validate_login(){
	global $g_db;
	
	if(!isset($g_db)) 
		load_database();
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$result = false;
	$query = "SELECT id, username, password, salt FROM member WHERE username = ?";
	
	$result = $g_db->query($query, array($username, PDO::PARAM_STR));
	
	$userpass = hash_password($result['password'],$result['salt']);
	
	return $result;
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