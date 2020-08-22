<?php
namespace CoolSMS\V4\Messages;

/**
 * Class ResponseListMessageListKakaoOptions
 *
 * @package CoolSMS\V4\Messages
 */
class ResponseListMessageListKakaoOptions
{
	/**
	 * @var string|null $senderKey
	 */
	public ?string $senderKey;

	/**
	 * @var string|null $templateCode
	 */
	public ?string $templateCode;

	/**
	 * @var string|null $templateId
	 */
	public ?string $templateId;

	/**
	 * @var string|null $buttonName
	 */
	public ?string $buttonName;

	/**
	 * @var string|null $buttonUrl
	 */
	public ?string $buttonUrl;

	/**
	 * @var bool $disableSms
	 */
	public bool $disableSms;

	/**
	 * @var array $buttons
	 */
	public array $buttons;

	/**
	 * @var string|null $pfId
	 */
	public ?string $pfId;

	/**
	 * @var string|null $imageId
	 */
	public ?string $imageId;

	public function __construct(array $data)
	{
		foreach ($data as $key => $value)
		{
			if ($key === 'buttons')
			{
				$this->buttons = [];
				foreach ($value as $row)
				{
					$this->buttons[] = new ResponseListMessageListKakaoOptionsButtons($row);
				}
			}
			else
				$this->$key = $value;
		}
	}
}
