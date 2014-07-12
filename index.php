<?php 
/**
 * Front/main page to the system. This page alone doesn't do anything, but
 * it loads all the subsystems that generate the pages and articles instead
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.2 2014-07-07
 *
 * @package 
 */

/* Load the bootstrap */
require_once(dirname( __FILE__ ) . '/bootstrap.php');

/* View the page */
load_page();


?>