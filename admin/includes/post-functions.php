<?php


function add_new_article($title, $input, $output, $parent){
	global $g_db;
	$vars    = array(
			":title"  => $title,
			":parent" => $parent,
			":excerpt"=> $excerpt,
			":status" => $status,
			":input"  => $input,
			":output" => $output,
			":user_id"=> $user_id,
			":date"   => $time);
	
	/* Make sure everything is valid */
	if(!validate_title($title))	
		return;
	if(!validate_slug($slug))
		return;
	if(!validate_parent($parent))
		return;
	
	
}

function edit_article($id, $title, $input, $output, $parent){
	global $g_db;
	$vars    = array(
			":title"  => $title,
			":parent" => $parent,
			":excerpt"=> $excerpt,
			":status" => $status,
			":input"  => $input,
			":output" => $output,
			":user_id"=> $user_id,
			":date"   => $time,
			":id"     => $id);
	if(!validate_title($title))
		return;
	if(!validate_slug($slug))
		return;
}

/* Validation
 -------------------------------------------------------------------------- */




/* Slug information
 -------------------------------------------------------------------------- */

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