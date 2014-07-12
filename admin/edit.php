<!DOCTYPE html>
<html>
<head>
<?php require('admin-meta.php'); ?>
<style>
	#admin-header{
		clear: both;
		height: 20px;
		width: 100%;
		min-width:100%;
		background: #000;
	}
</style>
</head>
<body>
  <header id="admin-header">
  	<div id="admin-header-content" class="container">
  	
  	</div>
  </header>
  <div id="wrapper">
  	<div id="edit-content" class="container">
    <div class="alert alert-info"><strong>Tip</strong> This would display a tip before submitting (or change to an error message if an error occurs)</div>
    <h1>Add New Article</h1>
    <input placeholder="Article Name"></input>
    <div id="wmd-button-bar"></div>
    <textarea id="wmd-input" class="input">



	</textarea>
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
  
</html>