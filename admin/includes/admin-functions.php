<?php
/**
 * The administration functions.
 *
 * 
 *
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.4 2014-07-19
 *
 * @package AffinityFramework
 * @subpackage Admin
 */

/* Get values
 -------------------------------------------------------------------------- */

/**
 * 
 * @param unknown $array
 * @param unknown $key
 * @param string $default_value
 * @return Ambigous <string, unknown>
 */
function array_value($array, $key, $default_value = null) {
    return is_array($array) && isset($array[$key]) ? $array[$key] : $default_value;
}

/**
 * Gets the value from one of the superglobal methods (GET, POST, or SESSION)
 * Returns $default_value if it is not set.
 * 
 * @param string $method The method to use (GET, POST, or SESSION)
 * @param string $key The global to get
 * @param string $default_value The default value if it's not set
 * @return string The value from the method
 */
function http_value($method, $key, $default_value = null){
	switch(strtoupper($method)){
		case "GET":
			$result = isset($_GET[$key]) ? $_GET[$key] : $default_value;
			break;
		case "POST":
			$result = isset($_POST[$key]) ? $_POST[$key] : $default_value;
			break;
		case "SESSION":
			$result = isset($_SESSION[$key]) ? $_SESSION[$key] : $default_value;
			break;
		case "GLOBALS":
			$result = isset($GLOBALS[$key]) ? $GLOBALS[$key] : $default_value;
			break;
		default:
			$result = $default_value;
	}
	return $result;
}

/* Message Handling
 -------------------------------------------------------------------------- */

/**
 * Sets the callout message and level to be read.
 * 
 * @param int $level The integer level
 * @param string $message The message to display
 */
function set_message($level, $message){
	global $g_messages;
	$g_messages->insert($level, $message);
}

/**
 * checks whether a message has been prepared
 * 
 * @return boolean whether or not a message is prepared
 */
function is_message_set(){
	global $g_messages;
	return !$g_messages->is_empty();
}

/**
 * Prints specified number of messages to the user. 
 * 0 to print all messages
 * 
 * @param number $limit
 */
function print_messages( $limit=1 ){
	global $g_messages;
	$g_messages->print_out($limit);
}

/**
 * Clears all the messages from the message stack
 */
function clear_messages(){
	global $g_messages;
	$g_messages->clear();
}

/* Redirection Handling
 -------------------------------------------------------------------------- */

/**
 * Redirects the URL to a specified location, optionally
 * with a delay
 * 
 * @param string $page Page to redirect to
 * @param number $delay (optional) delay in seconds before redirecting
 */
function redirect_address( $page, $delay=0 ){
	$url = get_home_url() . $page;
	if($delay!=0){
		header("Refresh: {$delay}; URL={$url}");
	}else{
		header("Location: {$url}");
	}
	exit();	
}

?>