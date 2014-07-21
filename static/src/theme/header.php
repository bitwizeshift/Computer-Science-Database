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
		<h1 id="logo">
			<a class="brand" title="Back to Home" href="." rel="home" itemprop="url">University Computer Science Database</a>
		</h1>
			<nav id="navigation">
			<ul>
				<li><a href="admin">Login</a></li>
				<li><a href="browse">Browse</a></li>
				<li><a href="about">About</a></li>
			</ul>
			<form class="search-form" action="search" method="GET" class="global-search">
		        <label class="search-label">Search</label>
		        <input type="text" name="search" class="search-input" value="" placeholder="Search...">
			</form>
		</nav><!-- Navigation -->		
    </div>
</header>
