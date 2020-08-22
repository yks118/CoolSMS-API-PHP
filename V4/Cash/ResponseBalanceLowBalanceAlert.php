<?php
namespace CoolSMS\V4\Cash;

/**
 * Class ResponseBalanceLowBalanceAlert
 *
 * @package CoolSMS\V4\Cash
 */
class ResponseBalanceLowBalanceAlert
{
	/**
	 * @var string $notificationBalance
	 */
	public string $notificationBalance;

	/**
	 * @var string $currentBalance
	 */
	public string $currentBalance;

	/**
	 * @var array $balances
	 */
	public array $balances;

	/**
	 * @var array $channels
	 */
	public array $channels;

	/**
	 * @var bool $enabled
	 */
	public bool $enabled;

	public function __construct(array $data)
	{
		foreach ($data as $key => $value)
		{
			$this->$key = $value;
		}
	}
}
