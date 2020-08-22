<?php
namespace CoolSMS\PHP53;

use DateTime;
use DateTimeZone;

/**
 * Class Curl
 *
 * @package CoolSMS\V4
 */
class Curl
{
	/**
	 * @var string $apiKey
	 */
	private $apiKey;

	/**
	 * @var string $apiSecret
	 */
	private $apiSecret;

	/**
	 * @var string $apiURL
	 */
	private $apiURL = 'https://api.coolsms.co.kr';

	public function __construct()
	{
		$this->apiKey = Coolsms::$apiKey;
		$this->apiSecret = Coolsms::$apiSecret;
	}

	/**
	 * signature
	 *
	 * @param   string  $dateTime
	 * @param   string  $salt
	 *
	 * @return  string
	 */
	private function signature($dateTime, $salt)
	{
		return hash_hmac('SHA256', $dateTime . $salt, $this->apiSecret);
	}

	/**
	 * dateTime
	 *
	 * @return  string
	 */
	private function dateTime()
	{
		$datetime = new DateTime();
		$datetime->setTimezone(new DateTimeZone('Z'));
		return $datetime->format('c');
	}

	/**
	 * arrayUnset
	 *
	 * @param   array   $data
	 *
	 * @return  array
	 */
	private function arrayUnset($data)
	{
		foreach ($data as $key => $value)
		{
			if (is_null($value))
				unset($data[$key]);
			elseif (is_object($value) || is_array($value))
				$data[$key] = $this->arrayUnset($value);
		}
		return $data;
	}

	/**
	 * curl
	 *
	 * @param   string  $method
	 * @param   string  $url
	 * @param   array   $data
	 *
	 * @return  array
	 */
	protected function curl($method, $url, $data = array())
	{
		$dateTime = $this->dateTime();
		$salt = uniqid();
		$signature = $this->signature($dateTime, $salt);

		// check curl_init function
		if (function_exists('curl_init'))
		{
			$ch = curl_init();

			$method = strtoupper($method);
			if ($method === 'POST')
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->arrayUnset($data)));
			else
				$url .= '?' . http_build_query($this->arrayUnset($data));

			curl_setopt($ch, CURLOPT_URL, $this->apiURL . $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			// set header
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Authorization: HMAC-SHA256 apiKey=' . $this->apiKey . ', date=' . $dateTime . ', salt=' . $salt . ', signature=' . $signature,
				'Content-Type: application/json'
			));

			$response = json_decode(curl_exec($ch), true);
			curl_close($ch);
		}

		return isset($response)?$response:array();
	}
}
