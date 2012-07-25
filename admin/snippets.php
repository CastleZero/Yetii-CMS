<?php
$title = 'Snippets';
$requiredAuth = 3;
$snippets = GetSnippets();
if (count($snippets) > 0) {
	// We have at least 1 snippet
	if (isset($_GET['snippet'])) {
		// Editing a snippet
		$snippet = $_GET['snippet'];
		foreach ($snippets as $availableSnippet) {
			if ($availableSnippet['name'] == $snippet) {
				// We have found the requested snippet in the list of available snippets
				$valid = $availableSnippet['valid'];
			}
		}
		if (isset($valid)) {
			// Snippet exists
			if ($valid === true) {
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					// Saving the snippet
					$snippetCode = $_POST['snippetCode'];
					if (file_put_contents(SNIPPETSFOLDER . $snippet . '/index.php', $snippetCode) === false) {
						// Saving of file failed
						echo 'There was an error saving the snippet. Please try again.<br>';
					} else {
						// File was saved
						echo 'Snippet saved.<br>';
					}
				}
				if (!isset($snippetCode)) {
					$snippetCode = file_get_contents(SNIPPETSFOLDER . $snippet . '/index.php');
				}
				?>
				<form method="POST">
					<?php CreateEditor($snippetCode, 'snippetCode'); ?>
					<input type="submit" value="Save Snippet">
				</form>
				<?php
			} else {
				echo 'Snippet is invalid: "' . $valid . '"<br>';
			}
		} else {
			echo 'Snippet does not exists. Please <a href="/admin/snippets.php">choose another snippet</a>.<br>';
		}
	} else {
		// Not editing a snippet, show them all
		?>
		<table>
			<th>Name</th>
			<th>Valid</th>
			<th>Edit</th>
			<?php
			foreach ($snippets as $snippet) {
				?>
				<tr>
					<td><?php echo $snippet['name']; ?></td>
					<td><?php
					if ($snippet['valid'] === true) {
						echo 'Yes';
					} else {
						echo 'No; ' . $snippet['valid'];
					}
					?></td>
					<td><a href="?snippet=<?php echo $snippet['name']; ?>" title="Edit this snippet">Edit Snippet</a></td>
				</tr>
				<?php
			}
			?>
		</table>
		<?php
	}
} else {
	echo 'No snippets were found. Why not <a href="/admin/newsnippet.php">create a new one</a>?<br>';
}
?>