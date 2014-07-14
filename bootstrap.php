<?php
/**
 * Bootstraps all the required modules together, and provides
 * the basic framework for this system to work together.
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.2 2014-07-03
 * 
 * @package 
 */
// Start the session
session_start();

// Enable error reporting
error_reporting(E_ALL);
#error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );
ini_set('display_errors','1');

/* Include the configuration file, if it exists */
if(file_exists( dirname(__FILE__) . '/configurations.php')){
	require_once( dirname(__FILE__) . '/configurations.php' );
}

/* Define all the path constants to use in the system */
require_once( dirname(__FILE__) . '/path-constants.php');


// Set timezone information
#date_default_timezone_set( 'UTC' );

// Include files required for initialization first
require_once( INCLUDE_PATH . 'version.php');
require_once( INCLUDE_PATH . 'default-constants.php');

// Set up default constants

require_once( INCLUDE_PATH . 'load.php'); 

// Prepare connections and default information
load_database();
load_asset_manager();
load_site_info();


require( INCLUDE_PATH . 'session.php' );
require( INCLUDE_PATH . 'template.php' );
require( INCLUDE_PATH . 'template-loader.php' );
require( INCLUDE_PATH . 'template-general.php' );
require( INCLUDE_PATH . 'template-link.php' );

// Include 
require( INCLUDE_PATH . 'view.interface.php' );
require( INCLUDE_PATH . 'page.class.php' );
require( INCLUDE_PATH . 'article.class.php' );
require( INCLUDE_PATH . 'functions.php' );


