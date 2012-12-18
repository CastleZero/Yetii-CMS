<?php
if ($showLogo) {
	?>
	<a href="<?php echo ROOTURL; ?>"><img src="<?php echo $imageURL; ?>" alt="Go Home"></a>
	<?php
}
if ($showText) {
	echo $text;
}
?>