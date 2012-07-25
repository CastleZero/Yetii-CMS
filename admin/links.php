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
		console.log(numberOfLinks);
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
			$('#sortableList').append('<li name="' + numberOfLinks + '"><input type="number" name="' + numberOfLinks + '_order" value=""><label> Name <input type="text" name="' + numberOfLinks + '_name" value="New Link ' + numberOfLinks + '"></label><label> URL <input type="text" name="' + numberOfLinks + '_url"></label><label> Title <input type="text"name="' + numberOfLinks + '_title"></label> <a href="javascript:DeleteLink(' + numberOfLinks + ');">Delete Link</a></li>');
			UpdateNewPositions();
		});
	});
</script>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Update the links if they've been submitted
	$linkNumber = 0;
	while (isset($_POST[$linkNumber . '_order'])) {
		// Go through every link submitted and add them to an array
		$linkOrder = $_POST[$linkNumber . '_order'];
		$links[$linkOrder]['name'] = $_POST[$linkNumber . '_name'];
		$links[$linkOrder]['url'] = $_POST[$linkNumber . '_url'];
		$links[$linkOrder]['title'] = $_POST[$linkNumber . '_title'];
		$links[$linkOrder]['order'] = $_POST[$linkNumber . '_order'];
		$linkNumber++;
	}
	// Order the links array (of arrays) by the order
	ksort($links, SORT_NUMERIC);
	$mapper = new Mapper();
	$mapper->SaveLinks($links);
	unset($mapper);
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
		foreach($linksArray as $linkArray) {
			$numberOfLinks++;
			$order = $linkArray['order'];
			$url = $linkArray['url'];
			$title = $linkArray['title'];
			$name = $linkArray['name'];
			?>
			<li name="<?php echo $numberOfLinks; ?>">
				<input type="number" name="<?php echo $numberOfLinks; ?>_order">
				<label>Name <input type="text" name="<?php echo $numberOfLinks; ?>_name" value="<?php echo $name; ?>"></label>
				<label>URL <input type="text" name="<?php echo $numberOfLinks; ?>_url" value="<?php echo $url; ?>"></label>
				<label>Title <input type="text" name="<?php echo $numberOfLinks; ?>_title" value="<?php echo $title; ?>"></label>
				<a href="javascript:DeleteLink(<?php echo $numberOfLinks; ?>);">Delete Link</a>
			</li>
			<?php
		}
		?>
	</ul>
	<input type="button" value="Add New Link" id="addNewLink"><br>
	<input type="submit" value="Save Links">
</form>