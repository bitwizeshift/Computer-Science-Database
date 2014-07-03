<?php
/**
 * Bootstraps all the required modules together, and provides
 * the basic framework for this system to work together.
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.2 2014-07-03
 */

/** Define ROOT as the root of the installation */
define('ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

/** Define SRC as the main src directory */
define('SRC', ROOT . 'static' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR);

/** Define INCPATH as the include path (from the src directory) */
define('INCPATH', 'includes' . DIRECTORY_SEPARATOR);

/** Define SITENAME as the name of the website */
define('SITENAME', 'UCSD');

# Initialize the framework exactly once
if(!defined("INITIALIZED"))
	init_framework();	

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
 * Generates page data for static pages (Non-article pages).
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

function require_theme_resource( $file ){
	
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
function require_database(){
	global $csdb;

	require_resource('db.class.php');
	if ( isset( $csdb ) )
		return;
	$GLOBALS['csdb'] = new Connection("settings.ini");
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
 * @global $asset AssetManager Object
 */
function require_asset_manager(){
	global $asset;
	
	require_resource('asset.class.php');
	if( isset( $asset ) )
		return;
	$GLOBALS['asset'] = new AssetManager('assets');
	
}

/**
 * Initializes the entire framework, along with all related global
 * values that should be initialized.
 * 
 * This function MUST be called once in order for all the related
 * files to be loaded.
 * 
 * @global $g_page The page name
 * @global $g_slug The article slug (should be null for page!=article)
 * @since 0.1
 */
function init_framework(){
	define("INITIALIZED",true);
	
	global $g_page, $g_slug;

	# Store global values
	$GLOBALS['g_page'] = $_GET['page'];
	$GLOBALS['g_slug'] = $_GET['slug'];

	// Initialize database connections
	require_database();
	// Initialize asset manager
	require_asset_manager();

	// Initialize version information
	require_resource('version.php');
	// Add page element functions
	require_resource('elements.php');
	// Add session functions
	require_resource('session.php');
	// Add remaining miscellaneous functional features
	include_resource('functions.php');	
}