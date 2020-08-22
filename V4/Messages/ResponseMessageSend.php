<?php
namespace CoolSMS\V4\Messages;

/**
 * Class ResponseMessageSend
 *
 * @package CoolSMS\V4\Messages
 */
class ResponseMessageSend
{
	/**
	 * @var string $groupId 그룹 아이디
	 */
	public string $groupId;

	/**
	 * @var string $messageId 메시지 아이디
	 */
	public string $messageId;

	/**
	 * @var string $accountId 계정 고유 번호
	 */
	public string $accountId;

	/**
	 * @var string $statusMessage 상태 메시지
	 */
	public string $statusMessage;

	/**
	 * @var string $statusCode 상태 코드
	 */
	public string $statusCode;

	/**
	 * @var string $to 수신번호
	 */
	public string $to;

	/**
	 * @var string $from 발신번호
	 *                   사전 등록된 전화번호만 사용 가능
	 */
	public string $from;

	/**
	 * @var string $type 메시지 타입
	 */
	public string $type;

	/**
	 * @var string $country 국가번호 (현재 미지원)
	 */
	public string $country;

	public function __construct(array $data)
	{
		foreach ($data as $key => $value)
		{
			$this->$key = $value;
		}
	}
}
