<?php
/**
 * Link Template Functions. 
 * 
 * Handles all URL generating functions for the framework.
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.2 2014-07-03
 * 
 * @package 
 * @subpackage Template
 */

/**
 * Retrieve the home url for a given site.
 *
 * Returns the 'home' option with the appropriate protocol, 'https' if
 * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
 * overridden.
 *
 * @since 0.3
 *
 * @param  string $path   (optional) Path relative to the home url.
 * @param  string $scheme (optional) Scheme to give the home url context. Currently 'http', 'https', or 'relative'.
 * @return string Home url link with optional path appended.
 */
function site_url( $path = '', $scheme = null ) {
	global $siteinfo;
	
	if ( ! in_array( $scheme, array( 'http', 'https' ) ) ) {
		if ( is_ssl() )
			$scheme = 'https';
		else
			$scheme = parse_url( $siteinfo['url'], PHP_URL_SCHEME );
	}
	if(!isset($scheme))
		$scheme = 'http';
	$url = "{$scheme}://" . $_SERVER['SERVER_NAME'];
	
	if ( $path && is_string( $path ) )
		$url .= '/' . ltrim( $path, '/' );
	$url .= '/';
	return $url;
}
/**
 * Retrieve the site url for a given site.
 *
 * Returns the site url option with the appropriate protocol, 'https' if
 * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
 * overridden.
 * 
 * @param  string $scheme (optional) Scheme to give the home url context. Currently 'http', 'https', or 'relative'.
 * @return string Site url
 */
function get_site_url( $scheme = null ){
	//$url  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
	//$url .= $_SERVER['SERVER_NAME'];

	return site_url( '', $scheme );
}

/**
 * 
 */
function get_current_url( $scheme = null ){
	return site_url( '', $scheme );
}
/**
 * Retrieve the home url for a given site.
 *
 * Returns the home url option with the appropriate protocol, 'https' if
 * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
 * overridden.
 * 
 * @param  string $scheme (optional) Scheme to give the home url context. Currently 'http', 'https', or 'relative'.
 * @return string Home url
 */
function get_home_url( $scheme = null ){
	
	/*$url  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
	$url .= $_SERVER['SERVER_NAME'] . '/';
	$parts = explode("/",ltrim($_SERVER['SCRIPT_NAME'],'/'));
	for($i=0;$i<sizeof($parts)-1;++$i){
		$url .= $parts[$i] . '/';
	}
	*/
	return site_url( '~rodu4140/test', $scheme );
}

/**
 * Retrieve the home url for a given site.
 *
 * Returns the home url option with the appropriate protocol, 'https' if
 * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
 * overridden.
 *
 * @param  string $scheme (optional) Scheme to give the home url context. Currently 'http', 'https', or 'relative'.
 * @return string Home url
 */
function admin_url(){
	return site_url('admin');
}

/**
 * Retrieve the home url for a given site.
 *
 * Returns the home url option with the appropriate protocol, 'https' if
 * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
 * overridden.
 *
 * @param  string $scheme (optional) Scheme to give the home url context. Currently 'http', 'https', or 'relative'.
 * @return string Home url
 */
function login_url(){
	return site_url('login');
}

/**
 * Retrieve the home url for a given site.
 *
 * Returns the home url option with the appropriate protocol, 'https' if
 * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
 * overridden.
 *
 * @param  string $scheme (optional) Scheme to give the home url context. Currently 'http', 'https', or 'relative'.
 * @return string Home url
 */
function logout_url(){
	return site_url('logout');
}

?>