<?php
/**
 * 
 * 
 * 
 */

// 404 page data
$browse_data['title'] = "Browse Articles";
$browse_data['description'] = "Browse Articles";
$browse_data['resource'] = "browse.php";
$browse_data['authors'] = array("Matthew Rodusek");
$browse_data['is_404'] = true;

$legal_data['title'] = "Terms of Use";
$legal_data['description'] = "Terms of Use for UCSD";
$legal_data['resource'] = "legal.php";
$legal_data['authors'] = array("Matthew Rodusek");
$legal_data['is_404'] = true;

$privacy_data['title'] = "Privacy Statement";
$privacy_data['description'] = "Privacy Description";
$privacy_data['resource'] = "privacy.php";
$privacy_data['authors'] = array("Matthew Rodusek");
$privacy_data['is_404'] = true;

// Register the pages
register_page( "browse", $browse_data );
register_page( "legal", $legal_data );
register_page( "privacy", $privacy_data );



?>

