<?php
namespace CoolSMS\PHP74\Response\SMS;

use CoolSMS\PHP74\Response\Response;

/**
 * Class PostSend
 *
 * @package CoolSMS\PHP74\Response\SMS
 *
 * @property string $group_id
 * @property int $success_count
 * @property int $error_count
 * @property string $result_code
 * @property string $result_message
 */
class PostSend extends Response
{
	/**
	 * @var array $castings
	 */
	protected array $castings = [
		'group_id'          => '?string',
		'success_count'     => '?int',
		'error_count'       => '?int',
		'result_code'       => '?string',
		'result_message'    => '?string'
	];

	/**
	 * @var string $group_id
	 */
	protected ?string $group_id = null;

	/**
	 * @var int $success_count
	 */
	protected ?int $success_count = null;

	/**
	 * @var int $error_count
	 */
	protected ?int $error_count = null;

	/**
	 * @var string $result_code
	 */
	protected ?string $result_code = null;

	/**
	 * @var string $result_message
	 */
	protected ?string $result_message = null;
}
