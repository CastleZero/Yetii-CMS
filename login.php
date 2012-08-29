<?php
$pageName = 'Log In';
if (isset($_SESSION['user_id'])) {
	// User already logged in
	header('Location: index.php');
	exit;
}
$errors = array();
if (isset($_GET['returnAddress'])) {
	$returnAddress = $_GET['returnAddress'];
	$error['message'] = 'You must log in to access that page. Please log in below to gain access to that page.';
	array_push($errors, $error);
} else {
	$returnAddress = '/';
}
if (isset($_POST['email']) || isset($_POST['password'])) {
	// An email or password was submitted
	$errors = array();
	// Check we have both email and password, if we don't have one, add it to the $errors array
	if ($_POST['email']) {
		// Convert it to lowercase so we can use it as a salt
		$email = strtolower($_POST['email']);
	} else {
		$error['name'] = 'email';
		$error['message'] = 'Please input an email';
		array_push($errors, $error);
	}
	if ($_POST['password']) {
		$password = $_POST['password'];
	} else {
		$error['name'] = 'password';
		$error['message'] = 'Please input a password';
		array_push($errors, $error);
	}
	if (count($errors) > 0) {
		// We have errors, display them at the end
	} else {
		// Both the email and password were submitted
		$mapper = new Mapper;
		$results = $mapper->CheckUserCredentials($email, $password); // The password is hashed and salted in this function
		if (is_array($results)) {
			extract($results);
		} else {
			$authLevel = $results;
		}
		if ($authLevel === false) {
			// Credentials were correct but the account has problems
			$error = array('message'=>'Incorrect email/password combination.');
			array_push($errors, $error);
		} else {
			// Credentials were correct
			if ($authLevel > 0) {
				// User has a valid account, log them in.
				$_SESSION['userId'] = $userId;
				$_SESSION['displayName'] = $displayName;
				echo 'You have been logged in! If you are not redirected, you can go to <a href="' . $returnAddress . '">where your were previously</a>.';
				header('Location: redirect.php?action=login&returnAddress=' . $returnAddress);
			} else if ($authLevel == 0) {
				$error = array('message'=>'Your email has not been verified');
				array_push($errors, $error);
			} else if ($authLevel == -1) {
				$error = array('message'=>'Your account has not been accepted yet');
				array_push($errors, $error);
			} else if ($authLevel == -2) {
				$error = array('message'=>'Your account has been banned');
				array_push($errors, $error);
			}
		}
	}
}

if (count($errors) > 0) {
	showErrors($errors);
}
?>
<form action="login.php<?php if (isset($_GET['returnAddress'])) echo '?returnAddress=' . $_GET['returnAddress']; ?>" method="POST">
	<label for="email">Email: </label>
	<input type="email" name="email" id="email" <?php if (isset($_POST['email'])) echo 'value="' . $_POST['email'] . '"' ?> autofocus="autofocus"><br>
	<label for="password">Password: </label>
	<input type="password" name="password" id="password"><br>
	<input type="submit" name="submit" value="Log In">
</form>