<?php
namespace CoolSMS\V4\SenderId;

use CoolSMS\V4\Coolsms;
use DateTime;
use DateTimeZone;
use Exception;

/**
 * Class ResponseNumbersSenderIdsUnlockDuplicate
 *
 * @package CoolSMS\V4\SenderId
 */
class ResponseNumbersSenderIdsUnlockDuplicate
{
	/**
	 * @var string|null $duplicateId
	 */
	public ?string $duplicateId;

	/**
	 * @var string|null $reason
	 */
	public ?string $reason;

	/**
	 * @var string|null $reasonForRequested
	 */
	public ?string $reasonForRequested;

	/**
	 * @var string|null $name
	 */
	public ?string $name;

	/**
	 * @var string|null $status
	 */
	public ?string $status;

	/**
	 * @var DateTime|null $dateCreated
	 */
	public ?DateTime $dateCreated;

	/**
	 * @var DateTime|null $dateUpdated
	 */
	public ?DateTime $dateUpdated;

	public function __construct(array $data)
	{
		foreach ($data as $key => $value)
		{
			if (!is_null($value) && in_array($key, ['dateCreated', 'dateUpdated']))
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
