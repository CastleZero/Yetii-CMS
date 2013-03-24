<?php
class RESTRequest {
	protected $url, $verb, $curl, $responseBody, $responseInfo;

	public function __construct($url, $verb) {
		$this->url = $url;
		$this->verb = $verb;
	}

	public function execute() {
		$curl = curl_init();

        switch (strtoupper($this->verb)) {
			case 'GET':
				$this->executeGET($curl);
			break;
			case 'POST':
				$this->executePOST($curl);
			break;
			case 'PUT':
				$this->executePUT($curl);
			break;
			case 'DELETE':
				$this->executeDELETE($curl);
			break;
			default:
				throw new InvalidArgumentException('The verb "' . $this->verb . '" is not a valid REST verb.');
			break;
		}

		// catch (InvalidArgumentException $e) {
		// 	curl_close($curl);
		// 	throw $e;
		// }

		// catch (Exception $e) {
		// 	curl_close($curl);
		// 	throw $e;
		// }
	}

	protected function setOptions(&$curlHandle) {
		curl_setopt($curlHandle, CURLOPT_TIMEOUT, 10);
	    curl_setopt($curlHandle, CURLOPT_URL, $this->url);
	    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
	}

	protected function doExecute(&$curlHandle) {
		$this->setOptions($curlHandle);
	    $this->responseBody = curl_exec($curlHandle);
	    $this->responseInfo  = curl_getinfo($curlHandle);
	    curl_close($curlHandle);
	}

	protected function executeGET($curl) {
    	$this->doExecute($curl);
	}

	public function getResponse() {
		return $this->responseBody;
	}
}
?>