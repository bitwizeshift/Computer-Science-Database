<?php
/**
 * View interface
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.2 2014-07-03
 */
interface View{

	/* Getters
	 ------------------------------------------------------------------------ */
	
	/**
	 * Get the title of this view
	 *
	 * @return string the title of the view
	 */
	public function get_title();
	/**
	 * Get the description of this view
	 *
	 * @return string the string description 
	 */
	public function get_description();
	/**
	 * Get the list of authors for this view
	 *
	 * @return array list of authors (strings)
	 */
	public function get_authors();
	/**
	 * Get the raw HTML content
	 *
	 * @return string the raw HTML content
	 */
	public function get_raw_content();
	/**
	 * Get the parsed HTML content
	 *
	 * @return string the parsed HTML content
	 */
	public function get_parsed_content();
	/**
	 * Gets the path to the resource file
	 * 
	 * @return string path to resource file
	 */
	public function get_resource();
	/**
	 * Gets the slug of the parent view
	 *
	 * @return string slug of parent
	 */
	public function get_parent();
	/**
	 * Gets the slugs of the child views
	 *
	 * @return array string slugs of children
	 */
	public function get_children();
	/**
	 * Get the edit history
	 *
	 * @return mixed associative array of arrays containin (username,date) pairs.
	 */
	public function get_history();
	/**
	 * Get the date last modified
	 *
	 * @return string ISO-formatted date string
	 */
	public function get_date_modified();
	/**
	 * Get the date the view was created
	 *
	 * @return string ISO-formatted date string
	 */
	public function get_date_created();
		
	/* Booleans
	 ------------------------------------------------------------------------ */
	
	/**
	 * Is the page the home page?
	 *
	 * @return boolean true if home page, false otherwise
	 */
	public function is_home();
	/**
	 * Is the page a 404 error?
	 *
	 * @return boolean true if 404, false otherwise
	 */
	public function is_404();
	/**
	 * Is the page a static web page?
	 *
	 * @return boolean true if static page, false otherwise
	 */
	public function is_page();
	/**
	 * Is the page an view page?
	 *
	 * @return boolean true if view, false otherwise
	 */
	public function is_article();
	/**
	 * Is the page an admin page?
	 *
	 * @return boolean true if admin page, false otherwise
	 */
	public function is_admin();
	
}
?>