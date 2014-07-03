<?php
/**
 * The Article class
 * 
 * @since 1.0
 */
class Article{
	
	/** The query for gathering content */
	private static $CONTENT_QUERY = "";
	/** The query for finding children  */
	private static $CHILDREN_QUERY = "";
	/** The query for finding ancestors */
	private static $ANCESTOR_QUERY = "";
	/** The query for gathering history */
	private static $HISTORY_QUERY = "";
	
	/** 
	 * Is the current page an article? 
	 * 
	 * @var boolean true if article
	 */
	private $is_article = false;
	/** 
	 * Is the current page a static page?* 
	 * 
	 * @var boolean true if static page
	 */
	private $is_page = false;
	/** 
	 * Is the current page the homepage?
	 * 
	 * @var boolean true if homepage
	 */
	private $is_home = false;
	/** 
	 * Is the current page a 404 error? 
	 * 
	 * @var boolean true if 404 error
	 */
	private $is_404 = false;
	/** 
	 * Is the current page the admin page? 
	 * 
	 * @var boolean true if admin page
	 */
	private $is_admin = false;
	
	/** 
	 * Title of the article
	 * 
	 *  @var string The title of the article
	 */
	private $title = "";
	/** 
	 * Excerpt of the article 
	 * 
	 * @var string finite sized excerpt from content
	 */
	private $excerpt = "";
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
	private $authors = array();
	/** 
	 * History of edits 
	 * 
	 * @var multitype associative array of (iso-date string->author name)
	 */
	private $history = array();
	/**
	 * Tags related to this article
	 *
	 * @var array strings containing tags
	 */
	private $tags = array();
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
	// -----------------------------------------------------------------------
	
	/**
	 * 
	 */
	public function __construct($article_info=null){
		register_shutdown_function( array( $this, '__destruct' ) );
		if(!empty($article_info)){
			$this->_parse_article_info($article_info);
		}else{
			$this->_access_article_data();
		}
	}
	
	/**
	 * Parse the article info content 
	 * 
	 * @param mixed $article_info
	 */
	private function _parse_article_info(&$article_info){
		// Check if title is set
		if(isset($article_info['title'])){
			$this->title = $article_info['title'];
		}
		// Check if Excerpt is set
		if(isset($article_info['excerpt'])){
			$this->excerpt = $article_info['excerpt'];
		}
		// Check if authors is set
		if(isset($article_info['authors'])){
			$this->authors = $article_info['authors'];
		}else{
			$this->authors = array("Matthew Rodusek");
		}
		// Check if is_home is set
		if(isset($article_info['is_home'])){
			$this->is_home = $article_info['is_home'];
		}
		// Check if is_admin is set
		if(isset($article_info['is_admin'])){
			$this->is_admin = $article_info['is_admin']; 
		}
		// Check if is_404 is set
		if(isset($article_info['is_404'])){
			$this->is_404 = $article_info['is_404'];
		}
		
		$this->is_page = true;
		
		// Verify that the values don't conflict
		if(!$this->_valid_values()){
			// @TODO: Handle errors
		}
	}
	
	/**
	 * Validates the article's values. Throws error if one occurs.
	 * 
	 * @return boolean true if values are valid
	 */
	private function _valid_values(){
		return true;
	}
	
	/**
	 * Gathers article information from the database connection,
	 * populating the attributes for this class.
	 */
	private function _access_article_data(){
		global $csdb;
		$slug = $_GET['slug'];
		
		// If no article specified (e.g. http://example.com/article/
		if(!isset($slug)){
			header("Location: " . BASE);
			exit();
		}
		
		
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function __destruct(){
		return true;
	}
	
	// -----------------------------------------------------------------------
	
	/**
	 * Get the title of this article
	 * 
	 * @return string
	 */
	public function get_title(){
		return (string) $this->title;
	}
	
	/**
	 * Get the excerpt of this article
	 * 
	 * @return string
	 */
	public function get_excerpt(){
		return (string) $this->excerpt;
	}
	
	/**
	 * Get the list of authors for this article
	 * 
	 * @return array
	 */
	public function get_authors(){
		return (array) $this->authors;
	}
	
	/**
	 * Get the raw, unparsed MarkDown content
	 * 
	 * @return string
	 */
	public function get_raw_content(){
		return (string) $this->raw_content;
	}
	
	/**
	 * Get the parsed HTML content
	 * 
	 * @return string
	 */
	public function get_parsed_content(){
		return (string) $this->parsed_content;
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
	
	// -----------------------------------------------------------------------
	
	/**
	 * Is the page a 404 error?
	 * 
	 * @return boolean true if 404, false otherwise
	 */
	public function is_404(){
		return (bool) $this->is_404;
	}
	
	/**
	 * Is the page the home page?
	 * 
	 * @return boolean true if home page, false otherwise
	 */
	public function is_home(){
		return (bool) $this->is_home;
	}
	
	/**
	 * Is the page a static web page?
	 * 
	 * @return boolean true if static page, false otherwise
	 */
	public function is_page(){
		return (bool) $this->is_page;
	}
	
	/**
	 * Is the page an article page?
	 * 
	 * @return boolean true if article, false otherwise
	 */
	public function is_article(){
		return (bool) $this->is_article;
	}
}
?>