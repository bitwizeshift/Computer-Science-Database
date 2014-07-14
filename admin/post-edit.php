<?php
/**
 * The Edit Post page.
 * 
 * Edits the currently specified article, given the article ID through $_GET.
 *
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.4 2014-07-13
 *
 * @package \Admin
 * @subpackage Post
 */

/* Bootstrap the framework  */
require_once( dirname(__FILE__) . '/admin-bootstrap.php' );

if(!is_secure_session()){
	redirect_address( "admin/login.php" );
}

?>


<!DOCTYPE html>
<html>
<head>
<?php require('admin-meta.php'); ?>

<script type="text/javascript">
	function saveParsedContent(){
		var preview = document.getElementById('wmd-preview');
		var output = document.getElementById('wmd-output');
		output.innerHTML = preview.innerHTML;
	}
</script>
</head>
<body class="admin edit">
	<header id="admin-header">
		<div id="admin-header-content" class="container">
  	
		</div>
	</header>
	<div id="wrapper">
		<div id="edit-content" class="container">
			<div class="alert alert-info"><strong>Tip</strong> This would display a tip before submitting (or change to an error message if an error occurs)</div>
			<h1>Add New Article</h1>
			<form name="wmd-form" id="wmd-form" method="post" action="admin/?action=submit">
				<input type="text" name="title" id="wmd-title-input" placeholder="Article Title"></input>
				<div id="wmd-button-bar"></div>
				<textarea name="input-content" id="wmd-input" class="input"></textarea>
				<textarea name="output-content" id="wmd-output" class="hidden"></textarea>
		    	<input type="submit" name="submit" id="wmd-submit" class="button" value="Publish" onclick="saveParsedContent();">
    		</form>
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