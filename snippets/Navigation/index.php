<?php
// Get all the links
require_once('navigationmapper.class.php');
$mapper = new NavigationMapper();
$links = $mapper->getLinks();
unset($mapper);
if ($links !== false) {
	$code = '';
	$numberOfLinks = 0;
	// Get the number of links to be displayed
	foreach($links as $link) {
		if ($link['order'] >= 0) {
			if ($link['requiredAuth'] <= usersAuth()) {
				$numberOfLinks++;	
			}
		}
	}
	if ($numberOfLinks < 3) {
		$numberOfLinks = 3;
	}
	$width = 100/$numberOfLinks;
	$padding = (15/$numberOfLinks)/2;
	// Create a string with all the links as list items
	foreach($links as $link) {
		if ($link['order'] >= 0) {
			if ($link['requiredAuth'] <= usersAuth()) {
				if ($link['useRoot']) {
					$url = ROOTURL . $link['url'];
				} else {
					$url = $link['url'];
				}
				if ($_SERVER['REQUEST_URI'] == $url || $_SERVER['REQUEST_URI'] == $url . '.php' || $_SERVER['REQUEST_URI'] == substr($url, 0, -4)) {
					$class = ' class="currentPage"';
				} else {
					$class = '';
				}
				$code .= '<li style="width: ' . $width . '%;"' . $class . '><a href="' . $url . '" title="' . $link['title'] . '" target="' . $link['target'] . '">' . $link['name'] . '</a></li>';
			}
		}
	}
	echo '<ul class="clearfix">' . $code . '</ul>';
} else {
	echo 'No links stored in the database';
}
?>