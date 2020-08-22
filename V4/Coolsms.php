<?php
namespace CoolSMS\V4;

use CoolSMS\V4\Cash\Cash;
use CoolSMS\V4\Messages\Messages;
use CoolSMS\V4\Quota\Quota;
use CoolSMS\V4\SenderId\SenderId;

/**
 * Class Coolsms
 *
 * @package CoolSMS\V4
 *
 * @since 2020.08.15
 * @url https://docs.coolsms.co.kr
 *
 * @property Cash $cash
 * @property Messages $messages
 * @property Quota $quota
 * @property SenderId $senderId
 */
class Coolsms
{
	/**
	 * @var string $apiKey
	 */
	public static string $apiKey = '{YOUR API KEY}';

	/**
	 * @var string $apiSecret
	 */
	public static string $apiSecret = '{YOUR API SECRET}';

	/**
	 * @var string $timeZone
	 */
	public static string $timeZone = 'Asia/Seoul';

	public function __get(string $key)
	{
		$className = ucfirst($key);
		$nameSpace = '\CoolSMS\V4\\' . $className . '\\' . $className;
		if (class_exists($nameSpace))
		{
			$this->$key = new $nameSpace();
			return $this->$key;
		}
		else
			return null;
	}
}
