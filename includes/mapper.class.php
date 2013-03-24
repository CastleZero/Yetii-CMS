<?php

/**
 * Mapper class
 *
 * @category Class
 * @author Joseph Duffy <JosephDuffy@me.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
class Mapper {
	const QUERY_GET_SETTINGS = "SELECT website_name, version, version_channel, template, language FROM settings";
	const QUERY_GET_PAGE = "SELECT page_name, required_auth, page_content, meta_description FROM pages WHERE page_url = ?";
	const QUERY_UPDATE_PAGE_URL = "UPDATE pages SET page_url = ? WHERE page_url = ?";
	const QUERY_ADD_NEW_PAGE = "INSERT INTO pages (page_url, page_name, required_auth, page_content, meta_description) VALUES (?, ?, ?, ?, ?)";
	const QUERY_UPDATE_PAGE = "UPDATE pages SET page_name = ?, required_auth = ?, page_content = ?, meta_description = ? WHERE page_url = ?";
	const QUERY_GET_PAGES = "SELECT page_url FROM pages";
	const QUERY_GET_SNIPPET_VARIABLES = "SELECT variables FROM snippets WHERE snippet_name = ?";
	const QUERY_REGISTER_USER = "INSERT INTO users (email, password, display_name, salt, auth_level) VALUES (?, ?, ?, ?, ?)";
	const QUERY_GET_USER_INFORMATION = "SELECT email, password, display_name, auth_level FROM users WHERE user_id = ?";
	const QUERY_CHECK_USER_EMAIL = "SELECT salt FROM users WHERE email = ?";
	const QUERY_CHECK_USER_INFORMATION = "SELECT user_id, auth_level, display_name FROM users WHERE email = ? AND password = ?";
	const QUERY_DELETE_PAGE = "DELETE FROM pages WHERE page_url = ?";
	protected $dbh;

	/**
	 * Creates the PDO object which in-turn opens the database
	 * Gets the database host, name, username and password from the configuration file
	 */
	public function __construct() {
		$this->dbh = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
	}

	/**
	 * Retrieves the settings from the database and returns them in an array
	 * @return array Array containing settings stored in the database
	 */
	public function getSettings() {
		$stmt = $this->dbh->prepare(self::QUERY_GET_SETTINGS);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$settings = array(
			'websiteName' => $result['website_name'],
			'version' => $result['version'],
			'versionChannel' => $result['version_channel'],
			'template' => $result['template'],
			'language' => $result['language']
		);
		return $settings;
	}

	/**
	 * Looks for the requested URL in the database and gets the pages code
	 * @param  String $url The URL of the page requested
	 * @return mixed       Array of information stored about the page in the database or false if the URL does not exist
	 */
	public function getPage($url) {
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

	/**
	 * Saves a page to the database
	 * @param  String $url             The URL of the page to save
	 * @param  String $name            The name of the page (to be displayed the in the HTML title tag)
	 * @param  int    $requiredAuth    The level of authentication required to view the page
	 * @param  String $contents        The code defining the content of the page
	 * @param  String $metaDescription The meta description for the page to be used in the HTML meta description tag
	 * @return bool                    true if the page was saved successfully, false on error
	 */
	public function savePage($url, $name, $requiredAuth, $contents, $metaDescription) {
		if ($this->getPage($url) === false) {
			// Page is new, create it
			$stmt = $this->dbh->prepare(self::QUERY_ADD_NEW_PAGE);
			if ($stmt->execute(array($url, $name, $requiredAuth, $contents, $metaDescription))) {
				return true;
			} else {
				return false;
			}
		} else {
			$stmt = $this->dbh->prepare(self::QUERY_UPDATE_PAGE);
			if ($stmt->execute(array($name, $requiredAuth, $contents, $metaDescription, $url))) {
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	 * Changes the URL of a page stored in the database
	 * @param  String $oldURL The URL of the page change
	 * @param  String $newURL The new URL of the page
	 * @return bool           true on succession, false on error
	 */
	public function changePageURL($oldURL, $newURL) {
		$stmt = $this->dbh->prepare(self::QUERY_UPDATE_PAGE_URL);
		if (!$stmt->execute(array($newURL, $oldURL))) {
			return false;
		}
		return true;
	}

	/**
	 * Load a snippets variables from the database
	 * @param  String $snippet The name of the snippet to retreive the settings of
	 * @return mixed           If the snippet exists in the database: Array of variables. If snippet was not found or error: false
	 */
	public function getSnippetVariables($snippet) {
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

	/**
	 * Get a list of all the page URLs stored in the database
	 * @return mixed Array of page URLs if more than 0 are found, false if 0 are found
	 */
	public function getAllPages() {
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

	/**
	 * Gets the authentication level of the user with the id supplied
	 * @param  integer $id The user id (user_id in the database)
	 * @return integer     The authentication level (auth_level in the database) of the user. Defaults to 0 if the id was not found
	 */
	public function getUsersAuth($id) {
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

	/**
	 * Registers a new user with the information supplied
	 * @param  String  $email       Email address of the new user
	 * @param  String  $password    Original (plaintext) password
	 * @param  String  $displayName Display name of the user
	 * @param  integer $authLevel   Authentication level of the user. Defaults to 0
	 * @return bool                 true if the insertion was a success, false on error
	 */
	public function registerUser($email, $password, $displayName, $authLevel = 0) {
		// Generate the salt
		$salt = generateRandomString(22, './0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
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

	/**
	 * Checks whether a users credentials match a record in the database
	 * @param  String $email    Email adress input by the user
	 * @param  String $password Plaintext password
	 * @return mixed            false if credentials don't match a record. Array of users information if credentials match
	 */
	public function checkUserCredentials($email, $password) {
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

	/**
	 * Delete a page from the database
	 * @param  String $url The URL of the page to be deleted
	 * @return bool        Whether the deletion was successful
	 */
	public function deletePage($url) {
		$stmt = $this->dbh->prepare(self::QUERY_DELETE_PAGE);
		if ($stmt->execute(array($url))) {
			return true;
		} else {
			return false;
		}
	}
}
?>