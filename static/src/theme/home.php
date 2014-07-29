<?php 
global $query;
$fields = array('slug','title','excerpt');
$recent   = $query->get_posts( null, $fields, Query::ORDER_DESC_DATE, 3);
$featured = null;// $query->query_featured(3);
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
	
		<div id="banner">
			<img src="static/img/banner.jpg" alt="banner" />
			<div id="banner-content">
				<div class="banner-content-inner">
					<h2>UCSD</h2>
					<p>UCSD is the University Computer Science database. It is a large source of information for computer-science related articles of information.</p>
					<p><a href="about">Read more about it</a></p>
				</div>
			</div>
		</div>
		
		<div class="panel">
			<h2>Recently Updated Articles</h2>
			<?php 
			if(empty($recent)){
				echo("<p>There are no articles recently published at this time</p>");
			}else{
				foreach($recent as $post){
					echo("<h3>{$post['title']} <a class='link' href='article/{$post['slug']}'>View</a></h3>");
					echo("<p>{$post['excerpt']}</p>");
				}
			}
			?>
		</div>
		
		<div class="panel">
			<h2>Featured Article</h2>
			<?php 
			if(empty($featured)){
				echo("<p>There are no featured articles at this time</p>");
			}else{

			}
			?>
		</div>
		
	</div>
	<div id="push" style="margin-top: 10px;"></div>
</div>
<?php get_footer(); ?>
</body>

</html>
