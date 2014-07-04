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

// Home page data
$home_data['title'] = "Home";
$home_data['description'] = "Homepage of UCSD";
$home_data['resource'] = "home.php";
$home_data['authors'] = array('Matthew Rodusek');
$home_data['is_home'] = true;

// About page data
$about_data['title'] = "About";
$about_data['description'] = "About UCSD";
$about_data['resource'] = "about.php";
$about_data['authors'] = array('Matthew Rodusek');

// 404 page data
$error_data['title'] = "404: Not Found";
$error_data['description'] = "Error 404: File not found";
$error_data['resource'] = "404.php";
$error_data['authors'] = array("Matthew Rodusek");
$error_data['is_404'] = true;

// Register the pages
register_page( "home", $home_data );
register_page( "about", $about_data );
register_page( "404", $error_data );
 
?>