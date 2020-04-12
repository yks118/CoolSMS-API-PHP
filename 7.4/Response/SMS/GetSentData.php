<?php
namespace CoolSMS\PHP74\Response\SMS;

use CoolSMS\PHP74\Response\Response;
use DateTime;

/**
 * Class GetSentData
 *
 * @package CoolSMS\PHP74\Response\SMS
 *
 * @property string $type
 * @property DateTime $accepted_time
 * @property string $recipient_number
 * @property string $group_id
 * @property string $message_id
 * @property int $status
 * @property string $result_code
 * @property string $result_message
 * @property DateTime $sent_time
 * @property string $text
 * @property string $carrier
 * @property DateTime $scheduled_time
 */
class GetSentData extends Response
{
	/**
	 * @var array $castings
	 */
	protected array $castings = [
		'type'              => '?string',
		'accepted_time'     => '?datetime',
		'recipient_number'  => '?string',
		'group_id'          => '?string',
		'message_id'        => '?string',
		'status'            => '?int',
		'result_code'       => '?string',
		'result_message'    => '?string',
		'sent_time'         => '?datetime',
		'text'              => '?string',
		'carrier'           => '?string',
		'scheduled_time'    => '?datetime'
	];

	/**
	 * @var string $type
	 */
	protected ?string $type = null;

	/**
	 * @var DateTime $accepted_time
	 */
	protected ?DateTime $accepted_time = null;

	/**
	 * @var string $recipient_number
	 */
	protected ?string $recipient_number = null;

	/**
	 * @var string $group_id
	 */
	protected ?string $group_id = null;

	/**
	 * @var string $message_id
	 */
	protected ?string $message_id = null;

	/**
	 * @var int $status
	 */
	protected ?int $status = null;

	/**
	 * @var string $result_code
	 */
	protected ?string $result_code = null;

	/**
	 * @var string $result_message
	 */
	protected ?string $result_message = null;

	/**
	 * @var DateTime $sent_time
	 */
	protected ?DateTime $sent_time = null;

	/**
	 * @var string $text
	 */
	protected ?string $text = null;

	/**
	 * @var string $carrier
	 */
	protected ?string $carrier = null;

	/**
	 * @var string $scheduled_time
	 */
	protected ?string $scheduled_time = null;

	/**
	 * status
	 *
	 * status 의 상태가 무엇인지 리턴합니다.
	 *
	 * @return  string
	 */
	public function status(): string
	{
		switch ($this->status)
		{
			case 1 :
				return '대기중';
				break;
			case 2 :
				return '이통사로 전송중';
				break;
			case 3 :
				return '이통사로부터 리포트 도착';
				break;
			default :
				return '알 수 없는 상태';
				break;
		}
	}
}
