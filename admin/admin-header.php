<?php
/**
 * The administration header bar.
 * 
 * This has the main links to Home, Dashboard, Post, Page, and Accounts
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.4 2014-07-13
 * 
 * @package AffinityFramework
 * @subpackage Admin
 */
?>
<header id="header">
	<div id="header-content" class="container">
		<nav class="navigation">
			<ul id="admin-nav" class="left">
				<li><a class="home"      href="<?= get_home_url(); ?>">Home</a></li>
				<li><a class="dashboard" href="admin/dashboard.php">Dashboard</a></li>
				<li><a class="post"      href="admin/post.php">Post</a></li>
				<li><a class="page"      href="admin/page.php">Page</a></li>
			</ul>
			<ul id="account-nav" class="right">
				<li><a class="account" href="admin/account.php"><?= $_SESSION['sess_display_name'] ?></a></li>
				<li><a class="logout"  href="admin/logout.php">Logout</a></li>
			</ul>
		</nav>
	</div>
</header>