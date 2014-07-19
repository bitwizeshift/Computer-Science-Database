<?php
/**
 * The Edit Post page.
 * 
 * Edits the currently specified article, given the article ID through $_GET.
 *
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.4 2014-07-13
 *
 * @package AffinityFramework
 * @subpackage Admin
 */

/* Bootstrap the framework  */
require_once( dirname(__FILE__) . '/admin-bootstrap.php' );

if(!is_secure_session()){
	redirect_address( "admin/login.php" );
}

$title = "";
$input = "";

if(isset($_GET['id'])){
	global $g_db;
	$id = $_GET['id'];
	$result = $g_db->query("SELECT title, input_content FROM `ucsd_posts` WHERE id = ?", $id);
	// If it's not found, just add new article
	if(!isset($result[0])) 
		redirect_address( "admin/post-edit.php");
	
	$title = $result[0]['title'];
	$input = $result[0]['input_content'];
	
}
	
if(isset($_GET['action']) && $_GET['action']=='submit'){
	global $g_db;
	
	// Get article information
	$title   = $_POST['title'];
	$input   = $_POST['input-content'];
	$output  = $_POST['output-content'];
	$user_id = $_SESSION['sess_user_id'];
	$time    = date( 'Y-m-d H:i:s', time() );
	$slug    = title_to_slug($title);
	$excerpt = "";
	$parent  = 0;
	$status  = "POST";
	
	// Create the original POST to publish
	$vars    = array(
			":title"  => $title,
			":parent" => $parent, 
			":excerpt"=> $excerpt, 
			":status" => $status, 
			":input"  => $input, 
			":output" => $output, 
			":user_id"=> $user_id, 
			":date"   => $time);
	$stmt = "INSERT INTO `ucsd_posts`(`title`,`parent`,`excerpt`,`status`,`input_content`,`output_content`,`author_id`,`modified`) 
			           VALUES(:title,:parent,:excerpt,:status,:input,:output,:user_id,:date)";
	$id = $g_db->execute($stmt, $vars);
	
	// Create the first REVISION of the article
	$vars[':status'] = "REVISION";
	$vars[':parent'] = $id;
	$g_db->execute($stmt, $vars);
	
	// Create the slug for the article
	$vars = array(
		":slug"       => $slug,
		":article_id" => $id
	);
	$stmt = "INSERT INTO ucsd_slugs(slug, article_id) VALUES(:slug, :article_id)";
	$g_db->execute($stmt, $vars);
	
}

function add_new_article($slug, $title, $input, $output){
	global $g_db;
	
	
}

function edit_article($id, $slug, $title, $input, $output){
	global $g_db;
}

?>


<!DOCTYPE html>
<html>
<head>
<title>Post Edit</title>
<?php require('admin-meta.php'); ?>

<script type="text/javascript">
	function saveParsedContent(){
		var preview = document.getElementById('wmd-preview');
		var output = document.getElementById('wmd-output');
		output.innerHTML = preview.innerHTML;
	}

	function copyTitle(){
		var title = document.getElementById('wmd-title-input');
		var preview = document.getElementById('wmd-preview-title');
		preview.innerHTML = title.value;
	}
</script>
</head>
<body class="admin post edit">
	<?php require('admin-header.php'); ?>
	<div id="wrapper">
		<div id="edit-content" class="container">
			<div class="alert alert-info"><strong>Tip</strong> This would display a tip before submitting (or change to an error message if an error occurs)</div>
			<h1>Add New Article</h1>
			<form name="wmd-form" id="wmd-form" method="post" action="admin/post-edit.php?action=submit" target="_self">
				<input type="text" name="title" id="wmd-title-input" placeholder="Article Title" value="<?=$title;?>" oninput="copyTitle()">
				<div id="wmd-button-bar"></div>
				<textarea name="input-content" id="wmd-input" class="input"><?=$input;?></textarea>
				<textarea name="output-content" id="wmd-output" class="removed"></textarea>
		    	<input type="submit" name="submit" id="wmd-submit" class="button" value="Publish" onclick="saveParsedContent();">
    		</form>
    		<h2 id="wmd-preview-title"><?=$title; ?></h2>
			<div id="wmd-preview" class="output"></div>
			<script type="text/javascript">
		(function () {
			var converter = new Markdown.Converter();
            	  
			converter.hooks.chain("preBlockGamut", function (text, rbg) {
				return text.replace(/^ {0,3}""" *\n((?:.*?\n)+?) {0,3}""" *$/gm, function (whole, inner) {
					return "<blockquote>" + rbg(inner) + "</blockquote>\n";
				});
			}); 

			converter.hooks.chain("plainLinkText", function (url) {
				return "This is a link to " + url.replace(/^https?:\/\//, "");
			});
                
			var help = function () { alert("Do you need help?"); }
			var options = {
				helpButton: { handler: help },
				strings: { quoteexample: "quoted text" }
			};
			var editor = new Markdown.Editor(converter, "", options);
                
			editor.run();
                
			var postfix = "";
			StackExchange.mathjaxEditing.prepareWmdForMathJax(editor, postfix, [["$", "$"], ["\\\\(","\\\\)"]]);
		})();
    		</script>
    	</div>
	</div><!-- #wrapper -->

</body>
  
</html>