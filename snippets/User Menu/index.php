<?php
$displayLogin = true;
if (isset($_SESSION['displayName'])) {
	// User is logged in
	echo 'Welcome, <a href="#" title="View your profile">' . $_SESSION['displayName'] . '</a>. <a href="' . ROOTURL . 'logout.php">Log Out</a>';
} else {
	// User not logged in
	if ($displayLogin === true) {
		echo '<a href="' . ROOTURL . 'login.php" title="Log In">Log In</a> | <a href="' . ROOTURL . 'register.php" title="Register">Register</a>';
	}
}
?>