<?php
class NavigationMapper extends Mapper {
	const QUERY_GET_LINKS = "SELECT name, url, title, `order`, required_auth as requiredAuth, use_root as useRoot, target FROM links ORDER BY `order` ASC";
	const QUERY_ADD_LINK = "INSERT INTO links (name, url, title, `order`, required_auth, use_root, `target`) VALUES (?, ?, ?, ?, ?, ?, ?)";

	public function getLinks() {
		$stmt = $this->dbh->prepare(self::QUERY_GET_LINKS);
		$stmt->execute();
		if ($stmt->fetchColumn() !== false) {
			$stmt = $this->dbh->prepare(self::QUERY_GET_LINKS);
			$stmt->execute();
			$links = $stmt->fetchAll();
			return $links;
		} else {
			return false;
		}
	}

	public function saveLinks($links) {
		$stmt = $this->dbh->prepare('TRUNCATE links');
		$stmt->execute();
		foreach ($links as $link) {
			$this->addLink($link);
		}
	}

	public function addLink($link) {
		$stmt = $this->dbh->prepare(self::QUERY_ADD_LINK);
		if ($stmt->execute(array($link['name'], $link['url'], $link['title'], $link['order'], $link['requiredAuth'], $link['useRoot'], $link['target']))) {
			return true;
		} else {
			var_dump($this->dbh->errorInfo());
		}
	}
}
?>