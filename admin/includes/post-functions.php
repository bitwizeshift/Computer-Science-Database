<?php
/**
 * The post functions.
 *
 *
 *
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.4 2014-07-19
 *
 * @package AffinityFramework
 * @subpackage Admin
 */

/* Validation
 -------------------------------------------------------------------------- */
function add_user_account($username, $password){
	global $g_db;
	
	


}

/*
function validate_username($username){
	global $g_db;
	$length = strlen($username);
	if($length > 32 || $length < 6){
		set_message(Message::ERROR, "Username length out of bounds. (Must be between 6 and 32)");
		return false;
	}
	return true;
}

function validate_password($password){
	$length = strlen($password);
	if($length > 32 || $length < 6){
		set_message(Message::ERROR, "Password length out of bounds. (Must be between 6 and 32)");
		return false;
	}
	return true;
}

function validate_email($email){
	
	return true;
}
*/

function validate_title( $title ){
	if($title==""){
		set_message(Message::ERROR, "Title can't be empty");
		return false;
	}
	return true;
}

function validate_slug( $slug ){
	global $query;
	if($slug==""){
		set_message(Message::ERROR, "Slug can't be empty. The title must have non-special characters.");
		return false;
	}
	$exists = $query->term_exists($slug, "SLUG");
	if($exists){
		set_message(Message::ERROR, "Slug already in use.");
		return false;
	}
	return true;
}

function validate_parent( $parent ){
	global $query;
	if($parent==0)
		return true;

	$exists = $query->post_exists( $parent );
	if(!$exists){
		set_message(Message::ERROR, "Parent must exist.");
		return false;
	}
	return true;
}

/* Check article pages
 -------------------------------------------------------------------------- */

/**
 *
 * @return boolean
 */
function is_add_article(){
	return (bool) isset($_GET['action']) && $_GET['action'] == "submit";
}

/**
 *
 * @return boolean
 */
function is_edit_article(){
	return (bool) isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "submit";
}


/* Inserting new article
 -------------------------------------------------------------------------- */

function update_post($info, $add_new = true){
	/* Validate Parameters */
	if(!validate_title($info['title']))
		return;
	//if(!validate_slug($info['slug']))
	//	return;
	if(!validate_parent($info['parent']))
		return;
	
	if($add_new){
		add_new_post($info);
	}else{
		edit_post($info);
	}
}

/**
 * 
 * @param unknown $info
 */
function add_new_post($info){
	global $query;

	/* Insert the post*/
	$post_id = $query->insert_post( $info, "POST" );
	
	/* Insert the revision */
	$info['parent'] = $post_id;
	$query->insert_post( $info, "REVISION" );

	$term_id = $query->insert_term( $info['slug'], $info['title'] );
	$query->insert_term_relation( $term_id, $post_id, "SLUG" );
		
	// Inform the user that it was successfully posted
	set_message(Message::SUCCESS, "Article posted successfully");
}

/**
 * 
 * @param unknown $info
 */
function edit_post($info){
	global $query;

	/* Update the original post */
	$query->update_post( $info, "POST" );
	
	/* Add the new revision */
	$info['parent'] = $info['id'];
	$query->insert_post( $info, "REVISION" );
	
	/* Update term (slug) */
	$query->update_slug( $info['id'], $info['slug'], $info['title'] );
	
	// Inform the user that it was successfully updated
	set_message(Message::SUCCESS, "Article updated successfully");
}

/* Slug information
 -------------------------------------------------------------------------- */

function output_to_excerpt($output){
	$excerpt = substr(strip_tags($output,'<p><a><strong><br>'),0,750) . " ...";
	return $excerpt;
}

function title_to_slug($title){
	$special_chars = array("/","\\","*","%","$","#");
	$slug = trim($title);
	$slug = strtolower($slug);
	$slug = str_replace(" ", "_", $slug);
	$slug = str_replace($special_chars,'',$slug);
	$slug = substr($slug,0,300);
	return $slug;
}

?>