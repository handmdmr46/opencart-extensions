<?php
class Ebaycall {

	public $requestToken;
	public $devID;
	public $appID;
	public $certID;
	public $serverUrl;
	public $compatLevel;
	public $siteID;
	public $callName;

	public function __construct($developerID, $applicationID, $certificateID, $compatLevel, $siteID, $callName) {
		$this->devID = $developerID;
		$this->appID = $applicationID;
		$this->certID = $certificateID;
		$this->compatLevel = $compatLevel;
		$this->siteID = $siteID;
		$this->callName = $callName;

	}

	public function sendHttpRequest($body) {
		//Production
		// $endpoint = "https://api.ebay.com/ws/api.dll";

		//Sandbox
		$endpoint = "https://api.sandbox.ebay.com/ws/api.dll";

		$headers = $this->buildEbayHeaders();

		$body = utf8_encode($body);

		$curl = curl_init();

		curl_setopt_array($curl,
			array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => $endpoint,
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => $body,
				CURLOPT_HTTPHEADER => $headers
			)
		);

		$response = curl_exec($curl);

		curl_close($curl);

		if(!$response){
			$response = die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
			return $response;
		}
		else
		{
			return $response;
		}
	}

	private function buildEbayHeaders() {
		$headers = array (
			'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $this->compatLevel,
			'X-EBAY-API-DEV-NAME: ' . $this->devID,
			'X-EBAY-API-APP-NAME: ' . $this->appID,
			'X-EBAY-API-CERT-NAME: ' . $this->certID,
			'X-EBAY-API-SITEID: ' . $this->siteID,
			'X-EBAY-API-CALL-NAME: ' . $this->callName
		);

		return $headers;
	}


}