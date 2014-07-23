<?php 

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
  	<div class="panel">
  		<h2>Browse Articles</h2>
  		<?php 
  			global $query;
			$results = $query->query_posts("POST", 'title');
			echo "<ul>";
			foreach($results as &$row){
				echo "<li><a href='article/{$row['slug']}'>{$row['title']}</a></li>";
			}
			echo "</ul>";
  		?>
  	</div>
  </div>
	<div id="push"></div>
</div>
<?php get_footer(); ?>
</body>

</html>
