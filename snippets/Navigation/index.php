<?php
// Get all the links
$mapper = new Mapper();
$linksArray = $mapper->GetLinks();
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
if ($numberOfLinks < 5) {
	$numberOfLinks = 5;
}
$linkWidth = 90/$numberOfLinks;
$linkPadding = (10/$numberOfLinks)/2;
$textColor = 'orange';
// Create a string with all the links as list items
foreach($linksArray as $linkArray) {
	if ($linkArray['order'] >= 0) {
		if ($linkArray['required_auth'] <= UsersAuth()) {
			$links .= '<li style="width: ' . $linkWidth . '%; margin: 0.5em ' . $linkPadding . '%; color: ' . $textColor . ';"><a href="' . $linkArray['url'] . '" title="' . $linkArray['title'] . '">' . $linkArray['name'] . '</a></li>';
			if ($textColor == 'orange') {
				$textColor = 'blue';
			} else {
				$textColor = 'orange';
			}
		}
	}
}
unset($mapper);
echo '<ul>' . $links . '</ul>';
?>