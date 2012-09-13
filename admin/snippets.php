<?php
$title = 'Snippets';
$requiredAuth = 3;
$snippets = GetSnippets();
if (isset($_GET['snippet'])) {
	// Editing snippet
	$snippet = $_GET['snippet'];
	$snippet = GetSnippet($snippet, false);
	if ($snippet !== false) {
		$snippetLocation = $snippet['location'];
		$snippetCode = $snippet['code'];
		$snippetType = $snippet['type'];
		if ($snippetType == 'static') {
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				// Save change to snippet
				$snippetCode = $_POST['snippetCode'];
				if (file_put_contents($snippetLocation, $snippetCode)) {
					echo 'Snippet saved.<br>';
				} else {
					echo 'There was an error saving the snippet. Please try again.<br>';
				}
			}
			?>
			<form method="POST">
				<?php CreateEditor($snippetCode, 'snippetCode'); ?>
				<input type="submit" value="Save Changes">
			</form>
			<?php
		} else {
			$configFile = $snippet['configFile'];
			$configVariables = parse_ini_file($configFile, true);
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				// Save changes to snippet
				$newVariables = array();
				foreach ($configVariables as $name => $variable) {
					$snippetCode[$name] = $_POST[$name];
				}
				if (write_ini_file($snippetCode, $snippetLocation)) {
					echo 'Snippet saved.<br>';
				} else {
					echo 'There was an error saving the snippet. Please try again.<br>';
				}
			}
			?>
			<form method="POST">
				<?php
				foreach ($configVariables as $name => $variable) {
					$friendlyName = $variable['friendlyName'];
					$required = $variable['required'];
					$value = $snippetCode[$name];
					echo $friendlyName;
					?>
					: <input type="text" name="<?php echo $name; ?>" value="<?php echo $value; ?>" <?php if ($required) echo 'required="required"'; ?>><br>
					<?php
				}
				?>
				<input type="submit" value="Save Changes">
			</form>
			<?php
		}
	}
} else {
	if (count($snippets) > 0) {
		// We have at least 1 snippet
		?>
		<table>
			<th>Name</th>
			<th>Valid</th>
			<th>Dynamic</th>
			<th>Edit</th>
			<?php
			foreach ($snippets as $snippet) {
				?>
				<tr>
					<td><?php echo $snippet['name']; ?></td>
					<td><?php echo $snippet['valid'] == true ? 'Yes' : 'No'; ?></td>
					<td><?php echo $snippet['dynamic'] == true ? 'Yes' : 'No'; ?></td>
					<td><?php if ($snippet['dynamic'] == true) {
						?> <a href="<?php echo SNIPPETSFOLDER . $snippet['name'] . '/config.php' ?>">Edit Snippet</a>
					<?php } else { ?>
						<a href="?snippet=<?php echo $snippet['name']; ?>" title="Edit this snippet">Edit Snippet</a>
					<?php } ?>
					</td>
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