<?php require_once("./static/src/functions.php"); ?>
<!DOCTYPE html>
<html>
<head>
<?php the_header(); ?>
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
  	<?php the_page("home.php"); ?>
  </div>
	<div id="push"></div>
</div>
<?php the_footer(); ?>
</body>
</html>