<?php
$settings = parse_ini_file('settings.ini');
extract($settings);
if (isset($_SESSION['displayName'])) {
	// User is logged in
	if (!isset($showWhenLoggedIn) || $showWhenLoggedIn != 'false') {
		echo 'Welcome, <a href="#" title="View your profile">' . $_SESSION['displayName'] . '</a>. <a href="' . ROOTURL . 'logout.php">Log Out</a>';
	}
} else {
	// User not logged in
	if (!isset($showWhenLoggedOut) || $showWhenLoggedOut != 'false') {
		echo '<a href="' . ROOTURL . 'login.php" title="Log In">Log In</a> | <a href="' . ROOTURL . 'register.php" title="Register">Register</a>';
	}
}
?>