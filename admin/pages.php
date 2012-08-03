<?php
$pageTitle = 'Pages';
$requiredAuth = 3;
$errors = array();
if (isset($_GET['pageURL'])) {
	// Editing a page
	$pageURL = $_GET['pageURL'];
	$pageVariables = GetPage($pageURL, false); // Get the page variables (unparsed)
	if ($pageVariables === false) {
		echo 'Page URL is not a valid page URL.<br>';
	} else {
		$currentPageURL = $pageURL;
		extract($pageVariables, EXTR_PREFIX_ALL, 'editingPage');
		$variables = parse_ini_file(PAGESFOLDER . $editingPage_pageType . '/variables.ini', true);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Save the page
			$submittedVariables = array();
			if (isset($_POST['editingPage_pageTitle']) && $_POST['editingPage_pageTitle'] != '') {
				$editedPageTitle = $_POST['editingPage_pageTitle'];
			} else {
				$error = array('fieldId' => 'editingPage_pageTitle', 'message' => 'The page title cannot be empty');
				array_push($errors, $error);
			}
			if (isset($_POST['editingPage_requiredAuth']) && $_POST['editingPage_requiredAuth'] != '') {
				$editedRequiredAuth = $_POST['editingPage_requiredAuth'];
			} else {
				$error = array('fieldId' => 'editingPage_requiredAuth', 'message' => 'The required auth cannot be empty');
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
					if ($editingPage_pageSavedIn == 'file') {
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
				$JSONVariables = json_encode($submittedVariables);
				if ($editingPage_pageSavedIn == 'database') {
					$mapper = new Mapper();
					if ($mapper->UpdatePage($pageURL, $currentPageURL, $editedPageTitle, $editedRequiredAuth, $JSONVariables)) {
						echo 'Page saved.<br>';
					} else {
						echo 'Page could not be saved.<br>';
					}
					unset($mapper);
				} else if ($editingPage_pageSavedIn == 'file') {
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
			Page Saved In: <?php echo $editingPage_pageSavedIn; ?><br>
			Page Title: <input type="text" name="editingPage_pageTitle" id="pageTitle" <?php if (isset($editingPage_pageTitle)) echo 'value="' . $editingPage_pageTitle . '"'; ?> required="required" ><br>
			Page URL: <input type="text" name="pageURL" id="pageURL" <?php if (isset($pageURL)) echo 'value="' . $pageURL . '"'; ?> required="required"><br>
			Required Auth: <input type="number" name="editingPage_requiredAuth" id="requiredAuth" <?php if (isset($editingPage_requiredAuth)) echo 'value="' . $editingPage_requiredAuth . '"'; else echo 'value="0"'; ?> required="required"><br>
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
				} else if (array_key_exists($name, $editingPage_pageVariables)) {
					$value = $editingPage_pageVariables[$name];
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
} else {
	// Not editing or creating a new page, display all pages and the option to create a new page
	?>
	All URLs are relative to the websites root address (do not add a "/" to the start).<br>
	<a href="/admin/newpage.php"><input type="button" value="Create New Page"></a>
	<form method="GET">
		Edit Page With URL: <input type="text" name="pageURL" id="pageURL">
		<input type="submit" value="Edit Page">
	</form>
	<?php
	$mapper = new Mapper();
	$pages = $mapper->GetAllPages();
	unset($mapper);
	if ($pages !== false) {
		?>
		All Pages in the database:<br>
		<table>
			<th>Page URL</th>
			<th>Valid Page?</th>
			<th>Edit Page</th>
			<?php
			foreach ($pages as $page) {
				$pageURL = $page['url'];
				if (is_file($pageURL)) {
					$validPage = 'Yes';
				} else {
					$validPage = 'No; No file was found for the URL';
				}
				?>
				<tr>
					<td><?php echo $pageURL; ?></td>
					<td><?php echo $validPage; ?></td>
					<td><a href="?pageURL=<?php echo $pageURL; ?>">Edit This Page</a></td>
				</tr>
			<?php
			}
			?>
		</table>
		<?php
	} else {
		echo 'No pages are stored in the database.<br>';
	}
}