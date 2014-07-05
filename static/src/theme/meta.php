<?php
/**
 * This unit contains all of the required metadata for the system to work on the frontend, 
 * including all of the appropriate SEO optimized tags.
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.1 2014-06-30
 */

// 
echo("<base href='" . get_base_url() . "'><!--[if IE]></base><![endif]-->");
echo("<title>" . get_title() . "</title>");
// Base meta tags
echo("<meta name='author' content='" . get_authors() . "'>");
echo("<meta name='description' content='" . get_description() . "'>");
echo("<meta name='application-name' content='" . SITENAME . "'/>");
echo("<meta name='distribution' content='web'>");
echo("<meta name='generator' content='Framework0.3'");
// OpenGraph Tags
echo("<meta name='og:type' content='website'>");
echo("<meta name='og:title' content='" . get_title() ."'>");
echo("<meta name='og:description' content='" . get_description() ."'>");
echo("<meta name='og:url' content='" . get_current_url() . "'>");
//
?>



<meta name='generator' content='Framework0.3' />
<meta name='msapplication-TileColor' content='#000000' />
<meta name='msapplication-square70x70logo' content='static/img/win8/icon70x70.png' />
<meta name='msapplication-square150x150logo' content='static/img/win8/icon150x150.png' />
<meta name='msapplication-wide310x150logo' content='static/img/win8/icon310x150.png' />
<meta name='msapplication-square310x310logo' content='static/img/win8/icon310x310.png' />
<meta http-equiv='Content-Type' content='text/html;charset=utf-8'>
<?php 
echo("<link rel='canonical' href='" . get_title() . "'");
echo("<link rel='copyright' href='//creativecommons.org/licenses/by-sa/3.0/'>")
?>
<link rel='apple-touch-icon' type='static/img/icon/apple-touch.png' />
<link rel='shortcut icon' type='image/x-icon' href='static/img/icon/favicon.ico' />
<link rel='shortcut icon' type='image/png' href='static/img/icon/favicon.png' />
<link rel='stylesheet' type='text/css' href='static/css/style.css?ver=1.0' media='screen' />
<link rel='stylesheet' type='text/css' href='static/css/print.css?ver=1.0' media='print' />
<?php 
 if(is_article()){
   echo("<script type='text/javascript' src='http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML'></script>");
 }
?>
<!--[if lt IE 9]>
	<script src="static/js/IE9.js"></script>
	<script src="statics/js/html5shiv.js"></script>
<![endif]-->
