<?php
$title = 'Pages';
$requiredAuth = 1;
$mapper = new Mapper();
if (isset($_GET['pageId'])) {
	$pageId = $_GET['pageId'];
	if (is_numeric($pageId)) {
		// Get the pages information
		$pageValues = $mapper->GetPageContentById($pageId);
		$pageVariables = json_decode($pageValues['pageVariables']);
		$pageVariables = get_object_vars($pageVariables);
	}
	// Set our variables. If a variable has been submitted, use it. Next check for variables from the database. If no value from the database was loaded, create it empty.
	if (isset($_POST['pageURL'])) {
		$pageURL = $_POST['pageURL'];
	} else if (isset($pageValues)) {
		$pageURL = $pageValues['pageURL'];
	} else {
		$pageURL = '';
	}
	if (isset($_POST['pageTitle'])) {
		$pageTitle = $_POST['pageTitle'];
	} else if (isset($pageValues)) {
		$pageTitle = $pageValues['pageTitle'];
	} else {
		$pageTitle = '';
	}
	if (isset($_GET['pageType'])) {
		$pageType = $_GET['pageType'];
	} else if (isset($pageValues)) {
		$pageType = $pageValues['pageType'];
	} else {
		$pageType = '';
	}
	// Get the page variables
	$pageVariables = parse_ini_file(PAGESFOLDER . $pageType . '.ini', true);
	$pageVariables = $pageVariables['variables'];
	foreach($pageVariables as $key => $value) {
		// Loop through all the page variables, checking if we have a value
		if (isset($_POST[$key])) {
			$$key = $_POST[$key];
		} else if (isset($pageVariables)) {
			$$key = $pageVariables[$key];
		} else {
			$$key = '';
		}
	}
	// Declare our errors array
	$errors = array();
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Submitting an update to a page, or a new page
			if ($_POST['pageURL']) {
				$pageURL = $_POST['pageURL'];
			} else {
				$error['name'] = 'pageURL';
				$error['message'] = 'Please input a Page URL';
				array_push($errors, $error);
			}
			if ($_POST['pageTitle']) {
				$pageTitle = $_POST['pageTitle'];
			} else {
				$error['name'] = 'pageTitle';
				$error['message'] = 'Please input a Page Title';
				array_push($errors, $error);
			}
			$pageVariables = array();
			foreach($pageVariables as $key => $value) {
				if ($_POST[$key]) {
					$pageVariables[$key] = $_POST[$key];
				} else {
					$error['name'] = $key;
					$error['message'] = 'Please select a value for ' . $key;
					array_push($errors, $error);
				}
			}
			if (count($errors) > 0) {
				showErrors($errors);
			} else {
				// No errors, submit the page to the database
				$pageVariables = json_encode($pageVariables);
				if ($_GET['pageId'] == 'new') {
					// Adding a new page
					$pageId = $mapper->AddNewPage($pageURL, $pageTitle, $pageType, $pageVariables);
					if (!$pageId) {
						echo 'Error adding new page, check that URL is not already taken<br>';
					} else {
						echo 'Page added! <a href="/' . $pageURL . '">View the page</a><br>';
					}
				} else {
					// Updating a page
					if ($mapper->UpdatePage($pageURL, $pageTitle, $pageType, $pageVariables, $pageId)) {
						echo 'Page updated<br>';
					} else {
						echo 'Error updating page, check that URL is not already taken<br>';
					}
				}
			}
			// Re-get the values from the database
			if (is_numeric($pageId)) {
				// Get the pages information
				$pageValues = $mapper->GetPageContentById($pageId);
				$pageVariables = json_decode($pageValues['pageVariables']);
				$pageVariables = get_object_vars($pageVariables);
			}
	}
	?>
	<form method="POST">
		Page URL: /<input type="text" value="<?php echo $pageURL; ?>" name="pageURL"><br>
		Page Title: <input type="text" value="<?php echo $pageTitle; ?>" name="pageTitle"><br>
		Page Type: <?php echo $pageType; ?><br>
		<?php
		foreach($pageVariables as $key => $value) {
			echo $key . ':';
			?>
			<input type="text" value="<?php echo $$key; ?>" name="<?php echo $key; ?>"><br>
			<?php
		}
		?>
		<input type="submit">
	</form>
	<?php
} else {
	$pages = $mapper->GetAllPages();
	// Get all page types
	$pageTypes = glob(PAGESFOLDER . '*.php', GLOB_NOSORT);
	?>
	<table>
		<th>Page Title</th>
		<th>Page Type</th>
		<th>Variable Name = Value</th>
		<th>Edit Page</th>
		<?php
		foreach ($pages as $page) {
			?>
			<tr>
				<?php
				echo '<td>' . $page['page_title'] . '</td>';
				echo '<td>' . $page['page_type'] . '</td>';
				$variables = json_decode($page['page_variables']);
				echo '<td>';
				foreach ($variables as $key => $value) {
					echo $key . ' = ' . $value . '<br>';
				}
				echo '</td>';
				?>
				<td><a href="?pageId=<?php echo $page['page_id']; ?>">Edit This Page</a></td>
			</tr>
		<?php
		}
		?>
	</table>
	Create new page<br>
	<form method="GET">
		<input type="hidden" value="new" name="pageId">
		<input type="submit" value="Create New">
		<select name="pageType">
			<?php
				foreach ($pageTypes as $type) {
					$type = str_replace(PAGESFOLDER, '', $type);
					$type = str_replace('.php', '', $type);
					?>
					<option value="<?php echo $type; ?>"><?php echo $type; ?></option>
					<?php
				}
			?>
		</select><br>
	</form>
	<?php
}
unset($mapper);
?>