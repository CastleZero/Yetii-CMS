<?php
$pageTitle = 'Redirecting You...';
switch ($_GET['action']) {
	case 'login':
		if (isset($_GET['returnAddress'])) {
			header('Refresh: 5; ' . $_GET['returnAddress']);
			echo 'Thank you for logging in. You will now be redirected to where you were previously. If you are not redirected within 5 seconds, you can <a href="' . $_GET['returnAddress'] . '">click here</a>.';
		} else {
			header('Refresh: 5; ' . ROOTURL . 'index.php');
			echo 'Thank you for logging in. You will now be redirected to the hompage. If you are not redirected within 5 seconds, you can <a href="index.php">click here</a>.';
		}
		break;
	case 'logout':
		if (isset($_GET['reason'])) {
			header('Refresh: 5; ' . ROOTURL . 'login.php');
			echo 'You have been logged out due to ' . $_GET['reason'] . '. You will be redirected to the login page. If you are not redirected within 5 seconds, you can <a href="login.php">click here</a>.';
		} else {
			header('Refresh: 5; ' . ROOTURL . 'index.php');
			echo 'You have been logged out. You will be redirected to the home page. If you are not redirected within 5 seconds, you can <a href="index.php">click here</a>.';
		}
		break;
	case 'register':
		header('Refresh: 5; ' . ROOTURL . 'index.php');
		echo 'You have been registered. An admin will need to approve your account before you can log in.  If you are not redirected within 5 seconds, you can <a href="index.php">click here</a>.';
		break;
	default:
		header('Refresh: 5; ' . ROOTURL . 'index.php');
		echo 'You will now be redirected to the hompage. If you are not redirected within 5 seconds, you can <a href="index.php">click here</a>.';
}
?>