<?php
/**
 * 
 * 
 * @author Bitwize
 * @since 1.0
 */
class Connection {	
	private $conn = null;

	//-------------------------------------------------------------------------
	
	public function __construct( $settings_file ) {
		$this->connect($settings_file);
	}
	
	//------------------------------------------------------
	
	/**
	 * Connect to the database from the specified ini file
	 * 
	 */
	private function connect( $settings_file ) {
		try {
			if( $settings = parse_ini_file( $settings_file, TRUE ) ) {
				$dsn = $settings['database']['dsn'];
				$usr = $settings['database']['usr'];
				$pwd = $settings['database']['pwd'];
				$options = array();
				$options[PDO::ATTR_PERSISTENT] = TRUE;
				$options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$this->conn = new PDO( $dsn, $usr, $pwd, $options );
			} else {
				throw new exception( 'Error: Unable to open settings file.' );
			}
		} catch( Exception $e ) {
			print( $e->getMessage() );
		}
	}
	
	//-------------------------------------------------------------------------
	
	/**
	 * Accesses and returns this instance to the connection
	 * 
	 * @return PDO connection class
	 */
	public function getConnection( ) {
		return( $this->conn );
	}
	
	//-------------------------------------------------------------------------
}
?>