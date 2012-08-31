<?php
$pageName = 'Log out';
if (isset($_SESSION['userId']) || isset($_SESSION['displayName'])) {
	// User is logged in
	if (session_destroy()) {
		// User has been logged out
		echo 'You have been logged out. You will now be redirected to the <a href="index.php">home page</a>.';
		header('Refresh: 5; index.php');
	} else {
		echo 'There was an error logging you out. Please <a href="logout.php">try again</a>.';
	}
} else {
	// User is not logged in
	echo 'You are not logged in. You will now be redirected to the <a href="login.php">log in page</a>.';
	header('Refresh: 3; login.php');
}
?>