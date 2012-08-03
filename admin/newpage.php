<?php
$pageTitle = 'Create New Page';
$requiredAuth = 3;
$errors = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// New page form has been submitted
	// Check if the checkbox has been checked. If it has not been checked, it probably won't have been sent through POST
	if (isset($_POST['doNotSaveToDatabase']) && $_POST['doNotSaveToDatabase'] === 'on') {
		$saveToDatabase = false;
	} else {
		$saveToDatabase = true;
	}
	// Check the page title
	$newPageTitle = $_POST['pageTitle'];
	if ($_POST['pageTitle'] == '') {
		$error = array('fieldId' => 'pageTitle', 'message' => 'The page title cannot be empty.');
		array_push($errors, $error);
	}
	// Check if the required auth is set and an integer
	$newPageRequiredAuth = $_POST['newPageRequiredAuth'];
	if (!is_numeric($newPageRequiredAuth)) {
		var_dump($newPageRequiredAuth);
		$error = array('fieldId' => 'newPageRequiredAuth', 'message' => 'The required auth cannot be empty and must be an integer.');
		array_push($errors, $error);
	}
	// Check if the requested new page URL is already taken or is available
	$newPageURL = $_POST['newPageURL'];
	if (is_file($newPageURL . '.php') || is_file($newPageURL)) {
		$error = array('fieldId' => 'newPageURL', 'message' => 'The chosen URL is already taken by a file. Please chose another name.');
		array_push($errors, $error);
	} else if (is_dir($newPageURL)) {
		$error = array('fieldId' => 'newPageURL', 'message' => 'The chosen URL is already taken by a directory. To specify a file add ".php" to the end of the file name.');
		array_push($errors, $error);
	} 
	// Get the page contents
	$pageCode = $_POST['pageCode'];
	if (count($errors) > 0) {
		showErrors($errors);
	} else {
		// Input has been validated, so save the file to the system
		$pathInfo = pathinfo($newPageURL);
		if (!array_key_exists('extension', $pathInfo)) {
			// Page did not have an extension set, so add .php to the end
			$newPageURL = $newPageURL . '.php';
		}
		$pageCode = "<?php\r\n" .
					'$pageTitle = "' . $newPageTitle . "\";\r\n" .
					'$requiredAuth = ' . $newPageRequiredAuth . ";\r\n" .
					"?>\r\n" .
					$pageCode;
		if (file_put_contents($newPageURL, $pageCode)) {
			echo 'Page saved! You can now <a href="/admin/pages.php?pageURL=' . $newPageURL . '">edit the file</a>.<br>';
			return;
		} else {
			echo 'There was error saving the file. Please try again.<br>';
		}
	}
}
?>
<form method="POST">
	Do Not Save To Database (NOT recommended): <input type="checkbox" name="doNotSaveToDatabase" <?php if (isset($saveToDatabase) && $saveToDatabase === false) echo 'checked="checked"'; ?>><br>
	New Page URL: smiledrivertraining.co.uk/<input type="text" name="newPageURL" <?php if (isset($newPageURL)) echo 'value="' . $newPageURL . '"'; ?> required="required"><br>
	Page Title = <input type="text" name="pageTitle" <?php if (isset($newPageTitle)) echo 'value="' . $newPageTitle . '"'; ?> required="required"><br>
	Page Required Auth = <input type="number" name="newPageRequiredAuth" <?php if (isset($newPageRequiredAuth)) echo 'value="' . $newPageRequiredAuth . '"'; else echo 'value="0"'; ?> required="required"><br>
	Page Content
	<?php
	if (!isset($pageCode)) {
		$pageCode = 'Page Content';
	}
	CreateEditor($pageCode, 'pageCode'); ?>
	<input type="submit" value="Save New Page">
</form>