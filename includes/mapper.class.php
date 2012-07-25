<?php

class Mapper {
	const QUERY_GET_PAGE = "SELECT page_url, page_variables FROM pages WHERE page_url = ?";
	const QUERY_GET_PAGES = "SELECT page_url, page_variables FROM pages";
	const QUERY_GET_SETTINGS = "SELECT website_name, footer_text, template FROM settings LIMIT 0, 1";
	const QUERY_GET_LINKS = "SELECT name, url, title, `order` FROM links ORDER BY `order` ASC";
	const QUERY_ADD_LINK = "INSERT INTO links (name, url, title, `order`) VALUES (?, ?, ?, ?)";
	const QUERY_GET_USER_INFORMATION = "SELECT email, password, display_name, auth_level FROM users WHERE user_id = ?";
	const QUERY_CHECK_USER_EMAIL = "SELECT salt FROM users WHERE email = ?";
	const QUERY_CHECK_USER_INFORMATION = "SELECT user_id, auth_level, display_name FROM users WHERE email = ? AND password = ?";
	const QUERY_UPDATE_PAGE = "UPDATE pages SET page_url = ?, page_variables = ? WHERE page_url = ?";
	const QUERY_ADD_NEW_PAGE = "INSERT INTO pages (page_url, page_variables) VALUES (?, ?)";
	protected $dbh;
	
	public function __construct() {
		$this->dbh = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
	}

	public function GetPageContent($pageURL) {
		$stmt = $this->dbh->prepare(self::QUERY_GET_PAGE);
		$stmt->execute(array($pageURL));
		if ($stmt->fetchColumn() !== false) {
			$stmt = $this->dbh->prepare(self::QUERY_GET_PAGE);
			$stmt->execute(array($pageURL));
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$valuesArray = array(
								'pageVariables' => $result['page_variables']
								);
			return $valuesArray;
		} else {
			return false;
		}
	}

	public function GetAllPages() {
		$stmt = $this->dbh->prepare(self::QUERY_GET_PAGES);
		$stmt->execute();
		if ($stmt->fetchColumn() !== false) {
			$stmt = $this->dbh->prepare(self::QUERY_GET_PAGES);
			$stmt->execute();
			$pages = $stmt->fetchAll();
			return $pages;
		} else {
			return false;
		}
	}

	public function GetSettings() {
		$stmt = $this->dbh->prepare(self::QUERY_GET_SETTINGS);
		$stmt->execute();
		if ($stmt->fetchColumn() !== false) {
			$stmt = $this->dbh->prepare(self::QUERY_GET_SETTINGS);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$settingsArray = array(
								'websiteName' => $result['website_name'],
								'footerText' => $result['footer_text'],
								'template' => $result['template']
								);
			return $settingsArray;
		} else {
			return false;
		}
	}

	public function GetLinks() {
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

	public function SaveLinks($links) {
		$stmt = $this->dbh->prepare('TRUNCATE links');
		$stmt->execute();
		foreach ($links as $link) {
			$this->AddLink($link);
		}
	}

	public function AddLink($link) {
		$stmt = $this->dbh->prepare(self::QUERY_ADD_LINK);
		if ($stmt->execute(array($link['name'], $link['url'], $link['title'], $link['order']))) {
			return true;
		} else {
			var_dump($this->dbh->errorInfo());
		}
	}

	public function GetUsersAuth($id) {
		$stmt = $this->dbh->prepare(self::QUERY_GET_USER_INFORMATION);
		$stmt->execute(array($id));
		if ($stmt->fetchColumn() !== false) {
			$stmt = $this->dbh->prepare(self::QUERY_GET_USER_INFORMATION);
			$stmt->execute(array($id));
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result['auth_level'];
		} else {
			return 0;
		}
	}

	public function CheckUserCredentials($email, $password) {
		$stmt = $this->dbh->prepare(self::QUERY_CHECK_USER_EMAIL);
		$stmt->execute(array($email));
		if ($stmt->fetchColumn() !== false) {
			// Email exists
			$stmt = $this->dbh->prepare(self::QUERY_CHECK_USER_EMAIL);
			$stmt->execute(array($email));
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			// Salt and hash the password
			$password = crypt($password, '$2a$10$' . $result['salt']);
			$stmt = $this->dbh->prepare(self::QUERY_CHECK_USER_INFORMATION);
			$stmt->execute(array($email, $password));
			if ($stmt->fetchColumn() !== false) {
				$stmt = $this->dbh->prepare(self::QUERY_CHECK_USER_INFORMATION);
				$stmt->execute(array($email, $password));
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				$userInformation = array(
								'authLevel' => $result['auth_level'],
								'userId' => $result['user_id'],
								'displayName' => $result['display_name']
								);
				return $userInformation;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function UpdatePage($newPageURL, $currentPageURL, $pageVariables) {
		$stmt = $this->dbh->prepare(self::QUERY_UPDATE_PAGE);
		if ($stmt->execute(array($newPageURL, $pageVariables, $currentPageURL))) {
			return true;
		} else {
			return false;
		}
	}

	public function AddNewPage($pageURL, $pageVariables) {
		$stmt = $this->dbh->prepare(self::QUERY_ADD_NEW_PAGE);
		if ($stmt->execute(array($pageURL, $pageVariables))) {
			return true;
		} else {
			return false;
		}
	}
}
?>