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

$per_page = 10;
if(!is_secure_session()){
	redirect_address( "admin/login.php" );
}

$page = isset($_GET['page']) ? intval($_GET['page']) * $per_page : 0;

global $g_db;
$stmt = "SELECT ucsd_posts.id,`title`,`display_name`,`modified` 
		 FROM `ucsd_posts` JOIN `ucsd_users` 
		 WHERE ucsd_posts.author_id = ucsd_users.id AND ucsd_posts.status = \"POST\"
		 LIMIT ?,?";
$result = $g_db->query($stmt, array($page, $per_page));

?>

<!DOCTYPE html>
<html>
<head>
<?php require('admin-meta.php'); ?>
</head>

<body class="admin post">
<?php require('admin-header.php'); ?>
<div id="wrapper">
	<div id="content" class="container">
	<h2 class="heading">Posts <a class="link" href="admin/post-edit.php">Add New</a></h2>
<?php /* Add new article option*/ ?>
<?php /* Current articles for page number */ ?>
<table class='table table-striped table-bordered'>
	<thead>
		<tr>
			<th>Title</th>
			<th>Author</th>
			<th>Date</th>
		</tr>
	</thead>
	<tbody>
<?php 
foreach( (array) $result as &$row){
	echo("<tr>");
	echo("<td><a href='admin/post-edit.php?id={$row['id']}'>{$row['title']}</a></td>");
	echo("<td>{$row['display_name']}</td>");
	echo("<td><time datetime='{$row['modified']}'>"  . date("F jS, Y.  h:i:sa",strtotime($row['modified'])) . "</time></td>");
	echo("</tr>");
}
?>
	</tbody>
</table>
</div>
</div>
<?php /* Select page number */ ?>

</body>
</html>