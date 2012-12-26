<?php
$pageName = 'Pages';
$requiredAuth = 3;
$errors = array();
if (isset($_GET['pageURL'])) {
	// Editing a page
	$url = $_GET['pageURL'];
	$page = new Page();
	if ($page->load($url, false) !== false) { // Get the page variables (unparsed)
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Page has been saved
			if (isset($_POST['url'])) {
				$page->setURL($_POST['url']);
			}
			if (isset($_POST['name'])) {
				$page->setName($_POST['name']);
			}
			if (isset($_POST['requiredAuth'])) {
				$page->setRequiredAuth($_POST['requiredAuth']);
			}
			if (isset($_POST['contents'])) {
				$page->setContents($_POST['contents']);
			}
			if (isset($_POST['metaDescription'])) {
				$page->setMetaDescription($_POST['metaDescription']);
			}
			$page->save();
			if ($page->getURLChanged()) {
				return;
			}
		}
		?>
		<form method="POST">
			Saved To: <?php echo $page->getSavedTo(); ?><br>
			Page URL: <input type="text" name="url" value="<?php echo $page->getURL(); ?>" required="required"><br>
			<?php if ($page->getSavedTo() == 'database') {
				?>
				Page Name = <input type="text" name="name" value="<?php echo $page->getName(); ?>" required="required"><br>
				Page Required Auth = <input type="number" name="requiredAuth" value="<?php echo $page->getRequiredAuth(); ?>" required="required"><br>
			<?php } ?>
			Page Content
			<?php CreateEditor($page->getContents(), 'contents'); ?>
			<?php if ($page->getSavedTo() == 'database') {
				?>
				Meta Description: <input type="text" name="metaDescription" value="<?php echo $page->getMetaDescription(); ?>"><br>
			<?php } ?>
			<input type="submit" value="Save Page">
		</form>
		<?php
	} else {
		echo 'Page URL could not be found.<br>';
	}
} else if (isset($_GET['deletePageURL'])) {
	// Delete a page
	$url = $_GET['deletePageURL'];
	$page = new Page();
	if ($page->load($url, false) !== false) {
		// Page is valid
		if (isset($_GET['confirmDelete']) && $_GET['confirmDelete']) {
			// Delete the page
			if ($page->getSavedTo() == 'database') {
				$mapper = new Mapper();
				if ($mapper->deletePage($url)) {
					echo 'Page has been deleted from the database.<br>';
				} else {
					echo 'Page was not deleted from the database.<br>';
				}
			} else if ($page->getSavedTo() == 'file') {
				if (unlink($url)) {
					echo 'Page has been deleted.<br>';
				} else {
					echo 'There was an error deleting the page';
				}
			} else {
				echo 'Page is not valid.<br>';
			}
		} else {
			// Ask for confirmation
			?>
			<form method="GET">
				<input type="hidden" name="deletePageURL" value="<?php echo $url; ?>">
				<input type="hidden" name="confirmDelete" value="true">
				<input type="submit" value="Confirm Delete">
			</form>
			<?php
		}
	} else {
		echo 'Provided URL was not found.<br>';
	}
} else {
	// Not editing a new page, display all pages and the option to create a new page
	?>
	All URLs are relative to the websites root address (do not add a "/" to the start).<br>
	<a href="newpage.php"><input type="button" value="Create New Page"></a>
	<form method="GET">
		Edit Page With URL: <input type="text" name="pageURL" id="pageURL">
		<input type="submit" value="Edit Page">
	</form>
	<?php
	$mapper = new Mapper();
	$pages = $mapper->getAllPages();
	unset($mapper);
	foreach ($pages as &$page) {
		$page['savedTo'] = 'database';
	}
	require_once('includes/upgrade/files.inc.php');
	$di = new RecursiveDirectoryIterator('.');
	foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
		if (substr($filename, -2) != '..' && substr($filename, -2) != '/.') {
		    $filename = substr($filename, 2);
		    if (substr($filename, 0, strlen(ADMINFOLDER)) == ADMINFOLDER ||
		    	substr($filename, 0, strlen('includes')) == 'includes' ||
		    	substr($filename, 0, strlen(SNIPPETSFOLDER)) == SNIPPETSFOLDER ||
		    	substr($filename, 0, strlen(TEMPLATESFOLDER)) == TEMPLATESFOLDER ||
		    	substr($filename, 0, strlen(IMAGESFOLDER)) == IMAGESFOLDER ||
		    	substr($filename, 0, 1) == '.' ||
				$filename == '_maintenance') {
		    	// Don't show files in the admin or includes directories
		    } else {
			    if (!in_array($filename, $currentFiles)) {
			    	$file = array('page_url' => $filename, 'savedTo' => 'file');
			    	array_push($pages, $file);
			    }
			}
		}
	}
	if ($pages !== false) {
		?>
		All Pages in the database:<br>
		<table>
			<th>Page URL</th>
			<th>Edit Page</th>
			<th>Saved To</th>
			<th>Delete Page</th>
			<?php
			foreach ($pages as $page) {
				$pageURL = $page['page_url'];
				?>
				<tr>
					<td><?php echo $pageURL; ?></td>
					<td><a href="?pageURL=<?php echo $pageURL; ?>">Edit This Page</a></td>
					<td><?php echo $page['savedTo']; ?></td>
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