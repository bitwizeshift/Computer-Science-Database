<?php
/**
 * The Article class
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.2 2014-07-03
 */
class Article implements View{
		
	/** 
	 * Is the current page an article? 
	 * 
	 * @var boolean true if article
	 */
	private $is_article = false;
	
	/** 
	 * Title of the article
	 * 
	 *  @var string The title of the article
	 */
	private $title = "Untitled";
	/** 
	 * Description of the article 
	 * 
	 * @var string finite sized excerpt from content
	 */
	private $description = "No description";
	/** 
	 * Raw content of the article 
	 * 
	 * @var string bigtext collection of unparsed content
	 */
	private $raw_content = "";
	/** 
	 * Parsed content of the article 
	 * 
	 * @var string bigtext collection of parsed content
	 */
	private $parsed_content = "";
	/** 
	 * Authors of the article 
	 * 
	 * @var array strings containing author names
	 */
	private $authors = array("John Doe");
	/** 
	 * History of edits 
	 * 
	 * @var multitype associative array of (iso-date string->author name)
	 */
	private $history = array();
	/** 
	 * Date initially created 
	 * 
	 * @var string iso-formatted string (yyyy-mm-dd hh:mm:ss)
	 */
	private $date_created = "1970-01-01 00:00:00";
	/** 
	 * Date last modified 
	 * 
	 * @var string iso-formatted string (yyyy-mm-dd hh:mm:ss)
	 */
	private $date_modified = "1970-01-01 00:00:00";
	/**
	 * The parent article's slug
	 * 
	 * @var string the slug of the parent
	 */
	private $parent = "";
	/**
	 * The array of the children's slugs
	 * 
	 * @var array the string slugs of the children
	 */
	private $children = array();
	
	/* Constructor/Destructor
	 ------------------------------------------------------------------------ */
	
	/**
	 * Constructs the Article object
	 * 
	 * @param string $article_slug The slug of the article
	 */
	public function __construct( $article_slug ){
		register_shutdown_function( array( $this, '__destruct' ) );
		$this->_access_article_data();
	}
	
	/**
	 * Destructs the Article object
	 *
	 * @return boolean
	 */
	public function __destruct(){
		return true;
	}
	

	/**
	 * Gathers article information from the database connection,
	 * populating the attributes for this class.
	 */
	private function _access_article_data(){
		global $g_db;
		
		
	}
	
	/* Getters
	 ------------------------------------------------------------------------ */
	
	/**
	 * Get the title of this article
	 * 
	 * @return string
	 */
	public function get_title(){
		return (string) $this->title;
	}
	
	/**
	 * Get the description of this article
	 * 
	 * @return string the string description 
	 */
	public function get_description(){
		return (string) $this->description;
	}
	
	/**
	 * Get the list of authors for this article
	 * 
	 * @return array list of authors (strings)
	 */
	public function get_authors(){
		return (array) $this->authors;
	}
	
	/**
	 * Get the raw, unparsed MarkDown content
	 * 
	 * @return string the unparsed MarkDown
	 */
	public function get_raw_content(){
		return (string) $this->raw_content;
	}

	/**
	 * Get the parsed HTML content
	 * 
	 * @return string the parsed HTML
	 */
	public function get_parsed_content(){
		return (string) $this->parsed_content;
	}
	
	/**
	 * Gets the path to the resource file. Null for articles
	 *
	 * @return null
	 */
	
	public function get_resource(){
		return "article.php";
	}
	
	/**
	 * Gets the slug of the parent article
	 *
	 * @return string slug of parent
	 */
	public function get_parent(){
		return (string) $this->parent;
	}
	
	/**
	 * Gets the slugs of the child articles
	 *
	 * @return array string slugs of children
	 */
	public function get_children(){
		return (array) $this->children;
	}
	
	/**
	 * Get the edit history. Returns null on Pages
	 *
	 * @return null
	 */
	public function get_history(){
		return (array) $this->history;
	}
	
	/**
	 * Get the edit history 
	 * 
	 * @return mixed associative array of arrays containin (username,date) pairs.
	 */
	public function get_edit_history(){
		return (array) $this->history;
	}
	
	/**
	 * Get the date last modified
	 * 
	 * @return string ISO-formatted date string
	 */
	public function get_date_modified(){
		return (string) $this->date_modified;
	}
	
	/**
	 * Get the date the article was created
	 * 
	 * @return string ISO-formatted date string
	 */
	public function get_date_created(){
		return (string) $this->date_created;
	}
	
	/* Getters
	 ------------------------------------------------------------------------ */
	
	/**
	 * Is the page the home page?
	 *
	 * @return boolean true if home page, false otherwise
	 */
	public function is_home(){
		return false;
	}
	
	/**
	 * Is the page a static web page?
	 *
	 * @return boolean true if static page, false otherwise
	 */
	public function is_page(){
		return false;
	}
	
	/**
	 * Is the page an view page?
	 *
	 * @return boolean true if view, false otherwise
	 */
	public function is_article(){
		return true;
	}
	
	/**
	 * Is the page an admin page?
	 *
	 * @return boolean true if admin page, false otherwise
	 */
	public function is_admin(){
		return false;
	}	
	
	/**
	 * Is the page a 404 error?
	 *
	 * @return boolean true if 404, false otherwise
	 */
	public function is_404(){
		return false;
	}
}
?>