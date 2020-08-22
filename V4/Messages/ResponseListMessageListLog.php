<?php
namespace CoolSMS\V4\Messages;

use CoolSMS\V4\Coolsms;
use DateTime;
use DateTimeZone;
use Exception;

/**
 * Class ResponseListMessageListLog
 *
 * @package CoolSMS\V4\Messages
 */
class ResponseListMessageListLog
{
	/**
	 * @var DateTime $createAt
	 */
	public DateTime $createAt;

	/**
	 * @var string $message
	 */
	public string $message;

	/**
	 * @var ResponseListMessageListLogOriginalData $originalData
	 */
	public ResponseListMessageListLogOriginalData $originalData;

	public function __construct(array $data)
	{
		foreach ($data as $key => $value)
		{
			if ($key === 'createAt')
			{
				try
				{
					$dateTime = new DateTime($value);
					$this->$key = $dateTime->setTimezone(new DateTimeZone(Coolsms::$timeZone));
				}
				catch (Exception $e)
				{}
			}
			elseif ($key === 'originalData')
				$this->$key = new ResponseListMessageListLogOriginalData($value);
			else
				$this->$key = $value;
		}
	}
}
