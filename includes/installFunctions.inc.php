<?php
function validateInput($name, $value) {
	switch ($name) {
		case 'websiteName':
			if ($value === '') {
				return 'Website Name cannot be empty';
			} else {
				return true;
			}
		break;

		default:
			return true;
		break;
	}
}
?>