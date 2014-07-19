<?php

/* Bootstrap the framework  */
require_once( dirname(__FILE__) . '/admin-bootstrap.php' );

if(!is_secure_session()){
	redirect_address( 'admin/login.php' );
}else{
	redirect_address( 'admin/dashboard.php' );
}