<?php
$pageName = 'Manage Images';
$requiredAuth = 3;
?>
<a href="upload.php">Upload Image</a><br>
<?php
$images = glob(IMAGESFOLDER . '*');
if (!empty($images)) {
	// There are some photos in the photos directory
	?>
	Clicking "Manage Image" will give you the URL that can be used when creating a page.<br>
	<table>
		<th>File Name</th>
		<th>Size (MB)</th>
		<th>Manage Image</th>
		<th>Delete</th>
		<?php
		foreach ($images as $image) {
			if (is_file($image)) {
				// File is an image
				$imageInfo = getimagesize($image);
				$fileName = str_replace(IMAGESFOLDER, '', $image);
				$fileSize = round(filesize($image)/1000/1000, 2); // Get the size in Megabytes to 2 decimal places
				?>
				<tr>
					<td><?php echo $fileName; ?></td>
					<td><?php echo $fileSize; ?></td>
					<td><a href="manage.php?image=<?php echo $fileName; ?>">Manage Image</a></td>
					<td><a href="delete.php?image=<?php echo $fileName; ?>">Delete Image</a></td>
				</tr>
				<?php
			} else {
				?>
				<tr>
					<td>Error loading image "<?php echo $image; ?>"</td>
				</tr>
				<?php
			}
		}
		?>
	</table>
<?php
}
?>