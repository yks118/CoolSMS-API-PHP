<?php
namespace CoolSMS\V4\Messages;

/**
 * Class RequestMessage
 *
 * @package CoolSMS\V4\Messages
 */
class RequestMessage
{
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
	 * @var string $text 메시지 내용
	 *                   한글 1,000자, 영문 2,000자 제한
	 */
	public string $text;

	/**
	 * @var string $type 메시지 타입
	 */
	public string $type;

	/**
	 * @var string $country 국가번호 (현재 미지원)
	 */
	public string $country;

	/**
	 * @var string $subject 메시지 제목
	 *                      한글 20자, 영문 40자 제한
	 */
	public string $subject;

	/**
	 * @var string $imageId Storage API에 등록된 이미지 아이디
	 *                      https://docs.coolsms.co.kr/api-reference/storage
	 */
	public string $imageId;

	/**
	 * @var RequestMessageKakaoOptions $kakaoOptions 친구톡, 알림톡을 보내기 위한 옵션
	 */
	public RequestMessageKakaoOptions $kakaoOptions;

	/**
	 * @var array $customFields 확장 필드로 사용. 키는 30자, 값은 100자 제한
	 */
	public array $customFields;

	/**
	 * @var bool $autoTypeDetect 타입 설정이 없을 경우 자동으로 설정함. 기본 값은 true
	 */
	public bool $autoTypeDetect = true;

	public function __construct(array $data = [])
	{
		foreach ($data as $key => $value)
		{
			switch ($key)
			{
				default :
					$this->$key = $value;
					break;
			}
		}
	}
}
