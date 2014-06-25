<?php 
/**
 * FUNCTIONS
 * 
 * Descriptions:
 *   This unit contains all of the required functions for the article system,
 *   both from other units, and also included in this one. 
 *   
 *   Secure Sessions, Page Elements, etc. are all here, included through
 *   their respective php files (organized separately for clarity)
 * 
 * Structure:
 *   -------------------------------------------------------------------------
 *   $__globals    Global variable definitions
 *   $__session    
 *   $__elements
 *   $__relations
 * 
 */

 /* __globals
 -------------------------------------------------------------------------- */
 define('__ROOT__', dirname(dirname(__FILE__)));
 
 require_once("Connection.Class.php"); // Connection Class
 
 $g_conn = new Connection("settings.ini"); // Global connection variable
 
 /* __session
 -------------------------------------------------------------------------- */
  
 // Include session management functions
 require("session.php");
 
 /* __elements
 -------------------------------------------------------------------------- */
 
 // Include page management functions
 require("page_elements.php");

 /* __relations
 -------------------------------------------------------------------------- */
 
 /**
  * 
  * 
  * @param number $id  
  */
 function generate_relationship($id){
 	
 }
 
 /**
  * 
  */
 function find_parent($id){
 	
 }
 
 /**
  * 
  * @param number $id
  * @param number $depth te
  */
 function find_children($id, $depth=1){
 	
 }
?>