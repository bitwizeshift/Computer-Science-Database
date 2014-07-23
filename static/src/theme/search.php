<?php


global $query;
$term = $_POST['search'];
$posts = $query->search_for_posts( $term );

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
  		<h2>Search Results</h2>
  		<?php
  			echo "<ul>";
  			foreach($posts as $post){

				echo("<li><a href='article/{$post['slug']}'>{$post['title']}</a></li>");
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
