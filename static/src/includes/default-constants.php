<?php




function default_constants(){
	// Constants for representing human-readable intervals
	define( 'MINUTE_IN_SECONDS', 60 );
	define( 'HOUR_IN_SECONDS',   60 * MINUTE_IN_SECONDS );
	define( 'DAY_IN_SECONDS',    24 * HOUR_IN_SECONDS   );
	define( 'WEEK_IN_SECONDS',    7 * DAY_IN_SECONDS    );
	define( 'YEAR_IN_SECONDS',  365 * DAY_IN_SECONDS    );
}



function ssl_constants(){
	if( !defined( 'FORCE_SSL_ADMIN' ) ){
		if( 'https' === parse_url ){
			define( 'FORCE_SSL_ADMIN', true );
		}else{
			define( 'FORCE_SSL_ADMIN', false );
		}
	}
	
	if( !defined( 'FORCE_SSL_LOGIN' ) ){
		if( true ){
			define( 'FORCE_SSL_LOGIN', true );
		}else{
			define( 'FORCE_SSL_LOGIN', false);
		}
	}
}

function path_constants(){
	
}

?>