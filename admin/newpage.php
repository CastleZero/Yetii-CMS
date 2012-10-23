<?php
$pageName = 'Create New Page';
$requiredAuth = 3;
$errors = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// New page form has been submitted
	// Check if the checkbox has been checked. If it has not been checked, it probably won't have been sent through POST
	if (isset($_POST['saveToFile']) && $_POST['saveToFile'] === 'on') {
		$saveToFile = true;
	} else {
		$saveToFile = false;
	}
	// Check if the requested new page URL is already taken or is available
	$newPageURL = $_POST['newPageURL'];
	if (IsPage($newPageURL) === true) {
		$error = array('fieldId' => 'newPageURL', 'message' => 'The chosen URL is already taken. Please chose another URL.');
		array_push($errors, $error);
	}
	// Check the page name
	$newPageName = $_POST['pageName'];
	if ($newPageName == '') {
		$error = array('fieldId' => 'pageName', 'message' => 'The page name cannot be empty.');
		array_push($errors, $error);
	}
	// Check if the required auth is set and an integer
	$newPageRequiredAuth = $_POST['newPageRequiredAuth'];
	if (!is_numeric($newPageRequiredAuth)) {
		$error = array('fieldId' => 'newPageRequiredAuth', 'message' => 'The required auth cannot be empty and must be an integer.');
		array_push($errors, $error);
	}
	$metaDescription = $_POST['metaDescription'];
	// Get the page's code
	$pageCode = $_POST['pageCode'];
	if (count($errors) > 0) {
		showErrors($errors);
	} else {
		// Input has been validated, so save the file to the system
		if ($saveToFile) {
			$pathInfo = pathinfo($newPageURL);
			if (!array_key_exists('extension', $pathInfo)) {
				// Page did not have an extension set, so add .php to the end
				$newPageURL = $newPageURL . '.php';
			}
			$pageCode = "<?php\r\n" .
						'$pageName = "' . $newPageName . "\";\r\n" .
						'$requiredAuth = ' . $newPageRequiredAuth . ";\r\n" .
						"?>\r\n" .
						$pageCode;
			if (file_put_contents($newPageURL, $pageCode)) {
				echo 'Page saved! You can now <a href="/admin/pages.php?pageURL=' . $newPageURL . '">edit the file</a>.<br>';
				if ($saveToDatabase) {
					$mapper = new Mapper();
					if ($mapper->AddNewPage($newPageURL)) {
						echo 'Page was also added to database.<br>';
					} else {
						echo 'There was an error adding the file to the database.<br>';
					}
				}
				return;
			} else {
				echo 'There was error saving the file. Please try again.<br>';
			}
		} else {
			// Save the page to the database
			$mapper = new Mapper();
			if ($mapper->SavePage($newPageURL, $newPageName, $newPageRequiredAuth, $pageCode, $metaDescription) !== false) {
				echo 'Page saved! You can now <a href="/admin/pages.php?pageURL=' . $newPageURL . '">edit the page</a>.<br>';
				return;
			} else {
				echo 'There was an error saving the page, please try again.<br>';
			}
		}
	}
}
?>
<form method="POST">
	Save to file (NOT recommended): <input type="checkbox" name="saveToFile" <?php if (isset($saveToFile) && $saveToFile === true) echo 'checked="checked"'; ?>><br>
	New Page URL: <?php echo ROOTURL; ?><input type="text" name="newPageURL" <?php if (isset($newPageURL)) echo 'value="' . $newPageURL . '"'; ?> required="required"><br>
	Page Name = <input type="text" name="pageName" <?php if (isset($newPageName)) echo 'value="' . $newPageName . '"'; ?> required="required"><br>
	Page Required Auth = <input type="number" name="newPageRequiredAuth" <?php if (isset($newPageRequiredAuth)) echo 'value="' . $newPageRequiredAuth . '"'; else echo 'value="0"'; ?> required="required"><br>
	Page Content
	<?php
	if (!isset($pageCode)) {
		$pageCode = 'Page Content';
	}
	CreateEditor($pageCode, 'pageCode'); ?>
	Meta Description: <input type="text" name="metaDescription" <?php if (isset($metaDescription)) echo 'value="' . $metaDescription . '"'; ?>><br>
	<input type="submit" value="Save New Page">
</form>