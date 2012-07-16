<?php
// Get all the links
$mapper = new Mapper();
$linksArray = $mapper->GetLinks();
$links = '';
// Create a string with all the links as list items
foreach($linksArray as $linkArray) {
	$links .= '<a href="' . $linkArray['url'] . '" title="' . $linkArray['title'] . '"><li>' . $linkArray['name'] . '</li></a>';
}
unset($mapper);
echo '<ul>' . $links . '</ul>';
?>