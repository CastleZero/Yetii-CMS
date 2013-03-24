<?php
$pageName = 'Register';
$metaDescription = 'Register for an account on ' . WEBSITENAME . '.';
?>
<h1>Register</h1>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Form has been submitted
	$errors = array();
	if (isset($_POST['displayName'])) {
		$displayName = $_POST['displayName'];
		if (strlen($displayName) < 4 || strlen($displayName) > 64) {
			$error = array('message' => 'Display name must be at least 4 characters and a maximum of 64 characters.', 'field' => 'displayName');
			array_push($errors, $error);
		}
	} else {
		$error = array('message' => 'Display name must entered', 'field' => 'displayName');
		array_push($errors, $error);
	}
	if (isset($_POST['email'])) {
		$email = $_POST['email'];
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = array('message' => 'Email address is not a valid email', 'field' => 'email');
			array_push($errors, $error);
		}
	} else {
		$error = array('message' => 'Email address name must entered', 'field' => 'email');
		array_push($errors, $error);
	}
	if (isset($_POST['password'])) {
		$password = $_POST['password'];
	} else {
		$error = array('message' => 'Password name must entered', 'field' => 'password');
		array_push($errors, $error);
	}
	if (isset($_POST['passwordVerification'])) {
		$passwordVerification = $_POST['passwordVerification'];
	} else {
		$error = array('message' => 'Password name must entered', 'field' => 'passwordVerification');
		array_push($errors, $error);
	}
	if ($password !== $passwordVerification) {
		$error = array('message' => 'Passwords must match', 'field' => 'password');
		array_push($errors, $error);
	}
	if (count($errors) == 0) {
		// Input has was valid
		$mapper = new Mapper();
		$result = $mapper->RegisterUser($email, $password, $displayName);
		unset($mapper);
		if ($result === true) {
			// User was successfully registered
			echo 'You have been successfully registered. Please click the link in the verification email sent to log in to your account.<br>';
			return;
		} else {
			// There was an error registering the user
			echo 'There was an error registering you.<br>';
		}
	} else {
		// Input data was invalid
		DisplayErrors($result);
	}
}
?>
<form method="POST">
	<label>Display Name: <input type="text" name="displayName" <?php if (isset($displayName)) echo 'value="' . $displayName . '"' ?>></label><br>
	<label>Email Address: <input type="email" name="email" <?php if (isset($email)) echo 'value="' . $email . '"' ?>></label><br>
	<label>Password: <input type="password" name="password" <?php if (isset($password)) echo 'value="' . $password . '"' ?>></label><br>
	<label>Password (again): <input type="password" name="passwordVerification" <?php if (isset($passwordVerification)) echo 'value="' . $passwordVerification . '"' ?>></label><br>
	<input type="submit" value="Register"><br>
</form>