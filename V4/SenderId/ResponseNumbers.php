<?php
namespace CoolSMS\V4\SenderId;

use CoolSMS\V4\Coolsms;
use DateTime;
use DateTimeZone;
use Exception;

/**
 * Class ResponseNumbers
 *
 * @package CoolSMS\V4\SenderId
 */
class ResponseNumbers
{
	/**
	 * @var int $limit
	 */
	public int $limit;

	/**
	 * @var string $accountId
	 */
	public string $accountId;

	/**
	 * @var array $senderIds
	 */
	public array $senderIds;

	/**
	 * @var array $limitationDocuments
	 */
	public array $limitationDocuments;

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
			if ($key === 'senderIds')
			{
				$this->senderIds = [];
				foreach ($value as $row)
				{
					$this->senderIds[] = new ResponseNumbersSenderIds($row);
				}
			}
			elseif (in_array($key, ['dateCreated', 'dateUpdated']))
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
