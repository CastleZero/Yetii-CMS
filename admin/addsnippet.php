<?php
$title = 'New Snippet';
$requiredAuth = 3;
if (isset($_GET['createAs'])) {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Form has been submitted
		$createAs = $_POST['createAs'];
		$snippetName = $_POST['snippetName'];
		$snippetCode = $_POST['snippetCode'];
		if ($createAs == '') {
			// Creating a new snippet
			if (is_dir(SNIPPETSFOLDER . $snippetName)) {
				$error = array('message' => 'A snippet with the name "' . $snippetName . '" already exists! Please choose another name.', 'fieldId' => 'snippetName');
				array_push($errors, $error);
				ShowErrors($errors);
			} else {
				// Snippet name does not already exist, create the snippet and return to stop the form showing again
				if (mkdir(SNIPPETSFOLDER . $snippetName)) {
					if (file_put_contents(SNIPPETSFOLDER . $snippetName . '/index.php', $snippetCode)) {
						echo 'Snippet created. You can <a href="/admin/snippets.php?snippet=' . $snippetName . '">edit the snippet</a> if you wish.<br>';
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
			// Adding to an existing snippet
			if (is_file(SNIPPETSFOLDER . $createAs . $snippetName)) {
				// File already exists
				echo 'File "' . $snippetName . '" already exists in the "' . $createAs . '" folder. Please choose a new name.<br>';
			} else {
				if (file_put_contents(SNIPPETSFOLDER . $createAs . $snippetName, $snippetCode)) {
					echo 'Snippet created. You can <a href="/admin/snippets.php?snippet=' . $createAs . $snippetName . '">edit the snippet</a> if you wish.<br>';
					return;
				} else {
					echo 'There was an error creating the file. Please try again.<br>';
				}
			}
		}
	} else {
		// Form has not been submitted
	}
} else {
	?>
	<form method="GET">
		Create a new
		<select name="createAs">
			<option value="blank">Blank</option>
			<?php
			$snippets = GetSnippets();
			foreach ($snippets as $snippet) {
				if ($snippet['type'] == 'dynamic') {
					echo '<option value="' . $snippet . '">' . $snippet . '</option>';
				}
			}
			?>
		</select> snippet.
		<input type="submit" value="Go">
	</form>
	<?php
}
?>