<?php
namespace CoolSMS\V4\Messages;

/**
 * Class ResponseList
 *
 * @package CoolSMS\V4\Messages
 */
class ResponseList
{
	/**
	 * @var string|null $startKey
	 */
	public ?string $startKey;

	/**
	 * @var int $limit
	 */
	public int $limit;

	/**
	 * @var array $messageList
	 */
	public array $messageList;

	/**
	 * @var string $nextKey
	 */
	public string $nextKey;

	public function __construct(array $data)
	{
		foreach ($data as $key => $value)
		{
			if ($key === 'messageList')
			{
				$this->messageList = [];
				foreach ($value as $row)
				{
					$this->messageList[] = new ResponseListMessageList($row);
				}
			}
			else
				$this->$key = $value;
		}
	}
}
