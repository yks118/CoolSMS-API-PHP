<?php
namespace CoolSMS\PHP74\Response\SMS;

use CoolSMS\PHP74\Response\Response;

/**
 * Class Balance
 *
 * @package CoolSMS\PHP74\Response\SMS
 *
 * @property int $cash
 * @property int $point
 * @property string $deferred_payment
 */
class Balance extends Response
{
	/**
	 * @var array $castings
	 */
	protected array $castings = [
		'cash'              => '?int',
		'point'             => '?int',
		'deferred_payment'  => '?string'
	];

	/**
	 * @var int $cash
	 */
	protected ?int $cash = null;

	/**
	 * @var int $point
	 */
	protected ?int $point = null;

	/**
	 * @var string $deferred_payment 후불회원인지 확인 (Y / N)
	 */
	protected ?string $deferred_payment = null;
}
