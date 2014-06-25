<?php require_once("common/src/functions.php");?>
<!DOCTYPE html>
<html>
<head>
<?php get_header();?>
</head>
<body>
<div id="wrapper">
  <header id="header">
    <div id="header-content" class="container">
 	    <h1 id="logo">
				<a class="brand" title="Back to Home" href="/" rel="home" itemprop="url">URL</a>
			</h1>
			<nav id="navigation">
			  
			  <!-- Navigation -->
			  
			</nav>
    </div>
  </header>
  <div id="content" class="container">
  	<?php get_page_content();?>
  </div>
	<div id="push"></div>
</div>
<?php get_footer();?>
</body>
</html>