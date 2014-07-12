<?php 
/**
 * This unit provides all the basic required features for the CMS's article
 * management. It includes features for checking the type of accessed page
 * (article, home, or error), accessing the header/footer/content, and
 * generating various page-related elements such as breadcrumbs and dynamic
 * navigation systems.
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.1 2014-06-30
 */

// Home page data
$home_data['title'] = "Home";
$home_data['description'] = "Homepage of UCSD";
$home_data['resource'] = "home.php";
$home_data['authors'] = array('Matthew Rodusek');
$home_data['is_home'] = true;

// About page data
$about_data['title'] = "About";
$about_data['description'] = "About UCSD";
$about_data['resource'] = "about.php";
$about_data['authors'] = array('Matthew Rodusek');

// Search page
$search_data['title'] = "Search";
$search_data['description'] = "Search the database";
$search_data['resource'] = "search.php";
$search_data['authors'] = array("Matthew Rodusek");

// 404 page data
$error_data['title'] = "404: Not Found";
$error_data['description'] = "Error 404: File not found";
$error_data['resource'] = "404.php";
$error_data['authors'] = array("Matthew Rodusek");
$error_data['is_404'] = true;

// Register the pages
register_page( "home", $home_data );
register_page( "about", $about_data );
register_page( "search", $search_data );
register_page( "404", $error_data );

/**
 * Registers a page in the system
 *
 * @param string $page the name for the page (the URL)
 * @param mixed $page_data Associative array containing page data to register
 * @global $g_pages Hashmap of Page objects in the form of slug => Page()
 */
function register_page( $page, $page_data ){
	global $g_pages;

	$GLOBALS['g_pages'][$page] = new Page( $page_data );
}

/**
 * Determine if SSL is used.
 *
 * @since 0.3
 *
 * @return bool True if SSL, false if not used.
 */
function is_ssl() {
	if ( isset($_SERVER['HTTPS']) ) {
		if ( strtolower($_SERVER['HTTPS']) == 'on' )
			return true;
		if ( $_SERVER['HTTPS'] == '1' )
			return true;
	} else if ( isset($_SERVER['SERVER_PORT']) && ( $_SERVER['SERVER_PORT'] == '443') ) {
		return true;
	}
	return false;
}
 
?>