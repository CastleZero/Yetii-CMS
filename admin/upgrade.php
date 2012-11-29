<?php
$pageName = 'Upgrade your installation';
$requiredAuth = 3;
require_once('includes/update.class.php');
$thisInstall = new Yetii();
$thisInstall->loadSettings();
$update = $thisInstall->getUpdate();
if ($update === false) {
	echo 'You\'re already on the latest version. Go you!<br>';
} else {
	if (isset($_GET['perform_upgrade'])) {
		if (is_file('_maintenance')) {
			rename('_maintenance', 'maintenance');
		} else {
			file_put_contents('maintenance', '');
		}
		if (!is_file('maintenance')) {
			echo 'There was an error creating the maintenance file. Please try upgrading again.<br>';
		} else {
			// Maintenance mode is now in effect
			$update->download();
			if ($update->unzip()) {
				$update->performUpgrade();
				echo 'Zip downloaded ok!<br>';
			}
			if (rename('maintenance', '_maintenance')) {
				echo 'The website is no longer in maintenance mode.<br>';
			} else {
				echo 'The maintenance file could not be renamed. Please either delete the "maintenance" file in your root directory or rename it to "_maintenance".<br>';
			}
		}
	} else {
		echo 'Version ' . $update->getVersion() . ' is out! Would you like to <a href="?perform_upgrade=true">upgrade</a>?<br>';
		echo '<strong>THIS CAN TAKE A LONG TIME. PLEASE DO NOT STOP OR LEAVE THIS PAGE ONCE YOU START THE UPGRADE.</strong><br>';
	}
}
?>