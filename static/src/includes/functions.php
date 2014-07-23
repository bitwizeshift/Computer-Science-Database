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

/**
 * Converts a date served from MySQL into a readable string date format
 *
 * @param string $format Format of the date to return.
 * @param string $date Date string from mysql to convert
 * @return string|int Formatted date string, or Unix timestamp.
 */
function mysql_to_date($format, $date){
	if(empty( $date ))
		return null;
	
	if($format=='G')
		return strtotime( $date . ' +0000' );
	
	$time = strtotime( $date );
	
	if($format=='U')
		return $time;
	
	return date( $format, $date );
}

function current_time( $type, $gmt = 0 ) {
	global $siteinfo;
	switch ( $type ) {
		case 'mysql':
			return ( $gmt ) ? gmdate( 'Y-m-d H:i:s' ) : gmdate( 'Y-m-d H:i:s', ( time() + ( $siteinfo['gmt_offset'] * HOUR_IN_SECONDS ) ) );
		case 'timestamp':
			return ( $gmt ) ? time() : time() + ( $siteinfo['gmt_offset'] * HOUR_IN_SECONDS );
		default:
			return ( $gmt ) ? date( $type ) : date( $type, time() + ( $siteinfo['gmt_offset'] * HOUR_IN_SECONDS ) );
	}
}
/**
 * Hides details of the string past $visible_length from the user.
 * 
 * Possible uses are:
 * 
 * $password = "12345abcde"
 * hide_string( $password, 4 );
 * > "1234******"
 * 
 * @param unknown $string
 * @param unknown $visible_length
 * @param string $fill
 * @return string
 */
function hide_string( $string, $visible_length, $fill = "*"){
	return substr( $string,0,$visible_length ) . str_repeat( $fill, (strlen($string)-$visible_length ) );
}

/**
 * Parses arguments into a single string containing values.
 *
 * @param object|array|string $args argument to parse
 * @param string $separator[optional]
 * @param string $before[optional]
 * @param string $after[optional]
 * @return array containing all the passed values
 */

function args_to_string( $args,  $separator=',', $before='', $after=''){
	if( is_object( $args ) ){
		$arr = get_object_vars( $args );
	}elseif( is_array( $args )){
		$arr = &$args;
	}else{
		$arr = (array) $args;
	}
	return $before . implode( $separator, $arr ) . $after;
}

/**
 * Parses arguments into a single array. 
 * 
 * @param object|array|string $args argument to parse
 * @param array $defaults[optional] default values for args
 * @return array containing all the passed values
 */
function parse_args( $args, $defaults = null ) {
	if( is_object( $args ) ){
		$r = get_object_vars( $args );
	}elseif( is_array( $args ) ){
		$r = &$args;
	}else{
		parse_str( $args, $r );
	}
	if ( is_array( $defaults ) ){
		return array_merge( $defaults, $r );
	}
	return $r;
}
 
?>