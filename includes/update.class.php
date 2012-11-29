<?php
class Update {
	private $error = false, $version, $url, $unpackedName, $localZipLocation, $unpackedLocation, $files, $redundantFiles;

	public function getInformation($channel) {
		$RESTRequest = new RESTRequest('http://yetii.net/rest/channels/' . VERSIONCHANNEL, 'GET');
		$RESTRequest->execute();
		$latestUpdate = json_decode($RESTRequest->getResponse(), true);
		unset($RESTRequest);
		if ($latestUpdate) {
			if (array_key_exists('error', $latestUpdate)) {
				$this->error = $latestUpdate['error'];
			} else {
				$this->version = $latestUpdate['version'];
				$this->url = $latestUpdate['updateURL'];
				$this->unpackedName = $latestUpdate['unpackedName'];
			}
		} else {
			$this->error = true;
		}
	}

	/**
	*	Downloads the remote zip archive.
	*	Would be a good idea to verify the download here
	*
	*/

	public function download() {
		if (!is_dir(TEMPDIRECTORY)) {
			mkdir(TEMPDIRECTORY);
		}
		$remoteZip = fopen($this->url, 'rb');
		$this->localZipLocation = TEMPDIRECTORY . 'latest.zip';
		/* Zip download code from http://stackoverflow.com/a/3938844/657676 */
		$localZip = fopen($this->localZipLocation, 'wb');
		if ($localZip) {
				while(!feof($remoteZip)) {
					fwrite($localZip, fread($remoteZip, 1024 * 8), 1024 * 8);
				}
		}
		/* End zip download code */
		fclose($localZip);
		fclose($remoteZip);
	}

	/**
	*	Unzips the downloaded zip archive.
	*	Verifies the downloaded file is a valid zip archive and then checks that all the required files are there
	*
	*/

	public function unzip() {
		$this->unpackedLocation = TEMPDIRECTORY . $this->unpackedName;
		$zip = new ZipArchive();
		if ($zip->open($this->localZipLocation)) {
			// Zip has been opened successfully
			if (is_dir($this->unpackedLocation)) {
				// A previous download still exists on the system, remove it
				removeDirectory($this->unpackedLocation);
			}
			if (is_dir($this->unpackedLocation)) {
				// There was an issue deleting the old download, abort
				$zip->close();
				echo 'There was an error deleting an old temp copy of Yetii.<br>';
			} else {
				$zip->extractTo(TEMPDIRECTORY);
				$zip->close();
				// Delete the local .zip archive
				unlink($this->localZipLocation);
				if (is_file($this->unpackedLocation . '/includes/upgrade/files.inc.php')) {
					require_once($this->unpackedLocation . '/includes/upgrade/files.inc.php');
					$this->files = $currentFiles;
					$this->redundantFiles = $oldFiles;
					$missingFiles = array();
					foreach ($this->files as $file) {
						if (!is_file($this->unpackedLocation . '/' . $file)) {
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
						return true;
					}
				} else {
					echo '"includes/upgrade/files.inc.php" could not be found in the newly downloaded version of Yetii. Upgrade will now abort.<br>';
				}
			}
			// Delete the extracted files
			removeDirectory($unpackedDir);
		} else {
			$zip->close();
			unlink($unpackedDir);
			unlink($localZip);
			echo 'There was an error with the downloaded zip file. Please try again.<br>';
		}
	}

	public function performUpgrade() {
		if (INSTALLURL !== '') {
			echo 'Sorry, automatic upgrades are not supported with a custom install url at this time.<br>';
		} else {
			if (is_file($unpackedLocation . '/beforeUpgrade.php')) {
				// A script with actions to perform before the new files are moved is included in this upgrade
				require_once($unpackedLocation . '/beforeUpgrade.php');
			}
			foreach ($this->files as $file) {
				// Need to check if the destination directory exists!
				if (!rename($this->unpackedLocation . '/' . $file, INSTALLURL . $file)) {
					echo 'Error moving ' . $file . '<br>'; 
				}
			}
			if (is_file($unpackedLocation . '/afterUpgrade.php')) {
				// A script with actions to perform after the new files are moved is included in this upgrade
				require_once($unpackedLocation . '/afterUpgrade.php');
			}
			foreach ($this->redundantFiles as $file) {
				if (is_file($file)) {
					unlink($file);
				}
			}
		}
	}

	public function getError() {
		return $this->error;
	}

	public function getVersion() {
		return $this->version;
	}
}
?>