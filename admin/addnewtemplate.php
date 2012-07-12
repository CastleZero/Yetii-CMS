<?php
$title = 'Templates';
$requiredAuth = 3;
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	?>
	Please upload either:
	<ul>
		<li>A single HTML Template file</li>
		<li>A single HTML Template file + its default.ini counterpart with the file name</li>
		<del><li>A single zip archive with either of the above</li></del>
	</ul>
	<form method="POST" enctype="multipart/form-data">
		<label for="file">Theme File(s)</label>
		<input type="file" name="files[]" multiple="multiple">
		<input type="submit">
	</form>
	<?php
} else {
	// Files have just been uploaded, store them in a temporary folder
	$allowedFileExtensions = array('html', 'ini');
	$errors = array();
	$htmlFile = false;
	$defaultsiniFile = false;
	if (isset($_POST['templateName'])) {
		$templateName = $_POST['templateName'];
	} else if (!isset($templateName)) {
		$templateName = 'Default Name';
	}
	if (!isset($_POST['tempFolder'])) {
		// Files have been uploaded
		$uploadedFiles = $_FILES['files'];
		$tempFolder = sys_get_temp_dir() . '\\' . uniqid('upload_', TRUE) . '\\';
		mkdir($tempFolder);
		for ($i = 0; $i < count($uploadedFiles['name']); $i++) {
			$fileInfo = pathinfo($uploadedFiles['name'][$i]);
			$fileName = $fileInfo['filename'];
			$fileExtension = $fileInfo['extension'];
			$tempFileName = $uploadedFiles['tmp_name'][$i];
			if ($fileName . '.' . $fileExtension == 'defaults.ini') {
				$defaultsiniFile = $tempFolder . $fileName . '.' . $fileExtension;
			}
			if ($fileExtension == 'html') {
				$htmlFile = $tempFolder . $fileName . '.' . $fileExtension;
			}
			if (!in_array($fileExtension, $allowedFileExtensions)) {
				$error = array();
				$error['message'] = 'File type "' . $fileExtension . '" not allowed';
				array_push($errors, $error);
			} else {
				// File extension is acceptable, move the file to a temporary folder
				move_uploaded_file($tempFileName, $tempFolder . $fileName . '.' . $fileExtension);
			}
		}
		if (!$htmlFile) {
			$error = array();
			$error['message'] = 'No HTML file was uploaded. Please upload a HTML file.';
			array_push($errors, $error);
		}
	} else {
		// Files have already been uploaded and are being stored in a temporary folder
		$tempFolder = $_POST['tempFolder'];
		// Get the template name
		foreach (glob($tempFolder . '*') as $fileName) {
			$fileInfo = pathinfo($tempFolder . $fileName);
			$fileName = $fileInfo['filename'];
			$fileExtension = $fileInfo['extension'];
			$file['name'] = $fileName;
			$file['extension'] = $fileExtension;
			if ($fileName . '.' . $fileExtension == 'defaults.ini') {
				$defaultsiniFile = $tempFolder . $fileName . '.' . $fileExtension;
			} else if ($fileExtension == 'html') {
				$htmlFile = $tempFolder . $fileName . '.html';
			}
		}
	}
	if (count($errors) == 0  && !isset($_POST['moveTemplate'])) {
		// We have not errors so far (at least a HTML file) and are not being asked to move the template from the temporary folder
		$html = file_get_html($htmlFile);
		$elements = array();
		// Find all the divs with an id
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
			<input type="text" name="templateName" value="<?php echo $templateName; ?>"><br>
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
					echo '<option value="none" disabled="disabled">Snippets</option>';
					// foreach ($snippets as $snippet) {

					// }
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
			<input type="hidden" name="tempFolder" value="<?php echo $tempFolder; ?>" >
			<input type="hidden" name="createPreview">
			<input type="submit" value="Create Preview">
		</form>
		<?php
		if (isset($_POST['createPreview'])) {
			// The "create preview" button has been pressed and the user is not yet finished with editing the template
			// Create the ini file with the current variables
			$templateOptionsArray = array();
			foreach ($elements as $element) {
				if ($_POST[$element . '_element'] != 'none') {
					$section = array('name' => $element, 'variable' => $_POST[$element . '_element'], 'replace' => $_POST[$element . '_replace']);
					array_push($templateOptionsArray, $section);
				}
			}
			// foreach ($snippets as $snippet) {

			// }
			if (count($templateOptionsArray) > 0) {
				// At least 1 option has been provided
				$iniFile = $tempFolder . 'elements.ini';
				write_ini_file($templateOptionsArray, $iniFile, true);
			} else {
				$error = array('message' => 'No options selected, please select at least 1 option.');
				array_push($errors, $error);
			}
			?>
			This is where the preview will go.<br>
			<form method="POST">
				<input type="hidden" name="tempFolder" value="<?php echo $tempFolder; ?>">
				<input type="hidden" name="templateName" value="<?php echo $templateName; ?>">
				<input type="hidden" name="moveTemplate">
				<input type="submit" value="Complete the Template">
			</form>
			<?php
		}
	} else if (count($errors) == 0 && isset($_POST['moveTemplate'])) {
		// No errors and the user is happy with the template preview, so move the template
		while(is_dir(TEMPLATESFOLDER . $templateName)) {
			$templateName .= '_';
		}
		mkdir(TEMPLATESFOLDER . $templateName);
		// Move the files from the temporary folder to a permanent folder
		foreach (glob($tempFolder . '*') as $fileName) {
			$fileInfo = pathinfo($tempFolder . $fileName);
			$fileName = $fileInfo['filename'];
			$fileExtension = $fileInfo['extension'];
			if (!rename($tempFolder . $fileName . '.' . $fileExtension, TEMPLATESFOLDER . $templateName . '/' . $fileName . '.' . $fileExtension)) {
				$error = array('message' => 'There was an error moving "' . $fileName . $fileExtension . '". This may cause the template to not function correctly, and should be looked into.');
				array_push($errors, $error);
			}
		}
		if (!rmdir($tempFolder)) {
			echo 'There was an error deleting the temporary directory. This warning can be ignored, but should be looked into.<br>';
		}
		if (count($errors) == 0) {
			// No errors, theme successfully uploaded
			echo 'Template was uploaded successfully under the name "' . $templateName .'" and can now be used!<br>';
		}
	}
	if (count($errors) > 0) {
		ShowErrors($errors);
	}
}
?>
