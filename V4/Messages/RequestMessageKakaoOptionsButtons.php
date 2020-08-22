<?php
namespace CoolSMS\V4\Messages;

/**
 * Class RequestMessageKakaoOptionsButtons
 *
 * @package CoolSMS\V4\Messages
 */
class RequestMessageKakaoOptionsButtons
{
	/**
	 * @var string $buttonName 버튼 이름
	 */
	public string $buttonName;

	/**
	 * @var string $buttonType 버튼 종류
	 */
	public string $buttonType;

	/**
	 * @var string $linkMo 모바일 링크
	 */
	public string $linkMo;

	/**
	 * @var string $linkPc 웹 링크
	 */
	public string $linkPc;

	/**
	 * @var string $linkAnd 안드로이드 링크
	 */
	public string $linkAnd;

	/**
	 * @var string $linkIos IOS 링크
	 */
	public string $linkIos;

	public function __construct(array $data = [])
	{
		foreach ($data as $key => $value)
		{
			$this->$key = $value;
		}
	}
}
