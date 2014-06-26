<?php
/**
 * PAGE_ELEMENTS
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
 *   $__content    Content-related functions (header/footer/etc)
 *   $__checks     Page-detail checks
 *   $__navigation	Functions for navigation (breadcrumbs, menus, etc)
 * 
 */

 /* __globals
 -------------------------------------------------------------------------- */

 class PAGE_QUERIES{
	public static $CONTENT_QUERY  = "SELECT `a.title`, `a.content` FROM ucsd_slugs AS s JOIN ucsd_articles AS a WHERE slug = ?";
	public static $CHILDREN_QUERY = "";
	public static $AUTHOR_QUERY   = "";
 }
 
 $SITENAME = "UCSD";
 $URLBase = "/~rodu4140/";
 
 $article = Array("authors" => "",
                  "title"   => "",
                  "content" => "");
 
 $slug = $_GET['slug'];

 if($slug==null){
  $res = null;
 }else{
  $res = $g_conn->query(PAGE_QUERIES::$CONTENT_QUERY, array(slug,PDO::PARAM_STR));
 }

 if($res==null){
 	$article["authors"] = array("Matthew Rodusek");
 	$article["title"]   = "404: Not Found";
 	$article["content"] = "";
  $found   = false;
 }else{
 	$article["authors"] = $res[0]["authors"];
 	$article["title"]   = $res[0]["title"];
 	$article["content"] = $res[0]['content'];
  $found   = true;
 }

 /* __content
 -------------------------------------------------------------------------- */

 /**
  * Generate the website's header
  */
 function the_header(){
  include(__ROOT__ . "/header.php");
 }

 /**
  * Generate the website's footer
  */
 function the_footer(){
  include(__ROOT__ . "/footer.php");
 }

 /**
  * Generate the website's page content
  */
 function the_content(){
	global $g_conn, $id;
	if(is_article()){
		echo $content;
	}else{
		include(__ROOT__ . "/errors/404.php");
	}
 }

 /**
  * Includes the specified php file as a flat page
  * 
  * @param string $page the page name to include (from ./static/src/)
  */
 function the_page($page){
  include(__ROOT__ . "/" . $page);
 }

 /**
  * Generates and returns the current page title
  */
 function get_title(){
	global $article, $SITENAME;
	return $SITENAME . "|" . $article["title"];
 }

 /* __checks
 -------------------------------------------------------------------------- */

 /**
  * Checks whether currently in an article
  *
  * @return true if article
  */
 function is_article(){
	global $found;
	return $found;
 }

 /**
  * Checks whether currently serving 404 page
  *
  * @return true if 404 error occurs
  */
 function is_404(){
	global $found;
	return !$found;
 }

 /* __navigation
 -------------------------------------------------------------------------- */

 /**
  * Creates Breadcrumbs
  *
  */
 function create_breadcrumbs(){

 }
?>