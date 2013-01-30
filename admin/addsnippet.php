<?php
$title = 'New Snippet';
$requiredAuth = 3;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Form has been submitted
	$snippetName = $_POST['snippetName'];
	$snippetCode = $_POST['snippetCode'];
	// Create a new snippet
	if (is_dir(SNIPPETSFOLDER . $snippetName)) {
		$error = array('message' => 'A snippet with the name "' . $snippetName . '" already exists! Please choose another name.', 'fieldId' => 'snippetName');
		$errors = array();
		array_push($errors, $error);
		showErrors($errors);
	} else {
		// Snippet name does not already exist, create the snippet and return to stop the form showing again
		if (mkdir(SNIPPETSFOLDER . $snippetName)) {
			if (file_put_contents(SNIPPETSFOLDER . $snippetName . '/index.php', $snippetCode)) {
				?>
				Snippet created. You can <a href="<?php echo ROOTURL; ?>admin/snippets.php?snippet=<?php echo $snippetName; ?>">edit the snippet</a> if you wish.<br>
				<?php
				return;
			} else {
				echo 'There was an error creating the file. Please try again.<br>';
				if (!rmdir(SNIPPETSFOLDER . $snippetName)) {
					echo 'There was an error deleting the directory for the snippet. Please try deleting "' . SNIPPETSFOLDER . $snippetName . '" manually.<br>';
				}
			}
		} else {
			echo 'There was an error creating the directory for the snippet. Please try again.<br>';
		}
	}
} else {
	?>
	<form method="POST">
		<label>Snippet Name: <input type="text" name="snippetName" id=""></label><br>
		<label>Code: <br><?php createEditor('', 'snippetCode'); ?></label><br>	
		<input type="submit" value="Save Snippet">
	</form>
	<?php
}
?>