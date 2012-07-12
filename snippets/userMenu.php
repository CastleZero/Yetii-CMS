<?php
if (isset($_SESSION['userId'])) {
	// Player is logged in
	echo 'Welcome, <a href="#" title="View your profile">' . $_SESSION['displayName'] . '</a>. <a href="/logout.php">Log Out</a>';
} else {
	// Player not logged in
	echo '<a href="/login.php" title="Log In">Log In</a> &#124; <a href="/register.php" title="Register">Register</a>';
}
?>