<?php
/**
 * This unit provides all the basic required features for the CMS's article
 * management. It includes features for checking the type of accessed page
 * (article, home, or error), accessing the header/footer/content, and 
 * generating various page-related elements such as breadcrumbs and dynamic
 * navigation systems.
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.2 2014-07-04
 */

/* Getters: Resource
 -------------------------------------------------------------------------- */

if(!function_exists('get_meta')):
/**
 * Includes the website's meta information for the website.
 * This will automatically apply information such as the title, description,
 * author, etc.
 *
 * @param string $meta
 */
function get_meta($meta=null){
	if(isset($meta)){
		load_theme_resource('meta-' . $meta . '.php', false);
	}else{
		load_theme_resource('meta.php', false);
	}
}
endif;

if(!function_exists('get_header')):
/**
 * Includes the header for the website.
 *
 * @param string $header
 */
function get_header($header=null){
	if(isset($header)){
		load_theme_resource('header-' . $header . '.php', false);
	}else{
		load_theme_resource('header.php', false);
	}
}
endif;

if(!function_exists('get_footer')):
/**
 * Include's the footer for the website.
*
* @param string $footer
*/
function get_footer($footer=null){
	if(isset($footer)){
		load_theme_resource('footer-' . $footer . '.php', false);
	}else{
		load_theme_resource('footer.php', false);
	}
}
endif;

/* Getters: Meta
 -------------------------------------------------------------------------- */

/**
 * Gets the list of authors as a string
 *
 * @return string comma separated string of authors
 */
function get_authors(){
	global $g_view;
	$authors = $g_view->get_authors();
	$result = "";
	$max = count($authors);
	for($i=0;$i<$max;++$i){
		$result.=$authors[$i];
		if($i!=$max-1){
			$result.=", ";
		}
	}
	return $result;
}

function get_title($separator="&raquo"){
	global $g_view;
	return SITENAME . " $separator " . $g_view->get_title();
}

function get_description(){
	global $g_view;
	return $g_view->get_description();
}

/* Getters: Content
 -------------------------------------------------------------------------- */

if(!function_exists('get_raw_content')):
/**
 * 
 */
function get_raw_content(){
	global $view;
	
}
endif;
/**
 * 
 */
function get_content(){
	
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

/* Loader
 -------------------------------------------------------------------------- */

/**
 * 
 */
function load_template(){
	global $g_view;
	load_theme_resource($g_view->get_resource());
}

?>