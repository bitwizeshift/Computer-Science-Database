<?php
ob_start();
session_start();

/* Bootstrap the framework  */
require_once( dirname(dirname(__FILE__)) . '/bootstrap.php' );

global $g_db, $g_hasher;

if(!isset($g_hasher))
	$g_hasher = new PasswordHash(8, true);
$result   = $g_db->query("SELECT * FROM users WHERE `id`=1", array());
$username = $result[0]['username'];
$password = $result[0]['password'];
$salt     = $result[0]['salt'];

# echo($salt . "   " . $password);

$check = $g_hasher->CheckPassword('password' . $salt, $password);
# echo $check ? "Correct" : "Incorrect";

// User not logged in, display login page

if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')){
	require_once("login.php");
	exit();
}
// User logged in, display edit page
else{
	require_once("edit.php");
	exit();
}