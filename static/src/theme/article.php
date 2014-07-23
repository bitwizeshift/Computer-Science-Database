<!DOCTYPE html>
<html>
<head>
<?php get_meta(); ?>
</head>
<body>
<div id="wrapper">
  <?php get_header(); ?>
  <div id="content" class="container">
  	<div class="panel">
	  	<h2><?= get_title(); ?></h2>
	  	<?php get_content();?>
  	</div>
  	<div class="panel">
  		<h2>Related to this Article</h2>
  		<?php 
  			$children = get_children();
  			foreach($children as &$child){
				echo "<h3><a href='article/{$child['slug']}'>{$child['title']}</a></h3>";
				echo "<p>{$child['excerpt']}</p>";
				
			}
  		?>
  	</div>
  </div>
	<div id="push"></div>
</div>
<?php get_footer(); ?>
</body>

</html>
