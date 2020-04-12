<?php
namespace CoolSMS\PHP74\Response\SenderID;

use CoolSMS\PHP74\Response\Response;

/**
 * Class GetDefault
 *
 * @package CoolSMS\PHP74\Response\SenderID
 *
 * @property string $handle_key
 * @property string $phone_number
 */
class GetDefault extends Response
{
	/**
	 * @var array $castings
	 */
	protected array $castings = [
		'handle_key'    => '?string',
		'phone_number'  => '?string'
	];

	/**
	 * @var string $handle_key
	 */
	protected ?string $handle_key = null;

	/**
	 * @var string $phone_number
	 */
	protected ?string $phone_number = null;
}
