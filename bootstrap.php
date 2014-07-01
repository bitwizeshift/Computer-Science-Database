<?php
/**
 * Bootstraps all the required modules together, and provides
 * the basic framework for this system to work together.
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.1 2014-06-30
 */

/** Define ROOT as the root of the installation */
define('ROOT', dirname(__FILE__) . '/');

/** Define SRC as the main src directory */
define('SRC', ROOT . 'static/src/');

/** Define INCPATH as the include path */
define('INCPATH', 'includes/');

/** Define BASE as the server-located directory */
define('BASE', 'http://' . $_SERVER['HTTP_HOST'] . '/ucsd/');

/**
 * 
 */
function generate_page($page_info){
	$GLOBALS['article'] = new Article($page_info);
}

/**
 * Includes a resource using require_once. 
 * 
 * @since 0.1
 * @param string $file filename
 */
function require_resource( $file ){
	require_once( SRC . INCPATH . $file );
}

/**
 * Includes a resource using include_once. 
 * 
 * @since 0.1
 * @param string $file filename
 */
function include_resource( $file ){
	include_once( SRC . INCPATH . $file );
}

/**
 * Load the correct Database file
 * 
 * This function is used to set the database class at runtime. It
 * lazyloads the database to insure that only one instance is running
 * at any given time. The variable $csdb is globalized for access
 * throughout all the subsystems.
 * 
 * @since 0.1
 * @global $csdb Database Object
 */
function require_db(){
	global $csdb;

	require_resource('db.class.php');
	if ( isset( $csdb ) )
		return;
	$GLOBALS['csdb'] = new Connection("settings.ini");
}

/**
 * Initializes the entire framework, along with all related global
 * values that should be initialized.
 * 
 * This function MUST be called once in order for all the related
 * files to be loaded.
 * 
 * @since 0.1
 */
function init_framework(){
	// Initialize database connections
	require_db();
	// Initialize version information
	require_resource('version.php');
	// Add page element functions
	require_resource('elements.php');
	// Add session functions
	require_resource('session.php');
	// Add remaining miscellaneous functional features
	require_resource('functions.php');	
}