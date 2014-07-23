<?php
/**
 * 
 * 
 * 
 * 
 */

function generate_pagination_link($page, $end, $title, $link){
	$disabled = "";
	if($page==$end)
		$disabled = " class='disabled'";
	echo("<li><a href='{$link}?page={$page}'{$disabled}>{$title}</a></li>");
}
function generate_pagination2($link){
	$page = http_value('GET', 'page', 1);
	$post_per_page = http_value('GET', 'post_per_page', 10);
	$total = isset($GLOBALS['total']) ? (int) $GLOBALS['total'] : 100;
	
	
}

function generate_pagination($current, $total, $per_page, $page='admin/post.php', $arg='page'){	
	$pages = ceil($total / $per_page);
	echo("<ol class='pagination'>");
	// Left arrows
	if($current==1){
		echo("<li><a href='#' class='disabled'>&laquo;</a></li>");
	}else{
		$temp = $current-1;
		echo("<li><a href='{$page}?{$arg}={$temp}'>&laquo;</a></li>");
	}
	// Individual pages
	for($i=1;$i <= $pages; ++$i){
		echo("<li><a href='{$page}?{$arg}={$i}'>{$i}</a></li>");
	}
	// Right arrows
	if($current==$pages){
		echo("<li><a href='#' class='disabled'>&raquo;</a></li>");
	}else{
		$temp = $current+1;
		echo("<li><a href='{$page}?{$arg}={$temp}'>&raquo;</a></li>");
	}
	echo("</ol>");
}

?>