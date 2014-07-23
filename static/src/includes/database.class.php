<?php

class Connection2 {

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

class Query extends Connection2{
	
	/* Sorting constants */
	
	const SORT_DATE_ASC    = "date ASC";
	const SORT_DATE_DESC   = "date DESC";
	const SORT_TITLE_ASC   = "title ASC";
	const SORT_TITLE_DESC  = "title DESC";
	const SORT_AUTHOR_ASC  = "display_name ASC";
	const SORT_AUTHOR_DESC = "display_name DESC";
	const SORT_LOGIN_ASC   = "username ASC";
	const SORT_LOGIN_DESC  = "username DESC";
	
	private static $term_attributes = array(
		"slug",
		"name",
		"type"
	);
	private static $user_attributes = array(
		"username",
		"password",
		"salt",
		"display_name",
		"email",
		"premissions",
	);
	private static $post_attributes = array(
		"title",
		"parent",
		"type",
		"excerpt",
		"input",
		"output",
		"date",
		"user_id"
	);
	
	/* Constructor/Destructor/Initialization
	 ------------------------------------------------------------------------ */
	
	/**
	 * Instantiates a Connection class from the values specified in the
	 * supplied ini file
	 *
	 * @param string $settings_file name of the .ini file to use for settings
	 */
	public function __construct( $settings_file ) {
		$this->table_prefix = "ucsd_";
		register_shutdown_function( array( $this, '__destruct' ) );
		$this->tables = array(
				"options"        => "options",
				"posts"          => "posts",
				"post_meta"      => "post_meta",
				"post_relations" => "post_relations",
				"terms"          => "terms",
				"term_relations" => "term_relations",
				"users"          => "users",
				"user_meta"      => "user_meta"
		);
		parent::__construct( $settings_file );
	}
	
	/**
	 * Destructor for the Connection class
	 *
	 * @return boolean always returns true
	 */
	public function __destruct(){
		return true;
	}

	/* Queries/Generation/Existence
	 ------------------------------------------------------------------------ */
	
	public function search_for_posts( $term ){
		$post_table = &$this->tables['posts'];
		$term_table = &$this->tables['terms'];
		$relations  = &$this->tables['term_relations'];
		
		$term = "%$term%";
		
		$query = "SELECT `title`, `slug`, `excerpt` " .
				"FROM `{$post_table}` JOIN `{$term_table}` JOIN `{$relations}` " .
				"WHERE `{$post_table}`.`type` = 'POST' " .
				"AND `{$term_table}`.`type` = 'SLUG' " .
				"AND `term_id` = `{$term_table}`.`id` " .
				"AND `post_id` = `{$post_table}`.`id` " .
				"AND (`title` LIKE ? OR `output` LIKE ? )";
		
		$stmt = $this->dbhandle->prepare($query);
		$stmt->bindValue( 1, $term, PDO::PARAM_STR );
		$stmt->bindValue( 2, $term, PDO::PARAM_STR );
		$stmt->execute();
		$posts = $stmt->fetchAll( PDO::FETCH_ASSOC );

		return $posts;
	}
	
	public function build_post_query( $attributes, $keys ){
		$use_terms;
		$use_users;
		foreach($attributes as &$attribute){
			if(in_array($attribute,self::$term_attributes)){
				$use_terms = true;
			}elseif(in_array($attribute,self::$user_attributes)){
				$use_users = true;
			}
		}
		
		
		$SELECT = "";
		$FROM = "";
	}
	
	public function query_options(){
		$options_table = &$this->tables['options'];
		
		$query = "SELECT option_name, option_value " . 
				"FROM `{$options_table}`";
		
		$stmt = $this->dbhandle->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll( PDO::FETCH_ASSOC );
	}
	
	public function query_term( $term, $type ){
		$term_table = &$this->tables['terms'];
		$term_relations  = &$this->tables['term_relations'];
		
		$query = "SELECT `post_id` " .
				"FROM `{$term_table}` JOIN `{$term_relations}` " .
				"WHERE `{$term_table}`.`id` = `term_id` " .
				"AND `type` = ? " .
				"AND `slug` = ? ";
		
		$stmt = $this->dbhandle->prepare( $query );
		$stmt->bindValue( 1, $type, PDO::PARAM_STR );
		$stmt->bindValue( 2, $term, PDO::PARAM_STR );
		
		$stmt->execute();
		return $stmt->fetchColumn();
	}
	
	public function query_posts( $type, $sort_by=null, $limit=null, $index=null ){
		$post_table = &$this->tables['posts'];
		$user_table = &$this->tables['users'];
		$term_table = &$this->tables['terms'];
		$relations  = &$this->tables['term_relations'];
		
		$num_params = (int) isset($limit) + isset($index);
		
		$query = "SELECT `{$post_table}`.`id`, `title`,`excerpt`, " . 
				"    `date`,`slug`,`display_name` as author " .
				"FROM {$post_table} JOIN {$user_table} JOIN {$term_table} JOIN {$relations} " . 
				"WHERE `term_id` = `{$term_table}`.`id` AND `post_id` = `{$post_table}`.`id` " . 
				"AND `{$term_table}`.`type` = 'SLUG' AND `{$post_table}`.`type` = ? " . 
				"AND `user_id` = `{$user_table}`.`id` ";
		// Add sort if requsted
		if(isset($sort_by)){
			$query .= "ORDER BY {$sort_by} ";
		}
		
		// Limit the number of queries
		if($num_params==1){
			$query .= "LIMIT ? ";
		}elseif($num_params==2){
			$query .= "LIMIT ?,? ";
		}
		
		$stmt = $this->dbhandle->prepare( $query );
		$stmt->bindValue( 1, $type, PDO::PARAM_STR );
		if($num_params==1){
			$stmt->bindValue( 2, $limit, PDO::PARAM_INT );
		}elseif($num_params==2){
			$stmt->bindValue( 2, $index, PDO::PARAM_INT );
			$stmt->bindValue( 3, $limit, PDO::PARAM_INT );
		}
		$stmt->execute();
		
		$posts = $stmt->fetchAll( PDO::FETCH_ASSOC );
		return $posts;
	}
	
	public function query_post( $post_id, $get_input = false){
		$post_table = &$this->tables['posts'];
		
		if($get_input){
			$content = "`input`";
		}else{
			$content = "`output`";
		}
		
		$query = "SELECT `id`, `parent`, `title`, `excerpt`, `date`, {$content} " .
				"FROM `{$post_table}` " .
				"WHERE `id` = ? AND `type` = 'POST'";
		
		$stmt = $this->dbhandle->prepare( $query );
		$stmt->bindValue( 1, $post_id, PDO::PARAM_INT );
		$stmt->execute();
		
		$post = $stmt->fetch( PDO::FETCH_ASSOC );
		$post['authors'] = $this->query_authors( $post_id );
		return $post;
	}
	
	public function query_children( $post_id, $type="POST"){
		$post_table = &$this->tables['posts'];
		$term_table = &$this->tables['terms'];
		$relations  = &$this->tables['term_relations'];
		
		$query = "SELECT `{$post_table}`.`id`, `slug`, `title`, `excerpt` " .
				"FROM `{$post_table}` JOIN `{$relations}` JOIN `{$term_table}` " .
				"WHERE `parent` = ? AND `{$post_table}`.`type` = ? " .
				"AND `term_id` = `{$term_table}`.`id` AND `post_id` = `{$post_table}`.id " .
				"AND `{$term_table}`.`type` = 'SLUG' ";

		$stmt = $this->dbhandle->prepare( $query );
		$stmt->bindValue( 1, $post_id, PDO::PARAM_INT );
		$stmt->bindValue( 2, $type, PDO::PARAM_STR );
		$stmt->execute();
		
		$children = $stmt->fetchAll( PDO::FETCH_ASSOC );
		
		return $children;
	}
	
	public function query_authors( $post_id ){
		$user_table = &$this->tables['users'];
		$post_table = &$this->tables['posts'];
		
		$query = "SELECT `display_name` " . 
				"FROM `{$user_table}` JOIN `{$post_table}` " .
				"WHERE `user_id` = `{$user_table}`.`id` " . 
				"AND `type` = 'REVISION' " .
				"AND `{$post_table}`.`parent` = ?";
		
		$stmt = $this->dbhandle->prepare( $query );
		$stmt->bindValue( 1, $post_id, PDO::PARAM_INT );
		$stmt->execute();
		
		$authors = array();
		while($author = $stmt->fetchColumn()){
			$authors[] = $author;
		}
		// Renumber author array, and make sure it's unique
		$authors = array_values( array_unique( $authors ) );
		
		return $authors;
	}
	
	public function query_user( $username ){
		$user_table = &$this->tables['users'];
		
		$query = "SELECT `id`, `username`, `password`, `display_name`, " .
				"     `salt`, `email`, `permission` " .
				"FROM `{$user_table}` " .
				"WHERE `username` = ? " .
				"LIMIT 1";
		
		$stmt = $this->dbhandle->prepare( $query );
		$stmt->bindValue( 1, $username, PDO::PARAM_STR );
		$stmt->execute();
		return $stmt->fetch( PDO::FETCH_ASSOC );
	}
	
	function query_total_posts( $type, $parent=null ){
		$posts_table = &$this->tables['posts'];
		
		$query = "SELECT count(id) " .
				"FROM {$posts_table} " .
				"WHERE type = ? ";
		if(isset($parent))
			$query .= "AND parent = ? ";
		$query .= "LIMIT 1";
		
		$stmt = $this->dbhandle->prepare( $query );
		$stmt->bindValue( 1, $type, PDO::PARAM_STR );
		
		if(isset($parent))
			$stmt->bindValue( 2, $parent, PDO::PARAM_INT );
		
		$stmt->execute();
		
		return $stmt->fetchColumn();
	}
	
	/* Insertions
	 ------------------------------------------------------------------------ */
	
	/**
	 * Inserts a post into the database, and returns the id of the insert
	 * 
	 * @param unknown $post
	 * @return string
	 */
	public function insert_post( $post, $type ){
		$post_table = &$this->tables['posts'];
		
		$params = array(
				":title"  => &$post['title'],
				":parent" => &$post['parent'],
				":excerpt"=> &$post['excerpt'],
				":type"   => $type,
				":input"  => &$post['input'],
				":output" => &$post['output'],
				":date"   => &$post['date'],
				":user_id"=> &$post['user_id']
		);
		
		$query = "INSERT INTO `{$post_table}`(`title`, `parent`, `excerpt`, `type`, `input`, `output`, `date`, `user_id`)" . 
				"VALUES(:title, :parent, :excerpt, :type, :input, :output, :date, :user_id)";
			
		$stmt = $this->dbhandle->prepare( $query );
		$stmt->execute( $params );
			
		$id = $this->dbhandle->lastInsertId();
		
		return $id;

	}
	
	/**
	 * Inserts a term into the database, and returns the id of the insert
	 * 
	 * @param unknown $slug
	 * @param unknown $name
	 * @return string
	 */
	public function insert_term( $slug, $name, $type ){
		$term_table = &$this->tables['terms'];
		
		$query = "INSERT INTO `{$term_table}`(`slug`,`name`, `type`) " .
				"VALUES (?, ?, ?)";
		
		$stmt = $this->dbhandle->prepare( $query );
		$stmt->bindValue( 1, $slug, PDO::PARAM_STR );
		$stmt->bindValue( 2, $name, PDO::PARAM_STR );
		$stmt->bindValue( 3, $type, PDO::PARAM_STR );
		$stmt->execute();
			
		$id = $this->dbhandle->lastInsertId();
			
		return $id;
	}
	
	/**
	 * Inserts a relation into the database
	 * 
	 * @param unknown $term_id
	 * @param unknown $post_id
	 * @param unknown $type
	 */
	public function insert_term_relation( $term_id, $post_id ){
		$relations  = &$this->tables['term_relations'];
		
		$query = "INSERT INTO `{$relations}`(`term_id`,`post_id`,`type`) " .
		"VALUES (?, ?)";
			
		$stmt = $this->dbhandle->prepare( $query );
		$stmt->bindValue( 1, $term_id, PDO::PARAM_INT );
		$stmt->bindValue( 2, $post_id, PDO::PARAM_INT );
		$stmt->execute();
	}
	
	/**
	 * Inserts a user into the database, returning the id
	 * 
	 * @param unknown $user
	 * @return string
	 */
	public function insert_user( $user ){
		$user_table = &$this->tables['users'];
		
		$params = array(
			":username"     => &$user["username"],
			":password"     => &$user["password"],
			":salt"         => &$user["salt"],
			":display_name" => &$user["display_name"],
			":email"        => &$user["email"],
			":permission"   => &$user["permission"]
		);
		
		$query = "INSERT INTO `{$user_table}`(`username`,`password`,`salt`,`display_name`,`email`,`permission`) " .
				"VALUES (:username, :password, :salt, :display_name, :email, :permission)";
		
		$stmt = $this->dbhandle->prepare( $query );
		$stmt->execute( $params );
			
		$id = $this->dbhandle->lastInsertId();
		
		return $id;
	}
	
	/**
	 * Inserts meta content into the database.
	 * 
	 * @param unknown $table
	 * @param unknown $key
	 * @param unknown $value
	 * @return boolean
	 */
	private function insert_meta( $table, $key, $value ){
		if(in_array($table, array_keys($this->tables)))
			return false;

		$meta_table = &$this->tables[$table];
		
		$params = array(
				":meta_key"   => $key,
				":meta_value" => $value
		);
		
		$query = "INSERT INTO `{$meta_table}`(`meta_key`,`meta_value`) " .
		"VALUES (:meta_key, :meta_value)";
		
		$stmt = $this->dbhandle->prepare( $query );
		return $stmt->execute( $params );
	}
	
	/**
	 * Inserts user meta into the database 
	 * 
	 * @param unknown $key
	 * @param unknown $value
	 * @return boolean
	 */
	public function insert_user_meta( $key, $value ){
		return $this->insert_meta( 'user_meta', $key, $value );
	}
	
	/**
	 * Inserts post meta into the database
	 * 
	 * @param unknown $key
	 * @param unknown $value
	 * @return boolean
	 */
	public function insert_post_meta( $key, $value ){
		return $this->insert_meta( 'post_meta', $key, $value );
	}
			
	
	/* Updates
	 ------------------------------------------------------------------------ */
	
	/**
	 * 
	 * @param unknown $post
	 */
	public function update_post( $post, $type ){
		$post_table = &$this->tables['posts'];
		
		$params = array(
				":title"  => &$post['title'],
				":parent" => &$post['parent'],
				":excerpt"=> &$post['excerpt'],
				":type"   => $type,
				":input"  => &$post['input'],
				":output" => &$post['output'],
				":user_id"=> &$post['user_id'],
				":date"   => &$post['date'],
				":id"     => &$post['id']
		);

		$query = "UPDATE `{$post_table}` " .
				"SET `title` = :title, `parent` = :parent, " .
				"    `excerpt` = :excerpt, `type` = :type, " .
				"    `input` = :input, `output` = :output, " .
				"    `user_id` = :user_id, `date` = :date " .
				"WHERE `id` = :id";

		$stmt = $this->dbhandle->prepare( $query );
		return $stmt->execute( $params );
	}
	
	/**
	 * 
	 * @param unknown $post_id
	 * @param unknown $slug
	 * @param unknown $name
	 * @return boolean
	 */
	public function update_slug( $post_id, $slug, $name ){
		$relations = &$this->tables['term_relations'];
		$term_table = &$this->tables['terms'];
		
		$params = array(
			":post_id" => $post_id,
			":slug"    => $slug,
			":name"    => $name
		);
		
		$query = "UPDATE `{$term_table}` JOIN `{$relations}` " .
				"SET `slug` = :slug, `name` = :name " .
				"WHERE `type` = 'SLUG' " .
				"AND `term_id` = `id`  " . 
				"AND `post_id` = :post_id ";
		
		$stmt = $this->dbhandle->prepare( $query );
		return $stmt->execute( $params );
	}
	
	/**
	 * 
	 * @param unknown $term_id
	 * @param unknown $slug
	 * @param unknown $name
	 */
	public function update_term( $term_id, $slug, $name ){
		$term_table = &$this->tables['terms'];
		
		$params = array(
				":id"   => $term_id,
				":slug" => $slug,
				":name" => $name,
				":type" => $type
		);
		
		$query = "UPDATE `{$term_table}` " .
		"SET `slug` = :slug, `name` = :name " .
		"WHERE `id` = :id ";
		
		$stmt = $this->dbhandle->prepare( $query );
		return $stmt->execute( $params );
	}

	/**
	 * 
	 * @param unknown $table
	 * @param unknown $key
	 * @param unknown $value
	 * @return boolean
	 */
	private function update_meta( $table, $key , $value ){
		if(in_array($table, array_keys($this->tables)))
			return false;
	
		$meta_table = &$this->tables[$table];
	
		$query = "UPDATE {$meta_table} " .
				"SET meta_value = :meta_value " .
				"WHERE meta_key = :meta_key";
	
		$stmt = $this->dbhandle->prepare( $query );
		return $stmt->execute( $params );
	
	}
	
	/**
	 * 
	 * @param unknown $key
	 * @param unknown $value
	 * @return boolean
	 */
	public function update_user_meta( $key, $value ){
		return $this->update_meta( 'user_meta', $key, $value );
	}
	
	/**
	 * 
	 * @param unknown $key
	 * @param unknown $value
	 * @return boolean
	 */
	public function update_post_meta( $key, $value ){
		return $this->update_meta( 'post_meta', $key, $value );
	}
	
	/* Deletion
	 ------------------------------------------------------------------------ */
	
	/**
	 * 
	 * @param unknown $id
	 * @return boolean
	 */
	public function delete_post( $id ){
		$post_table = &$this->tables['posts'];
		$query = "DELETE FROM {$post_table} " . 
				"WHERE id = ?";
		
		$stmt = $this->dbhandle->prepare( $query );
		$stmt->bindValue( 1, $id, PDO::PARAM_INT );
		return $stmt->execute();
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @return boolean
	 */
	public function delete_user( $id ){
		$user_table = &$this->tables['users'];
		$query = "DELETE FROM {$user_table} " .
				"WHERE id = ?";
	
		$stmt = $this->dbhandle->prepare( $query );
		$stmt->bindValue( 1, $id, PDO::PARAM_INT );
		return $stmt->execute();
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @return boolean
	 */
	public function delete_term( $id ){
		$term_table = &$this->tables['terms'];
		$query = "DELETE FROM {$term_table} " .
				"WHERE id = ?";
	
		$stmt = $this->dbhandle->prepare( $query );
		$stmt->bindValue( 1, $id, PDO::PARAM_INT );
		return $stmt->execute();
	}	
	
	/* Existence
	 ------------------------------------------------------------------------ */
	
	/**
	 * 
	 * @param unknown $user
	 * @return boolean
	 */
	public function user_exists( $user ){
		$user_table = &$this->tables['users'];
		if(is_string( $user )){
			$result = $this->value_exists( $user_table, "username", $user );
		}else{
			$result = $this->value_exists( $user_table, "id", $user );
		}
		return (bool) $result;
	}
	/**
	 * 
	 * @param unknown $post_id
	 * @return boolean
	 */
	public function post_exists( $post_id ){
		$post_table = &$this->tables['posts'];
		$result = $this->value_exists( $post_table, "id", $post_id );
		
		return (bool) $result;
	}
	
	/**
	 * 
	 * @param unknown $slug
	 * @return boolean
	 */
	public function term_exists( $slug ){
		$term_table = &$this->tables['terms'];
		$result = $this->value_exists( $term_table, "slug", $slug );
		
		return (bool) $result;
	}
	
	/**
	 * 
	 * @param unknown $table
	 * @param unknown $key
	 * @return boolean
	 */
	private function meta_exists( $table, $key ){
		if(in_array($table, array_keys($this->tables)))
			return false;
	
		$meta_table = &$this->tables[$table];
		$result = $this->value_exists( $meta_table, "meta_key", $key );
		
		return (bool) $result;
	}
	
	/**
	 * 
	 * @param unknown $key
	 * @return boolean
	 */
	public function user_meta_exists( $key ){
		return (bool) $this->meta_exists('user_meta', $key);
	}
	
	/**
	 * 
	 * @param unknown $key
	 * @return boolean
	 */
	public function post_meta_exists( $key ){
		return (bool) $this->meta_exists('post_meta', $key);
	}
	
}