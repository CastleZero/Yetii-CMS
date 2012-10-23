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
						fwrite($localFile, fread($latestZip, 1024 * 8 ), 1024 * 8 );
					}
			}
			/* End zip download code */
			fclose($localFile);
			fclose($latestZip);
			$zip = new ZipArchive();
			if ($zip->open(TEMPDIRECTORY . 'latest.zip')) {
				$zip->extractTo(TEMPDIRECTORY);
				$zip->close();
				$results = glob(TEMPDIRECTORY . '*');
				foreach($results as $result) {
					if (is_dir($result) && $result != '.' && $result != '..') {
						if (!isset($folder)) {
							$folder = $result;
						} else {
							$folder = false;
						}
					}
				}
				if ($folder) {
					unlink(TEMPDIRECTORY . 'latest.zip');
					rename($folder, TEMPDIRECTORY . 'latest');
				} else {
					echo 'There was an error extracting the zip or an old one still remains. Please try again.<br>';
					if (!RemoveDirectory('includes/temp')) {
						echo 'Please try deleting the ' . TEMPDIRECTORY . ' folder.<br>';
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