<?php
/**
 * The Post page.
 * 
 * This page displays all of the currently published articles to the user,
 * and allows for them to
 *
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.4 2014-07-13
 *
 * @package AffinityFramework
 * @subpackage Admin
 */

/* Bootstrap the framework  */
require_once( dirname(__FILE__) . '/admin-bootstrap.php' );

// Redirect to login page if not currently logged in
if(!is_secure_session())
	redirect_address( "admin/login.php" );

global $query;

$per_page = (int) http_value("GET", "ppp", 10);
$page     = (int) http_value("GET", "page",1);
$page     = $page < 1 ? 1 : $page;
$index = ($page-1) * $per_page;

$stmt = "SELECT ucsd_posts.id,`title`,`display_name`,`modified` 
		 FROM `ucsd_posts` JOIN `ucsd_users` 
		 WHERE ucsd_posts.author_id = ucsd_users.id AND ucsd_posts.status = \"POST\"
		 ORDER BY `modified` DESC 
		 LIMIT ?,?";

$posts = $query->query_posts( "POST", Query::SORT_DATE_DESC , $per_page, $index );

$total = $query->query_total_posts("POST");
?>

<!DOCTYPE html>
<html>
<head>
<title>Post</title>
<?php require('admin-meta.php'); ?>
</head>

<body class="admin post">
<?php require('admin-header.php'); ?>
<div id="wrapper">
	<div id="content" class="container">
	<div class="panel">
		<h2 class="heading">Posts <a class="link" href="admin/post-edit.php">Add New</a></h2>
		<table class='table table-striped table-bordered'>
		<thead>
			<tr>
				<th id="col_title">Title</th>
				<th id="col_author">Author</th>
				<th id="col_date">Date Modified</th>
			</tr>
		</thead>
		<tbody>
<?php 
foreach( (array) $posts as &$post){
	echo("<tr>");
	echo("<td><a href='admin/post-edit.php?id={$post['id']}'>{$post['title']}</a></td>");
	echo("<td>{$post['author']}</td>");
	echo("<td><time datetime='{$post['date']}'>"  . date("F jS, Y",strtotime($post['date'])) . "</time>" . "<small>" . date("h:i:sa",strtotime($post['date'])) . "</small></td>");
	echo("</tr>");
}
?>
		</tbody>
	</table>
	<?php generate_pagination($page, $total, $per_page); ?>
	</div>
</div>
</div>


</body>
</html>