<?php

class Validate{
	
	
	
	
	
	
	static function user_account($username, $password){
		$error_messages = array();
		
		if(!isset($username))
			$error_messages[] = Message::USERNAME_EMPTY;
		
		if(!isset($password))
			$error_messages[] = Message::PASSWORD_EMPTY;
		
		$username = trim($username);

		if(sizeof($username) < 4 || sizeof($username) > 32)
			$error_message[] = Message::USERNAME_OOB;
		
		if(sizeof($password) < 6 || sizeof($password) > 32)
			$error_messages[] = Message::PASSWORD_OOB;
		
		if(preg_match('/[^a-zA-Z]+_/', $username))
			$error_messages[] = Message::SPECIAL_CHARACTERS;
		
		return $error_messages;
	}
	
	
}


class Message{
	
	const SUCCESS = "success";
	const INFO    = "info";
	const ERROR   = "error";
	const WARNING = "warning";

	// User validation
	
	const USERNAME_EMPTY = ""; #array(ERROR,   "The username field was left empty.");
	const PASSWORD_EMPTY = ""; #array(ERROR,   "The password field was left empty.");
	const INVALID_LOGIN  = ""; #array(ERROR,   "Invalid username or password.");
	const SPECIAL_CHARS  = ""; #array(ERROR,   "Username uses invalid characters.");
	const USERNAME_OOB   = ""; #array(ERROR,   "Username must be between 4 and 32 characters.");
	const PASSWORD_OOB   = ""; #array(ERROR,   "Password must be between 6 and 32 characters.");
	
	const LOGOUT_SUCCESS = ""; #array(SUCCESS, "Successfully logged out.");
		
}
