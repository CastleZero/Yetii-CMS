<?php
$pageName = 'Delete an image';
$requiredAuth = 3;
if (isset($_GET['image'])) {
	$imageName = $_GET['image'];
	if (isset($_POST['confirm']) && $_POST['confirm'] == 'true') {
		// User has confirmed they wish to delete the image
		if (unlink(IMAGESFOLDER . $imageName)) {
			echo 'Image was deleted.<br>';
		} else {
			echo 'There was error deleting the error.<br>';
		}
	} else {
		// Ask the user for confirmation
		?>
		Do you really want to delete the image? This action is irreversible!<br>
		<form method="POST">
			<input type="hidden" name="confirm" value="true">
			<input type="submit" value="Delete Image"><br>
		</form>
		<?php
	}
} else {
	?>
	<a href="config.php">Please choose an image to delete.</a><br>
	<?php
}