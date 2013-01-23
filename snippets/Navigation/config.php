<?php
$pageName = 'Edit navigation links';
$requiredAuth = 3;
require_once('navigationmapper.class.php');
?>
<script>
	function updateNewPositions() {
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

	function deleteLink(link) {
		$('li[name="' + link + '"]').remove();
		updateNewPositions();
	}

	$(function() {
		$("#sortableList").sortable({
			update: function(event, ui) {
				updateNewPositions();
			}
		});

		$("#sortableList").disableSelection();
		updateNewPositions();

		$('#addNewLink').click(function() {
			$('#sortableList').append('<li name="' + numberOfLinks + '">\
				<input type="number" name="' + numberOfLinks + '_order" value="">\
				<label> Name <input type="text" name="' + numberOfLinks + '_name" value="New Link ' + numberOfLinks + '"></label>\
				<label for="' + numberOfLinks + '_url">\
					URL: </label><label>Use Root (<?php echo ROOTURL; ?>) <input type="checkbox" name="' + numberOfLinks + '_useRoot" checked="checked"></label>\
				<input type="text" name="' + numberOfLinks + '_url" id="' + numberOfLinks + '_url">\
				<label> Title <input type="text" name="' + numberOfLinks + '_title"></label>\
				<label>Open Target\
					<select name="' + numberOfLinks + '_target">\
						<option value="_self">Current Tab</option>\
						<option value="_blank">New Tab</option>\
					</select>\
				</label>\
				<label> Required Auth <input type="number" name="' + numberOfLinks + '_requiredAuth" value="0"></label>\
				 <a href="javascript:deleteLink(' + numberOfLinks + ');">Delete Link</a></li>');
			updateNewPositions();
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
			$links[$linkOrder]['requiredAuth'] = $_POST[$linkNumber . '_requiredAuth'];
			$links[$linkOrder]['useRoot'] = isset($_POST[$linkNumber . '_useRoot']) ? true : false;
			$links[$linkOrder]['target'] = $_POST[$linkNumber . '_target'];
			$numberOfLinks--;
		}
		$linkNumber++;
	}
	// Order the links array (of arrays) by the order
	if (isset($links) && is_array($links)) {
		ksort($links, SORT_NUMERIC);
		$mapper = new NavigationMapper();
		$mapper->saveLinks($links);
		unset($mapper);
	} else {
		echo 'No links provided. Please provide at least 1 link.<br>';
	}
}
// Get all the links
$mapper = new NavigationMapper();
$linksArray = $mapper->getLinks();
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
				$useRoot = $linkArray['useRoot'];
				$title = $linkArray['title'];
				$target = $linkArray['target'];
				$name = $linkArray['name'];
				$requiredAuth = $linkArray['requiredAuth'];
				?>
				<li name="<?php echo $numberOfLinks; ?>">
					<input type="number" name="<?php echo $numberOfLinks; ?>_order">
					<label>Name <input type="text" name="<?php echo $numberOfLinks; ?>_name" value="<?php echo $name; ?>"></label>
					<label for="<?php echo $numberOfLinks; ?>_url">
						URL: </label><label>Use Root (<?php echo ROOTURL; ?>) <input type="checkbox" name="<?php echo $numberOfLinks; ?>_useRoot" <?php if ($useRoot) echo 'checked="checked"'; ?>></label>
					<input type="text" name="<?php echo $numberOfLinks; ?>_url" id="<?php echo $numberOfLinks; ?>_url" value="<?php echo $url; ?>">
					<label>Title <input type="text" name="<?php echo $numberOfLinks; ?>_title" value="<?php echo $title; ?>"></label>
					<label>Open Target
					<select name="<?php echo $numberOfLinks; ?>_target">
						<option value="_self" <?php if ($target == '_self') echo 'selected="selected"'; ?>>Current Tab</option>
						<option value="_blank" <?php if ($target == '_blank') echo 'selected="selected"'; ?>>New Tab</option>
					</select>
					</label>
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