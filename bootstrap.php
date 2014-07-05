<?php
/**
 * Bootstraps all the required modules together, and provides
 * the basic framework for this system to work together.
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.2 2014-07-03
 */

# Define constants to standardize the system

/** Define ROOT as the root of the installation */
define('ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

/** Define RESOURCE as the static include directory */
define('RESOURCE', ROOT . 'static' . DIRECTORY_SEPARATOR);

/** Define SRC as the main src directory */
define('SRC', RESOURCE . 'src' . DIRECTORY_SEPARATOR);

/** Define INCPATH as the include path (from the src directory) */
define('INCPATH', 'includes' . DIRECTORY_SEPARATOR);

/** Define THEMEPATH as the path to the theme directory */
define('THEMEPATH', 'theme' . DIRECTORY_SEPARATOR);

/** Define SITENAME as the name of the website */
define('SITENAME', 'UCSD');

define('DEBUG',true);

# Initialize the framework exactly once
if(defined(DEBUG)){
	error_reporting(E_ALL);
	ini_set( 'display_errors','1');
}

if(!defined("INITIALIZED"))
	init_framework();	

/* Useful methods and functions
 -------------------------------------------------------------------------- */

/**
 * Generates the URL of the framework installation
 * 
 * @return string the URL of the framework
 */
function get_base_url(){
	$url  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
	$url .= $_SERVER['SERVER_NAME'] . '/';
	$parts = explode("/",ltrim($_SERVER['SCRIPT_NAME'],'/'));
	for($i=0;$i<sizeof($parts)-1;++$i){
		$url .= $parts[$i] . '/';
	}
	
	return $url;
}

/**
 * Get the current URL of the accessed page
 * 
 * @return string the currently accessed URL
 */
function get_current_url(){
	$url =  isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
	$url .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	return $url;
}

/* Resource loading functions (required)
 -------------------------------------------------------------------------- */

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
 * Loads a resource from the include path.
 * 
 * @param string $resource The resource file to load
 * @param bool $required (optional) Is the resource a required? (default: true)
 * @since 0.2
 */
function load_resource( $resource, $required=true ){
	if($required){
		require_once( SRC . INCPATH . $resource );
	}else{
		include_once( SRC . INCPATH . $resource );
	}
}

/**
 * Loads a resource from the theme path.
 * 
 * @param string $resource The resource file to load
 * @param bool $required (optional) Is the resource required? (default: true)
 * @since 0.2
 */
function load_theme_resource( $resource, $required=true ){
	if($required){
		require_once( SRC . THEMEPATH . $resource );
	}else{
		include_once( SRC . THEMEPATH . $resource );
	}
}


/**
 * Load the Database connection
 * 
 * This function is used to set the database class at runtime. It
 * lazyloads the database to insure that only one instance is running
 * at any given time. The variable $csdb is globalized for access
 * throughout all the subsystems.
 * 
 * @since 0.1
 * @global $g_db Database Object
 */
function load_database(){
	global $g_db;

	load_resource('db.class.php', true);
	if ( isset( $g_db ) )
		return;
	$GLOBALS['g_db'] = new Connection("settings.ini");
}

/**
 * Load the Asset Manager
 * 
 * This function is used to generate the manager at runtime online.
 * It lazyloads the AssetManager  to insure that only one instance is
 * running at any given time. The variable $asset is globalized for 
 * access throughout all the subsystems
 * 
 * @since 0.2
 * @global $g_asset AssetManager Object
 */
function load_asset_manager(){
	global $g_asset;
	
	load_resource('asset.class.php', true);
	if( isset( $g_asset ) )
		return;
	$GLOBALS['g_asset'] = new AssetManager('assets');
	
}

/**
 * Initializes required global variables for the currently requested page.
 * 
 * @global $g_view The current View
 * @global $g_pages The map of all static pages
 */
function load_current_view(){
	global $g_view, $g_pages;
	
	// Store page and slug information
	$page = (isset($_GET['page']) ? $_GET['page'] : 'home');
	$slug = (isset($_GET['slug']) ? $_GET['slug'] : null );
	
	// If an article is specified
	if( $page=='article' && $slug != null ){
		$GLOBALS['g_view'] = new Article( $slug );
		// If the article isn't found
		if( $g_view->is_404() ){
			$GLOBALS['g_view'] = $GLOBALS['g_pages']['404'];
		}
		// If the pages
	}elseif( isset($GLOBALS['g_pages'][$page]) ){
		$GLOBALS['g_view'] = $GLOBALS['g_pages'][$page];
		// Otherwise the page must be an error
	}else{
		$GLOBALS['g_view'] = $GLOBALS['g_pages']['404'];
	}
}

function concat_args( array $args ){
	$result = "";
	for($i=0;$i<sizeof($args);$i++){
		$type = gettype($args[$i]);
		switch($type){
		   case "boolean": $arg = $args[$i] ? "true" : "false"; break;
		   case "integer": $arg = "$args[$i]"; break;
		   case "double" : $arg = "$args[$i]"; break;
		   case "string" : $arg = "\"$args[$i]\""; break;
		   case "array"  : $arg = "array(...)"; break;
		   case "object" : $arg = "$args[$i]"; break;
		   case "NULL"   : $arg = "null"; break;
		   default: $arg = "arg"; 
		}
		$result.= $arg;
		if($i<sizeof($args)-1)
			$result.=", ";
	}
	return $result;
}

/**
 * Debug prints the specified function, along with its success
 * 
 * @param callable $function
 * @param unknown $args
 */
function debug_function( callable $function, $args ){
	
	$result = $function . '(' . concat_args($args) . ')';
	printf("<pre style='font-family: \"Courier New\", Courier, monospace'>%-45s ", $result);
	$success = true;
	echo("&#x2713;  ");
	try{
		call_user_func_array( $function, $args );
	}catch(Exception $e){
		$sucess = false;
	}
	if($success){
		echo("&#x2713;");
	}else{
		echo("x");
	}
	echo("</pre>");
}


/**
 * Initializes the entire framework, along with all related global
 * values that should be initialized.
 * 
 * This function MUST be called once in order for all the related
 * files to be loaded.
 * 
 * @since 0.2
 */
function init_framework(){
	define("INITIALIZED",true);
	// Initialize version information
	load_resource('version.php');
	// Initialize database connections
	load_database();
	// Initialize asset manager
	load_asset_manager();
	// Add session functions
	load_resource('session.php');
	// Load resources for View, Article, and Page
	load_resource('view.interface.php');
	load_resource('article.class.php');
	load_resource('page.class.php');
	// Add theme's resource.php first to override built in
	load_theme_resource('functions.php', false);
	// Add non-overridden functions
	load_resource('functions.php');
	// Loads the current view information, populating global variables
	load_current_view();
	// Enable the page template loader
	load_resource("template.php");
	// Finally load the template and display the page
	load_template();
}