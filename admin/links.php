<?php
$pageName = 'Edit navigation links';
$requiredAuth = 3;
?>
<script>
	function UpdateNewPositions() {
		numberOfLinks = 0;
		$('#sortableList li').each(function(index) {
			numberOfLinks++;
			var name = $(this).attr('name');
			$('input[name="' + name + '_order"]').val(index);
			$('input[name="' + name + '_order"]').change(function() {
				alert('Handler for .change() called.');
			});
		});
		$('input[name="numberOfLinks"]').val(numberOfLinks);
	}

	function DeleteLink(link) {
		$('li[name="' + link + '"]').remove();
		UpdateNewPositions();
	}

	$(function() {
		$("#sortableList").sortable({
			update: function(event, ui) {
				UpdateNewPositions();
			}
		});

		$("#sortableList").disableSelection();
		UpdateNewPositions();

		$('#addNewLink').click(function() {
			$('#sortableList').append('<li name="' + numberOfLinks + '"><input type="number" name="' + numberOfLinks + '_order" value=""><label> Name <input type="text" name="' + numberOfLinks + '_name" value="New Link ' + numberOfLinks + '"></label><label> URL: <label>Use Root (<?php echo ROOTURL; ?>)<input type="checkbox" name="' + numberOfLinks + '_useRoot" checked="checked"><input type="text" name="' + numberOfLinks + '_url"></label><label> Title <input type="text" name="' + numberOfLinks + '_title"></label><label> Required Auth <input type="number" name="' + numberOfLinks + '_requiredAuth" value="0"></label> <a href="javascript:DeleteLink(' + numberOfLinks + ');">Delete Link</a></li>');
			UpdateNewPositions();
		});
	});
</script>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Update the links if they've been submitted
	$linkNumber = 0;
	$numberOfLinks = $_POST['numberOfLinks'];
	while($numberOfLinks > 0) {
		if (isset($_POST[$linkNumber . '_order'])) {
			// Go through every link submitted and add them to an array
			$linkOrder = $_POST[$linkNumber . '_order'];
			$links[$linkOrder]['name'] = $_POST[$linkNumber . '_name'];
			$links[$linkOrder]['url'] = $_POST[$linkNumber . '_url'];
			$links[$linkOrder]['title'] = $_POST[$linkNumber . '_title'];
			$links[$linkOrder]['order'] = $_POST[$linkNumber . '_order'];
			$links[$linkOrder]['required_auth'] = $_POST[$linkNumber . '_requiredAuth'];
			$links[$linkOrder]['use_root'] = isset($_POST[$linkNumber . '_useRoot']) ? true : false;
			$numberOfLinks--;
		}
		$linkNumber++;
	}
	// Order the links array (of arrays) by the order
	if (isset($links) && is_array($links)) {
		ksort($links, SORT_NUMERIC);
		$mapper = new Mapper();
		$mapper->SaveLinks($links);
		unset($mapper);
	} else {
		echo 'No links provided. Please provide at least 1 link.<br>';
	}
}
// Get all the links
$mapper = new Mapper();
$linksArray = $mapper->GetLinks();
unset($mapper);
// Create a table with all the links
?>
Drag around the list below to re-order the links. Edit any links as required.<br>
<form method="POST">
	<ul id="sortableList">
		<?php
		$numberOfLinks = -1;
		if ($linksArray !== false) {
			// There are some links stored in the database
			foreach($linksArray as $linkArray) {
				$numberOfLinks++;
				$order = $linkArray['order'];
				$url = $linkArray['url'];
				$useRoot = $linkArray['use_root'];
				$title = $linkArray['title'];
				$name = $linkArray['name'];
				$requiredAuth = $linkArray['required_auth'];
				?>
				<li name="<?php echo $numberOfLinks; ?>">
					<input type="number" name="<?php echo $numberOfLinks; ?>_order">
					<label>Name <input type="text" name="<?php echo $numberOfLinks; ?>_name" value="<?php echo $name; ?>"></label>
					<label>URL: <label>Use Root (<?php echo ROOTURL; ?>) <input type="checkbox" name="<?php echo $numberOfLinks; ?>_useRoot" <?php if ($useRoot) echo 'checked="checked"'; ?>></label><input type="text" name="<?php echo $numberOfLinks; ?>_url" value="<?php echo $url; ?>"></label>
					<label>Title <input type="text" name="<?php echo $numberOfLinks; ?>_title" value="<?php echo $title; ?>"></label>
					<label>Required Auth <input type="number" name="<?php echo $numberOfLinks; ?>_requiredAuth" value="<?php echo $requiredAuth; ?>"></label>
					<a href="javascript:DeleteLink(<?php echo $numberOfLinks; ?>);">Delete Link</a>
				</li>
				<?php
			}
		} else {
			echo 'No links have been stored in the database yet.';
		}
		?>
	</ul>
	<input type="hidden" name="numberOfLinks" value="<?php echo $numberOfLinks; ?>">
	<input type="button" value="Add New Link" id="addNewLink"><br>
	<input type="submit" value="Save Links">
</form>