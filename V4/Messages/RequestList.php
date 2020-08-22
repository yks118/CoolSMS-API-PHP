<?php
namespace CoolSMS\V4\Messages;

/**
 * Class RequestList
 *
 * @package CoolSMS\V4\Messages
 *
 * @see https://docs.coolsms.co.kr/api-reference/messages/getmessagelist#query-params
 */
class RequestList
{
	/**
	 * @var string $criteria
	 */
	public string $criteria;

	/**
	 * @var string $cond
	 */
	public string $cond;

	/**
	 * @var string $value
	 */
	public string $value;

	/**
	 * @var string $startKey
	 */
	public string $startKey;

	/**
	 * @var int $limit
	 */
	public int $limit = 20;

	public function __construct(array $data = [])
	{
		foreach ($data as $key => $value)
		{
			$this->$key = $value;
		}
	}
}
