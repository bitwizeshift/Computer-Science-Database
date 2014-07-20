<?php
/**
 *
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.4 2014-07-13
 *
 * @package AffinityFramework
 * @subpackage Admin
 */

function is_valid_field($field, $validator, $start, $end){
	
}


/**
 * 
 * @param unknown $password
 */
function is_validate_username($username){
	return is_valid_field($username, Validate::ALPHA_NUMERIC, 0, 32);
}

/**
 * 
 * @param unknown $password
 */
function is_validate_password($password){
	return is_valid_field($password, Validate::ANY, 0, 32);
}


/**
 * 
 *
 */
abstract class Validate{
	const UPPERCASE     = "";
	const LOWERCASE     = "";
	const ALPHABETIC    = "";
	const NUMERIC       = "";
	const ALPHA_NUMERIC = "";
	const SYMBOLS       = "";
	const ANY           = "";
}

?>