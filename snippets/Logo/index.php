<?php
if ($showLogo) {
	?>
	<a href="<?php echo ROOTURL; ?>"><img src="<?php echo $imageURL; ?>" alt="<?php echo WEBSITENAME; ?>'s Logo"></a>
	<?php
}
if ($showText) {
	echo $text;
}
?>