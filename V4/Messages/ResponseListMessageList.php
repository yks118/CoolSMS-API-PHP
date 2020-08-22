<?php
namespace CoolSMS\V4\Messages;

use CoolSMS\V4\Coolsms;
use DateTime;
use DateTimeZone;
use Exception;

/**
 * Class ResponseListMessageList
 *
 * @package CoolSMS\V4\Messages
 */
class ResponseListMessageList
{
	/**
	 * @var string $_id
	 */
	public string $_id;

	/**
	 * @var string $groupId
	 */
	public string $groupId;

	/**
	 * @var string $type
	 */
	public string $type;

	/**
	 * @var ResponseListMessageListCustomFields $customFields
	 */
	public ResponseListMessageListCustomFields $customFields;

	/**
	 * @var string $country
	 */
	public string $country;

	/**
	 * @var string|null $subject
	 */
	public ?string $subject;

	/**
	 * @var string|null $imageId
	 */
	public ?string $imageId;

	/**
	 * @var DateTime $dateCreated
	 */
	public DateTime $dateCreated;

	/**
	 * @var DateTime $dateUpdated
	 */
	public DateTime $dateUpdated;

	/**
	 * @var DateTime $dateReceived
	 */
	public DateTime $dateReceived;

	/**
	 * @var string $statusCode
	 */
	public string $statusCode;

	/**
	 * @var string|null $networkCode
	 */
	public ?string $networkCode;

	/**
	 * @var array $log
	 */
	public array $log;

	/**
	 * @var bool $replacement
	 */
	public bool $replacement;

	/**
	 * @var bool $autoTypeDetect
	 */
	public bool $autoTypeDetect;

	/**
	 * @var string $from
	 */
	public string $from;

	/**
	 * @var string $text
	 */
	public string $text;

	/**
	 * @var string $to
	 */
	public string $to;

	/**
	 * @var string $messageId
	 */
	public string $messageId;

	/**
	 * @var string $accountId
	 */
	public string $accountId;

	/**
	 * @var ResponseListMessageListKakaoOptions $kakaoOptions
	 */
	public ResponseListMessageListKakaoOptions $kakaoOptions;

	/**
	 * @var string $routedQueue
	 */
	public string $routedQueue;

	/**
	 * @var DateTime $dateProcessed
	 */
	public DateTime $dateProcessed;

	/**
	 * @var DateTime $dateReported
	 */
	public DateTime $dateReported;

	/**
	 * @var string $reason
	 */
	public string $reason;

	/**
	 * @var string $networkName
	 */
	public string $networkName;

	public function __construct(array $data)
	{
		// var_dump($data['from']);
		foreach ($data as $key => $value)
		{
			if ($key === 'customFields')
				$this->customFields = new ResponseListMessageListCustomFields($value);
			elseif (in_array($key, ['dateCreated', 'dateUpdated', 'dateReceived', 'dateProcessed', 'dateReported']))
			{
				try
				{
					$dateTime = new DateTime($value);
					$this->$key = $dateTime->setTimezone(new DateTimeZone(Coolsms::$timeZone));
				}
				catch (Exception $e)
				{}
			}
			elseif ($key === 'log')
			{
				$this->log = [];
				foreach ($value as $row)
				{
					$this->log[] = new ResponseListMessageListLog($row);
				}
			}
			elseif ($key === 'kakaoOptions')
				$this->$key = new ResponseListMessageListKakaoOptions($value);
			else
				$this->$key = $value;
		}
	}
}
