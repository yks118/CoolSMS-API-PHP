<?php
namespace CoolSMS\V4\Cash;

use CoolSMS\V4\Curl;

/**
 * Class Cash
 *
 * @package CoolSMS\V4\Cash
 */
class Cash extends Curl
{
	/**
	 * balance
	 *
	 * 잔액조회
	 *
	 * @see https://docs.coolsms.co.kr/api-reference/cash/getbalance
	 *
	 * @retrun ResponseBalance
	 */
	public function balance(): ResponseBalance
	{
		$response = $this->curl('GET', '/cash/v1/balance');
		return new ResponseBalance($response);
	}
}
