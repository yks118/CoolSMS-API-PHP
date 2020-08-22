<?php
namespace CoolSMS\V4\Quota;

use CoolSMS\V4\Coolsms;
use DateTime;
use DateTimeZone;
use Exception;

/**
 * Class ResponseMe
 *
 * @package CoolSMS\V4\Quota
 */
class ResponseMe
{
	/**
	 * @var int $quota
	 */
	public int $quota;

	/**
	 * @var string $accountId
	 */
	public string $accountId;

	/**
	 * @var DateTime $dateCreated
	 */
	public DateTime $dateCreated;

	/**
	 * @var DateTime $dateUpdated
	 */
	public DateTime $dateUpdated;

	public function __construct(array $data)
	{
		foreach ($data as $key => $value)
		{
			if (in_array($key, ['dateCreated', 'dateUpdated']))
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
