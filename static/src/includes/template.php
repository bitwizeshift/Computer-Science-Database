<?php
/**
 * Template Functions.
 * 
 * 
 * 
 * @author  Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.2 2014-07-04
 * 
 * @package DevFeed
 * @subpackage Template
 */

/* Getters: Resource
 -------------------------------------------------------------------------- */

/** 
 * Retrieve the name of the highest priority template file that exists.
 *
 * Searches in the STYLESHEETPATH before TEMPLATEPATH so that themes which
 * inherit from a parent theme can just overload one file.
 *
 * @since 0.3
 *
 * @param string|array $template_names Template file(s) to search for, in order.
 * @param bool $load If true the template file will be loaded if it is found.
 * @param bool $require_once Whether to require_once or require. Default true. Has no effect if $load is false.
 * @return string The template filename if one is located.
 */
function locate_template($template_names, $load = false, $require_once = true ) {
	$located = '';
	foreach ( (array) $template_names as $template_name ) {
		if ( !$template_name )
			continue;
		if ( file_exists(SRC . $template_name) ) {
			$located = SRC . $template_name;
			break;
		}else if ( file_exists(SRC . THEMEPATH . $template_name) ) {
			$located = THEME_PATH . $template_name;
			break;
		}
	}
	if ( $load &&  $located != '' )
		load_template( $located, $require_once );
  return $located;
}

/**
 * Require the template file
 *
 * The globals are set up for the template file to ensure that the WordPress
 * environment is available from within the function. The query variables are
 * also available.
 *
 * @since 1.5.0
 *
 * @param string $_template_file Path to template file.
 * @param bool $require_once Whether to require_once or require. Default true.
 */
function load_template( $_template_file, $require_once = true ) {
	if ( $require_once ){
		require_once( $_template_file );
	}else{
		require( $_template_file );
	}
}



/* Getters: Meta
 -------------------------------------------------------------------------- */

function get_site_name(){
	global $siteinfo;
	return $siteinfo['name'];
}

function get_stylesheet_uri( $file='style.css' ){
	$stylesheet_path = SOURCE_DIR . '/' . THEME_DIR . '/' . $file;
	return $stylesheet_path;
}

function get_site_info( $show='' ){
	global $siteinfo;
	switch( $show ){
		case 'site_description':
			$output = $siteinfo['description'];
			break;
		case 'site_name':
			$output = $siteinfo['name'];
			break;
		case 'site_url':
			$output = $siteinfo['url'];
			break;
		case 'version':
			$output = $siteinfo['version'];
			break;
		default: 
			$output = $siteinfo['name']; 
			break;
	}
	
	return $output;
}

/**
 * 
 * @param string $tag
 * @param string $string
 * @return array array of strings
 */
function extract_text_from_tags($tag, $string){
	return preg_match_all("#<{$tag}.*?>([^<]+)</{$tag}>#", $str, $foo);
}

function get_site_title($separator="&raquo;"){
	global $g_view, $siteinfo;
	
	$title = $g_view->get_title();
	
	return $siteinfo['name'] . " $separator " . $title;
}
/**
 * 
 * @param object $post Post data.
 * @return bool True when finished.
 */
function setup_postdata( $post ){
	
	$id      = (int) $post->ID;
	$title   = $post->title;
	$excerpt = $post->excerpt;
	$input   = $post->input;
	$output  = $post->output;
	
}

/**
 * 
 * @param string $separator
 * @param string $title
 * @return string
 */
function get_title(){
	global $g_view;
	
	$title = $g_view->get_title();
	
	return $title;
}

/**
 * Gets the list of authors as a string
 *
 * @return string comma separated string of authors
 */
function get_authors(){
	global $g_view;
	$authors = $g_view->get_authors();
	
	return args_to_string($authors, ', ');
}


function get_description(){
	global $g_view;
	return $g_view->get_description();
}

function get_parent(){
	global $g_view;
	return $g_view->get_parent();
}

function get_children(){
	global $g_view;
	return $g_view->get_children();
}

/* Getters: Content
 -------------------------------------------------------------------------- */

/**
 * 
 */
function get_content(){
	global $g_view;
	echo $g_view->get_parsed_content();
}

/* Comparitors
 -------------------------------------------------------------------------- */

function is_article(){
	global $g_view;
	return (bool) $g_view->is_article();
}

function is_404(){
	global $g_view;
	return (bool) $g_view->is_404();
}

function is_home(){
	global $g_view;
	return (bool) $g_view->is_home();
}

function is_page(){
	global $g_view;
	return (bool) $g_view->is_page();
}

function create_menu($id,$depth=null){
	global $query;
	static $fields = array('id','title','slug');
	
	if( isset($depth) ){
		// If at the lowest depth, stop
		if( $depth==0 ) return;
		// otherwise, decrement and continue
		--$depth;
	}

	$children = $query->get_children( $id, $fields );
	
	if(!empty($children)){
		echo("<ul class='tree'>");
		foreach($children as $child){
			echo("<li><a href='article/{$child['slug']}' title='{$child['title']}'> {$child['title']} </a>");
			create_menu( $child['id'], $child );
			echo("</li>");
		}
		echo("</ul>");
	}
}

?>