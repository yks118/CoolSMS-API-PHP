<?php
namespace CoolSMS\V4\Messages;

/**
 * Class RequestMessageKakaoOptions
 *
 * @package CoolSMS\V4\Messages
 */
class RequestMessageKakaoOptions
{
	/**
	 * @var string $pfId COOLSMS와 연동된 플러스 친구 고유 아이디
	 */
	public string $pfId;

	/**
	 * @var string $templateId 알림톡 템플릿 아이디
	 */
	public string $templateId;

	/**
	 * @var bool $disableSms 대체 발송 여부
	 *                       true : SMS 미발송
	 *                       false : SMS 발송
	 */
	public bool $disableSms = false;

	/**
	 * @var string $imageId Storage API에 등록된 이미지 아이디
	 *                      https://docs.coolsms.co.kr/api-reference/storage
	 */
	public string $imageId;

	/**
	 * @var array $buttons 알림톡 템플릿 버튼 목록
	 */
	public array $buttons;

	public function __construct(array $data = [])
	{
		foreach ($data as $key => $value)
		{
			switch ($key)
			{
				case 'buttons' :
					$this->buttons = [];
					foreach ($value as $row)
					{
						$this->buttons[] = new RequestMessageKakaoOptionsButtons($row);
					}
					break;
				default :
					$this->$key = $value;
					break;
			}
		}
	}
}
