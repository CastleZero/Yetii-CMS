<?php
$title = 'Templates';
$requiredAuth = 3;
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	?>
	Please upload either a single zip archive with all your template in
	<form method="POST" enctype="multipart/form-data">
		<label for="file">Template File</label>
		<input type="file" name="files[]">
		<input type="submit">
	</form>
	<?php
} else {
	// Files have already been uploaded
	$errors = array();
	if (isset($_POST['useTemplate'])) {
		// No errors and the user is happy with the template preview, use the template
		echo 'Template has been uploaded under the name "' . $_POST['templateName'] . '" and will now be used across the website.<br>';
	} else if (isset($_POST['deleteTemplate'])) {
		// User does not want the template, delete it
		if (DeleteDirectory(TEMPLATESFOLDER . $_POST['templateName'])) {
			echo 'Template deleted.<br>';
		} else {
			echo 'Template could not be deleted.<br>';
		}
	} else {
		// User has not finished
		$htmlFile = false;
		$defaultsiniFile = false;
		if (isset($_POST['templateName'])) {
			$templateName = $_POST['templateName'];
		} else if (!isset($templateName)) {
			$templateName = 'Default Name';
		}
		if (!isset($_POST['createPreview'])) {
			// Files have been uploaded and haven't been moved yet
			$uploadedFiles = $_FILES['files'];
			$tempFolder = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('upload_', TRUE) . DIRECTORY_SEPARATOR;
			mkdir($tempFolder);
			for ($i = 0; $i < count($uploadedFiles['name']); $i++) {
				$fileInfo = pathinfo($uploadedFiles['name'][$i]);
				$fileName = $fileInfo['filename'];
				$fileExtension = $fileInfo['extension'];
				$fullFileName = $fileInfo['basename'];
				$tempFileName = $uploadedFiles['tmp_name'][$i];
				if ($fileExtension == 'zip') {
					// Move the archive to a folder where we have write permissions
					move_uploaded_file($tempFileName, $tempFolder . $fullFileName);
					$zip = new ZipArchive();
					if ($zip->open($tempFolder . $fullFileName)) {
						// zip file successfully opened, extract it to the temporary zip folder
						$zip->extractTo($tempFolder);
						if (is_dir($tempFolder . $zip->getNameIndex(0))) {
							// The first item _should_ be the name of the folder that the zip file extracted into (which is is also the template name)
							$templateName = $zip->getNameIndex(0);
							$templateName = substr_replace($templateName, '', -1);
						}
						$originalName = $templateName;
						while (is_dir(TEMPLATESFOLDER . $templateName)) {
							$templateName = $templateName . '_';
						}
						mkdir(TEMPLATESFOLDER . $templateName);
						for ($i = 0; $i < $zip->numFiles; $i++) {
							// Loop through each file in the zip archive
							$entryInfo = $zip->statIndex($i);
							$entryLocation = $entryInfo['name'];
							$entryInfo = pathinfo($entryInfo['name']);
							$entryName = $entryInfo['basename'];
							$directory = $entryInfo['dirname'];
							$entryFileName = $entryInfo['filename'];
							// Get the original directory name (e.g. no template name in the directory name)
							if (strpos($directory, $originalName . '/') !== false) {
								// Entry is in a directory that is not in the top level
								$originalDirectory = str_replace($originalName . '/', '', $directory);
							} else {
								// Entry is in the top level directory
								$originalDirectory = str_replace($originalName, '', $directory);
								if ($entryName== 'index.html') {
									$htmlFile = TEMPLATESFOLDER . $templateName . '/' . $entryName;
								} else if ($entryName == 'defaults.ini') {
									$defaultsiniFile = TEMPLATESFOLDER . $templateName . '/' . $entryName;
								}
							}
							if (strpos($directory, $originalName) == 0 && $directory != '.' && $entryFileName != '' && strpos($originalDirectory, '__MACOSX') === false) {
								// Entry is something we want (e.g. starts with the original name, not a dot-file, has a file name and does not have __MACOSX in the directory name)
								if (!is_dir(TEMPLATESFOLDER . $templateName . '/' . $originalDirectory)) {
									// Folder has not been created in the new folder yet
									mkdir(TEMPLATESFOLDER . $templateName . '/' . $originalDirectory);
								}
								$old = $tempFolder . $directory . DIRECTORY_SEPARATOR . $entryName;
								if ($originalDirectory != '') {
									$originalDirectory = '/' . $originalDirectory;
								}
								$new = TEMPLATESFOLDER . $templateName . $originalDirectory . DIRECTORY_SEPARATOR . $entryName;
								if (is_file($old)) {
									// Entry is a file, not a directory, move it
									Move($old, $new);
								}
							}
						}
						$zip->close();
						// Delete the temporary folder that the zip file was in
						if (!DeleteDirectory($tempFolder)) {
							echo 'There was an error deleting the temporary zip folder.<br>';
						}
					} else {
						$error = array();
						$error['message'] = 'Error opening zip file.';
						array_push($errors, $error);
					}
				} else {
					// File is not the defaults.ini, index.html or a zip file
					$error = array();
					$error['message'] = 'Please only upload a zip file';
					array_push($errors, $error);
				}
			}
			if (!$htmlFile) {
				$error = array();
				$error['message'] = 'No HTML file was uploaded. Please upload a HTML file.';
				array_push($errors, $error);
			}
		} else {
			// Files have already been uploaded and moved
			$templateName = $_POST['templateName'];
			foreach (glob(TEMPLATESFOLDER . $templateName . DIRECTORY_SEPARATOR . '*') as $fileName) {
				$fileInfo = pathinfo($fileName);
				if (array_key_exists('extension', $fileInfo)) {
					// Current value is not a directory
					$fileName = $fileInfo['basename'];
					$fileExtension = $fileInfo['extension'];
					if ($fileName . '.' . $fileExtension == 'defaults.ini') {
						$defaultsiniFile = TEMPLATESFOLDER . $templateName . '/' . $fileName;
					} else if ($fileExtension == 'html') {
						$htmlFile = TEMPLATESFOLDER . $templateName . '/' . $fileName;
					}
				}
			}
		}
		if (count($errors) == 0  && !isset($_POST['moveTemplate'])) {
			// We have not errors so far (at least a HTML file) and are not being asked to move the template from the temporary folder
			$html = file_get_html($htmlFile);
			$elements = array();
			//Find all the divs with an id
			foreach ($html->find('div[id]') as $div) {
				array_push($elements, $div->attr['id']);
			}
			// Array with HTML elements
			$htmlElements = array('head', 'header', 'nav', 'footer', 'section', 'title');
			// Find any extra HTML elements that might have been used
			foreach ($htmlElements as $element) {
				if ($html->find($element)) {
					array_push($elements, $element);
				}
			}
			?>
			Choose a part of the website to display in the following HTML elements. Choose "none" if the element does not require dynamically filling with content.<br>
			<form method="POST" id="templateOptions" name="templateOptions">
				<?php
				foreach ($elements as $element) {
					if (isset($_POST[$element . '_element'])) {
						$checkedElementValue = $_POST[$element . '_element'];
					} else if ($defaultsiniFile !== false) {
						$defaults = parse_ini_file($defaultsiniFile, true);
						foreach ($defaults as $default) {
							if ($default['name'] == $element) {
								if (array_key_exists('variable', $default)) {
									$checkedElementValue = $default['variable'];
								} else if (!isset($checkedElementValue)) {
									$checkedElementValue = false;
								}
							} else if (!isset($checkedElementValue)) {
								$checkedElementValue = false;
							}
						}
					} else {
						$checkedElementValue = false;
					}
					if (isset($_POST[$element . '_replace'])) {
						$checkedReplaceValue = $_POST[$element . '_replace'];
					} else if ($defaultsiniFile !== false) {
						$defaults = parse_ini_file($defaultsiniFile, true);
						foreach ($defaults as $default) {
							if ($default['name'] == $element) {
								if (array_key_exists('replace', $default)) {
									$checkedReplaceValue = $default['replace'];
								} else if (!isset($checkedReplaceValue)) {
									$checkedReplaceValue = false;
								}
							} else if (!isset($checkedReplaceValue)) {
								$checkedReplaceValue = false;
							}
						}
					} else {
						$checkedReplaceValue = false;
					}
					// Create all the default elements
					$availableElements = array(
						'pageTitle' => 'Title (HTML Head)',
						'header' => 'Header',
						'navigation' => 'Navigation',
						'pageContents' => 'Page Contents',
						'footer' => 'Footer');
					echo $element;
					?>
					:<select name="<?php echo $element; ?>_element">
						<option value="none">None</option>
						<option value="none" disabled="disabled">Variables</option>
						<?php
						foreach ($availableElements as $value => $displayName) {
							echo '<option value="' . $value . '"';
							if ($value == $checkedElementValue) echo 'selected="selected"';
							echo '>' . $displayName . '</option>';
						}
						$snippets = GetSnippets();
						if (count($snippets) > 0) {
							echo '<option value="none" disabled="disabled">Snippets</option>';
							foreach ($snippets as $snippet) {
								$value = $snippet['value'];
								$displayName = $snippet['displayName'];
								echo '<option value="' . $value . '"';
								if ($value == $checkedElementValue) echo 'selected="selected"';
								echo '>' . $displayName . '</option>';
							}
						}
						?>
					</select>
					Fill Level: 
					<select name="<?php echo $element; ?>_replace">
						<option value="full" <?php if ($checkedReplaceValue == 'full') echo 'selected="selected"'; ?>>Full</option>
						<option value="before" <?php if ($checkedReplaceValue == 'before') echo 'selected="selected"'; ?>>Before</option>
						<option value="after" <?php if ($checkedReplaceValue == 'after') echo 'selected="selected"'; ?>>After</option>
					</select><br>
					<?php
				}
				?>
				<input type="hidden" name="templateName" value="<?php echo $templateName; ?>" >
				<input type="hidden" name="createPreview">
				<input type="submit" value="Create Preview">
			</form>
			<?php
			if (isset($_POST['createPreview'])) {
				// The "create preview" button has been pressed and the user is not yet finished with editing the template
				// Create the ini file with the current variables
				$templateOptionsArray = array('variables', 'snippets');
				$snippets = GetSnippets();
				foreach ($elements as $element) {
					if ($_POST[$element . '_element'] != 'none') {
						var_dump($element);
						var_dump($snippets);
						if (array_key_exists($element, $snippets)) {
							echo 'You chose a snippet<br>';
						}
						$section = array('name' => $element, 'variable' => $_POST[$element . '_element'], 'replace' => $_POST[$element . '_replace']);
						array_push($templateOptionsArray, $section);
					}
				}
				if (count($templateOptionsArray) > 0) {
					// At least 1 option has been provided, create the preview
					$iniFile = TEMPLATESFOLDER . $templateName . '/elements.ini';
					write_ini_file($templateOptionsArray, $iniFile, true);
					?>
					<iframe src="/index.php?template=<?php echo TEMPLATESFOLDER . $templateName; ?>" style="width: 100%; height: 400px;"></iframe>
					<form method="POST">
						<input type="hidden" name="templateName" value="<?php echo $templateName; ?>">
						<input type="hidden" name="useTemplate">
						<input type="submit" value="Use the Template">
					</form>
					<?php
				} else {
					$error = array('message' => 'No options selected, please select at least 1 option.');
					array_push($errors, $error);
				}
			}
		}
	}
	if (count($errors) > 0) {
		ShowErrors($errors);
	}
}
?>
