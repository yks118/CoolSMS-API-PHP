<?php
namespace CoolSMS\PHP74;

use CoolSMS\PHP74\Request\SMS\GetSent as RequestGetSent;
use CoolSMS\PHP74\Request\SMS\GetStatus as RequestGetStatus;
use CoolSMS\PHP74\Request\SMS\PostCancel as RequestPostCancel;
use CoolSMS\PHP74\Request\SMS\PostSend as RequestPostSend;
use CoolSMS\PHP74\Response\SenderID\GetDefault as ResponseGetDefault;
use CoolSMS\PHP74\Response\SenderID\GetList as ResponseGetList;
use CoolSMS\PHP74\Response\SMS\Balance as ResponseBalance;
use CoolSMS\PHP74\Response\SMS\GetSent as ResponseGetSent;
use CoolSMS\PHP74\Response\SMS\GetStatus as ResponseGetStatus;
use CoolSMS\PHP74\Response\SMS\PostSend as ResponsePostSend;

/**
 * Class CoolSMS
 *
 * PHP 7.4+
 *
 * @package Coolsms\PHP74
 *
 * @property Byte $byte
 * @property Charge $charge
 */
class CoolSMS
{
	/**
	 * @var string $apiKey CoolSMS 에서 발급받은 API KEY
	 */
	private string $apiKey = '';

	/**
	 * @var string $apiSecret CoolSMS 에서 발급받은 API Secret KEY
	 */
	private string $apiSecret = '';

	/**
	 * @var string $apiURL
	 */
	private string $apiURL = 'https://api.coolsms.co.kr/';

	/**
	 * @var string $version SMS API Version
	 */
	private string $version = '1.6';

	/**
	 * @var string $senderIDVersion 발신번호 등록 API
	 */
	private string $senderIDVersion = '1.2';

	/**
	 * @var string $defaultPhoneNumber 대표 발신자 번호
	 */
	private ?string $defaultPhoneNumber = null;

	/**
	 * @var string $srk
	 */
	private string $srk = 'K0010535426';

	/**
	 * @var Byte $byte 바이트 수
	 */
	private ?Byte $byte = null;

	/**
	 * @var Charge $charge 요금
	 */
	private ?Charge $charge = null;

	public function __construct(?string $key = null, ?string $secret = null)
	{
		if (isset($key, $secret))
		{
			$this->apiKey = $key;
			$this->apiSecret = $secret;
		}
	}

	public function __get(string $name)
	{
		switch ($name)
		{
			case 'byte' :
				if (is_null($this->byte))
					$this->byte = new Byte();
				return $this->byte;
				break;
			case 'charge' :
				if (is_null($this->charge))
					$this->charge = new Charge();
				return $this->charge;
				break;
		}

		return null;
	}

	/**
	 * signature
	 *
	 * @param   int     $timestamp
	 * @param   string  $salt
	 *
	 * @return  string
	 */
	private function signature(int $timestamp, string $salt): string
	{
		return hash_hmac('md5', $timestamp . $salt, $this->apiSecret);
	}

	/**
	 * curl
	 *
	 * @param   string  $method GET / POST
	 * @param   string  $url    API URL
	 * @param   array   $data   API Request Data
	 *
	 * @return  array
	 */
	private function curl(string $method, string $url, array $data = []): array
	{
		// set default data
		$data['api_key'] = $this->apiKey;
		$data['timestamp'] = time();
		$data['salt'] = uniqid();
		$data['signature'] = $this->signature($data['timestamp'], $data['salt']);

		// check curl_init function
		if (function_exists('curl_init'))
		{
			$ch = curl_init();

			$method = strtoupper($method);
			if ($method === 'POST')
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			else
				$url .= '?' . http_build_query($data);

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$response = json_decode(curl_exec($ch), true);
			curl_close($ch);
		}

		return $response??[];
	}

	/**
	 * senderIDDefault
	 *
	 * 기본으로 사용될 발신번호를 리턴합니다.
	 *
	 * @see https://developer.coolsms.co.kr/SenderID_API#GETget_default
	 *
	 * @return  ResponseGetDefault
	 */
	public function senderIDDefault(): ResponseGetDefault
	{
		$response = $this->curl('GET', $this->apiURL . 'senderid/' . $this->senderIDVersion . '/get_default');
		$getDefault = new ResponseGetDefault($response);
		if (is_null($this->defaultPhoneNumber))
			$this->defaultPhoneNumber = $getDefault->phone_number;
		return $getDefault;
	}

	/**
	 * senderIDList
	 *
	 * 등록된 발신번호 목록을 조회합니다.
	 *
	 * @see https://developer.coolsms.co.kr/SenderID_API#GETlist
	 *
	 * @return  array
	 */
	public function senderIDList(): array
	{
		$response = $this->curl('GET', $this->apiURL . 'senderid/' . $this->senderIDVersion . '/list');

		$data = [];
		if (is_array($response))
		{
			foreach ($response as $row)
			{
				$list = new ResponseGetList($row);
				if (is_null($this->defaultPhoneNumber) && $list->flag_default === 'Y')
					$this->defaultPhoneNumber = $list->phone_number;
				$data[] = $list;
			}
		}
		return $data;
	}

	/**
	 * balance
	 *
	 * 잔액을 확인합니다.
	 *
	 * @see https://developer.coolsms.co.kr/SMS_API#GETbalance
	 *
	 * @return  ResponseBalance
	 */
	public function balance(): ResponseBalance
	{
		$response = $this->curl('GET', $this->apiURL . 'sms/' . $this->version . '/balance');
		return new ResponseBalance($response);
	}

	/**
	 * status
	 *
	 * 전송채널의 상태를 조회합니다.
	 *
	 * @see https://developer.coolsms.co.kr/SMS_API#GETstatus
	 *
	 * @param   RequestGetStatus    $request
	 *
	 * @return  ResponseGetStatus
	 */
	public function status(?RequestGetStatus $request = null): ResponseGetStatus
	{
		$data = isset($request)?$request->getData():[];
		$response = $this->curl('GET', $this->apiURL . 'sms/' . $this->version . '/status', $data);
		return new ResponseGetStatus($response);
	}

	/**
	 * cancel
	 *
	 * 예약된 문자메시지를 취소합니다. 예약되지 않았거나, 예약되었으나 이미 발송된 문자메시지는 취소 할 수 없습니다.
	 *
	 * @see https://developer.coolsms.co.kr/SMS_API#POSTcancel
	 *
	 * @param   RequestPostCancel   $request
	 *
	 * @return  void
	 */
	public function cancel(RequestPostCancel $request): void
	{
		$this->curl('POST', $this->apiURL . 'sms/' . $this->version . '/cancel', $request->getData());
	}

	/**
	 * sent
	 *
	 * 발송된 문자메시지의 목록을 가져옵니다.
	 *
	 * @see https://developer.coolsms.co.kr/SMS_API#GETsent
	 *
	 * @param   RequestGetSent  $request
	 *
	 * @return  ResponseGetSent
	 */
	public function sent(?RequestGetSent $request = null): ResponseGetSent
	{
		$data = isset($request)?$request->getData():[];
		$response = $this->curl('GET', $this->apiURL . 'sms/' . $this->version . '/sent', $data);
		return new ResponseGetSent($response);
	}

	/**
	 * send
	 *
	 * 문자메시지를 전송 요청합니다. 전송 요청에 대한 Response는 휴대전화까지 전송된 결과가 아닙니다.
	 *
	 * @see https://developer.coolsms.co.kr/SMS_API#POSTsend
	 *
	 * @param   RequestPostSend     $request
	 *
	 * @return  ResponsePostSend
	 */
	public function send(RequestPostSend $request): ResponsePostSend
	{
		// 발신 번호가 없다면..
		if (!isset($request->from))
		{
			// class에 저장된 대표 번호가 없다면..
			if (!isset($this->defaultPhoneNumber))
			{
				// 대표 번호를 가져옴..
				$this->senderIDDefault();
			}
			$request->from = $this->defaultPhoneNumber;
			// 발신 번호가 존재하지 않는다면..
			if (!isset($request->from))
				die('문자 발송 실패 : 발신 번호가 존재하지 않습니다.');
		}
		$request->from = preg_replace('/[^0-9]/', '', $request->from);

		// 수신 번호가 없다면..
		if (!isset($request->to))
			die('문자 발송 실패 : 수신 번호가 존재하지 않습니다.');
		$request->to = preg_replace('/[^0-9,]/', '', $request->to);

		// 문자 내용이 존재하지 않는다면..
		if (!isset($request->text) || empty($request->text))
			die('문자 발송 실패 : 문자 내용이 존재하지 않습니다.');

		// 문자 타입이 존재하지 않으면 SMS / LMS 자동 선택
		if (!isset($request->type))
		{
			$byte = $this->getByte($request->text);
			if ($byte <= $this->byte->sms)
				$request->type = 'SMS';
			elseif ($byte <= $this->byte->lms)
				$request->type = 'LMS';
		}
		$request->type = strtoupper($request->type);

		$request->srk = $this->srk;

		$response = $this->curl('POST', $this->apiURL . 'sms/' . $this->version . '/send', $request->getData());
		return new ResponsePostSend($response);
	}

	/**
	 * getByte
	 *
	 * 텍스트의 Byte를 구함
	 *
	 * @param   string      $text
	 *
	 * @return  int         $byte
	 */
	private function getByte($text)
	{
		$byte = 0;
		$length = mb_strlen($text, 'UTF-8');

		for ($i = 0; $i < $length; $i++)
		{
			$char = mb_substr($text, $i, 1, 'UTF-8');
			$ord = ord($char);
			$len = mb_strlen(bin2hex($char), 'UTF-8');
			if ($ord == 13)
			{
				// break point
			}
			elseif ($ord == 10)
			{
				// new line
				$byte++;
			}
			elseif ($len == 2)
			{
				// 1byte - ex. [0-9a-zA-Z]
				$byte++;
			}
			elseif ($len == 6)
			{
				// 3byte - ex. [가-히]
				$byte += 2;
			}
		}

		return $byte;
	}
}
