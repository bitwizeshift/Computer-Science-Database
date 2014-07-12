<?php
/**
 * 
 */

/* Existence functions (for convenience)
 -------------------------------------------------------------------------- */

/**
 * Check if normal resource exists
 *
 * @param string $resource the name of the resource
 * @return boolean true if file exists, false otherwise
 * @since 0.2
 */
function resource_exists( $resource ){
	return file_exists( INCLUDE_PATH . $resource );
}

/**
 * Check if theme resource exists
 *
 * @param string $resource the name of the resource
 * @return boolean true if file exists, false otherwise
 * @since 0.2
 */
function theme_resource_exists( $resource ){
	return file_exists( THEME_PATH . $resource );
}
/**
 * Check if admin resource exists
 *
 * @param string $resource the name of the resource
 * @return boolean true if file exists, false otherwise
 * @since 0.2
 */
function admin_resource_exists( $resource ){
	return file_exists( ADMIN_PATH . $resource );
}

/* Object loading/initializing
 -------------------------------------------------------------------------- */

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

	require_once( INCLUDE_PATH . 'db.class.php');
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

	require_once( INCLUDE_PATH .'asset.class.php');
	if( isset( $g_asset ) )
		return;
	$GLOBALS['g_asset'] = new AssetManager('assets');
}

/**
 * Load the site information.
 * 
 * @since 0.3
 * @global $siteinfo associative array of site information
 */
function load_site_info(){
	global $siteinfo, $g_db;
	
	$result = $g_db->query("SELECT option_name, option_value FROM ucsd_options");
	
	foreach($result as $row){
		$siteinfo[$row['option_name']] = $row['option_value'];
	}	
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

function load_page(){
	global $g_view;
	load_current_view();
	require( THEME_PATH . $g_view->get_resource());
}