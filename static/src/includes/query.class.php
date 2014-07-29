<?php

function has_post(){
	
}

function get_posts(){
	
}

function get_post(){
	
}

class Query extends Connection{
	
	/* Sorting constants */
	const SORT_DATE_ASC    = "date ASC";
	const SORT_DATE_DESC   = "date DESC";
	const SORT_TITLE_ASC   = "title ASC";
	const SORT_TITLE_DESC  = "title DESC";
	const SORT_AUTHOR_ASC  = "display_name ASC";
	const SORT_AUTHOR_DESC = "display_name DESC";
	const SORT_LOGIN_ASC   = "username ASC";
	const SORT_LOGIN_DESC  = "username DESC";
	
	/* Sorting (Default DESC) */
	const ORDER_ASC_POST_ID  = 0x01; // 0000 0001
	const ORDER_ASC_DATE     = 0x02; // 0000 0010
	const ORDER_ASC_TITLE    = 0x04; // 0000 0100
	const ORDER_ASC_AUTHOR   = 0x08; // 0000 1000
	
	const ORDER_DESC_POST_ID = 0x10; // 0001 0000
	const ORDER_DESC_DATE    = 0x20; // 0010 0000
	const ORDER_DESC_TITLE   = 0x40; // 0100 0000
	const ORDER_DESC_AUTHOR  = 0x80; // 1000 0000
	
	/* Post types */
	const TYPE_POST       = "POST";
	const TYPE_PRIVATE    = "PRIVATE";
	const TYPE_REVISION   = "REVISION";
	const TYPE_SUGGESTION = "SUGGESTION";
	const TYPE_PAGE       = "PAGES";
	
	/* Term types */
	const TYPE_SLUG       = "SLUG";
	const TYPE_CATEGORY   = "CATEGORY";
	const TYPE_TAG        = "TAG";
		
	/* Table Attributes */
	private static $term_attributes = array(
		"slug","name","type"
	);
	private static $user_attributes = array(
		"username", "password", "salt", "display_name",
		"email", "premissions"
	);
	private static $post_attributes = array(
		"id", "title", "parent", "type", "excerpt",
		"input", "output", "date", "user_id"
	);
	private static $meta_attributes = array(
		"meta_key", "meta_value"
	);
	/* View Attributes */
	private static $post_data_fields = array(
			"id", "parent", "slug", "title", "type",
			"excerpt", "input", "output", "date"
	);
	/* Constructor/Destructor/Initialization
	 ------------------------------------------------------------------------ */
	private static function decode_order_by( $orderby ){
		$orders = array();
		if( ($orderby & self::ORDER_ASC_POST_ID) == self::ORDER_ASC_POST_ID )
			$orders[] = "`id` ASC";
		if( ($orderby & self::ORDER_ASC_DATE) == self::ORDER_ASC_DATE )
			$orders[] = "`date` ASC";
		if( ($orderby & self::ORDER_ASC_TITLE) == self::ORDER_ASC_TITLE )
			$orders[] = "`title` ASC";
		if( ($orderby & self::ORDER_ASC_AUTHOR) == self::ORDER_ASC_AUTHOR )
			$orders[] = "`author` ASC";
		
		if( ($orderby & self::ORDER_DESC_POST_ID) == self::ORDER_DESC_POST_ID )
			$orders[] = "`id` DESC";
		if( ($orderby & self::ORDER_DESC_DATE) == self::ORDER_DESC_DATE )
			$orders[] = "`date` DESC";
		if( ($orderby & self::ORDER_DESC_TITLE) == self::ORDER_DESC_TITLE )
			$orders[] = "`title` DESC";
		if( ($orderby & self::ORDER_DESC_AUTHOR) == self::ORDER_DESC_AUTHOR )
			$orders[] = "`author` DESC";
		return $orders;
	}
	
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
				"user_meta"      => "user_meta",
				"post_data"		 => "post_data",
				"post_authors"	 => "post_authors",
				"post_hierarchy" => "post_hierarchy"
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
	
	/**
	 * 
	 * @param unknown $select
	 * @param unknown $from
	 * @param unknown $where
	 * @return multitype:
	 */
	public function query_builder( $select, $from, $where ){
		$table = &$this->tables[$from];
		$where_str = '';
		$where_arr = array();
		$attributes = array();
		
		foreach( $where as $attribute => $value ){
			$where_arr[] = "`{$attribute}` = ?";
			$attributes[] = $value;
		}
		if(!empty($where_arr))
			$where_str = 'WHERE ' . args_to_string($where_arr, ' AND ');
		
		$query = "SELECT " . args_to_string( $select, '`, `','`','` ') . 
				"FROM `{$table}` " . 
				$where_str;

		$stmt = $this->dbhandle->prepare( $query );
		$i = 1;
		foreach($attributes as &$attribute){
			$stmt->bindValue($i++,$attribute);
		}
		$stmt->execute();
		
		return $stmt->fetchAll( PDO::FETCH_ASSOC );
	}
	
	/**
	 * Gets posts based on the parameters. Key=>Value pairs can be specified 
	 * in $keys to allow for this to query more than just by id, or it can
	 * optionally be null
	 * 
	 * @param array $keys[optional] (key=>value) pairs to search for
	 * @param array $fields[optional] the columns to acquire
	 * @param int $orderby[optional] How it should be sorted
	 * @param array $limit[optional] array of (posts to draw, index to start at)
	 * @return multitype:
	 */
	public function get_posts( $keys=null, $fields=null, $orderby=null, $limit=null ){
		if( $fields === null ) $fields = self::$post_data_fields;
		
		$post_data = $this->tables['post_data'];
		$where_str = "";

		if( $keys !== null ){
			foreach( (array) $keys as $attribute => $value ){
				$attributes[] = "`{$attribute}` " . ($value===null ? 'is ?' : '= ?');
				$values[]     = $value;
			}
			$where_str = 'WHERE ' . args_to_string( $attributes, ' AND ' );
		}
		
		$query = "SELECT " . args_to_string( $fields, '`, `','`','` ') .
				"FROM `{$post_data}` " .
				"{$where_str} ";
		
		// ORDER BY
		if( $orderby !== null ){
			$orders = self::decode_order_by( $orderby );	
			$query .= "ORDER BY " . args_to_string( $orders, ', ','',' ' );
		}
		
		// LIMIT
		if( $limit !== null )
			$query .= "LIMIT " . args_to_string( (array) $limit, ',' );

		$stmt = $this->dbhandle->prepare( $query );
		$i = 1;
		// Bind all the values, if any exist to bind
		if( $keys !== null ){
			foreach( (array) $values as &$value ){
				$stmt->bindValue($i++,$value);
			}
		}

		$stmt->execute();
		return $stmt->fetchAll( PDO::FETCH_ASSOC );
	}
	
	/**
	 * 
	 * @param unknown $post_id
	 * @param string $fields
	 * @return mixed
	 */
	public function get_post( $post_id, $fields=null ){
		if( $fields === null ) $fields = self::$post_data_fields;
		
		$post_data = $this->tables['post_data'];
		
		$query = "SELECT " . args_to_string($fields, '`, `','`','` ') .
				"FROM `{$post_data}` " .
				"WHERE `id` = ?";
		
		$stmt = $this->dbhandle->prepare( $query );
		$stmt->bindValue( 1, $post_id, PDO::PARAM_INT );
		$stmt->execute();
		
		return $stmt->fetch( PDO::FETCH_ASSOC );
	}
	
	/**
	 * 
	 * @param unknown $parent
	 * @param string $fields
	 * @return multitype:
	 */
	public function get_children( $parent, $fields=null ){
		return $this->get_posts( array('parent'=>$parent), $fields );
	}
	
	/**
	 * 
	 * @param unknown $post_id
	 * @return multitype:
	 */
	public function get_authors( $post_id ){
		$author_table = $this->tables['post_authors'];
		
		$query = "SELECT `display_name` " .
				"FROM {$author_table} " .
				"WHERE post_id = ?";
		
		$stmt = $this->dbhandle->prepare( $query );
		$stmt->bindValue( 1, $post_id, PDO::PARAM_INT );
		$stmt->execute();
		
		return $stmt->fetchAll( PDO::FETCH_COLUMN );
	}
	
	public function get_options(){
		$options_table = &$this->tables['options'];
		
		$query = "SELECT `option_name`, `option_value` " .
				"FROM `{$options_table}`";
		
		$stmt = $this->dbhandle->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll( PDO::FETCH_ASSOC );
	}
	
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
	
	public function query_options(){
		$options_table = &$this->tables['options'];
		
		$query = "SELECT `option_name`, `option_value` " . 
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
	
	public function add_new_post( $post, $type=QUERY::TYPE_POST ){
		// Prepare the tables
		$post_table = &$this->tables['posts'];
		$term_table = &$this->tables['terms'];
		$relations  = &$this->tables['term_relations'];
		
		// Prepare the parameters
		$p_params = array(
			":title"  => &$post['title'],
			":parent" => &$post['parent'],
			":excerpt"=> &$post['excerpt'],
			":type"   => $type,
			":input"  => &$post['input'],
			":output" => &$post['output'],
			":date"   => &$post['date'],
			":user_id"=> &$post['user_id']
		);
				
		// Prepare the insert statements
		$p_in = "INSERT INTO `{$post_table}`(`title`, `parent`, `excerpt`, `type`, `input`, `output`, `date`, `user_id`)" . 
				"VALUES(:title, :parent, :excerpt, :type, :input, :output, :date, :user_id)";
		
		$t_in = "INSERT INTO `{$term_table}`(`slug`,`name`, `type`) " .
				"VALUES (?, ?, ?)";
		
		$r_in = "INSERT INTO `{$relations}`(`term_id`,`post_id`) " . 
				"VALUES (?, ?)";
		
		try{
			// Start this transaction
			$this->dbhandle->beginTransaction();
			
			// Add the new post
			$stmt = $this->dbhandle->prepare( $p_in );
			$stmt->execute( $p_params );
			
			$post_id = (int) $this->dbhandle->lastInsertId();
			
			// Add the new term slug
			$stmt = $this->dbhandle->prepare( $t_in );
			$stmt->bindValue( 1, $post['slug'], PDO::PARAM_STR );
			$stmt->bindValue( 2, $post['title'], PDO::PARAM_STR );
			$stmt->bindValue( 3, 'SLUG', PDO::PARAM_STR );
			$stmt->execute();
			
			$term_id = (int) $this->dbhandle->lastInsertId();
			
			// Add the new relationship between the two
			
			$stmt = $this->dbhandle->prepare( $r_in );
			$stmt->bindValue( 1, $term_id, PDO::PARAM_INT );
			$stmt->bindValue( 2, $post_id, PDO::PARAM_INT );
			$stmt->execute();
			
			// Commit the changes
			$this->dbhandle->commit();
			return true;
		}catch(Exception $e){
			// Rollback changes if an error occurs
			$this->dbhandle->rollBack();
			set_message(Message::SEVERE, $e->getMessage());
			return false;
		}
	}
	
	public function modify_post( $post_id, $post ){
		// Prepare the tables
		$post_table = &$this->tables['posts'];
		$term_table = &$this->tables['terms'];
		$relations  = &$this->tables['term_relations'];
		
		// Prepare the parameters
		$p_params = array(
			":title"  => &$post['title'],
			":parent" => &$post['parent'],
			":excerpt"=> &$post['excerpt'],
			":type"   => Query::TYPE_POST,
			":input"  => &$post['input'],
			":output" => &$post['output'],
			":date"   => &$post['date'],
			":user_id"=> &$post['user_id'],
			":id"     => $post_id
		);
		
		$t_params = array(
			":slug" => &$post['slug'],
			":name" => &$post['title'],
			":id"   => $post_id
		);
		
		// Prepare the insert statements
		$r_in = "INSERT INTO `{$post_table}`(`title`, `parent`, `excerpt`, `type`, `input`, `output`, `date`, `user_id`) " . 
				"SELECT `title`, ? as `id`, `excerpt`,'REVISION' as `type`,`input`,`output`,`date`,`user_id` " .
				"FROM {$post_table} " .
				"WHERE `id` = ? ";
		
		$p_mod = "UPDATE {$post_table} " .
				"SET `title` = :title, `parent` = :parent, " .
				"    `excerpt` = :excerpt, `type` = :type, " .
				"    `input` = :input, `output` = :output, " .
				"    `user_id` = :user_id, `date` = :date "  .
				"WHERE `id` = :id";
		
		$t_mod = "UPDATE {$term_table} JOIN {$relations} " .
				"ON `term_id` = `id` " .
				"SET `slug` = :slug, `name` = :name " .
				"WHERE `post_id` = :id";
		try{
			// Start this transaction
			$this->dbhandle->beginTransaction();
			
			// Insert revision first
			$stmt = $this->dbhandle->prepare( $r_in );
			$stmt->bindValue( 1, $post_id, PDO::PARAM_INT );
			$stmt->bindValue( 2, $post_id, PDO::PARAM_INT );
			$stmt->execute();
			
			// Alter the newest post
			$stmt = $this->dbhandle->prepare( $p_mod );
			$stmt->execute( $p_params );
			
			// Alter the term
			$stmt = $this->dbhandle->prepare( $t_mod );
			$stmt->execute( $t_params );
			
			// Commit the changes
			$this->dbhandle->commit();
			return true;
		}catch(Exception $e){
			$this->dbhandle->rollBack();
			return false;
		}
	}
	
	public function delete_post( $post_id ){
		// Prepare the tables
		$post_table = &$this->tables['posts'];
		$term_table = &$this->tables['terms'];
		$relations  = &$this->tables['term_relations'];
		
		$p_del = "DELETE FROM {$post_table} " .
				"WHERE `id` = ?";
				
		$t_del = "DELETE FROM `{$term_table}` \n" .
				"USING `{$term_table}` INNER JOIN {$relations} \n" .
				"ON `term_id` = `id` \n" .
				"WHERE `post_id` = ? AND `type` = 'SLUG'";	
				
		try{
			// Start this transaction
			$this->dbhandle->beginTransaction();

			// Delete the term first (cascading to delete the relation)
			$stmt = $this->dbhandle->prepare( $t_del );
			$stmt->bindvalue( 1, $post_id, PDO::PARAM_INT );
			$stmt->execute();
			
			// Delete the post
			$stmt = $this->dbhandle->prepare( $p_del );
			$stmt->bindValue( 1, $post_id, PDO::PARAM_INT );
			$stmt->execute();
			
			// Commit the changes
			$this->dbhandle->commit();
			return true;
		}catch(Exception $e){
			// Rollback changes if an error occurs
			$this->dbhandle->rollBack();
			set_message(Message::SEVERE, $e->getMessage());
			return false;
		}
	}
	
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
	 * @param unknown $id
	 * @param unknown $type
	 * @return boolean
	 */
	public function change_post_type( $id, $type ){
		$post_table = &$this->tables['posts'];
	
		$params = array(
			":id" => $id,
			":type" => $type
		);
		
		$query = "UPDATE `{$post_table}` " .
				"SET `type` = :type " .
				"WHERE `id` = :id ";
		
		$stmt = $this->dbhandle->prepare( $query );
		return $stmt->execute( $params );
	}
	
	
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
	
	public function term_exists_outside_id( $slug, $post_id ){
		$post_data = &$this->tables['post_data'];
		$query = "SELECT 1 " .
				"FROM {$post_data} " .
				"WHERE slug = ? AND id <> ?";
		$stmt = $this->dbhandle->prepare( $query );
		$stmt->bindValue( 1, $slug, PDO::PARAM_STR );
		$stmt->bindValue( 2, $post_id, PDO::PARAM_INT );
		$stmt->execute();
		return (bool) $stmt->fetchColumn();
	}
	
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