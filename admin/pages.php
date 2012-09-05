<?php
$pageName = 'Pages';
$requiredAuth = 3;
$errors = array();
if (isset($_GET['pageURL'])) {
	// Editing a page
	$url = $_GET['pageURL'];
	$page = new Page();
	if ($page->LoadPage($url, false) !== false) { // Get the page variables (unparsed)
		$savedTo = $page->savedTo;
		if (isset($_POST['pageURL'])) {
			if ($url !== $_POST['pageURL']) {
				// Updating the pages URL
				$oldURL = $_GET['pageURL'];
				if (IsPage($url) === true) {
					$error = array('fieldId' => 'pageURL', 'message' => 'The chosen URL is already taken. Please chose another URL.');
					array_push($errors, $error);
				}
			} else {
				$oldURL = false;
			}
			$url = $_POST['pageURL'];
		} else {
			$url = $page->url;
		}
		if (isset($_POST['name'])) {
			$name = $_POST['name'];
		} else {
			$name = $page->name;
		}
		if (isset($_POST['requiredAuth'])) {
			$requiredAuth = $_POST['requiredAuth'];
		} else {
			$requiredAuth = $page->requiredAuth;
		}
		if (isset($_POST['contents'])) {
			$contents = $_POST['contents'];
		} else {
			$contents = $page->contents;
		}
		if (isset($_POST['metaDescription'])) {
			$metaDescription = $_POST['metaDescription'];
		} else {
			$metaDescription = $page->metaDescription;
		}
		if (count($errors) > 0) {
			showErrors($errors);
		} else {
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				// Save the page
				if ($savedTo == 'database') {
					$mapper = new Mapper();
					if ($mapper->SavePage($url, $name, $requiredAuth, $contents, $metaDescription, $oldURL)) {
						if ($oldURL) {
							echo 'Page URL has been updated. You can <a href="/admin/pages.php?pageURL=' . $url . '">edit the page using its new URL</a>.<br>';
							return;
						} else {
							echo 'Page was successfully updated!<br>';
						}
					} else {
						echo 'There was an error updating the page. Please try again.<br>';
					}
				} else {
					// Save the page to a file
					echo 'You cannot currently update a page in a file. Please create a new page and store it in the database.<br>';
					// if ($oldURL) {
					// 	// Changing URL
					// 	if (file_put_contents($url, $contents)) {
					// 		if (unlink($oldURL)) {
					// 			echo 'Page has been saved and can now be <a href="/admin/pages.php?pageURL=' . $url . '">edited using the new URL</a>.<br>';
					// 		} else {
					// 			echo 'There was an error deleting the old file. The new page can now be <a href="/admin/pages.php?pageURL=' . $url . '">edited at using the new URL</a>.<br>';
					// 		}
					// 		return;
					// 	} else {
					// 		echo 'There was an error saving the new file. Please try again.<br>';
					// 	}
					// } else {
					// 	if (!file_put_contents($url, $contents)) {
					// 		echo 'Error saving file. Please try again.<br>';
					// 	} else {
					// 		echo 'Page updated!<br>';
					// 	}
					// }
				}
			}
		}
		?>
		<form method="POST">
			Saved To: <?php echo $savedTo; ?><br>
			Page URL: <input type="text" name="pageURL" id="pageURL" value="<?php echo $url; ?>" required="required"><br>
			<?php if ($savedTo == 'database') {
				?>
				Page Name = <input type="text" name="name" value="<?php echo $name; ?>" required="required"><br>
				Page Required Auth = <input type="number" name="requiredAuth" value="<?php echo $requiredAuth; ?>" required="required"><br>
			<?php } ?>
			Page Content
			<?php CreateEditor($contents, 'contents'); ?>
			<?php if ($savedTo == 'database') {
				?>
				Meta Description: <input type="text" name="metaDescription" value="<?php echo $metaDescription; ?>"><br>
			<?php } ?>
			<input type="submit" value="Save Page">
		</form>
		<?php
	} else {
		echo 'Page URL could not be found.<br>';
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
			<th>Edit Page</th>
			<th>Delete Page</th>
			<?php
			foreach ($pages as $page) {
				$pageURL = $page['page_url'];
				?>
				<tr>
					<td><?php echo $pageURL; ?></td>
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