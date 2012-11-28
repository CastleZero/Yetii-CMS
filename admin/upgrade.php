<?php
$pageName = 'Upgrade your installation';
$requiredAuth = 3;
$isLatestVersion = IsLatestVersion();
if ($isLatestVersion === true) {
	echo 'You\'re already on the latest version. Go you!<br>';
} else if ($isLatestVersion === false) {
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
			if (!is_dir(TEMPDIRECTORY)) {
				mkdir(TEMPDIRECTORY);
			}
			$latestZip = fopen('https://github.com/JosephDuffy/Yetii-CMS/zipball/' . VERSIONCHANNEL, 'rb');
			/* Zip download code from http://stackoverflow.com/a/3938844/657676 */
			$localFile = fopen(TEMPDIRECTORY . 'latest.zip', 'wb');
			if ($localFile) {
					while(!feof($latestZip)) {
						fwrite($localFile, fread($latestZip, 1024 * 8), 1024 * 8);
					}
			}
			/* End zip download code */
			fclose($localFile);
			fclose($latestZip);
			$zip = new ZipArchive();
			if ($zip->open(TEMPDIRECTORY . 'latest.zip')) {
				// Zip has been opened successfully
				if (is_dir(TEMPDIRECTORY . 'lastest')) {
					removeDirectory(TEMPDIRECTORY . 'lastest');
				}
				if (is_dir(TEMPDIRECTORY . 'lastest')) {
					$zip->close();
					echo 'There was an error deleting an old temp copy of Yetii.<br>';
				} else {
					$zip->extractTo(TEMPDIRECTORY);
					$zip->close();
					if (is_file(TEMPDIRECTORY . 'latest/includes/upgrade/files.inc.php')) {
						require_once(TEMPDIRECTORY . 'latest/includes/upgrade/files.inc.php');
						$missingFiles = array();
						foreach ($currentFiles as $file) {
							if (!is_file(TEMPDIRECTORY . 'latest/' . $file)) {
								array_push($missingFiles, $file);
							}
						}
						if (count($missingFiles) > 0) {
							echo 'The download is missing the following files and the upgrade will not be abandoned:<br>';
							foreach ($missingFiles as $file) {
								echo $file . '<br>';
							}
						} else {
							// No files are missing from the downloaded zip
							foreach ($currentFiles as $file) {
								echo 'Moving ' . $file . ' to new installation location.<br>';
							}
						}
					} else {
						echo '"includes/update/files.inc.php" could not be found in the newly downloaded version of Yetii. Upgrade will now abort.<br>';
					}
				}
			} else {
				unlink(TEMPDIRECTORY . 'latest.zip');
				echo 'There was an error with the downloaded zip file. Please try again.<br>';
				$zip->close();
			}
			if (rename('maintenance', '_maintenance')) {
				echo 'The website is no longer in maintenance mode.<br>';
			} else {
				echo 'The maintenance file could not be renamed. Please either delete the "maintenance" file in your root directory or rename it to "_maintenance".<br>';
			}
		}
	} else {
		echo 'Version ' . GetLatestVersionNumber() . ' is out! Would you like to <a href="?perform_upgrade=true">upgrade</a>?<br>';
		echo '<strong>THIS CAN TAKE A LONG TIME. PLEASE DO NOT STOP OR LEAVE THIS PAGE ONCE YOU START THE UPGRADE.<br>';
	}
}
?>