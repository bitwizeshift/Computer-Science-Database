<?php
/**
 * CONNECTION
 * 
 * Descriptions:
 *   This unit contains the modular database connection class which forms
 *   an adapter around the PDO MySQL database.
 * 
 */
class Connection {	
	
	/**
	 * Prefix for the database
	 * 
	 * @since 1.0
	 * @var string
	 */
	private $db_prefix = "";
	/** 
	 * Prefix for the tables 
	 * 
	 * @since 1.0
	 * @var string
	 */
	private $table_prefix = "";	
	
	/**
	 * Database handle
	 * 
	 * @since 1.0
	 * @var PDO
	 */
	private $dbhandle = null;
	/**
	 * The character set
	 * 
	 * @var string
	 */
	private $charset;

	//------------------------------------------------------------------------
	
	/**
	 * Instantiates a Connection class from the values specified in the
	 * supplied ini file
	 * 
	 * @param string $settings_file name of the .ini file to use for settings
	 */
	public function __construct( $settings_file ) {
		register_shutdown_function( array( $this, '__destruct' ) );
		$this->_connect($settings_file);
	}
	
	/**
	 * Destructor for the Connection class
	 * 
	 * @return boolean always returns true
	 */
	public function __destruct(){
		return true;
	}
	
	//------------------------------------------------------------------------
		
	/**
	 * Connect to the database from the specified ini file
	 * 
	 * @param string $settings_file name of the .ini file to use for settings
	 */
	private function _connect( $settings_file ) {
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
			die();
		}
	}
	
	/**
	 * Queries the database, returning an associative array of the results
	 * 
	 * @param string $statement The SQL query statement
	 * @return multitype associative array result of query
	 */
	public function query($statement){
		$i=1;
		$stmt = $this->conn->prepare( $statement );
		$argc = func_num_args();
		$argv = func_get_args();
		foreach($argv as &$arg){
			$stmt->bindValue($i,$arg[0],$arg[1]);
			++$i;
		}
		$stmt->setFetchMode( PDO::FETCH_ASSOC );
		$stmt->execute();
		return $stmt->fetchAll();
	}

}
?>