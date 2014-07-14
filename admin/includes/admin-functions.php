<?php

function if_error(){
	return isset($_GET['err']);
}

function get_error_messages(){
	switch($_GET['err']){
		case "emptyfield": 
			$result = "Required field left empty"; 
			break;
	}
}

function get_message($key, $value){
}

function get_warning_message(){
	
}

function redirect_address( $page, $delay=0){
	$url = get_home_url() . $page;
	if($delay!=0){
		header("Refresh: {$delay}; URL={$url}");
	}else{
		header("Location: {$url}");
	}
	exit();	
}

?>