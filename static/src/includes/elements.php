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

load_resource('view.interface.php');
load_resource('article.class.php');
load_resource('page.class.php');

/**
 * Loads an article if one has not already been
 * generated.
 * 
 * @global $article Article object
 */
function load_view(){
	if(isset($GLOBALS['view']))
		return;
	
	$GLOBALS['view'] = new Article();
}

/* Getters
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
function get_parsed_content(){
	load_article();
	global $article;
	echo($article->get_parsed_content());
}

/**
 * Generate the website's raw content
 */
function get_raw_content(){
	load_article();
	global $article;
	echo($article->get_raw_content());
}

/**
 * Get the article/page's title
 */
function get_title(){
	load_article();
	global $article;
	return $article->get_title();
}

/**
 * Gets the list of authors as a string
 * 
 * @return string comma separated string of authors
 */
function get_authors(){
	load_article();
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

/**
 * Gets the excerpt of the article
 */
function get_description(){
	load_article();
	global $article;
	return $article->get_excerpt();
}
 
/* Checks
 -------------------------------------------------------------------------- */

/**
 * 
 * @return boolean
 */
function is_home(){
	load_article();
	global $article;
	return (bool) $article->is_home();
}

/**
 * 
 * @return boolean
 */
function is_article(){
	load_article();
	global $article;
	return (bool) $article->is_article();	
}

/**
 * 
 * @return boolean
 */
function is_page(){
	load_article();
	global $article;
	return (bool) $article->is_page();
}

/**
 * 
 * @return boolean
 */
function is_admin(){
	load_article();
	global $article;
	return (bool) $article->is_admin();
}

/**
 *
 * @return boolean
 */
function is_404(){
	load_article();
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