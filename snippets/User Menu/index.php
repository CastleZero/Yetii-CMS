<?php
$displayLogin = false;
if (isset($_SESSION['displayName'])) {
	// User is logged in
	echo 'Welcome, <a href="#" title="View your profile">' . $_SESSION['displayName'] . '</a>. <a href="/logout.php">Log Out</a>';
} else {
	// User not logged in
	if ($displayLogin === true) {
		echo '<a href="/login.php" title="Log In">Log In</a> | <a href="/register.php" title="Register">Register</a>';
	}
}
?>