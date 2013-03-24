<?php
if (isset($imageName)) {
	if (substr($imageName, 0, 1) != '/') {
		// Image is stored on the server
		if (is_file($imageName)) {
			$imageURL = ROOTURL . $imageName;
		} else {
			if (is_file(IMAGESFOLDER . $imageName)) {
				$imageURL = ROOTURL . IMAGESFOLDER . $imageName;
			} else {
				$imageURL = false;
			}
		}
	}
	if ($imageURL) {
		?>
		<img src="<?php echo $imageURL; ?>" <?php echo (isset($imageAlt)) ? 'alt="' . $imageAlt . '"' : ''; echo (isset($class)) ? 'class="' . $class . '"' : ''; ?>>
		<?php
	} else {
		echo 'Error loading image "' . $imageName . '".<br>';
	}
}
?>