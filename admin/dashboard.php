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
 * @package
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
<?php require('admin-meta.php'); ?>
</head>

<body>

</body>

</html>