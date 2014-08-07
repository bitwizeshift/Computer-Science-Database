<?php
/**
 * This unit contains all of the required metadata for the system to work on the frontend, 
 * including all of the appropriate SEO optimized tags.
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.1 2014-06-30
 */

// 
echo("<base href='" . get_home_url() . "'><!--[if IE]></base><![endif]-->");
echo("<title>" . get_site_title() . "</title>");
// Base meta tags
echo("<meta name='author' content='" . get_authors() . "'>");
echo("<meta name='description' content='" . get_description() . "'>");
echo("<meta name='application-name' content='" . get_site_name() . "'/>");
echo("<meta name='distribution' content='web'>");
echo("<meta name='generator' content='Framework0.3'>");
// OpenGraph Tags
echo("<meta name='og:type' content='website'>");
echo("<meta name='og:title' content='" . get_title() ."'>");
echo("<meta name='og:description' content='" . get_description() ."'>");
echo("<meta name='og:url' content='" . get_home_url() . "'>");
//
?>
<meta name='generator' content='Framework0.3' />
<meta name='msapplication-TileColor' content='#000000' />
<meta name='msapplication-square70x70logo' content='static/img/icon/icon70x70.png' />
<meta name='msapplication-square150x150logo' content='static/img/icon/icon150x150.png' />
<meta name='msapplication-wide310x150logo' content='static/img/icon/icon310x150.png' />
<meta name='msapplication-square310x310logo' content='static/img/icon/icon310x310.png' />
<meta http-equiv='Content-Type' content='text/html;charset=utf-8'>
<?php 
echo("<link rel='canonical' href='" . get_current_url() . "'/>");
?>
<link rel='icon' type='image/x-icon' href='static/img/icon/favicon.ico'>
<link rel='icon' type='image/png' href='static/img/icon/favicon.png'>
<link rel='apple-touch-icon' href='static/img/icon/touch-icon-iphone.png'>
<link rel='apple-touch-icon' sizes='76x76' href='static/img/icon/touch-icon-ipad.png'>
<link rel='apple-touch-icon' sizes='120x120' href='static/img/icon/touch-icon-iphone-retina.png'>
<link rel='apple-touch-icon' sizes='152x152' href='static/img/icon/touch-icon-ipad-retina.png'>
<link rel='stylesheet' type='text/css' href='static/css/common.css?ver=1.0'>
<link rel='stylesheet' type='text/css' href='static/css/print.css?ver=1.0' media='print'>
<link rel='stylesheet' type='text/css' href='<?php echo get_stylesheet_uri('style.css'); ?>' media='screen'>
<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
<!--[if lt IE 9]>
	<script src="statics/js/html5shiv.js"></script>
	<script src="static/js/IE9.min.js"></script>
<![endif]-->
