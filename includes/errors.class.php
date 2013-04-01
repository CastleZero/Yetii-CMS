<?php
class Errors {
	private $errors;

	function __construct() {
		$this->errors = array();
	}

	public function add($error) {
		array_push($this->errors, $error);
	}

	public function hasErrors() {
		if (count($this->errors) > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function show() {
		foreach ($this->errors as $error) {
			echo $error;
		}
	}

}
?>