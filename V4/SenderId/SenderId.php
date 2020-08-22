<?php
namespace CoolSMS\V4\SenderId;

use CoolSMS\V4\Curl;

/**
 * Class SenderId
 *
 * @package CoolSMS\V4\SenderId
 */
class SenderId extends Curl
{
	/**
	 * numbers
	 *
	 * 발신번호 정보를 조회합니다.
	 *
	 * @see https://docs.coolsms.co.kr/api-reference/senderid/getsenderidinfo
	 *
	 * @return  ResponseNumbers
	 */
	public function numbers(): ResponseNumbers
	{
		$response = $this->curl('GET', '/senderid/v1/numbers');
		return new ResponseNumbers($response);
	}
}
