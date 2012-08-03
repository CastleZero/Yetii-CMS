<?php
$pageTitle = 'Pages';
$requiredAuth = 3;
$errors = array();
if (isset($_GET['pageURL'])) {
	// Editing a page
	$pageURL = $_GET['pageURL'];
	$pageVariables = GetPage($pageURL, false); // Get the page variables (unparsed)
	$pageCode = $pageVariables['pageContents'];
	if ($pageCode === false) {
		echo 'Page URL is not a valid page URL.<br>';
	} else {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Save the page
			$pageCode = $_POST['pageCode'];
			if ($pageURL !== $_POST['pageURL']) {
				// Updating the pages URL
				$newPageURL = $_POST['pageURL'];
				if (is_file($newPageURL . '.php') || is_file($newPageURL)) {
					$error = array('fieldId' => 'newPageURL', 'message' => 'The chosen URL is already taken by a file. Please chose another name.');
					array_push($errors, $error);
				} else if (is_dir($newPageURL)) {
					$error = array('fieldId' => 'newPageURL', 'message' => 'The chosen URL is already taken by a directory. To specify a file add ".php" to the end of the file name.');
					array_push($errors, $error);
				}
			}
			if (count($errors) > 0) {
				showErrors($errors);
			} else {
				if (isset($newPageURL)) {
					// Changing URL
					if (file_put_contents($newPageURL, $pageCode)) {
						$mapper = new Mapper();
						if (unlink($pageURL)) {
							if ($mapper->UpdatePage($pageURL, $newPageURL)) {
								echo 'Page has been saved and can now be <a href="/admin/pages.php?pageURL=' . $newPageURL . '">edited at using the new URL</a>. It has also been updated in the database.<br>';
							} else {
								echo 'The page has been saved but there was an error updating the database entry.<br>';
							}
							unset($mapper);
						} else {
							echo 'There was an error deleting the old file you. The new page can now be <a href="/admin/pages.php?pageURL=' . $newPageURL . '">edited at using the new URL</a>.<br>';
						}
						return;
					} else {
						echo 'There was an error saving the new file. Please try again.<br>';
					}
				} else {
					if (!file_put_contents($pageURL, $pageCode)) {
						echo 'Error saving file. Please try again.<br>';
					} else {
						echo 'Page updated!<br>';
					}
				}
			}
		}
		?>
		<form method="POST">
			Page URL: <input type="text" name="pageURL" id="pageURL" value="<?php echo $pageURL; ?>" required="required"><br>
			<?php CreateEditor($pageCode, 'pageCode'); ?>
			<input type="submit" value="Save Page">
		</form>
		<?php
	}
} else if (isset($_GET['deletePageURL'])) {
	$pageURL = $_GET['deletePageURL'];
	if (GetPage($pageURL, false)) {
		if (isset($_GET['confirmDelete']) && $_GET['confirmDelete']) {
			// Delete the page
			if (unlink($pageURL)) {
				echo 'File has been deleted.<br>';
				$mapper = new Mapper();
				if ($mapper->DeletePage($pageURL)) {
					echo 'Page has been removed from the database.';
				} else {
					echo 'Page was not removed from the database.';
				}
			} else {
				echo 'There was an error deleting the file, please try again.';
			}
		} else {
			// Ask for confirmation
			?>
			<form method="GET">
				<input type="hidden" name="deletePageURL" value="<?php echo $pageURL; ?>">
				<input type="hidden" name="confirmDelete" value="true">
				<input type="submit" value="Confirm Delete">
			</form>
			<?php
		}
	} else {
		echo 'Provided page URL is not valid.';
	}
} else {
	// Not editing a new page, display all pages and the option to create a new page
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
			<th>Delete Page</th>
			<?php
			foreach ($pages as $page) {
				$pageURL = $page['page_url'];
				if (GetPage($pageURL, true)) {
					$validPage = 'Yes';
				} else {
					$validPage = 'No';
				}
				?>
				<tr>
					<td><?php echo $pageURL; ?></td>
					<td><?php echo $validPage; ?></td>
					<td><a href="?pageURL=<?php echo $pageURL; ?>">Edit This Page</a></td>
					<td><a href="?deletePageURL=<?php echo $pageURL; ?>">Delete This Page</a></td>
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