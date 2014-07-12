<?php 
/**
 * General template functions that can go anywhere in the system.
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.2 2014-07-07
 *
 * @package 
 * @subpackage Template
 */

/**
 * Load meta template.
 * 
 * Includes the meta template for a theme or if a name is specified then a
 * specialised meta will be included.
 * 
 * @since 0.3
 * 
 * @uses locate_template()
 *
 * @param string $meta
 */
function get_meta($name=null){
	$templates = array();
	$name = (string) $name;
	if ( '' !== $name ){
		$templates[] = "meta-{$name}.php";
	}
	$templates[] = "meta.php";
	
	locate_template($templates, true);
}

/**
 * Load header template.
 * 
 * Includes the header template for a theme or if a name is specified then a
 * specialised header will be included.
 * 
 * @since 0.3
 * 
 * @uses locate_template()
 *
 * @param string $meta
 */
function get_header($name=null){
	
	$templates = array();
	$name = (string) $name;
	if ( '' !== $name ){
		$templates[] = "header-{$name}.php";
	}
	$templates[] = "header.php";
	
	locate_template($templates, true);
}

/**
 * Load footer template.
 * 
 * Includes the footer template for a theme or if a name is specified then a
 * specialised footer will be included.
 * 
 * @since 0.3
 * 
 * @uses locate_template()
 *
 * @param string $meta
 */
function get_footer($name=null){
	$templates = array();
	$name = (string) $name;
	if ( '' !== $name ){
		$templates[] = "footer-{$name}.php";
	}
	$templates[] = "footer.php";
	
	locate_template($templates, true);
}

/**
 * Load sidebar template.
 *
 * Includes the sidebar template for a theme or if a name is specified then a
 * specialised sidebar will be included.
 *
 * @since 0.3
 *
 * @uses locate_template()
 *
 * @param string $meta
 */
function get_sidebar($name=null){
	$templates = array();
	$name = (string) $name;
	if ( '' !== $name ){
		$templates[] = "footer-{$name}.php";
	}
	$templates[] = "footer.php";
	
	locate_template($templates, true);
}

?>