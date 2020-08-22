<?php
namespace CoolSMS\V4\Messages;

/**
 * Class ResponseListMessageListCustomFields
 *
 * @package CoolSMS\V4\Messages
 */
class ResponseListMessageListCustomFields
{
	/**
	 * @var string $coolsmsGroupId
	 */
	public string $coolsmsGroupId;

	/**
	 * @var string $coolsmsMessageId
	 */
	public string $coolsmsMessageId;

	public function __construct(array $data)
	{
		foreach ($data as $key => $value)
		{
			$this->$key = $value;
		}
	}
}
