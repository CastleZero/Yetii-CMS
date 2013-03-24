<?php
$uri = $_SERVER['REQUEST_URI'];
if (substr($uri, 0, strlen(ROOTURL)) == ROOTURL) {
	$uri = substr($uri, strlen(ROOTURL));
}
if (substr($uri, -1) == '/') {
	$uri = substr($uri, 0, strlen($uri) - 2);
}
$explodeduri = explode('/', $uri);
if (count($explodeduri) > 2) {
	$breadcrumburl = ROOTURL;
	echo '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';
	for ($i = 0; $i < count($explodeduri); $i++) {
		if ($i + 1 != count($explodeduri)) {
			// Not on the last item
			$breadcrumburl = $breadcrumburl . $explodeduri[$i] . '/';
			$friendlyName = html_entity_decode($explodeduri[$i]);
			$friendlyName = str_replace('%20', ' ', $friendlyName);
			$friendlyName = ucwords($friendlyName);
			echo '<a href="' . $breadcrumburl . '" itemprop="url"><span itemprop="title">' . $friendlyName . '</span></a> > ';
		} else {
			if (PAGENAME) {
				echo PAGENAME;
			} else {
				echo 'Current Page';
			}
		}
	}
	echo '</div>';
}
?>