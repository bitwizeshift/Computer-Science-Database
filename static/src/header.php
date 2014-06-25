<?php
/**
 * HEADER
 * 
 * Descriptions:
 *   This unit contains all of the required metadata for the system to work on the frontend, 
 *   including all of the appropriate SEO optimized tags.
 */

 echo("<base href='$URLBase' target='_blank'>");
 echo("<title>" . get_title() . "</title>");
 echo("<meta name='author' content='$author'>");
 echo("<meta name='description' content='$description'");
 echo("<meta name='distribution' content='web'>");
 echo("<meta http-equiv='Content-Type' content='text/html;charset=utf-8'>");
?>
<link type="text/css"  rel="stylesheet" href="common/css/style.css"/>
<link href="common/css/print.css?ver=1.0.0" rel="stylesheet" type="text/css" media="print" />
<link type="image/png" rel="icon" href="common/img/icon.png">
<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
