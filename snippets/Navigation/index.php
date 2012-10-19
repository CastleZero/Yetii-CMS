<?php
// Get all the links
$mapper = new Mapper();
$linksArray = $mapper->GetLinks();
unset($mapper);
if ($linksArray !== false) {
	$links = '';
	$numberOfLinks = 0;
	// Get the number of links to be displayed
	foreach($linksArray as $linkArray) {
		if ($linkArray['order'] >= 0) {
			if ($linkArray['required_auth'] <= UsersAuth()) {
				$numberOfLinks++;	
			}
		}
	}
	if ($numberOfLinks < 3) {
		$numberOfLinks = 3;
	}
	$linkWidth = 100/$numberOfLinks;
	$linkPadding = (15/$numberOfLinks)/2;
	// Create a string with all the links as list items
	foreach($linksArray as $linkArray) {
		if ($linkArray['order'] >= 0) {
			if ($linkArray['required_auth'] <= UsersAuth()) {
				if ($linkArray['use_root']) {
					$linkURL = ROOTURL . $linkArray['url'];
				} else {
					$linkURL = $linkArray['url'];
				}
				$links .= '<li style="width: ' . $linkWidth . '%;"><a href="' . $linkURL . '" title="' . $linkArray['title'] . '">' . $linkArray['name'] . '</a></li>';
			}
		}
	}
	echo '<ul class="clearfix">' . $links . '</ul>';
} else {
	echo 'No links stored in the database';
}
?>