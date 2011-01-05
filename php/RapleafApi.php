<?php
	namespace Rapleaf;
	
	define("RAPLEAF_API_KEY", "SET_ME");			// Set your API key here
	define("RAPLEAF_BASE_PATH", "https://personalize.rlcdn.com/v4/dr?email=");
	$rapleaf_api_curl = curl_init();
	curl_setopt($rapleaf_api_curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($rapleaf_api_curl, CURLOPT_TIMEOUT, 2.0);
	curl_setopt($rapleaf_api_curl, CURLOPT_SSL_VERIFYPEER, TRUE);
	curl_setopt($rapleaf_api_curl, CURLOPT_USERAGENT, "RapleafApi/PHP/1.0");
	
	// Takes an e-mail and returns a hash mapping attribute fields onto attributes
	function query_by_email($email) {
		$url = RAPLEAF_BASE_PATH . urlencode($email) . "&api_key=" . RAPLEAF_API_KEY;
		global $rapleaf_api_curl;
		curl_setopt($rapleaf_api_curl, CURLOPT_URL, $url);
		$json_string = curl_exec($rapleaf_api_curl);
		$response_code = curl_getinfo($rapleaf_api_curl, CURLINFO_HTTP_CODE);
		if ($response_code < 200 || $response_code >= 300) {
			trigger_error("Error Code: " . $response_code . "\nError Body: " . $json_string);
		} else {
			$personalization = json_decode($json_string, TRUE);
			return $personalization;
		}
	}
?>