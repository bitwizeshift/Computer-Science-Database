<?php
/**
 * 
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.2 2014-07-03
 */
class Page implements View{
	/**
	 * Is the current page a 404 page?*
	 *
	 * @var boolean true if static page
	 */
	private $is_404 = false;
	/**
	 * Is the current page the homepage?
	 *
	 * @var boolean true if homepage
	 */
	private $is_home = false;
	/**
	 * Is the current page an admin page?
	 * 
	 * @var boolean true if admin page
	 */
	private $is_admin = false;
	/**
	 * Title of the article
	 *
	 *  @var string The title of the article
	 */
	private $title = "Untitled";
	/**
	 * Description of the page
	 *
	 * @var string finite sized excerpt from content
	 */
	private $description = "No description";
	/**
	 * Path to the resource (from theme directory)
	 * 
	 * @var string path to the resource
	 */
	private $resource = "";
	/** 
	 * Author(s) of the page
	 * 
	 * @var array strings containing author names
	 */
	private $authors = array("John Doe");
	/** 
	 * Date initially created 
	 * 
	 * @var string iso-formatted string (yyyy-mm-dd hh:mm:ss)
	 */
	private $date_created = "1970-01-01 00:00:00";
	
	/* Constructor/Destructor
	 ------------------------------------------------------------------------ */
	
	/**
	 * Constructs the Page object
	 * 
	 */
	public function __construct( $page_info ){
		register_shutdown_function( array( $this, '__destruct' ) );
		$this->_parse_page_info($page_info);
	}
	
	/**
	 * Destructs the Page object
	 *
	 * @return boolean
	 */
	public function __destruct( ){
		return true;
	}
	
	/**
	 * Parse the page info content 
	 * 
	 * @param mixed $page_info 
	 */
	private function _parse_page_info( $page_info ){
		if(!isset($page_info['resource']))
			throw new BadMethodCallException("Required argument 'resource' not specified");
		
		$this->resource = $page_info['resource'];

		// Check if title is set
		if(isset($page_info['title'])){
			$this->title = $page_info['title'];
		}
		// Check if Description is set
		if(isset($page_info['description'])){
			$this->description = $page_info['description'];
		}
		// Check if authors is set
		if(isset($page_info['authors'])){
			$this->authors = $page_info['authors'];
		}
		// Check if is_home is set
		if(isset($page_info['is_home'])){
			$this->is_home = $page_info['is_home'];
		}
		// Check if is_admin is set
		if(isset($page_info['is_admin'])){
			$this->is_admin = $page_info['is_admin'];
		}
		// Check if is_404 is set
		if(isset($page_info['is_404'])){
			$this->is_404 = $page_info['is_404'];
		}
		if(!$this->_valid_values())
			throw new IllegalArgumentException("Page can only be one of 404, admin, or home");
		
	}
	
	/**
	 * Validates the article's values. Throws error if one occurs.
	 *
	 * @return boolean true if values are valid
	 */
	private function _valid_values(){
		$result = !(($this->is_home && $this->is_admin) ||
			($this->is_admin && $this->is_404) ||
			($this->is_404 && $this->is_home));
		return (bool) $result;
	}
	
	
	/* Getters
	 ------------------------------------------------------------------------ */
	
	/**
	 * Get the title of this view
	 *
	 * @return string the title of the view
	 */
	public function get_title(){
		return (string) $this->title;
	}
	/**
	 * Get the description of this view
	 *
	 * @return string the string description 
	 */
	public function get_description(){
		return (string) $this->description;
	}
	/**
	 * Get the list of authors for this view
	 *
	 * @return array list of authors (strings)
	 */
	public function get_authors(){
		return (array) $this->authors;
	}
	/**
	 * Get the raw HTML content. Returns an empty string on Pages
	 *
	 * @return string an empty string
	 */
	public function get_raw_content(){
		return "";
	}
	/**
	 * Get the parsed HTML content. Returns an empty string on Pages
	 *
	 * @return string an empty string
	 */
	public function get_parsed_content(){
		return "";
	}
	/**
	 * Gets the path to the resource file
	 * 
	 * @return string path to resource file
	 */
	public function get_resource(){
		return (string) $this->resource;
	}
	/**
	 * Gets the slug of the parent article. Returns null on Pages
	 *
	 * @return null
	 */
	public function get_parent(){
		return null;
	}
	/**
	 * Gets the slugs of the child articles. Returns null on Pages
	 *
	 * @return null
	 */
	public function get_children(){
		return null;
	}
	/**
	 * Get the edit history. Returns null on Pages
	 *
	 * @return null
	 */
	public function get_history(){
		return null;
	}
	/**
	 * Get the date the view was created
	 *
	 * @return string ISO-formatted date string
	 */
	public function get_date_created(){
		return (string) $this->date_created;
	}
	/**
	 * Get the date last modified
	 *
	 * @return string ISO-formatted date string
	 */
	public function get_date_modified(){
		return date("F d Y H:i:s.", getlastmod());
	}
	
	/* Booleans
	 ------------------------------------------------------------------------ */
	
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
		return true;
	}
	
	/**
	 * Is the page an view page?
	 *
	 * @return boolean true if view, false otherwise
	 */
	public function is_article(){
		return false;
	}
	
	/**
	 * Is the page an admin page?
	 *
	 * @return boolean true if admin page, false otherwise
	 */
	public function is_admin(){
		return (bool) $this->is_admin;
	}

	/**
	 * Is the page a 404 error?
	 *
	 * @return boolean true if 404, false otherwise
	 */
	public function is_404(){
		return (bool) $this->is_404;
	}
}

?>