<?php
namespace CoolSMS\V4\Quota;

use CoolSMS\V4\Curl;

/**
 * Class Quota
 *
 * @package CoolSMS\V4\Quota
 */
class Quota extends Curl
{
	/**
	 * me
	 *
	 * 계정의 메시지 발송 한도 조회
	 *
	 * @see https://docs.coolsms.co.kr/api-reference/quota/getquota
	 *
	 * @retrun ResponseMe
	 */
	public function me(): ResponseMe
	{
		$response = $this->curl('GET', '/quota/v1/me');
		return new ResponseMe($response);
	}
}
