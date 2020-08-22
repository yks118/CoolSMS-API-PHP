<?php
namespace CoolSMS\V4\SenderId;

use CoolSMS\V4\Coolsms;
use DateTime;
use DateTimeZone;
use Exception;

/**
 * Class ResponseNumbersSenderIdsLog
 *
 * @package CoolSMS\V4\SenderId
 */
class ResponseNumbersSenderIdsLog
{
	/**
	 * @var DateTime $createAt
	 */
	public DateTime $createAt;

	/**
	 * @var string $message
	 */
	public string $message;

	public function __construct(array $data)
	{
		foreach ($data as $key => $value)
		{
			if (in_array($key, ['createAt']))
			{
				try
				{
					$dateTime = new DateTime($value);
					$this->$key = $dateTime->setTimezone(new DateTimeZone(Coolsms::$timeZone));
				}
				catch (Exception $e)
				{}
			}
			else
				$this->$key = $value;
		}
	}
}
