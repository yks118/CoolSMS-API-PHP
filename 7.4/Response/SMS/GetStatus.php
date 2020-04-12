<?php
namespace CoolSMS\PHP74\Response\SMS;

use CoolSMS\PHP74\Response\Response;
use DateTime;

/**
 * Class GetStatus
 *
 * @package CoolSMS\PHP74\Response\SMS
 *
 * @property DateTime $registdate
 * @property int $sms_average
 * @property int $sms_sk_average
 * @property int $sms_kt_average
 * @property int $sms_lg_average
 * @property int $mms_average
 * @property int $mms_sk_average
 * @property int $mms_kt_average
 * @property int $mms_lg_average
 * @property int $test
 */
class GetStatus extends Response
{
	/**
	 * @var array $castings
	 */
	protected array $castings = [
		'registdate'        => '?datetime',
		'sms_average'       => '?int',
		'sms_sk_average'    => '?int',
		'sms_kt_average'    => '?int',
		'sms_lg_average'    => '?int',
		'mms_average'       => '?int',
		'mms_sk_average'    => '?int',
		'mms_kt_average'    => '?int',
		'mms_lg_average'    => '?int'
	];

	/**
	 * @var DateTime $registdate
	 */
	protected ?DateTime $registdate = null;

	/**
	 * @var int $sms_average
	 */
	protected ?int $sms_average = null;

	/**
	 * @var int $sms_sk_average
	 */
	protected ?int $sms_sk_average = null;

	/**
	 * @var int $sms_kt_average
	 */
	protected ?int $sms_kt_average = null;

	/**
	 * @var int $sms_lg_average
	 */
	protected ?int $sms_lg_average = null;

	/**
	 * @var int $mms_average
	 */
	protected ?int $mms_average = null;

	/**
	 * @var int $mms_sk_average
	 */
	protected ?int $mms_sk_average = null;

	/**
	 * @var int $mms_kt_average
	 */
	protected ?int $mms_kt_average = null;

	/**
	 * @var int $mms_lg_average
	 */
	protected ?int $mms_lg_average = null;
}
