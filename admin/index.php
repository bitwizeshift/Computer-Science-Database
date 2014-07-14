<?php

/* Bootstrap the framework  */
require_once( dirname(__FILE__) . '/admin-bootstrap.php' );

if(!is_secure_session()){
	header("Location: login.php");
}else{
	header("Location: edit.php");
}