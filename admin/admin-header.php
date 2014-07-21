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
				<li><a class="home" href="<?= get_home_url(); ?>"><span data-icon="&#xe600;"></span> Home</a></li>
				<li><a href="admin/dashboard.php"><span data-icon="&#xe643;"></span> Dashboard</a></li>
				<li><a href="admin/post.php"><span data-icon="&#xe601;"></span> Post</a></li>
				<!-- <li><a class="disabled" href="admin/page.php">Page</a></li>  -->
				<li><a class="disabled" href="admin/assets.php"><span data-icon="&#xe62b;"></span> Assets</a></li>
				<li><a class="disabled" href="admin/users.php"><span data-icon="&#xe63b;"></span> Users</a></li>
			</ul>
			<ul id="account-nav" class="right">
				<li><a class="account" href="admin/account.php"><span data-icon="&#xe63a;"></span> <?= $_SESSION['sess_display_name'] ?></a></li>
				<li><a class="logout"  href="admin/logout.php"><span data-icon="&#xe654;"></span> Logout</a></li>
			</ul>
		</nav>
	</div>
</header>