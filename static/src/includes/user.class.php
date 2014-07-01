<?php
/**
 * The User class.
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.1 2014-06-30
 */
class User{
	
	private static $PERMISSIONS = array(1 => "publish", 
			2 => "review", 3 => "upload",
			4 => "remove", 5 => "edit");
	
	/** Can user publish articles? */
	private $can_publish = false;
	/** Can user review articles? */
	private $can_review = false;
	/** Can user upload articles? */
	private $can_upload = false;
	/** Can user remove articles? */
	private $can_remove = false;
	/** Can user edit articles? */
	private $can_edit = false;
	
	/** The user's given username */
	private $username = "";
	/** The user's password hash */
	private $password_hash = "";
	/** The user's permission array */
	private $permissions = array();
	
	
	
	/**
	 * Constructs a User object initializing the various permissions
	 */
	public function __construct($username, $password){
		register_shutdown_function( array( $this, '__destruct' ) );

		$this->username = $username;
		
		$this->_decode_permissions();
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function __destruct(){
		return true;
	}
	
	/**
	 * Decodes the permissions for the user based on the user's
	 * numeric permission value. This method sets the attributes
	 * for the User class.
	 * 
	 * @since 0.1
	 */
	private function _decode_permissions(){
		
	}
}

?>