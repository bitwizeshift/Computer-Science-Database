<?php 
require_once('bootstrap.php');
init_framework();

$page_info = array("title"=>"About",
		           "authors"=>array("Matthew Rodusel"),
                   "excerpt"=>"About UCSD",
                   "is_home"=>true);
generate_page($page_info);
?>
<!DOCTYPE html>
<html>
<head>
<?php get_meta(); ?>
</head>
<body>
<div id="wrapper">
  <?php get_header(); ?>
  <div id="content" class="container">
  	<h2>Some content</h2>
  </div>
	<div id="push"></div>
</div>
<?php get_footer(); ?>
</body>

</html>