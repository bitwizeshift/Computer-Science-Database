<?php 
/**
 * The main administration screen, otherwise known as the `dashboard`.
 * 
 * This is where admins/mods/reviewers are able to access all of the available
 * features and settings available to them.
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.4 2014-07-13
 * 
 * @package AffinityFramework
 * @subpackage Admin
 */

/* Bootstrap the framework  */
require_once( dirname(__FILE__) . '/admin-bootstrap.php' );

if(!is_secure_session()){
	redirect_address( "admin/login.php" );
}

global $query;

$recent = $query->query_posts("POST",Query::SORT_DATE_DESC,  3);
$review = $query->query_posts("REVIEW",Query::SORT_DATE_DESC, 3);

?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<?php require('admin-meta.php'); ?>
</head>

<body class="admin dashboard">
<?php require('admin-header.php'); ?>
<div id="wrapper">
	<div id="content" class="container">
		<noscript>
			<div class="callout severe">
				<strong>Severe</strong>: This dashboard requires Javascript in order to make most changes and post articles!
			</div>
		</noscript>
		<!--[if lt IE 9]>
			<div class="callout warning">
				<strong>Warning</strong>: This dashboard requires IE 9 or greater to be viewed properly!
			</div>
		<![endif]-->
		
		<div class="panel">
			<h2 class="heading">Dashboard</h2>
			<h4>Welcome to your dashbard!</h4>
			<p>From here you can view all of your updates, such as recently published posts, or posts that are pending reviews</p>
			<h4>Hints</h4>
			<ul>
				<li>Recently updated posts can quickly be viewed or edited below by clicking 'view' or 'edit' respectively</li>
				<li>You can access the options to add/edit/delete any post by clicking 'Posts' from the administration bar</li>
				<li>To get back to this dashboard at any time, just click 'Dashboard' from the administration bar</li>
			</ul>
		</div>
		<div class="panel">
			<h2 class="heading">Recently Published</h2>
			<?php 
			if(empty($recent)){
				echo("<p>There are no posts recently published at this time</p>");
			}
			foreach($recent as $post){
				echo("<h3>{$post['title']} <a class='link' href='admin/post-edit.php?id={$post['id']}'>Edit</a><a class='link' href='article/{$post['slug']}'>View</a></h3>");
				echo("<time datetime='{$post['date']}'>"  . date("F jS, Y",strtotime($post['date'])) . "</time>");
				echo("<p>{$post['excerpt']}</p>");
			}
			
			?>
		</div>
		<div class="panel">
			<h2>Needs Review</h2>
			<?php 
			if(empty($review)){
				echo("<p>There are no posts to review at this time</p>");
			}
			foreach($review as $post){
				echo("<h3>{$post['title']} <a class='link' href='admin/post-edit.php?id={$post['id']}'>Review</a></h3>");
				echo("<p>{$post['excerpt']}</p>");
			}
			?>		
		</div>
	</div>
</div>

</body>

</html>