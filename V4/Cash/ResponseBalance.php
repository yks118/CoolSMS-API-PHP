<?php
namespace CoolSMS\V4\Cash;

/**
 * Class ResponseBalance
 *
 * @package CoolSMS\V4\Cash
 */
class ResponseBalance
{
	/**
	 * @var ResponseBalanceLowBalanceAlert $lowBalanceAlert
	 */
	public ResponseBalanceLowBalanceAlert $lowBalanceAlert;

	/**
	 * @var int $point
	 */
	public int $point;

	/**
	 * @var int $minimumCash
	 */
	public int $minimumCash;

	/**
	 * @var int $rechargeTo
	 */
	public int $rechargeTo;

	/**
	 * @var int $rechargeTryCount
	 */
	public int $rechargeTryCount;

	/**
	 * @var int $autoRecharge
	 */
	public int $autoRecharge;

	/**
	 * @var string $accountId
	 */
	public string $accountId;

	/**
	 * @var int $balance
	 */
	public int $balance;

	public function __construct(array $data)
	{
		foreach ($data as $key => $value)
		{
			if ($key === 'lowBalanceAlert')
				$this->lowBalanceAlert = new ResponseBalanceLowBalanceAlert($value);
			else
				$this->$key = $value;
		}
	}
}
