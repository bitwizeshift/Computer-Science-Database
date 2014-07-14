<?php
/**
 * The Post page.
 * 
 * This page displays all of the currently published articles to the user,
 * and allows for them to
 *
 *
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.4 2014-07-13
 *
 * @package \Admin
 * @subpackage Post
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

<?php /* Add new article option*/ ?>
<?php /* Current articles for page number */?>
<?php /* Select page number */?>

</body>
</html>