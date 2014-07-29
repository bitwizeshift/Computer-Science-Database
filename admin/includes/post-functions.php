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
		set_message( Message::ERROR, "Title can't be empty" );
		return false;
	}
	return true;
}

function validate_slug( $slug, $id = null ){
	global $query;
	if($slug==""){
		set_message( Message::ERROR, "Slug can't be empty. The title must have non-special characters." );
		return false;
	}
	if(!isset($id)){
		$exists = $query->term_exists( $slug, "SLUG" );
	}else{
		$exists = $query->term_exists_outside_id( $slug, $id );
	}
	if($exists){
		set_message( Message::ERROR, "Slug already in use." );
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
		set_message( Message::ERROR, "Parent must exist." );
		return false;
	}
	return true;
}

function validate_input( $id, $input ){
	global $query;
	if(empty($input) || strlen($input)==0){
		set_message( Message::ERROR, "Post is empty." );
		return false;
	}
	
	$content = $query->query_post( $id, true );
	if($content['input'] == $input ){
		set_message( Message::ERROR, "No content changed, no need to publish");
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

function update_post($info, $post_id = null){
	/* Validate Parameters */
	if(!validate_title($info['title']))
		return;
	if(!validate_parent($info['parent']))
		return;
	
	if( $post_id === null ){
		if(!validate_slug( $info['slug'] ))
			return;
		add_new_post($info);
	}else{
		if( !validate_slug( $info['slug'], $post_id ) )
			return;
		if( !validate_input( $post_id, $info['input'] ) )
			return;
		edit_post($post_id, $info);
	}
}

/**
 * 
 * @param unknown $info
 */
function add_new_post($info){
	global $query;
	
	$query->add_new_post( $info, Query::TYPE_POST );
	
	// Inform the user that it was successfully posted
	set_message(Message::SUCCESS, "Article posted successfully");
}

/**
 * 
 * @param unknown $info
 */
function edit_post( $post_id, $info ){
	global $query;
	
	$query->modify_post( $post_id, $info );
	/*
	// Update the original post
	$query->update_post( $info, "POST" );
	
	// Add the new revision
	$info['parent'] = $info['id'];
	$query->insert_post( $info, "REVISION" );
	
	// Update term (slug)
	$query->update_slug( $info['id'], $info['slug'], $info['title'] );
	*/
	
	// Inform the user that it was successfully updated
	set_message(Message::SUCCESS, "Article updated successfully");
}

/* Slug information
 -------------------------------------------------------------------------- */

function output_to_excerpt( $output, $expected=500, $max=750 ){
	preg_match_all("/<p>(.*)<\/p>/U", $output, $matches, PREG_SET_ORDER);
	$excerpt = '';
	$length = 0;
	foreach($matches as &$match){
		$content = strip_tags( trim($match[1]) );
		$match_length = strlen( $content );
		if($length + $match_length >= $max){
			$excerpt .= '<p>' . substr( $content, 0, $max - $length - 3 ) . '...</p>';
			break;
		}else{
			$excerpt .= "<p>{$content}</p>";
		}
		
		$length += $match_length;
		if($length >= $expected)
			break;
	}	
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