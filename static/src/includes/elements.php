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

require_resource('article.class.php');

global $article;

if(isset($article)){
	$article = new Article();
}

/* __content
 -------------------------------------------------------------------------- */

/**
 * Includes the website's meta information for the website.
 * This will automatically apply information such as the title, description,
 * author, etc.
 * 
 * @param string $meta
 */
function get_meta($meta=null){
	if(isset($meta)){
		include(SRC . 'meta-' . $meta . '.php');
	}else{
		include(SRC . 'meta.php');
	}
}

/**
 * Includes the header for the website.
 * 
 * @param string $header
 */
function get_header($header=null){
	if(isset($header)){
		include(SRC . 'header-' . $header . '.php');
	}else{
		include(SRC . 'header.php');
	}
}

/**
 * Include's the footer for the website.
 * 
 * @param string $footer
 */
function get_footer($footer=null){
	if(isset($footer)){
		include(SRC . 'footer-' . $footer . '.php');
	}else{
		include(SRC . 'footer.php');
	}
}

/**
 * Generate the website's page content
 */
function get_content(){
	global $article;
	// @todo: Generate content for the website
}

function get_title(){
	global $article;
	return $article->get_title();
}

function get_authors(){
	global $article;
	$authors = $article->get_authors();	
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

function get_description(){
	global $article;
	return $article->get_excerpt();
}
 
/* __checks
 -------------------------------------------------------------------------- */
/**
 * 
 * @return boolean
 */
function is_home(){
	global $article;
	return (bool) $article->is_home();
}

/**
 * 
 * @return boolean
 */
function is_article(){
	global $article;
	return (bool) $article->is_article();	
}

/**
 * 
 * @return boolean
 */
function is_page(){
	global $article;
	return (bool) $article->is_page();
}

/**
 * 
 * @return boolean
 */
function is_admin(){
	global $article;
	return (bool) $article->is_admin();
}

/**
 *
 * @return boolean
 */
function is_404(){
	global $article;
	return (bool) $article->is_404();
}

/* __navigation
 -------------------------------------------------------------------------- */

/**
 * Creates Breadcrumbs
 *
 */
function create_breadcrumbs(){

}
?>