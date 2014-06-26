<?php 
/**
 * FUNCTIONS
 * 
 * Descriptions:
 *   This unit provides all the basic required features for the CMS's article
 *   management. It includes features for checking the type of accessed page
 *   (article, home, or error), accessing the header/footer/content, and
 *   generating various page-related elements such as breadcrumbs and dynamic
 *   navigation systems.
 * 
 * Structure:
 *   -------------------------------------------------------------------------
 *   $__globals    Global variable definitions
 *   $__elements
 *   $__relations   Page-detail checks
 * 
 */

 /* __globals
 -------------------------------------------------------------------------- */
 define('__ROOT__', dirname(dirname(__FILE__)));
 
 require_once("Connection.Class.php"); // Connection Class
 
 $g_conn = new Connection("settings.ini"); // Global connection variable
 
 /* __elements
 -------------------------------------------------------------------------- */
 
 // Include page management functions
 require("page_elements.php");

 /* __relations
 -------------------------------------------------------------------------- */
 
 /**
  * Find the IDs of the previous ancestors based on the article ID
  * 
  * @param number $id
  * @param number $depth
  * @return an array of ancestors' ids
  */
 function find_ancestors($id, $depth=1){
 	global $g_conn;

 	return {0};
 }
 
 /**
  * Find the ID direct parent of the article ID
  * 
  * @param number $id
  * @return parent's article id
  */
 function find_parent($id){
 	return find_ancestors($id, 1);
 }
 
 /**
  * Find the children IDs of the specified article ID
  * 
  * @param number $id
  * @param number $depth
  * @return an array of children's ids
  */
 function find_children($id, $depth=1){
 	global $g_conn;
 	return {0};
 }
 
?>