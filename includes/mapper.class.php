<?php

class Mapper {
	const QUERY_GET_PAGE = "SELECT page_name, required_auth, page_content, meta_description FROM pages WHERE page_url = ?";
	const QUERY_CHANGE_PAGE_URL = "UPDATE pages SET page_url = ? WHERE page_url = ?";
	const QUERY_ADD_NEW_PAGE = "INSERT INTO pages (page_url, page_name, required_auth, page_content, meta_description) VALUES (?, ?, ?, ?, ?)";
	const QUERY_UPDATE_PAGE = "UPDATE pages SET page_name = ?, required_auth = ?, page_content = ?, meta_description = ? WHERE page_url = ?";
	const QUERY_GET_PAGES = "SELECT page_url FROM pages";
	const QUERY_GET_SNIPPET_VARIABLES = "SELECT variables FROM snippets WHERE snippet_name = ?";
	const QUERY_GET_SETTINGS = "SELECT website_name, template FROM settings LIMIT 0, 1";
	const QUERY_GET_LINKS = "SELECT name, url, title, `order`, required_auth FROM links ORDER BY `order` ASC";
	const QUERY_ADD_LINK = "INSERT INTO links (name, url, title, `order`, required_auth) VALUES (?, ?, ?, ?, ?)";
	const QUERY_REGISTER_USER = "INSERT INTO users (email, password, display_name, salt, auth_level) VALUES (?, ?, ?, ?, ?)";
	const QUERY_GET_USER_INFORMATION = "SELECT email, password, display_name, auth_level FROM users WHERE user_id = ?";
	const QUERY_CHECK_USER_EMAIL = "SELECT salt FROM users WHERE email = ?";
	const QUERY_CHECK_USER_INFORMATION = "SELECT user_id, auth_level, display_name FROM users WHERE email = ? AND password = ?";
	const QUERY_DELETE_PAGE = "DELETE FROM pages WHERE page_url = ?";
	protected $dbh;
	
	public function __construct() {
		$this->dbh = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
	}

	public function GetPage($url) {
		if ($url == '' || $url == '/' || $url == 'index.php') {
			// Looking for index
			$url = 'index';
		}
		$stmt = $this->dbh->prepare(self::QUERY_GET_PAGE);
		$stmt->execute(array($url));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result['page_name']) {
			$valuesArray = array(
								'name' => $result['page_name'],
								'requiredAuth' => $result['required_auth'],
								'content' => $result['page_content'],
								'metaDescription' => $result['meta_description']
								);
			return $valuesArray;
		} else {
			return false;
		}
	}

	public function SavePage($url, $name, $requiredAuth, $contents, $metaDescription, $oldURL = false) {
		if ($this->GetPage($url) !== false || $this->GetPage($oldURL) !== false) {
			// Page already exists; update it
			if ($oldURL !== false) {
				// The URL of the page is being updated
				$stmt = $this->dbh->prepare(self::QUERY_CHANGE_PAGE_URL);
				if (!$stmt->execute(array($url, $oldURL))) {
					return false;
				}
			}
			$stmt = $this->dbh->prepare(self::QUERY_UPDATE_PAGE);
			if ($stmt->execute(array($name, $requiredAuth, $contents, $metaDescription, $url))) {
				return true;
			} else {
				return false;
			}
		} else {
			// Page is new; create it
			$stmt = $this->dbh->prepare(self::QUERY_ADD_NEW_PAGE);
			if ($stmt->execute(array($url, $name, $requiredAuth, $metaDescription, $contents))) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function GetSnippetVariables($snippet) {
		$stmt = $this->dbh->prepare(self::QUERY_GET_SNIPPET_VARIABLES);
		$stmt->execute(array($snippet));
		if ($stmt->fetchColumn() !== false) {
			$stmt = $this->dbh->prepare(self::QUERY_GET_SNIPPET_VARIABLES);
			$stmt->execute(array($snippet));
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$result = json_decode($result['variables'], true);
			return $result;
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
		if ($stmt->execute(array($link['name'], $link['url'], $link['title'], $link['order'], $link['required_auth']))) {
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

	public function RegisterUser($email, $password, $displayName, $authLevel = 0) {
		// Generate the salt
		$salt = GenerateRandomString(22, './0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
		if ($salt !== false) {
			// Create the hashed and salted password
			$password = crypt($password, '$2a$10$' . $salt);
			$stmt = $this->dbh->prepare(self::QUERY_REGISTER_USER);
			if ($stmt->execute(array($email, $password, $displayName, $salt, $authLevel))) {
				return true;
			} else {
				return false;
			}
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

	public function DeletePage($pageURL) {
		$stmt = $this->dbh->prepare(self::QUERY_DELETE_PAGE);
		if ($stmt->execute(array($pageURL))) {
			return true;
		} else {
			return false;
		}
	}
}
?>