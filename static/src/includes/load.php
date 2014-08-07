<?php
/**
 * 
 */

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
	global $query;

	require_once( INCLUDE_PATH . 'connection.class.php' );
	require_once( INCLUDE_PATH . 'query.class.php');
	if ( isset( $query ) )
		return;
	$GLOBALS['query'] = new Query('settings.ini');
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
	global $siteinfo, $query;
	
	$options = $query->query_options();
	
	foreach( (array) $options as &$option){
		$siteinfo[$option['option_name']] = $option['option_value'];
	}	
}

/**
 * Load the query information
 * 
 */
function load_query_information(){
	global $query_info;
	
	$defaults = array("p"              => 1,
					  "posts_per_page" => 10,
					  "page"           => "home",
					  "id"             => null,
					  "slug"           => null,
					  "search"         => null,
					  "sortby"         => "date");
	
	$GLOBALS['query_info'] = parse_args($_GET, $defaults);
	
}

/**
 * Initializes required global variables for the currently requested page.
 *
 * @global $g_view The current View
 * @global $g_pages The map of all static pages
 */
function load_current_view(){
	global $g_view, $g_pages, $query;

	// Store page and slug information
	$page = (isset($_GET['page']) ? $_GET['page'] : 'home');
	$slug = (isset($_GET['slug']) ? $_GET['slug'] : null );
	
	
	// If an article is specified
	if( $page=='article' && $slug != null ){
		$result = $query->get_posts( array('slug'=>$slug), array('id'), null,1);
		$id = isset($result[0]['id'])?$result[0]['id']:null;
		//$id = $query->query_term( $slug, "SLUG" );
		if($id){
			$GLOBALS['g_view'] = new Article( (int) $id );
		}else{
			$GLOBALS['g_view'] = $GLOBALS['g_pages']['404'];
		}
		// If the pages
	}elseif( isset($GLOBALS['g_pages'][$page]) ){
		$GLOBALS['g_view'] = $GLOBALS['g_pages'][$page];
	}else{
		$GLOBALS['g_view'] = $GLOBALS['g_pages']['404'];
	}
}

function load_page(){
	global $g_view;
	load_current_view();
	include( THEME_PATH . $g_view->get_resource());
}