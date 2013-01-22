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
			[Images:{"imageName":"<?php echo $imageName; ?>"}]<br>
			<input type="submit" value="Submit Changes"><br>
			Copy the contents of the textarea area and paste it in a page.<br>
			<textarea cols="50" rows="5">dummy_[Images:{"imageName":"<?php echo $imageName; ?>"}]</textarea><br>
		</form>
		<?php
	} else {
		?>
		<a href="config.php">Invalid image provided, please choose an image to manage.</a><br>
		<?php
	}
} else {
	?>
	<a href="config.php">Please choose an image to manage.</a><br>
	<?php
}