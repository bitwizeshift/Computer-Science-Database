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

function validate_title($title){
	if($title==""){
		set_message(Message::ERROR, "Title can't be empty");
		return false;
	}
	return true;
}

function validate_slug($slug){
	global $g_db;
	if($slug==""){
		set_message(Message::ERROR, "Slug can't be empty. The title must have non-special characters.");
		return false;
	}
	$result = $g_db->query("SELECT id FROM ucsd_slugs WHERE slug = ?", $slug);
	if(isset($result[0]['id'])){
		set_message(Message::ERROR, "Slug already in use.");
		return false;
	}
	return true;
}

function validate_parent($parent){
	global $g_db;
	if(!isset($parent) || $parent=="")
		return true;
	$result = $g_db->query("SELECT id FROM ucsd_slugs WHERE slug = ?", $parent);
	if(isset($result[0]['id'])){
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
	if(!validate_slug($info['slug']))
		return;
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
	global $g_db;
	
	$params = array(
		":title"  => $info['title'],
		":parent" => $info['parent'],
		":excerpt"=> $info['excerpt'],
		":status" => "POST",
		":input"  => $info['input'],
		":output" => $info['output'],
		":user_id"=> $info['user_id'],
		":date"   => $info['date']
	);
	
	print_r($params);
	
	$stmt = "INSERT INTO `ucsd_posts`(`title`,`parent`,`excerpt`,`status`,`input_content`,`output_content`,`author_id`,`modified`)
		VALUES(:title, :parent, :excerpt, :status, :input, :output, :user_id, :date)";
	
	/* Insert new Post */
	$id = $g_db->query($stmt, $params);
	
	/* Insert revision of Post*/
	$params[':parent'] = $id;
	$params[':status'] = "REVISION"; 
	$g_db->query($stmt, $params);
	
	/* Insert slug for post */
	$params = array(
		":slug"       => $info['slug'],
		":article_id" => $id
	);
	$g_db->query("INSERT INTO ucsd_slugs(slug, article_id) VALUES(:slug, :article_id)", $params);
}

/**
 * 
 * @param unknown $info
 */
function edit_post($info){
	global $g_db;
	
	$params = array(
		":title"  => $info['title'],
		":parent" => $info['parent'],
		":excerpt"=> $info['excerpt'],
		":status" => "POST",
		":input"  => $info['input'],
		":output" => $info['output'],
		":user_id"=> $info['author'],
		":date"   => $info['date'],
		":id"     => $info['id']);	
	
	$stmt = "SET `title`=:title, `parent`=:parent, `excerpt`=:excerpt, `status`=:status, 
		`input_content`=:input,	`output_content`=:output, `author_id`=:user_id, `modified`=:date
		WHERE `id`=:id";
	
	/* Update Post */
	$g_db->execute($stmt, $vars);
	
	/* Insert revision of Post */
	$stmt = "INSERT INTO `ucsd_posts`(`title`,`parent`,`excerpt`,`status`,`input_content`,`output_content`,`author_id`,`modified`)
		VALUES(:title,:parent,:excerpt,:status,:input,:output,:user_id,:date)";
	$params[':status'] = "REVISION";
	$params[':parent'] = $params['id'];
	unset($params['id']);
	$id = $g_db->query($stmt, $params);

}

/* Slug information
 -------------------------------------------------------------------------- */

function output_to_excerpt($output){
	$excerpt = substr(strip_tags($output),0,100) . " ...";
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