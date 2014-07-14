<?php

// Constants for directories

if(!defined('INC_DIR'))
/** Define INC_DIR as the include directory */
define('INC_DIR', 'includes' );

if(!defined('ADMIN_DIR'))
/** Define ADMIN_DIR as the admin directory */
define('ADMIN_DIR', 'admin' );

if(!defined('CONTENT_DIR'))
/** Define CONTENT_DIR as the content directory */
define('CONTENT_DIR', 'content' );

if(!defined('TEMPLATE_DIR'))
/** Define TEMPLATE_DIR as the template directory */
define('TEMPLATE_DIR', 'template' );

if(!defined('THEME_DIR'))
/** Define THEME_DIR as the theme directory */
define('THEME_DIR', 'theme');

if(!defined('SOURCE_DIR'))
/** Define SOURCE_DIR as the source directory */
define('SOURCE_DIR', 'static/src' );

// Constants for full directory paths
/** Define ROOT as the root path of the installation */
define('ROOT', dirname(__FILE__) . '/' );

/** Define SRC as the path to the source directory */
define('SRC', ROOT . SOURCE_DIR . '/' );

/** Define INCLUDE_PATH as the path to the include directory */
define('INCLUDE_PATH', SRC . INC_DIR . '/' );

/** Define TEMPLATE_PATH as the path to the template directory */
define('TEMPLATE_PATH', SRC . TEMPLATE_DIR . '/' );

/** Define THEME_PATH as the path to the theme directory */
define('THEME_PATH', SRC . THEME_DIR . '/' );

/** Define ADMIN_PATH as the path to the admin directory */
define('ADMIN_PATH', ROOT . ADMIN_DIR . '/' );

/** Define THEMEPATH as the theme directory */
define('THEMEPATH', 'theme' . DIRECTORY_SEPARATOR);

?>