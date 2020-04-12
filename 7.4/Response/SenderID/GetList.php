<?php
namespace CoolSMS\PHP74\Response\SenderID;

use CoolSMS\PHP74\Response\Response;
use DateTime;

/**
 * Class GetList
 *
 * @package CoolSMS\PHP74\Response\SenderID
 *
 * @property string $idno
 * @property string $phone_number
 * @property string $flag_default
 * @property DateTime $updatetime
 * @property DateTime $regdate
 * @property DateTime $expiration
 */
class GetList extends Response
{
	/**
	 * @var array $castings
	 */
	protected array $castings = [
		'idno'          => '?string',
		'phone_number'  => '?string',
		'flag_default'  => '?string',
		'updatetime'    => '?datetime',
		'regdate'       => '?datetime',
		'expiration'    => '?datetime'
	];

	/**
	 * @var string $idno
	 */
	protected ?string $idno = null;

	/**
	 * @var string $phone_number Not Dash
	 */
	protected ?string $phone_number = null;

	/**
	 * @var string $flag_default Y / N
	 */
	protected ?string $flag_default = null;

	/**
	 * @var DateTime $updatetime 마지막 갱신일시
	 */
	protected ?DateTime $updatetime = null;

	/**
	 * @var DateTime $regdate 최초 등록일시
	 */
	protected ?DateTime $regdate = null;

	/**
	 * @var DateTime $expiration 다음 갱신일시
	 */
	protected ?DateTime $expiration = null;
}
