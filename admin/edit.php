<?php 
/**
 * The main edit screen for the administrators to handle creation
 * of articles
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.4 2014-07-13
 * 
 * @package
 * @subpackage Admin
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
<style>
body 
{ 
	background-color: White;
    font-family: sans-serif;
}

blockquote {
	border-left: 2px dotted #888;
	padding-left: 5px;
	background: #d0f0ff;
}

.wmd-panel
{
	margin-left: 25%;
	margin-right: 25%;
	width: 50%;
	min-width: 500px;
}

.wmd-button-bar 
{
	width: 100%;
	background-color: Silver; 
}

.wmd-input 
{ 
	height: 300px;
	width: 100%;
	background-color: Gainsboro;
	border: 1px solid DarkGray;
}

.wmd-preview 
{ 
	background-color: #c0e0ff; 
}

.wmd-button-row 
{
	position: relative; 
	margin-left: 5px;
	margin-right: 5px;
	margin-bottom: 5px;
	margin-top: 10px;
	padding: 0px;  
	height: 20px;
}

.wmd-spacer
{
	width: 1px; 
	height: 20px; 
	margin-left: 14px;
	
	position: absolute;
	background-color: Silver;
	display: inline-block; 
	list-style: none;
}

.wmd-button {
    width: 20px;
    height: 20px;
    padding-left: 2px;
    padding-right: 3px;
    position: absolute;
    display: inline-block;
    list-style: none;
    cursor: pointer;
}

.wmd-button > span {
    background-image: url(static/js/wmd-buttons.png);
    background-repeat: no-repeat;
    background-position: 0px 0px;
    width: 20px;
    height: 20px;
    display: inline-block;
}

.wmd-spacer1
{
    left: 50px;
}
.wmd-spacer2
{
    left: 175px;
}
.wmd-spacer3
{
    left: 300px;
}

.wmd-prompt-background
{
	background-color: Black;
}

.wmd-prompt-dialog
{
	border: 1px solid #999999;
	background-color: #F5F5F5;
}

.wmd-prompt-dialog > div {
	font-size: 0.8em;
	font-family: arial, helvetica, sans-serif;
}


.wmd-prompt-dialog > form > input[type="text"] {
	border: 1px solid #999999;
	color: black;
}

.wmd-prompt-dialog > form > input[type="button"]{
	border: 1px solid #888888;
	font-family: trebuchet MS, helvetica, sans-serif;
	font-size: 0.8em;
	font-weight: bold;
}
	#admin-header{
		clear: both;
		height: 20px;
		width: 100%;
		min-width:100%;
		background: #000;
	}
	.hidden{
		display: none;
	}
</style>
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