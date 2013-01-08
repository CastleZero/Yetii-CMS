<?php
$pageName = "Manage Image";
$requiredAuth = 3;
if (isset($_GET['image'])) {
	if ($image = getimagesize(IMAGESFOLDER . $_GET['image'])) {
		$imageName = $_GET['image'];
		?>
		Currently all this does is show you the image. You will be able to change some things in the future :)<br>
		<form method="post">
			<input type="text" name="imageName" value="<?php echo $imageName; ?>" disabled="disabled"><br>
			<img src="<?php echo ROOTFOLDER . IMAGESFOLDER . $imageName; ?>" <?php echo $image[3]; ?>><br>
			<input type="submit" value="Submit Changes"><br>
			Copy the contents of the textarea area and paste it in the URL when adding an image to a page.<br>
			<textarea cols="30" rows="2"><?php echo '<?php echo ROOTFOLDER . IMAGESFOLDER; ?>' . $imageName; ?></textarea><br>
		</form>
		<?php
	} else {
		?>
		<a href="<?php echo ROOTFOLDER . ADMINFOLDER; ?>images/">Invalid image provided, please choose an image to manage.</a><br>
		<?php
	}
} else {
	?>
	<a href="<?php echo ROOTFOLDER . ADMINFOLDER; ?>images/">Please choose an image to manage.</a><br>
	<?php
}