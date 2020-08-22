<?php
namespace CoolSMS\V4\SenderId;

use CoolSMS\V4\Coolsms;
use DateTime;
use DateTimeZone;
use Exception;

/**
 * Class ResponseNumbersSenderIds
 *
 * @package CoolSMS\V4\SenderId
 */
class ResponseNumbersSenderIds
{
	/**
	 * @var ResponseNumbersSenderIdsUnlockDuplicate $unlockDuplicate
	 */
	public ResponseNumbersSenderIdsUnlockDuplicate $unlockDuplicate;

	/**
	 * @var string $status
	 */
	public string $status;

	/**
	 * @var DateTime $expireAt
	 */
	public DateTime $expireAt;

	/**
	 * @var string $method
	 */
	public string $method;

	/**
	 * @var array $log
	 */
	public array $log;

	/**
	 * @var DateTime $dateCreated
	 */
	public DateTime $dateCreated;

	/**
	 * @var DateTime $dateUpdated
	 */
	public DateTime $dateUpdated;

	/**
	 * @var array $approvalDocuments
	 */
	public array $approvalDocuments;

	/**
	 * @var string $handleKey
	 */
	public string $handleKey;

	/**
	 * @var string $phoneNumber
	 */
	public string $phoneNumber;

	public function __construct(array $data)
	{
		foreach ($data as $key => $value)
		{
			if ($key === 'unlockDuplicate')
				$this->unlockDuplicate = new ResponseNumbersSenderIdsUnlockDuplicate($value);
			elseif ($key === 'log')
			{
				$this->log = [];
				foreach ($value as $row)
				{
					$this->log[] = new ResponseNumbersSenderIdsLog($row);
				}
			}
			elseif (in_array($key, ['expireAt', 'dateCreated', 'dateUpdated']))
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
