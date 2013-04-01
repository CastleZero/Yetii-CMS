<?php
class Error {
	private $code, $decsription, $context;

	public static function withCode($ocde) {
		$error = new self();
		$error->setCode($code);
		return $error;
	}

	protected function setCode($code) {
		$this->code = $code;
	}

	public static function withDescription($description, $context = '') {
		$error = new self();
		$error->setDescription($description);
		$error->setContext($context);
		return $error;
	}

	protected function setDescription($description) {
		$this->description = $description;
	}
	protected function setContext($context) {
		$this->context = $context;
	}

	public function __toString() {
		return $this->description . '<br>';
	}
}
?>