<?php
/**
 * The administration functions.
 *
 * 
 *
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.4 2014-07-19
 *
 * @package AffinityFramework
 * @subpackage Admin
 */
function if_error(){
	return isset($_GET['err']);
}

function get_error_messages(){
	switch($_GET['err']){
		case "emptyfield": 
			$result = "Required field left empty"; 
			break;
	}
}

function get_message($key, $value){
}

function get_warning_message(){
	
}

function redirect_address( $page, $delay=0){
	$url = get_home_url() . $page;
	if($delay!=0){
		header("Refresh: {$delay}; URL={$url}");
	}else{
		header("Location: {$url}");
	}
	exit();	
}

function title_to_slug($title){
	$special_chars = array("/","\\","*","%","$","#");
	$slug = trim($title);
	$slug = strtolower($slug);
	$slug = str_replace(" ", "_", $slug);
	$slug = str_replace($special_chars,'',$slug);
	$slug = substr($slug,0,100);
	return $slug;
}

?>