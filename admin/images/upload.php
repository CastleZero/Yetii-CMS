<?php
$pageName = 'Upload an image';
$requiredAuth = 3;
$maxUpload = (ini_get('upload_max_filesize'));
$maxPost = (ini_get('post_max_size'));
$memoryLimit = (ini_get('memory_limit'));
$uploadLimit = min($maxUpload, $maxPost, $memoryLimit);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// An image has been uploaded
	$imageName = $_FILES['uploadedImage']['name'];
	$tempFile = $_FILES['uploadedImage']['tmp_name'];
	if (getimagesize($tempFile)) {
		// Upload is an image
		if (is_file(IMAGESFOLDER . $imageName)) {
			echo 'An image already exists with that name. Please delete the image or rename either image.<br>';
		} else {
			if (move_uploaded_file($tempFile, IMAGESFOLDER . $imageName)) {
				echo 'Image was successfully uploaded. You can upload more imaged below.<br>';
			} else {
				echo 'There was an error uploading the file, please try again.<br>';
			}
		}
	} else {
		echo 'Uploaded file was not a recognised image. Please upload an image or convert the file to a more common image type.<br>';
	}
}
?>
Choose an image to upload to the images folder (<?php echo IMAGESFOLDER; ?>). The maximum upload size is <?php echo $uploadLimit; ?>.<br>
<form method="POST" enctype="multipart/form-data">
	<input type="file" name="uploadedImage"><br>
	<input type="submit" value="Upload"><br>
</form>