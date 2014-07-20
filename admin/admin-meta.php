<?php 
/**
 * The administration meta file.
 * 
 * This unit contains all of the required metadata for the system to work on the back-end. 
 * 
 * @author Matthew Rodusek <rodu4140@mylaurier.ca>
 * @version 0.4 2014-07-19
 *
 * @package AffinityFramework
 * @subpackage Admin
 */
?>
<base href="<?=get_home_url(); ?>" target="_self">        
<script type="text/javascript" src="static/js/Markdown.Converter.js"></script>
<script type="text/javascript" src="static/js/Markdown.Sanitizer.js"></script>
<script type="text/javascript" src="static/js/Markdown.Editor.js"></script>
<!-- Must happen in this order! -->
<script type="text/x-mathjax-config;executed=true">
MathJax.Hub.Config({
	showProcessingMessages: false,
	tex2jax: { inlineMath: [['$','$'],['\\(','\\)']] }
});
</script>	
<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
<script type="text/javascript" src="static/js/mathjax-editing.js"></script>
<script type="text/javascript" src="static/js/autosuggest.js"></script>
<!-- End -->
<link rel="stylesheet" type="text/css" href="static/css/common.css?ver=1.0" />
<link rel="stylesheet" type="text/css" href="admin/css/style.css?ver=1.0"/>