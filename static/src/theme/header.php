<?php
/**
 * The HTML header to display (generally) above the rest of the page.
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.1 2014-06-30
 */

?>
<header id="header">
	<div id="header-content" class="container">
		<nav class="navigation">
			<ul id="admin-nav" class="left">
				<li><a href="<?= get_home_url(); ?>" id="logo"><span data-icon="&#xe644;"></span> <strong>UCSD</strong> Computer Science Database</a></li>
				<li><a href="browse/"><span data-icon="&#xe62c;"></span> Browse Articles</a></li>
				<!-- <li><a href="hierarchy/"><span data-icon="&#xe64a;"></span> Hierarchy</a></li> -->
			</ul>
			<form class="search-form global-search" method="post" action="search/">
		        <label class="search-label" for="site-search">Search <span data-icon="&#xe63d;"></span>
		        <input type="text" name="search" class="search-input" id="site-search" value="" placeholder="Search Posts..."></label>
			</form>
		</nav>
	</div>
</header>
