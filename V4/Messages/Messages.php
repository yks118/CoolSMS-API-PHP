<?php
namespace CoolSMS\V4\Messages;

use CoolSMS\V4\Curl;
use CoolSMS\V4\SenderId\SenderId;
use Exception;

/**
 * Class Messages
 *
 * @package CoolSMS\V4\Messages
 */
class Messages extends Curl
{
	/**
	 * @var RequestAgent $agent
	 */
	protected RequestAgent $agent;

	/**
	 * @var array $types
	 */
	protected array $types = [
		'SMS', 'LMS', 'MMS', 'ATA', 'CTA', 'CTI'
	];

	public function __construct()
	{
		parent::__construct();

		$this->agent = new RequestAgent();
	}

	/**
	 * send
	 *
	 * 하나의 메시지를 발송합니다.
	 *
	 * @see https://docs.coolsms.co.kr/api-reference/messages/sendsimplemessage
	 *
	 * @param RequestMessage $requestMessage
	 *
	 * @return  ResponseMessageSend
	 * @throws  Exception
	 */
	public function send(RequestMessage $requestMessage): ResponseMessageSend
	{
		if (empty($requestMessage->from))
		{
			$senderId = new SenderId();
			$numbers = $senderId->numbers();
			if (isset($numbers->senderIds[0]))
			{
				$senderIds = $senderId->numbers()->senderIds[0];
				$requestMessage->from = $senderIds->phoneNumber;
			}
		}

		// 수신번호가 없는 경우
		if (!isset($requestMessage->to) || empty($requestMessage->to))
			throw new Exception('Required : to');

		// 수신번호 숫자만 남기기
		if ($requestMessage->to)
			$requestMessage->to = preg_replace('/[^0-9]/', '', $requestMessage->to);

		// 발신번호가 없는 경우
		if (!isset($requestMessage->from) || empty($requestMessage->from))
			throw new Exception('Required : from');

		// 발신번호 숫자만 남기기
		if ($requestMessage->from)
			$requestMessage->from = preg_replace('/[^0-9]/', '', $requestMessage->from);

		// 문자 내용이 없는 경우
		if (!isset($requestMessage->text) || empty($requestMessage->text))
			throw new Exception('Required : text');

		// type 대문자로 변경
		if (isset($requestMessage->type))
		{
			$requestMessage->type = strtoupper($requestMessage->type);
			if (!in_array($requestMessage->type, $this->types))
				throw new Exception('type : ' . implode(', ', $this->types));
		}

		// 필수 항목 - 제목
		if (empty($requestMessage->subject))
			$requestMessage->subject = mb_substr($requestMessage->text, 0, 20);

		$response = $this->curl('POST', '/messages/v4/send', [
			'message'   => $requestMessage,
			'agent'     => $this->agent
		]);
		if (isset($response['errorCode'], $response['errorMessage']))
			throw new Exception($response['errorCode'] . ' : ' . $response['errorMessage']);

		return new ResponseMessageSend($response);
	}

	/**
	 * lists
	 *
	 * 메시지의 목록을 조회합니다.
	 *
	 * @see https://docs.coolsms.co.kr/api-reference/messages/getmessagelist
	 *
	 * @param RequestList|null $requestList
	 *
	 * @return  ResponseList
	 */
	public function lists(RequestList $requestList = null): ResponseList
	{
		$response = $this->curl('GET', '/messages/v4/list', (array) $requestList);
		return new ResponseList($response);
	}
}
