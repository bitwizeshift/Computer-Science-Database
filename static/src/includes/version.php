<?php
/**
 * Version information for this article system.
 *
 * The various versions are incremented by 1 every time a 
 * significant change is made to them.
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.1 2014-06-30
 */

/**
 * Holds the version string for the article system.
 * 
 * @global string $version
 */
$GLOBALS['version'] = '0.0.1b';

/**
 * Holds the database revision version. Increments when 
 * changes are made to the initial schema.
 * 
 * @global int $database_version
 */
$GLOBALS['database_version'] = 1;

/**
 * Holds the pagedown revision version. Increments when
 * changes are made to the initial system
 * 
 * @global int $pagedown_version
 */
$GLOBALS['pagedown_version'] = 1;

/**
 * Holds the required PHP version
 * 
 * @global string $required_php_version
 */
$GLOBALS['required_php_version'] = '5.3';

/**
 * Holds the required MySQL version.
 * 
 * @global string $required_mysql_version
 */
$GLOBALS['required_mysql_version'] = '5.0';
?>