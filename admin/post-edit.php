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

global $g_db;

$posts = $g_db->query("SELECT id, title FROM ucsd_posts WHERE status=\"POST\" ORDER BY title");

$title  = http_value("POST", "title","");
$input  = http_value("POST", "input-content","");
$parent = (int) http_value("POST", "parent",0);

/* If modifying an article, pull the info or redirect to add new if it doesn't exist*/
if(isset($_GET['id'])){
	global $g_db;
	$id = $_GET['id'];
	$result = $g_db->query("SELECT title, parent, input_content FROM `ucsd_posts` WHERE id = ? AND status=\"POST\"", $id);
	// If it's not found, just add new article
	if(!isset($result[0]))
		redirect_address( "admin/post-edit.php");

	$title = $result[0]['title'];
	$input = $result[0]['input_content'];
	$parent = $result[0]['parent'];
}


/* If Submitting the article */
if(isset($_POST['title']) && isset($_GET['action']) && $_GET['action']=='submit'){
	clear_messages();
	
	$info = array(
		"title"   => $_POST['title'],
		"parent"  => (int) $_POST['parent'],
		"excerpt" => output_to_excerpt($_POST['output-content']),
		"input"   => $_POST['input-content'],
		"output"  => $_POST['output-content'],
		"user_id" => (int) $_SESSION['sess_user_id'],
		"date"    => date( 'Y-m-d H:i:s', time() ),
		"slug"    => title_to_slug($_POST['title'])
	);
	
	if(isset($_GET['id'])){
		$info['id'] = (int) $_GET['id'];
		update_post($info, false);
	}else{
		update_post($info);
	}
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
						<select type="text" name="parent" id="wmd-parent-input" class="full-size">
							<option value="0" style="color: #777;">No parent</option>
							<?php 
							foreach($posts as &$post){
								if($parent==$post['id']){
									echo("<option value='{$post['id']}' selected='selected'>{$post['title']}</option>");	
								}else{
									echo("<option value='{$post['id']}'>{$post['title']}</option>");
								}
							}
							?>
						</select>
						</label>
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