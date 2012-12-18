<?php
$pageName = 'Edit Snippets';
$requiredAuth = 3;
if (isset($_GET['snippet'])) {
	// Editing snippet
	if (isset($_POST['snippetCode'])) {
		$code = $_POST['snippetCode'];
	} else {
		$code = false;
	}
	$snippet = new Snippet();
	// Load the snippet unparsed
	if ($snippet->load($_GET['snippet'], true, array(), $code)) {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$snippet->save($code);
		}
		?>
		<form method="POST">
			<?php CreateEditor($snippet->getContents(), 'snippetCode'); ?>
			<input type="submit" value="Save Changes">
		</form>
	 	<?php
	} else {
		echo $snippet->getError();
	}
} else {
	$snippets = GetSnippets();
	if (count($snippets) > 0) {
		// We have at least 1 snippet
		?>
		<table>
			<th>Name</th>
			<th>Valid</th>
			<th>Dynamic</th>
			<th>Edit</th>
			<th>var_dump</th>
			<?php
			foreach ($snippets as $snippet) {
				?>
				<tr>
					<td><?php echo $snippet->getName(); ?></td>
					<td><?php echo $snippet->getError() === false ? 'Yes' : $snippet->getError(); ?></td>
					<td><?php echo $snippet->isDynamic() === true ? 'Yes' : 'No'; ?></td>
					<td><?php if ($snippet->isDynamic() === true) {
						?> <a href="<?php echo ROOTFOLDER . $snippet->getConfigurationPage() ?>">Edit Snippet</a>
					<?php } else { ?>
						<a href="?snippet=<?php echo $snippet->getName(); ?>" title="Edit this snippet">Edit Snippet</a>
					<?php } ?>
					</td>
					<td><?php //$snippet->diagnose(); ?></td>
				</tr>
				<?php
			}
			?>
		</table>
		<?php
	} else {
		echo 'No snippets were found. Why not <a href="/admin/newsnippet.php">create a new one</a>?<br>';
	}
}
?>