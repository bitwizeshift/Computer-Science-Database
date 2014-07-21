<?php
/**
 * Bootstraps all the required modules together for the
 * administration side of the system
 *
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.4 2014-07-13
 *
 * @package AffinityFramework
 * @subpackage Admin
 */

/* Bootstrap the main framework  */
require_once( dirname(dirname(__FILE__)) . '/bootstrap.php' );

// Load admin functions
require( ADMIN_PATH . INC_DIR . '/admin-functions.php');
require( ADMIN_PATH . INC_DIR . '/message.class.php');
require( ADMIN_PATH . INC_DIR . '/validation.php');
require( ADMIN_PATH . INC_DIR . '/generate-html.php');
require( ADMIN_PATH . INC_DIR . '/post-functions.php');

// Initialize important globals
/** Stack of messages in the form of {level, message} */
$GLOBALS['g_messages'] = new Message();

?>