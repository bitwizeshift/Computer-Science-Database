<?php
/**
 * 
 * 
 * 
 * 
 */


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