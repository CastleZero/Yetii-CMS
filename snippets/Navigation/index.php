<?php
// Get all the links
$mapper = new Mapper();
$linksArray = $mapper->GetLinks();
$links = '';
// Create a string with all the links as list items
foreach($linksArray as $linkArray) {
	if ($linkArray['order'] >= 0) {
		$links .= '<li><a href="' . $linkArray['url'] . '" title="' . $linkArray['title'] . '">' . $linkArray['name'] . '</a></li>';
	}
}
unset($mapper);
echo '<ul>' . $links . '</ul>';
?>