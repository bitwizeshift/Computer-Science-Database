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

set_message(Message::INFO,"This area will display tips or errors.");

$title = "";
$input = "";

if(isset($_GET['id'])){
	global $g_db;
	$id = $_GET['id'];
	$result = $g_db->query("SELECT title, input_content FROM `ucsd_posts` WHERE id = ? AND status=\"POST\"", $id);
	// If it's not found, just add new article
	if(!isset($result[0])) 
		redirect_address( "admin/post-edit.php");
	
	$title = $result[0]['title'];
	$input = $result[0]['input_content'];
}
// If submitting a post
if(isset($_GET['action']) && $_GET['action']=='submit'){
	global $g_db;
	
	clear_messages();
	
	// Get article information
	$title   = $_POST['title'];
	$input   = $_POST['input-content'];
	$output  = $_POST['output-content'];
	$parent  = 0; #$_POST['parent'];
	$user_id = $_SESSION['sess_user_id'];
	$time    = date( 'Y-m-d H:i:s', time() );
	$slug    = title_to_slug($title);
	$excerpt = "";
	$status  = "POST";
	
	$vars    = array(
			":title"  => $title,
			":parent" => $parent,
			":excerpt"=> $excerpt,
			":status" => $status,
			":input"  => $input,
			":output" => $output,
			":user_id"=> $user_id,
			":date"   => $time);
	
	if(isset($_GET['id'])){
		$vars[':id'] = (int) $_GET['id'];
		$stmt = "UPDATE `ucsd_posts` 
				SET `title`=:title, `parent`=:parent, `excerpt`=:excerpt, `status`=:status, 
					`input_content`=:input,	`output_content`=:output, `author_id`=:user_id, `modified`=:date
				WHERE `id`=:id";
	}else{
		$stmt = "INSERT INTO `ucsd_posts`(`title`,`parent`,`excerpt`,`status`,`input_content`,`output_content`,`author_id`,`modified`)
			           VALUES(:title,:parent,:excerpt,:status,:input,:output,:user_id,:date)";
	}
	// Create the original POST to publish
	$id = $g_db->execute($stmt, $vars);
	if(isset($_GET['id']))
		$id = (int) $_GET['id'];
	
	$stmt = "INSERT INTO `ucsd_posts`(`title`,`parent`,`excerpt`,`status`,`input_content`,`output_content`,`author_id`,`modified`)
			           VALUES(:title,:parent,:excerpt,:status,:input,:output,:user_id,:date)";
	
	// Create the first REVISION of the article
	if(isset($vars[':id'])) unset($vars[':id']);
	$vars[':status'] = "REVISION";
	$vars[':parent'] = $id;
	$g_db->execute($stmt, $vars);
	
	if(isset($_GET['id'])){
		// Create the slug for the article
		$vars = array(
			":slug"       => $slug,
			":article_id" => $id
		);
		$stmt = "INSERT INTO ucsd_slugs(slug, article_id) VALUES(:slug, :article_id)";
		$g_db->execute($stmt, $vars);
	}
	
	set_message(Message::SUCCESS, "Article posted successfully");
	
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
		<div id="content" class="container">
			<?php print_messages(0); ?>
			
			<div class="panel">
				<?php if(isset($_GET['id'])){?>
					<h2 class="heading">Edit Article</h2>
				<?php }else{ ?>
					<h2 class="heading">Add New Article</h2>
				<?php }?>
				<form name="wmd-form" id="wmd-form" method="post" action="admin/post-edit.php?action=submit<?= isset($_GET['id']) ? "&id={$_GET['id']}" : ""; ?>" target="_self">
					<input type="text" name="title" id="wmd-title-input" placeholder="Article Title" value="<?=$title;?>" oninput="copyTitle()">
					<div id="wmd-button-bar"></div>
					<textarea name="input-content" id="wmd-input" class="input"><?=$input;?></textarea>
					<textarea name="output-content" id="wmd-output" class="removed"></textarea>
					<p>
						<label for="wmd-parent-input">Parent<br>
						<input type="text" name="parent" id="wmd-parent-input" class="full-size"></label>
					</p>
			    	<input type="submit" name="submit" id="wmd-submit" class="button" value="Publish" onclick="saveParsedContent();">
	    		</form>
	    	</div><!-- .panel -->
	    	<div class="panel">
	    		<h2 id="wmd-preview-title" class="heading"><?=$title; ?></h2>
				<div id="wmd-preview" class="output"></div>
			</div><!-- .panel -->
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