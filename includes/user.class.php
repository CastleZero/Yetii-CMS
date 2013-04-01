<?php

class User {
	private $email, $displayName, $authenticationLevel;

	public static function register($email, $password, $passwordVerification, $displayName, $authenticationLevel = -1) {
		global $errors;
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors->add(Error::withDescription('Email address not valid'));
		}
		if ($password !== $passwordVerification) {
			$errors->add(Error::withDescription('Passwords do not match'));
		}
		if (strlen($password) < 6) {
			$errors->add(Error::withDescription('Password must be at least 6 characters'));
		}
		if (strlen($displayName) < 4 || strlen($displayName) > 64) {
			$errors->add(Error::withDescription('Display name must be at least 4 characters and a maximum of 64 characters.'));
		}
		if ($errors->hasErrors()) {
			return $errors;
		} else {
			$mapper = new Mapper();
			$result = $mapper->addNewUser($email, $password, $displayName, $authenticationLevel);
			unset($mapper);
			return $result;
		}
	}
}
?>