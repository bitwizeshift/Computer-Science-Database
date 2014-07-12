<?php
/**
 * Database connection class
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.1 2014-06-30
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

	/* Constructor/Destructor/Initialization
	 ------------------------------------------------------------------------ */
	
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
				$this->dbhandle = new PDO( $dsn, $usr, $pwd, $options );
			} else {
				throw new exception( 'Error: Unable to open settings file.' );
			}
		} catch( Exception $e ) {
			print( $e->getMessage() );
			die();
		}
	}
	
	/* Queries/Generation/Existence
	 ------------------------------------------------------------------------ */
	
	/**
	 * Queries the database, returning an associative array of the results
	 * 
	 * @param string $statement The SQL query statement
	 * @return multitype array of parameters for the query
	 */
	public function query($statement, $params=array()){
		$i=1;
		$stmt = $this->dbhandle->prepare( $statement );		
		foreach( (array) $params as &$param){
			$type = Connection::get_type($param);
			echo "<p>$type</p>";
			$stmt->bindValue( $i, $param, $type);
			++$i;
		}
		$stmt->setFetchMode( PDO::FETCH_ASSOC );
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	static private function get_type($param){
		switch(gettype($param)){
			case "boolean":
				$result = PDO::PARAM_BOOL;
				break;
			case "double": // no break
			case "string":
				$result = PDO::PARAM_STR;
				break;
			case "integer":
				$result = PDO::PARAM_INT;
				break;
			default:
				$result = PDO::PARAM_NULL;
				break;
		}
		return $result;
	}
	
	/**
	 * 
	 */
	public function execute( $statement, $params ){
		try{
			$stmt = $this->dbhandle->prepare($statement);
		}catch(PDOException $e){
			echo "Error caught: " . $e;
		}
		return $stmt->execute($params);
	}
	
	/**
	 * Checks if the table exists
	 * 
	 * @param string $table table name
	 * @return true if table exists
	 */
	public function table_exists($table){
		try {
			// Check if table is found
			$result = $this->dbhandle->query("SELECT 1 FROM $table LIMIT 1");
		} catch (Exception $e) {
			// Table not found
			return false;
		}
		// Table has been found
		return $result !== false;
	}
}
?>