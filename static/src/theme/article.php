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
  	
  	<?php if(!empty(get_parent())): ?>
  	<div class="panel">
  		<h2>Parent Article</h2>
  		<?php 
  		$parent = get_parent();
  		echo("<h3>{$parent['title']}<a class='link' href='article/{$parent['slug']}'>View</a></h3>");
  		echo("<p>{$parent['excerpt']}</p>");
  		?>
  	</div>
  	<?php endif;?>
  	
  	<?php if(!empty(get_children())):?>
  	<div class="panel">
  		<h2>Related to this Article</h2>
  		<?php 
  			foreach(get_children() as &$child){
				echo("<div class='preview'>");
				echo("<h3>{$child['title']}<a class='link' href='article/{$child['slug']}'>View</a></h3>");
				echo("<p>{$child['excerpt']}</p>");
				echo("</div>");
			}
  		?>
  	</div>
  	<?php endif;?>
  	
  </div>
	<div id="push"></div>
</div>
<?php get_footer(); ?>
</body>

</html>
