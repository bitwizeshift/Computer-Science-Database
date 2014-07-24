<?php 
global $query;
$recent = $query->query_posts("POST",Query::SORT_DATE_DESC,  3);
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
			<h2>Updated Articles</h2>
			<?php 
			if(empty($recent)){
				echo("<p>There are no articles recently published at this time</p>");
			}
			foreach($recent as $post){
				echo("<h3>{$post['title']} <a class='link' href='article/{$post['slug']}'>View</a></h3>");
				echo("<p>{$post['excerpt']}</p>");
			}
			
			?>
		</div>
		
		<div class="panel">
			<h2>Featured Article</h2>
			<h3>Article 3</h3>
			<p>In pretium, enim et dapibus auctor, metus eros tincidunt dolor, quis feugiat nisi sapien quis erat. Donec orci ligula, condimentum sit amet ligula a, sollicitudin interdum justo. Nulla facilisis, mi id ullamcorper congue, sem justo accumsan arcu, et faucibus quam nulla vel nulla.</p>
			<h3>Article 4</h3>
			<p>Nam nec rhoncus dui. Nunc posuere purus lorem, hendrerit egestas ligula suscipit accumsan. Vestibulum id massa ac odio malesuada cursus. Cras bibendum justo nec erat pellentesque, id sodales urna fermentum. Vivamus varius turpis metus, quis facilisis metus consequat rhoncus. Nunc velit odio, consequat et hendrerit hendrerit, porta vel magna.</p>
		</div>
		
	</div>
	<div id="push" style="margin-top: 10px;"></div>
</div>
<?php get_footer(); ?>
</body>

</html>
