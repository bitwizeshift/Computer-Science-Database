<?php
/**
 * PAGE_ELEMENTS
 * 
 * Descriptions:
 *   This unit provides all the basic required features for the CMS's article
 *   management. It includes features for checking the type of accessed page
 *   (article, home, or error), accessing the header/footer/content, and 
 *   generating various page-related elements such as breadcrumbs and dynamic
 *   navigation systems.
 * 
 * Structure:
 *   -------------------------------------------------------------------------
 *   $__globals    Global variable definitions
 *   $__content    Content-related functions (header/footer/etc)
 *   $__checks     Page-detail checks
 *   $__navigation	Functions for navigation (breadcrumbs, menus, etc)
 * 
 */

/* __globals
 -------------------------------------------------------------------------- */

$URLBase = "/~rodu4140/";

$slug    = null; // Article slug 
$id      = null; // Article id
$authors = null; // Authors of the article
$title   = null; // Title of the article


/* __content
 -------------------------------------------------------------------------- */

/**
 * Generate the website's header
 */
function the_header(){
	include(__ROOT__ . "header.php");
}

/**
 * Generate the website's footer
 */
function the_footer(){
	include(__ROOT__ . "footer.php");
}

/**
 * Generate the website's page content
 */
function the_content(){
	// Generate different front page for home
	if(is_home()){
		include(__ROOT__ . "home.php");
	}else if(is_404()){
		include(__ROOT__ . "errors/404.php");
	}else{
		// Display article
	}
}

/**
 * Generates and returns the current page title
 */
function get_title(){

}

/* __checks
 -------------------------------------------------------------------------- */

/**
 * Checks whether currently on the homepage
 *
 * @return true if homepage
 */
function is_home(){
	global $id;
	return $id==0;
}

/**
 * Checks whether currently in an article
 *
 * @return true if article
 */
function is_article(){
	return !(is_home() && is_404());
}
/**
 * Checks whether currently serving 404 page
 *
 * @return true if 404 error occurs
 */
function is_404(){
	global $id;
	return $id==-1;
}

/* __navigation
 -------------------------------------------------------------------------- */

/**
 * Creates Breadcrumbs
 *
 *
 */
function create_breadcrumbs(){

}
?>