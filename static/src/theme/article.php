<!DOCTYPE html>
<html>
<head>
<?php get_meta(); ?>
</head>
<body>
<div id="wrapper">
  <?php get_header(); ?>
  <div id="content" class="container">
  	<h2><?= get_title(); ?></h2>
  	<?php get_content();?>
  </div>
	<div id="push"></div>
</div>
<?php get_footer(); ?>
</body>

</html>
