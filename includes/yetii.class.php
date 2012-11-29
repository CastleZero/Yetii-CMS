<?php

class Yetii {
	private $name, $version, $channel, $template, $language, $update = false;

	public function loadSettings() {
		$mapper = new Mapper();
		$settings = $mapper->GetSettings();
		unset($mapper);
		$this->name = $settings['websiteName'];
		$this->version = $settings['version'];
		$this->channel = $settings['versionChannel'];
		$this->template = $settings['template'];
		$this->language = $settings['language'];
		// Legacy support
		if (!defined('WEBSITENAME')) {
			define('WEBSITENAME', $settings['websiteName']);
		}
		if (!defined('VERSION')) {
			define('VERSION', $settings['version']);
		}
		if (!defined('VERSIONCHANNEL')) {
			define('VERSIONCHANNEL', $settings['versionChannel']);
		}
		if (!defined('TEMPLATE')) {
			define('TEMPLATE', $settings['template']);
		}
		if (!defined('LANGUAGE')) {
			define('LANGUAGE', $settings['language']);
		}
	}

	public function checkForUpdates() {
		
	}

	public function isLatestVersion() {
		if ($this->update === false) {
			return true;
		} else {
			return false;
		}
	}

	public function getUpdate() {
		$update = new Update();
		$update->getInformation($this->channel);
		if ($update->getError() === false && $this->version < $update->getVersion()) {
			return $update;
		} else {
			return false;
		}
	}
}
?>