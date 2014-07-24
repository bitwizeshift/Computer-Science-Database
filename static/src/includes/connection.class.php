<?php
/**
 * Database connection class
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 1.0 2014-06-30
 */
class Connection {

	/**
	 * Prefix for the tables
	 *
	 * @since 1.0
	 * @var string
	 */
	public $table_prefix = "";
	/**
	 * All available tables in the database
	 *
	 * @since 1.0
	 * @var array array of table names in the database
	 */
	public $tables = array();
	/**
	 * Database handle
	 *
	 * @since 1.0
	 * @var PDO
	*/
	protected $dbhandle = null;

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

		// Prefix tables, if a prefix is set
		if(!empty($this->table_prefix)){
			foreach($this->tables as &$table){
				$table = $this->table_prefix . $table;
			}
		}

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
				$host = $settings['database']['host'];
				$db   = $settings['database']['dbname'];
				$user = $settings['database']['user'];
				$pass = $settings['database']['pass'];
				$char = $settings['database']['charset'];

				$dsn = "mysql:host={$host};dbname={$db};charset={$char}";

				$options = array();
				$options[PDO::ATTR_PERSISTENT] = TRUE;
				$options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$this->dbhandle = new PDO( $dsn, $user, $pass, $options );
			} else {
				throw new exception( 'Error: Unable to open settings file.' );
			}
		} catch( Exception $e ) {
			echo( '<h1>Error connecting to database</h1>');
			echo( '<pre>' . $e->getMessage() . '</pre>' );
			die();
		}
	}

	/* Queries/Generation/Existence
	 ------------------------------------------------------------------------ */

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
	
	/**
	 * Checks if the value exists in the table at the specified column
	 * 
	 * @param string $table the table name
	 * @param string $column the column name
	 * @param unknown $value the value to check for
	 * @return boolean ture if value exists
	 */
	public function value_exists( $table, $column, $value ){
		$query = "SELECT 1 FROM `{$table}` " .
		"WHERE `$column` = ? " .
		"LIMIT 1";
		
		$stmt = $this->dbhandle->prepare( $query );
		$stmt->bindValue( 1, $value );
		$stmt->execute();
		
		return (bool) $stmt->rowCount() > 0;
	}
}
?>