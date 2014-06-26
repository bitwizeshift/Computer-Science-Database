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