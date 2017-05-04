<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use GuzzleHttp\Client;

class Json_ld_helpers {

	public static function getBaseURL($method='', $extra='')
	{
		if($method == '/') $method = '';
		elseif($method) $method = '/'.$method;

		return ee('CP/URL', 'addons/settings/json_ld'.$method.$extra);
	}

	public static function getNav($nav_items=array())
	{
		$sidebar = ee('CP/Sidebar')->make();
		$last_segment = ee()->uri->segment_array();
		$last_segment = end($last_segment);

		foreach($nav_items as $title => $method) {
			if($method == '/') {
				$method = 'index';
			}

			if(strpos($method, 'http') === false) {
				$url = Json_ld_helpers::getBaseURL($method);
			} else {
				$url = $method;
			}

			$nav_items[$title] = $sidebar->addHeader($title)->withUrl($url);
		}
	}

	public static function googleValidate($data)
	{
		
		// Get data
		$googleURL = "https://search.google.com/structured-data/testing-tool/validate";

		$sendData['html'] = $data;

		// Guzzle it to Google
		$client = new \GuzzleHttp\Client();

		try {

			$response = $client->request('POST', $googleURL, [

  				'form_params' => $sendData,
  				'headers' => [
					'Content-Type' => 'application/x-www-form-urlencoded'
				]
			
			]);
		
		} catch (Exception $e) {
		
			return null;
		
		}

		// Shoot back the response
		return $response->getBody()->getContents();

	}

}