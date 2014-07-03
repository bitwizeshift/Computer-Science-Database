<?php
/**
 * This unit contains all of the required metadata for the system to work on the frontend, 
 * including all of the appropriate SEO optimized tags.
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.1 2014-06-30
 */

 echo("<base href='" . get_base_url() . "' target='_blank'><!--[if IE]></base><![endif]-->");
 echo("<title>" . SITENAME . " &raquo " . get_title() . "</title>");
 echo("<meta name='author' content='" . get_authors() . "'>");
 echo("<meta name='description' content='" . get_description() . "'>");
 echo("<meta name='distribution' content='web'>");
 echo("<meta http-equiv='Content-Type' content='text/html;charset=utf-8'>");
 echo("<meta name='application-name' content='" . SITENAME . "'/>");
?>
<meta name='msapplication-TileColor' content='#000000'/>
<meta name='msapplication-square70x70logo' content='static/img/win8/icon70x70.png'/>
<meta name='msapplication-square150x150logo' content='static/img/win8/icon150x150.png'/>
<meta name='msapplication-wide310x150logo' content='static/img/win8/icon310x150.png'/>
<meta name='msapplication-square310x310logo' content='static/img/win8/icon310x310.png'/>
<link rel='icon' type='image/x-icon' href='static/img/favicon.ico' />
<link rel='icon' type='image/png' href='static/img/favicon.png' />
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
