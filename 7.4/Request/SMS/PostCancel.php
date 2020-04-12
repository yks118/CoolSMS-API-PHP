<?php
namespace CoolSMS\PHP74\Request\SMS;

use CoolSMS\PHP74\Request\Request;

/**
 * Class PostCancel
 *
 * @package CoolSMS\PHP74\Request\SMS
 *
 * @property string $mid
 * @property string $gid
 */
class PostCancel extends Request
{
	/**
	 * @var array $castings
	 */
	protected array $castings = [
		'mid'   => '?string',
		'gid'   => '?string'
	];

	/**
	 * @var string $mid 메시지ID
	 */
	protected ?string $mid = null;

	/**
	 * @var string $gid 그룹ID
	 */
	protected ?string $gid = null;
}
