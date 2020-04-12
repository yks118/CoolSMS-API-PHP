<?php
namespace CoolSMS\PHP74\Request\SMS;

use CoolSMS\PHP74\Request\Request;
use DateTime;

/**
 * Class PostSend
 *
 * @package CoolSMS\PHP74\Request\SMS
 *
 * @property string $to
 * @property string $from
 * @property string $text
 * @property string $type
 * @property string $image
 * @property string $image_encoding
 * @property string $refname
 * @property string $country
 * @property DateTime $datetime
 * @property string $subject
 * @property string $charset
 * @property string $srk
 * @property string $mode
 * @property string $extension
 * @property int $delay
 * @property bool $force_sms
 * @property string $os_platform
 * @property string $dev_lang
 * @property string $sdk_version
 * @property string $app_version
 * @property string $sender_key
 * @property string $template_code
 */
class PostSend extends Request
{
	/**
	 * @var array $castings
	 */
	protected array $castings = [
		'to'                => '?string',
		'from'              => '?string',
		'text'              => '?string',
		'type'              => '?string',
		'image'             => '?string',
		'image_encoding'    => '?string',
		'refname'           => '?string',
		'country'           => '?int',
		'datetime'          => '?datetime',
		'subject'           => '?string',
		'charset'           => '?string',
		'srk'               => '?string',
		'mode'              => '?string',
		'extension'         => '?string',
		'delay'             => '?int',
		'force_sms'         => '?bool',
		'os_platform'       => '?string',
		'dev_lang'          => '?string',
		'sdk_version'       => '?string',
		'app_version'       => '?string',
		'sender_key'        => '?string',
		'template_code'     => '?string'
	];

	/**
	 * @var string $to 수신번호 입력 콤마(,)로 구분된 수신번호 입력가능
	 */
	protected string $to;

	/**
	 * @var string $from 발신번호
	 */
	protected string $from;

	/**
	 * @var string $text 문자내용
	 */
	protected string $text;

	/**
	 * @var string $type SMS / LMS / MMS / ATA
	 */
	protected ?string $type = null;

	/**
	 * @var string $image 지원형식 : 300KB 이하의 JPEG, PNG, GIF 형식의 파일 2048x2048 픽셀이하
	 */
	protected ?string $image = null;

	/**
	 * @var string $image_encoding 이미지 인코딩 방식 binary(Default), base64
	 */
	protected ?string $image_encoding = null;

	/**
	 * @var string $refname 참조내용(이름)
	 */
	protected ?string $refname = null;

	/**
	 * @var int $country 한국: 82, 일본: 81, 중국: 86, 미국: 1, 기타 등등 (기본 한국) http://countrycode.org 참고
	 */
	protected ?int $country = 82;

	/**
	 * @var DateTime $datetime 예약시간을 YYYYMMDDHHMISS 포맷으로 입력
	 */
	protected ?DateTime $datetime = null;

	/**
	 * @var string $subject LMS, MMS 일때 제목 (40바이트)
	 */
	protected ?string $subject = null;

	/**
	 * @var string $charset 한글 인코딩 방식 지정 유니코드 UTF-8 일 경우 utf8 완성형 한글(EUC-KR) 일 경우 euckr 으로 입력
	 */
	protected string $charset = 'utf8';

	/**
	 * @var string $srk 솔루션 제공 수수료를 정산받을 솔루션 등록키
	 */
	protected ?string $srk = null;

	/**
	 * @var string $mode test로 입력할 경우 CARRIER 시뮬레이터로 시뮬레이션됨 수신번호를 반드시 01000000000 으로 테스트하세요. 예약필드 datetime는 무시됨 결과값은 60 잔액에서 실제 차감되며 다음날 새벽에 재충전됨
	 */
	protected ?string $mode = null;

	/**
	 * @var string $extension JSON 포맷의 개별 메시지를 담을 수 있음
	 */
	protected ?string $extension = null;

	/**
	 * @var int $delay 0~20 사이의 값으로 전송지연 시간을 줄 수 있음, 1은 약 1초 (기본값은 0)
	 */
	protected int $delay = 0;

	/**
	 * @var bool $force_sms 누리고푸시를 사용하더라도 SMS로 발송되도록 강제
	 */
	protected bool $force_sms = false;

	/**
	 * @var string $os_platform 클라이언트의 OS 및 플랫폼 버전) CentOS 6.6
	 */
	protected ?string $os_platform = null;

	/**
	 * @var string $dev_lang 개발 프로그래밍 언어 예) PHP 5.3.3
	 */
	protected ?string $dev_lang = null;

	/**
	 * @var string $sdk_version SDK 버전 예) PHP SDK 1.5
	 */
	protected ?string $sdk_version = null;

	/**
	 * @var string $app_version 어플리케이션 버전 예) Purplebook 4.1
	 */
	protected ?string $app_version = null;

	/**
	 * @var string $sender_key 알림톡 Sender Key 입력
	 */
	protected ?string $sender_key = null;

	/**
	 * @var string $template_code 알림톡 템플릿 코드 입력
	 */
	protected ?string $template_code = null;

	public function __construct(array $data = [])
	{
		parent::__construct($data);

		$this->dev_lang = 'PHP ' . phpversion();
	}

	public function getData(): array
	{
		$data = parent::getData();
		if (isset($data['datetime']))
		{
			/**
			 * @var DateTime $dateTime
			 */
			$dateTime = $data['datetime'];
			$data['datetime'] = $dateTime->setTimezone($this->timeZone())->format('YmdHis');
		}
		return $data;
	}
}
