<?php
namespace CoolSMS\PHP53;

/**
 * Class Coolsms
 *
 * @package CoolSMS\V4
 *
 * @since 2020.08.15
 * @url https://docs.coolsms.co.kr
 */
class Coolsms extends Curl
{
	/**
	 * @var string $apiKey
	 */
	public static $apiKey = '{YOUR API KEY}';

	/**
	 * @var string $apiSecret
	 */
	public static $apiSecret = '{YOUR API SECRET}';

	/**
	 * @var string $timeZone
	 */
	public static $timeZone = 'Asia/Seoul';

	/**
	 * cashBalance
	 *
	 * 잔액조회
	 *
	 * @see https://docs.coolsms.co.kr/api-reference/cash/getbalance
	 *
	 * @retrun array
	 */
	public function cashBalance()
	{
		return $this->curl('GET', '/cash/v1/balance');
	}

	/**
	 * messagesSend
	 *
	 * 하나의 메시지를 발송합니다.
	 *
	 * @see https://docs.coolsms.co.kr/api-reference/messages/sendsimplemessage
	 *
	 * @param array $request
	 *
	 * @return array
	 */
	public function messagesSend($request)
	{
		if (isset($request['to']))
			$request['to'] = preg_replace('/[^0-9]/', '', $request['to']);

		if (isset($request['from']))
			$request['from'] = preg_replace('/[^0-9]/', '', $request['from']);

		if (isset($request['type']))
			$request['type'] = strtoupper($request['type']);

		return $this->curl('POST', '/messages/v4/send', array(
			'message'   => $request,
			'agent'     => array(
				'appId'         => 'K0010535426',
				'osPlatform'    => PHP_OS,
				'sdkVersion'    => '1.0'
			)
		));
	}

	/**
	 * messageslist
	 *
	 * 메시지의 목록을 조회합니다.
	 *
	 * @see https://docs.coolsms.co.kr/api-reference/messages/getmessagelist
	 *
	 * @param array $request
	 *
	 * @return array
	 */
	public function messageslist($request = array())
	{
		return $this->curl('GET', '/messages/v4/list', $request);
	}

	/**
	 * quotaMe
	 *
	 * 계정의 메시지 발송 한도 조회
	 *
	 * @see https://docs.coolsms.co.kr/api-reference/quota/getquota
	 *
	 * @return array
	 */
	public function quotaMe()
	{
		return $this->curl('GET', '/quota/v1/me');
	}

	/**
	 * senderIdNumbers
	 *
	 * 발신번호 정보를 조회합니다.
	 *
	 * @see https://docs.coolsms.co.kr/api-reference/senderid/getsenderidinfo
	 *
	 * @return array
	 */
	public function senderIdNumbers()
	{
		return $this->curl('GET', '/senderid/v1/numbers');
	}
}
