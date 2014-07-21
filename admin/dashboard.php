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
		<div class="panel">
			<h2 class="heading">Dashboard</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi iaculis vel lorem nec egestas. Integer sed turpis quis augue ullamcorper porttitor. Phasellus vitae hendrerit felis. Donec a nisl id odio scelerisque rhoncus. Curabitur interdum leo in magna dictum tempus. Mauris scelerisque viverra elit ut mattis. Aenean pharetra tellus ut purus eleifend, et consectetur lorem pellentesque.</p>
			<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Morbi vitae tellus tincidunt, ultricies velit vel, adipiscing dui. Duis vitae accumsan sapien. Quisque sit amet suscipit tellus. Integer malesuada est eu felis blandit aliquam. Aenean a commodo velit, sed molestie est. Cras aliquet condimentum turpis ut fringilla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean semper mi nisi, ut pellentesque lectus viverra ac. Donec viverra diam urna, sit amet consectetur tortor fermentum tincidunt. Etiam urna turpis, eleifend a eros quis, ultrices tincidunt lectus.</p>
			<p>Proin non nibh sit amet justo fringilla sagittis nec a nibh. Duis auctor est non quam tristique pretium. Integer ac elit eget risus vestibulum sodales. Vestibulum vel vulputate augue, in aliquet ligula. Integer id risus libero. Nam id ultrices nibh. Morbi a ipsum nec tellus molestie eleifend at et ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nunc dictum gravida arcu, quis pellentesque erat. Pellentesque ultricies cursus egestas. Mauris lacus est, tincidunt vitae enim non, posuere condimentum nunc.</p>
		</div>
		<div class="panel">
			<h2 class="heading">Recently Published</h2>
			<p>Etiam et metus lacus. Nullam ultricies sem id faucibus dapibus. Nunc fermentum lectus sed quam elementum malesuada. Curabitur eget quam id velit convallis ullamcorper. In eu auctor mauris, sit amet convallis turpis. Nulla fringilla volutpat sem, quis luctus nulla euismod sit amet. Nulla euismod turpis at nisl condimentum, et congue odio semper. Suspendisse viverra neque eros, a bibendum sapien pellentesque id. Proin est odio, ullamcorper id facilisis in, porttitor ut est.</p>
		</div>
		<div class="panel">
			<h2 class="heading">Needs Review</h2>
			<p title="This is here for future-proofing">There are no articles to be reviewed at this time</p>
		</div>
	</div>
</div>

</body>

</html>