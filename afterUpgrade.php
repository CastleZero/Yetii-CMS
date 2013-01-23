<?php
class AfterUpgradeMapper extends Mapper {
	const QUERY_ADD_TARGET_TO_LINK = "ALTER TABLE `links` ADD `target` VARCHAR(12) NOT NULL";

	function addTargetToLink() {
		$stmt = $this->dbh->prepare(self::QUERY_ADD_TARGET_TO_LINK);
		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
}

if ($update->oldVersion < '0.2.8') {
	$mapper = new AfterUpgradeMapper();
	if (!$mapper->addTargetToLink()) {
		echo 'Error upgrading database!';
	}
	unset($mapper);
	?>
	Snippets now have the syntax "snippet[<i>SnippetName</i>]". <a href="http://yetii.net/changelog#0.2.8" title="View changelog for version 0.2.8">View full changelog</a><br>
	<?php
}

//unlink(__FILE__);