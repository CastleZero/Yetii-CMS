<?php

class Yetii {
	private $name, $channel, $template, $language, $update = false;
	const VERSION = '0.3.1';

	public function loadSettings() {
		$mapper = new Mapper();
		$settings = $mapper->getSettings();
		unset($mapper);
		$this->name = $settings['websiteName'];
		$this->channel = $settings['versionChannel'];
		$this->template = $settings['template'];
		$this->language = $settings['language'];
		// Legacy support
		if (!defined('WEBSITENAME')) {
			define('WEBSITENAME', $settings['websiteName']);
		}
		if (!defined('VERSION')) {
			define('VERSION', self::VERSION);
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
		$update->getInformation($this->channel, self::VERSION);
		if ($update->getError() === false && self::VERSION < $update->getVersion()) {
			return $update;
		} else {
			return false;
		}
	}
}
?>