<?php
$title = 'Pages';
$requiredAuth = 3;
$mapper = new Mapper();
$errors = array();
if (isset($_GET['pageURL'])) {
	// Editing a page
	$pageURL = $_GET['pageURL'];
	$pageVariables = GetPage($pageURL, false); // Get the page variables (unparsed)
	if ($pageVariables === false) {
		echo 'Page URL is not a valid page URL.<br>';
	} else {
		$currentPageURL = $pageURL;
		extract($pageVariables);
		$variables = parse_ini_file(PAGESFOLDER . $pageType . '/variables.ini', true);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Save the page
			$submittedVariables = array();
			if (isset($_POST['pageName']) && $_POST['pageName'] != '') {
				$submittedVariables['pageName'] = $_POST['pageName'];
			} else {
				$error = array('fieldId' => 'pageName', 'message' => 'The page name cannot be empty');
				array_push($errors, $error);
			}
			$pageURL = $_POST['pageURL'];
			if ($pageURL !== $currentPageURL) {
				// Updating page URL
				if (is_file($pageURL . '.php')) {
					$error = array('fieldId' => 'newPageURL', 'message' => 'The chosen URL is already taken by a file. Please chose another name');
					array_push($errors, $error);
				} else if (GetPage($pageURL) !== false) {
					$error = array('fieldId' => 'newPageURL', 'message' => 'The chosen URL is already taken by a page in the database. Please chose another name');
					array_push($errors, $error);
				} else {
					if ($pageSavedIn == 'file') {
						// Change the file name
						/*** We should also check if there is a link to update anywhere! ***/
						if (rename($currentPageURL . '.php', $pageURL . '.php')) {
							echo 'Page name has been updated. You will need to <a href="/admin/pages.php?pageURL=' . $pageURL . '">reload the page with the new URL</a>.<br>';
							return;
						} else {
							echo 'Error changing file name. There will be 2 versions of this file (old name and new name). Please try deleting the old name.<br>';
						}
					} else {
						echo 'Page name has been updated. You will need to <a href="/admin/pages.php?pageURL=' . $pageURL . '">reload the page with the new URL</a>.<br>';
						return;
					}
				}
			}
			foreach ($variables as $name => $variable) {
				if (array_key_exists('required', $variable)) {
					$required = $variable['required'];
				} else {
					$required = false;
				}
				if (isset($_POST[$name]) && $_POST[$name] != '') {
					// We have a none empty variable
					$submittedVariables[$name] = $_POST[$name];
				} else {
					// The variable is empty, check if it is required
					if ($required === true) {
						$error = array('fieldId' => 'newPageURL', 'message' => '"' . $name . '" is a required variable. Please enter a value and try again.');
						array_push($errors, $error);
					}
				}
			}
			if (count($errors) > 0) {
				showErrors($errors);
			} else {
				// We have all the variables we need, they have been stored, save them to the system
				$submittedVariables['pageType'] = $pageType;
				$JSONVariables = json_encode($submittedVariables);
				if ($pageSavedIn == 'database') {
					$mapper = new Mapper();
					if ($mapper->UpdatePage($pageURL, $currentPageURL, $JSONVariables)) {
						echo 'Page saved.<br>';
					} else {
						echo 'Page could not be saved.<br>';
					}
					unset($mapper);
				} else if ($pageSavedIn == 'file') {
					if (file_put_contents($pageURL . '.php', $JSONVariables)) {
						echo 'Page saved.<br>';
					} else {
						echo 'Page could not be saved.<br>';
					}
				}
			}
		}
		?>
		<form method="POST">
			Page Saved In: <?php echo $pageSavedIn; ?><br>
			Page Name: <input type="text" name="pageName" id="pageName" <?php if (isset($pageName)) echo 'value="' . $pageName . '"'; ?> required="required" ><br>
			Page URL: <input type="text" name="pageURL" id="pageURL" <?php if (isset($pageURL)) echo 'value="' . $pageURL . '"'; ?> required="required"><br>
			<?php
			foreach ($variables as $name => $variable) {
				if (array_key_exists('friendlyName', $variable)) {
					$friendlyName = $variable['friendlyName'];
				} else {
					$friendlyName = ucwords($name);
				}
				if (array_key_exists('type', $variable)) {
					$type = $variable['type'];
				} else {
					$type = 'text';
				}
				if (array_key_exists('required', $variable)) {
					$required = $variable['required'];
				} else {
					$required = false;
				}
				if (array_key_exists('description', $variable)) {
					$description = $variable['description'];
				} else {
					$description = false;
				}
				if (isset($_POST[$name])) {
					$value = $_POST[$name];
				} else if (array_key_exists($name, $pageVariables)) {
					$value = $pageVariables[$name];
				} else {
					$value = '';
				}
				echo $friendlyName . ': ';
				switch ($type) {
					case 'textarea':
						?>
						<textarea name="<?php echo $name; ?>" id="<?php echo $name; ?>" <?php if ($required === true) echo 'required="required"'; ?>><?php echo $value; ?></textarea>
						<?php
						break;
					case 'wysiwyg':
						CreateEditor($value, $name);
						break;
					default:
						?>
						<input type="<?php echo $type; ?>" name="<?php echo $name; ?>" id="<?php echo $name; ?>" <?php if ($required === true) echo 'required="required"'; ?> value="<?php echo $value; ?>">
						<?php
						break;
				}
				echo '<br>';
			}
			?>
			<input type="submit" value="Save Page">
		</form>
		<?php
	}
} else if (isset($_GET['newPageType'])) {
	// Creating a new page
	$pageTypes = GetPageTypes();
	$newPageType = $_GET['newPageType'];
	foreach ($pageTypes as $pageType) {
		if ($pageType['pageType'] == $newPageType) {
			// We have found the requested page type in the list of available page type
			$valid = $pageType['valid'];
		}
	}
	if (isset($valid)) {
		// Page type exists
		if ($valid === true) {
			$variables = parse_ini_file(PAGESFOLDER . $newPageType . '/variables.ini', true);
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				// New page form has been submitted
				$submittedVariables = array();
				if (isset($_POST['saveToDatabase']) && $_POST['saveToDatabase'] === 'on') {
					$saveToDatabase = true;
				} else {
					$saveToDatabase = false;
				}
				if (isset($_POST['pageName']) && $_POST['pageName'] != '') {
					$submittedVariables['pageName'] = $_POST['pageName'];
				} else {
					$error = array('fieldId' => 'pageName', 'message' => 'The page name cannot be empty');
					array_push($errors, $error);
				}
				$newPageURL = $_POST['newPageURL'];
				if (is_file($newPageURL . '.php')) {
					$error = array('fieldId' => 'newPageURL', 'message' => 'The chosen URL is already taken by a file. Please chose another name');
					array_push($errors, $error);
				} else if (GetPage($newPageURL) !== false) {
					$error = array('fieldId' => 'newPageURL', 'message' => 'The chosen URL is already taken by a page in the database. Please chose another name');
					array_push($errors, $error);
				}
				foreach ($variables as $name => $variable) {
					if (array_key_exists('required', $variable)) {
						$required = $variable['required'];
					} else {
						$required = false;
					}
					if (isset($_POST[$name]) && $_POST[$name] != '') {
						// We have a none empty variable
						$submittedVariables[$name] = $_POST[$name];
					} else {
						// The variable is empty, check if it is required
						if ($required === true) {
							$error = array('fieldId' => 'newPageURL', 'message' => '"' . $name . '" is a required variable. Please enter a value and try again.');
							array_push($errors, $error);
						}
					}
				}
				if (count($errors) > 0) {
					showErrors($errors);
				} else {
					// We have all the variables we need, they have been stored, save them to the system
					$submittedVariables['pageType'] = $newPageType;
					$JSONVariables = json_encode($submittedVariables);
					if ($saveToDatabase) {
						$mapper = new Mapper();
						$mapper->AddNewPage($newPageURL, $JSONVariables);
						unset($mapper);
						echo 'Page saved to database.<br>';
					} else {
						if (file_put_contents($newPageURL . '.php', $JSONVariables)) {
							echo 'File saved.<br>';
						} else {
							echo 'File could not be saved.<br>';
						}
					}
				}
			}
			?>
			<form method="POST">
				Save To Database: <input type="checkbox" name="saveToDatabase" id="newPageURL" <?php if (isset($saveToDatabase) && $saveToDatabase === true) echo 'checked="checked"'; ?>><br>
				New Page Name: <input type="text" name="pageName" id="pageName" required="required"><br>
				New Page URL: <input type="text" name="newPageURL" id="newPageURL" <?php if (isset($newPageURL)) echo 'value="' . $newPageURL . '"'; ?> required="required"><br>
				<?php
				foreach ($variables as $name => $variable) {
					if (array_key_exists('friendlyName', $variable)) {
						$friendlyName = $variable['friendlyName'];
					} else {
						$friendlyName = ucwords($name);
					}
					if (array_key_exists('type', $variable)) {
						$type = $variable['type'];
					} else {
						$type = 'text';
					}
					if (array_key_exists('default', $variable)) {
						$value = $variable['default'];
					} else {
						$value = false;
					}
					if (array_key_exists('required', $variable)) {
						$required = $variable['required'];
					} else {
						$required = false;
					}
					if (array_key_exists('description', $variable)) {
						$description = $variable['description'];
					} else {
						$description = false;
					}
					echo $friendlyName . ': ';
					switch ($type) {
						case 'textarea':
							?>
							<textarea name="<?php echo $name; ?>" id="<?php echo $name; ?>" <?php if ($required === true) echo 'required="required"'; ?>><?php echo $value; ?></textarea>
							<?php
							break;
						case 'wysiwyg':
							CreateEditor(false, $name);
						default:
							?>
							<input type="<?php echo $type; ?>" name="<?php echo $name; ?>" id="<?php echo $name; ?>" <?php if ($required === true) echo 'required="required"'; ?> value="<?php echo $value; ?>">
							<?php
							break;
					}
					echo '<br>';
				}
				?>
				<input type="submit" value="Save New Page">
			</form>
			<?php
		} else {
			echo 'Page Type is invalid: "' . $valid . '"<br>';
		}
	} else {
		echo 'Page Type does not exists. Please <a href="/admin/pages.php">choose another page type</a>.<br>';
	}
} else {
	// Not editing or creating a new page, display all pages and the option to create a new page
	$pages = $mapper->GetAllPages();
	// Get all page types
	$pageTypes = GetPageTypes();
	?>
	<form method="GET">
		Create new page with type: <select name="newPageType">
			<?php
				foreach ($pageTypes as $pageTypeVariables) {
					$pageType = $pageTypeVariables['pageType'];
					$valid = $pageTypeVariables['valid'];
					?>
					<option value="<?php echo $pageType; ?>" <?php if ($valid !== true) echo 'disabled="disabled"'; ?> ><?php echo $pageType; ?></option>
					<?php
				}
			?>
		</select>
		<input type="submit" value="Create New"><br>
	</form>
	<form method="GET">
		Edit Custom Page URL: <input type="text" name="pageURL" id="pageURL">
		<input type="submit" value="Edit Page">
	</form>
	All Pages in the database:<br>
	<table>
		<th>Page URL</th>
		<th></th>
		<?php
		foreach ($pages as $page) {
			// $pageVariables = json_decode($page['page_variables']);
			// $pageVariables = get_object_vars($pageVariables);
			// extract($pageVariables);
			?>
			<tr>
				<?php
				echo '<td>' . $page['page_url'] . '</td>'; 
				// echo '<td>';
				// foreach ($pageVariables as $key => $value) {
				// 	echo $key . ' = ' . $value . '<br>';
				// }
				// echo '</td>';
				?>
				<td><a href="?pageURL=<?php echo $page['page_url']; ?>">Edit This Page</a></td>
			</tr>
		<?php
		}
		?>
	</table>
	<?php
}
unset($mapper);
?>